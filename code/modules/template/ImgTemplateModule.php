<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 生成图片模版
 *
 * @author MoredealAiWriter
 */
class  ImgTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Generate Images' );
        $this->desc   = Plugin::translation( 'Creating images from scratch based on a text prompt' );
        $this->icon   = 'image-area';
        $this->topics = 'Writing';
        $this->tags   = 'system';
        $this->scenes = SceneManager::default_scenes();
        $this->steps  = array(
            StepFactory::defDefaultImageStep(),
            StepFactory::defDefaultSaveImagesStep()
        );
    }
}