<?php

namespace MoredealAiWriter;

/*
Plugin Name: Moredeal AI Writer
Text Domain: moredeal-ai-writer
Plugin URI: https://www.mdc.ai
Description: Moredeal AI Writer - GPT Content Generator, Custom AI Template & AI Forms & Prompt Template Market & Sell Template
Author: mdc.ai
Version: 1.2.0
Author URI: https://www.mdc.ai
*/

defined( '\ABSPATH' ) || die( 'No direct script access allowed!' );

use MoredealAiWriter\application\Installer;

define( 'MoredealAiWriter\\VERSION', '1.2.0' );
define( 'MoredealAiWriter\\PLUGIN_FILE', __FILE__ );
define( 'MoredealAiWriter\\PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MoredealAiWriter\\PLUGIN_RES', plugins_url( 'res', __FILE__ ) );
define( 'MoredealAiWriter\\PLUGIN_CHAT', plugins_url( 'chat', __FILE__ ) );
define( 'MoredealAiWriter\\PLUGIN_WP_BLOCK', plugins_url( 'wp_block', __FILE__ ) );

require_once PLUGIN_PATH . 'AutoLoader.php';

add_action( 'plugins_loaded', array( '\MoredealAiWriter\application\Plugin', 'getInstance' ) );
if ( is_admin() ) {
    register_activation_hook( __FILE__, array( Installer::getInstance(), 'activate' ) );
    register_deactivation_hook( __FILE__, array( Installer::getInstance(), 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( '\MoredealAiWriter\application\Installer', 'uninstall' ) );
    add_action( 'init', array( '\MoredealAiWriter\application\admin\AdminPlugin', 'getInstance' ) );
}






