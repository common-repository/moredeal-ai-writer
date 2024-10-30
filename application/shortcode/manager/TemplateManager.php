<?php

namespace MoredealAiWriter\application\shortcode\manager;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\helpers\TextHelper;
use MoredealAiWriter\application\Plugin;

abstract class TemplateManager {

    /**
     * 实例
     *
     * @var array
     */
    private static $_instances = array();

    /**
     * 需要渲染的页面
     *
     * @var array|null 模版包名称
     */
    private $templates = null;

    /**
     * 最后一次渲染的数据
     *
     * @var array
     */
    private $last_render_data = array();

    /**
     * 获取模版路径前缀
     *
     * @return string
     */
    public abstract function template_prefix(): string;

    /**
     * 模版路径. 最前面不要加斜杠
     *
     * @return string
     */
    public abstract function template_path(): string;

    /**
     * 获取模版路径
     *
     * @return string
     */
    public function template_path_finally(): string {
        return Plugin::plugin_path() . 'application/templates/' . $this->template_path();
    }

    /**
     * 自定义模版路径
     *
     * @return array
     */
    public abstract function custom_template_paths(): array;

    /**
     * 获取实例
     *
     * @return static
     */
    public static function getInstance(): TemplateManager {
        $class = get_called_class();

        if ( ! isset( self::$_instances[ $class ] ) ) {
            self::$_instances[ $class ] = new $class();
        }

        return self::$_instances[ $class ];
    }

    /**
     * 渲染
     *
     * @param       $view_name
     * @param array $_data
     *
     * @return false|string
     */
    public function render( $view_name, array $_data = array() ) {
        $file = $this->template_file_path( $view_name );

        if ( ! $file ) {
            return '';
        }

        $this->last_render_data = $_data;
        extract( $_data, EXTR_PREFIX_SAME, 'data' );
        ob_start();
        ob_implicit_flush( false );
        include $file;

        return ob_get_clean();
    }

    /**
     * 根据完整文件路径名称渲染
     *
     * @param       $view_path
     * @param array $_data
     *
     * @return string
     * @throws Exception
     */
    protected function render_by_path( $view_path, array $_data = array() ): string {

        if ( ! is_file( $view_path ) || ! is_readable( $view_path ) ) {
            throw new Exception( 'View file "' . $view_path . '" does not exist.' );
        }

        $_data = array_merge( $this->last_render_data, $_data );
        extract( $_data, EXTR_PREFIX_SAME, 'data' );
        ob_start();
        ob_implicit_flush( false );
        include $view_path;

        return ob_get_clean();
    }

    /**
     * 获取模版集合
     *
     * @param bool $short_mode
     *
     * @return array|string|null
     */
    public function template_list( bool $short_mode = false ) {
        $prefix = $this->template_prefix();
        if ( $this->templates === null ) {
            // 内部模版
            $base_path = $this->template_path_finally();
            $templates = $this->scan_template_list( $base_path, $prefix );

            // 自定义模版
            $custom_paths = $this->custom_template_paths();
            foreach ( $custom_paths as $custom_name => $custom_path ) {
                $custom_list = $this->scan_template_list( $custom_path, $prefix, $custom_name );
                $templates   = array_merge( $templates, $custom_list );
            }

            $this->templates = $templates;
        }

        // 简化模版列表
        if ( $short_mode ) {
            $list = array();
            foreach ( $this->templates as $id => $name ) {
                $custom = '';
                if ( self::is_custom_template( $id ) ) {
                    $parts  = explode( '/', $id );
                    $custom = 'custom/';
                    $id     = $parts[1];
                }
                // 去掉前缀
                $list[ $custom . substr( $id, strlen( $prefix ) ) ] = $name;
            }

            return $list;
        }

        return $this->templates;
    }

    /**
     * 扫描模版
     *
     * @param string $path
     * @param string $prefix
     * @param bool   $custom_name
     *
     * @return array
     */
    private function scan_template_list( string $path, string $prefix, bool $custom_name = false ): array {

        if ( $custom_name && ! is_dir( $path ) ) {
            return array();
        }

        $template_files = glob( $path . '/' . $prefix . '*.php' );
        if ( ! $template_files ) {
            return array();
        }

        $templates = array();
        foreach ( $template_files as $file ) {
            $template_id = basename( $file, '.php' );
            if ( $custom_name ) {
                $template_id = 'custom/' . $template_id;
            }

            $data = get_file_data( $file, array( 'name' => 'Name' ) );
            if ( $data && ! empty( $data['name'] ) ) {
                $templates[ $template_id ] = sanitize_text_field( $data['name'] );
            } else {
                $templates[ $template_id ] = $template_id;
            }

            if ( $custom_name ) {
                $templates[ $template_id ] .= ' [' . esc_attr( __( $custom_name, 'moredeal' ) ) . ']';
            }

        }

        return $templates;
    }

    /**
     * 获取模版路径
     *
     * @param $view_name
     *
     * @return false|string
     */
    public function template_file_path( $view_name ) {
        $view_name = str_replace( '.', '', $view_name );
        if ( self::is_custom_template( $view_name ) ) {

            $view_name = substr( $view_name, 7 );
            foreach ( $this->custom_template_paths() as $custom_prefix => $custom_dir ) {
                $tpl_path = $custom_dir;
                $file     = $tpl_path . DIRECTORY_SEPARATOR . TextHelper::clear( $view_name ) . '.php';
                if ( is_file( $file ) && is_readable( $file ) ) {
                    return $file;
                }
            }

        } else {
            $tpl_path = $this->template_path_finally();
            $file     = $tpl_path . DIRECTORY_SEPARATOR . TextHelper::clear( $view_name ) . '.php';
            if ( is_file( $file ) && is_readable( $file ) ) {
                return $file;
            }

        }

        return false;
    }

    /**
     * 获取完整的模版key
     *
     * @param $short_template
     *
     * @return string
     */
    public function full_template_key( $short_template ): string {
        $prefix = $this->template_prefix();
        $custom = '';
        if ( self::is_custom_template( $short_template ) ) {
            $parts  = explode( '/', $short_template );
            $custom = 'custom/';
            $id     = $parts[1];
        } else {
            $id = $short_template;
        }

        // check _data prefix
        if ( substr( $id, 0, strlen( $prefix ) ) != $prefix ) {
            $id = $prefix . $id;
        }

        return $custom . $id;
    }

    /**
     * 是否是自定义模版
     *
     * @param $template_id
     *
     * @return bool
     */
    public static function is_custom_template( $template_id ): bool {
        if ( substr( $template_id, 0, 7 ) == 'custom/' ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 模版是否存在
     *
     * @param $template
     *
     * @return bool
     */
    public function template_exists( $template ): bool {
        $templates_list = $this->template_list();

        return array_key_exists( $template, $templates_list );
    }

    /**
     * 获取模版目录
     *
     * @param $template
     *
     * @return string
     */
    public function prepare_template( $template ): string {

        if ( ! $template ) {
            return '';
        }

        if ( self::is_custom_template( $template ) ) {
            $is_custom = true;
            // 删除 custom_ 前缀
            $template = substr( $template, 7 );
        } else {
            $is_custom = false;
        }

        $template = TextHelper::clear( $template );
        if ( $is_custom ) {
            $template = 'custom/' . $template;
        } else {
            $template = $this->full_template_key( $template );
        }

        return $template;
    }


}