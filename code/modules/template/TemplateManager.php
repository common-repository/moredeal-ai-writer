<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\models\TemplateModel;
use MoredealAiWriter\code\modules\context\BaseContextModule;
use MoredealAiWriter\code\modules\extend\ExtendManager;

/**
 * TemplateManager 模版管理器
 *
 * @author MoredealAiWriter
 */
class  TemplateManager {

    /**
     * 模版信息
     *
     * @var AbstractTemplateModule
     */
    private $template;

    /**
     * 构造函数
     */
    private function __construct() {
    }

    /**
     * 获取模版信息
     *
     * @return AbstractTemplateModule
     */
    public function getTemplate(): AbstractTemplateModule {

        return $this->template;
    }

    /**
     * 根据模版生成一个模版管理器
     *
     * @param AbstractTemplateModule $template 模版信息
     *
     * @return TemplateManager
     */
    public static function factory( AbstractTemplateModule $template ): TemplateManager {
        $instance           = new self();
        $instance->template = $template;

        return $instance;
    }

    /**
     * 根据模版 Id 获取一个模版管理器
     *
     * @param int $tmpId 模版 Id
     *
     * @return TemplateManager
     * @throws Exception
     */
    public static function factoryById( int $tmpId ): TemplateManager {
        // 获取模版信息
        $templateModel = TemplateModel::getInstance()->templateDetail( $tmpId );
        if ( empty( $templateModel ) || empty( $templateModel->info ) ) {
            throw new Exception( 'Got an error, The template is not exist or template info is not exist!' );
        }

        /**
         * @var AbstractTemplateModule $template
         */
        $template              = $templateModel->info;
        $manager               = static::factory( $template );
        $manager->template->id = $tmpId;

        return $manager;
    }

    /**
     * 根据模版编码获取一个模版管理器
     *
     * @param string $tmpCode 模版编码
     *
     * @return TemplateManager
     * @throws Exception
     */
    public static function factoryByCode( string $tmpCode ): TemplateManager {

        if ( empty( $tmpCode ) ) {
            throw new Exception( 'Template type is required' );
        }

        $template_base_class = 'MoredealAiWriter\\code\\modules\\template\\' . $tmpCode;
        if ( class_exists( $template_base_class ) ) {
            /**
             * @var AbstractTemplateModule $template_base_class
             */
            return static::factory( $template_base_class::new() );
        }

        $template_ext_class = 'MoredealAiWriter\\extend\\modules\\template\\' . $tmpCode;
        if ( class_exists( $template_ext_class ) ) {
            return static::factory( $template_ext_class::new() );
        }
        throw new Exception( $tmpCode . ' Template type is not exist' );

    }

    /**
     * 根据模版标识获取一个模版管理器
     *
     * @param string $logotype
     *
     * @return TemplateManager
     * @throws Exception
     */
    public static function factoryByLogotype( string $logotype ): TemplateManager {

        if ( empty( $logotype ) ) {
            throw new Exception( 'Template logotype is required' );
        }

        try {
            $template_module = TemplateFactory::factoryByLogotype( $logotype );

            return static::factory( $template_module );
        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }

    }

    /**
     * 根据类型 key 获取模版数据
     *
     * @param $info
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryByKey( $info ) {

        if ( empty( $info ) ) {
            throw new Exception( 'Template info is required' );
        }
        if ( empty( $info->key ) ) {
            throw new Exception( 'Template key is required' );
        }
        $template_base_class = 'MoredealAiWriter\\code\\modules\\template\\' . $info->key;
        if ( class_exists( $template_base_class ) ) {
            /**
             * @var  $template_base_class AbstractTemplateModule
             */
            try {
                $template = $template_base_class::factoryObject( $info );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $template;
        }

        $template_ext_class = 'MoredealAiWriter\\extend\\modules\\template\\' . $info->key;
        if ( class_exists( $template_ext_class ) ) {
            try {
                $ext_template = $template_ext_class::factoryObject( $info );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_template;
        }
        throw new Exception( $info->key . ' Template type is not exist' );
    }

    /**
     * 执行模版
     *
     * @param $instanceId
     * @param $stepField
     * @param $sceneKey
     * @param $variable
     *
     * @return TemplateExecuteResponse
     * @throws Exception
     */
    public function executeScene( $instanceId, $stepField, $sceneKey, $variable ): TemplateExecuteResponse {
        return $this->executeDefault( $instanceId, $stepField, $sceneKey, $variable );
    }

    /**
     * 执行模版
     *
     * @param        $instanceId
     * @param        $stepField
     * @param        $sceneKey
     * @param array  $variable 变量
     *
     * @return TemplateExecuteResponse
     * @throws Exception
     */
    public function executeDefault( $instanceId, $stepField, $sceneKey, array $variable = [] ): TemplateExecuteResponse {

        $tmp = $this->getTemplate();

        //判断stepCode 是否存在

        if ( empty( $stepField ) ) {
            //取第一个
            $stepField = ! empty( $tmp->getFirstStep() ) ? $tmp->getFirstStep()->field : null;
        }

        if ( empty( $sceneKey ) ) {
            //取第一个
            $sceneKey = ! empty( $tmp->getFirstScene() ) ? $tmp->getFirstScene()->key : "";
        }

        $context = new BaseContextModule( $this->getTemplate(), $variable );
        $context->set_scene_key( $sceneKey );
        $context->set_isstream(json_encode($variable["stream"]));

        ExtendManager::_init( $context );

//		if ( empty( $instanceId ) ) {
//			//创建一个执行事例
//			$instanceModel = TemplateInstanceModel::getInstance()->createTable();
//			$instanceId    = 1;
//		} else {
//
//			$instanceModel = TemplateInstanceModel::getInstance()->findById( $instanceId );
//		}

        $context->setInstanceId( $instanceId );

        $context->runEventTempPre();

        $run          = false;
        $lastResponse = null;
        /**
         * @var $step \MoredealAiWriter\code\modules\step\StepWrapper
         */
        foreach ( $this->template->steps as $key => $step ) {

            //从指定的step开始执行
            if ( $step->field == $stepField ) {

                $context->setStepField( $stepField );
                $lastResponse = $step->_execute( $context );
//
//				if ( ! $lastResponse->status ) {
//					break;
//				}
                break;
            }
        }

        $response              = new TemplateExecuteResponse( $lastResponse );
        $response->instanceId  = $instanceId;
        $response->gmtModified = date( 'Y-m-d H:i:s', ( new \DateTime() )->getTimestamp() );
        $response->stepField   = $stepField;

        if ( $lastResponse->status ) {
            $context->runEventTempPost();
        }

        //增加返回结果到 事例表中 addResponse()

        //保存事例

        return $response;

    }


}