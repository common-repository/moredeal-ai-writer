<?php

namespace MoredealAiWriter\code\lib\openai\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\code\lib\openai\consts\ModelConstant;
use MoredealAiWriter\code\lib\openai\OpenAi;
use MoredealAiWriter\code\modules\step\response\ModelPrice;

/**
 * Class OpenAiTextModule
 *
 * @author MoredealAiWriter
 */
class OpenAiTextModule {
    /**
     * ID of the model to use.
     * @var string
     */
    public $model = 'text-davinci-003';

    /**
     * The prompt(s) to generate completions for,
     * encoded as a string, array of strings, array of tokens, or array of token arrays.
     * @var
     */
    public $prompt = "默认值";

    /**
     * What sampling temperature to use, between 0 and 2.
     * Higher values like 0.8 will make the output more random,
     * while lower values like 0.2 will make it more focused and deterministic.
     * @var
     */
    public $temperature = 0.6;

    /**
     * The maximum number of tokens to generate in the completion.
     * Most models have a context length of 2048 tokens (except for the newest models, which support 4096).
     * @var
     */
    public $max_tokens = 100;
    /**
     * @var
     */
    public $frequency_penalty = 0;
    /**
     * @var
     */
    public $presence_penalty = 0;

    /**
     * 用户唯一标识
     * @var
     */
    public $user = "0_0";

    public function __construct() {

    }


    // 参数转模型
    public function convert( array $opts = [] ): array {
        if ( empty( $opts ) ) {
            return get_object_vars( $this );
        }

        return [
            "model"             => $opts["model"] ?? $this->model,
            "prompt"            => $opts["prompt"] ?? $this->prompt,
            "temperature"       => $opts["temperature"] ? doubleval( $opts["temperature"] ) : $this->temperature,
            "max_tokens"        => $opts["max_tokens"] ? intval( $opts["max_tokens"] ) : $this->max_tokens,
            "frequency_penalty" => $opts["frequency_penalty"] ?? $this->frequency_penalty,
            "presence_penalty"  => $opts["presence_penalty"] ?? $this->presence_penalty,
            "user"              => $opts["user"] ?? $this->user,
        ];

    }

    /**
     * request
     *
     * @throws Exception
     */
    public function send( $opts, bool $open_ai, $open_ai_key = null ): array {

        $this->checkParam( $opts );

        try {

            if ( $open_ai ) {
                $open_ai  = new OpenAi( $open_ai_key );
                $complete = $open_ai->completion( $opts );
            } else {
                $complete = json_encode( SeastarRestfulClient::getInstance()->openaiChat( $opts ) );
            }

            return (array) json_decode( $complete, true );

        } catch ( \Exception $e ) {
            error_log( "send openapi is failure. " . $e->getMessage() );
            throw new \Exception( "send openapi is failure. " . $e->getMessage() );
        }

    }

    public function logicPrice( array $complete = [] ) {
        if ( ! empty( $complete ) ) {

            $model = $complete['model'];

            $price = ModelConstant::getPriceByName( $model );

            $total_tokens = $complete['usage']['total_tokens'];

            $total_price = $total_tokens * $price;

            $modelPrice = new ModelPrice( $model, $total_tokens, $price, $total_price );

            return $modelPrice;
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private function checkParam( array $opts = [] ) {
        if ( empty( $opts ) ) {
            error_log( "the opts is null." );
            throw new \Exception( "the opts is null." );
        }

        if ( ! array_key_exists( "prompt", $opts ) || empty( $opts["prompt"] ) ) {
            error_log( "the prompt is required." );
            throw new \Exception( "the prompt is required." );
        }

    }

}