<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

/**
 * Admin Helper 工具类
 *
 * @author MoredealAiWriter
 */
class AdminHelper {

    /**
     * 渲染选项Tab页面
     *
     * @param $page
     *
     * @return void
     */
    public static function doTabsSections( $page ) {
        global $wp_settings_sections;

        if ( ! isset( $wp_settings_sections[ $page ] ) ) {
            return;
        }

        echo '<div id="moredeal-tabs">';
        echo '<ul>';
        $i = 1;
        foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
            echo '<li><a href="#tabs-' . esc_attr( $i ) . '">' . esc_html( $section['title'] ) . '</a></li>';
            $i ++;
        }
        echo '</ul>';
        $i = 1;
        foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
            echo '<div id="tabs-' . esc_attr( $i ) . '">';
            echo '<table class="form-table" role="presentation">';
            do_settings_fields( $page, $section['id'] );
            echo '</table>';
            echo '</div>';
            $i ++;
        }
        echo '</div>';
        echo '<script type="text/javascript">' . 'jQuery(document).ready(function($){$(\'#moredeal-tabs\').tabs();});' . '</script>';
    }

}