<?php

namespace MoredealAiWriter\application\shortcode;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\shortcode\manager\TplTemplateManager;

/**
 * 模板简码内容渲染
 *
 * @autor MoredealAiWriter
 */
class TemplateShortCode extends ShortCode {

    /**
     * 简码允许的属性即默认属性
     *
     * @var array
     */
    const ALLOWED_ATTRIBUTES = array(
        'title'    => '', // 标题
        'template' => '', // 模版
        'id'       => '', // 模版ID
        'style'    => '', // 样式
        'dark'     => '', // 暗色模式
    );

    /**
     * 简码
     *
     * @var string
     */
    const SHORT_CODE = 'moredeal_ai_writer_template';

    /**
     * 默认模版
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'template';

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
        return ModuleViewer::getInstance()->render_template( $content, $attributes );
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
        foreach ( $attrs as $key => $value ) {
            if ( ! array_key_exists( $key, $allowed_attributes ) ) {
                unset( $attrs[ $key ] );
            }
        }

        // 模板管理器
        $tpl_manager = TplTemplateManager::getInstance();
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
        $tpl_manager = TplTemplateManager::getInstance();
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

        // 是否配置了模版 ID
        if ( empty( $attributes['id'] ) ) {
            throw new Exception( 'Template ID is required. Please configure the template ID in the simplified code. e.g [moredeal_ai_writer_template id=1].' );
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

        // 模版ID
        $attributes['id'] = intval( trim( $attributes['id'] ) );

        if ( empty( $attributes['dark'] ) ) {
            $attributes['dark'] = false;
        } else {
            $attributes['dark'] = (bool) $attributes['dark'];
        }

        return $attributes;
    }


}