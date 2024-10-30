<?php

namespace MoredealAiWriter\application\libs\rest;

defined( '\ABSPATH' ) || exit;

use Exception;

/**
 * rest 客户端
 * MoredealRestClient class file
 *
 * @author MoredealAiWriter
 */
class HttpRestfulClient {

    /**
     * http 路径前缀
     */
    const HTTP = 'http://';

    /**
     * https 路径前缀
     */
    const HTTPS = 'https://';

    /**
     * timeout
     * @var int 超时时间
     */
    const TIMEOUT = 120;

    /**
     * User Agent
     * @var string  User Agent
     */
    const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.41';

    /**
     * @var string
     */
    const SSL_VERIFY = false;

    /**
     * @var int
     */
    const REDIRECTION = 5;

    /**
     * 默认Content-Type
     *
     * @var string
     */
    const JSON_TYPE = 'application/json;charset=UTF-8';

    const FILE_TYPE = 'multipart/form-data';

    /**
     * http client object
     * @var HttpClient|null
     */
    protected static $httpClient = null;
    /**
     * Endpoint uri of this web service
     * @var string|null $_uri
     */
    protected $uri = null;
    /**
     * 返回类型
     * @var String|null Return Type
     */
    protected $responseType = null;
    /**
     * 返回类型 array
     * @var array Response Format Types
     */
    protected $responseTypes = array( 'json', 'xml', 'html', 'text' );
    /**
     * 请求头部
     * @var array
     */
    protected $headers = array();

    /**
     * 构造器
     *
     * @param string|null $uri
     */
    public function __construct( string $uri = null ) {
        if ( ! empty( $uri ) ) {
            $this->setUri( $uri );
        }
    }

    /**
     * 获取响应类型
     *
     * @return string|null
     */
    public function getResponseType() {
        return $this->responseType;
    }

    /**
     * 设置响应类型
     *
     * @param string $responseType
     *
     * @throws Exception
     */
    public function setResponseType( string $responseType = 'json' ) {
        if ( ! in_array( $responseType, $this->responseTypes, true ) ) {
            throw new Exception( 'Invalid Response Type' );
        }
        $this->responseType = $responseType;
    }

    /**
     * 添加请求头部
     *
     * @param array $headers
     *
     * @return void
     */
    public function addHeaders( array $headers = array() ) {
        if ( ! empty( $headers ) ) {
            foreach ( $headers as $name => $value ) {
                $this->addHeader( $name, $value );
            }
        }
    }

    /**
     * 添加请求头部
     *
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function addHeader( string $name, string $value ) {
        if ( empty( $name ) ) {
            return;
        }
        if ( empty( $value ) ) {
            return;
        }
        $this->headers[ $name ] = trim( $value );
    }

    /**
     * 根据名称获取具体请求头
     *
     * @param $name string 请求头的名称
     *
     * @return string|null 请求头的值
     */
    public function getHeader( string $name ) {
        if ( ! empty( $this->headers[ $name ] ) ) {
            return $this->headers[ $name ];
        }

        return self::getHttpClient()->getHeader( $name );
    }

    /**
     * 获取用于请求的 HTTP 客户端对象。如果未设置任何设置，则将使用默认 HttpClient。
     *
     * @param $options array 选项
     *
     * @return HttpClient|null
     */
    public static function getHttpClient( array $options = array() ) {
        $_opts = array(
            'timeout'     => self::TIMEOUT,
            'ssl_verify'  => self::SSL_VERIFY,
            'redirection' => self::REDIRECTION,
            'user_agent'  => self::USER_AGENT,
        );
        if ( $options ) {
            $_opts = array_merge( $_opts, $options );
        }
        if ( self::$httpClient == null ) {
            self::$httpClient = new HttpClient();
            self::$httpClient->addHeader( 'Accept-Charset', 'ISO-8859-1,utf-8' );
            self::$httpClient->setTimeout( $_opts['timeout'] );
            self::$httpClient->setRedirection( $_opts['redirection'] );
            self::$httpClient->setSslVerify( $_opts['ssl_verify'] );
            self::$httpClient->setUserAgent( $_opts['user_agent'] );
        }

        return self::$httpClient;
    }

    /**
     * 设置用于请求的 HTTP 客户端对象。如果未设置任何设置，则将使用默认 HttpClient。
     *
     * @param HttpClient $httpClient
     */
    public static function setHttpClient( HttpClient $httpClient ) {
        self::$httpClient = $httpClient;
    }

    /**
     * 获取所有请求头
     *
     * @return array 请求头数组
     */
    public function getHeaders(): array {
        return array_merge( self::getHttpClient()->getHeaders(), $this->headers );
    }

    /**
     * get 请求
     *
     * @param            $path
     * @param array|null $query
     *
     * @return string
     */
    public final function get( $path, array $query = null ): string {
        try {
            return $this->requestGet( $path, $query );
        } catch ( Exception $e ) {
            return json_encode( $this->failure( $e->getMessage() ) );
        }
    }

    /**
     * Get 请求
     *
     * @param string     $path
     * @param array|null $query Array of GET parameters
     * @param array      $opts
     *
     * @return string
     * @throws Exception
     */
    public function requestGet( string $path, array $query = null, array $opts = array() ): string {
        $client = self::getHttpClient( $opts );
        $this->prepareRest( $client, $path, HttpClient::GET, $query );

        return $this->result( $client->request( HttpClient::GET ) );
    }

    /**
     * 准备请求
     *
     * @param HttpClient $client 请求客户端
     * @param string     $path 请求路径
     * @param string     $method 请求方法
     * @param null       $data 请求数据
     *
     * @return void
     */
    private function prepareRest( HttpClient $client, string $path, string $method = HttpClient::GET, $data = null ) {
        // 重置请求参数, 包括请求头和请求体
        $client->resetParameters();
        // 设置请求 URL
        $client->setUri( $this->parsePath( $path ) );
        // 处理请求头
        $this->prepareHeaders( $client, $path );
        // 处理请求参数
        $this->prepareRequest( $client, $path, $method, $data );
    }

    /**
     * 处理请求路径
     *
     * @param string $path
     *
     * @return string
     */
    protected function parsePath( string $path ): string {
        if ( str_starts_with( $path, self::HTTP ) || str_starts_with( $path, self::HTTPS ) ) {
            $uri = $path;
        } else {
            $uri = $this->getUri();
            if ( $path && $path[0] != '/' && $uri[ strlen( $uri ) - 1 ] != '/' ) {
                $path = '/' . $path;
            }
            $uri = $uri . $path;
        }

        return $uri;
    }

    /**
     * 获取请求 URL
     * @return string|null
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * 设置请求 URL
     *
     * @param $uri
     *
     * @return void
     */
    public function setUri( $uri ) {
        $this->uri = $uri;
    }

    /**
     * 准备请求头
     *
     * @param HttpClient $client
     * @param string     $path
     *
     * @return void
     */
    protected function prepareHeaders( HttpClient $client, string $path ) {
        if ( isset( $this->headers['Content-Type'] ) || empty( $this->headers['Content-Type'] ) ) {
            $this->headers['Content-Type'] = self::JSON_TYPE;
        }
        foreach ( $this->headers as $name => $value ) {
            $client->addHeader( $name, $value );
        }
    }

    /**
     * 准备请求
     *
     * @param HttpClient $client
     *
     * @param string     $path
     * @param string     $method
     * @param null       $data
     *
     * @return void
     */
    protected function prepareRequest( HttpClient $client, string $path, string $method = HttpClient::GET, $data = null ) {
        if ( $method == HttpClient::GET ) {
            $client->setParameterGet( $data );
        }
        if ( $method == HttpClient::POST ) {
            if ( is_string( $data ) ) {
                $client->setRawData( $data );
            } elseif ( is_array( $data ) || is_object( $data ) ) {
                $client->setParameterPost( (array) $data );
            }
        }
    }

    /**
     * @param $response
     *
     * @return string
     * @throws Exception
     */
    protected function result( $response ): string {
        if ( is_wp_error( $response ) ) {
            $error_mess = "HTTP request fails: " . $response->get_error_code() . " - " . $response->get_error_message() . '.';
            throw new Exception( $error_mess );
        }

        $this->exceptionHandler( $response );

        return wp_remote_retrieve_body( $response );
    }

    /**
     * @param $response
     *
     * @return void
     * @throws Exception
     */
    protected function exceptionHandler( $response ) {
        $response_code = (int) wp_remote_retrieve_response_code( $response );
        if ( $response_code != 200 && $response_code != 206 ) {
            $response_message = wp_remote_retrieve_response_message( $response );
            $body             = wp_remote_retrieve_body( $response );
            $error_mess       = "HTTP request status fails: " . $response_code . " - " . $response_message . '. Server replay: ' . $body;
            error_log( $error_mess );
            if ( neve_is_json( $body ) ) {
                $body = json_decode( $body, true );
                if ( isset( $body['message'] ) ) {
                    throw new Exception( $body['message'], $response_code );
                }
                if ( isset( $body['error'] ) ) {
                    throw new Exception( $body['error'], $response_code );
                }
                if ( isset( $body['msg'] ) ) {
                    throw new Exception( $body['msg'], $response_code );
                }
                if ( isset( $body['errorMessage'] ) ) {
                    throw new Exception( $body['errorMessage'], $response_code );
                }
            }

            throw new Exception( $error_mess, $response_code );
        }
    }

    /**
     * 响应失败
     *
     * @param string $message
     * @param null   $data
     *
     * @return array
     */
    public function failure( string $message = '', $data = null ): array {
        return array(
            'success' => false,
            'message' => $message,
            'data'    => $data
        );
    }

    /**
     * post 请求
     *
     * @param string      $path 请求路径
     * @param             $data mixed|null 请求数据
     * @param array       $opts 额外参数
     *
     * @return string 请求结果
     */
    public final function post( string $path, $data = null, array $opts = array() ): string {
        try {
            return $this->requestPost( $path, $data, $opts );
        } catch ( Exception $e ) {
            return json_encode( $this->failure( $e->getMessage() ) );
        }
    }

    /**
     * post 请求
     *
     * @param string     $path 请求路径
     * @param mixed|null $data 请求数据
     * @param array      $opts 额外参数
     *
     * @return string 请求结果
     * @throws Exception 请求异常
     */
    public function requestPost( string $path, $data = null, array $opts = array() ): string {
        $client = self::getHttpClient( $opts );
        $this->prepareRest( $client, $path, HttpClient::POST, $data );

        return $this->result( $client->request( HttpClient::POST ) );
    }

    /**
     * 请求后处理
     *
     * @param        $result mixed 请求结果
     * @param string $default_error_message 默认错误信息
     * @param string $success_message 成功信息
     * @param bool   $is_page_result 是否分页结果
     *
     * @return array
     */
    public function build_result( $result, string $default_error_message = '', string $success_message = '', bool $is_page_result = false ): array {

        if ( $result == null ) {
            return $this->failure( $default_error_message );
        }

        /*
         * 1. 请求失败
         */
        if ( ! empty( $result['code'] ) && $result['code'] != 200 ) {
            return $this->failure( ! empty( $result['msg'] ) ? $result['msg'] : $default_error_message );
        }

        /*
         * 2. 请求成功
         */
        if ( ! empty( $result['success'] ) ) {
            // 分页结果
            if ( $is_page_result ) {
                return $result;
            }

            // 非分页结果
            return $this->success( $result['data'], $success_message );
        }

        /*
         * 3. 请求失败
         */
        // 分页结果
        if ( $is_page_result ) {
            if ( empty( $result['message'] ) ) {
                $result['message'] = $default_error_message;
            }

            return $result;
        }

        error_log( $result['message'] );
        if ( ! empty( $result['message'] ) ) {
            return $this->failure( $result['message'] );
        }
        $message = ! empty( $result['errorMessage'] ) ? $result['errorMessage'] : $default_error_message;
        $data    = ! empty( $result['data'] ) ? $result['data'] : null;

        return $this->failure( $message, $data );
    }

    /**
     * 响应成功
     *
     * @param        $data
     * @param string $message
     *
     * @return array
     */
    public function success( $data = null, string $message = '' ): array {
        return array(
            'success' => true,
            'message' => $message,
            'data'    => $data
        );
    }


}