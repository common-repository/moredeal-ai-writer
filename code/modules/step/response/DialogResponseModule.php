<?php

namespace MoredealAiWriter\code\modules\step\response;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\ResponseStyleConstant;

/**
 * 重定向响应
 *
 * @author MoredealAiWriter
 */
class DialogResponseModule extends AbstractResponseModule {


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
     * 默认响应
     *
     * @return DialogResponseModule
     */
    public static function defResponse(): DialogResponseModule {

        $response        = DialogResponseModule::new();
        $response->style = ResponseStyleConstant::STYLE_BUTTON()->getValue();
        $response->type  = ResponseConstant::TYPE_DIALOG()->getValue();

        $response->isShow = true;

        return $response;
    }


}