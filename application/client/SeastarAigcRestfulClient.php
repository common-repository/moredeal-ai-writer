<?php

namespace MoredealAiWriter\application\client;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\libs\rest\HttpClient;
use MoredealAiWriter\application\Plugin;

/**
 * SeaStar Aigc Restful Client
 *
 * @autor  Moredeal Ai Writer
 */
class SeastarAigcRestfulClient extends MoredealRestfulClient {

    /**
     * token header
     *
     * @var string
     */
    const MOREDEAL_AIGC_TOKEN = 'License-Authorization';

    /**
     * domain header
     *
     * @var string
     */
    const MOREDEAL_AIGC_DOMAIN = 'License-Domain';

    /**
     * 默认 host
     */
//    const DEFAULT_SEASTAR_HOST = 'http://192.168.0.37:8080/';
    const DEFAULT_SEASTAR_HOST = 'http://api-aigc.hotsalecloud.com';

    /**
     * 默认 api 前缀
     */
    const SEASTAR_API_URI_SUFFIX = '';

    /**
     * 不需要 token 的 api
     */
    const NOT_NEED_TOKEN_API = array( '/aigc/crateInitCode' );

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 请求 host
     * @return string host
     */
    public function host(): string {
        return self::DEFAULT_SEASTAR_HOST;
    }

    /**
     * 请求 api 前缀
     * @return string api 前缀
     */
    public function api_prefix(): string {
        return self::SEASTAR_API_URI_SUFFIX;
    }

    /**
     * 获取殷勤列表
     * @return array
     */
    public function list_engine(): array {
        error_log( 'list engine' );
        $result        = json_decode( $this->get( '/aigc/stability/listEngine', array() ), true );
        $error_message = "list engine error: Contact your administrator";

        return $this->build_result( $result, $error_message );
    }

    /**
     * 根据文字生成图片
     *
     * @param array $request
     *
     * @return array
     */
    public function generate_image_by_text( array $request ): array {
        $request = json_encode( $request );
        error_log( 'generate image by text: ' . $request );
        $result = json_decode( $this->post( '/aigc/stability/testToImage', $request ), true );

        $token = null;
        if ( ! empty( $result['paramMap'] && ! empty( $result['paramMap']['token'] ) ) ) {
            $token = $result['paramMap']['token'];
        }
        $error_message = "generate image by text error: Contact your administrator";
        $result        = $this->build_result( $result, $error_message );
        if ( ! empty( $token ) ) {
            $result['token'] = $token;
        }

        return $result;
    }


    public function chat_with_context( array $body ) {
        error_log( 'chat with context: ' . json_encode( $body ) );
        $result        = json_decode( $this->post( '/aigc/chat/context', json_encode( $body ) ), true );
        $error_message = "chat with context error: Contact your administrator";

        return $this->build_result( $result, $error_message );
    }


    public function chat_config( array $body ) {
        error_log( 'chat config: ' . json_encode( $body ) );
        $result        = json_decode( $this->post( '/aigc/chat/config', json_encode( $body ) ), true );
        $error_message = "chat config error: Contact your administrator";

        return $this->build_result( $result, $error_message );
    }

    public function chat_open() {
        $result        = json_decode( $this->get( '/aigc/chat/open', array() ), true );
        $error_message = "chat open error: Contact your administrator";

        return $this->build_result( $result, $error_message );
    }

    public function delete_config( string $configId ) {
        $result        = json_decode( $this->post( '/aigc/chat/delete/' . $configId ), true );
        $error_message = "delete config error: Contact your administrator";

        return $this->build_result( $result, $error_message );
    }

    /**
     * 请求前准备参数
     *
     * @param        $client HttpClient
     * @param string $path
     *
     * @return void
     * @throws Exception
     */
    protected function prepareHeaders( HttpClient $client, string $path = '' ) {
        $feature_path = explode( '?', $path );
        if ( count( $feature_path ) > 0 && in_array( $feature_path[0], self::NOT_NEED_TOKEN_API ) ) {
            $client->addHeader( self::MOREDEAL_AIGC_DOMAIN, Plugin::current_domain() );
            parent::prepareHeaders( $client, $path );
            error_log( 'Moredeal Ai Writer Not Need Token Request URL: ' . $client->getUri() );
            error_log( self::MOREDEAL_AIGC_DOMAIN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_DOMAIN ) ) );

            return;
        }

        // 需要添加 header token 和 domain 的接口
        $aigc_key = Plugin::plugin_key();
        if ( empty( $aigc_key ) ) {
            throw new Exception( Plugin::name() . Plugin::translation( ' Cant find your account id or license key. Please contact the administrator.' ) );
        }
        $client->addHeader( self::MOREDEAL_AIGC_TOKEN, $aigc_key );
        $client->addHeader( self::MOREDEAL_AIGC_DOMAIN, Plugin::current_domain() );
        parent::prepareHeaders( $client, $path );
        error_log( 'Moredeal Ai Writer Request URL: ' . $client->getUri() );
        error_log( self::MOREDEAL_AIGC_TOKEN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_TOKEN ) ) );
        error_log( self::MOREDEAL_AIGC_DOMAIN . ' Header: ' . json_encode( $client->getHeader( self::MOREDEAL_AIGC_DOMAIN ) ) );
        error_log( json_encode( $client->getHeaders() ) );
    }

}