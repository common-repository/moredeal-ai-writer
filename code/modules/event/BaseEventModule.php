<?php

namespace MoredealAiWriter\code\modules\event;

defined( '\ABSPATH' ) || exit;

/**
 * Class BaseEventModule
 *
 * @author MoredealAiWriter
 */
class BaseEventModule extends AbstractEventModule {


    public function init() {
        parent::init();
    }

    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }


}