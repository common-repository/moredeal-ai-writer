<?php

namespace MoredealAiWriter\code\extend\LogExtend;

defined( '\ABSPATH' ) || exit;

use DateTime;
use Exception;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\application\models\LogModel;
use MoredealAiWriter\code\consts\EventCodeConst;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\event\BaseEventModule;
use MoredealAiWriter\code\modules\extend\AbstractBaseExtend;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\AbstractStepModule;

/**
 * Class LogExtend
 *
 * @author MoredealAiWriter
 */
class LogExtend extends AbstractBaseExtend {

    private $_start_time;
    private $_end_time;

    public function initExtend( AbstractContextModule $context ) {
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_PRE()->getValue(), array(
            $this,
            "event_log_event_temp_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_POST()->getValue(), array(
            $this,
            "event_log_event_temp_post"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_PRE()->getValue(), array(
            $this,
            "event_log_event_step_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_POST()->getValue(), array(
            $this,
            "event_log_event_step_post"
        ) ) );
    }


    public function event_log_event_temp_pre( AbstractContextModule $context ) {

        //echo "LogExtend eventEVENT_TEMP_PRE";

    }

    public function event_log_event_temp_post( AbstractContextModule $context ) {

        //echo "LogExtend eventEVENT_TEMP_POST";

    }

    public function event_log_event_step_pre( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        $this->_start_time = new DateTime();
        //echo "LogExtend eventEVENT_STEP_PRE";

    }

    /**
     * @throws Exception
     */
    public function event_log_event_step_post( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        $this->_end_time = new DateTime();
        $diff_time       = date_diff( $this->_start_time, $this->_end_time );

        $response = $stepModule->response;

        $logModel = new LogModel();

        // ip地址
        $ip_address           = $_SERVER['REMOTE_ADDR'];
        $logModel->ip_address = $ip_address;

        if ( ! session_id() ) {
            session_start();
        }

        $session_id = session_id();

        $logModel->session_id = $session_id;

        // 获取场景名称
        $scene_key = $context->get_scene_key();
        $scene     = SceneManager::factoryScene( $scene_key );

        $logModel->scene = $scene->name;

        $logModel->template_name = $context->getTemplate()->name;
        $logModel->template_key  = $context->getTemplate()->key;
        $logModel->instance_id   = $context->getInstanceId();
        $logModel->template_id   = $context->getTemplate()->id;
        $logModel->step_key      = $context->getStepField();

        $processParams = $response->processParams; //接口实际返回结果和入参
        if ( ! empty( $response->processParams ) ) {
            $logModel->token_mark = $processParams->mark;
            if ( $processParams->status === true && array_key_exists( "complete", $processParams->response ) ) {
                $logModel->api = $processParams->response['complete']['object'];
            }
            if ( isset( $processParams->modelPrice ) ) {
                $modelPriceArr = get_object_vars( $processParams->modelPrice );

                $user_type = $modelPriceArr["user_type"];

                if ( $user_type == Constant::GUESTS ) {
                    $logModel->user_id = $session_id;
                } else {
                    $logModel->user_id = $modelPriceArr["user_id"];
                }

                $logModel->user_name   = $modelPriceArr["user_name"];
                $logModel->user_type   = $user_type;
                $logModel->model       = $modelPriceArr["model"];
                $logModel->price       = $modelPriceArr["price"];
                $logModel->total_price = $modelPriceArr["total_price"];
                $logModel->token_usage = $modelPriceArr["token_usage"];

            }

            $logModel->request  = json_encode( $processParams->request );
            $logModel->response = json_encode( $processParams->response );
        }

        $logModel->start_time   = date( 'Y-m-d H:i:s', $this->_start_time->getTimestamp() );
        $logModel->end_time     = date( 'Y-m-d H:i:s', $this->_end_time->getTimestamp() );
        $logModel->diff_time    = $diff_time->s;
        $logModel->success      = $response->status;
        $logModel->gmt_create   = date( 'Y-m-d H:i:s', $this->_end_time->getTimestamp() );
        $logModel->gmt_modified = date( 'Y-m-d H:i:s', $this->_end_time->getTimestamp() );
        $logModel->is_delete    = 0;

        // key id都存
        $log_model_arr = get_object_vars( $logModel );

        $logModel->arrayToSqlInsert( $log_model_arr );

    }

    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }


}