<?php

namespace MoredealAiWriter\application\components;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\admin\TokenConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\Plugin;

/**
 * Moredeal Aigc Account 管理类. Moredeal AI Writer 会为每个用户创建一个 Account, 用于免费用户的免费 token 使用
 *
 * @author MoredealAiWriter
 */
class AccountManager {

    /**
     * Moredeal Aigc Account 值
     * @var string|false
     */
    private static $aigc_account = false;

    /**
     * Moredeal Aigc Account 管理实例
     *
     * @var null LicenseManager
     */
    private static $instance = null;

    /**
     * 获取实例
     *
     * @return AccountManager
     */
    public static function getInstance(): AccountManager {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 获取 Moredeal Aigc Account
     *
     * @return string|false Aigc Token 值 ,获取不到的时候为false
     */
    public static function plugin_account( bool $force = false ) {
        if ( $force ) {
            $aigc_account       = get_option( self::account_option_name(), false );
            self::$aigc_account = $aigc_account;

            return self::$aigc_account;
        }

        return self::$aigc_account;
    }

    /**
     * Moredeal Aigc Account Option
     *
     * @return string
     */
    public static function account_option_name(): string {
        return Plugin::option_prefix() . 'account';
    }

    /**
     * 初始化加载
     *
     * @return void
     */
    public function admin_init() {
        $aigc_account = get_option( self::account_option_name(), false );
        if ( ! empty( $aigc_account ) ) {
            self::$aigc_account = $aigc_account;
        } else {
            self::$aigc_account = false;
        }
    }

    /**
     * 渲染 Moredeal Aigc Account 信息
     *
     * @param $section
     *
     * @return void
     */
    public function render_aigc_account( $section ) {
        $aigc_account = self::plugin_account( true );
        echo '<div style="font-size: 14px">';
        if ( ! empty( $aigc_account ) ) {
            $this->render_normal_aigc_account( $aigc_account );
        } else {
            if ( $section === 'Token' ) {
                $slug = TokenConfig::getInstance()->page_slug();
            } else if ( $section === 'License' ) {
                $slug = LicenseConfig::getInstance()->page_slug();
            } else {
                $slug = '';
            }
            $this->render_empty_aigc_account( $slug );
        }
        echo '</div>';
    }

    /**
     * 有 token 的时候, 渲染 token 页面
     *
     * @param string $token
     *
     * @return void
     */
    public function render_normal_aigc_account( string $token ) {
        echo '<p style="font-size: 14px; margin-bottom: 4px; margin-top: 4px"><strong>Account ID: &nbsp;&nbsp; <em>' . $token . '</em></strong></p>';
        echo '<p style="font-size: 14px; margin-bottom: 4px; margin-top: 4px">' . Plugin::translation( 'This account id is a unique key representation of the Moredeal AI Writer plugin we generate for you.' ) . '</p>';
    }

    /**
     * 无 token 的时候, 渲染 token 页面
     *
     * @param string $slug
     *
     * @return void
     */
    public function render_empty_aigc_account( string $slug ) {
        echo '<p style="font-size: 14px; margin: 14px 10px 14px 0; display: inline">';
        echo '<strong>Account ID: &nbsp;&nbsp; ' . Plugin::translation( 'Not Found Your Account ? Please click the Generate button to generate your Account.' ) . '</strong></p>';
        if ( ! empty( $slug ) ) {
            echo '<form action=" ' . esc_url_raw( get_admin_url( get_current_blog_id(), 'admin.php?page=' . $slug ) ) . ' " method="POST" style="display: inline-block; vertical-align: middle;">';
            echo '<input type="hidden" name="generate_aigc_account" id="generate_aigc_account" value="generate_aigc_account_value"/>';
            echo '<input type="submit" name="aigc_gen_account" id="aigc_gen_account" value="' . Plugin::translation( 'Generate' ) . '" class="button button-normal" />';
            echo '</form>';
        }
        echo '<p style="font-size: 14px; margin-bottom: 4px; margin-top: 4px">' . Plugin::translation( 'This account id is the only key representation of the Moredeal AI Writer plugin to you. ' ) . '</p>';
    }

    /**
     * 初始化的时候, 为用户生成一个新的 token
     *
     * @return bool
     */
    public function save_aigc_account(): bool {

        // 如果已经有 token 了, 就不再生成了
        $aigc_account = self::plugin_account( true );
        if ( ! empty( $aigc_account ) ) {
            return true;
        }

        // 生成新的 token
        $result = SeastarRestfulClient::getInstance()->moredeal_aigc_account();

        if ( empty( $result['success'] ) ) {
            return false;
        }

        if ( empty( $result['data'] ) ) {
            return false;
        }

        $account = $result['data'];

        // 保存 token
        $option = update_option( self::account_option_name(), $account );
        if ( $option ) {
            error_log( self::plugin_account( true ) );

            return true;
        }
        error_log( "save_aigc_account false" );

        return false;

    }

    /**
     * 初始化的时候, 为用户生成一个新的 token
     *
     * @return void
     */
    public function generate_aigc_account() {

        if ( isset( $_POST['generate_aigc_account'] ) && $_POST['generate_aigc_account'] == 'generate_aigc_account_value' ) {

            // 如果已经有 token 了, 就不再生成了
            $aigc_account = self::plugin_account( true );
            if ( ! empty( $aigc_account ) ) {
                return;
            }

            // 生成新的 token
            $result = SeastarRestfulClient::getInstance()->moredeal_aigc_account();
            error_log( json_encode( $result ) );
            if ( empty( $result['success'] ) ) {
                add_settings_error( 'account', 'account', Plugin::translation( $result['message'] ) );

                return;
            }

            if ( empty( $result['data'] ) ) {
                add_settings_error( 'account', 'account', Plugin::translation( ErrorConstant::GET_MOREDEAL_AIGC_ACCOUNT_FAIL_MESSAGE ) );

                return;
            }

            $account = $result['data'];

            // 保存 token
            update_option( self::account_option_name(), $account );
        }
    }

}