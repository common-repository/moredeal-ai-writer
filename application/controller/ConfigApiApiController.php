<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\config\GeneralConfig;
use WP_REST_Request;

/**
 * 配置控制器
 *
 * @author MoredealAiWriter
 */
class ConfigApiApiController extends AbstractApiController {

    const MODEL_NAME = "config";

    /**
     * 构造函数
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * 获取模块名称
     * @return string
     */
    public function model_name(): string {
        return self::MODEL_NAME;
    }

    /**
     * 配置路由
     * @return void
     */
    public function registerSearchRestRoute() {
        // 模版配置
        register_rest_route($this->name_space(), '/get', array(
            'methods' => 'GET',
            'callback' => array($this, 'get'),
            'permission_callback' => '__return_true',
        ));

        // 模版配置
        register_rest_route($this->name_space(), '/set', array(
            'methods' => 'POST',
            'callback' => array($this, 'set'),
            'permission_callback' => '__return_true',
        ));
    }

    /**
     * 获取配置
     * @return array
     */
    public function get(): array {
        $config = GeneralConfig::getInstance()->getConfig();
        return $this->_success($config);
    }

    /**
     * 保存配置
     * @param WP_REST_Request $request
     * @return array
     */
    public function set(WP_REST_Request $request): array {
        $sBody = $request->get_body();
        if (empty($sBody)) {
            return $this->_error('config params is empty!');
        }
        $params = json_decode($sBody);
        if (empty($params->api_key)) {
            return $this->_error('api_key is required!');
        }
        $update = GeneralConfig::getInstance()->updateConfig($params);
        if (!$update) {
            return $this->_error('config update failed!');
        }
        return $this->_successMessage('success', 'config update success!');
    }


}