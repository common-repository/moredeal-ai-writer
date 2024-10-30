<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\components\AbstractConfig;
use MoredealAiWriter\application\consts\ResConstant;
use MoredealAiWriter\application\Plugin;

/**
 * 用户服务配置
 *
 * @author MoredealAiWriter
 */
class ServiceConfig extends AbstractConfig {

    /**
     * 页面标识
     *
     * @return string
     */
    public function page_slug(): string {
        return Plugin::slug() . '-service';
    }

    /**
     * option 名称
     *
     * @return string
     */
    public function option_name(): string {
        return Plugin::option_prefix() . 'service';
    }

    /**
     * 添加菜单
     *
     * @return void
     */
    public function add_admin_menu() {

        $menu_title = Plugin::translation( 'Service' );
        $page_title = $menu_title . ' &lsaquo; ' . Plugin::translation( Plugin::name() );
        $capability = 'manage_options';
        add_submenu_page(
            Plugin::slug(),
            $page_title,
            $menu_title,
            $capability,
            $this->page_slug(),
            array( $this, 'service_index' )
        );
    }

    /**
     * 加载License页面
     *
     * @return void
     */
    public function service_index() {
        $this->load_scripts();
        echo '<div id="moredeal_ai_writer_service"></div>';
    }

    /**
     * 加载脚本
     * @return void
     */
    public function load_scripts() {
        // 样式文件
        AdminPlugin::load_moredeal_aigc_commons_styles();
        wp_register_style( 'moredeal_aigc_service_index_style', ResConstant::MOREDEAL_AIGC_SERVICE_INDEX_STYLE, array( 'moredeal_aigc_vendor_style' ), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_aigc_service_index_style' );

        // 脚本文件
        AdminPlugin::load_moredeal_aigc_commons_scripts( ResConstant::MOREDEAL_AIGC_SERVICE_VENDORS_SCRIPT );
        wp_register_script( 'moredeal_aigc_service_index_script', ResConstant::MOREDEAL_AIGC_SERVICE_INDEX_SCRIPT, array( 'moredeal_aigc_vendor_script' ), Plugin::script_version(), true );
        wp_localize_script( 'moredeal_aigc_service_index_script', 'MOREDEAL_AIGC', AdminPlugin::get_moredeal_aigc_store() );
        wp_enqueue_script( 'moredeal_aigc_service_index_script' );
    }

    /**
     * 操作选项
     *
     * @return array[]
     */
    protected function options(): array {
        return array();
    }

}