<?php

namespace MoredealAiWriter\code\consts;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\lib\enum\PhpEnum;

/**
 * Group constant
 *
 * @author MoredealAiWriter
 */
class VariableGroupConstant extends PhpEnum {

    /**
     * System group
     */
    const GROUP_SYS = [ 'sys' ];

    /**
     * Params group
     */
    const GROUP_PARAMS = [ 'params' ];

    /**
     * Model group
     */
    const GROUP_MODEL = [ 'model' ];

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
