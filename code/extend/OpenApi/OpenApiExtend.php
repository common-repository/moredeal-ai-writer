<?php

namespace MoredealAiWriter\code\extend\OpenApi;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\consts\EventCodeConst;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\event\BaseEventModule;
use MoredealAiWriter\code\modules\extend\AbstractBaseExtend;

/**
 * Class OpenApiExtend
 *
 * @author MoredealAiWriter
 */
class OpenApiExtend extends AbstractBaseExtend {

    public function initExtend( AbstractContextModule $context ) {

        $context->addEvent(

            BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_PRE, array( $this, "eventEVENT_TEMP_PRE" ) )

        );

    }


    public function eventEVENT_TEMP_PRE() {

        // echo "eventEVENT_TEMP_PRE";

    }

    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }


}