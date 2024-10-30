<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

/**
 * Class TextHelper
 *
 * @author MoredealAiWriter
 */
class TextHelper {

    /**
     * 清除字符串中的非法字符
     *
     * @param string $str
     *
     * @return string
     */
    public static function clear( string $str ): string {
        if ( empty( $str ) ) {
            return "";
        }

        return preg_replace( '/[^a-zA-Z0-9_]/', '', $str );
    }

    /**
     * 清理文本
     *
     * @param string $rawText
     *
     * @return string
     */
    public static function clean_text( string $rawText = "" ): string {
        $text = html_entity_decode( $rawText );
        $text = wp_strip_all_tags( $text );
        $text = preg_replace( '/[\r\n]+/', "\n", $text );

        return $text . " ";
    }

    /**
     * 确保没有重复的句子，并将长度控制在最大长度以下。
     *
     * @param string $text
     * @param int    $max_tokens
     *
     * @return string
     */
    public static function clean_sentences( string $text, int $max_tokens = 512 ): string {
        $sentences       = preg_split( '/(?<=[.?!。．！？])+/u', $text );
        $hashes          = array();
        $uniqueSentences = array();
        $length          = 0;
        foreach ( $sentences as $sentence ) {
            $sentence = preg_replace( '/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $sentence );
            $hash     = md5( $sentence );
            if ( ! in_array( $hash, $hashes ) ) {
                $tokensCount = apply_filters( 'mwai_estimate_tokens', 0, $sentence );
                if ( $length + $tokensCount > $max_tokens ) {
                    continue;
                }
                $hashes[]          = $hash;
                $uniqueSentences[] = $sentence;
                $length            += $tokensCount;
            }
        }
        $freshText = implode( " ", $uniqueSentences );

        return preg_replace( '/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $freshText );
    }


}