<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\consts\StepTypeConstant;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\WPAdminSceneModule;
use MoredealAiWriter\code\modules\scene\WPAdminTemplateMarketSceneModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\DialogResponseModule;
use MoredealAiWriter\code\modules\util\LogUtil;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

/**
 * 生成文章执行步骤
 *
 * @author MoredealAiWriter
 */
class ViewPPTStepModule extends AbstractStepModule {

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
        $this->name         = Plugin::translation( 'View Report As PPT' );
        $this->desc         = Plugin::translation( 'View Report As PPT' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = '';
        $this->type         = StepTypeConstant::TYPE_ADAPTER()->getValue();
        $this->tags         = array( 'WordPress', 'View Report As PPT' );
        $this->isAuto       = false;
        $this->isCanAddStep = false;
        $this->icon         = Plugin::plugin_res() . '/images/ppt.svg';
        $this->scenes       = array( WPAdminSceneModule::of(), WPAdminTemplateMarketSceneModule::of() );
        $this->variables    = array(
            static::defContentVariable()
        );
        $this->response     = DialogResponseModule::defResponse();
    }

    /**
     * 执行该步骤
     *
     * @param AbstractContextModule $context
     *
     * @return AbstractResponseModule
     * @throws Exception
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {
        $report_content = $context->getStepVariable( 'view_ppt_content' ) ?? '';
        $model_price    = LogUtil::build_model_price( 'view_ppt' );

        if ( empty( $report_content ) ) {
            $this->response->error( 'view ppt content: the content is required' );
            $this->response->setProcessParams( LogUtil::build_process( $context, array(), array(), $this->response->status, $model_price ) );

            return $this->response;
        }

        $this->response->setProcessParams( LogUtil::build_process( $context, array(), array(), $this->response->status, $model_price ) );

        return $this->response->success( $report_content );
    }

    /**
     * 定义内容变量
     *
     * @return TextVariableModule
     */
    public function defContentVariable(): TextVariableModule {
        $content_variable           = TextVariableModule::new();
        $content_variable->field    = "view_ppt_content";
        $content_variable->label    = "View PPT Content";
        $content_variable->desc     = "View PPT Content is the Generate Report Step response, you can entry the {STEP.GENERATE_REPORT._OUT} or yor custom content";
        $content_variable->default  = "{STEP.GENERATE_REPORT._OUT}";
        $content_variable->order    = 1;
        $content_variable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $content_variable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $content_variable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $content_variable->is_point = true;
        $content_variable->is_show  = false;

        return $content_variable;
    }

}