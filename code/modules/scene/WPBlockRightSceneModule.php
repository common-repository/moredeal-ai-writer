<?php
/**
 * 扩展管理
 */

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\helpers\TextHelper;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;

/**
 * wp 文章编辑 BLOCK 下 右键点击呼出的按钮
 *
 * @author MoredealAiWriter
 */
class WPBlockRightSceneModule extends AbstractSceneModule {

    /**
     * 初始化配置
     * @return void
     */
    protected function initConfig() {
        $this->name        = Plugin::translation( 'Post Block Right' );
        $this->app         = Plugin::translation( 'WordPress' );
        $this->description = Plugin::translation( 'In the Wordpress post Block Editor Toolbar, right click option the block content' );
        $this->docs_uri    = "https://";
    }

    /**
     * 获取该场景
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
     * 保存模版 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractTemplateModule $template
     *
     * @return void
     * @throws Exception
     */
    public function save_before( AbstractSceneModule $scene, AbstractTemplateModule $template ) {
        $step_wrapper = $template->getFirstStep();
        $variables    = $step_wrapper->variables;
        if ( empty( $variables ) ) {
            throw new Exception( Plugin::translation( "Got an Error! This Template is need 'content' variable! The variable field must be called 'content'" ) );
        }
        $variables_fields = array_column( $variables, 'field' );
        if ( ! in_array( 'content', $variables_fields ) ) {
            throw new Exception( Plugin::translation( "Got an Error! This Template is need 'content' variable! The variable field must be called 'content'" ) );
        }
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
        $global_content = $context->getGlobalVariable( 'content' );
        if ( empty( $global_content ) ) {
            throw new Exception( "Got a error, content is required" );
        }

        $firstStep   = $context->getTemplate()->getFirstStep();
        $content_key = $context->existsStepVariableAndReturnFullKeyByStep( 'content', $firstStep->field );
        if ( ! $content_key ) {
            throw new Exception( "Got a error, This Template Step " . $firstStep->field . " need 'content' variable" );
        }

        $content = TextHelper::clean_text( $global_content );
        $context->pushVariable( $content_key, $content );
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