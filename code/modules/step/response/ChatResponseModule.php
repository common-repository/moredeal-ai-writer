<?php

namespace MoredealAiWriter\code\modules\step\response;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\ResponseStyleConstant;

/**
 * 文本响应
 *
 * @author MoredealAiWriter
 */
class ChatResponseModule extends AbstractResponseModule {


    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * @return TextResponseModule
     */
    public static function defInputResponse(): ChatResponseModule {

        $response         = ChatResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_INPUT()->getValue();
        $response->isShow = true;

        return $response;
    }

    /**
     * @return void
     */
    public static function defTextResponse() {


        $response         = ChatResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_DESC()->getValue();
        $response->isShow = true;

        return $response;
    }


}