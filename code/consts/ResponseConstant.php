<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Response constant
 *
 * @author MoredealAiWriter
 */
class ResponseConstant extends PhpEnum {

    const TYPE_TEXT = [ 'text' ];

    const TYPE_ARRAY = [ 'array' ];

    const TYPE_REDIRECT = [ 'redirect' ];

    const TYPE_COPY = [ 'copy' ];

    const TYPE_DIALOG = [ 'dialog' ];

    protected $value;

    protected function construct( $value ) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

}