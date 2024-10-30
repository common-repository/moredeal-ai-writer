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
class RedirectResponseModule extends AbstractResponseModule {

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
     * @return RedirectResponseModule
     */
    public static function defResponse(): RedirectResponseModule {
        $response         = RedirectResponseModule::new();
        $response->style  = ResponseStyleConstant::STYLE_BUTTON()->getValue();
        $response->type   = ResponseConstant::TYPE_REDIRECT()->getValue();
        $response->isShow = true;

        return $response;
    }

    /**
     * Redirect Response
     *
     * @return RedirectResponseModule
     */
    public static function defArrayResponse(): RedirectResponseModule {
        $response         = RedirectResponseModule::new();
        $response->style  = ResponseStyleConstant::STYLE_BUTTON()->getValue();
        $response->type   = ResponseConstant::TYPE_ARRAY()->getValue();
        $response->isShow = true;

        return $response;
    }

}