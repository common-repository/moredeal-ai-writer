<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\admin\UseLimitConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\models\Model;
use MoredealAiWriter\application\models\TemplateDownloadModel;
use MoredealAiWriter\application\models\TemplateModel;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\context\BaseContextModule;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPTemplateMarketSceneModule;
use MoredealAiWriter\code\modules\step\StepManager;
use MoredealAiWriter\code\modules\template\ArticleTemplateModule;
use MoredealAiWriter\code\modules\template\TemplateFactory;
use MoredealAiWriter\code\modules\template\TemplateManager;
use MoredealAiWriter\code\modules\template\TemplateModule;
use WP_REST_Request;

/**
 * Open Api 对外提供接口
 *
 * @author MoredealAiWriter
 */
class TemplateApiApiController extends AbstractApiController {

    const MODEL_NAME = "template";
    const TEMPLATE_MARKET_DEFAULT_SORT = "popular";

    /**
     * 构造函数
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * OpenAi 模块
     * @return string
     */
    public function model_name(): string {
        return self::MODEL_NAME;
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {

        /**
         * 获取token信息
         */
        register_rest_route( $this->name_space(), '/tokenInfo', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'token_info' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版配置
         */
        register_rest_route( $this->name_space(), '/config', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'config' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取topic列表
         */
        register_rest_route( $this->name_space(), '/topics', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'topics' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取tag列表
         */
        register_rest_route( $this->name_space(), '/tags', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'tags' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取场景列表
         */
        register_rest_route( $this->name_space(), '/sceneList', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'scene_list' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 获取步骤列表
         */
        register_rest_route( $this->name_space(), '/stepList', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'step_list' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版列表
         */
        register_rest_route( $this->name_space(), '/page', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'page' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版列表
         */
        register_rest_route( $this->name_space(), '/listTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'listTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 根据场景获取模版列表
         */
        register_rest_route( $this->name_space(), '/listTemplateGroupByScene', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'listTemplateGroupByScene' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版详情
         */
        register_rest_route( $this->name_space(), '/detail', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'detail' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 新增模版
         */
        register_rest_route( $this->name_space(), '/create', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'createTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 生成模板说明
         */
        register_rest_route( $this->name_space(), '/generatePromptDetails', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'promptDetails' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 提交模版
         */
        register_rest_route( $this->name_space(), '/submit', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'submitTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 复制模版
         */
        register_rest_route( $this->name_space(), '/copy', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'copyTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 修改模版
         */
        register_rest_route( $this->name_space(), '/modify', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'modifyTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 删除模版
         */
        register_rest_route( $this->name_space(), '/delete', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'deleteTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 分页获取模版列表
         */
        register_rest_route( $this->name_space(), '/pageMarketTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'pageMarketTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模板市场获取排序字段
         */
        register_rest_route( $this->name_space(), '/sorts', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'sorts' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版市场模版详情
         */
        register_rest_route( $this->name_space(), '/detailMarketTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'detailMarketTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 单页面模版详情
         */
        register_rest_route( $this->name_space(), '/singleMarketTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'singleMarketTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 模版市场操作
         */
        register_rest_route( $this->name_space(), '/actionMarketTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'actionMarketTemplate' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 校验下载模版市场模版
         */
        register_rest_route( $this->name_space(), '/checkDownloadMarketTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'checkDownload' ),
            'permission_callback' => '__return_true',
        ) );

        /**
         * 执行模版
         */
        register_rest_route( $this->name_space(), '/executeTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'executeTemplate' ),
            'permission_callback' => '__return_true',
        ) );

    }

    /**
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/token_info
     *
     * @return array
     */
    public function token_info(): array {
        $isLimitEnabled = UseLimitConfig::getInstance()->option( 'enable' );
        if ( $isLimitEnabled ) {
            $result = UseLimitApiController::getInstance()->availableToken();
            if ( ! empty( $result['data'] ) ) {
                return $this->_success( $result['data'] );
            }
        }

        $aigc_key = Plugin::plugin_key();
        $result   = SeastarRestfulClient::getInstance()->token_info( $aigc_key );
        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            if ( empty( $result['message'] ) ) {
                return $this->_error( 'Unknown error, Please contact your administrator！' );
            }

            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 获取topic
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/topics
     *
     * @return array
     */
    public function topics(): array {

        $seastarRestfulClient = new SeastarRestfulClient();
        $result               = $seastarRestfulClient->topicMap();

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['errorMessage'] ?? ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        $topic_arr = array();
        $icon_arr  = array();
        foreach ( $result['data'] as $index => $topic ) {
            $topic_arr[] = $index;
            $icon_arr[]  = $topic;
        }


        $result = [
            'topics' => $topic_arr,
            'icon'   => $icon_arr,
        ];

        return $this->_success( $result );
    }

    /**
     * 获取我的模板标签列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/tags
     *
     * @return array
     */
    public function tags(): array {

        $tags = TemplateModel::getInstance()->getTags();

        $result = [
            'tags' => $tags
        ];

        return $this->_success( $result );
    }

    /**
     * 场景列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/sceneList
     *
     * @return array
     */
    public function scene_list(): array {
        return $this->_success( SceneManager::get_scenes_info() );
    }

    /**
     * 获取步骤列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/stepList
     *
     * @return array
     */
    public function step_list(): array {
        return $this->_success( StepManager::get_step_list() );
    }

    /**
     * 分页获取模版列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/page
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function page( WP_REST_Request $request ): array {
        try {
            $default_params = TemplateModel::page_default_params();

            $sBody = $request->get_body();
            if ( empty( $sBody ) ) {
                $sBody = json_encode( $default_params );
            }

            $params = json_decode( $sBody, true );
            if ( empty( $params ) ) {
                $params = $default_params;
            }

            if ( empty( $params['limit'] ) ) {
                $params['limit'] = $default_params['limit'];
            }

            if ( empty( $params['current'] ) ) {
                $params['current'] = $default_params['current'];
            }

            $page = TemplateModel::getInstance()->page( $params );
            $page = $this->_page( $page['list'], $page['total'], $page['current'], $page['limit'] );

            return $this->_success( $page );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 根据条件获取模版列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/listTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function listTemplate( WP_REST_Request $request ): array {
        try {
            $params = array( 'is_easy_template' => false );
            $sBody  = $request->get_body();
            if ( ! empty( $sBody ) ) {
                $params = json_decode( $sBody, true );
                if ( empty( $params['is_easy_template'] ) ) {
                    $params['is_easy_template'] = false;
                }
            }

            $list = TemplateModel::getInstance()->listTemplate( $params );

            return $this->_success( $list );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 根据条件获取模版列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/listTemplateGroupByScene
     *
     * @return array
     */
    public function listTemplateGroupByScene(): array {
        try {
            // 1. 获取非 admin 和 单页面场景
            $scenes = SceneManager::get_scenes_info( true, true );

            // 2. 获取版本登记
            $level = Plugin::plugin_level();

            // 3.获取我的模版中我创建的模版
            $list = TemplateModel::getInstance()->listTemplate( array( 'is_easy_template' => true, ) );
            foreach ( $scenes as $index => $scene ) {
                // 3.1 处理默认模版
                $default_templates = array();
                if ( ! empty( $scene['defaultTemplate'] ) ) {
                    $template          = TemplateFactory::factoryByLogotype( $scene['defaultTemplate'] );
                    $default_template  = array(
                        'id'     => $template->logotype,
                        'key'    => $template->key,
                        'name'   => $template->name,
                        'desc'   => $template->desc,
                        'scenes' => SceneManager::get_scene_keys( $template->scenes ),
                    );
                    $default_templates = array( $default_template );
                    unset( $scene['defaultTemplate'] );
                }

                // 3.2 处理查询数据库模版
                $templates = array();
                foreach ( $list as $item ) {
                    if ( empty( $item->scenes ) || ! in_array( $scene['key'], $item->scenes ) ) {
                        continue;
                    }
                    $templates[] = $item;
                }

                // 3.3 合并模版信息，默认模版放在第一个
                $scene['templates'] = array_merge( $default_templates, $templates );
                $scenes[ $index ]   = $scene;
            }

            // 4. scenes 分组
            $scene_list = array();
            foreach ( $scenes as $scene ) {
                $keys                   = explode( '_', $scene['key'] );
                $group                  = $keys[0];
                $scene_list[ $group ][] = $scene;
            }

            // 4. 返回数据
            $result = array(
                'desc'       => 'listTemplateGroupByScene',
                'level'      => $level,
                'version'    => Plugin::version(),
                'upgradeUrl' => Plugin::upgrade_url(),
                'scenes'     => $scene_list,
            );

            return $this->_success( $result );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 根据 ID 获取模版详情
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/detail?tmpId=0
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function detail( WP_REST_Request $request ): array {
        try {
            $tmpId   = $request->get_param( "tmpId" );
            $tmpCode = $request->get_param( "tmpCode" );
            // 我的模版传入的是模版 ID
            if ( ! empty( $tmpId ) ) {
                $tmpId = intval( $tmpId );
                $model = TemplateModel::getInstance()->templateDetail( $tmpId );
                if ( $model == null ) {
                    return $this->_error( "The template does not exist" );
                }
                unset( $model->is_delete );

            } else if ( ! empty( $tmpCode ) ) {
                // 新版模版。
                if ( $tmpCode === TemplateModule::getModuleKey() ) {
                    if ( empty( $request->get_param( 'logotype' ) ) ) {
                        return $this->_error( 'When template key equals TemplateModule. The logotype is required!' );
                    }
                    $template_module = TemplateFactory::factoryByLogotype( $request->get_param( 'logotype' ) );
                    $model           = TemplateModel::buildByTemplate( $template_module );

                } else {
                    // 兼容旧版模版。
                    $tmp_codes = array_column( TemplateFactory::getTemplateRecommend(), 'key' );
                    if ( in_array( TemplateModule::getModuleKey(), $tmp_codes ) ) {
                        // 删除 $tmp_codes 中所有的 TemplateModule::getModuleKey()
                        $tmp_codes = array_values( array_diff( $tmp_codes, array( TemplateModule::getModuleKey() ) ) );
                    }
                    if ( in_array( $tmpCode, $tmp_codes ) ) {
                        $template_manager = TemplateManager::factoryByCode( $tmpCode );
                        $template         = $template_manager->getTemplate();
                        $model            = TemplateModel::buildByTemplate( $template );

                    } else {
                        // 已经下载的模版
                        $model = TemplateDownloadModel::getInstance()->templateDetail( $tmpCode );
                        if ( $model == null ) {
                            return $this->_error( "The template does not exist" );
                        }
                        unset( $model->id );
                        unset( $model->is_delete );
                    }
                }
            }

            $variableLabel = BaseContextModule::_getVariableLabel( $model->info );

            $model->_variableToTips = $variableLabel;

            return $this->_success( $model );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 新增模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/create
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function createTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The template data is required" );
        }

        $params = json_decode( $sBody );

        $template = TemplateModel::getInstance()->findByName( $params->name );
        if ( ! empty( $template ) ) {
            return $this->_error( "The template already exists, name: " . $params->name );
        }

        // 转换并且校验数据
        try {
            $template = TemplateModel::parseAndVerify( $sBody, Model::INSERT );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        // 插入数据
        try {
            $insert = TemplateModel::getInstance()->createTemplate( $template );

            if ( ! $insert || $insert <= 0 ) {
                return $this->_error( "The template create failed, place checked and try again!" );
            }
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        return $this->_successMessage( $insert, 'The template create success' );
    }

    /**
     * 复制模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/copy
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function copyTemplate( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The template data is required" );
        }
        // 转换并且校验数据
        try {
            $template = TemplateModel::parseAndVerify( $sBody, Model::COPY );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }
        $template->name = $template->name . ' - Copy';

        // 校验名称的重复性
        $findByName = TemplateModel::getInstance()->findByName( $template->name );
        if ( ! empty( $findByName ) ) {
            return $this->_error( "The template already exists, name: " . $template->name );
        }

        $copy = TemplateModel::getInstance()->copyTemplate( $template );
        if ( ! $copy || $copy <= 0 ) {
            return $this->_error( "The template copy failed, place checked and try again!" );
        }

        return $this->_successMessage( $copy, 'The template copy success' );
    }

    /**
     * 修改模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/modify
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function modifyTemplate( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The template data is required" );
        }
        // 转换并且校验数据
        try {
            $template = TemplateModel::parseAndVerify( $sBody, Model::MODIFY );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        // 校验名称的重复性
        $findByName = TemplateModel::getInstance()->findByName( $template->name );
        if ( ! empty( $findByName ) && $findByName['id'] != $template->id ) {
            return $this->_error( "The template already exists, name: " . $template->name );
        }

        $modify = TemplateModel::getInstance()->modifyTemplate( $template );
        if ( ! $modify || $modify <= 0 ) {
            return $this->_error( "The template modify failed, place checked and try again!" );
        }

        return $this->_successMessage( $modify, 'The template modify success' );
    }

    /**
     * 删除模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/delete
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function deleteTemplate( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The template data is required" );
        }

        $params = json_decode( $sBody, true );
        if ( ! isset( $params['tmpId'] ) ) {
            return $this->_error( "The template ID is required" );
        }

        $delete = TemplateModel::getInstance()->deleteTemplate( $params['tmpId'], false );
        if ( ! $delete || $delete <= 0 ) {
            return $this->_error( "The template delete failed, place checked and try again!" );
        }

        return $this->_successMessage( $delete, 'The template delete success' );

    }

    // 模版市场 API START -------------------------------------------------------------------------------------------------

    /**
     * 应用市场列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/pageMarketTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function pageMarketTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        // 基础数据校验
        if ( empty( $sBody ) ) {
            return $this->_error( "The get template market list query data is required" );
        }

        $params = json_decode( $sBody, true );

        // 分页数据处理
        if ( ! isset( $params['pageQuery'] ) ) {
            $params['pageQuery'] = array( 'page' => 1, 'pageSize' => 20 );
        }

        if ( ! isset( $params['pageQuery']['page'] ) ) {
            $params['pageQuery']['page'] = 1;
        }

        if ( ! isset( $params['pageQuery']['pageSize'] ) ) {
            $params['pageQuery']['pageSize'] = 20;
        }

        $params['client'] = 'php';

        // 查询数据
        $result = SeastarRestfulClient::getInstance()->pageMarketTemplate( $params );

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['message'] ?? ErrorConstant::PAGE_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        $records = $result['data'] ?? array();

        if ( ! empty( $records ) ) {

            foreach ( $records as $index => $record ) {
                unset( $record['audit'] );
                unset( $record['promptDetails'] );
                unset( $record['scenes'] );
                unset( $record['status'] );
                unset( $record['step'] );
                unset( $record['tempKey'] );
                unset( $record['tempKey'] );
                unset( $record['language'] );
                unset( $record['config'] );
                unset( $record['word'] );
                unset( $record['dislikeCount'] );
                unset( $record['downloadCount'] );

                if ( ! empty( $record['tags'] && is_array( $record['tags'] ) ) ) {
                    if ( in_array( self::TEMPLATE_MARKET_DEFAULT_SORT, $record['tags'] ) ) {
                        $record['sort'] = 0;
                    } else {
                        $record['sort'] = 1;
                    }
                } else {
                    $record['sort'] = 0;
                }

                $records[ $index ] = $record;
            }
        }

        $page = $this->_page( $records, count( $records ), 1, 1 );

        return $this->_success( $page );
    }

    /**
     * 模板市场获取排序字段
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/sorts
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function sorts( WP_REST_Request $request ): array {
        $sorts = [
            [
                "icon" => "new-box",
                "text" => "new",
                "key"  => "gmt_create"
            ],
            [
                "icon" => "emoticon",
                "text" => "popular",
                "key"  => "like"
            ],
            [
                "icon" => "trophy",
                "text" => "recommend",
                "key"  => "step"
            ]
        ];

        return $this->_success( $sorts );

    }

    /**
     * 模版市场页面-查看模板详情
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/detailMarketTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function detailMarketTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();
        if ( empty( $sBody ) ) {
            return $this->_error( "The get template market detail query data is required" );
        }

        $params = json_decode( $sBody, true );

        if ( ! isset( $params['id'] ) ) {
            return $this->_error( "The template ID is required" );
        }

        if ( ! isset( $params['templateId'] ) ) {
            return $this->_error( "The TemplateId is required" );
        }

        if ( ! isset( $params['version'] ) ) {
            return $this->_error( "The version is required" );
        }

        // 操作
        error_log( "start time:" . date( 'Y-m-d H:i:s' ) );
        $params['operate'] = 'view';

        $action_result = $this->actionTemplateService( $params );
        $action_data   = $action_result['data'];

        error_log( "action end time:" . date( 'Y-m-d H:i:s' ) );
        // 查询详情
        $result = SeastarRestfulClient::getInstance()->detailMarketTemplate( $params );

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['message'] ?? ErrorConstant::DETAIL_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        $detail_data = $result['data'];

        error_log( "detail end time:" . date( 'Y-m-d H:i:s' ) );

        unset( $detail_data['info'] );

        // check是否安装
        $check_result = $this->checkDownloadService( $params );
        $check_data   = $check_result['data'];

        error_log( "check end time:" . date( 'Y-m-d H:i:s' ) );

        $finally_result = [
            "detail" => $detail_data ?? array(),
            "action" => $action_data ?? array(),
            "check"  => $check_data ?? array()
        ];

        return $this->_success( $finally_result );
    }

    /**
     * 单页面查看模板详情
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/singleMarketTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function singleMarketTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();
        if ( empty( $sBody ) ) {
            return $this->_error( "The get template market detail query data is required" );
        }

        $params = json_decode( $sBody, true );

        if ( ! isset( $params['id'] ) ) {
            return $this->_error( "The template ID is required" );
        }

        if ( ! isset( $params['templateId'] ) ) {
            return $this->_error( "The TemplateId is required" );
        }
        $params['scene'] = WPTemplateMarketSceneModule::getModuleKey();
        // 查询详情
        $result = SeastarRestfulClient::getInstance()->detailMarketTemplate( $params );

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['message'] ?? ErrorConstant::DETAIL_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        $params['operate'] = 'view';

        $this->actionTemplateService( $params );

        return $this->_success( $result['data'] ?? array() );
    }

    /**
     * 对模板进行点赞操作
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/actionMarketTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function actionMarketTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The get template market action data data is required" );
        }

        $params = json_decode( $sBody, true );

        if ( ! isset( $params['templateId'] ) ) {
            return $this->_error( "The template ID is required" );
        }

        if ( ! isset( $params['operate'] ) ) {
            return $this->_error( "The template operate is required" );
        }

        if ( ! in_array( $params['operate'], array( 'like', 'dislike', 'view', 'download' ) ) ) {
            return $this->_error( "The template operate is invalid" );
        }

        return $this->actionTemplateService( $params );
    }

    public function actionTemplateService( $params ) {
        $license_key = LicenseConfig::license_key();
        if ( empty( $license_key ) ) {
            return $this->_error( "Please install plug-ins." );
        }

        $params['authorizationCode'] = $license_key;

        $result = SeastarRestfulClient::getInstance()->actionMarketTemplate( $params );

        if ( ! isset( $result['success'] ) || ! $result['success'] ) {
            return $this->_error( $result['message'] ?? ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 检查用户是否已经安装模版
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/checkDownload
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function checkDownload( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The check template download data is required" );
        }

        $params = json_decode( $sBody, true );

        if ( ! isset( $params['templateId'] ) ) {
            return $this->_error( "The template ID is required" );
        }

        if ( ! isset( $params['version'] ) ) {
            return $this->_error( "version is required" );
        }

        return $this->checkDownloadService( $params );

    }

    public function checkDownloadService( $params ): array {
        $template_id = $params['templateId'];

        $db_params = [
            "where" => "template_id = " . "'" . $template_id . "'"
        ];

        $columns = [
            "template_id",
            "MAX( version ) AS version "
        ];

        $template = TemplateDownloadModel::getInstance()->findOne( $db_params, $columns );

        if ( ! empty( $template ) && $template['version'] != null ) {
            $max_version = $template['version'];
            if ( $params['version'] < $max_version ) {
                $result = [
                    "status"  => 2,
                    "message" => "已安装最新版本"
                ];
            } else if ( $params['version'] == $max_version ) {
                $result = [
                    "status"  => 1,
                    "message" => "已安装"
                ];
            } else {
                $result = [
                    "status"  => 3,
                    "message" => "可升级"
                ];
            }
        } else {
            $result = [
                "status"  => 0,
                "message" => "未安装"
            ];
        }

        return $this->_success( $result );
    }


    /**
     * 获取 promptDetails
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/generatePromptDetails
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function promptDetails( WP_REST_Request $request ): array {
        $id = $request->get_param( "id" );

        if ( empty( $id ) ) {
            return $this->_error( "The id is required" );
        }

        $tmpId = intval( $id );

        try {
            $template_manager = TemplateManager::factoryById( $tmpId );

            $template_module = $template_manager->getTemplate();

            // 多步骤Generol中的参数
            $variables = $template_module->variables;
            $steps     = $template_module->steps;

            $prompt_details = $this->getPromptExample( $variables, $steps );

        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() ?? ErrorConstant::ACTION_MARKET_TEMPLATE_FAIL_MESSAGE );
        }

        return $this->_success( $prompt_details );
    }


    /**
     * 获取模板示例
     *
     * @param $variables
     * @param $steps
     *
     * @return string
     */
    public function getPromptExample( $variables, $steps ): string {

        if ( ! empty( $variables ) && sizeof( $variables ) > 0 ) {
            $generol_input = "### Generol Input:\n\n";

            foreach ( $variables as $variable ) {
                if ( $variable->field == 'temperature' || $variable->field == 'max_tokens' ) {
                    continue;
                }
                $generol_input .= $variable->label . ": " . $variable->value . "\n\n";
            }
        }

        $_prompt_value_array = [];

        if ( ! empty( $steps ) && sizeof( $steps ) > 0 ) {

            foreach ( $steps as $step ) {
                $field = $step->field;
                if ( $field == "CREATE_POST" || $field == "COPY" ) {
                    continue;
                }

                $title_bar               = "### " . $step->label . "\n\n";
                $title_input_value_array = array();

                // request value
                $step_variables = $step->variables;

                if ( ! empty( $step_variables ) ) {
                    foreach ( $step_variables as $step_variable ) {

                        // 单步骤忽略 max_tokens temperature
                        $label = $step_variable->label;
                        if ( $label == "MaxTokens" || $label == "Temperature" ) {
                            continue;
                        }

                        $input                     = $label . ": " . $step_variable->value . "\n\n";
                        $title_input_value_array[] = $input;
                    }

                    $title_input_value = str_replace( "\n", "\n\n", implode( '', $title_input_value_array ) );
                } else {
                    $title_input_value = "";
                }

                // response value
                $title_output_value = "";

                $stepModule = $step->stepModule;
                if ( ! empty( $stepModule ) ) {
                    $response = $stepModule->response;
                    if ( ! empty( $response ) ) {
                        $title_output_value = $response->value;
                    }
                }

                $_prompt_value = $title_bar;
                if ( ! empty( $title_input_value ) ) {
                    $_prompt_value .= "##### Input:\n\n" . $title_input_value;
                }
                if ( ! empty( $title_output_value ) ) {
                    $_prompt_value .= "\n\n##### Output:\n\n" . "```\n\n" . $title_output_value . "\n\n```";
                }

                $_prompt_value_array[] = $_prompt_value;

            }

        }

        $prompt_params = implode( "\n\n", $_prompt_value_array );

        $prompt_details = $generol_input . $prompt_params;

        return $prompt_details;
    }

    /**
     * 提交新模板
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/template/submitTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     * @throws Exception
     */
    public function submitTemplate( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The submit template market data is required" );
        }

        $params = json_decode( $sBody, true );

        try {
            $success = TemplateServiceModel::getInstance()->submitTemplate( $params );

            return $this->_successCode( $success["code"], $success["message"], $success["data"] );

        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

    }

    // 模版市场 API END -------------------------------------------------------------------------------------------------

    /**
     *
     * 找到模版，判断模版状态
     * 创建执行事例，
     *  执行，异常
     *  更新事例状态
     *
     * 查询事例状态数据并返回
     *
     * @param WP_REST_Request $request
     *
     * @return array
     * @throws Exception
     */
    public function executeTemplate( WP_REST_Request $request ): array {

        $tmpId      = $request->get_param( "tmpId" );
        $instanceId = $request->get_param( "instanceId" );
        $stepField  = $request->get_param( "stepField" );
        $scene      = $request->get_param( "scene" );

        $is_test = $request->get_param( "_test_test" );

        try {

            if ( $is_test ) {

                //$tmpManager = TemplateManager::factory( ImgTemplateModule::new() );

                //$tmpManager = TemplateManager::factory( TextTemplateModule::new() );

                $tmpManager = TemplateManager::factory( ArticleTemplateModule::new() );


                //$tmpManager = TemplateManager::factoryById( 1 );

            } else {

                $sBody          = $request->get_body();
                $sBody          = json_decode( $sBody );
                $templateModule = $sBody->templateModel;

                if ( empty( $templateModule ) ) {
                    return $this->_error( "The template data is required" );
                }

                $template = TemplateModel::convert( $templateModule );

                $tmpManager = TemplateManager::factory( $template->info );

            }

            //指定步骤
            $lastResponse = $tmpManager->executeDefault( $instanceId, $stepField, $scene );

            //去除无用字段

            return $this->_success( $lastResponse );

        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

    }

}

