<?php

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;

/**
 * 简码后台模版市场场景
 *
 * @autor Moredeal AI Writer
 */
class WPAdminTemplateMarketSceneModule extends AbstractSceneModule {

    /**
     * 初始化基本信息
     *
     * @return void
     */
    protected function initConfig() {
        $this->app         = Plugin::translation( 'WordPress' );
        $this->name        = Plugin::translation( 'Template Market Admin' );
        $this->description = Plugin::translation( 'Supported by default, The Template Market Admin execute template use.' );
        $this->docs_uri    = "https://";
    }

    /**
     * 保存模版 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractTemplateModule $template
     *
     * @return void
     * @throws Exception
     */
    public function save_before( AbstractSceneModule $scene, AbstractTemplateModule $template ) {

    }

    /**
     * 保存模版 后置处理函数
     *
     * @return void
     */
    public function save_after( AbstractSceneModule $scene, AbstractTemplateModule $template ) {

    }

    /**
     * 模版执行 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public function handler_tmp_before( AbstractSceneModule $scene, AbstractContextModule $context ) {

    }

    /**
     * 步骤执行 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     * @param AbstractStepModule $stepModule
     *
     * @return void
     * @throws Exception
     */
    public function handler_step_before( AbstractSceneModule $scene, AbstractContextModule $context, AbstractStepModule $stepModule ) {

    }

    /**
     * 模版执行 后置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public function handler_tmp_after( AbstractSceneModule $scene, AbstractContextModule $context ) {

    }

    /**
     * 模版执行 后置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     * @param AbstractStepModule $stepModule
     *
     * @return void
     * @throws Exception
     */
    public function handler_step_after( AbstractSceneModule $scene, AbstractContextModule $context, AbstractStepModule $stepModule ) {

    }

}