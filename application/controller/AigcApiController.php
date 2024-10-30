<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\client\AigcRestfulClient;
use MoredealAiWriter\application\client\SeastarAigcRestfulClient;
use WP_REST_Request;
use WpOrg\Requests\Exception;

/**
 * Open Api 对外提供接口
 *
 * @author MoredealAiWriter
 */
class AigcApiController extends AbstractApiController {

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
        return "aigc";
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {
        // 生成简码
        register_rest_route( $this->name_space(), '/context', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'chatWithContext' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( $this->name_space(), '/chatConfig', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'chatConfig' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( $this->name_space(), '/chatOpen', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'chatOpen' ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( $this->name_space(), '/delete/config', array(
            'methods'             => 'DELETE',
            'callback'            => array( $this, 'deleteConfig' ),
            'permission_callback' => '__return_true',
        ) );


    }

    /**
     * OpenAi 聊天
     *
     * ruL: http://127.0.0.1:8084/wp-json/aigc/v1/aigc/context
     *
     * @param WP_REST_Request $request
     *
     * @return string
     */
    public function chatWithContext(WP_REST_Request $request) {
        try {
            $result = SeastarAigcRestfulClient::getInstance()->chat_with_context(json_decode($request->get_body(),true));
            return $result;
        } catch (Exception $e) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 配置聊天窗口
     *
     * ruL: http://127.0.0.1:8084/wp-json/aigc/v1/aigc/chatConfig
     *
     * @param WP_REST_Request $request
     *
     * @return string
     */
    public function chatConfig(WP_REST_Request $request) {
        try {
            $result = SeastarAigcRestfulClient::getInstance()->chat_config(json_decode($request->get_body(),true));
            return $result;
        } catch (Exception $e) {
            return $this->_error( $e->getMessage() );
        }
    }

    /**
     * 打开一个新的聊天
     *
     * ruL: http://127.0.0.1:8084/wp-json/aigc/v1/aigc/chatOpen
     *
     * @param WP_REST_Request $request
     *
     * @return string
     */
    public function chatOpen() {
        try {
            $result = SeastarAigcRestfulClient::getInstance()->chat_open();
            return $result;
        } catch (Exception $e) {
            return $this->_error( $e->getMessage() );
        }
    }

    public function deleteConfig(WP_REST_Request $request){
        try {
            $configId   = $request->get_param( "id" );
            $result = SeastarAigcRestfulClient::getInstance()->delete_config($configId);
            return $result;
        } catch (Exception $e) {
            return $this->_error( $e->getMessage() );
        }
    }


}