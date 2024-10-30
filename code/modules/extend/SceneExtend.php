<?php

namespace MoredealAiWriter\code\modules\extend;

use Exception;
use MoredealAiWriter\code\consts\EventCodeConst;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\event\BaseEventModule;
use MoredealAiWriter\code\modules\scene\AbstractSceneModule;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\AbstractStepModule;

/**
 * 场景基本扩展
 */
class SceneExtend extends AbstractBaseExtend {

    /**
     * 获取该对象
     *
     * @param $object
     *
     * @return mixed
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 加载扩展
     *
     * @param AbstractContextModule $context
     *
     * @return void
     */
    public function initExtend( AbstractContextModule $context ) {
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_PRE()->getValue(), array(
            $this,
            "event_scene_event_temp_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_TEMP_POST()->getValue(), array(
            $this,
            "event_scene_event_temp_post"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_PRE()->getValue(), array(
            $this,
            "event_scene_event_step_pre"
        ) ) );
        $context->addEvent( BaseEventModule::newEvent( EventCodeConst::EVENT_STEP_POST()->getValue(), array(
            $this,
            "event_scene_event_step_post"
        ) ) );
    }

    /**
     * 模版执行前
     *
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public function event_scene_event_temp_pre( AbstractContextModule $context ) {
        try {
            // 1 基础校验
            $base_verify = $this->base_verify( $context );
            if ( ! $base_verify ) {
                throw new Exception( "scene verify fail" );
            }

            $scene_key = $context->get_scene_key();

            // 属于默认场景不做校验
            if ( in_array( $scene_key, SceneManager::default_scene_keys() ) ) {
                return;
            }

            /**
             * @var $scene AbstractSceneModule
             */
            $scene = SceneManager::factoryScene( $scene_key );
            // 执行前校验，处理
            $scene->handler_tmp_before( $scene, $context );

        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    /**
     * 模版执行后
     *
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public function event_scene_event_temp_post( AbstractContextModule $context ) {
        try {

            $scene_key = $context->get_scene_key();

            // 属于默认场景不做校验
            if ( in_array( $scene_key, SceneManager::default_scene_keys() ) ) {
                return;
            }

            /**
             * @var $scene AbstractSceneModule
             */
            $scene = SceneManager::factoryScene( $scene_key );
            // 执行前校验，处理
            $scene->handler_tmp_after( $scene, $context );

        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    /**
     * 步骤执行前
     *
     * @param AbstractContextModule $context
     * @param AbstractStepModule    $stepModule
     *
     * @return void
     * @throws Exception
     */
    public function event_scene_event_step_pre( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        try {
            // 只在第一步进行校验
            if ( $context->getTemplate()->getFirstStep()->stepModule->key != $stepModule->key ) {
                return;
            }

            $scene_key = $context->get_scene_key();

            // 属于默认场景不做校验
            if ( in_array( $scene_key, SceneManager::default_scene_keys() ) ) {
                return;
            }

            /**
             * @var $scene AbstractSceneModule
             */
            $scene = SceneManager::factoryScene( $scene_key );
            // 执行前校验，处理
            $scene->handler_step_before( $scene, $context, $stepModule );

        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    /**
     * 步骤执行后
     *
     * @param AbstractContextModule $context
     * @param AbstractStepModule    $stepModule
     *
     * @return void
     * @throws Exception
     */
    public function event_scene_event_step_post( AbstractContextModule $context, AbstractStepModule $stepModule ) {
        try {
            // 只在第一步进行校验
            if ( $context->getTemplate()->getFirstStep()->stepModule->key != $stepModule->key ) {
                return;
            }
            $scene_key = $context->get_scene_key();

            // 属于默认场景不做校验
            if ( in_array( $scene_key, SceneManager::default_scene_keys() ) ) {
                return;
            }
            
            /**
             * @var $scene AbstractSceneModule
             */
            $scene = SceneManager::factoryScene( $scene_key );
            // 执行前校验，处理
            $scene->handler_step_after( $scene, $context, $stepModule );

        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }

    /**
     * 基础验证
     *
     * @param AbstractContextModule $context
     *
     * @return bool
     * @throws Exception
     */
    public function base_verify( AbstractContextModule $context ): bool {

        $scenes = $context->getTemplate()->scenes;
        if ( empty( $scenes ) ) {
            throw new Exception( 'Got a error, This template has no scenes. Unable to execute the template based on the scenario' );
        }

        $scene_key = $context->get_scene_key();
        if ( empty( $scene_key ) ) {
            throw new Exception( "Got a error, If the template needs to be executed based on the scenario, the scenario key is required" );
        }

        // 默认场景直接跳过
        if ( in_array( $scene_key, SceneManager::default_scene_keys() ) ) {
            return true;
        }

        if ( ! in_array( $scene_key, SceneManager::get_scene_keys( $scenes ) ) ) {
            error_log( 'Got a error, this template Unsupported this scene ' . $scene_key );
            throw new Exception( 'Got a error, this template Unsupported this scene ' . $scene_key );
        }

        return true;
    }
}