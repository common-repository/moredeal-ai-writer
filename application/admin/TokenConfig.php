<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\components\AbstractConfig;
use MoredealAiWriter\application\components\AccountManager;
use MoredealAiWriter\application\components\TokenManager;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\Plugin;

/**
 * Token 页面配置
 *
 * @author MoredealAiWriter
 */
class TokenConfig extends AbstractConfig {

    /**
     * 页面标识
     *
     * @return string
     */
    public function page_slug(): string {
        return Plugin::slug() . '-token';
    }

    /**
     * option 名称
     *
     * @return string
     */
    public function option_name(): string {
        return Plugin::option_prefix() . 'token';
    }

    /**
     * 添加菜单
     *
     * @return void
     */
    public function add_admin_menu() {

        if ( TokenManager::is_display_notice() ) {
            AccountManager::getInstance()->generate_aigc_account();
        }

        $menu_title = Plugin::translation( 'Token Recharge' );
        $page_title = $menu_title . ' &lsaquo; ' . Plugin::translation( Plugin::name() );
        $capability = 'manage_options';

        add_submenu_page(
            Plugin::slug(),
            $page_title,
            $menu_title,
            $capability,
            $this->page_slug(),
            array( $this, 'token_index' )
        );
    }

    /**
     * 加载 Token 页面
     *
     * @return void
     */
    public function token_index() {
        AdminPlugin::load_moredeal_aigc_admin_scripts();
        AdminPlugin::render( 'token_index', array( 'page_slug' => $this->page_slug() ) );
    }

    /**
     * 配置选项
     *
     * @return array
     */
    protected function options(): array {
        return array(
            // 按钮 text
            'token_recharge_key' => array(
                'title'       => Plugin::translation( 'Token Recharge Key' ),
                'description' => sprintf( Plugin::translation( 'Please enter your Token Recharge Key, Please check %s to purchase the token recharge key you want.' ), sprintf( '<a href="%s" target="_blank">' . Plugin::translation( 'The Price List' ) . '</a>', Plugin::upgrade_url() ) ),
                'callback'    => array( $this, 'render_input' ),
                'default'     => '',
                'style'       => 'width: 600px',
                'validator'   => array(
                    'trim',
                    array(
                        'call'    => array( '\MoredealAiWriter\application\helpers\FormValidator', 'required' ),
                        'message' => Plugin::translation( 'The Token Recharge Key can not be empty.' ),
                    ),
                    array(
                        'call'    => array( '\MoredealAiWriter\application\helpers\FormValidator', 'licenseFormat' ),
                        'message' => Plugin::translation( 'Invalid Token Recharge Key, Please check your License Key.' ),
                    ),
                    array(
                        'call' => array( $this, 'active_token' ),
                    ),
                ),
                'section'     => Plugin::translation( 'Token' ),
            )
        );
    }

    /**
     * 激活 Token
     *
     * @param string $value
     *
     * @return bool
     */
    public function active_token( string $value ): bool {
        $result = SeastarRestfulClient::getInstance()->active_token( $value );
        if ( empty( $result['success'] ) ) {
            $message = empty( $result['message'] ) ? Plugin::translation( ErrorConstant::ACTIVE_TOKEN_FAIL_MESSAGE ) : Plugin::translation( $result['message'] );
            TokenManager::add_token_setting_error( $message );

            return false;
        }

        return true;
    }

    /**
     * 获取 Token 充值值, 提供方法方便外部获取
     *
     * @param string $default
     *
     * @return string
     */
    public static function token_recharge_key( string $default = '' ): string {
        return self::getInstance()->option( 'token_recharge_key', $default );
    }

}