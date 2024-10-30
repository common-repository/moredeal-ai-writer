<?php

namespace MoredealAiWriter\application\controller;

use Exception;
use MoredealAiWriter\application\admin\UseLimitConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\models\LogModel;
use MoredealAiWriter\application\models\Model;
use MoredealAiWriter\application\models\UseLimitModel;
use MoredealAiWriter\application\Plugin;
use WP_REST_Request;

class UseLimitApiController extends AbstractApiController {

    const MODEL_NAME = "useLimit";

    protected function __construct() {
        parent::__construct();
    }

    public function model_name(): string {
        return self::MODEL_NAME;
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {

        // 创建限制配置
        register_rest_route( $this->name_space(), '/create', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'createLimit' ),
            'permission_callback' => '__return_true',
        ) );

        // 获取限制配置详情
        register_rest_route( $this->name_space(), '/detail', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'detail' ),
            'permission_callback' => '__return_true',
        ) );

        // 修改限制配置
        register_rest_route( $this->name_space(), '/modify', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'modifyLimit' ),
            'permission_callback' => '__return_true',
        ) );

        // 删除限制配置
        register_rest_route( $this->name_space(), '/delete', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'deleteLimit' ),
            'permission_callback' => '__return_true',
        ) );

        // 获取限制配置列表
        register_rest_route( $this->name_space(), '/page', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'pageLimit' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 修改用户限制开关
         */
        register_rest_route( $this->name_space(), '/modifyOption', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'modifyOption' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取用户限制开关状态
         */
        register_rest_route( $this->name_space(), '/getOption', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'getOption' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取用户集合
         */
        register_rest_route( $this->name_space(), '/getAccounts', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'getAccounts' ),
            'permission_callback' => '__return_true',
        ) );

        // test
        register_rest_route( $this->name_space(), '/test', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'uselimitTest' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 限制条件内剩余可用token量
         */
        register_rest_route( $this->name_space(), '/availableToken', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'availableToken' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * 创建限制配置
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/create
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function createLimit( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The data is required" );
        }

        try {
            $uselimit = UseLimitModel::parseAndVerify( $sBody, Model::INSERT );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        try {

            $insert = UseLimitModel::getInstance()->createTemplate( $uselimit );

            if ( ! $insert || $insert <= 0 ) {
                return $this->_error( "The uselimit create failed, place checked and try again!" );
            }

        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        return $this->_successMessage( $insert, 'The template create success' );
    }

    /**
     * 获取限制详情
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/detail
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function detail( WP_REST_Request $request ): array {
        $id = $request->get_param( "id" );

        if ( empty( $id ) ) {
            return $this->_error( "The ID is required" );
        }

        try {
            $useLimit = UseLimitModel::getInstance()->uselimitDetail( $id );
        } catch ( Exception $e ) {
            return array();
        }

        return $this->_success( $useLimit );

    }

    /**
     * 修改用户限制
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/modify
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function modifyLimit( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The data is required" );
        }

        try {
            $uselimit = UseLimitModel::parseAndVerify( $sBody, Model::MODIFY );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        $modify = UseLimitModel::getInstance()->updateById( (array) $uselimit );
        if ( ! $modify || $modify <= 0 ) {
            return $this->_error( "The useLimit modify failed, place checked and try again!" );
        }

        return $this->_successMessage( $modify, 'The useLimit modify success' );
    }

    /**
     * 删除限制
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/delete
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function deleteLimit( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The data is required" );
        }

        $params = json_decode( $sBody, true );
        if ( ! isset( $params['id'] ) ) {
            return $this->_error( "The ID is required" );
        }

        $id = $params['id'];
        if ( $id == 1 ) {
            return $this->_error( "The default configuration cannot be deleted." );
        }

        $delete = UseLimitModel::getInstance()->deleteById( $id );

        if ( ! $delete || $delete <= 0 ) {
            return $this->_error( "The useLimit delete failed, place checked and try again!" );
        }

        return $this->_successMessage( $delete, 'The useLimit delete success' );
    }

    /**
     * 获取用户限制列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/page
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function pageLimit( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        // 基础数据校验
        if ( empty( $sBody ) ) {
            return $this->_error( "The get list query data is required" );
        }

        $params = json_decode( $sBody, true );

        try {
            $page = UseLimitModel::getInstance()->page( $params );
            $page = $this->_page( $page['list'], $page['total'], $page['current'], $page['limit'] );

            $page['available_total'] = $this->getAvailableTotalFromAuthcodeInfo();

            return $this->_success( $page );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
    }


    /**
     * 获取授权码信息
     *
     * @return array|int|mixed
     */
    public function getAvailableTotalFromAuthcodeInfo() {

        $result = SeastarRestfulClient::getInstance()->getCodeInfo( array() );
        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['errorMessage'] ?? ErrorConstant::SERVICE_GET_AUTHCODE_INFO_FAIL_MESSAGE );
        }

        $extendData = $result['data']['extendData'];
        if ( ! empty( $extendData ) ) {
            $extendData = json_decode( $extendData, true );

            return $extendData['useLimitConfigNum'] ?? 1;
        } else {
            return 1;
        }

    }

    /**
     * 修改用户限制开关
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/modifyOption
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function modifyOption( WP_REST_Request $request ): array {

        $open_uselimit = $request->get_param( "open_uselimit" );

        if ( empty( $open_uselimit ) ) {
            $open_uselimit = false;
        }

        update_option( "moredeal_aigc_uselimit", array( "enable" => $open_uselimit ) );

        if ( $open_uselimit ) {
            try {
                $i = UseLimitModel::getInstance()->count();
                if ( $i == 0 ) {
                    $model = UseLimitModel::getDefaultInstance( Constant::GUESTS );
                    UseLimitModel::getInstance()->createTemplate( $model );
                }
            } catch ( Exception $e ) {
                error_log( 'init limits data' . $e->getMessage() );
            }

        }

        return $this->_success( "update uselimit enable is success." );
    }

    /**
     * 获取用户限制开关状态
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/getOption
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function getOption( WP_REST_Request $request ): array {

        $is_limit = UseLimitConfig::getInstance()->option( 'enable' );

        return $this->_success( $is_limit );
    }


    /**
     * 获取用户集合
     *
     * @param WP_REST_Request $request
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/getAccounts
     *
     * @return array
     */
    public function getAccounts( WP_REST_Request $request ): array {

        $users = get_users();

        $data = array();
        foreach ( $users as $user ) {
            $data[] = [
                "wpUserId"   => $user->ID,
                "wpUserName" => $user->user_login
            ];

        }

        return $this->_success( $data );
    }

    /**
     *
     * 限制条件内剩余可用token量 (说明：如果创建了日期：week:1000,  day:2000 展示剩余可用token数量时，以日期最小为准，结果等于 2000-已使用数量)
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/availableToken
     *
     * @return array
     */
    public function availableToken(): array {

        $current_user = wp_get_current_user();
        $user_id      = $current_user->ID;

        if ( current_user_can( 'administrator', $user_id ) ) {
            return $this->_success( null );
        }

        if ( $user_id == 0 || ! is_user_logged_in() ) {
            $list = UseLimitModel::getInstance()->findListByScope( Constant::GUESTS );
            if ( ! session_id() ) {
                session_start();
            }
            $session_id = session_id();
        }else{
            $list = UseLimitModel::getInstance()->findUselimitData( $user_id );
        }

        if ( empty( $list ) ) {
            return $this->_success( null );
        }

        if ( sizeof( $list ) > 1 ) {
            usort( $list, function ( $useLimit1, $useLimit2 ) {
                return $useLimit1->getTimeValue() - $useLimit2->getTimeValue();
            } );
        }

        $smallestLimit = $list[0];

        // 最小日期集合
        $smallestLimits = array();
        foreach ( $list as $item ) {
            if ( $item->getTime() === $smallestLimit->getTime() ) {
                $smallestLimits[] = $item;
            }
        }

        // 获取最小的token值
        usort( $smallestLimits, function ( $a, $b ) {
            return intval( $a->getLimits() ) - intval( $b->getLimits() );
        } );

        $finallyLimit = reset( $smallestLimits );

        $startTime = UseLimitModel::getInstance()->getLimitsStartTime( $finallyLimit->time );

        $limit = $finallyLimit->getLimits();

        $user_id = $session_id ?? $user_id;

        // 从日志中获取数量
        $params = [
            'user_id'    => $user_id,
            'start_time' => [ $startTime, date( 'Y-m-d H:i:s' ) ]
        ];

        $logStats = LogApiApiController::getInstance()->getStatsService( $params );

        $total_token_usage = $logStats['total_token_usage'];

        $result = [
            'tokenUsable' => $limit - $total_token_usage,
            'expireTime'  => UseLimitModel::getInstance()->getLastTime( $finallyLimit->time ),
            'timeLeft'    => UseLimitModel::getInstance()->getLeftTime( $finallyLimit->time ),
            'level'       => Plugin::plugin_level(),
        ];

        return $this->_success( $result );
    }

    /**
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/useLimit/test
     *
     * @throws Exception
     */
    public function uselimitTest( WP_REST_Request $request ): array {

        $isLimitEnabled = UseLimitConfig::getInstance()->option( 'enable' );

        if ( $isLimitEnabled ) {
            $user_id           = get_current_user_id();
            $is_user_logged_in = is_user_logged_in();

            if ( $user_id == 0 || ! $is_user_logged_in ) {
                $list = UseLimitModel::getInstance()->findListByScope( Constant::GUESTS );
                if ( empty( $list ) ) {
                    return array( "未查询到对应的限制记录：Constant::GUESTS" );
                }

                $session_id = session_id();
                if ( empty( $session_id ) ) {
                    session_start();
                    $session_id = session_id();
                }

                $this->execLimits( $session_id, null, $list );

            } else {
                $list = UseLimitModel::getInstance()->findUselimitData( $user_id );
                if ( empty( $list ) ) {
                    return array( "未查询到对应的限制记录：Constant::USER" );
                }

                $this->execLimits( null, $user_id, $list );
            }
        }

        return array( "no Limit." );
    }

    /**
     * @param string|null $session_id
     * @param int|null $user_id
     * @param array $uselimitList
     *
     * @throws Exception
     */
    private function execLimits( ?string $session_id, ?int $user_id, array $uselimitList ): void {
        $target_id = $session_id ?? $user_id;
        if ( empty( $target_id ) ) {
            return;
        }

        foreach ( $uselimitList as $useLimit ) {
            $start_time  = UseLimitModel::getInstance()->getLimitsStartTime( $useLimit->time );
            $token_usage = LogModel::getInstance()->getTokenUsageByUserIdAndTimeRange( $target_id, $start_time, date( 'Y-m-d H:i:s' ) );

            error_log( 'Limits count: ' . $token_usage );

            if ( $token_usage >= $useLimit->limits ) {
                throw new Exception( $useLimit->tips );
            }
        }
    }


}