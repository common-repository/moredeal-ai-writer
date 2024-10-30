<?php

namespace MoredealAiWriter\application\admin;

use MoredealAiWriter\application\components\AbstractConfig;
use MoredealAiWriter\application\Plugin;

defined( '\ABSPATH' ) || exit;

/**
 * 通用设置页面
 *
 * @author MoredealAiWriter
 */
class GeneralConfig extends AbstractConfig {

    /**
     * 页面标识
     *
     * @return string
     */
    public function page_slug(): string {
        return Plugin::slug() . '-settings';
    }

    /**
     * option 名称
     *
     * @return string
     */
    public function option_name(): string {
        return Plugin::option_prefix() . 'settings';
    }

    /**
     * 添加菜单
     *
     * @return void
     */
    public function add_admin_menu() {

        $menu_title = Plugin::translation( 'Settings' );
        $page_title = $menu_title . ' &lsaquo; ' . Plugin::translation( Plugin::name() );
        $capability = 'manage_options';
        add_submenu_page(
            Plugin::slug(),
            $page_title,
            $menu_title,
            $capability,
            $this->page_slug(),
            array( $this, 'settings_index' )
        );
    }

    /**
     * 加载License页面
     *
     * @return void
     */
    public function settings_index() {
        AdminPlugin::load_moredeal_aigc_admin_scripts();
        AdminPlugin::render( 'settings_index', array( 'page_slug' => $this->page_slug() ) );
    }

    /**
     * 操作选项
     *
     * @return array[]
     */
    protected function options(): array {

        return array(
            'user_template_permission'      => array(
                'title'       => Plugin::translation( 'Moredeal Ai Writer User Template Permissions' ),
                'description' => Plugin::translation( 'You can view only the templates that you have created(administrator can view all templates).' ),
                'callback'    => array( $this, 'render_checkbox' ),
                'section'     => Plugin::translation( "General Settings" )
            ),

            // Moredeal AI Writer 权限
            'master_page_permissions'       => array(
                'title'            => Plugin::translation( 'Moredeal Ai Writer Page Permissions' ),
                'description'      => Plugin::translation( 'Select the user roles that can access the Moredeal Ai Writer page.' ),
                'checkbox_options' => self::get_roles(),
                'callback'         => array( $this, 'render_checkbox_list' ),
                'default'          => array(),
                'section'          => Plugin::translation( "General Settings" )
            ),

            // 是否开启Gutenberg编辑器
            'enable_gutenberg_block_editor' => array(
                'title'       => Plugin::translation( 'Enable Gutenberg Block Editor' ),
                'description' => Plugin::translation( 'Enable Gutenberg Block Editor. You can use our provided block editing tools to simplify writing articles.' ),
                'callback'    => array( $this, 'render_checkbox' ),
                'section'     => Plugin::translation( "General Settings" )
            ),
        );
    }

    /**
     * 获取角色
     * @return array
     */
    public static function get_roles(): array {
        $roles      = wp_roles()->roles;
        $role_names = array();
        foreach ( $roles as $role => $role_info ) {
            if ( $role == 'administrator' ) {
                continue;
            }
            $role_names[ $role ] = Plugin::translation( $role_info['name'] );
        }

        return $role_names;
    }

    /**
     * 获取主页面权限
     * @return array
     */
    public static function master_page_permissions(): array {
        return self::getInstance()->option( 'master_page_permissions' );
    }

    /**
     * 用户查看模版的权限开关
     *
     * @return bool
     */
    public static function getUserTemplatePermission(): bool {
        return self::getInstance()->option( 'user_template_permission' );
    }

    /**
     * 是否启用古腾堡块编辑器
     *
     * @return bool
     */
    public static function enable_gutenberg_block_editor(): bool {
        return self::getInstance()->option( 'enable_gutenberg_block_editor' );
    }


}