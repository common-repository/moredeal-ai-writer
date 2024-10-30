<?php

namespace MoredealAiWriter\application\components;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\admin\LicenseConfig;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\libs\rest\HttpRestfulClient;
use MoredealAiWriter\application\Plugin;

/**
 * Update 管理类
 *
 * @author MoredealAiWriter
 */
class UpdateManager {

    /**
     * 版本文件地址
     */
    const VERSION_URL = 'https://download.hotsalecloud.com/wp-plugins/version/aigc.version.txt';

    /**
     * 允许下载的版本
     */
    const ALLOWED_LEVEL = array( 'pro', 'plus' );

    /**
     * 版本文件地址
     *
     * @return string
     */
    public static function version_url(): string {
        return self::VERSION_URL;
    }

    /**
     * 允许下载的版本
     *
     * @return array
     */
    public static function allowed_level(): array {
        return self::ALLOWED_LEVEL;
    }

    /**
     * 获取下载链接
     *
     * @return string|false
     */
    public static function download_url( string $level ) {

        // 授权
        if ( empty( LicenseConfig::license_key() ) ) {
            return false;
        }

        // 级别
        if ( ! in_array( $level, self::allowed_level() ) ) {
            return false;
        }

        // 最新版本
        $last_version = self::latest_version( $level );
        if ( ! $last_version ) {
            return false;
        }

        // 下载链接
        $download_link = self::download_link( $last_version, $level );
        if ( ! $download_link ) {
            return false;
        }

        return $download_link;
    }

    /**
     * 获取最新版本号
     *
     * @return string|false
     */
    public static function latest_version( $level ) {

        $remote_version_list = self::remote_version_list();
        if ( empty( $remote_version_list ) ) {
            return false;
        }

        // 循环截取以 $level 结尾的版本号，组成一个新数组
        $version_list = array();
        foreach ( $remote_version_list as $version ) {
            if ( str_ends_with( $version, $level ) ) {
                $version_explode = explode( '-', $version );
                if ( count( $version_explode ) > 0 && ! empty( $version_explode[0] ) ) {
                    $version_list[] = $version_explode[0];
                }
            }
        }
        $version_list = array_unique( $version_list );
        // 版本号升序排序
        usort( $version_list, 'version_compare' );
        // 获取最新版本号
        $last_version = end( $version_list );
        if ( ! $last_version ) {
            return false;
        }

        return $last_version;
    }

    /**
     * 获取远程最新版集合
     *
     * @return array|false 版本号集合，错误时候返回false
     */
    public static function remote_version_list() {

        $response = wp_remote_get( self::version_url() );
        if ( is_wp_error( $response ) ) {
            return false;
        }

        $response_code = (int) wp_remote_retrieve_response_code( $response );
        if ( $response_code != 200 && $response_code != 206 ) {
            return false;
        }

        $version_text = wp_remote_retrieve_body( $response );
        if ( ! $version_text ) {
            return false;
        }

        $version_list = explode( "\n", $version_text );
        if ( empty( $version_list ) || ! is_array( $version_list ) || count( $version_list ) <= 0 ) {
            return false;
        }

        return $version_list;
    }

    /**
     * 获取远程信息
     *
     * @return false|string
     */
    public static function download_link( string $latest, string $level ) {
        $file_name = $latest . '-' . $level;
        $remote    = self::remote_client();
        $result    = json_decode( $remote->post( "/stage-api/aigc/oss/down/sdk?fileName=" . $file_name ), true );
        $result    = $remote->build_result( $result, 'GET DOWNLOAD LINK FAIL' );
		error_log("params: " . $file_name . " . result: " . json_encode($result));
        if ( ! empty( $result['success'] ) && ! empty( $result['data'] ) ) {
            return $result['data'];
        }

        return false;
    }

    /**
     * 获取远程客户端
     *
     * @return HttpRestfulClient
     */
    private static function remote_client(): HttpRestfulClient {
        $httpRestfulClient = new HttpRestfulClient();
        $httpRestfulClient->setUri( SeastarRestfulClient::DEFAULT_SEASTAR_HOST );
        $httpRestfulClient->addHeader( 'Content-Type', 'multipart/form-data' );
        $httpRestfulClient->addHeader( 'Accept-Encoding', 'gzip, deflate, br' );
        $httpRestfulClient->addHeader( SeastarRestfulClient::MOREDEAL_AIGC_TOKEN, LicenseConfig::license_key() );
        $httpRestfulClient->addHeader( SeastarRestfulClient::MOREDEAL_AIGC_DOMAIN, Plugin::current_domain() );

        return $httpRestfulClient;
    }

}