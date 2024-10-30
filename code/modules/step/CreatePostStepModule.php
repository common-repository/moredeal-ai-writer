<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\WpRestfulClient;
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
use MoredealAiWriter\code\modules\step\response\EmptyResponseModule;
use MoredealAiWriter\code\modules\util\LogUtil;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

/**
 * 生成文章执行步骤
 *
 * @author MoredealAiWriter
 */
class CreatePostStepModule extends AbstractStepModule {

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
        $this->name         = Plugin::translation( 'Create Post' );
        $this->desc         = Plugin::translation( 'Generate articles to your article list as drafts based on the steps of Title, Content, and Excerpt.' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->type         = StepTypeConstant::TYPE_ADAPTER()->getValue();
        $this->sourceUrl    = '';
        $this->tags         = array( 'WordPress', Plugin::translation( 'Create Post' ) );
        $this->isAuto       = false;
        $this->isCanAddStep = false;
        $this->icon         = Plugin::plugin_res() . '/images/post.svg';
        $this->scenes       = array( WPAdminSceneModule::of(), WPAdminTemplateMarketSceneModule::of() );
        $this->variables    = array(
            self::defTitleVariable(),
            self::defContentVariable(),
            self::defExcerptVariable(),
        );
        $this->response     = EmptyResponseModule::defResponse();
    }

    /**
     * 执行生成文章到文章列表
     *
     * @param AbstractContextModule $context
     *
     * @return AbstractResponseModule
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {
        $model_price  = LogUtil::build_model_price( 'create_post' );
        $post_title   = $context->getStepVariable( 'create_post_title' ) ?? '';
        $post_content = $context->getStepVariable( 'create_post_content' ) ?? '';
        $post_excerpt = $context->getStepVariable( 'create_post_excerpt' ) ?? '';

        if ( empty( $post_title ) ) {
            $this->response->error( 'post title is required' );

            return $this->response;
        }

        if ( empty( $post_content ) ) {
            $this->response->error( 'post content is required' );
            $this->response->setProcessParams( LogUtil::build_process( $context, $context, null, $this->response->status, $model_price ) );

            return $this->response;
        }

        $post_data = array(
            'post_title'   => wp_strip_all_tags( $post_title ),
            'post_content' => sanitize_textarea_field( $post_content ),
            'post_excerpt' => sanitize_text_field( $post_excerpt ),
        );

        $result = WpRestfulClient::getInstance()->create_post( $post_data );
        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            $this->response->error( $result['message'] ?? Plugin::translation( 'create post failure, place try again!' ) );
            $this->response->setProcessParams( LogUtil::build_process( $context, $post_data, $result, $this->response->status, $model_price ) );

            return $this->response;
        }
        $link = $result['data'];
        $this->response->success( $link, 'create post success' );
        $this->response->setProcessParams( LogUtil::build_process( $context, $post_data, $result, $this->response->status, $model_price ) );

        return $this->response;
    }

    /**
     * 定义标题变量
     *
     * @return TextVariableModule
     */
    public static function defTitleVariable(): TextVariableModule {
        $title_variable           = TextVariableModule::new();
        $title_variable->field    = "create_post_title";
        $title_variable->label    = Plugin::translation( 'Title Out' );
        $title_variable->desc     = Plugin::translation( 'Title Out is the Title Step response. you can entry the {STEP.TITLE._OUT} or yor custom title' );
        $title_variable->default  = "{STEP.TITLE._OUT}";
        $title_variable->order    = 1;
        $title_variable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $title_variable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $title_variable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $title_variable->is_point = true;
        $title_variable->is_show  = false;

        return $title_variable;
    }

    /**
     * 定义内容变量
     *
     * @return TextVariableModule
     */
    public static function defContentVariable(): TextVariableModule {
        $content_variable           = TextVariableModule::new();
        $content_variable->field    = "create_post_content";
        $content_variable->label    = Plugin::translation( 'Content Out' );
        $content_variable->desc     = Plugin::translation( 'Content Out is the Content Step response, you can entry the {STEP.CONTENT._OUT} or yor custom content' );
        $content_variable->default  = "{STEP.CONTENT._OUT}";
        $content_variable->order    = 2;
        $content_variable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $content_variable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $content_variable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $content_variable->is_point = true;
        $content_variable->is_show  = false;

        return $content_variable;
    }

    /**
     * 定义摘录变量
     *
     * @return TextVariableModule
     */
    public static function defExcerptVariable(): TextVariableModule {
        $excerpt_variable           = TextVariableModule::new();
        $excerpt_variable->field    = "create_post_excerpt";
        $excerpt_variable->label    = Plugin::translation( 'Excerpt Out' );
        $excerpt_variable->desc     = Plugin::translation( 'Excerpt Out is the Excerpt Step response, you can entry the {STEP.EXCERPT._OUT} or yor custom excerpt' );
        $excerpt_variable->default  = "{STEP.EXCERPT._OUT}";
        $excerpt_variable->order    = 3;
        $excerpt_variable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $excerpt_variable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $excerpt_variable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $excerpt_variable->is_point = true;
        $excerpt_variable->is_show  = false;

        return $excerpt_variable;
    }
}