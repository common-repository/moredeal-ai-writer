<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\WpRestfulClient;
use MoredealAiWriter\code\modules\template\TemplateManager;
use WP_REST_Request;

/**
 * WordPress api 控制器
 *
 * @author MoredealAiWriter
 */
class WordPressApiController extends AbstractApiController {

    /**
     * 模型名称
     *
     * @var string
     */
    const MODEL_NAME = 'wp';

    /**
     * 构造函数
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * 获取模型名称
     *
     * @return string
     */
    public function model_name(): string {
        return self::MODEL_NAME;
    }

    /**
     * 注册 rest 路由
     *
     * @return void
     */
    public function registerSearchRestRoute() {
        // 获取用户名
        register_rest_route( $this->name_space(), '/getUserName', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'getUserName' ),
            'permission_callback' => '__return_true',
        ) );

        // 文章列表
        register_rest_route( $this->name_space(), '/pagePost', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'pagePost' ),
            'permission_callback' => '__return_true',
        ) );

        // 文章分类列表
        register_rest_route( $this->name_space(), '/listCategories', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'listCategories' ),
            'permission_callback' => '__return_true',
        ) );

        // 上传图片
        register_rest_route( $this->name_space(), '/executeTemplate', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'executeTemplate' ),
            'permission_callback' => '__return_true',
        ) );

    }

    /**
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/wp/getUserName
     *
     * 获取用户信息
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function getUserName( WP_REST_Request $request ): array {
        // 获取当前用户
        $user     = wp_get_current_user();
        $username = '';
        foreach ( $_COOKIE as $key => $value ) {
            if ( strpos( $key, "wordpress_logged" ) !== false ) {
                $username = explode( '|', $value )[0];
            }
        }

        return $this->_success( array(
            'user_id'   => $user->ID,
            "user_name" => $user->user_login ?? $username,
        ) );

    }

    /**
     * 文章列表
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/wp/pagePost
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function pagePost( WP_REST_Request $request ): array {
        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->failure( "The post data is required", false );
        }

        $params = json_decode( $sBody, true );

        if ( empty( $params ) ) {
            $params = array();
        }
        $result = WpRestfulClient::getInstance()->page_post( $params );

        if ( ! $result ) {
            return $this->_error( "Page post failed" );
        }

        if ( empty( $result['success'] ) ) {
            return $this->_error( $result['message'] );
        }

        if ( empty( $result['data'] ) ) {
            return $this->_success( $this->_page( array(), 0, $params['paged'], $params['posts_per_page'] ) );
        }

        $data      = $result['data'];
        $data_page = $this->_page( $data['list'], $data['total'], $data['page'], $data['size'] );

        return $this->_success( $data_page );
    }

    /**
     * 获取文章分类
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/wp/listCategories
     *
     *
     * @return array
     */
    public function listCategories(): array {

        $result = WpRestfulClient::getInstance()->get_categories();
        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            return $this->_error( $result['message'] );
        }

        return $this->_success( $result['data'] );
    }

    /**
     * 执行模版步骤
     *
     * URL: http://127.0.0.1:8084/wp-json/aigc/v1/wp/executeTemplate
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function executeTemplate( WP_REST_Request $request ): array {

        $sBody = $request->get_body();

        if ( empty( $sBody ) ) {
            return $this->_error( "Got a error, The post data is required!" );
        }

        $params = json_decode( $sBody, true );
        $params["stream"] = false;
        if ( empty( $params['templateId'] ) ) {
            return $this->_error( 'Got a error, The templateId or tplKey is required!' );
        }

        if ( empty( $params['sceneKey'] ) ) {
            return $this->_error( 'Got a error, The sceneKey is required!' );
        }

        try {
            $template_id = $params['templateId'];
            // 如果是字符串且无法转为数字，表示是通过factoryByCode创建的
            if ( is_string( $template_id ) && intval( $template_id ) == 0 ) {
                $tmpManager = TemplateManager::factoryByLogotype( $template_id );
            } else {
                $tmpManager = TemplateManager::factoryById( $template_id );
            }

            $response = $tmpManager->executeScene( null, null, $params['sceneKey'], $params );

            if ( empty( $response ) ) {
                return $this->_error( "Got a error The template response is empty" );
            }

            if ( $response->status ) {
                if ( ! empty( $response->stepResponse ) && ! empty( $response->stepResponse->status ) && ! empty( $response->stepResponse->value ) ) {
                    return $this->_success( $response->stepResponse->value );
                }
            }

            return $this->_error( $response->message );
        } catch ( Exception $e ) {
            return $this->_error( $e->getMessage() );
        }

    }
}