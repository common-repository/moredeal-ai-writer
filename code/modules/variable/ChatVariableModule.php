<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;

/**
 * chat变量
 *
 * @author MoredealAiWriter
 */
class ChatVariableModule extends AbstractVariableModule {

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
     * 默认变量
     *
     * @return array
     */
    public static function defGlobalVariables(): array {
        $globalVariable           = ChatVariableModule::new();
        $globalVariable->field    = 'name';
        $globalVariable->label    = 'name label';
        $globalVariable->default  = 'test defaults';
        $globalVariable->order    = 0;
        $globalVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $globalVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $globalVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $globalVariable->is_point = true;
        $globalVariable->is_show  = true;
        $globalVariable->addOption( 'test 1', '1' );
        $globalVariable->addOption( 'test 2', '2' );

        return [
            $globalVariable,
        ];
    }

    /**
     * Temperature 变量
     *
     * @return AbstractVariableModule
     */
    public static function defModelTemperatureVariables(): AbstractVariableModule {
        $temperatureVariable           = ChatVariableModule::new();
        $temperatureVariable->field    = 'temperature';
        $temperatureVariable->label    = 'Temperature';
        $temperatureVariable->desc     = 'Temperature description';
        $temperatureVariable->default  = 0.7;
        $temperatureVariable->order    = 1;
        $temperatureVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $temperatureVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $temperatureVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $temperatureVariable->is_point = true;
        $temperatureVariable->is_show  = false;

        return $temperatureVariable;
    }

    /**
     * MaxTokens 变量
     *
     * @return AbstractVariableModule
     */
    public static function defMaxTokensVariables(): AbstractVariableModule {
        $maxTokenVariable           = ChatVariableModule::new();
        $maxTokenVariable->field    = 'max_tokens';
        $maxTokenVariable->label    = 'MaxTokens';
        $maxTokenVariable->desc     = 'MaxTokens description';
        $maxTokenVariable->default  = 1000;
        $maxTokenVariable->order    = 2;
        $maxTokenVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $maxTokenVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $maxTokenVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $maxTokenVariable->is_point = true;
        $maxTokenVariable->is_show  = false;

        return $maxTokenVariable;
    }

    /**
     * Prompt 变量
     *
     * @return AbstractVariableModule
     */
    public static function defPromptVariables(): AbstractVariableModule {
        $promptVariable           = ChatVariableModule::new();
        $promptVariable->field    = 'message';
        $promptVariable->label    = 'message';
        $promptVariable->desc     = 'A text description of the desired image(s). The maximum length is 1000 characters.';
        $promptVariable->default  = [ [ 'role' => 'user', 'content' => 'HI! ChatGPT.' ] ];
        $promptVariable->order    = 4;
        $promptVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $promptVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $promptVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $promptVariable->is_point = true;
        $promptVariable->is_show  = true;

        return $promptVariable;
    }


}