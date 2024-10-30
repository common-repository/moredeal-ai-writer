<?php

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;

/**
 * 简码单页面场景
 *
 * @autor Moredeal AI Writer
 */
class WPShortCodeSceneModule extends AbstractSceneModule {

    /**
     * 初始化基本信息
     *
     * @return void
     */
    protected function initConfig() {
        $this->app         = Plugin::translation( 'WordPress' );
        $this->name        = Plugin::translation( 'Post Single Page' );
        $this->description = Plugin::translation( 'Supported by default, You can config Wordpress Shortcode to display this template on a single post. only this template is allowed to be executed on a single post page for security reasons.' );
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