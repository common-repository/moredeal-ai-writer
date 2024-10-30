<?php

namespace MoredealAiWriter\code\lib\openai;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;

/**
 * Class OpenAi
 *
 * @author MoredealAiWriter
 */
class OpenAi {
    private $engine = "davinci";
    private $model = "text-davinci-003";
    private $chatModel = "gpt-3.5-turbo";
    private $headers;
    private $contentTypes;
    private $timeout = 0;
    private $stream_method;
    private $customUrl = "";
    private $proxy = "";
    private $curlInfo = [];

    const DEFAULT_SEASTAR_HOST = 'http://api-aigc.hotsalecloud.com';

    public function __construct( $OPENAI_API_KEY, $OPENAI_ORG = "", $customUrl = "" ) {
        $this->contentTypes = [
            "application/json"    => "Content-Type: application/json",
            "multipart/form-data" => "Content-Type: multipart/form-data",
        ];

        $this->headers = [
            $this->contentTypes["application/json"],
            "Authorization: Bearer $OPENAI_API_KEY",
        ];

        if ( $OPENAI_ORG != "" ) {
            $this->headers[] = "OpenAI-Organization: $OPENAI_ORG";
        }
        if ( $customUrl != "" ) {
            $this->customUrl = $customUrl;
        }

		$this->timeout = 60;
    }

    /**
     *
     * @return array
     * Remove this method from your code before deploying
     */
    public function getCURLInfo() {
        return $this->curlInfo;
    }


    /**
     *
     * @return bool|string
     */
    public function listModels() {
        $url = Url::fineTuneModel();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $model
     *
     * @return bool|string
     */
    public function retrieveModel( $model ) {
        $model = "/$model";
        $url   = Url::fineTuneModel() . $model;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     * @deprecated
     */
    public function complete( $opts ) {
        $engine = $opts['engine'] ?? $this->engine;
        $url    = Url::completionURL( $engine );
        unset( $opts['engine'] );
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param      $opts
     * @param null $stream
     *
     * @return bool|string
     * @throws Exception
     */
    public function completion( $opts, $stream = null ) {
        if ( $stream != null && array_key_exists( 'stream', $opts ) ) {
            if ( ! $opts['stream'] ) {
                throw new Exception(
                    'Please provide a stream function. Check https://github.com/orhanerday/open-ai#stream-example for an example.'
                );
            }

            $this->stream_method = $stream;
        }

        $opts['model'] = $opts['model'] ?? $this->model;
        $url           = Url::completionsURL();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function createEdit( $opts ) {
        $url = Url::editsUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function image( $opts ) {
        $url = Url::imageUrl() . "/generations";
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function imageEdit( $opts ) {
        $url = Url::imageUrl() . "/edits";
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function createImageVariation( $opts ) {
        $url = Url::imageUrl() . "/variations";
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     * @deprecated
     */
    public function search( $opts ) {
        $engine = $opts['engine'] ?? $this->engine;
        $url    = Url::searchURL( $engine );
        unset( $opts['engine'] );
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     * @deprecated
     */
    public function answer( $opts ) {
        $url = Url::answersUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     * @deprecated
     */
    public function classification( $opts ) {
        $url = Url::classificationsUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function moderation( $opts ) {
        $url = Url::moderationUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param      $opts
     * @param null $stream
     *
     * @throws Exception
     */
    public function chat( $opts, $stream = null ) {
        if (array_key_exists('stream', $opts) && $opts["stream"]) {
            $url           = self::DEFAULT_SEASTAR_HOST.'/aigc/chat/context/stream';

            $resp = $this -> sendRequestStream($url,"POST", $opts);
            return json_decode($resp,true);
        }
        if ( $stream != null && array_key_exists( 'stream', $opts ) ) {
            if ( ! $opts['stream'] ) {
                throw new Exception(
                    'Please provide a stream function. Check https://github.com/orhanerday/open-ai#stream-example for an example.'
                );
            }
            $this->stream_method = $stream;
        }

        $opts['model'] = $opts['model'] ?? $this->chatModel;
        $url           = Url::chatUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function transcribe( $opts ) {
        $url = Url::transcriptionsUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function translate( $opts ) {
        $url = Url::translationsUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }


    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function uploadFile( $opts ) {
        $url = Url::filesUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @return bool|string
     */
    public function listFiles() {
        $url = Url::filesUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $file_id
     *
     * @return bool|string
     */
    public function retrieveFile( $file_id ) {
        $file_id = "/$file_id";
        $url     = Url::filesUrl() . $file_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $file_id
     *
     * @return bool|string
     */
    public function retrieveFileContent( $file_id ) {
        $file_id = "/$file_id/content";
        $url     = Url::filesUrl() . $file_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $file_id
     *
     * @return bool|string
     */
    public function deleteFile( $file_id ) {
        $file_id = "/$file_id";
        $url     = Url::filesUrl() . $file_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'DELETE' );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function createFineTune( $opts ) {
        $url = Url::fineTuneUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @return bool|string
     */
    public function listFineTunes() {
        $url = Url::fineTuneUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $fine_tune_id
     *
     * @return bool|string
     */
    public function retrieveFineTune( $fine_tune_id ) {
        $fine_tune_id = "/$fine_tune_id";
        $url          = Url::fineTuneUrl() . $fine_tune_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $fine_tune_id
     *
     * @return bool|string
     */
    public function cancelFineTune( $fine_tune_id ) {
        $fine_tune_id = "/$fine_tune_id/cancel";
        $url          = Url::fineTuneUrl() . $fine_tune_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST' );
    }

    /**
     * @param $fine_tune_id
     *
     * @return bool|string
     */
    public function listFineTuneEvents( $fine_tune_id ) {
        $fine_tune_id = "/$fine_tune_id/events";
        $url          = Url::fineTuneUrl() . $fine_tune_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $fine_tune_id
     *
     * @return bool|string
     */
    public function deleteFineTune( $fine_tune_id ) {
        $fine_tune_id = "/$fine_tune_id";
        $url          = Url::fineTuneModel() . $fine_tune_id;
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'DELETE' );
    }

    /**
     * @param
     *
     * @return bool|string
     * @deprecated
     */
    public function engines() {
        $url = Url::enginesUrl();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $engine
     *
     * @return bool|string
     * @deprecated
     */
    public function engine( $engine ) {
        $url = Url::engineUrl( $engine );
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'GET' );
    }

    /**
     * @param $opts
     *
     * @return bool|string
     */
    public function embeddings( $opts ) {
        $url = Url::embeddings();
        $this->baseUrl( $url );

        return $this->sendRequest( $url, 'POST', $opts );
    }

    /**
     * @param int $timeout
     */
    public function setTimeout( int $timeout ) {
        $this->timeout = $timeout;
    }

    /**
     * @param string $proxy
     */
    public function setProxy( string $proxy ) {
        if ( $proxy && strpos( $proxy, '://' ) === false ) {
            $proxy = 'http://' . $proxy;
        }
        $this->proxy = $proxy;
    }

    /**
     * @param string $customUrl
     */
    public function setCustomURL( string $customUrl ) {
        if ( $customUrl != "" ) {
            $this->customUrl = $customUrl;
        }
    }

    /**
     * @param string $org
     */
    public function setORG( string $org ) {
        if ( $org != "" ) {
            $this->headers[] = "OpenAI-Organization: $org";
        }
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $opts
     *
     * @return bool|string
     */
    private function sendRequest( string $url, string $method, array $opts = [] ) {
        $post_fields = json_encode( $opts );

        if ( array_key_exists( 'file', $opts ) || array_key_exists( 'image', $opts ) ) {
            $this->headers[0] = $this->contentTypes["multipart/form-data"];
            $post_fields      = $opts;
        } else {
            $this->headers[0] = $this->contentTypes["application/json"];
        }
        $curl_info = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => $this->headers,
        ];

        if ( $opts == [] ) {
            unset( $curl_info[ CURLOPT_POSTFIELDS ] );
        }

        if ( array_key_exists( 'stream', $opts ) && $opts['stream'] ) {
            $curl_info[ CURLOPT_WRITEFUNCTION ] = $this->stream_method;
        }

        $curl = curl_init();

        curl_setopt_array( $curl, $curl_info );
        $response = curl_exec( $curl );
        curl_close( $curl );

        return $response;
    }

    /**
     * @throws Exception
     */
    private function sendRequestStream(string $url, string $method, array $opts = [] ): string
    {
        $ch = curl_init();
        $aigc_key = Plugin::plugin_key();
        $headers = array(
            $this->contentTypes["application/json"],
            "License-Authorization: ".$aigc_key
        );
        if (!array_key_exists('chatId', $opts) || empty( $opts["chatId"] )) {
            $bytes = random_bytes(16);
            $opts["chatId"] = base64_encode($bytes);
            error_log($opts["chatId"]);
        }
        $opts["messages"] = $opts["messages"][0]["content"];
        error_log(json_encode($opts));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($opts));
        $origin = str_replace("/wp-json/","",rest_url());
        header('Content-Type: text/plain; charset=UTF-8');
        header( 'Access-Control-Allow-Origin: '.$origin);
        header( 'Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE' );
        header( 'Access-Control-Allow-Credentials: true' );
        header('X-Accel-Buffering: no');
        $streamData = [
            "content" => '',
            "extend" => ''
        ];
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($curl, $data) use (&$streamData) {
            if (str_starts_with($data, "&end&")) {
                echo " &end& ";
                ob_flush();
                flush();
                $streamData["extend"] .= str_replace("&end&", "", $data);
            }elseif (str_starts_with($data, "&error&")){
                echo $data;
                ob_flush();
                flush();
                throw Exception();
            } else{
                if (!str_starts_with($data, "&start&")){
                    $streamData["content"] = $streamData["content"].$data;
                }
                echo $data;
                ob_flush();
                flush();
            }
            return strlen($data);
        });
        curl_exec($ch);
        curl_close($ch);
        $choices = json_decode($streamData["extend"]);
        $choices->choices[0]->message->content = $streamData["content"];
        return json_encode($choices);
    }

    /**
     * @param string $url
     */
    private function baseUrl( string &$url ) {
        if ( $this->customUrl != "" ) {
            $url = str_replace( Url::ORIGIN, $this->customUrl, $url );
        }
    }
}

