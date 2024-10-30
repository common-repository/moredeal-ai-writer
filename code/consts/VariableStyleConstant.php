<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Style constant
 *
 * @author MoredealAiWriter
 */
class VariableStyleConstant extends PhpEnum {

    /**
     * Input type
     */
    const STYLE_INPUT = [ 'input' ];

    /**
     * Text type
     */
    const STYLE_TEXT = [ 'text' ];

    /**
     * Select type
     */
    const STYLE_SELECT = [ 'select' ];

    /**
     * Value
     * @var
     */
    protected $value;

    /**
     * Get value 获取值，即上面的常量数组的值
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * 构造函数
     *
     * @param $value
     *
     * @return void
     */
    protected function construct( $value ) {
        $this->value = $value;
    }


}