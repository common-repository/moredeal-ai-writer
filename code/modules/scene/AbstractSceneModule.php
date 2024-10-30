<?php

namespace MoredealAiWriter\code\modules\scene;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * 场景模块
 *
 * @author MoredealAiWriter
 */
abstract class AbstractSceneModule extends BaseModule {

    /**
     * 应用
     *
     * @var string
     */
    public $app;

    /**
     * 类型 key
     *
     * @var string
     */
    public $key;

    /**
     * 名称
     *
     * @var string
     */
    public $name;

    /**
     * 短名称
     * @var string
     */
    public $short_name;

    /**
     * 描述
     *
     * @var string
     */
    public $description;

    /**
     * 默认模版
     * @var string
     */
    public $default_template;

    /**
     * 文档地址
     *
     * @var string
     */
    public $docs_uri;

    /**
     * 初始化配置
     *
     * @return mixed
     */
    protected abstract function initConfig();

    /**
     * 保存模版 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractTemplateModule $template
     *
     * @return void
     * @throws Exception
     */
    public abstract function save_before( AbstractSceneModule $scene, AbstractTemplateModule $template );

    /**
     * 保存模版 后置处理函数
     *
     * @return void
     */
    public abstract function save_after( AbstractSceneModule $scene, AbstractTemplateModule $template );

    /**
     * 模版执行 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public abstract function handler_tmp_before( AbstractSceneModule $scene, AbstractContextModule $context );

    /**
     * 步骤执行 前置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     * @param AbstractStepModule $stepModule
     *
     * @return void
     * @throws Exception
     */
    public abstract function handler_step_before( AbstractSceneModule $scene, AbstractContextModule $context, AbstractStepModule $stepModule );

    /**
     * 模版执行 后置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     *
     * @return void
     * @throws Exception
     */
    public abstract function handler_tmp_after( AbstractSceneModule $scene, AbstractContextModule $context );

    /**
     * 模版执行 后置处理函数
     *
     * @param AbstractSceneModule $scene
     * @param AbstractContextModule $context
     * @param AbstractStepModule $stepModule
     *
     * @return void
     * @throws Exception
     */
    public abstract function handler_step_after( AbstractSceneModule $scene, AbstractContextModule $context, AbstractStepModule $stepModule );

    /**
     * 新建场景
     *
     *
     * @param string $name
     * @param string $description
     *
     * @param string $key_suffix
     * @param null $default_template
     *
     * @return AbstractSceneModule
     */
    public static function of( string $name = '', string $description = '', string $key_suffix = '', $default_template = null ): AbstractSceneModule {
        $scene = static::new();
        if ( empty( $key_suffix ) ) {
            if ( ! empty( $name ) ) {
                $scene->name = $name;
            }
            if ( ! empty( $description ) ) {
                $scene->description = $description;
            }

            return $scene;
        }
        $scene->key = $scene->key . '_' . ucwords( $key_suffix );
        if ( ! empty( $name ) ) {
            $scene->name = $name;
        } else {
            $scene->name = $scene->name . ' ' . ucwords( $key_suffix );
        }

        $scene->short_name = str_replace( '_', ' ', ucwords( $key_suffix ) );

        if ( ! empty( $description ) ) {
            $scene->description = $description;
        } else {
            $scene->description = $scene->description . ' ' . ucwords( $key_suffix );
        }

        if ( ! empty( $default_template ) ) {
            $scene->default_template = $default_template;
        }

        return $scene;
    }

    /**
     * 新建场景
     *
     *
     * @param string $key_suffix
     *
     * @return string
     */
    public static function of_scene_key( string $key_suffix = '' ): string {
        if ( empty( $key_suffix ) ) {
            return static::getModuleKey();
        }

        return static::getModuleKey() . '_' . ucwords( $key_suffix );
    }

    /**
     * 初始化
     * @return void
     */
    public function init() {
        $this->key = static::getModuleKey();
        $this->initConfig();
    }

    /**
     * 获取场景基本信息
     *
     * @return array
     */
    public function get_info(): array {
        return array(
            'key'             => $this->key,
            'name'            => $this->name,
            'shortName'       => $this->short_name,
            'description'     => $this->description,
            'defaultTemplate' => $this->default_template,
        );
    }

    /**
     * 获取对象使用
     *
     * @param $object
     *
     * @return mixed
     */
    public static function factoryObject( $object ) {
        $name       = $object->name ?? '';
        $desc       = $object->description ?? '';
        $key_suffix = $object->key_suffix ?? '';

        $self              = static::of( $name, $desc, $key_suffix );
        $self              = ModuleConvertUtil::convert( $self, $object );
        $self->name        = Plugin::translation( $self->name ?? '' );
        $self->description = Plugin::translation( $self->description ?? '' );

        return $self;
    }

}