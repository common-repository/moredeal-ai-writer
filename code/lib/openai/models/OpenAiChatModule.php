<?php

namespace MoredealAiWriter\code\lib\openai\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\consts\ErrorConstant;
use MoredealAiWriter\code\lib\openai\consts\ModelConstant;
use MoredealAiWriter\code\lib\openai\OpenAi;
use MoredealAiWriter\code\modules\step\response\ModelPrice;

/**
 * Class OpenAiChatModule
 *
 * @author MoredealAiWriter
 */
class OpenAiChatModule {

    public $model = 'gpt-3.5-turbo';

    /**
     * @link  https://platform.openai.com/docs/guides/chat/introduction
     * @var array
     */
    public $messages = [];

    public $temperature = 0.2;

    public $n = 1;

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

    /**
     * @var string
     */
    public $chatId = "";

    public function __construct() {

    }

    public function convert( array $opts = [] ): array {
        if ( empty( $opts ) ) {
            return get_object_vars( $this );
        }

        return [
            "model"             => $opts["model"] ?? $this->model,
            "messages"          => $opts["messages"] ?? $this->messages,
            "temperature"       => $opts["temperature"] ? doubleval( $opts["temperature"] ) : $this->temperature,
            "n"                 => $opts["n"] ?? $this->n,
            "max_tokens"        => $opts["max_tokens"] ? intval( $opts["max_tokens"] ) : $this->max_tokens,
            "frequency_penalty" => $opts["frequency_penalty"] ?? $this->frequency_penalty,
            "presence_penalty"  => $opts["presence_penalty"] ?? $this->presence_penalty,
            "user"              => $opts["user"] ?? $this->user,
            "chatId"            => $opts["chatId"] ?? $this->chatId,
            "stream"            => $opts["stream"] ?? true
        ];

    }

    /**
     * @throws Exception
     */
    public function send( $opts, bool $open_ai, $open_ai_key = null ): array {

        $this->checkParam( $opts );

        try {

            if (array_key_exists('stream', $opts) && $opts["stream"]) {
                error_log("start stream chat");
                $open_ai  = new OpenAi( $open_ai_key );
                $complete = $open_ai->chat( $opts );
            } else {
                $complete = SeastarRestfulClient::getInstance()->openaiChatCompletion( $opts );
                if ( isset( $complete['success'] ) && ! $complete['success'] ) {
                    throw new Exception( $complete['message'] ?? ErrorConstant::SEND_OPENAI_CHAT_COMPLETION_FAIL_MESSAGE );
                }
            }
            return $complete;

        } catch ( Exception $e ) {
            error_log( "send openapi chat is failure. " . $e->getMessage() );
            throw new Exception( $e->getMessage() );
        }
    }

    public function logicPrice( array $complete = [] ): ModelPrice {
        if ( ! empty( $complete ) ) {

            $model = $complete['model'];

            $price = ModelConstant::getPriceByName( $model );

            $total_tokens = $complete['usage']['totalTokens'];

            $total_price = $total_tokens * $price;

            return new ModelPrice( $model, $total_tokens, $price, $total_price );
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

        if ( ! array_key_exists( "messages", $opts ) || empty( $opts["messages"] ) ) {
            error_log( "the messages is required." );
            throw new Exception( "the messages is required." );
        }

    }
}
