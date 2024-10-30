<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;


use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepFactory;

/**
 * 生成商品报告模版
 *
 * @author MoredealAIWriter
 */
class ProductTemplateModule extends AbstractTemplateModule {

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
        $this->name   = Plugin::translation( 'Generate Product Report' );
        $this->desc   = Plugin::translation( 'Product generator is a powerful tool that can analyze and optimize specific Product for you' );
        $this->topics = 'Amazon';
        $this->icon   = 'shopping-outline';
        $this->tags   = 'Tested';
        $this->scenes = SceneManager::default_scenes();
        $this->steps  = array(
            StepFactory::defProductSearchStep(),
            StepFactory::defProductOptimizationTitleStep(),
            StepFactory::defProductOptimizationDescriptionStep(),
            StepFactory::defProductOptimizationPointsStep(),
            StepFactory::defProductReportStep(),
        );
    }

}