<?php
/**
 * debugger 页面
 *
 * @package MoredealAiWriter
 */
defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\helpers\AdminHelper;
use MoredealAiWriter\application\Plugin;

?>

<div class="moredeal-maincol">
    <div class="wrap">
        <h2>
            <?php Plugin::translation_e( 'Moredeal AI Writer Debugger' ); ?>
            <?php if ( ! Plugin::is_free() ): ?>
                <span class="moredeal-label moredeal-label-pro"><?php Plugin::translation_e( Plugin::plugin_level() . ' ' . Plugin::version() ) ?></span>
            <?php else: ?>
                <a target="_blank" class="page-title-action"
                   href="<?php echo esc_url_raw( Plugin::upgrade_url() ); ?>"><?php Plugin::translation_e( 'Go Pro' ); ?></a>
            <?php endif; ?>
        </h2>

        <?php settings_errors(); ?>
        <?php if ( ! empty( $page_slug ) ): ?>
            <form action="options.php" method="POST">
                <?php settings_fields( $page_slug ); ?>
                <?php AdminHelper::doTabsSections( $page_slug ); ?>
                <?php submit_button(); ?>
            </form>
        <?php endif; ?>
    </div>
</div>
