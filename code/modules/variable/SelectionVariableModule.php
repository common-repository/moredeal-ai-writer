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
class SelectionVariableModule extends AbstractVariableModule {

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
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {
        parent::initConfig();
        $this->type = VariableConstant::TYPE_TEXT()->getValue();
    }

    /**
     * 语言变量
     *
     * @return AbstractVariableModule
     */
    public static function defLanguageVariables(): AbstractVariableModule {
        $languageVariable           = static::new();
        $languageVariable->field    = 'language';
        $languageVariable->label    = Plugin::translation( 'Language' );
        $languageVariable->desc     = Plugin::translation( 'In which language will the generated content be returned' );
        $languageVariable->default  = 'English';
        $languageVariable->value    = 'English';
        $languageVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $languageVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $languageVariable->is_point = true;
        $languageVariable->addOption( Plugin::translation( 'English' ), 'English' );
        $languageVariable->addOption( Plugin::translation( 'German' ), 'German' );
        $languageVariable->addOption( Plugin::translation( 'French' ), 'French' );
        $languageVariable->addOption( Plugin::translation( 'Spanish' ), 'Spanish' );
        $languageVariable->addOption( Plugin::translation( 'Italian' ), 'Italian' );
        $languageVariable->addOption( Plugin::translation( 'Chinese' ), 'Chinese' );
        $languageVariable->addOption( Plugin::translation( 'Japanese' ), 'Japanese' );
        $languageVariable->addOption( Plugin::translation( 'Portuguese' ), 'Portuguese' );
        $languageVariable->addOption( Plugin::translation( 'Other' ), 'Other' );

        return $languageVariable;
    }

    /**
     * Writing style 变量
     *
     * @return AbstractVariableModule
     */
    public static function defWritingStyleVariables(): AbstractVariableModule {
        $writingStyleVariable           = static::new();
        $writingStyleVariable->field    = 'writing_style';
        $writingStyleVariable->label    = Plugin::translation( 'Writing style' );
        $writingStyleVariable->desc     = Plugin::translation( 'The writing style of the generated content' );
        $writingStyleVariable->default  = 'Creative';
        $writingStyleVariable->value    = 'Creative';
        $writingStyleVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $writingStyleVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $writingStyleVariable->is_point = true;
        $writingStyleVariable->addOption( Plugin::translation( 'Informative' ), 'Informative' );
        $writingStyleVariable->addOption( Plugin::translation( 'Descriptive' ), 'Descriptive' );
        $writingStyleVariable->addOption( Plugin::translation( 'Creative' ), 'Creative' );
        $writingStyleVariable->addOption( Plugin::translation( 'Narrative' ), 'Narrative' );
        $writingStyleVariable->addOption( Plugin::translation( 'Persuasive' ), 'Persuasive' );
        $writingStyleVariable->addOption( Plugin::translation( 'Reflective' ), 'Reflective' );
        $writingStyleVariable->addOption( Plugin::translation( 'Argumentative' ), 'Argumentative' );
        $writingStyleVariable->addOption( Plugin::translation( 'Analytical' ), 'Analytical' );
        $writingStyleVariable->addOption( Plugin::translation( 'Evaluative' ), 'Evaluative' );
        $writingStyleVariable->addOption( Plugin::translation( 'Journalistic' ), 'Journalistic' );
        $writingStyleVariable->addOption( Plugin::translation( 'Technical' ), 'Technical' );

        return $writingStyleVariable;
    }

    /**
     * Cheerful 变量
     *
     * @return AbstractVariableModule
     */
    public static function defCheerfulVariables(): AbstractVariableModule {
        $nameVariable           = static::new();
        $nameVariable->field    = 'writing_tone';
        $nameVariable->label    = Plugin::translation( 'Writing tone' );
        $nameVariable->desc     = Plugin::translation( 'The writing tone of the generated content' );
        $nameVariable->default  = 'Cheerful';
        $nameVariable->value    = 'Cheerful';
        $nameVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $nameVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $nameVariable->is_point = true;
        $nameVariable->addOption( Plugin::translation( 'Eutral' ), 'Neutral' );
        $nameVariable->addOption( Plugin::translation( 'Formal' ), 'Formal' );
        $nameVariable->addOption( Plugin::translation( 'Assertive' ), 'Assertive' );
        $nameVariable->addOption( Plugin::translation( 'Cheerful' ), 'Cheerful' );
        $nameVariable->addOption( Plugin::translation( 'Humorous' ), 'Humorous' );
        $nameVariable->addOption( Plugin::translation( 'Informal' ), 'Informal' );
        $nameVariable->addOption( Plugin::translation( 'Inspirational' ), 'Inspirational' );
        $nameVariable->addOption( Plugin::translation( 'Professional' ), 'Professional' );
        $nameVariable->addOption( Plugin::translation( 'Confvalueent' ), 'Confvalueent' );
        $nameVariable->addOption( Plugin::translation( 'Emotional' ), 'Emotional' );
        $nameVariable->addOption( Plugin::translation( 'Persuasive' ), 'Persuasive' );
        $nameVariable->addOption( Plugin::translation( 'Supportive' ), 'Supportive' );
        $nameVariable->addOption( Plugin::translation( 'Sarcastic' ), 'Sarcastic' );
        $nameVariable->addOption( Plugin::translation( 'Condescending' ), 'Condescending' );
        $nameVariable->addOption( Plugin::translation( 'Skeptical' ), 'Skeptical' );
        $nameVariable->addOption( Plugin::translation( 'Narrative' ), 'Narrative' );
        $nameVariable->addOption( Plugin::translation( 'Journalistic' ), 'Journalistic' );

        return $nameVariable;
    }


}