<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Scene constant
 *
 * @author MoredealAiWriter
 */
class SceneConstant extends PhpEnum {

    /**
     * WP_BLOCK_LEFT
     */
    const WP_BLOCK_RIGHT = [ 'wp_block_right' ];

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

}