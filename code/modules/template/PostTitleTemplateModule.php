<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPMetaBoxSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 生成文章标题模版
 *
 * @author MoredealAiWriter
 */
class PostTitleTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Generate Post Title' );
        $this->desc   = Plugin::translation( 'Generate Post Title, In Post Meta Box Scene Use, You Can Use It In Edit Post Page For Generate Post Title' );
        $this->topics = 'Writing, Title';
        $this->icon   = 'post';
        $this->tags   = 'Generate Post Title';
        $this->scenes = SceneManager::default_scenes_push_one( WPMetaBoxSceneModule::getModuleKey(), 'Titles' );
        $this->steps  = array( StepFactory::defPostTitleStep() );
    }

}