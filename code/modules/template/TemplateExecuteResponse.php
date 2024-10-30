<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;

/**
 * 模版执行结果
 *
 * @author MoredealAiWriter
 */
class TemplateExecuteResponse {

    /**
     * 实例 ID
     *
     * @var
     */
    public $instanceId;

    /**
     * 步骤字段
     *
     * @var string
     */
    public $stepField;

    /**
     * 状态
     *
     * @var
     */
    public $status;

    /**
     * 错误码
     *
     * @var
     */
    public $errorCode;

    /**
     * 消息
     *
     * @var string
     */
    public $message;

    /**
     * 步骤响应
     *
     * @var $stepResponse AbstractResponseModule
     */
    public $stepResponse;

    /**
     * 修改时间
     *
     * @var
     */
    public $gmtModified;

    /**
     * @param AbstractResponseModule $stepResponse
     */
    public function __construct( AbstractResponseModule $stepResponse ) {
        $this->stepResponse = $stepResponse;
        $this->status       = $stepResponse->status;
        $this->errorCode    = $stepResponse->errorCode;
        $this->message      = $stepResponse->message;
    }

}