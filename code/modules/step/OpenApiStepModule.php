<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\lib\openai\models\OpenAiChatModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\ProcessParams;
use MoredealAiWriter\code\modules\step\response\TextResponseModule;
use MoredealAiWriter\code\modules\util\OpenAiUtil;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

/**
 * Open API 执行步骤
 *
 * @author MoredealAiWriter
 */
class  OpenApiStepModule extends AbstractStepModule {

    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {
        $this->name         = Plugin::translation( 'Open API' );
        $this->desc         = Plugin::translation( 'Open API Chat' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = 'https://platform.openai.com/docs/api-reference/completions/create';
        $this->tags         = [ Plugin::translation( 'OpenAI' ), Plugin::translation( 'Completions' ) ];
        $this->isAuto       = true;
        $this->isCanAddStep = true;
        $this->icon         = Plugin::plugin_res() . "/images/openai.svg";
        $this->variables    = [
            TextVariableModule::defMaxTokensVariables(),
            TextVariableModule::defModelTemperatureVariables(),
            TextVariableModule::defNVariables(),
            TextVariableModule::defPromptVariables()
        ];
        $this->response     = TextResponseModule::defInputResponse();
    }


    /**
     * 执行步骤
     *
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {

        return $this->executeChat( $context );
    }

    /**
     * 执行步骤
     *
     * @throws Exception
     */
    public function executeChat( AbstractContextModule $context ): AbstractResponseModule {
        $open_ai_key = $context->getOpenAiKey();

        $openAiChatModule = new OpenAiChatModule();

        $stream = true;
        if ($context->get_isstream() === "false") {
            $stream = false;
        }

        $user    = wp_get_current_user();
        $user_id = $user->ID;

        $opts = [
            "messages"    => [
                [
                    "role"    => "user",
                    "content" => $context->getStepVariable( "prompt" ),
                ]
            ],
            "n"           => $context->getStepVariable( "n" ),
            "temperature" => $context->getStepVariable( "temperature" ),
            "max_tokens"  => $context->getStepVariable( "max_tokens" ),
            "user"        => $user_id,
            "chatId"      => $context->getStepVariable( "chatId" ),
            "stream"      => $context->getStepVariable( "stream" ) ?? $stream
        ];

        $opts = $openAiChatModule->convert( $opts );

        try {

            error_log( "openAiChatModule_send start: " . $context->getStepField() . ": " . json_encode( $opts ) );

            $complete = $openAiChatModule->send( $opts, false, $open_ai_key );

            error_log( "openAiChatModule_send end: " . $context->getStepField() . ": " . json_encode( $complete ) );

            $modelPrice            = $openAiChatModule->logicPrice( $complete );
            $modelPrice->user_id   = $user_id;
            $modelPrice->user_name = $user->user_login;

            if ( $user_id == 0 || empty( $modelPrice->user_name ) ) {
                $modelPrice->user_type = Constant::GUESTS;
            } else {
                $modelPrice->user_type = Constant::USER;
            }

            $result = OpenAiUtil::build_choice_result( $complete, $opts['n'] );
            $this->response->success( $result );

            if ( $opts['n'] >= 1 ) {
                $this->response->type = ResponseConstant::TYPE_ARRAY()->getValue();
            }

        } catch ( Exception $e ) {

            $this->response->error( $e->getMessage() );

            throw new Exception( 'openAiChatModule_send is fail:' . $e->getMessage() );
        }

        $this->response->setProcessParams( new ProcessParams( "openApi", $opts, $complete, $this->response->status, $modelPrice ) );

        return $this->response;

    }


}