<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use Exception;

/**
 * 变量管理
 *
 * @author MoredealAiWriter
 */
class VariableManager {

    /**
     * 根据类型获取步骤
     *
     * @param $variable
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryByKey( $variable ) {

        if ( empty( $variable ) ) {
            throw new Exception( 'variable is required' );
        }

        if ( ! isset( $variable->key ) ) {
            // 目前只有一个类型变量类型，如果不传入直接用 TextVariableModule
            $variable->key = TextVariableModule::getModuleKey();
            // throw new Exception( 'variable key type is required' );
        }

        $variable_base_class = 'MoredealAiWriter\\code\\modules\\variable\\' . $variable->key;
        if ( class_exists( $variable_base_class ) ) {
            /**
             * @var AbstractVariableModule $variable_base_class
             */
            try {
                $base_variable = $variable_base_class::factoryObject( $variable );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $base_variable;
        }

        $variable_ext_class = 'MoredealAiWriter\\extend\\modules\\variable\\' . $variable->key;
        if ( class_exists( $variable_ext_class ) ) {
            try {
                $ext_variable = $variable_ext_class::factoryObject( $variable );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_variable;
        }
        throw new Exception( $variable->key . ' variable type is not exist' );
    }

}