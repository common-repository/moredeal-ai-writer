<?php

namespace MoredealAiWriter\code\modules\template;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\AbstractSceneModule;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepManager;
use MoredealAiWriter\code\modules\step\StepWrapper;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;
use MoredealAiWriter\code\modules\variable\AbstractVariableModule;
use MoredealAiWriter\code\modules\variable\VariableManager;

/**
 * Class AbstractTemplateModule
 *
 * @author MoredealAiWriter
 */
abstract class AbstractTemplateModule extends BaseModule {

    /**
     * 版本
     *
     * @var int
     */
    public $version = 1;

    /**
     * 模板 id
     *
     * @var int
     */
    public $id;

    /**
     * 模板 key
     *
     * @var string
     */
    public $key;

    /**
     * 类型 1.系统(不可编辑 Step) 2.自定义
     *
     * @var string
     */
    public $type;

    /**
     * 标识，当 key 的值为 TemplateModule 时，需要传入的参数。
     *
     * @var string
     */
    public $logotype;

    /**
     * 应用
     *
     * @var string
     */
    public $name;

    /**
     * 位子
     *
     * @var string
     */
    public $desc;

    /**
     * 图标
     *
     * @var string
     */
    public $icon;

    /**
     * Undocumented variable
     *
     * @var string
     */
    public $tags;

    /**
     * 主题
     *
     * @var
     */
    public $topics;

    /**
     * 场景
     *
     * @var AbstractSceneModule[]
     */
    public $scenes = [];

    /**
     * @var StepWrapper[]
     */
    public $steps = [];

    /**
     * 变量
     * @var AbstractVariableModule[]
     */
    public $variables = [];

    /**
     * @var $context AbstractContextModule
     */
    public $context;

    /**
     * 初始化
     *
     * @return void
     */
    public function init() {

        $this->key = static::getModuleKey();
        $this->initConfig();
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {

    }

    /**
     * 获取模版基本信息
     *
     * @return array
     */
    public function getInfo(): array {
        $stepIcons     = array();
        $step_wrappers = $this->steps;
        foreach ( $step_wrappers as $step_wrapper ) {
            $step        = $step_wrapper->stepModule;
            $stepIcons[] = $step->icon;
        }

        $topics = explode( ',', $this->topics );

        $seastarRestfulClient = new SeastarRestfulClient();
        $image                = $seastarRestfulClient->handleCommonDefaultImage( $topics );

        return [
            'key'        => $this->key,
            'name'       => $this->name,
            'desc'       => $this->desc,
            'icon'       => $this->icon,
            'type'       => $this->type,
            'logotype'   => $this->logotype,
            'tags'       => explode( ',', $this->tags ),
            'topics'     => $topics,
            'image_urls' => $image,
            'stepIcons'  => $stepIcons,
        ];
    }

    /**
     * 根据 field 获取 step
     *
     * @param $field
     *
     * @return false|StepWrapper
     */
    public function getStepByField( $field ) {
        if ( empty( $this->steps ) ) {
            return false;
        }

        foreach ( $this->steps as $step ) {
            if ( $step->field == $field ) {
                return $step;
            }
        }

        return false;

    }

    /**
     * 获取第一个步骤
     *
     * @return null|StepWrapper
     */
    public function getFirstStep() {

        if ( ! empty( $this->steps ) ) {
            return current( $this->steps );
        }

        return null;
    }

    /**
     * 获取上一个步骤
     *
     * @param $key
     *
     * @return null|StepWrapper
     */
    public function getPreStep( $key ) {

        $preStep = $this->getFirstStep();
        foreach ( $this->steps as $step ) {
            if ( $step->field == $key ) {
                break;
            }
            $preStep = $step;
        }

        return $preStep;
    }

    /**
     * 获取第一个场景
     *
     * @return null|AbstractSceneModule
     */
    public function getFirstScene() {
        if ( ! empty( $this->scenes ) ) {
            return current( $this->scenes );
        }

        return null;
    }

    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryObject( $object ) {
        $self = static::new();
        $self = ModuleConvertUtil::convert( $self, $object );

        if ( is_array( $self->scenes ) ) {
            $sceneList = $self->scenes;
        } else if ( is_object( $self->scenes ) ) {
            $sceneList = (array) $self->scenes;
        } else if ( is_string( $self->scenes ) ) {
            $sceneList = json_decode( $self->scenes, true );
        } else {
            $sceneList = [];
        }

        // 场景
        foreach ( $sceneList as $index => $scene ) {
            /**
             * @var $scene AbstractSceneModule
             */
            $scene               = SceneManager::factoryByKey( $scene );
            $sceneList[ $index ] = $scene;
        }

        // 全局变量
        $variableList = $self->variables;
        foreach ( $variableList as $index => $variable ) {
            $variable               = VariableManager::factoryByKey( $variable );
            $variableList[ $index ] = $variable;
        }

        // 步骤
        $stepList = $self->steps;
        /**
         * @var $step StepWrapper
         */
        foreach ( $stepList as $index => $stepWrapper ) {

            $step               = StepManager::factoryWrapperByKey( $stepWrapper );
            $stepList[ $index ] = $step;
        }

        $self->scenes    = $sceneList;
        $self->variables = $variableList;
        $self->steps     = $stepList;

        return $self;

    }


}