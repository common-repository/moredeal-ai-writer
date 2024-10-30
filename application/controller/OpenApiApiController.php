<?php

namespace MoredealAiWriter\application\controller;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\openai\models\OpenAiChatModule;
use WP_REST_Request;

/**
 * Open Api 对外提供接口
 *
 * @author MoredealAiWriter
 */
class OpenApiApiController extends AbstractApiController {

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
        return "ai";
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerSearchRestRoute() {
        // 生成简码
        register_rest_route( $this->name_space(), '/chat', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'chat' ),
            'permission_callback' => '__return_true',
        ) );

    }

    /**
     * OpenAi 聊天
     *
     * ruL: http://127.0.0.1:8084/wp-json/aigc/v1/ai/chat
     *
     * @param WP_REST_Request $request
     *
     * @return string
     */
    public function chat(): array {

        $openAiChatModule           = new OpenAiChatModule();
        $openAiChatModule->messages = [
            [
                "role"    => "user",
                "content" => "哪个国家是世界上犯罪率最高的国家？"
            ]
        ];

        $opts = $openAiChatModule->convert();

        try {

            $result = $openAiChatModule->send( $opts, false, "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" );

        } catch ( \Exception $e ) {
            error_log( "...qqqqqqqq." );

            return $e;
        }

        return $result;
    }


}