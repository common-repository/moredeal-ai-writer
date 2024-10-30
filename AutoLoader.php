<?php

namespace MoredealAiWriter;

defined( '\ABSPATH' ) || exit;

/**
 * AutoLoader 加载器
 * 将插件目录下的所有类自动加载, 无需手动 require, 方便管理
 *
 * @author MoredealAiWriter
 */
class AutoLoader {

    /**
     * 基础目录 (插件目录)
     *
     * @var string $base_dir
     */
    private static $base_dir;

    /**
     * AutoLoader 构造函数.
     */
    public function __construct() {
        self::$base_dir = PLUGIN_PATH;
        $this->register_auto_loader();
    }

    /**
     * 注册自动加载
     *
     * @return void
     */
    public function register_auto_loader() {
        spl_autoload_register( array( $this, 'autoload' ) );
    }

    /**
     * 自动加载类
     *
     * @param $className string 类名称
     *
     * @return void
     */
    public static function autoload( string $className ) {
        $prefix = __NAMESPACE__;
        $len    = strlen( $prefix );

        // 检测当前类是否属于当前命名空间
        if ( strncmp( $prefix, $className, $len ) !== 0 ) {
            return;
        }

        // 排除 pro 版本 和 plus 版本的类, 由 pro 包下面的 ProAutoLoader 和 plus 包下面的 PlusAutoLoader 加载
        if ( self::is_exclude_dir( $prefix, $className, 'pro' ) || self::is_exclude_dir( $prefix, $className, 'plus' ) ) {
            return;
        }

        // 获取相对类名
        $relative_class = substr( $className, $len );
        // 将相对类名转换为文件路径
        $file = self::$base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
        // 如果文件存在, 则加载
        if ( file_exists( $file ) ) {
            require $file;
        }
    }

    /**
     * 是否排除 dir_name 目录下的类的自动加载
     *
     * 如:
     * pro 版本的类由 pro 包下面的 ProAutoLoader 加载, 无需在此加载
     * plus 版本的类由 plus 包下面的 PlusAutoLoader 加载, 无需在此加载
     *
     * @param        $prefix string 命名空间前缀
     * @param        $className string 类名称
     * @param string $dir_name string 目录名称
     *
     * @return bool
     */
    private static function is_exclude_dir( string $prefix, string $className, string $dir_name ): bool {
        $plus_prefix = $prefix . '\\' . $dir_name . '\\';
        $plus_len    = strlen( $plus_prefix );
        // 检测当前类是否属于当前命名空间, 是则直接返回, 不加载该命名空间下的类, 由 plus 包下面的 PlusAutoLoader 加载
        if ( strncmp( $plus_prefix, $className, $plus_len ) == 0 ) {
            return true;
        }

        return false;
    }

}

new AutoLoader();

require_once PLUGIN_PATH . 'AutoRequire.php';

