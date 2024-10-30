<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 生成表格模版
 *
 * @author MoredealAiWriter
 */
class GenerateTableTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Generate Table' );
        $this->desc   = Plugin::translation( 'Generate Table, You Can Use It In Edit Post Page For Generate Content To Table Or Other Scene' );
        $this->topics = 'Writing, Table';
        $this->icon   = 'post';
        $this->tags   = 'Generate Table';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Generate_Table' );
        $this->steps  = array( StepFactory::defGenerateTableStep() );
    }

}