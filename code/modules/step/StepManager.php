<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;

/**
 * 步骤管理
 *
 * @author MoredealAiWriter
 */
class StepManager {

    /**
     * 根据类型获取步骤
     *
     * @param $step AbstractStepModule
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryByKey( $step ) {

        if ( empty( $step ) ) {
            throw new Exception( 'step is required' );
        }

        if ( ! isset( $step->key ) ) {
            throw new Exception( 'step key type is required' );
        }


        $step_base_class = 'MoredealAiWriter\\code\\modules\\step\\' . $step->key;
        if ( class_exists( $step_base_class ) ) {
            /**
             * @var AbstractStepModule $step_base_class
             */
            try {
                $base_step = $step_base_class::factoryObject( $step );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $base_step;
        }

        $step_ext_class = 'MoredealAiWriter\\extend\\modules\\step\\' . $step->key;
        if ( class_exists( $step_ext_class ) ) {
            try {
                $ext_step = $step_ext_class::factoryObject( $step );
            } catch ( Exception $e ) {
                throw new Exception( $e->getMessage() );
            }

            return $ext_step;
        }
        throw new Exception( $step->key . ' step key is not exist' );

    }

    /**
     * 根据 key获取步骤包装
     *
     * @param $stepWrapper
     *
     * @return mixed|StepWrapper
     * @throws Exception
     */
    public static function factoryWrapperByKey( $stepWrapper ) {

        $wrapper             = StepWrapper::factoryObject( $stepWrapper );
        $stepModule          = static::factoryByKey( $stepWrapper->stepModule );
        $wrapper->stepModule = $stepModule;

        return $wrapper;
    }

    /**
     * 获取标准步骤
     *
     * @return array
     */
    public static function get_standard_steps(): array {
        return array(
            OpenApiStepModule::getModuleKey(),
            OpenApiImageStepModule::getModuleKey(),
            StabilityAiImageStepModule::getModuleKey(),
            SearchProductStepModule::getModuleKey(),
        );
    }

    /**
     * 获取功能性步骤的 keys。比如 生成文章按钮，保存图片按钮
     *
     * @return array
     */
    public static function get_functional_step_keys(): array {
        return array(
            EmptyStepModule::getModuleKey(),
            CreatePostStepModule::getModuleKey(),
            UrlSaveStepModule::getModuleKey(),
            ViewPPTStepModule::getModuleKey(),
            Base64SaveStepModule::getModuleKey(),
        );
    }

    /**
     * 获取功能性步骤骤初始统计值
     * @return array
     */
    public static function get_functional_step_keys_count(): array {
        $count_array = array();
        foreach ( static::get_functional_step_keys() as $step ) {
            $count_array[ $step ] = 0;
        }

        return $count_array;
    }

    /**
     * 获取步骤列表
     *
     * @return array
     */
    public static function get_step_list(): array {
        return array(
            StepFactory::defDefaultTextStep(),
            StepFactory::defDefaultImageStep(),
            StepFactory::defDefaultCreatePostStep(),
            StepFactory::defDefaultSaveImagesStep(),
        );
    }

}
