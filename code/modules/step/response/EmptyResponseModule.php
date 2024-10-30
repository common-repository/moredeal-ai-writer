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
class EmptyResponseModule extends AbstractResponseModule {


    /**
     * @return TextResponseModule
     */
    public static function defResponse(): EmptyResponseModule {

        $response         = EmptyResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_INPUT()->getValue();
        $response->isShow = false;

        return $response;
    }

}