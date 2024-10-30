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
class MakeLongerTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Make Longer' );
        $this->desc   = Plugin::translation( 'Make Longer Text, You Can Use It In Edit Post Page For Make Longer Post Content Or Other Scene' );
        $this->topics = 'Writing, Make Longer';
        $this->icon   = 'post';
        $this->tags   = 'Make Longer';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Make_Longer' );
        $this->steps  = array( StepFactory::defMakeLongerStep() );
    }

}