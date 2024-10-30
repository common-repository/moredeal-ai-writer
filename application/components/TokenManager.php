<?php

namespace MoredealAiWriter\application\components;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\admin\TokenConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\Plugin;

/**
 * Token 管理类
 *
 * @author MoredealAiWriter
 */
class TokenManager {

    /**
     * License 信息
     *
     * @var array
     */
    private $token_info = null;

    /**
     * 授权码管理实例
     *
     * @var null LicenseManager
     */
    private static $instance = null;

    /**
     * 获取实例
     *
     * @return TokenManager
     */
    public static function getInstance(): TokenManager {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 是否是 token 配置页面
     * @return bool
     */
    public static function is_display_notice(): bool {
        if ( $GLOBALS['pagenow'] == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == TokenConfig::getInstance()->page_slug() ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加错误信息
     *
     * @param string $message
     *
     * @return void
     */
    public static function add_token_setting_error( string $message ) {
        if ( self::is_display_notice() ) {
            return;
        }
        add_settings_error( 'token', 'token', $message );
    }

    /**
     * 获取 token 信息
     *
     * @param string $aigc_key
     *
     * @return array
     */
    public function token_info( string $aigc_key ): array {

        if ( empty( $aigc_key ) ) {
            $this->token_info = array();

            return $this->token_info;
        }

        $result = SeastarRestfulClient::getInstance()->token_info( $aigc_key );
        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) && is_array( $result['data'] ) ) {
            $token_info = $result['data'];
        } else {
            $token_info = array();
        }

        $this->token_info = $token_info;

        return $this->token_info;
    }

    /**
     * 获取 token 信息
     *
     * @param string $aigc_key
     *
     * @return array
     */
    public function token_info_message( string $aigc_key ): array {

        if ( empty( $aigc_key ) ) {
            $this->token_info = array();

            return $this->token_info;
        }

        $result = SeastarRestfulClient::getInstance()->token_info( $aigc_key );
        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) && is_array( $result['data'] ) ) {
            $this->token_info = $result['data'];
        }

        return $result;
    }

    /**
     * 初始化加载
     *
     * @return void
     */
    public function admin_init() {
        if ( ! self::is_display_notice() ) {
            return;
        }
        add_action( 'admin_notices', array( $this, 'display_notice' ) );
    }

    /**
     * 显示 token 配置页面的显示信息
     *
     * @return void
     */
    public function display_notice() {

        // 仅在 Token 配置页面显示
        if ( ! self::is_display_notice() ) {
            return;
        }

        // 加载样式
        $this->add_inline_css();

        // aigc_key ( 免费版和非免费版,但是没有 license_key 为 account, 高级版且有 license_key 则为 license_key)  不存在，使用免费授权码
        $aigc_key = LicenseConfig::license_key();
        if ( empty( $aigc_key ) ) {
            $aigc_key = Plugin::plugin_key();
            if ( empty( $aigc_key ) ) {
                return;
            }
        }
        
        // 获取 Token 信息
        $result = $this->token_info_message( $aigc_key );
        if ( empty( $result ) || empty( $result['success'] ) || empty( $result['data'] ) ) {
            $token_info = array();
        } else {
            $token_info = $result['data'];
        }
        $message = empty( $result['success'] ) ? $result['message'] : '';
        $check   = $this->display_check_notice( $aigc_key, $token_info, $message );
        if ( ! $check ) {
            return;
        }

        // token 信息不为空
        $this->display_notice_normal( $aigc_key, $token_info );
    }

    /**
     * 校验 Token 信息通知
     *
     * @param string $aigc_key
     * @param array  $token_info
     * @param string $message
     *
     * @return bool
     */
    private function display_check_notice( string $aigc_key, array $token_info, string $message = '' ): bool {
        if ( ! empty( $message ) ) {
            echo '<div class="notice notice-error is-dismissible"><p>';
            echo Plugin::translation( $message );
            echo '</p></div>';

            return false;
        }
        // Token 信息为空
        if ( empty( $token_info ) ) {
            echo '<div class="notice notice-error is-dismissible"><p>';
            echo Plugin::translation( 'Cant get token info, This token has an unknown error occurred, contact your administrator to solve the problem. ' );
            echo '</p></div>';

            return false;
        }

        if ( empty( $token_info['code'] ) || $token_info['code'] != $aigc_key ) {
            echo '<div class="notice notice-error is-dismissible"><p>';
            echo Plugin::translation( 'Other errors occurred, contact your administrator to solve the problem. ' );
            echo '</p></div>';

            return false;
        }

        return true;
    }

    /**
     * 显示 Token 信息
     *
     * @return void
     */
    public function display_notice_normal( $aigc_key, $token_info ) {

        echo '<div class="notice notice-success moredeal-notice">';
        if ( $aigc_key == LicenseConfig::license_key() ) {
            echo '<p><strong>License Key: &nbsp;&nbsp; <em>' . $aigc_key . '</em> <strong></p>';
            echo '<p>' . Plugin::translation( 'If you want to buy tokens, your recharge key will be recharged to this license key. ' ) . '</p>';
        } else {
            echo '<p><strong>Account ID: &nbsp;&nbsp; <em>' . $aigc_key . '</em></strong></p>';
            echo '<p>' . Plugin::translation( 'If you want to buy tokens, your recharge key will be recharged to this account id, if you upgrade your plugin again, the token will not be transferred. It is recommended to upgrade to a higher version of the plugin before topping up your tokens to get a better experience.' ) . '</p>';
        }
        $this->display_token_info( $token_info );
        echo '</div>';
    }

    /**
     * 渲染 Token 信息
     *
     * @param $token_info
     *
     * @return void
     */
    public function display_token_info( $token_info ) {
        // 总 token
        $total_token = ! empty( $token_info['tokenTotal'] ) ? $token_info['tokenTotal'] : null;
        // 可用 token
        $usable_token = ! empty( $token_info['tokenUsable'] ) ? $token_info['tokenUsable'] : null;
        // 已用 token
        $used_token = ! empty( $token_info['tokenUsed'] ) ? $token_info['tokenUsed'] : null;
        // 到期时间
        $timeLeft = ! empty( $token_info['timeLeft'] ) ? $token_info['timeLeft'] : null;

        echo '<div>';
        if ( ! empty( $total_token ) ) {
            echo '<p>' . Plugin::translation( 'Total Token: ' ) . '<strong>' . $total_token . '</strong></p>';
        }
        if ( ! empty( $used_token ) ) {
            echo '<p>' . Plugin::translation( 'Used Token: ' ) . '<strong>' . $used_token . '</strong></p>';
        }
        if ( ! empty( $usable_token ) ) {
            echo '<p>' . Plugin::translation( 'Usable Token: ' ) . '<strong>' . $usable_token . '</strong></p>';
        }
        if ( ! empty( $timeLeft ) ) {
            echo '<p>' . Plugin::translation( 'Days left: ' ) . '<strong>' . $timeLeft . '</strong> </p>';
        }
        echo '</div>';
    }


    /**
     * 加载样式
     *
     * @return void
     */
    public function add_inline_css() {
        echo '<style>.moredeal-notice a.moredeal-notice-close {position:static;font-size:13px;float:right;top:0;right0;padding:0;margin-top:-20px;line-height:1.23076923;text-decoration:none;}.moredeal-notice a.moredeal-notice-close::before{position: relative;top: 18px;left: -20px;}.moredeal-notice img {float:left;width:40px;padding-right:12px;}</style>';
        echo '<style>.comp_wrapper{display:table;font-size:13px;color:#7A7A7A;border:1px solid #ececec;margin-bottom:8px}.comp_wrapper .comp_row:nth-child(2n+1){background-color:#f5f5f5}.comp_row{display:table-row}.comp_thead{font-weight:600;max-width:140px}.com_data,.comp_thead{width:140px;display:table-cell;vertical-align:middle;position:relative;text-align:center;padding:10px 10px 10px 10px;}.comp_wrapper .comp_row:nth-child(1) > div{padding:10px 5px}.comp_wrapper a{overflow:hidden;display:block;text-align:center;box-shadow:none;text-decoration:none;color:#448FD5;font-weight:700} </style>';
    }


}