<?php

namespace MoredealAiWriter\code\modules\event;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * Class AbstractEventModule
 *
 * @author MoredealAiWriter
 */
abstract class AbstractEventModule extends BaseModule {

    public $eventCode;

    /**
     * @var $_callback array
     */
    public $_callback;

    public static function factoryObject( $object ) {
        $self = static::new();

        return ModuleConvertUtil::convert( $self, $object );
    }

    public function init() {
        // TODO: Implement init() method.
    }

    /**
     * @param $eventCode
     * @param $callback
     *
     * @return AbstractEventModule
     */
    public static function newEvent( $eventCode, array $callback ) {

        $event = static::new();

        $event->eventCode = $eventCode;
        $event->_callback = $callback;

        return $event;

    }


    public function _execute( AbstractContextModule $context ) {

        call_user_func_array( $this->_callback, func_get_args() );

    }


}