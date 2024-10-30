<?php

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\helpers\PostHelper;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;

/**
 * 文章编辑，元框中按钮编辑文章场景
 */
class WPMetaBoxSceneModule extends AbstractSceneModule {

    /**
     * 初始化配置
     * @return void
     */
    protected function initConfig() {
        $this->name        = Plugin::translation( 'Post Meta Box' );
        $this->app         = Plugin::translation( 'WordPress' );
        $this->description = Plugin::translation( 'In the Wordpress Post Editor Meta Box: The button in the meta box edits the article scenario' );;
        $this->docs_uri = "https://";
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

        $post_id = $context->getGlobalVariable( 'postId' );
        if ( empty( $post_id ) ) {
            throw new Exception( "Got a error, Post ID is required" );
        }

        $firstStep   = $context->getTemplate()->getFirstStep();
        $content_key = $context->existsStepVariableAndReturnFullKeyByStep( 'content', $firstStep->field );
        if ( ! $content_key ) {
            throw new Exception( "Got a error, This Template Step " . $firstStep->field . " need 'content' variable" );
        }
        $postId  = intval( $post_id );
        $content = PostHelper::get_clean_post_content( $postId );
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