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
class TextResponseModule extends AbstractResponseModule {


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
    public static function defInputResponse(): TextResponseModule {

        $response         = TextResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_INPUT()->getValue();
        $response->isShow = true;

        return $response;
    }


}