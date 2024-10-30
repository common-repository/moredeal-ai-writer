<?php

namespace MoredealAiWriter\application\shortcode\manager;

defined( '\ABSPATH' ) || exit;

/**
 * Aigc模版 渲染管理
 *
 * @autor MoredealAiWriter
 */
class MyTplTemplateManager extends TemplateManager {

    /**
     * @var string 模版路径
     */
    const TEMPLATE_PATH = 'my-template';

    /**
     * @var string 自定义模版路径
     */
    const CUSTOM_TEMPLATE_PATH = 'moredeal-ai-writer/my-templates';

    /**
     * @var string 模版前缀
     */
    const TEMPLATE_PREFIX = 'aigc_tpl_';

    /**
     * 获取模版路径前缀
     * @return string
     */
    public function template_prefix(): string {
        return self::TEMPLATE_PREFIX;
    }

    /**
     * 获取模版路径
     * @return string
     */
    public function template_path(): string {
        return self::TEMPLATE_PATH;
    }

    /**
     * 获取自定义模版路径
     * @return array
     */
    public function custom_template_paths(): array {
        return array(
            'child-theme' => get_stylesheet_directory() . '/' . self::CUSTOM_TEMPLATE_PATH,
            'theme'       => get_template_directory() . '/' . self::CUSTOM_TEMPLATE_PATH,
            'custom'      => WP_CONTENT_DIR . '/' . self::CUSTOM_TEMPLATE_PATH,
        );
    }

    /**
     * 获取模版列表
     *
     * @param bool $short_mode
     *
     * @return array
     */
    public function template_list( bool $short_mode = false ): array {
        $templates = parent::template_list( $short_mode );
        apply_filters( 'moredeal_aigc_templates', $templates );

        return $templates;
    }

    /**
     * 渲染模版
     *
     * @param       $view_name
     * @param array $_data
     *
     * @return string
     */
    public function render( $view_name, array $_data = array() ): string {
        return parent::render( $view_name, $_data );
    }

}
