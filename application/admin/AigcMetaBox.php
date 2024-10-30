<?php

namespace MoredealAiWriter\application\admin;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\Plugin;

/**
 * AigcMetaBox
 *
 * @author MoredealAiWriter
 */
class AigcMetaBox {

    /**
     * 单例实例
     * @var AigcMetaBox $instance 单例实例
     */
    private static $instance = null;

    /**
     * 获取单例实例
     * @return AigcMetaBox
     */
    public static function getInstance(): AigcMetaBox {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 构造函数
     */
    private function __construct() {
        add_action( 'add_meta_boxes', array( $this, "render_metadata_metabox" ) );
    }

    /**
     * 添加边栏的 meta box
     *
     * @return void
     */
    public function render_metadata_metabox() {
        if ( ! in_array( get_post_type(), array( 'page', 'post' ) ) ) {
            return;
        }
        add_meta_box( 'moredeal_aigc_meta_box', Plugin::translation( Plugin::name() ),
            array( $this, 'render_meta_box' ), null, 'side', 'high' );
    }

    /**
     * 渲染 meta box
     *
     * @return void
     */
    public function render_meta_box() {
        echo '<div id="moredeal-aigc-meta-box-side">Moredeal AI Writer</div>';
    }


}