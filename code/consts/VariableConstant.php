<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Variable constant
 *
 * @author MoredealAiWriter
 */
class VariableConstant extends PhpEnum {

    /**
     * Text type
     */
    const TYPE_TEXT = [ 'text' ];

    /**
     * Value
     * @var
     */
    protected $value;

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

    /**
     * Get value 获取值，即上面的常量数组的值
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

}
