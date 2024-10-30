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
class FileConvertUtil {


    /**
     * 基础通用对象转换
     *
     * @param $source object 源对象
     * @param $target
     *
     * @return mixed
     * @throws \Exception
     */
    public static function encode( $urls ) {

        $files = [];
        foreach ( $urls as $index => $url ) {

            if ( ! key_exists( "url", $url ) ) {
                throw new \Exception( "UrlConvertUtil encode is fail" . json_encode( $urls ) );
            } else {

                $files[] = new FileVariable( $url['url'] );
            }
        }

        return $files;
    }


    /**
     * @param $std
     *
     * @return array{FileVariable}
     * @throws \Exception
     */
    public static function decode( $std ): array {

        $files = [];

        if ( is_string( $std ) ) {
            $std = json_decode( $std );
        }

        foreach ( $std as $file ) {

            if ( ! isset( $file->url ) ) {
                throw new \Exception( "UrlConvertUtil decode is fail" . json_encode( $file ) );
            } else {
                $files[] = new FileVariable( $file->url, $file->fileName );
            }
        }

        return $files;
    }


}


class FileVariable {

    public $url;

    public $fileName;

    /**
     * @param        $url
     * @param string $fileName
     */
    public function __construct( $url, string $fileName = "" ) {
        $this->url      = $url;
        $this->fileName = $fileName;
    }

}