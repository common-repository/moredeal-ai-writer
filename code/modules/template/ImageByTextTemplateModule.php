<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 根据文本生成图片模版
 *
 * @author MoredealAiWriter
 */
class ImageByTextTemplateModule extends AbstractTemplateModule {

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
        parent::initConfig();
        $this->name   = Plugin::translation( 'Generate Image By Content' );
        $this->desc   = Plugin::translation( 'Creating images from scratch based on content, We will analyze the content you provide and generate pictures for you.' );
        $this->topics = 'Writing, Image';
        $this->icon   = 'image';
        $this->tags   = 'Image, Content';
        $this->scenes = SceneManager::default_scenes();
        $this->steps  = array(
            StepFactory::defImageContentTextStep(),
            StepFactory::defContentImageStep(),
            StepFactory::defDefaultSaveImagesStep()
        );
    }

}