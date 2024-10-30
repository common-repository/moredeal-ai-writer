<?php

namespace MoredealAiWriter\code\components;

defined( '\ABSPATH' ) || exit;

/**
 * 通用模型
 *
 * @autor MoredealAiWriter
 */
abstract class BaseModule {

    /**
     * 模块Code
     * @var string
     */
    public $moduleCode;

    /**
     * 构造函数
     */
    public function __construct() {
        $this->moduleCode = get_class( $this );
        $this->init();
    }

    /**
     * 获取模块 key
     * @return mixed|string|null
     */
    public static function getModuleKey() {
        $array = explode( '\\', static::class );

        return array_pop( $array );
    }

    /**
     * 新建模块
     * @return static
     */
    public static function new() {
        return new static();
    }

    /**
     * 初始化
     * @return void
     */
    abstract public function init();

    /**
     * 工厂方法,获取对象
     *
     * @param $object
     *
     * @return mixed
     */
    abstract public static function factoryObject( $object );

    /**
     * 工厂方法,获取对象
     *
     * @param $encode
     *
     * @return mixed
     */
    public static function factoryEncode( $encode ) {
        $obj = static::toDecode( $encode );

        return static::factoryObject( $obj );
    }

    /**
     * 转换为字符串
     * @return false|string
     */
    function toEncode() {
        $this->moduleCode = get_class( $this );

        return json_encode( $this, JSON_UNESCAPED_UNICODE );
    }

    /**
     * 转换为对象
     *
     * @param $str
     *
     * @return mixed
     */
    protected static function toDecode( $str ) {
        return json_decode( $str );
    }

}