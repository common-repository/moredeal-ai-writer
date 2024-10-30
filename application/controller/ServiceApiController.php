<?php

namespace MoredealAiWriter\application\controller;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use WP_REST_Request;

class ServiceApiController extends AbstractApiController {

    const MODEL_NAME = "service";

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
        // 注册服务
        register_rest_route( $this->name_space(), '/register', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'register' ),
            'permission_callback' => '__return_true',
        ) );

        // 更新服务
        register_rest_route( $this->name_space(), '/update', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'update' ),
            'permission_callback' => '__return_true',
        ) );

        // 删除服务
        register_rest_route( $this->name_space(), '/delete', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'delete' ),
            'permission_callback' => '__return_true',
        ) );

        // 服务资源类型
        register_rest_route( $this->name_space(), '/sourceType', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'sourceType' ),
            'permission_callback' => '__return_true',
        ) );

        // 服务列表
        register_rest_route( $this->name_space(), '/list', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'list' ),
            'permission_callback' => '__return_true',
        ) );
        // 服务列表
        register_rest_route( $this->name_space(), '/chat/searchList', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'chatSearchList' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * 服务注册
     *
     * @param WP_REST_Request $request
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/register
     *
     * @return array
     * @throws Exception
     */
    public function register( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The service data is required" );
        }

        $params = json_decode( $sBody, true );

        // 转换并且校验数据
        try {
            $result = SeastarRestfulClient::getInstance()->service_register( $params );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 服务注册
     *
     * @param WP_REST_Request $request
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/update
     *
     * @return array
     * @throws Exception
     */
    public function update( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The service data is required" );
        }

        $params = json_decode( $sBody, true );

        // 转换并且校验数据
        try {
            $result = SeastarRestfulClient::getInstance()->service_update( $params );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 服务注册
     *
     * @param WP_REST_Request $request
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/delete
     *
     * @return array
     * @throws Exception
     */
    public function delete( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "The service data is required" );
        }

        $params = json_decode( $sBody, true );

        try {
            $result = SeastarRestfulClient::getInstance()->service_delete( $params );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 服务资源类型
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/sourceType
     *
     * @return array
     * @throws Exception
     */
    public function sourceType(): array {

        try {
            $result = SeastarRestfulClient::getInstance()->service_source_type();
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 服务列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/list
     *
     * @return array
     * @throws Exception
     */
    public function list(): array {

        try {
            $result = SeastarRestfulClient::getInstance()->service_list();
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 服务列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/service/chat/searchList
     *
     * @return array
     * @throws Exception
     */
    public function chatSearchList(): array {

        try {
            $result = SeastarRestfulClient::getInstance()->service_chat_search_list();
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }
}