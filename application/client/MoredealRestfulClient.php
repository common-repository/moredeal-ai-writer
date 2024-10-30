<?php

namespace MoredealAiWriter\application\client;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\libs\rest\HttpRestfulClient;

/**
 * 封装基本的 rest 客户端操作
 *
 * @author MoredealAiWriter
 */
abstract class MoredealRestfulClient extends HttpRestfulClient {

    /**
     * 实例
     *
     * @var array
     */
    private static $_instances = array();

    /**
     * 构造函数
     *
     */
    public function __construct() {
        parent::__construct($this->parseUri());
        // 是否需要注册 rest 路由
    }

    /**
     * 获取实例
     * @return static
     */
    public static function getInstance(): MoredealRestfulClient {
        $class = get_called_class();

        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }

    /**
     * 请求 host
     * @return string host
     */
    public abstract function host(): string;

    /**
     * 请求 api 前缀
     * @return string api 前缀
     */
    public abstract function api_prefix(): string;

    /**
     * 解析 uri
     *
     * @return string
     */
    protected function parseUri(): string {
        $host = $this->host();
        if (str_ends_with($host, '/')) {
            $host = substr($host, 0, -1);
		}

		return $host . $this->api_prefix();
	}

}