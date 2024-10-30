<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\scene\WPBlockRightSceneModule;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 总结表格模版
 *
 * @author MoredealAiWriter
 */
class SummarizeTableTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Summarize Table' );
        $this->desc   = Plugin::translation( 'Summarize Table, You Can Use It In Edit Post Page For Summarize Post Table Or Other Scene' );
        $this->topics = 'Writing, Summarize, Table';
        $this->icon   = 'post';
        $this->tags   = 'Summarize Table';
        $this->scenes = SceneManager::default_scenes_push_one( WPBlockRightSceneModule::getModuleKey(), 'Summarize_Table' );
        $this->steps  = array( StepFactory::defSummarizeTableStep() );
    }

}