<?php

namespace MoredealAiWriter\code\extend\UseLimit;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\admin\UseLimitConfig;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\application\models\LogModel;
use MoredealAiWriter\application\models\UseLimitModel;
use MoredealAiWriter\code\consts\EventCodeConst;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\event\BaseEventModule;
use MoredealAiWriter\code\modules\extend\AbstractBaseExtend;
use MoredealAiWriter\code\modules\step\AbstractStepModule;

class UseLimitExtend extends AbstractBaseExtend {


    public function initExtend( AbstractContextModule $context ) {
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_PRE()->getValue(), array(
            $this,
            "event_uselimit_event_temp_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_POST()->getValue(), array(
            $this,
            "event_uselimit_event_temp_post"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_PRE()->getValue(), array(
            $this,
            "event_uselimit_event_step_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_POST()->getValue(), array(
            $this,
            "event_uselimit_event_step_post"
        ) ) );
    }

    /**
     * @throws Exception
     */
    public function event_uselimit_event_temp_pre( AbstractContextModule $context ) {
        $isLimitEnabled = UseLimitConfig::getInstance()->option( 'enable' );

        if ( $isLimitEnabled ) {
            $user_id           = get_current_user_id();
            $is_user_logged_in = is_user_logged_in();

            if ( $user_id == 0 || ! $is_user_logged_in ) {
                $list = UseLimitModel::getInstance()->findListByScope( Constant::GUESTS );

                if ( empty( $list ) ) {
                    return;
                }

                if ( ! session_id() ) {
                    session_start();
                }

                $session_id = session_id();

                $this->execLimits( $session_id, null, $list );

            } else {
                $list = UseLimitModel::getInstance()->findUselimitData( $user_id );

                if ( empty( $list ) ) {
                    return;
                }

                $this->execLimits( null, $user_id, $list );
            }

        }
    }

    /**
     * @param $session_id
     * @param $user_id
     * @param $uselimitList
     *
     * @return void
     * @throws Exception
     */
    private function execLimits( $session_id, $user_id, $uselimitList ) {

        $user_id = $session_id ?? $user_id;

        if ( ! empty( $uselimitList ) ) {

            foreach ( $uselimitList as $useLimit ) {

                $start_time = UseLimitModel::getInstance()->getLimitsStartTime( $useLimit->time );

                $token_usage = LogModel::getInstance()->getTokenUsageByUserIdAndTimeRange( $user_id, $start_time, date( 'Y-m-d H:i:s' ) );

                error_log( 'Limits count: ' . $token_usage );
                if ( $token_usage >= $useLimit->limits ) {
                    throw new Exception( $useLimit->tips );
                }
            }
        }
    }


    public function event_uselimit_event_temp_post( AbstractContextModule $context ) {
        //echo "uselimitExtend eventEVENT_TEMP_POST";

    }

    public function event_uselimit_event_step_pre( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        //echo "uselimitExtend eventEVENT_STEP_PRE";

    }

    public function event_uselimit_event_step_post( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        //echo "uselimitExtend eventEVENT_STEP_POST";
    }


}