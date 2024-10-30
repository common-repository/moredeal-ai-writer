<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 生成文本模板
 *
 * @author MoredealAiWriter
 */
class TextTemplateModule extends AbstractTemplateModule {

    /**
     * 获取该对象时候使用
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
        $this->name   = Plugin::translation('Generate Text');
        $this->desc   = Plugin::translation('you can ask the AI to perform various tasks for you. You can ask it to write, rewrite, or translate an article, categorize words or elements into groups, write an email, etc.');
        $this->topics = 'Writing';
        $this->icon   = 'post';
        $this->tags   = 'Generate Text';
        $this->scenes = SceneManager::default_scenes();
        $this->steps  = array( StepFactory::defDefaultTextStep() );
    }

}