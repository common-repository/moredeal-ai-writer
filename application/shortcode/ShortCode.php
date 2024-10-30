<?php

namespace MoredealAiWriter\application\shortcode;

defined( '\ABSPATH' ) || exit;

abstract class ShortCode {

    /**
     * 实例
     *
     * @var array
     */
    private static $_instances = array();

    /**
     * ShortCode constructor.
     *
     */
    protected function __construct() {
        // 添加简码
        add_shortcode( $this->short_code(), array( $this, 'render_short_code' ) );
    }

    /**
     * 获取实例
     *
     * @return static
     */
    public static function getInstance(): ShortCode {
        $class = get_called_class();

        if ( ! isset( self::$_instances[ $class ] ) ) {
            self::$_instances[ $class ] = new $class();
        }

        return self::$_instances[ $class ];
    }

    /**
     * 初始化
     *
     * @return void
     */
    public static function init() {
        TemplateShortCode::getInstance();
        ChatbotShortCode::getInstance();
        MyTemplateShortCode::getInstance();
    }

    /**
     * 简码
     *
     * @return string
     */
    public abstract function short_code(): string;

    /**
     * 简码回调
     *
     * @param        $attrs
     * @param string $content
     *
     * @return string
     */
    public abstract function render_short_code( $attrs, string $content = "" ): string;
}