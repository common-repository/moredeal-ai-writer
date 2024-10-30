<?php
/*
  Name: Template By Key
 */

use MoredealAiWriter\application\Plugin;

defined( '\ABSPATH' ) || exit;

$model      = $template_model ?? array();
$divId      = $div_id ?? uniqid( 'moredeal_ai_writer_template_' );
//wp_register_script( 'moredeal_aigc_template_index_script', Plugin::plugin_res() . '/admin/template/index.js', array( 'moredeal_aigc_template_vendor_script' ), Plugin::script_version(), true );
//wp_localize_script( 'moredeal_aigc_template_index_script', 'MOREDEAL_AIGC_TEMPLATE', array(
//    'level'         => Plugin::md_ai_writer_level(),
//    'model'         => $model,
//    'dark'          => $dark ?? false,
//    'templateId'    => $templateId,
//    'divId'         => $divId,
//    'wpRestUrl'     => rest_url(),
//    'wpRestNonce'   => wp_create_nonce( 'wp_rest' ),
//    'imagesPath'    => Plugin::plugin_res() . '/images/',
//    'lang'        => get_locale(),
//    'localeMessage' => array(),
//) );
//wp_enqueue_script( 'moredeal_aigc_template_index_script' );
?>

<?php if ( $title ?? '' ): ?>
    <h3 class="moredeal-shortcode-title"><?php echo esc_html( $title ?? '' ); ?></h3>
<?php endif; ?>
<!-- 渲染区域 -->
<div id="<?php echo $divId ?>"> My Template Coming Soon </div>
