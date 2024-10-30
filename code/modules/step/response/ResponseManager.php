<?php

namespace MoredealAiWriter\code\modules\step\response;

defined( '\ABSPATH' ) || exit;

use Exception;

/**
 * 响应管理
 *
 * @author MoredealAiWriter
 */
class ResponseManager {

    /**
     * 根据类型获取响应
     *
     * @param $response
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryByKey( $response ) {

        if ( empty( $response ) ) {
            throw new Exception( 'response is required' );
        }

        if ( ! isset( $response->key ) ) {
            throw new Exception( 'response key type is required' );
        }

        $response_base_class = 'MoredealAiWriter\\code\\modules\\step\\response\\' . $response->key;
        if ( class_exists( $response_base_class ) ) {
            /**
             * @var AbstractResponseModule $response_base_class
             */
            try {
                $base_response = $response_base_class::factoryObject( $response );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $base_response;
        }

        $response_ext_class = 'MoredealAiWriter\\extend\\modules\\step\\response\\' . $response->key;
        if ( class_exists( $response_ext_class ) ) {
            try {
                $ext_response = $response_ext_class::factoryObject( $response );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_response;
        }
        throw new Exception( $response->key . ' response type is not exist' );

    }
}