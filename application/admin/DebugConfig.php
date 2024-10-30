<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\components\AbstractConfig;
use MoredealAiWriter\application\Plugin;

/**
 * 调试页面
 * 开放一个调试页面，方便调试. 发布的时候关闭
 *
 * @author MoredealAiWriter
 */
class DebugConfig extends AbstractConfig {

    /**
     * 后台菜单地址标识
     *
     * @return string
     */
    public function page_slug(): string {
        return Plugin::slug() . '-debug';
    }

    /**
     * option 名称
     *
     * @return string
     */
    public function option_name(): string {
        return Plugin::option_prefix() . 'debug';
    }

    /**
     * 添加菜单
     * @return void
     */
    public function add_admin_menu() {

        $menu_title = Plugin::translation( 'Debugger' );
        $page_title = $menu_title . ' &lsaquo; ' . Plugin::translation( Plugin::name() );
        $capability = 'manage_options';

        add_submenu_page(
            Plugin::slug(),
            $page_title,
            $menu_title,
            $capability,
            $this->page_slug(),
            array( $this, 'debug_index' )
        );
    }

    /**
     * 加载Debug页面
     * @return void
     */
    public function debug_index() {
        AdminPlugin::load_moredeal_aigc_admin_scripts();
        AdminPlugin::render( 'debug_index', array( 'page_slug' => $this->page_slug() ) );
    }

    /**
     * options
     *
     * @return array
     */
    protected function options(): array {
        return array(
            'debug' => array(
                'title'       => Plugin::translation( 'Enable Debugger' ),
                'description' => '',
                'callback'    => array( $this, 'render_checkbox' ),
                'default'     => false,
                'section'     => Plugin::translation( 'Debugger' ),
            ),
            'mode'  => array(
                'title'            => Plugin::translation( 'Debugger Mode' ),
                'description'      => Plugin::translation( 'Debugger mode, you can select Free, Pro, Plus' ),
                'callback'         => array( $this, 'render_dropdown' ),
                'style'            => 'width: 300px',
                'dropdown_options' => array(
                    Plugin::LEVEL_FREE => Plugin::translation( 'Free' ),
                    Plugin::LEVEL_PRO  => Plugin::translation( 'Pro' ),
                    Plugin::LEVEL_PLUS => Plugin::translation( 'Plus' ),
                ),
                'section'          => Plugin::translation( 'Debugger' ),
            ),
        );
    }

}