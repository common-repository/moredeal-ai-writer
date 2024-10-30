<?php

namespace MoredealAiWriter\code\modules\util;

use Exception;

defined( '\ABSPATH' ) || exit;

/**
 * Open Ai 工具类
 */
class OpenAiUtil {


    /**
     * 处理结果
     *
     * @param array $complete
     * @param int   $max_result
     *
     * @return array | string
     * @throws Exception
     */
    public static function build_choice_result( array $complete, int $max_result = 1 ) {

        if ( $complete == null || count( $complete ) == 0 ) {
            throw new Exception( "Have an error, request result complete is null" );
        }

        if ( isset( $complete['error'] ) ) {
            $message = $complete['error']['message'];
            // If the message contains "Incorrect API key provided: THE_KEY.", replace the key by "----".
            if ( preg_match( '/API key provided(: .*)\./', $message, $matches ) ) {
                $message = str_replace( $matches[1], '', $message );
            }
            throw new Exception( $message );
        }

        if ( ! $complete['model'] ) {
            error_log( print_r( $complete, 1 ) );
            throw new Exception( "Got an unexpected response from OpenAI. Check your Error Logs." );
        }

        if ( empty( $complete['choices'] ) || ! is_array( $complete['choices'] ) ) {
            error_log( print_r( $complete, 1 ) );
            throw new Exception( 'Got an empty response form OpenAI. Check your Error Logs.' );
        }

        $result = array();
        if ( $max_result == 1 ) {
            return trim( $complete['choices'][0]['message']['content'] );
        }

        foreach ( $complete['choices'] as $choice ) {
            if ( isset( $choice['message'] ) ) {
                $content  = trim( $choice['message']['content'] );
                $result[] = array( "content" => $content, "index" => $choice["index"] );
            }
        }

        return $result;
    }

}