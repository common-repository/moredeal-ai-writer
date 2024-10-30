<?php

namespace MoredealAiWriter\application\notice;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\Plugin;
use const LoginCustomizer\Includes\LOGINCUST_FREE_URL;

/**
 * Moredeal Ai Writer 通知配置
 */
class ReviewNotice {

    /**
     * WordPress Nonce 标识
     */
    const WP_NONCE = '_wpnonce';

    /**
     * Moredeal Ai Writer 通知随机数标识
     *
     * @var string
     */
    const MOREDEAL_AIGC_REVIEW_NOTICE_NONCE = 'moredeal_aigc_review_notice_nonce';

    /**
     * Moredeal Ai Writer 通知不再显示标识
     *
     * @var string
     */
    const MOREDEAL_AIGC_REVIEW_NOTICE_DISMISS = 'moredeal_aigc_review_notice_dismiss';

    /**
     * Moredeal Ai Writer 通知稍后显示标识
     *
     * @var string
     */
    const MOREDEAL_AIGC_REVIEW_NOTICE_LATER = 'moredeal_aigc_review_notice_later';

    /**
     * Moredeal Ai Writer 通知激活时间标识
     *
     * @var string
     */
    const MOREDEAL_AIGC_REVIEW_NOTICE_ACTIVE_TIME = 'moredeal_aigc_review_notice_active_time';

    /**
     * Moredeal Ai Writer Review Notice 实例
     *
     * @var null
     */
    private static $instance = null;

    /**
     * 获取实例
     *
     * @return ReviewNotice
     */
    public static function getInstance(): ReviewNotice {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 构造函数
     */
    private function __construct() {

    }

    /**
     * 初始化
     *
     * @return void
     */
    public function admin_init() {
        add_action( 'admin_init', array( $this, 'moredeal_aigc_review_notice' ) );
    }

    /**
     * Moredeal Ai Writer 通知
     *
     * @return void
     */
    public function moredeal_aigc_review_notice() {
        // 通知不再显示
        $this->moredeal_aigc_review_notice_dismissal();
        // 通知稍后显示
        $this->moredeal_aigc_review_notice_pending();

        $activation_time  = get_site_option( self::review_notice_active_time() );
        $review_dismissal = get_site_option( self::review_notice_dismiss() );

        // 如果点击了不再显示，则不再显示
        if ( 'yes' == $review_dismissal ) {
            return;
        }

        // 如果没有激活时间，则设置激活时间
        if ( ! $activation_time ) {
            $activation_time = time();
            add_site_option( self::review_notice_active_time(), $activation_time );
        }

        // 如果激活时间大于7天，则显示通知 604800
        if ( time() - $activation_time > 604800 ) {
            // 加载样式
            wp_enqueue_style( 'moredeal_aigc_review_notification_style', Plugin::plugin_res() . '/css/notice.css', array(), Plugin::script_version() );
            // 添加通知
            add_action( 'admin_notices', array( $this, 'moredeal_aigc_review_notice_message' ) );
        }
    }

    /**
     * 检查是否点击了不再显示
     *
     * @return void
     */
    private function moredeal_aigc_review_notice_dismissal() {

        if ( ! is_admin() ||
             ! current_user_can( 'manage_options' ) ||
             ! isset( $_GET[ self::wp_nonce() ] ) ||
             ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET[ self::wp_nonce() ] ) ), self::review_notice_nonce() ) ||
             ! isset( $_GET[ self::review_notice_dismiss() ] ) ) {

            return;
        }
        // 设置不再显示
        add_site_option( self::review_notice_dismiss(), 'yes' );

        // 重定向到当前页面
        $current_url = $_SERVER['REQUEST_URI'];
        $current_url = remove_query_arg( self::wp_nonce(), $current_url );
        $current_url = remove_query_arg( self::review_notice_dismiss(), $current_url );
        wp_safe_redirect( $current_url );
    }

    /**
     * 检查是否点击了稍后显示，如果点击了，则重置激活时间
     *
     * @return void
     */
    function moredeal_aigc_review_notice_pending() {

        if ( ! is_admin() ||
             ! current_user_can( 'manage_options' ) ||
             ! isset( $_GET[ self::wp_nonce() ] ) ||
             ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET[ self::wp_nonce() ] ) ), self::review_notice_nonce() ) ||
             ! isset( $_GET[ self::review_notice_later() ] ) ) {


            return;
        }
        // 重置激活时间
        update_site_option( self::review_notice_active_time(), time() );

        // 重定向到当前页面
        $current_url = $_SERVER['REQUEST_URI'];
        $current_url = remove_query_arg( self::wp_nonce(), $current_url );
        $current_url = remove_query_arg( self::review_notice_later(), $current_url );
        wp_safe_redirect( $current_url );
    }

    /**
     * 渲染通知
     *
     * @return void
     */
    public function moredeal_aigc_review_notice_message() {

        $scheme       = ( wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) ) ? '&' : '?';
        $dismiss_link = $_SERVER['REQUEST_URI'] . $scheme . self::review_notice_dismiss() . '=yes';
        $dismiss_url  = wp_nonce_url( $dismiss_link, self::review_notice_nonce() );

        $later_link = $_SERVER['REQUEST_URI'] . $scheme . self::review_notice_later() . '=yes';
        $later_url  = wp_nonce_url( $later_link, self::review_notice_nonce() );

        ?>
        <div class="moredeal-aigc-review-notice">
            <div class="moredeal-aigc-review-thumbnail">
                <img src="<?php echo Plugin::plugin_res() . '/images/moredeal_ai_writer.png' ?>" alt="cant load images">
            </div>
            <div class="moredeal-aigc-review-text">
                <h3><?php Plugin::translation_e( 'Leave A Review ?' ) ?></h3>
                <p><?php Plugin::translation_e( "We hope you've enjoyed using Moredeal AI Writer! Would you consider leaving us a review on WordPress.org ?" ) ?></p>
                <ul class="moredeal-aigc-review-ul">
                    <li>
                        <a href="<?php echo Plugin::review_url() ?>" target="_blank">
                            <span class="dashicons dashicons-external"></span>
                            <?php Plugin::translation_e( "Sure, I'd Love To" ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $dismiss_url ?>">
                            <span class="dashicons dashicons-smiley"></span>
                            <?php Plugin::translation_e( "I've Already Left A Review" ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $later_url ?>">
                            <span class="dashicons dashicons-calendar-alt"></span>
                            <?php Plugin::translation_e( 'Maybe Later' ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $dismiss_url ?>">
                            <span class="dashicons dashicons-dismiss"></span>
                            <?php Plugin::translation_e( 'Never Show Again' ); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * WP NONCE 标识
     *
     * @return string
     */
    public static function wp_nonce(): string {
        return self::WP_NONCE;
    }

    /**
     * Moredeal Ai Writer 通知随机数标识
     *
     * @return string
     */
    public static function review_notice_nonce(): string {
        return self::MOREDEAL_AIGC_REVIEW_NOTICE_NONCE;
    }

    /**
     * Moredeal Ai Writer 通知不再显示标识
     *
     * @return string
     */
    public static function review_notice_dismiss(): string {
        return self::MOREDEAL_AIGC_REVIEW_NOTICE_DISMISS;
    }

    /**
     * Moredeal Ai Writer 通知稍后显示标识
     *
     * @return string
     */
    public static function review_notice_later(): string {
        return self::MOREDEAL_AIGC_REVIEW_NOTICE_LATER;
    }

    /**
     * Moredeal Ai Writer 通知激活时间标识
     *
     * @return string
     */
    public static function review_notice_active_time(): string {
        return self::MOREDEAL_AIGC_REVIEW_NOTICE_ACTIVE_TIME;
    }
}
