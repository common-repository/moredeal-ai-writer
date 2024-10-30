<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\models\LogModel;
use WP_REST_Request;

/**
 * 日志控制器
 *
 * @author MoredealAiWriter
 */
class LogApiApiController extends AbstractApiController {

    protected function __construct() {
        parent::__construct();
    }

    /**
     * OpenAi 模块
     * @return string
     */
    public function model_name(): string {
        return "log";
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {
        register_rest_route( $this->name_space(), '/limitPage', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'page' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取固定的日志信息
         */
        register_rest_route( $this->name_space(), '/daysum', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'getStats' ),
            'permission_callback' => '__return_true',
        ) );


    }

    /**
     * 获取统计数据
     *
     * http://127.0.0.1:8084/wp-json/aigc/v1/log/getStats
     *
     * @throws Exception
     */
    public function getStats( WP_REST_Request $request ): array {

        $params = $request->get_params();

        return $this->_success( $this->getStatsService( $params ) );
    }

    /**
     * Get the total token usage, request count, and user count for a given time period.
     *
     * @param array $params An array containing the start_time and end_time parameters.
     *
     * @return array An array containing the total token usage, request count, and user count.
     */
    public function getStatsService( array $params ): array {

        $startTime = $params['start_time'][0] ?? date( 'Y-m-d 00:00:00' );
        $endTime   = $params['start_time'][1] ?? date( 'Y-m-d 23:59:59' );

        $where = sprintf( "`start_time` > '%s' and `start_time` < '%s'", $startTime, $endTime );

        if ( isset($params['user_id'] ) ) {
            $where .= sprintf( " and user_id = '%s'", $params['user_id'] );
        }

        $columns = [
            "IFNULL(sum(token_usage) ,0) as total_token_usage",
            "count(*) as request_count",
            "count(distinct(user_id)) as user_count"
        ];

        $params = [
            "where" => $where,
        ];

        $log = LogModel::getInstance()->findList( $params, $columns );

        return $log ? array_shift( $log ) : [];
    }


    /**
     * 查看日志列表
     *
     * http://127.0.0.1:8084/wp-json/aigc/v1/log/limitPage
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function page( WP_REST_Request $request ): array {
        $params = $request->get_params();
        if ( ! isset( $params['limit'] ) ) {
            $params['limit'] = 20;
        }
        if ( ! isset( $params['current'] ) ) {
            $params['current'] = 1;
        }

        $page = LogModel::getInstance()->page( $params );

        return $this->_success( $page );
    }
}
