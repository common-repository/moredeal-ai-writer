<?php

namespace MoredealAiWriter\code\modules\util;

use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\code\lib\openai\models\OpenAiChatModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\ModelPrice;
use MoredealAiWriter\code\modules\step\response\ProcessParams;

class LogUtil {

    /**
     * 构建过程参数
     *
     * @param AbstractContextModule $context 上下文
     * @param                       $request
     * @param                       $response
     * @param                       $status
     * @param ModelPrice            $modelPrice 模型价格
     *
     * @return ProcessParams
     */
    public static function build_process( AbstractContextModule $context, $request, $response, $status, ModelPrice $modelPrice ): ProcessParams {
        $process       = new ProcessParams();
        $process->mark = $context->getStepField();;
        $process->request    = $request;
        $process->response   = $response;
        $process->status     = $status;
        $process->modelPrice = $modelPrice;

        return $process;
    }

    /**
     * 构建模型价格
     *
     * @param string $model 模型名称
     * @param array  $complete 完成的参数
     *
     * @return ModelPrice
     */
    public static function build_model_price( string $model = '', array $complete = [] ): ModelPrice {

        $openAiChatModule = new OpenAiChatModule();
        $user             = wp_get_current_user();
        $user_id          = $user->ID;
        $modelPrice       = $openAiChatModule->logicPrice( $complete );

        if ( empty( $modelPrice->model ) ) {
            $modelPrice->model = $model;
        }

        $modelPrice->user_id   = $user_id;
        $modelPrice->user_name = $user->user_login;

        if ( $user_id == 0 || empty( $modelPrice->user_name ) ) {
            $modelPrice->user_type = Constant::GUESTS;
        } else {
            $modelPrice->user_type = Constant::USER;
        }

        return $modelPrice;
    }

}