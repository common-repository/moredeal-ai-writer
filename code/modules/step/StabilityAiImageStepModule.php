<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarAigcRestfulClient;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\ImageResponseModule;
use MoredealAiWriter\code\modules\step\response\ProcessParams;
use MoredealAiWriter\code\modules\util\LogUtil;
use MoredealAiWriter\code\modules\variable\ImageVariableModule;

class StabilityAiImageStepModule extends AbstractStepModule {

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
        $this->name         = Plugin::translation( 'Stability Ai Image' );
        $this->desc         = Plugin::translation( 'Stability Ai Image, Generate Image By Text' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = "https://platform.stability.ai/";
        $this->tags         = [ "StabilityAi", "Image" ];
        $this->isAuto       = true;
        $this->isCanAddStep = true;
        $this->icon         = Plugin::plugin_res() . "/images/stability.svg";
        $this->variables    = ImageVariableModule::defStabilityAiVariables();
        $this->response     = ImageResponseModule::defInputBase64Response();
    }

    /**
     * 执行生成图片
     *
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {
        $model_price = LogUtil::build_model_price( 'stability_ai_image' );

        $size  = $context->getStepVariable( "size" );
        $sizes = explode( "x", $size );
        if ( count( $sizes ) == 1 ) {
            $sizes[1] = $sizes[0];
        }
        if ( count( $sizes ) == 0 ) {
            $sizes[0] = 512;
            $sizes[1] = 512;
        }
        $width   = intval( $sizes[0] );
        $height  = intval( $sizes[1] );
        $prompt  = $context->getStepVariable( "prompt" );
        $request = [
            'engineId'           => self::get_engine_id( $width, $height ),
            'width'              => $width,
            'height'             => $height,
            'steps'              => $context->getStepVariable( "steps" ),
            'seed'               => $context->getStepVariable( "seed" ),
            'samples'            => $context->getStepVariable( "number" ),
            'cfgScale'           => $context->getStepVariable( "cfg_scale" ),
            'clipGuidancePreset' => $context->getStepVariable( "clip_guidance_preset" ),
            'sampler'            => $context->getStepVariable( "sampler" ),
            'stylePreset'        => $context->getStepVariable( "style_preset" ),
            'textPrompts'        => array(
                array(
                    'text'   => $prompt,
                    'weight' => 1.0
                )
            )
        ];
        $result  = null;
        try {
            error_log( "Begin: StabilityAiImageStepModule: " . $context->getStepField() . ": " . json_encode( $request ) );

            $result = SeastarAigcRestfulClient::getInstance()->generate_image_by_text( $request );

            error_log( "End StabilityAiImageStepModule: " . $context->getStepField() . ": " . json_encode( $result['success'] ) );

            if ( empty( $result ) || empty( $result['success'] ) || empty( $result['data'] ) ) {
                $this->response->error( $result['message'] );
                $this->response->setProcessParams( new ProcessParams( "StabilityAi", $request, $result, $this->response->status, $model_price ) );

                return $this->response;
            }

            $token                    = empty( $result['token'] ) ? 0 : $result['token'];
            $model_price->price       = $token;
            $model_price->total_price = $token;
            $model_price->token_usage = $token;

            $images = $result['data'];
            foreach ( $images as $index => $image ) {
                $image['name']    = uniqid( str_replace( [
                            " ",
                            ","
                        ], "_", strtolower( $prompt ) ) . "_" . $index ) . ".png";
                $images[ $index ] = $image;
            }

            $this->response->success( $images );
            $this->response->setProcessParams( new ProcessParams( "StabilityAi", $request, $result, $this->response->status, $model_price ) );

            return $this->response;
        } catch ( Exception $e ) {
            $this->response->error( $e->getMessage() );
            $this->response->setProcessParams( new ProcessParams( "StabilityAi", $request, $result, $this->response->status, $model_price ) );
            error_log( "FAIL StabilityAiImageStepModule: " . $e->getMessage() );

            return $this->response;
        }

    }

    /**
     * 获取引擎ID
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    private static function get_engine_id( int $width, int $height ): string {
        if ( $width * $height > 589824 ) {
            return 'stable-diffusion-768-v2-1';
        }

        return 'stable-diffusion-512-v2-1';
    }

}