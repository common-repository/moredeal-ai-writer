<?php

namespace MoredealAiWriter\code\lib\openai\consts;

defined( '\ABSPATH' ) || exit;

/**
 * OpenApiConstant
 *
 * @author MoredealAiWriter
 */
interface OpenApiConstant {

    const CLIENT = "client";
    const SERVER = "server";

    /**
     * image
     */
    const SIZE_256 = "256x256";
    const SIZE_512 = "512x512";
    const SIZE_1024 = "1024x1024";
    const RES_FORMAT_URL = "url";
    const RES_FORMAT_B64_URL = "b64_json";


}