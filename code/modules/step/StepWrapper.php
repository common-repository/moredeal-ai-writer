<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\components\BaseModule;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;
use MoredealAiWriter\code\modules\variable\AbstractVariableModule;
use MoredealAiWriter\code\modules\variable\VariableManager;

/**
 * 执行步骤基类
 *
 * @author MoredealAiWriter
 */
class  StepWrapper extends BaseModule {

    /**
     * 应用
     *
     * @var string
     */
    public $field;

    /**
     * 标签
     *
     * @var string
     */
    public $label;

    /**
     * 描述
     *
     * @var string
     */
    public $desc;

    /**
     * 按钮标签
     * @var string
     */
    public $buttonLabel = "Generate";

    /**
     * 步骤
     *
     * @var $stepModule AbstractStepModule
     */
    public $stepModule;

    /**
     * 变量
     *
     * @var array{AbstractVariableModule}
     */
    public $variables = [];

    /**
     * 初始化
     *
     * @return void
     */
    public function init() {

    }

    /**
     * 返回对象
     *
     * @param $object
     *
     * @return StepWrapper
     */
    public static function factoryObject( $object ): StepWrapper {
        $self = self::new();

        ModuleConvertUtil::convert( $self, $object );

        $self->buttonLabel = $self->label;

        $result = [];
        foreach ( $self->variables as $index => $variable ) {

            try {
                $variable         = VariableManager::factoryByKey( $variable );
                $result[ $index ] = $variable;
            } catch ( Exception $e ) {
                //log
            }

        }
        $self->variables = $result;

        $self->label       = Plugin::translation( $self->label ?? '' );
        $self->buttonLabel = Plugin::translation( $self->buttonLabel ?? '' );
        $self->desc        = Plugin::translation( $self->desc ?? '' );

        return $self;
    }

    /**
     * 生成步骤包装器
     *
     * @param string $label 标签
     * @param string $desc 描述
     * @param AbstractStepModule $stepModule 步骤
     *
     * @return static
     */
    public static function createWrapper( string $label, string $desc, AbstractStepModule $stepModule ): StepWrapper {
        $wrapper              = new static();
        $wrapper->field       = str_ireplace( " ", "_", strtoupper( $label ) );
        $wrapper->label       = $label;
        $wrapper->buttonLabel = $label;
        if ( empty( $desc ) ) {
            $desc = $stepModule->desc;
        }
        $wrapper->desc       = $desc;
        $wrapper->stepModule = $stepModule;

        return $wrapper;
    }

    /**
     * 设置响应类型
     *
     * @param $type
     *
     * @return $this
     */
    public function setResponseType( $type ): StepWrapper {
        if ( ! empty( $this->stepModule->response ) ) {
            $this->stepModule->response->type = $type;
        }

        return $this;
    }

    /**
     * 设置响应样式
     *
     * @param $style
     *
     * @return $this
     */
    public function setResponseStyle( $style ): StepWrapper {
        if ( ! empty( $this->stepModule->response ) ) {
            $this->stepModule->response->style = $style;
        }

        return $this;
    }

    /**
     * 设置响应
     *
     * @param AbstractResponseModule $response
     *
     * @return $this
     */
    public function setStepResponse( AbstractResponseModule $response ): StepWrapper {
        if ( ! empty( $response ) ) {
            $this->stepModule->response = $response;
        }

        return $this;
    }

    /**
     * 执行步骤
     *
     * @param AbstractContextModule $context
     *
     * @return AbstractResponseModule
     * @throws Exception
     */
    public function _execute( AbstractContextModule $context ): AbstractResponseModule {

        return $this->stepModule->_execute( $context, $this );
    }

}