<?php

namespace MoredealAiWriter\code\modules\step\response;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\ResponseStyleConstant;

/**
 * Class ImageResponseModule
 *
 * @author MoredealAiWriter
 */
class ImageResponseModule extends AbstractResponseModule {

    /**
     * URL of the image
     * @return ImageResponseModule
     */
    public static function defInputResponse(): ImageResponseModule {

        $response         = ImageResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_IMG()->getValue();
        $response->isShow = true;

        return $response;
    }

    /**
     * Base 64 of the image
     * @return ImageResponseModule
     */
    public static function defInputBase64Response(): ImageResponseModule {

        $response         = ImageResponseModule::new();
        $response->type   = ResponseConstant::TYPE_TEXT()->getValue();
        $response->style  = ResponseStyleConstant::STYLE_BASE_64()->getValue();
        $response->isShow = true;

        return $response;
    }


    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }


    public function getValue() {
        return json_encode( $this->value );
    }


}