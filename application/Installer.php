<?php

namespace MoredealAiWriter\application;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\components\AccountManager;

/**
 * Installer class file
 *
 * @author Aclumsy
 */
class Installer {

    /**
     * DB 版本, 作用于插件自定义表结构或者数据发生变化的时候，提升该版本号，发布之后既可以自动升级
     *
     * @var int
     */
    const DB_VERSION = 1190;

    /**
     * WP 要求最低版本
     *
     * @var string
     */
    const WP_REQUIRES = '4.6.1';

    /**
     * PHP 要求最低版本
     *
     * @var string
     */
    const PHP_REQUIRES = '7.0';

    /**
     * 扩展
     *
     * @var array
     */
    const EXTENSIONS = array( 'simplexml', 'mbstring', 'hash' );

    /**
     * 实例
     * @var Installer|null
     */
    private static $instance = null;

    /**
     * 获取实例
     * @return Installer|null
     */
    public static function getInstance() {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 获取 DB 版本
     * 作用于插件自定义表结构或者数据发生变化的时候，提升该版本号，发布之后既可以自动执行升级脚本。从而完成数据库结构或者数据的升级
     *
     * 比如说，插件发布时，数据库版本为 1，那么当插件发布了一个新版本，需要修改数据库结构或者数据（比如说添加删除新字段等），那么就需要提升数据库版本为 2
     * 这样，当用户升级插件的时候，就会自动执行升级脚本，从而完成数据库结构或者数据的升级
     *
     * 当然，如果你的插件升级不涉及到数据库结构或者数据的变化，那么就不需要提升该版本号。
     *
     * @return int
     */
    public static function db_version(): int {
        return self::DB_VERSION;
    }

    /**
     * 获取 WP 要求最低版本
     *
     * @return string
     */
    public static function wp_requires(): string {
        return self::WP_REQUIRES;
    }

    /**
     * 获取 PHP 要求最低版本
     *
     * @return string
     */
    public static function php_requires(): string {
        return self::PHP_REQUIRES;
    }

    /**
     * 获取扩展
     *
     * @return array
     */
    public static function extensions(): array {
        return self::EXTENSIONS;
    }

    /**
     * 构造方法
     */
    private function __construct() {
        if ( ! empty( $GLOBALS['pagenow'] ) && $GLOBALS['pagenow'] == 'plugins.php' ) {
            add_action( 'admin_init', array( $this, 'requirements' ), 0 );
        }
        add_action( 'admin_init', array( $this, 'upgrade' ) );
        add_action( 'admin_init', array( $this, 'redirect_after_activation' ) );
    }

    /**
     * 激活插件
     * @return void
     */
    public static function activate() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        self::requirements();

        add_option( Plugin::option_prefix() . 'do_activation_redirect', true );
        add_option( Plugin::option_prefix() . 'first_activation_date', time() );
        self::generateAigcToken();
        self::upgradeTables();
    }

    /**
     * 停用插件
     *
     * @return void
     */
    public static function deactivate() {
        error_log( 'MoredealAiWriter Plugin Deactivated' );
    }

    /**
     * 卸载
     * @return void
     */
    public static function uninstall() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        delete_option( Plugin::option_prefix() . 'db_version' );
    }

    /**
     * 要求
     *
     * @return void
     */
    public static function requirements() {

        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $errors = array();
        $name   = get_file_data( Plugin::plugin_file(), array( 'Plugin Name' ), 'plugin' );

        /**
         * wp version check
         */
        global $wp_version;
        if ( version_compare( self::wp_requires(), $wp_version, '>' ) ) {
            $errors[] = sprintf( 'You are using WordPress %s. <em>%s</em> requires at least <strong>Wordpress %s</strong>.', $wp_version, $name[0], self::wp_requires() );
        }

        /**
         * php version check
         */
        $php_version = phpversion();
        if ( version_compare( self::php_requires(), $php_version, '>' ) ) {
            $errors[] = sprintf( 'PHP is installed on your server %s. <em>%s</em> requires at least <strong>PHP %s</strong>.', $php_version, $name[0], self::php_requires() );
        }

        /**
         * extension check
         */
        foreach ( self::extensions() as $extension ) {
            if ( ! extension_loaded( $extension ) ) {
                $errors[] = sprintf( 'Requires extension <strong>%s</strong>.', $extension );
            }
        }

        if ( ! $errors ) {
            return;
        }
        unset( $_GET['activate'] );
        error_log( 'MoredealAiWriter Plugin Activation Failed' );
        deactivate_plugins( Plugin::plugin_basename() );
        $e = sprintf( '<div class="error"><p>%1$s</p><p><em>%2$s</em> ' . 'cannot be installed!' . '</p></div>', join( '</p><p>', $errors ), $name[0] );
        wp_die( wp_kses_post( $e ) );
    }

    /**
     * 升级
     * @return void
     */
    public static function upgrade() {
        $db_version = get_option( Plugin::option_prefix() . 'db_version' );
        if ( (int) $db_version >= self::db_version() ) {
            return;
        }
        self::generateAigcToken();
        self::upgradeTables();

        update_option( Plugin::option_prefix() . 'db_version', self::db_version() );
    }

    /**
     * 生成 AIGC Token
     * @return bool
     */
    public static function generateAigcToken(): bool {
        return AccountManager::getInstance()->save_aigc_account();
    }

    /**
     * 升级表
     */
    private static function upgradeTables() {
        error_log( 'MoredealAiWriter Plugin Upgrade Tables' );
        $models = array( 'LogModel', 'TemplateModel', 'TemplateDownloadModel', 'UseLimitModel' );
        $sql    = '';
        foreach ( $models as $model ) {
            $model = "\\MoredealAiWriter\\application\\models\\" . $model;
            $sql   .= $model::model()->dump_sql();
            $sql   .= "\r\n";
        }
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $queries = dbDelta( $sql );

        error_log( 'MoredealAiWriter Plugin Upgrade Tables: ' . json_encode( $queries ) );
    }

    /**
     * 激活后重定向
     */
    public function redirect_after_activation() {
        if ( get_option( Plugin::option_prefix() . 'do_activation_redirect', false ) ) {
            delete_option( Plugin::option_prefix() . 'do_activation_redirect' );
            wp_safe_redirect( get_admin_url( get_current_blog_id(), 'admin.php?page=' . Plugin::slug() ) );
        }
    }

}
