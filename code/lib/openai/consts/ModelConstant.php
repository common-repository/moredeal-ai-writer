<?php

namespace MoredealAiWriter\code\lib\openai\consts;

defined( '\ABSPATH' ) || exit;

/**
 * ModelConstant
 *
 * @author MoredealAiWriter
 */
class ModelConstant {

    const model = [
        "ada" => 0.0004 / 1000,

        "babbage" => 0.0005 / 1000,

        "curie" => 0.0020 / 1000,

        "davinci" => 0.0200 / 1000,

        "gpt-3.5-turbo" => 0.002 / 1000,

        "1024x1024" => 0.0004 / 1000,

        "512x512" => 0.018,

        "256x256" => 0.016
    ];


    /**
     * 根据名称获取价格
     *
     * @param $name
     *
     * @return mixed
     */
    public static function getPriceByName( $name ) {
        foreach ( self::model as $key => $value ) {
            if ( str_contains( $name, $key ) ) {
                return $value;
            }
        }
        return 0;
    }

}
