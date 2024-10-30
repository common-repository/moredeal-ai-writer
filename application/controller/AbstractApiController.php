<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

/**
 * 抽象控制器
 *
 * @author MoredealAiWriter
 */
abstract class AbstractApiController {

    /**
     * 路由注册的基本 NAME_SPACE
     */
    const BASE_NAME_SPACE = "aigc/v1";

    /**
     * 实例
     *
     * @var array
     */
    private static $_instances = array();

    /**
     * 构造函数
     */
    protected function __construct() {
        add_action( 'rest_api_init', array( $this, 'registerSearchRestRoute' ) );
    }

    /**
     * 注册路由
     * @return void
     */
    public abstract function registerSearchRestRoute();

    /**
     * 模块路径
     * @return string
     */
    public abstract function model_name(): string;

    /**
     * 获取实例
     * @return static
     */
    public static function getInstance(): AbstractApiController {
        $class = get_called_class();

        if ( ! isset( self::$_instances[ $class ] ) ) {
            self::$_instances[ $class ] = new $class();
        }

        return self::$_instances[ $class ];
    }

    /**
     * 初始化
     *
     * @return void
     */
    public static function init() {
        OpenApiApiController::getInstance();
        TemplateApiApiController::getInstance();
        LogApiApiController::getInstance();
        ConfigApiApiController::getInstance();
        WordPressApiController::getInstance();
        TemplateDownloadApiController::getInstance();
        UseLimitApiController::getInstance();
        ServiceApiController::getInstance();
        AigcApiController::getInstance();
    }

    /**
     * 获取 name_space
     * @return string
     */
    protected function name_space(): string {
        $model_name = $this->model_name();
        if ( empty( $model_name ) ) {
            return self::BASE_NAME_SPACE;
        }
        if ( str_starts_with( $model_name, '/' ) ) {
            return self::BASE_NAME_SPACE . $model_name;
        }

        return self::BASE_NAME_SPACE . '/' . $model_name;
    }

    /**
     * 分页
     *
     * @param $list array 数据
     * @param $total int 总数
     * @param $current int 当前页
     * @param $limit int 每页数量
     *
     * @return array
     */
    protected function _page( array $list, int $total = 0, int $current = 1, int $limit = 20 ): array {

        return [
            'list' => $list,
            'page' => [
                'total'   => $total,
                'current' => $current,
                'limit'   => $limit
            ]
        ];
    }

    /**
     * 成功返回
     *
     * @param $data
     *
     * @return array
     */
    protected function _success( $data ): array {

        return [
            "status" => true,
            "data"   => $data
        ];
    }

    /**
     * 成功返回
     *
     * @param $data
     * @param $message
     *
     * @return array
     */
    protected function _successMessage( $data, $message ): array {

        return [
            "status"  => true,
            "data"    => $data,
            "message" => $message,
        ];
    }

    /**
     * 成功返回
     *
     * @param $code
     * @param $data
     * @param $message
     *
     * @return array
     */
    protected function _successCode( $code, $data, $message ): array {
        return [
            "status"  => true,
            "code"    => $code,
            "data"    => $data,
            "message" => $message,
        ];
    }

    /**
     * 失败返回
     *
     * @param $error
     *
     * @return array
     */
    protected function _error( $error ): array {

        return [
            "status" => false,
            "error"  => $error
        ];
    }

    /**
     * 失败返回
     *
     * @param string $message
     * @param null   $data
     *
     * @return array
     */
    protected function failure( string $message = "", $data = null ): array {

        return [
            "status"  => false,
            "message" => $message,
            "data"    => $data,
        ];
    }

}
