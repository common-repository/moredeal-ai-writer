<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * 事件枚举
 *
 * @autor MoredealAiWriter
 */
class EventCodeConst extends PhpEnum {

    /**
     * EVENT_TEMP_PRE
     */
    const EVENT_TEMP_PRE = [ "EVENT_TEMP_PRE" ];

    /**
     * EVENT_TEMP_POST
     */
    const EVENT_TEMP_POST = [ "EVENT_TEMP_POST" ];

    /**
     * EVENT_STEP_PRE
     */
    const EVENT_STEP_PRE = [ "EVENT_STEP_PRE" ];

    /**
     * EVENT_STEP_POST
     */
    const EVENT_STEP_POST = [ "EVENT_STEP_POST" ];

    /**
     * value
     * @var mixed
     */
    protected $value;

    /**
     * construct
     *
     * @param $value
     *
     * @return void
     */
    protected function construct( $value ) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

}