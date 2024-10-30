<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * 响应样式枚举
 *
 * @autor MoredealAiWriter
 */
class ResponseStyleConstant extends PhpEnum {

    /**
     * input
     */
    const STYLE_INPUT = [ 'input' ];

    /**
     * text
     */
    const STYLE_TEXT = [ 'text' ];

    /**
     * img
     */
    const STYLE_IMG = [ 'img' ];

    /**
     * img
     */
    const STYLE_BASE_64 = [ 'base64' ];

    /**
     * button
     */
    const STYLE_BUTTON = [ 'button' ];

    /**
     * product
     */
    const STYLE_PRODUCT = [ 'product' ];

    protected $value;

    protected function construct( $value ) {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return ResponseStyleConstant
     */
    public function setValue( $value ): ResponseStyleConstant {
        $this->value = $value;

        return $this;
    }


}