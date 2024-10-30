<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 扩展文本模版
 *
 * @author MoredealAiWriter
 */
class ContinueWritingTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation('Continue Writing');
        $this->desc   = Plugin::translation('Continue Writing, You Can Use It In Edit Post Page For Continue Writing Post Content Or Other Scene');
        $this->topics = 'Writing, Extend';
        $this->icon   = 'post';
        $this->tags   = 'Continue Writing';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Continue_Writing' );
        $this->steps  = array( StepFactory::defContinueWritingStep() );
    }

}