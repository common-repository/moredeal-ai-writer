<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\code\consts\TemplateTypeConstant;
use MoredealAiWriter\code\modules\scene\SceneManager;

/**
 * 模版，基础模版模块，后续将改成所有的模版都会由此模版配置出来
 *
 * @author MoredealAiWriter
 */
class TemplateModule extends AbstractTemplateModule {

    /**
     * 获取对象时候使用
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
        $this->type   = TemplateTypeConstant::TYPE_CUSTOM()->getValue();
        $this->scenes = SceneManager::default_scenes();
    }

}