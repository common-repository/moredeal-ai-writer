<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;

/**
 * 文本变量
 *
 * @author MoredealAiWriter
 */
class TextVariableModule extends AbstractVariableModule {

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
     * Temperature 变量
     *
     * @return AbstractVariableModule
     */
    public static function defModelTemperatureVariables(): AbstractVariableModule {
        $temperatureVariable           = TextVariableModule::new();
        $temperatureVariable->field    = 'temperature';
        $temperatureVariable->label    = Plugin::translation( 'Temperature' );
        $temperatureVariable->desc     = Plugin::translation( 'What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.' );
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
        $maxTokensVariable           = TextVariableModule::new();
        $maxTokensVariable->field    = 'max_tokens';
        $maxTokensVariable->label    = Plugin::translation( 'MaxTokens' );
        $maxTokensVariable->desc     = Plugin::translation( "The total length of input tokens and generated tokens is limited by the model's context length." );
        $maxTokensVariable->default  = 1000;
        $maxTokensVariable->order    = 2;
        $maxTokensVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $maxTokensVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $maxTokensVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $maxTokensVariable->is_point = true;
        $maxTokensVariable->is_show  = false;

        return $maxTokensVariable;
    }

    /**
     * 数量 变量
     *
     * @return AbstractVariableModule
     */
    public static function defNVariables(): AbstractVariableModule {
        $nVariable          = TextVariableModule::new();
        $nVariable->field   = 'n';
        $nVariable->label   = Plugin::translation( 'N' );
        $nVariable->desc    = Plugin::translation( 'How many chat completion choices to generate for each input message. https://platform.openai.com/docs/api-reference/chat' );
        $nVariable->default = 1;
        $nVariable->order   = 2;
        $nVariable->type    = VariableConstant::TYPE_TEXT()->getValue();
        $nVariable->style   = VariableStyleConstant::STYLE_SELECT()->getValue();
        $nVariable->group   = VariableGroupConstant::GROUP_MODEL()->getValue();
        $nVariable->addOption( '1', 1 );
        $nVariable->addOption( '2', 2 );
        $nVariable->addOption( '3', 3 );
        $nVariable->addOption( '4', 4 );
        $nVariable->addOption( '5', 5 );
        $nVariable->addOption( '6', 6 );
        $nVariable->addOption( '7', 7 );
        $nVariable->addOption( '8', 8 );
        $nVariable->addOption( '9', 9 );
        $nVariable->addOption( '10', 10 );
        $nVariable->is_point = true;
        $nVariable->is_show  = false;

        return $nVariable;
    }

    /**
     * 话题 变量
     *
     * @return AbstractVariableModule
     */
    public static function defTopicVariables(): AbstractVariableModule {
        $topicVariable           = TextVariableModule::new();
        $topicVariable->field    = 'topic';
        $topicVariable->label    = Plugin::translation('Topic');
        $topicVariable->desc     = Plugin::translation('The topic you want to generate content');
        $topicVariable->default  = 'Enter the topic you want to generate content';
        $topicVariable->order    = 3;
        $topicVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $topicVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $topicVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $topicVariable->is_point = true;
        $topicVariable->is_show  = true;

        return $topicVariable;
    }

    /**
     * prompt 变量
     *
     * @return AbstractVariableModule
     */
    public static function defPromptVariables(): AbstractVariableModule {
        $promptVariable           = TextVariableModule::new();
        $promptVariable->field    = 'prompt';
        $promptVariable->label    = Plugin::translation('prompt');
        $promptVariable->desc     = Plugin::translation('A text description of the desired image(s). The maximum length is 1000 characters.');
        $promptVariable->default  = 'Hi.';
        $promptVariable->order    = 4;
        $promptVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $promptVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $promptVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $promptVariable->is_point = true;
        $promptVariable->is_show  = true;

        return $promptVariable;
    }


    /**
     * stream 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStreamVariables(): AbstractVariableModule {
        $streamVariable           = TextVariableModule::new();
        $streamVariable->field    = 'stream';
        $streamVariable->label    = 'Stream';
        $streamVariable->desc     = 'If set, partial message deltas will be sent, like in ChatGPT.';
        $streamVariable->default  = false;
        $streamVariable->order    = 5;
        $streamVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $streamVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $streamVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $streamVariable->addOption( 'false', false );
        $streamVariable->addOption( 'true', true );
        $streamVariable->is_point = true;
        $streamVariable->is_show  = false;
        return $streamVariable;
    }

    /**
     * 基础变量
     *
     * @param $label
     * @param $field
     * @param $value
     *
     * @return AbstractVariableModule
     */
    public static function defBaseVariable( $label, $field, $value ): AbstractVariableModule {
        $variable        = self::new();
        $variable->label = $label;
        $variable->field = $field;
        $variable->value = $value;

        return $variable;
    }

}