<?php

namespace MoredealAiWriter\code\modules\step\response;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\ResponseStyleConstant;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * 返回响应基类
 *
 * @author MoredealAiWriter
 */
abstract class AbstractResponseModule extends BaseModule {

    /**
     * 类型 key
     *
     * @var string
     */
    public $key;

    /**
     * 应用
     *
     * @var ResponseConstant
     */
    public $type;

    /**
     * 位子
     *
     * @var ResponseStyleConstant
     */
    public $style;

    /**
     * 步骤 key
     * @var string
     */
    public $stepField;

    /**
     * 返回的过程参数，记录用
     *
     * @var $processParams ProcessParams
     */
    public $processParams;

    /**
     * @return ProcessParams
     */
    public function getProcessParams(): ProcessParams {
        return $this->processParams;
    }

    /**
     * @param ProcessParams $processParams
     *
     * @return AbstractResponseModule
     */
    public function setProcessParams( ProcessParams $processParams ): AbstractResponseModule {
        $this->processParams = $processParams;

        return $this;
    }

    /**
     * @var bool
     */
    public $isShow = true;

    /**
     * 需要的返回结果，返回下游用
     * @var
     */
    public $value;

    /**
     * 错误码
     * @var int
     */
    public $errorCode;

    /**
     * 状态
     *
     * @var string
     */
    public $status = false;

    /**
     * 消息
     *
     * @var string
     */
    public $message;

    /**
     * 初始化
     *
     * @return void
     */
    public function init() {
        $this->key = static::getModuleKey();
        $this->initConfig();
    }

    /**
     * 获取value
     * @return
     */
    public function getValue() {
        return $this->value;
    }

    public function setValue( $value ) {
        $this->value = $value;

        return $this;
    }

    public function success( $value, $message = "" ) {


        $this->setValue( $value );
        $this->status  = true;
        $this->message = $message;

        return $this;
    }

    public function error( $msg ) {
        $this->message = $msg;
        $this->status  = false;

        return $this;
    }

    /**
     * 初始化配置
     *
     * @param void
     */
    protected function initConfig() {


    }

    /**
     * 获取模块
     *
     * @param $object
     *
     * @return mixed
     */
    public static function factoryObject( $object ) {
        $self = self::new();

        return ModuleConvertUtil::convert( $self, $object );
    }


}


class ProcessParams {


    public $mark;

    public $request;

    public $response;

    public $status;
    public $modelPrice;

    /**
     * @param $mark
     * @param $request
     * @param $response
     */
    public function __construct( $mark = null, $request = null, $response = null, $status = null, $modelPrice = null ) {
        $this->mark       = $mark;
        $this->request    = $request;
        $this->response   = $response;
        $this->status     = $status;
        $this->modelPrice = $modelPrice;
    }

}

class ModelPrice {
    public $model;

    public $user_id;

    public $user_name;
    public $user_type;
    public $token_usage;

    public $price;
    public $total_price;

    /**
     * @param $model
     * @param $token_usage
     * @param $price
     * @param $total_price
     */
    public function __construct( $model = null, $token_usage = null, $price = null, $total_price = null ) {
        $this->model       = $model;
        $this->token_usage = $token_usage;
        $this->price       = $price;
        $this->total_price = $total_price;
    }


}