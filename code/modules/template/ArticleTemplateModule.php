<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepFactory;
use MoredealAiWriter\code\modules\variable\SelectionVariableModule;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

/**
 * 生成文章模版
 *
 * @author MoredealAiWriter
 */
class  ArticleTemplateModule extends AbstractTemplateModule {

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
        parent::initConfig();
        $this->name      = Plugin::translation('Generate Article');
        $this->desc      = Plugin::translation('Article generator is a powerful tool that can generate rich multi-paragraph article content for you.');
        $this->topics    = 'Writing';
        $this->icon      = 'file-document-outline';
        $this->tags      = 'system';
        $this->variables = [
            TextVariableModule::defTopicVariables(),
            SelectionVariableModule::defLanguageVariables(),
            SelectionVariableModule::defWritingStyleVariables(),
            SelectionVariableModule::defCheerfulVariables(),
            TextVariableModule::defModelTemperatureVariables(),
            TextVariableModule::defMaxTokensVariables(),
        ];
        $this->scenes    = SceneManager::default_scenes();
        $this->steps     = [
            StepFactory::defArticleTitleStep(),
            StepFactory::defArticleSectionsStep(),
            StepFactory::defArticleContentStep(),
            StepFactory::defArticleExcerptStep(),
            StepFactory::defDefaultCreatePostStep(),
        ];
    }

}