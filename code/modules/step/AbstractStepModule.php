<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\models\LogModel;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\AbstractSceneModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\step\response\ResponseManager;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;
use MoredealAiWriter\code\modules\variable\AbstractVariableModule;
use MoredealAiWriter\code\modules\variable\VariableManager;

/**
 * 执行步骤基类
 *
 * @author MoredealAiWriter
 */
abstract class  AbstractStepModule extends BaseModule {

    /**
     * 版本
     *
     * @var int
     */
    public $version = 1;

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
     * 描述
     *
     * @var string
     */
    public $desc;

    /**
     * source
     *
     * @var StepConstant
     */
    public $source;

    /**
     * source url
     *
     * @var string
     */
    public $sourceUrl;

    /**
     * 标签
     *
     * @var string
     */
    public $tags;

    /**
     * 是否自动执行
     *
     * @var bool true 自动执行 false 手动执行
     */
    public $isAuto;

    /**
     * 类型
     * @var string
     */
    public $type;

    /**
     * 图标
     *
     * @var string
     */
    public $icon;

    /**
     * 场景，也有白名单的作用，如果为空，则所有场景都可以使用
     *
     * @var array{AbstractSceneModule}
     */
    public $scenes = [];

    /**
     * 变量
     *
     * @var array{AbstractVariableModule}
     */
    public $variables = [];

    /**
     * 结果
     *
     * @var AbstractResponseModule
     */
    public $response = null;

    /**
     * 是否可以添加步骤
     *
     * @var bool
     */
    public $isCanAddStep = false;

    /**
     * 初始化配置
     *
     * @return void
     */
    abstract protected function initConfig();

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

        $variableList = $self->variables;
        foreach ( $variableList as $index => $variable ) {
            $variable               = VariableManager::factoryByKey( $variable );
            $variableList[ $index ] = $variable;
        }
        $self->variables = $variableList;
        $self->response  = ResponseManager::factoryByKey( $self->response );
        $self->name      = Plugin::translation( $self->name ?? '' );
        $self->desc      = Plugin::translation( $self->desc ?? '');

        return $self;
    }

    /**
     * 执行步骤
     *
     * @param AbstractContextModule $context
     *
     * @return AbstractResponseModule
     */
    public abstract function execute( AbstractContextModule $context ): AbstractResponseModule;

    /**
     * 执行步骤
     *
     * @param AbstractContextModule $context
     * @param StepWrapper $stepWrapper
     *
     * @return AbstractResponseModule
     * @throws Exception
     */
    public function _execute( AbstractContextModule $context, StepWrapper $stepWrapper ): AbstractResponseModule {

        //参数替换 上下文占位符

        $stepField = $stepWrapper->field;
        $context->setStepField( $stepField );

        try {

            $context->runEventStepPre( $this );

            $this->response            = $this->execute( $context );
            $this->response->stepField = $context->getStepField();

            if ( $this->response->status === true ) {
                $context->runEventStepPost( $this );

                //更新结果到上下文的中, 出参，状态
                $context->reloadByStep( $this );
                $this->response->status = true;
            }

        } catch ( Exception $e ) {

            $this->response->status    = false;
            $this->response->errorCode = $e->getCode();
            $this->response->message   = $e->getMessage();

            LogModel::getInstance()->addErrorLog( $context, $e->getMessage() );

            error_log( 'Template execute is error. ' . $e->getMessage(), $e->getCode() );
        }


        return $this->response;

    }


}