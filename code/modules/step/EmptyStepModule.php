<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\WPAdminSceneModule;
use MoredealAiWriter\code\modules\scene\WPAdminTemplateMarketSceneModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\TextResponseModule;
use MoredealAiWriter\code\modules\util\LogUtil;

/**
 * Open API 执行步骤
 *
 * @author MoredealAiWriter
 */
class  EmptyStepModule extends AbstractStepModule {

    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {
        $this->name         = Plugin::translation( 'Empty Step' );
        $this->desc         = Plugin::translation( 'Empty Step' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = '';
        $this->tags         = array( Plugin::translation( 'Empty Step' ) );
        $this->isAuto       = false;
        $this->isCanAddStep = false;
        $this->variables    = array();
        $this->scenes       = array( WPAdminSceneModule::of(), WPAdminTemplateMarketSceneModule::of() );
        $this->response     = TextResponseModule::defInputResponse();
    }

    /**
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {
        $model_price = LogUtil::build_model_price( 'copy content' );
        $this->response->success( "Is Ok" );
        $this->response->setProcessParams( LogUtil::build_process( $context, array(), array(), $this->response->status, $model_price ) );

        return $this->response;
    }

}