<?php

namespace MoredealAiWriter\code\modules\context;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\step\StepWrapper;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;
use MoredealAiWriter\code\modules\variable\AbstractVariableModule;
use MoredealAiWriter\code\modules\variable\TextVariableModule;

/**
 * Class BaseContextModule
 *
 * @author MoredealAiWriter
 */
class  BaseContextModule extends AbstractContextModule {


    private $_paramsVariable = [];

    /**
     * 构造函数
     *
     * @param AbstractTemplateModule $template
     * @param array                  $variable
     */
    public function __construct( AbstractTemplateModule $template, array $variable = [] ) {

        $this->_paramsVariable = self::build_variables( $variable );
        // 入参合并
        $template->variables = self::variable_merge( $template->variables, $this->_paramsVariable );
        parent::__construct( $template );
    }

    /**
     * 初始化操作
     *
     * @return void
     */
    public function init() {

        //设置模版参数到 上下文中
        /**
         * @var $variable AbstractVariableModule
         */
        $maps = static::_loadVariable( $this->template, function ( $variable ) {
            return $variable->getValue();
        } );

        $this->addVariable( $maps );

    }

    /**
     * 重新加载步骤
     *
     * @param AbstractStepModule $step
     *
     * @return void
     */
    public function reloadByStep( AbstractStepModule $step ) {
        //更新结果到上下文的中, 出参，状态
        $keys = [ static::KEY_STEP, $this->getStepField(), static::KEY_STEP_RESPONSE ];
        $this->pushVariable( static::generateKey( $keys ), $step->response->getValue() );

    }

    /**
     * 获取 变量的 label 集合
     *
     * @param AbstractTemplateModule $templateModule
     *
     * @return array
     */
    public static function _getVariableLabel( AbstractTemplateModule $templateModule ) {

        /**
         * @var $variable AbstractVariableModule
         */
        $maps = static::_loadVariable( $templateModule, function ( $variable ) {
            return $variable->label;
        } );

        return $maps;
    }

    /**
     * 加载变量
     *
     * @param AbstractTemplateModule $templateModule
     * @param                        $callback
     *
     * @return array
     */
    protected static function _loadVariable( AbstractTemplateModule $templateModule, $callback ) {
        $maps = [];

        /**
         * @var $variable AbstractVariableModule
         */
        foreach ( $templateModule->variables as $variable ) {
            $keys                                 = [ static::KEY_GLOBAL, $variable->field ];
            $maps[ static::generateKey( $keys ) ] = $callback( $variable );
        }

        /**
         * @var $stepWrapper StepWrapper
         */
        foreach ( $templateModule->steps as $stepWrapper ) {
            //@todo $stepWrapper variables  and step variables
            //先 $stepWrapper->variables
            foreach ( $stepWrapper->variables as $variable ) {
                $keys                                 = [ static::KEY_STEP, $stepWrapper->field, $variable->field ];
                $maps[ static::generateKey( $keys ) ] = $callback( $variable );

                $keys                                 = [
                    static::KEY_STEP,
                    $stepWrapper->field,
                    '_in',
                    $variable->field
                ];
                $maps[ static::generateKey( $keys ) ] = $callback( $variable );
            }

            // step variables
            $step = $stepWrapper->stepModule;
            /**
             * @var $variable AbstractVariableModule
             */
            foreach ( $step->variables as $variable ) {
                $keys                                 = [ static::KEY_STEP, $stepWrapper->field, $variable->field ];
                $maps[ static::generateKey( $keys ) ] = $callback( $variable );

                $keys                                 = [
                    static::KEY_STEP,
                    $stepWrapper->field,
                    '_in',
                    $variable->field
                ];
                $maps[ static::generateKey( $keys ) ] = $callback( $variable );
            }


            if ( ! empty( $step->response ) ) {
                $keys                                 = [
                    static::KEY_STEP,
                    $stepWrapper->field,
                    static::KEY_STEP_RESPONSE
                ];
                $maps[ static::generateKey( $keys ) ] = $step->response->getValue();
            }


        }

        return $maps;

    }

    /**
     * 获取该类型对象
     *
     * @param $object
     *
     * @return AbstractContextModule
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 构建 variable
     *
     * @param array $variables
     *
     * @return array{AbstractVariableModule}
     */
    public static function build_variables( array $variables ): array {
        if ( empty( $variables ) ) {
            return array();
        }
        $variable_list = array();
        foreach ( $variables as $field => $value ) {
            $variable_list[] = TextVariableModule::defBaseVariable( $field, $field, $value );
        }

        return $variable_list;
    }

    /**
     * 合并参数, 有则覆盖，无则添加
     *
     * @param array $template_variables
     * @param array $params_variables
     *
     * @return array
     */
    public static function variable_merge( array &$template_variables = [], array $params_variables = [] ): array {
        if ( empty( $template_variables ) ) {
            return $params_variables;
        }
        if ( empty( $params_variables ) ) {
            return $template_variables;
        }

        // 两个数组根据 field 字段 合并去重
        $template_fields = array_column( $template_variables, 'field' );
        foreach ( $params_variables as $params_variable ) {
            // 如果不在模版参数中，则添加该参数
            if ( ! in_array( $params_variable->field, $template_fields ) ) {
                $template_variables[] = $params_variable;
            } else {
                // 如果在模版参数中，则覆盖该参数的值
                $field_index                        = array_search( $params_variable->field, $template_fields );
                $field_variable                     = $template_variables[ $field_index ];
                $field_variable->value              = $params_variable->value;
                $template_variables[ $field_index ] = $field_variable;
            }
        }

        return $template_variables;
    }

}