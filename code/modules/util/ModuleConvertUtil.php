<?php

namespace MoredealAiWriter\code\modules\util;

defined( '\ABSPATH' ) || exit;

/**
 * 模块转换工具
 *
 * Class ModuleConvertUtil
 *
 * @author MoredealAiWriter
 */
class ModuleConvertUtil {

    /**
     * 需要转换为int的字段
     */
    const NEED_CONVERT_INT = array( 'id', 'status', 'is_delete', 'order' );

    /**
     * 基础通用对象转换
     *
     * @param $source object 源对象
     * @param $target
     *
     * @return mixed
     */
    public static function convert( $target, $source ) {
        if ( is_array( $source ) ) {
            $source = (object) $source;
        }
        foreach ( $source as $key => $value ) {
            if ( property_exists( $target, $key ) ) {
                if ( in_array( $key, self::NEED_CONVERT_INT ) ) {
                    $value = intval( $value );
                }
                $target->$key = $value;
            }
        }

        return $target;

    }

}