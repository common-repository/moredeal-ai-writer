<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\components\AbstractConfig;
use MoredealAiWriter\application\components\AccountManager;
use MoredealAiWriter\application\components\LicenseManager;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\application\Plugin;

/**
 * 授权码页面
 *
 * @author MoredealAiWriter
 */
class LicenseConfig extends AbstractConfig {

    /**
     * 页面标识
     *
     * @return string
     */
    public function page_slug(): string {
        return Plugin::slug() . '-license';
    }

    /**
     * option 名称
     *
     * @return string
     */
    public function option_name(): string {
        return Plugin::option_prefix() . 'license';
    }

    /**
     * 添加菜单
     *
     * @return void
     */
    public function add_admin_menu() {

        if ( LicenseManager::is_display_notice() ) {
            $this->unbind_license();
            AccountManager::getInstance()->generate_aigc_account();
        }

        $menu_title = Plugin::translation( 'License' );
        $page_title = $menu_title . ' &lsaquo; ' . Plugin::translation( Plugin::name() );
        $capability = 'manage_options';
        add_submenu_page(
            Plugin::slug(),
            $page_title,
            $menu_title,
            $capability,
            $this->page_slug(),
            array( $this, 'license_index' )
        );
    }

    /**
     * 加载License页面
     *
     * @return void
     */
    public function license_index() {
        AdminPlugin::load_moredeal_aigc_admin_scripts();
        AdminPlugin::render( 'license_index', array( 'page_slug' => $this->page_slug() ) );
    }

    /**
     * 操作选项
     *
     * @return array[]
     */
    protected function options(): array {

        return array(
            // 按钮 text
            'license_key' => array(
                'title'       => Plugin::translation( 'License Key' ),
                'description' => sprintf( Plugin::translation( 'Please enter your license key, Please check %s to purchase the license key you want.' ), sprintf( '<a href="%s" target="_blank">' . Plugin::translation( 'The Price List' ) . '</a>', Plugin::upgrade_url() ) ),
                'callback'    => array( $this, 'render_input' ),
                'default'     => '',
                'style'       => 'width: 600px',
                'validator'   => array(
                    'trim',
                    array(
                        'call'    => array( '\MoredealAiWriter\application\helpers\FormValidator', 'required' ),
                        'message' => Plugin::translation( 'The License key can not be empty.' ),
                    ),
                    array(
                        'call'    => array( '\MoredealAiWriter\application\helpers\FormValidator', 'licenseFormat' ),
                        'message' => Plugin::translation( 'Invalid License Key, Please check your License Key.' ),
                    ),
                    array(
                        'call' => array( $this, 'activating_license' ),
                    ),
                ),
                'section'     => Plugin::translation( 'License' ),
            )
        );
    }

    /**
     * 激活License
     *
     * @param $value string
     *
     * @return bool true: 激活成功
     */
    public function activating_license( string $value ): bool {

        $result = SeastarRestfulClient::getInstance()->active_license( $value );
        if ( empty( $result['success'] ) ) {
            $message = empty( $result['message'] ) ? Plugin::translation( ErrorConstant::ACTIVE_LICENSE_FAIL_MESSAGE ) : Plugin::translation( $result['message'] );
            LicenseManager::add_license_setting_error( $message );

            return false;
        }

        return true;
    }

    /**
     * 解绑
     * @return void
     */
    public function unbind_license() {

        // UNBIND_TAG 为解绑标识, UNBIND_TAG_VALUE 为解绑标识值. 用于判断是否为解绑操作
        if ( isset( $_POST[ LicenseManager::UNBIND_TAG ] ) && $_POST[ LicenseManager::UNBIND_TAG ] == LicenseManager::UNBIND_TAG_VALUE ) {
            // 判断 License 是否为空
            if ( ! isset( $_POST[ LicenseManager::UNBIND_FORM_LICENSE ] ) || empty( $_POST[ LicenseManager::UNBIND_FORM_LICENSE ] ) ) {
                LicenseManager::add_license_setting_error( Plugin::translation( ErrorConstant::UNBIND_LICENSE_FAIL_MESSAGE ) );

                return;
            }
            // 判断 Domain 是否为空
            if ( ! isset( $_POST[ LicenseManager::UNBIND_FORM_DOMAIN ] ) || ! $_POST[ LicenseManager::UNBIND_FORM_DOMAIN ] ) {
                LicenseManager::add_license_setting_error( Plugin::translation( ErrorConstant::UNBIND_LICENSE_FAIL_MESSAGE ) );

                return;
            }

            // 解绑操作
            $request = array(
                'license' => $_POST[ LicenseManager::UNBIND_FORM_LICENSE ],
                'domain'  => $_POST[ LicenseManager::UNBIND_FORM_DOMAIN ]
            );
            $result  = SeastarRestfulClient::getInstance()->unbind_license( $request );

            // 解绑失败
            if ( empty( $result['success'] ) ) {
                $message = empty( $result['message'] ) ? Plugin::translation( ErrorConstant::UNBIND_LICENSE_FAIL_MESSAGE ) : Plugin::translation( $result['message'] );
                LicenseManager::add_license_setting_error( $message );

                return;
            }

            // 解绑成功
            if ( $_POST[ LicenseManager::UNBIND_FORM_DOMAIN ] == Plugin::current_domain() ) {
                // 删除License
                delete_option( $this->option_name() );
                delete_option( TokenConfig::getInstance()->option_name() );
                // 重置选项
                $this->reset_option();
                TokenConfig::getInstance()->reset_option();
                // 重置等级
                Plugin::plugin_reset_level();
            }
        }

    }

    /**
     * 获取License Key
     *
     * @param string $default
     *
     * @return string
     */
    public static function license_key( string $default = '' ): string {
        return self::getInstance()->option( 'license_key', $default );
    }


}
