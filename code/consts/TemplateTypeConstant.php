<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * 模版类型
 *
 * @author Moredeal Ai Writer
 */
class TemplateTypeConstant extends PhpEnum {

    /**
     * System group
     */
    const TYPE_SYSTEM = [ 'system' ];

    /**
     * Params group
     */
    const TYPE_CUSTOM = [ 'custom' ];

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
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }
}