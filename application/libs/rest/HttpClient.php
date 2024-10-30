<?php

namespace MoredealAiWriter\application\libs\rest;

defined( '\ABSPATH' ) || exit;

use Exception;
use WP_Error;

/**
 * MoredealHttpClient class file
 * http 客户端工具类
 *
 * @author MoredealAiWriter
 */
class HttpClient {

    /**
     * GET 请求
     *
     * @var string GET
     */
    const GET = 'GET';

    /**
     * POST 请求
     *
     * @var string POST
     */
    const POST = 'POST';

    /**
     * PUT 请求
     *
     * @var string PUT
     */
    const PUT = 'PUT';

    /**
     * HEAD 请求
     *
     * @var string HEAD
     */
    const HEAD = 'HEAD';

    /**
     * DELETE 请求
     *
     * @var string DELETE
     */
    const DELETE = 'DELETE';

    /**
     * TRACE 请求
     *
     * @var string TRACE
     */
    const TRACE = 'TRACE';

    /**
     * OPTIONS 请求
     *
     * @var string OPTIONS
     */
    const OPTIONS = 'OPTIONS';

    /**
     * CONNECT 请求
     *
     * @var string CONNECT
     */
    const CONNECT = 'CONNECT';

    /**
     * POST data encoding methods form 表单
     *
     * @var string application/x-www-form-urlencoded
     */
    const ENC_URLENCODED = 'application/x-www-form-urlencoded';
    /**
     * Request URI
     *
     * @var string|null
     */
    protected $uri;
    /**
     * request headers 请求头
     *
     * @var array 请求头
     */
    protected $headers = array();
    /**
     * HTTP request method
     *
     * @var string 请求方法
     */
    protected $method = self::GET;
    /**
     * GET 请求参数数组
     *
     * @var array GET 请求参数数组
     */
    protected $paramsGet = array();
    /**
     * Post 请求参数数组
     *
     * @var array POST 请求参数数组
     */
    protected $paramsPost = array();
    /**
     * The raw post data to send. Could be set by setRawData($data, $enctype).
     *
     * @var string|null
     */
    protected $raw_post_data = null;
    /**
     * response
     *
     * @var array|null|WP_Error
     */
    protected $response = null;
    /**
     * 超时时间
     * @var int|null
     */
    private $timeout = 10;
    /**
     * 是否验证 SSL
     * @var bool|null
     */
    private $ssl_verify = false;
    /**
     * User agent
     *
     * @var string|null
     */
    private $user_agent = null;
    /**
     * Redirection
     *
     * @var int|null
     */
    private $redirection = 5;

    /**
     * 获取请求的 URI
     * Get the URI for the next request
     *
     * @return string 请求的 URI
     */
    public function getUri(): string {
        return $this->uri;
    }

    /**
     * 设置请求的 URI
     * Set the URI for the next request
     *
     * @param string $uri 请求的 URI
     */
    public function setUri( string $uri ) {
        $this->uri = $uri;
    }

    /**
     * 设置请求头
     *
     * @param $headers
     */
    public function addHeaders( $headers ) {
        if ( is_array( $headers ) ) {
            foreach ( $headers as $key => $value ) {
                if ( is_string( $key ) ) {
                    $this->addHeader( $key, $value );
                }
            }
        }
    }

    /**
     * 添加设置请求头
     *
     * @param        $name string 请求头的名称
     * @param string $value string|null 请求头的值
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
        if ( empty( $name ) ) {
            return null;
        }
        if ( isset( $this->headers[ $name ] ) ) {
            return $this->headers[ $name ];
        }

        return null;
    }

    /**
     * 获取所有请求头
     *
     * @return array 请求头数组
     */
    public function getHeaders(): array {
        return $this->headers;
    }

    /**
     * 设置请求超时时间
     *
     * @param $timeout int 超时时间, 单位秒
     *
     * @return void
     */
    public function setTimeout( int $timeout ) {
        $this->timeout = $timeout;
    }

    /**
     * 设置请求的 SSL 验证
     *
     * @param $sslVerify
     *
     * @return void
     */
    public function setSslVerify( $sslVerify ) {
        $this->ssl_verify = $sslVerify;
    }

    /**
     * 设置请求 User Agent
     *
     * @param $userAgent
     *
     * @return void
     */
    public function setUserAgent( $userAgent ) {
        $this->user_agent = $userAgent;
    }

    /**
     * 设置请求的重定向
     *
     * @param $redirection
     *
     * @return void
     */
    public function setRedirection( $redirection ) {
        $this->redirection = $redirection;
    }

    /**
     * 设置 GET 请求参数
     *
     * @param array|string $name 参数名称
     * @param string|null  $value 参数值
     *
     * @return void
     */
    public function setParameterGet( $name, string $value = null ) {
        if ( is_array( $name ) ) {
            foreach ( $name as $key => $value ) {
                $this->setParameter( self::GET, $key, $value );
            }
        } else {
            $this->setParameter( self::GET, $name, $value );
        }
    }

    /**
     * Set a GET or POST parameter - used by SetParameterGet and SetParameterPost
     *
     * @param string $type GET or POST
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    protected function setParameter( string $type, string $name, $value ) {
        $params = array();
        switch ( $type ) {
            case self::GET:
                $params = &$this->paramsGet;
                break;
            case self::POST:
                $params = &$this->paramsPost;
                break;
        }
        if ( $value === null ) {
            if ( isset( $params[ $name ] ) ) {
                unset( $params[ $name ] );
            }
        } else {
            $params[ $name ] = $value;
        }
    }

    /**
     * 设置 POST 请求参数
     *
     * @param array|string $name 参数名称
     * @param null         $value 参数值
     *
     * @return void
     */
    public function setParameterPost( $name, $value = null ) {
        if ( is_array( $name ) ) {
            foreach ( $name as $k => $v ) {
                $this->setParameter( self::POST, $k, $v );
            }
        } else {
            $this->setParameter( self::POST, $name, $value );
        }
    }

    /**
     * 发送 HTTP 请求
     *
     * @param $method string|null 请求方法
     *
     * @return array|WP_Error 失败时的响应数组或WP_Error
     * @throws Exception
     */
    public function request( string $method = null ) {
        if ( ! $this->uri ) {
            throw new Exception( 'No valid URI has been passed to the client' );
        }

        // 设置请求方法
        if ( $method ) {
            $this->setMethod( $method );
        }

        // 将其他 GET 参数添加到 uri 中
        if ( ! empty( $this->paramsGet ) ) {
            $query = parse_url( $this->uri, PHP_URL_QUERY );
            if ( ! empty( $query ) ) {
                $this->uri .= '&';
            } else {
                $this->uri .= '?';
            }
            $this->uri .= http_build_query( $this->paramsGet, null, '&' );
        }

        $this->response = wp_remote_request( $this->uri, $this->prepareParams() );

        return $this->response;
    }

    /**
     * 设置请求方法 request method
     *
     * @param string $method 请求方法, GET, POST 只支持这两种
     *
     * @throws Exception
     */
    public function setMethod( string $method = self::GET ) {

        if ( $method !== self::GET && $method !== self::POST ) {
            throw new Exception( 'Only GET and POST method support.' );
        }

        $this->method = $method;
    }

    /**
     * 准备请求参数
     *
     * @return array The request parameters
     */
    protected function prepareParams(): array {
        $params           = array();
        $params['method'] = $this->method;
        if ( $this->timeout != null ) {
            $params['timeout'] = $this->timeout;
        }
        if ( $this->ssl_verify != null ) {
            $params['$sslverify'] = $this->ssl_verify;
        }
        if ( $this->user_agent != null ) {
            $params['user-agent'] = $this->user_agent;
        }
        if ( $this->redirection != null ) {
            $params['redirection'] = $this->redirection;
        }
        $params['headers'] = $this->prepareHeaders();
        $params['body']    = $this->prepareBody();

        return $params;
    }

    /**
     * 准备请求标头
     *
     * @return array The request headers
     */
    protected function prepareHeaders(): array {
        $headers = array();

        // 设置主机标头 Host
        if ( empty( $this->headers['Host'] ) ) {
            $headers['Host'] = parse_url( $this->uri, PHP_URL_HOST );
        }

        // 设置连接标头 Connection
        if ( empty( $this->headers['connection'] ) ) {
            $headers['Connection'] = "close";
        }

        // 设置 Accept-Encoding 标头
        if ( empty( $this->headers['Accept-encoding'] ) ) {
            if ( function_exists( 'gzinflate' ) ) {
                $headers['Accept-encoding'] = 'gzip, deflate';
            } else {
                $headers['Accept-encoding'] = 'identity';
            }
        }

        // 设置其他标头
        foreach ( $this->headers as $name => $value ) {
            if ( is_array( $value ) ) {
                $value = implode( ', ', $value );
            }
            $headers[ $name ] = $value;
        }

        return $headers;
    }

    /**
     * 准备请求正文（用于 POST 和 PUT 请求）
     *
     * @return string The request body
     */
    protected function prepareBody(): string {

        // 根据 RFC2616，TRACE 请求不应具有正文。
        if ( $this->method == self::TRACE ) {
            return '';
        }

        // 如果我们有raw_post_data设置，只需将其用作正文即可。
        if ( isset( $this->raw_post_data ) ) {
            $this->addHeader( 'Content-length', strlen( $this->raw_post_data ) );

            return $this->raw_post_data;
        }

        $body = '';

        // 如果我们有 POST 参数，请对其进行编码并将它们添加到正文中
        if ( count( $this->paramsPost ) > 0 ) {
            // 将正文编码为 applications-www-form-urlencoding
            $this->addHeader( 'Content-type', self::ENC_URLENCODED );
            $body = http_build_query( $this->paramsPost, '', '&' );
        }

        // 如果我们有一个正文或请求是 POST, PUT 设置内容长度
        if ( $body || $this->method == self::POST || $this->method == self::PUT ) {
            $this->addHeader( 'Content-length', strlen( $body ) );
        }

        return $body;
    }

    /**
     * 设置请求数据
     *
     * @param $data string 请求数据
     *
     * @return void
     */
    public function setRawData( string $data ) {
        $this->raw_post_data = $data;
    }

    /**
     * 清除所有 GET 和 POST 参数 如果客户端用于多个并发请求，则应用于重置请求参数。
     *
     * @return void
     */
    public function resetParameters() {
        // Reset parameter data
        $this->paramsGet     = array();
        $this->paramsPost    = array();
        $this->raw_post_data = null;

        // Reset header data
        $allowed_headers = array( 'Accept-Charset' );
        foreach ( $this->headers as $header => $value ) {
            if ( ! in_array( $header, $allowed_headers ) ) {
                unset( $this->headers[ $header ] );
            }
        }
    }

}