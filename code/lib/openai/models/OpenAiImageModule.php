<?php

namespace MoredealAiWriter\code\lib\openai\models;

defined( '\ABSPATH' ) || exit;


use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\code\lib\openai\consts\ModelConstant;
use MoredealAiWriter\code\lib\openai\consts\OpenApiConstant;
use MoredealAiWriter\code\lib\openai\OpenAi;
use MoredealAiWriter\code\modules\step\response\ModelPrice;

/**
 * Class OpenAiImageModule
 *
 * @author MoredealAiWriter
 */
class OpenAiImageModule {
    /**
     * A text description of the desired image(s). The maximum length is 1000 characters.
     * @var string
     */
    public $prompt;
    /**
     * The number of images to generate.
     * @var int
     */
    public $n = 1;
    /**
     * The size of the generated images.
     * @var string
     */
    public $size = OpenApiConstant::SIZE_1024;
    /**
     * The format in which the generated images are returned.
     * @var string
     */
    public $response_format = OpenApiConstant::RES_FORMAT_URL;

    /**
     * A unique identifier representing your end-user, which can help OpenAI to monitor and detect abuse.
     * @return void
     */
    public $user = "0_0";

    public function __construct() {
    }

    public function convert( array $opts = [] ): array {
        if ( empty( $opts ) ) {
            return get_object_vars( $this );
        }

        return [
            "prompt"          => $opts["prompt"] ?? "",
            "n"               => $opts["n"] ?? $this->n,
            "size"            => $opts["size"] ?? $this->size,
            "response_format" => $opts["response_format"] ?? $this->response_format,
            "user"            => $opts["user"] ?? $this->user
        ];

    }

    /**
     * @param array $opts
     * @param bool $open_ai
     * @param string|null $open_ai_key
     *
     * @return array
     * @throws Exception
     */
    public function send( $opts, bool $open_ai, $open_ai_key = null ): array {

        $this->checkParam( $opts );

        try {

            if ( $open_ai ) {
                $open_ai  = new OpenAi( $open_ai_key );
                $complete = $open_ai->image( $opts );
            } else {
                $complete = SeastarRestfulClient::getInstance()->openai_image( $opts );
            }

            return $complete;

        } catch ( Exception $e ) {
            error_log( "send openapi image is failure. " . $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }

    public function logicPrice( array $opts = [] ): ModelPrice {
        if ( ! empty( $opts ) ) {
            $size = $opts['size'];

            $price = ModelConstant::getPriceByName( $size );

            $n = $opts['n'];

            $total_price = $n * $price;

            return new ModelPrice( $size, $n, $price, $total_price );
        }

        return new ModelPrice( "", "", "", "" );
    }

    /**
     * @throws Exception
     */
    private function checkParam( array $opts = [] ) {
        if ( empty( $opts ) ) {
            error_log( "the opts is null." );
            throw new Exception( "the opts is null." );
        }

        if ( ! array_key_exists( "prompt", $opts ) || empty( $opts["prompt"] ) ) {
            error_log( "the prompt is required." );
            throw new Exception( "the prompt is required." );
        }

        if ( strlen( $opts["prompt"] ) > 1000 ) {
            error_log( "the prompt length is to long." );
            throw new Exception( "the prompt length is to long." );
        }

        if ( ! array_key_exists( "n", $opts ) || empty( $opts["n"] ) ) {
            error_log( "the n is required." );
            throw new Exception( "the n is required." );
        }


        if ( $opts["n"] < 1 || $opts["n"] > 10 ) {
            error_log( "the image number must be between 1 and 10." );
        }

    }

}
