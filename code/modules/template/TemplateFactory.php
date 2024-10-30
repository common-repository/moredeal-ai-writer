<?php

namespace MoredealAiWriter\code\modules\template;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\TemplateTypeConstant;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\scene\WPMetaBoxSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;
use MoredealAiWriter\code\modules\variable\SelectionVariableModule;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

defined( '\ABSPATH' ) || exit;

/**
 * 模版工厂，负责生产不同功能的模版
 *
 * @author Moredeal Ai Writer
 */
class TemplateFactory {

    const TEMPLATE_FACTORY = '\MoredealAiWriter\code\modules\template\TemplateFactory';

    /**
     * 模版映射表
     */
    const TEMPLATE_MAPPING = array(
        'custom'           => array( self::TEMPLATE_FACTORY, 'defCustomTemplate' ),
        'text'             => array( self::TEMPLATE_FACTORY, 'defTextTemplate' ),
        'image'            => array( self::TEMPLATE_FACTORY, 'defImageTemplate' ),
        'image_by_text'    => array( self::TEMPLATE_FACTORY, 'defImageByTextTemplate' ),
        'article'          => array( self::TEMPLATE_FACTORY, 'defArticleTemplate' ),
        'product_report'   => array( self::TEMPLATE_FACTORY, 'defProductReportTemplate' ),
        'post_title'       => array( self::TEMPLATE_FACTORY, 'defPostTitleTemplate' ),
        'post_excerpt'     => array( self::TEMPLATE_FACTORY, 'defPostExcerptTemplate' ),
        'translate_text'   => array( self::TEMPLATE_FACTORY, 'defTranslateTextTemplate' ),
        'improve_writing'  => array( self::TEMPLATE_FACTORY, 'defImproveWritingTemplate' ),
        'continue_writing' => array( self::TEMPLATE_FACTORY, 'defContinueWritingTemplate' ),
        'make_longer'      => array( self::TEMPLATE_FACTORY, 'defMakeLongerTemplate' ),
        'summarize_text'   => array( self::TEMPLATE_FACTORY, 'defSummarizeTextTemplate' ),
        'summarize_table'  => array( self::TEMPLATE_FACTORY, 'defSummarizeTableTemplate' ),
        'generate_table'   => array( self::TEMPLATE_FACTORY, 'defGenerateTableTemplate' ),
    );

    /**
     * 获取模版映射表
     *
     * @return array
     */
    private static function templateMapping(): array {
        return self::TEMPLATE_MAPPING;
    }

    /**
     * 根据模版标识，获取模版映射信息
     *
     * @param string $logotype 模版标识
     *
     * @return array
     * @throws Exception
     */
    public static function getTemplateMappingByLogotype( string $logotype ): array {
        if ( array_key_exists( $logotype, self::TEMPLATE_MAPPING ) ) {
            return self::TEMPLATE_MAPPING[ $logotype ];
        }

        throw new Exception( 'This ' . $logotype . ' template does not exist.' );
    }

    /**
     * 工厂方法, 创建不同功能的模版
     *
     * @param $source
     *
     * @return TemplateModule
     */
    public static function factory( $source ): TemplateModule {
        $template = TemplateModule::new();

        return ModuleConvertUtil::convert( $template, $source );
    }

    /**
     * 根据标识，创建不同功能的模版
     *
     * @param string $logotype 模版标识
     *
     * @return TemplateModule
     * @throws Exception
     */
    public static function factoryByLogotype( string $logotype ): TemplateModule {
        $templateMapping = self::getTemplateMappingByLogotype( $logotype );
        /**
         * @var TemplateModule $template
         */
        $template = call_user_func( $templateMapping );

        return $template;
    }

    /**
     * 获取系统推荐模版
     *
     * @return array
     */
    public static function getTemplateRecommend(): array {
        $template_list = array();
        foreach ( self::templateMapping() as $logotype => $templateMapping ) {
            // 免费版不显示自定义模版
            if ( $logotype === 'custom' && Plugin::is_free() ) {
                continue;
            }
            /**
             * @var TemplateModule $template
             */
            $template        = call_user_func( $templateMapping );
            $template_list[] = $template->getInfo();
        }

        return $template_list;
    }

    /**
     * 生成一个自定义模版
     *
     * @return TemplateModule
     */
    public static function defCustomTemplate(): TemplateModule {
        $customTemplate            = TemplateModule::new();
        $customTemplate->type      = TemplateTypeConstant::TYPE_CUSTOM()->getValue();
        $customTemplate->logotype  = 'custom';
        $customTemplate->name      = Plugin::translation( 'Custom Template' );
        $customTemplate->desc      = Plugin::translation( 'You can customize your template, personalize editing your steps, variables, and scenarios.' );
        $customTemplate->icon      = 'custom';
        $customTemplate->tags      = 'Custom Template';
        $customTemplate->topics    = 'Custom';
        $customTemplate->scenes    = SceneManager::default_scenes();
        $customTemplate->steps     = array( StepFactory::defDefaultTextStep() ); // 自定义模版默认显示一个生成文本的步骤
        $customTemplate->variables = array();

        return $customTemplate;
    }

    /**
     * 系统模版：文本模版
     *
     * @return TemplateModule
     */
    public static function defTextTemplate(): TemplateModule {
        $textTemplate            = TemplateModule::new();
        $textTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $textTemplate->logotype  = 'text';
        $textTemplate->name      = Plugin::translation( 'Generate Text' );
        $textTemplate->desc      = Plugin::translation( 'you can ask the AI to perform various tasks for you. You can ask it to write, rewrite, or translate an article, categorize words or elements into groups, write an email, etc.' );
        $textTemplate->icon      = 'text';
        $textTemplate->tags      = 'Text, System, Default';
        $textTemplate->topics    = 'Writing';
        $textTemplate->scenes    = SceneManager::default_scenes();
        $textTemplate->steps     = array( StepFactory::defDefaultTextStep() );
        $textTemplate->variables = array();

        return $textTemplate;
    }

    /**
     * 系统模版：图片模版
     *
     * @return TemplateModule
     */
    public static function defImageTemplate(): TemplateModule {
        $imageTemplate            = TemplateModule::new();
        $imageTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $imageTemplate->logotype  = 'image';
        $imageTemplate->name      = Plugin::translation( 'Generate Images' );
        $imageTemplate->desc      = Plugin::translation( 'Generate images from scratch based on a text prompt' );
        $imageTemplate->icon      = 'image';
        $imageTemplate->tags      = 'Image, System, Default';
        $imageTemplate->topics    = 'Image';
        $imageTemplate->scenes    = SceneManager::default_scenes();
        $imageTemplate->steps     = array(
            StepFactory::defDefaultImageStep(),
            StepFactory::defDefaultSaveImagesStep()
        );
        $imageTemplate->variables = array();

        return $imageTemplate;
    }

    /**
     * 系统模版：图片模版
     *
     * @return TemplateModule
     */
    public static function defImageByTextTemplate(): TemplateModule {
        $imageByTextTemplate            = TemplateModule::new();
        $imageByTextTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $imageByTextTemplate->logotype  = 'image_by_text';
        $imageByTextTemplate->name      = Plugin::translation( 'Generate Image By Content' );
        $imageByTextTemplate->desc      = Plugin::translation( 'Creating images from scratch based on content, We will analyze the content you provide and generate pictures for you.' );
        $imageByTextTemplate->icon      = 'image';
        $imageByTextTemplate->tags      = 'Image By Content, System, Default';
        $imageByTextTemplate->topics    = 'Image';
        $imageByTextTemplate->scenes    = SceneManager::default_scenes();
        $imageByTextTemplate->steps     = array(
            StepFactory::defImageContentTextStep(),
            StepFactory::defContentImageStep(),
            StepFactory::defDefaultSaveImagesStep()
        );
        $imageByTextTemplate->variables = array();

        return $imageByTextTemplate;
    }

    /**
     * 系统模版：文章模版
     *
     * @return TemplateModule
     */
    public static function defArticleTemplate(): TemplateModule {
        $articleTemplate            = TemplateModule::new();
        $articleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $articleTemplate->logotype  = 'article';
        $articleTemplate->name      = Plugin::translation( 'Generate Article' );
        $articleTemplate->desc      = Plugin::translation( 'Article generator is a powerful tool that can generate rich multi-paragraph article content for you' );
        $articleTemplate->icon      = 'file-document-outline';
        $articleTemplate->tags      = 'Article, Blog, System, Default';
        $articleTemplate->topics    = 'Writing, Blog';
        $articleTemplate->scenes    = SceneManager::default_scenes();
        $articleTemplate->steps     = array(
            StepFactory::defArticleTitleStep(),
            StepFactory::defArticleSectionsStep(),
            StepFactory::defArticleContentStep(),
            StepFactory::defArticleExcerptStep(),
            StepFactory::defDefaultCreatePostStep(),
        );
        $articleTemplate->variables = array(
            TextVariableModule::defTopicVariables(),
            SelectionVariableModule::defLanguageVariables(),
            SelectionVariableModule::defWritingStyleVariables(),
            SelectionVariableModule::defCheerfulVariables(),
            TextVariableModule::defModelTemperatureVariables(),
            TextVariableModule::defMaxTokensVariables(),
        );

        return $articleTemplate;
    }

    /**
     * 系统模版：产品报告模版
     *
     * @return TemplateModule
     */
    public static function defProductReportTemplate(): TemplateModule {
        $productTemplate            = TemplateModule::new();
        $productTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $productTemplate->logotype  = 'product_report';
        $productTemplate->name      = Plugin::translation( 'Generate Product Report' );
        $productTemplate->desc      = Plugin::translation( 'Product generator is a powerful tool that can analyze and optimize specific Product for you.' );
        $productTemplate->icon      = 'shopping-outline';
        $productTemplate->tags      = 'Product, Report, System, Default';
        $productTemplate->topics    = 'Amazon';
        $productTemplate->scenes    = SceneManager::default_scenes();
        $productTemplate->steps     = array(
            StepFactory::defProductSearchStep(),
            StepFactory::defProductOptimizationTitleStep(),
            StepFactory::defProductOptimizationDescriptionStep(),
            StepFactory::defProductOptimizationPointsStep(),
            StepFactory::defProductReportStep(),
        );
        $productTemplate->variables = array();

        return $productTemplate;
    }

    /**
     * 系统模版: 文章标题模版
     *
     * @return TemplateModule
     */
    public static function defPostTitleTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'post_title';
        $postTitleTemplate->name      = Plugin::translation( 'Generate Post Title' );
        $postTitleTemplate->desc      = Plugin::translation( 'Generate Post Title, In Post Meta Box Scene Use, You Can Use It In Edit Post Page For Generate Post Title' );
        $postTitleTemplate->icon      = 'post-title';
        $postTitleTemplate->tags      = 'Post Title, System, Default';
        $postTitleTemplate->topics    = 'Writing, Title';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPMetaBoxSceneModule::getModuleKey(), 'Titles' );
        $postTitleTemplate->steps     = array( StepFactory::defPostTitleStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 文章标题模版
     *
     * @return TemplateModule
     */
    public static function defPostExcerptTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'post_excerpt';
        $postTitleTemplate->name      = Plugin::translation( 'Generate Post Excerpt' );
        $postTitleTemplate->desc      = Plugin::translation( 'Generate Post Excerpt, In Post Meta Box Scene Use, You Can Use It In Edit Post Page For Generate Post Excerpt' );
        $postTitleTemplate->icon      = 'post-excerpt';
        $postTitleTemplate->tags      = 'Post Excerpt, System, Default';
        $postTitleTemplate->topics    = 'Writing, Excerpt';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPMetaBoxSceneModule::getModuleKey(), 'Excerpts' );
        $postTitleTemplate->steps     = array( StepFactory::defPostExcerptStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 文章标题模版
     *
     * @return TemplateModule
     */
    public static function defTranslateTextTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'translate_text';
        $postTitleTemplate->name      = Plugin::translation( 'Translate Text' );
        $postTitleTemplate->desc      = Plugin::translation( 'Translate Text, You Can Use It In Edit Post Page For Translate Post Content Or Other Scene' );
        $postTitleTemplate->icon      = 'translate-ext';
        $postTitleTemplate->tags      = 'Translate Text, System, Default';
        $postTitleTemplate->topics    = 'Writing, Translate';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Translate_Text' );
        $postTitleTemplate->steps     = array( StepFactory::defTranslateTextStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 改进写作模版
     *
     * @return TemplateModule
     */
    public static function defImproveWritingTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'improve_writing';
        $postTitleTemplate->name      = Plugin::translation( 'Improve Writing' );
        $postTitleTemplate->desc      = Plugin::translation( 'Improve Writing, You Can Use It In Edit Post Page For Improve Writing Post Content Or Other Scene' );
        $postTitleTemplate->icon      = 'improve-writing';
        $postTitleTemplate->tags      = 'Improve Writing, System, Default';
        $postTitleTemplate->topics    = 'Writing, Improve Writing';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Improve_Writing' );
        $postTitleTemplate->steps     = array( StepFactory::defImproveWritingStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 续写文本
     *
     * @return TemplateModule
     */
    public static function defContinueWritingTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'continue_writing';
        $postTitleTemplate->name      = Plugin::translation( 'Continue Writing' );
        $postTitleTemplate->desc      = Plugin::translation( 'Continue Writing, You Can Use It In Edit Post Page For Continue Writing Post Content Or Other Scene' );
        $postTitleTemplate->icon      = 'continue-writing';
        $postTitleTemplate->tags      = 'Continue Writing, System, Default';
        $postTitleTemplate->topics    = 'Writing, Continue Writing';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Continue_Writing' );
        $postTitleTemplate->steps     = array( StepFactory::defContinueWritingStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 增强文本
     *
     * @return TemplateModule
     */
    public static function defMakeLongerTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'make_longer';
        $postTitleTemplate->name      = Plugin::translation( 'Make Longer' );
        $postTitleTemplate->desc      = Plugin::translation( 'Make Longer Text, You Can Use It In Edit Post Page For Make Longer Post Content Or Other Scene' );
        $postTitleTemplate->icon      = 'make-longer';
        $postTitleTemplate->tags      = 'Make Longer, System, Default';
        $postTitleTemplate->topics    = 'Writing, Make Longer';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Make_Longer' );
        $postTitleTemplate->steps     = array( StepFactory::defMakeLongerStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 总结文本
     *
     * @return TemplateModule
     */
    public static function defSummarizeTextTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'summarize_text';
        $postTitleTemplate->name      = Plugin::translation( 'Summarize Text' );
        $postTitleTemplate->desc      = Plugin::translation( 'Summarize Text, You Can Use It In Edit Post Page For Summarize Post Content Or Other Scene' );
        $postTitleTemplate->icon      = 'summarize-text';
        $postTitleTemplate->tags      = 'Summarize Text, System, Default';
        $postTitleTemplate->topics    = 'Writing, Summarize Text';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Summarize_Text' );
        $postTitleTemplate->steps     = array( StepFactory::defSummarizeTextStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 总结文本成表格
     *
     * @return TemplateModule
     */
    public static function defSummarizeTableTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'summarize_table';
        $postTitleTemplate->name      = Plugin::translation( 'Summarize Table' );
        $postTitleTemplate->desc      = Plugin::translation( 'Summarize Table, You Can Use It In Edit Post Page For Summarize Post Table Or Other Scene' );
        $postTitleTemplate->icon      = 'summarize-table';
        $postTitleTemplate->tags      = 'Summarize Table, System, Default';
        $postTitleTemplate->topics    = 'Writing, Summarize Table';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Summarize_Table' );
        $postTitleTemplate->steps     = array( StepFactory::defSummarizeTableStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

    /**
     * 系统模版: 生成表格
     *
     * @return TemplateModule
     */
    public static function defGenerateTableTemplate(): TemplateModule {
        $postTitleTemplate            = TemplateModule::new();
        $postTitleTemplate->type      = TemplateTypeConstant::TYPE_SYSTEM()->getValue();
        $postTitleTemplate->logotype  = 'generate_table';
        $postTitleTemplate->name      = Plugin::translation( 'Generate Table' );
        $postTitleTemplate->desc      = Plugin::translation( 'Generate Table, You Can Use It In Edit Post Page For Generate Content To Table Or Other Scene' );
        $postTitleTemplate->icon      = 'generate-table';
        $postTitleTemplate->tags      = 'Generate Table, System, Default';
        $postTitleTemplate->topics    = 'Writing, Generate Table';
        $postTitleTemplate->scenes    = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Generate_Table' );
        $postTitleTemplate->steps     = array( StepFactory::defGenerateTableStep() );
        $postTitleTemplate->variables = array();

        return $postTitleTemplate;
    }

}