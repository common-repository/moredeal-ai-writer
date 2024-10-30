<?php

namespace MoredealAiWriter\application;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\components\AccountManager;
use MoredealAiWriter\application\controller\AbstractApiController;
use MoredealAiWriter\application\shortcode\ModuleViewer;
use MoredealAiWriter\application\shortcode\ShortCode;
use const MoredealAiWriter\PLUGIN_CHAT;
use const MoredealAiWriter\PLUGIN_FILE;
use const MoredealAiWriter\PLUGIN_PATH;
use const MoredealAiWriter\PLUGIN_RES;
use const MoredealAiWriter\PLUGIN_WP_BLOCK;
use const MoredealAiWriter\VERSION;

/**
 * Plugin class file
 *
 * @author MoredealAiWriter
 */
class Plugin {

    /**
     * MoredealAiWriter 名称
     *
     * @var string
     */
    const NAME = 'Moredeal AI Writer';

    /**
     * MoredealAiWriter slug 唯一标识
     *
     * @var string
     */
    const SLUG = 'moredeal-ai-writer';

    /**
     * MoredealAiWriter Option 前缀
     */
    const OPTION_PREFIX = 'moredeal_aigc_';

    /**
     * MoredealAiWriter 官网
     *
     * @var string
     */
    const OFFICIAL_WEBSITE = 'https://www.mdc.ai';

    /**
     * MoredealAiWriter 升级地址
     *
     * @var string
     */
    const UPGRADE_URL = 'https://www.mdc.ai/moredeal-aigc-plug-pricing/';

    /**
     * MoredealAiWriter 文档地址
     *
     * @var string
     */
    const DOCUMENT_URL = 'https://docs.mdc.ai/';

    /**
     * MoredealAiWriter 联系我们
     *
     * @var string
     */
    const CONTACT_US_URL = 'https://www.mdc.ai/contact-us';

    /**
     * MoredealAiWriter 评价地址
     */
    const PLUGIN_WORDPRESS_REVIEW_URL = 'https://wordpress.org/support/view/plugin-reviews/moredeal-ai-writer?rate=5#postform';

    /**
     * 免费版
     *
     * @var string
     */
    const LEVEL_FREE = 'free';

    /**
     * 专业版
     *
     * @var string
     */
    const LEVEL_PRO = 'pro';

    /**
     * 专业高级版
     *
     * @var string
     */
    const LEVEL_PLUS = 'plus';

    /**
     * MoredealAiWriter 插件级别
     *
     * @var string
     */
    private static $level = null;

    /**
     * 实例
     *
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Plugin 实例
     * @return Plugin|null
     */
    public static function getInstance() {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {
        $this->loadTextDomain();
        if ( ! is_admin() ) {
            add_action( 'wp_enqueue_scripts', array( $this, 'registerScripts' ) );
            add_action( 'amp_post_template_css', array( $this, 'registerAmpStyles' ) );
            // Open Ai 接口
            AbstractApiController::init();
            // 简码
            ModuleViewer::getInstance()->init();
            ShortCode::init();
        }
    }

    /**
     * MoredealAiWriter 国际化
     */
    private function loadTextDomain() {
        load_plugin_textdomain( self::slug(), false, dirname( self::plugin_basename() ) . '/languages/' );
    }

    /**
     * MoredealAiWriter 注册脚本
     */
    public function registerScripts() {

    }

    /**
     * 注册 amp 样式
     */
    public function registerAmpStyles() {
        echo '';
    }

    /**
     * MoredealAiWriter 名称
     *
     * @return string
     */
    public static function name(): string {
        return self::NAME;
    }

    /**
     * MoredealAiWriter 插件版本
     *
     * @return string
     */
    public static function version(): string {
        return VERSION;
    }

    /**
     * MoredealAiWriter 脚本版本号
     * @return string
     */
    public static function script_version(): string {
        $timestamp        = time(); // 当前时间戳
        $halfHour         = 30 * 60; // 半个小时的秒数
        $roundedTimestamp = floor( $timestamp / $halfHour ) * $halfHour;

        // 每半个小时更新一次版本号
        return self::version() . '-' . $roundedTimestamp;
    }

    /**
     * MoredealAiWriter 插件 slug
     *
     * @return string
     */
    public static function slug(): string {
        return self::SLUG;
    }

    /**
     * MoredealAiWriter 插件 Option 前缀
     *
     * @return string
     */
    public static function option_prefix(): string {
        return self::OPTION_PREFIX;
    }

    /**
     * MoredealAiWriter 插件级别
     *
     * free: 免费版
     * plus: 高级版
     * pro: 专业版
     * @return string
     */
    public static function plugin_level(): string {
        // license key 不存在直接返回免费版
        $license_key = LicenseConfig::license_key();
        if ( empty( $license_key ) ) {
            return self::LEVEL_FREE;
        }

        if ( self::$level !== null ) {
            return self::$level;
        }

        $plus_file = self::plugin_path() . 'plus/PlusAutoLoader.php';
        $pro_file  = self::plugin_path() . 'pro/ProAutoLoader.php';

        // Pro 版本
        if ( file_exists( $pro_file ) && file_exists( $plus_file ) ) {
            self::$level = self::LEVEL_PRO;

            return self::$level;
        }

        // Plus 版本
        if ( file_exists( $plus_file ) && ! file_exists( $pro_file ) ) {
            self::$level = self::LEVEL_PLUS;

            return self::$level;
        }


        self::$level = self::LEVEL_FREE;

        return self::$level;
    }

    /**
     * 重置 MoredealAiWriter 插件级别
     *
     * @return void
     */
    public static function plugin_reset_level() {
        self::$level = null;
    }

    /**
     * 是否是免费版
     *
     * @return bool
     */
    public static function is_free(): bool {
        return self::plugin_level() === self::LEVEL_FREE;
    }

    /**
     * 是否是高级版
     *
     * @return bool
     */
    public static function is_plus(): bool {
        return self::plugin_level() === self::LEVEL_PLUS;
    }

    /**
     * 是否是专业版
     *
     * @return bool
     */
    public static function is_pro(): bool {
        return self::plugin_level() === self::LEVEL_PRO;
    }

    /**
     * 插件的全局 key
     *
     *  1.0 。
     *  ##只有在 pro 版本或者 plus 版本才会使用 license key，否则使用 account id
     *
     *  ##如果激活了授权码，但是还没有下载最新 pro 或着 plus 包进行覆盖，那么会使用 account id。
     *
     *  2.0
     *  只要有 LicenseConfig::license_key(); 就用 license_key, 只要激活，就用 license_key
     *
     * @param bool $force 是否强制刷新
     *
     * @return string
     */
    public static function plugin_key( bool $force = true ): string {

        $license_key = LicenseConfig::license_key();

        if ( ! empty( $license_key ) ) {
            return $license_key;
        }

//		$plus_file = self::plugin_path() . 'plus/PlusAutoLoader.php';
//		$pro_file  = self::plugin_path() . 'pro/ProAutoLoader.php';
//
//		$account = AccountManager::plugin_account( $force );
//
//		if ( ( file_exists( $pro_file ) && file_exists( $plus_file ) ) || ( file_exists( $plus_file ) && ! file_exists( $pro_file ) ) ) {
//			$license_key = LicenseConfig::license_key();
//			if ( ! empty( $license_key ) ) {
//				return $license_key;
//			}
//		}

        return AccountManager::plugin_account( $force );
    }

    /**
     * MoredealAiWriter 插件官网
     *
     * @return string
     */
    public static function official_website(): string {
        return self::OFFICIAL_WEBSITE;
    }

    /**
     * MoredealAiWriter 插件升级高级版地址
     *
     * @return string
     */
    public static function upgrade_url(): string {
        return self::UPGRADE_URL;
    }

    /**
     * MoredealAiWriter 插件文档地址
     *
     * @return string
     */
    public static function document_url(): string {
        return self::DOCUMENT_URL;
    }

    /**
     * MoredealAiWriter 插件联系我们地址
     *
     * @return string
     */
    public static function contact_us(): string {
        return self::CONTACT_US_URL;
    }

    /**
     * MoredealAiWriter 插件评价地址
     *
     * @return string
     */
    public static function review_url(): string {
        return self::PLUGIN_WORDPRESS_REVIEW_URL;
    }

    /**
     * 获取当前域名
     *
     * @return string
     */
    public static function current_domain(): string {
        $domain = parse_url( site_url(), PHP_URL_HOST );
        if ( ! empty( $domain ) ) {
            return $domain;
        }

        $domain = site_url();
        if ( ! empty( $domain ) ) {
            return $domain;
        }

        return '';
    }

    /**
     * MoredealAiWriter 插件路径
     *
     * @return string
     */
    public static function plugin_path(): string {
        return PLUGIN_PATH;
    }

    /**
     * MoredealAiWriter 插件 File
     *
     * @return string
     */
    public static function plugin_file(): string {
        return PLUGIN_FILE;
    }

    /**
     * MoredealAiWriter 插件基础名
     *
     * @return string
     */
    public static function plugin_basename(): string {
        return plugin_basename( self::plugin_file() );
    }

    /**
     * MoredealAiWriter 插件资源路径
     *
     * @return string
     */
    public static function plugin_res(): string {
        return PLUGIN_RES;
    }

    /**
     * MoredealAiWriter 聊天
     * @return string
     */
    public static function plugin_chat(): string {
        return PLUGIN_CHAT;
    }

    /**
     * MoredealAiWriter 插件资源路径
     * @return string
     */
    public static function plugin_wp_block(): string {
        return PLUGIN_WP_BLOCK;
    }

    /**
     * 翻译文本, 用于国际化. MoredealAiWriter 为插件的文本域
     *
     * @param string $message 待翻译文本
     *
     * @return string 翻译文本
     */
    public static function translation( string $message ): string {
        return __( $message, self::slug() );
    }

    /**
     * 显示已转义的翻译文本，以便在HTML输出中安全使用。 如果没有翻译，或者没有加载文本域，则会转义并显示原始文本。
     *
     * @param string $message
     *
     * @return void
     */
    public static function translation_e( string $message ) {
        esc_html_e( $message, self::slug() );
    }


}