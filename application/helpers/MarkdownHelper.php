<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\libs\markdown\Parsedown;

/**
 * markdown 工具类
 */
class MarkdownHelper {

    /**
     * markdown to html
     *
     * @param $content
     *
     * @return string
     */
    public static function markdown_to_html( $content ) {
        $parse_down = new Parsedown();

        return $parse_down->text( $content );
    }
}