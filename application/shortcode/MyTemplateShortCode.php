<?php

namespace MoredealAiWriter\application\shortcode;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\shortcode\manager\MyTplTemplateManager;

/**
 * 我的模板简码内容渲染
 *
 * @autor MoredealAiWriter
 */
class MyTemplateShortCode extends ShortCode {

    /**
     * 简码允许的属性即默认属性
     *
     * @var array
     */
    const ALLOWED_ATTRIBUTES = array(
        'title'    => '', // 标题
        'template' => '', // 模版
        'style'    => '', // 样式
        'dark'     => '', // 暗色模式
        'name'     => '', // 模版名称
        'ids'      => '', // 模版IDS
        'scenes'   => '', // 场景
        'tags'     => '', // 标签
        'topics'   => '', // 话题
        'tplUrl'   => '', // 模版地址
        'tplDark'  => '', // 模版暗色模式
    );

    /**
     * 简码
     *
     * @var string
     */
    const SHORT_CODE = 'moredeal_ai_writer_my_template';

    /**
     * 默认模版
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'my_template';

    /**
     * 简码允许的属性
     *
     * @return array
     */
    public static function allowed_attributes(): array {
        return self::ALLOWED_ATTRIBUTES;
    }

    /**
     * 构造函数
     */
    protected function __construct() {
        parent::__construct();
    }

    /**
     * 简码
     *
     * @return string
     */
    public function short_code(): string {
        return self::SHORT_CODE;
    }

    /**
     * 默认模版
     * @return string
     */
    public function default_template(): string {
        return self::DEFAULT_TEMPLATE;
    }

    /**
     * 渲染简码内容
     *
     * @param         $attrs
     * @param string  $content
     *
     * @return string
     */
    public function render_short_code( $attrs, string $content = "" ): string {
        if ( ! is_array( $attrs ) ) {
            $attrs = array();
        }

        // 1. 默认属性赋值
        $attrs = $this->default_attributes( $attrs, self::allowed_attributes() );

        // 2. 基本验证数据
        try {
            $verification = $this->verification( $attrs );
            if ( ! $verification ) {
                return $content;
            }
        } catch ( Exception $e ) {
            return $e->getMessage();
        }

        // 3. 简码属性预处理
        $attributes = $this->prepare_attributes( $attrs );

        // 4. 渲染结果
        return ModuleViewer::getInstance()->render_my_template( $content, $attributes );
    }

    /**
     * 默认属性赋值
     *
     * @param       $attrs
     * @param array $allowed_attributes
     *
     * @return mixed
     */
    private function default_attributes( $attrs, array $allowed_attributes ) {
        // 过滤掉不允许的属性
        $attrs = array_intersect_key( $attrs, array_flip( $allowed_attributes ) );

        // 模板管理器
        $tpl_manager = MyTplTemplateManager::getInstance();
        if ( empty( $attrs['template'] ) ) {
            $attrs['template'] = self::default_template();
        }
        // 获取模版全路径
        $template          = $tpl_manager->prepare_template( $attrs['template'] );
        $attrs['template'] = $template;

        return $attrs;
    }

    /**
     * 基本验证数据, 必填属性验证
     *
     * @param  $attributes
     *
     * @return bool
     * @throws Exception
     */
    public function verification( $attributes ): bool {

        // 模板管理器
        $tpl_manager = MyTplTemplateManager::getInstance();
        // 获取模版全路径
        $template = $attributes['template'];

        // 模版不存在
        if ( ! $tpl_manager->template_exists( $template ) ) {
            throw new Exception( 'Unsupported this template. Please check if the template file exists.' );
        }

        // 模版路径不存在
        if ( ! $tpl_manager->template_file_path( $template ) ) {
            return false;
        }

        return true;
    }

    /**
     * 准备简码属性
     *
     * @param  $attrs
     *
     * @return array
     */
    public function prepare_attributes( $attrs ): array {
        $shortcode = $this->short_code();
        $hook_name = $shortcode . '_shortcode_attrs';

        $default    = apply_filters( $hook_name, self::allowed_attributes() );
        $attributes = shortcode_atts( $default, $attrs, $shortcode );

        if ( empty( $attributes['dark'] ) ) {
            $attributes['dark'] = false;
        } else {
            $attributes['dark'] = (bool) $attributes['dark'];
        }

        // 模版黑暗模式
        if ( empty( $attributes['tplDark'] ) ) {
            $attributes['tplDark'] = false;
        } else {
            $attributes['tplDark'] = (bool) $attributes['tplDark'];
        }

        // 模版名称
        if ( ! empty( $attributes['name'] ) ) {
            $attributes['name'] = sanitize_text_field( trim( $attributes['name'] ) );
        } else {
            $attributes['name'] = '';
        }

        // 模版IDS
        if ( ! empty( $attributes['ids'] ) ) {
            $attributes['ids'] = explode( '|', sanitize_text_field( trim( $attributes['ids'] ) ) );
        } else {
            $attributes['ids'] = array();
        }

        // 模版场景
        if ( ! empty( $attributes['scenes'] ) ) {
            $attributes['scenes'] = explode( '|', sanitize_text_field( trim( $attributes['scenes'] ) ) );
        } else {
            $attributes['scenes'] = array();
        }

        // 模版标签
        if ( ! empty( $attributes['tags'] ) ) {
            $attributes['tags'] = explode( '|', sanitize_text_field( trim( $attributes['tags'] ) ) );
        } else {
            $attributes['tags'] = array();
        }

        // 模版话题
        if ( ! empty( $attributes['topics'] ) ) {
            $attributes['topics'] = explode( '|', sanitize_text_field( trim( $attributes['topics'] ) ) );
        } else {
            $attributes['topics'] = array();
        }

        return $attributes;
    }


}