<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\lib\openai\models\OpenAiImageModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\ImageResponseModule;
use MoredealAiWriter\code\modules\step\response\ProcessParams;
use MoredealAiWriter\code\modules\util\FileConvertUtil;
use MoredealAiWriter\code\modules\variable\ImageVariableModule;

/**
 * Class OpenApiImageStepModule
 *
 * @author MoredealAiWriter
 */
class  OpenApiImageStepModule extends AbstractStepModule {

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
        $this->name         = Plugin::translation( 'OpenAPI Image' );
        $this->desc         = Plugin::translation( 'You can enter a prompt to generate the image you desire.' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = "";
        $this->tags         = array( 'OpenAIImage' );
        $this->icon         = Plugin::plugin_res() . "/images/openai.svg";
        $this->isAuto       = true;
        $this->isCanAddStep = true;
        $this->variables    = array(
            ImageVariableModule::defSizeVariables(),
            ImageVariableModule::defNumberVariables(),
            ImageVariableModule::defPromptVariables()
        );
        $this->response     = ImageResponseModule::defInputResponse();
    }

    /**
     * 执行生成图片
     *
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {

        $open_ai_key = $context->getOpenAiKey();

        $openAiImageModule = new OpenAiImageModule();

        $user    = wp_get_current_user();
        $user_id = $user->ID;

        $opts = [
            "prompt" => $context->getStepVariable( "prompt" ),
            'n'      => $context->getStepVariable( "number" ),
            'size'   => $context->getStepVariable( "size" ),
        ];

        $opts = $openAiImageModule->convert( $opts );

        // 价格计算
        $modelPrice            = $openAiImageModule->logicPrice( $opts );
        $modelPrice->user_id   = $user_id;
        $modelPrice->user_name = $user->user_login;
        if ( $user_id == 0 || empty( $modelPrice->user_name ) ) {
            $modelPrice->user_type = Constant::GUESTS;
        } else {
            $modelPrice->user_type = Constant::USER;
        }

        $complete = null;

        try {
            error_log( "OpenApiImageStepModule_send start: " . $context->getStepField() . ": " . json_encode( $opts ) );

            $complete = $openAiImageModule->send( $opts, false, $open_ai_key );

            error_log( "OpenApiImageStepModule_send end: " . $context->getStepField() . ": " . json_encode( $complete ) );

            if ( empty( $complete ) || array_key_exists( "success", $complete ) ) {

                if ( ! $complete['success'] ) {
                    $this->response->error( $complete['message'] );
                }

            } else {

                $files = FileConvertUtil::encode( $complete["data"] );

                foreach ( $files as $index => $file ) {
                    $file->fileName = str_replace( [ " ", "," ], "_", strtolower( $opts['prompt'] ) ) . "_" . $index;
                }
                $this->response->success( $files );
            }

        } catch ( Exception $e ) {

            $this->response->error( $e->getMessage() );

            throw new Exception( 'openAiChatModule_send is fail:' . $e->getMessage() );
        }

        $this->response->setProcessParams( new ProcessParams( "openApi", $opts, $complete, $this->response->status, $modelPrice ) );

        return $this->response;

    }


}