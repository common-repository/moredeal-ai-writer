<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 翻译文本 key
 *
 * @author MoredealAiWriter
 */
class TranslateTextTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Translate Text' );
        $this->desc   = Plugin::translation( 'Translate Text, You Can Use It In Edit Post Page For Translate Post Content Or Other Scene' );
        $this->topics = 'Writing, Translate';
        $this->icon   = 'post';
        $this->tags   = 'Translate Text';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Translate_Text' );
        $this->steps  = array( StepFactory::defTranslateTextStep() );
    }

}