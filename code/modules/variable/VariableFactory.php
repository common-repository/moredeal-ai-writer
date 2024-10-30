<?php

namespace MoredealAiWriter\code\modules\variable;

use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;

defined( '\ABSPATH' ) || exit;

/**
 * 变量工厂
 *
 * @author Moredeal AI Writer
 */
class VariableFactory {

    /**
     * 内容变量
     *
     * @return TextVariableModule
     */
    public static function defContentVariable( $desc, $default_value = '', $value = '', $is_show = true ): AbstractVariableModule {
        $content_variable           = new TextVariableModule();
        $content_variable->field    = 'content';
        $content_variable->label    = Plugin::translation( 'Content' );
        $content_variable->desc     = $desc;
        $content_variable->default  = $default_value;
        $content_variable->value    = $value;
        $content_variable->order    = 0;
        $content_variable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $content_variable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $content_variable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $content_variable->is_point = true;
        $content_variable->is_show  = $is_show;

        return $content_variable;
    }

    // article variables start =================

    /**
     * 定义文章段落变量
     *
     * @return AbstractVariableModule
     */
    public static function defArticleSectionsVariables(): AbstractVariableModule {

        $nameVariable           = SelectionVariableModule::new();
        $nameVariable->field    = 'Sections';
        $nameVariable->label    = Plugin::translation( 'Sections' );
        $nameVariable->desc     = Plugin::translation( 'The Sections of Generate article.' );
        $nameVariable->default  = 2;
        $nameVariable->value    = 2;
        $nameVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $nameVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $nameVariable->is_point = true;
        $nameVariable->addOption( '2', 2 );
        $nameVariable->addOption( '5', 5 );
        $nameVariable->addOption( '10', 10 );
        $nameVariable->default = 2;

        return $nameVariable;
    }

    /**
     * 定义文章段落变量
     *
     * @return AbstractVariableModule
     */
    public static function defArticleParagraphsVariables(): AbstractVariableModule {
        $nameVariable           = SelectionVariableModule::new();
        $nameVariable->field    = 'Paragraphs';
        $nameVariable->label    = Plugin::translation( 'Paragraphs' );
        $nameVariable->desc     = Plugin::translation( 'The Paragraphs per Section of Generate article.' );
        $nameVariable->default  = 3;
        $nameVariable->value    = 3;
        $nameVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $nameVariable->group    = VariableGroupConstant::GROUP_PARAMS()->getValue();
        $nameVariable->is_point = true;
        $nameVariable->addOption( '2', 2 );
        $nameVariable->addOption( '3', 3 );
        $nameVariable->addOption( '5', 5 );
        $nameVariable->addOption( '10', 10 );
        $nameVariable->default = 2;

        return $nameVariable;
    }

    // article variables end =================

}