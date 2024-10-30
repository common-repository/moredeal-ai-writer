<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\components\AccountManager;
use MoredealAiWriter\application\components\LicenseManager;
use MoredealAiWriter\application\components\TokenManager;
use MoredealAiWriter\application\consts\ResConstant;
use MoredealAiWriter\application\helpers\TextHelper;
use MoredealAiWriter\application\notice\ReviewNotice;
use MoredealAiWriter\application\Plugin;
use const MoredealAiWriter\PLUGIN_RES;

/**
 * wp-admin 管理界面插件类
 *
 * @author MoredealAiWriter
 */
class AdminPlugin {

    /**
     * 实例
     * @var AdminPlugin|null
     */
    private static $instance = null;

    /**
     * PluginAdmin 实例
     *
     * @return AdminPlugin
     */
    public static function getInstance(): AdminPlugin {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 构造函数
     */
    private function __construct() {
        // 确定当前请求是否针对管理界面页。
        if ( ! is_admin() ) {
            die( Plugin::translation( 'You are not authorized to perform the requested action.' ) );
        }
        // 添加 action
        $this->add_moredeal_aigc_actions();
        // 添加 filter
        $this->add_moredeal_aigc_filters();
        // review notice
        ReviewNotice::getInstance()->admin_init();
        // 全局 key 获取
        AccountManager::getInstance()->admin_init();
        // Aigc meta box
        // AigcMetaBox::getInstance();
        // General 配置
        GeneralConfig::getInstance()->admin_init();
        // Use Limit 配置
        UseLimitConfig::getInstance()->admin_init();
        // Service 配置
        ServiceConfig::getInstance()->admin_init();
        // Token 配置
        TokenConfig::getInstance()->admin_init();
        // License 配置
        LicenseConfig::getInstance()->admin_init();
        // Debug 配置, 正式发布的时候需要注释掉这个
        // DebugConfig::getInstance()->admin_init();
        // Token 管理通知
        TokenManager::getInstance()->admin_init();
        // License 管理通知
        LicenseManager::getInstance()->admin_init();
        if ( ! Plugin::is_free() ) {
            // 自动更新
            \MoredealAiWriter\application\AutoUpdate::admin_init();
        }
    }

    /**
     * 添加 action
     *
     * @return void
     */
    public function add_moredeal_aigc_actions() {
        add_action( 'admin_enqueue_scripts', array( $this, 'add_moredeal_aigc_admin_load_scripts' ) );
        if ( ! empty( GeneralConfig::enable_gutenberg_block_editor() ) ) {
            add_action( 'enqueue_block_editor_assets', array( $this, 'moredeal_ai_writer_enqueue_block_scripts' ) );
        }
        add_action( 'admin_menu', array( $this, 'add_moredeal_aigc_admin_menu' ) );
    }

    /**
     * 添加 filter
     *
     * @return void
     */
    public function add_moredeal_aigc_filters() {
        if ( isset( $GLOBALS['pagenow'] ) && $GLOBALS['pagenow'] == 'plugins.php' ) {
            add_filter( 'plugin_row_meta', array( $this, 'add_moredeal_aigc_plugin_row_meta' ), 10, 2 );
        }
    }

    /**
     * 加载 admin 通用脚本
     *
     * @return void
     */
    public static function load_moredeal_aigc_admin_scripts() {
        self::load_moredeal_aigc_sleek_script();
        wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_style( 'moredeal_ai_writer_admin_ui_style', ResConstant::MOREDEAL_AI_WRITER_ADMIN_UI_STYLE, false, Plugin::script_version() );
        wp_enqueue_style( 'moredeal_ai_writer_setting_style', ResConstant::MOREDEAL_AI_WRITER_SETTING_STYLE, Plugin::script_version() );
    }

    /**
     * 加载通用脚本
     * @return void
     */
    public function add_moredeal_aigc_admin_load_scripts() {
        // 只在插件设置页面加载
        if ( $GLOBALS['pagenow'] != 'admin.php' || empty( $_GET['page'] ) || sanitize_key( wp_unslash( $_GET['page'] ) ) != strtolower( Plugin::slug() ) ) {
            return;
        }

        // 样式文件
        self::load_moredeal_aigc_commons_styles();
        wp_register_style( 'moredeal_aigc_index_style', ResConstant::MOREDEAL_AIGC_INDEX_STYLE, array( 'moredeal_aigc_vendor_style' ), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_aigc_index_style' );

        // 脚本文件
        self::load_moredeal_aigc_commons_scripts();
        wp_register_script( 'moredeal_aigc_index_script', ResConstant::MOREDEAL_AIGC_INDEX_SCRIPT, array( 'moredeal_aigc_vendor_script' ), Plugin::script_version(), true );
        wp_localize_script( 'moredeal_aigc_index_script', 'MOREDEAL_AIGC', self::get_moredeal_aigc_store() );
        wp_enqueue_script( 'moredeal_aigc_index_script' );


    }

    /**
     * 通用 Moredeal AI Writer 样式
     * @return void
     */
    public static function load_moredeal_aigc_commons_styles( string $vendor = ResConstant::MOREDEAL_AIGC_VENDOR_STYLE ) {
        wp_register_style( 'moredeal_aigc_vendor_style', $vendor, array(), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_aigc_vendor_style' );
    }

    /**
     * 通用 Moredeal AI Writer 脚本
     *
     * @param string $vendor
     *
     * @return void
     */
    public static function load_moredeal_aigc_commons_scripts( string $vendor = ResConstant::MOREDEAL_AIGC_VENDOR_SCRIPT ) {
        self::load_moredeal_aigc_sleek_script();
        // vendor 脚本
        wp_register_script( 'moredeal_aigc_vendor_script', $vendor, array(), Plugin::script_version(), true );
        wp_enqueue_script( 'moredeal_aigc_vendor_script' );
    }

    /**
     * 加载 sleek 脚本
     *
     * @return void
     */
    public static function load_moredeal_aigc_sleek_script() {
        // sleek 脚本
        wp_register_script( 'moredeal_ai_writer_sleek_script', ResConstant::MOREDEAL_AIGC_SLEEK_SCRIPT, array(), Plugin::script_version() );
        wp_enqueue_script( 'moredeal_ai_writer_sleek_script' );
    }

    /**
     * 定义需要传输给前端的数据
     *
     * @return array
     */
    public static function get_moredeal_aigc_store(): array {
        return array(
            'level'         => Plugin::plugin_level(),
            'wpRestUrl'     => rest_url(),
            'wpRestNonce'   => wp_create_nonce( 'wp_rest' ),
            'imagesPath'    => Plugin::plugin_res() . '/images/',
            'chatPath'      => Plugin::plugin_chat(),
            'lang'          => get_locale(),
            'localeMessage' => array(),
        );
    }

    /**
     * 添加插件块编辑器脚本
     *
     * @return void
     */
    public static function moredeal_ai_writer_enqueue_block_scripts() {
        // 样式文件
        wp_register_style( 'moredeal_ai_writer_wp_block_gutenberg_style', ResConstant::MOREDEAL_AIGC_BLOCK_STYLE_INDEX_STYLE, array(), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_ai_writer_wp_block_gutenberg_style' );
        wp_register_style( 'moredeal_ai_writer_wp_block_gutenberg_index_style', ResConstant::MOREDEAL_AIGC_BLOCK_INDEX_STYLE, array( 'moredeal_ai_writer_wp_block_gutenberg_style' ), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_ai_writer_wp_block_gutenberg_index_style' );

        // 脚本文件
        wp_register_script( 'moredeal_ai_writer_wp_block_gutenberg_index_script', ResConstant::MOREDEAL_AIGC_BLOCK_INDEX_SCRIPT, array(), Plugin::script_version() );
        wp_localize_script( 'moredeal_ai_writer_wp_block_gutenberg_index_script', 'MOREDEAL_AIGC_GUTENBERG_SETTING', array(
            'level'       => Plugin::plugin_level(),
            'wpRestUrl'   => rest_url(),
            'wpRestNonce' => wp_create_nonce( 'wp_rest' ),
            'lang'        => get_locale()
        ) );
        wp_enqueue_script( 'moredeal_ai_writer_wp_block_gutenberg_index_script' );
    }

    /**
     * 添加菜单
     * @return void
     */
    public function add_moredeal_aigc_admin_menu() {
        $title      = Plugin::name();
        $capability = 'access_moredeal_aigc_admin_menu';
        $this->role_cap( $capability );

        $icon_svg = PLUGIN_RES . '/images/setting.svg';
        add_menu_page(
            $title,
            $title,
            $capability,
            Plugin::slug(),
            array( $this, 'add_moredeal_aigc_admin_page' ),
            $icon_svg
        );
    }

    /**
     * 插件 admin 后台管理页面
     * @return void
     */
    public function add_moredeal_aigc_admin_page() {
        echo '<div id="moredeal-ai-writer-dashboard"></div>';
    }

    /**
     * 插件页面添加链接
     *
     * @param array $links
     * @param       $file
     *
     * @return array
     */
    public function add_moredeal_aigc_plugin_row_meta( array $links, $file ): array {
        if ( $file == Plugin::plugin_basename() ) {
            return array_merge( $links, array(
                '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=' . Plugin::slug() . '">' . Plugin::translation( Plugin::name() ) . '</a>',
            ) );
        }

        return $links;
    }

    /**
     * 添加权限
     *
     * @param $capability
     *
     * @return void
     */
    private function role_cap( $capability ) {
        // 首先移除所有除 admin 的角色该权限
        foreach ( GeneralConfig::get_roles() as $role => $value ) {
            $role = get_role( $role );
            if ( $role == null ) {
                continue;
            }
            $role->remove_cap( $capability );
        }

        // 给 admin 重新设置权限
        get_role( 'administrator' )->add_cap( $capability );

        // 给其他角色设置权限
        $permissions = GeneralConfig::master_page_permissions();
        foreach ( $permissions as $permission => $permission_name ) {
            $role = get_role( $permission );
            if ( $role == null ) {
                continue;
            }
            $role->add_cap( $capability );
        }
    }

    /**
     * 加载插件设置页面
     *
     * @param $view_name
     * @param $_data
     *
     * @return void
     */
    public static function render( $view_name, $_data = null ) {
        if ( is_array( $_data ) ) {
            extract( $_data, EXTR_PREFIX_SAME, 'data' );
        } else {
            $data = $_data;
        }

        include Plugin::plugin_path() . 'application/admin/views/' . TextHelper::clear( $view_name ) . '.php';
    }

}
