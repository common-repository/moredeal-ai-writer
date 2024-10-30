<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 文本增强模版
 *
 * @author MoredealAiWriter
 */
class ImproveWritingTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Improve Writing' );
        $this->desc   = Plugin::translation( 'Improve Writing, You Can Use It In Edit Post Page For Improve Writing Post Content Or Other Scene' );
        $this->topics = "Writing, ImproveWriting";
        $this->icon   = 'post';
        $this->tags   = 'ImproveWriting';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Improve_Writing' );
        $this->steps  = array( StepFactory::defImproveWritingStep() );
    }

}