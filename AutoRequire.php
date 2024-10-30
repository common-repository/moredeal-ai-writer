<?php

namespace MoredealAiWriter;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\Plugin;

/**
 * AutoRequire 加载器
 *
 * @author MoredealAiWriter
 */
class AutoRequire {

    /**
     * AutoRequire 构造函数.
     * 调试模式开启情况下根据调试模式加载不同版本的类
     * free mode: AutoLoader, 只加载 free 版本类
     * plus mode: PlusAutoLoader, 加载 free 和 plus 版本类
     * pro mode: ProAutoLoader, 加载 free, plus 和 pro 版本类
     */
    public function __construct() {

        $level = Plugin::plugin_level();
        if ( $level === Plugin::LEVEL_PLUS ) {
            require_once Plugin::plugin_path() . 'plus/PlusAutoLoader.php';

            // error_log( 'MoredealAiWriter PLUS: ' . Plugin::version() . ' is loaded.' );

            return;
        }

        if ( $level === Plugin::LEVEL_PRO ) {
            require_once Plugin::plugin_path() . 'plus/PlusAutoLoader.php';
            require_once Plugin::plugin_path() . 'pro/ProAutoLoader.php';

            // error_log( 'MoredealAiWriter PRO: ' . Plugin::version() . ' is loaded.' );

            return;
        }
        // error_log( 'MoredealAiWriter FREE: ' . Plugin::version() . ' is loaded.' );
    }
}

new AutoRequire();