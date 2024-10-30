<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\consts\VariableStyleConstant;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * 变量模块
 *
 * @author MoredealAiWriter
 */
abstract class  AbstractVariableModule extends BaseModule {

    /**
     * 类型 key
     *
     * @var string
     */
    public $key;
    /**
     * 应用
     *
     * @var string
     */
    public $field;

    /**
     * 位子
     *
     * @var string
     */
    public $label;

    /**
     * 说明
     *
     * @var string
     */
    public $desc;

    /**
     * 类型
     *
     * @var string
     */
    public $type;

    /**
     * 选项
     * @var array
     */
    public $options = [];

    /**
     * 默认值
     *
     * @var string
     */
    public $default;

    /**
     * 值
     * @var
     */
    public $value;

    /**
     * 排序
     * @var int
     */
    public $order = 0;

    /**
     * 分组
     *
     * @var string
     */
    public $group;

    /**
     * 是否是点位
     *
     * @var bool
     */
    public $is_point;


    /**
     * 是否显示
     *
     * @var bool
     */
    public $is_show = true;

    /**
     * 样式
     *
     * @var string
     */
    public $style;

    /**
     * 初始化
     * @return void
     */
    public function init() {

        $this->key = static::getModuleKey();
        $this->initConfig();
    }

    /**
     * 初始化配置
     * @return void
     */
    protected function initConfig() {

    }

    /**
     * 获取该对象时候使用
     *
     * @param $object
     *
     * @return mixed
     */
    public static function factoryObject( $object ) {
        $self        = self::new();
        $self        = ModuleConvertUtil::convert( $self, $object );
        $self->label = Plugin::translation( $self->label ?? '' );
        $self->desc  = Plugin::translation( $self->desc ?? '' );
        if ( $self->style == VariableStyleConstant::STYLE_SELECT()->getValue() ) {
            foreach ( $self->options as $index => $option ) {
                $option                  = (array) $option;
                $option['label']         = Plugin::translation( $option['label'] ?? '' );
                $self->options[ $index ] = $option;
            }
        }

        return $self;
    }

    /**
     * 添加选项
     *
     * @param $label
     * @param $value
     *
     * @return AbstractVariableModule
     */
    public function addOption( $label, $value ): AbstractVariableModule {

        $this->options[] = [
            "label" => $label,
            "value" => $value
        ];

        return $this;
    }

    /**
     * 获取值
     * @return mixed
     */
    public function getValue() {
        return empty( $this->value ) ? $this->default : $this->value;
    }


}