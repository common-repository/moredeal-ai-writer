<?php

namespace MoredealAiWriter\code\modules\extend;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;

/**
 * Class AbstractBaseExtend
 *
 * @author MoredealAiWriter
 */
abstract class AbstractBaseExtend extends BaseModule {


    public function init() {
        // TODO: Implement init() method.
    }


    public static function factoryObject( $object ) {
        $self = static::new();

        return $self->initExtend( $object );
    }


    public abstract function initExtend( AbstractContextModule $context );

}