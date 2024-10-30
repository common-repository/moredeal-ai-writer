<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;

/**
 * 产品变量
 *
 * @author MoredealAiWriter
 */
class ProductVariableModule extends AbstractVariableModule {

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
     * 关键词 变量
     *
     * @return AbstractVariableModule
     */
    public static function defKeywordVariables(): AbstractVariableModule {
        $keywordVariable           = TextVariableModule::new();
        $keywordVariable->field    = 'keyword';
        $keywordVariable->label    = Plugin::translation( 'Keyword' );
        $keywordVariable->desc     = Plugin::translation( 'Enter keywords/asin to search for products.' );
        $keywordVariable->default  = '';
        $keywordVariable->order    = 2;
        $keywordVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $keywordVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $keywordVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $keywordVariable->is_point = true;
        $keywordVariable->is_show  = true;

        return $keywordVariable;
    }

    /**
     * ASIN 变量
     *
     * @return AbstractVariableModule
     */
    public static function defASINVariables(): AbstractVariableModule {
        $asinVariable           = TextVariableModule::new();
        $asinVariable->field    = 'code';
        $asinVariable->label    = Plugin::translation( 'asin' );
        $asinVariable->desc     = Plugin::translation( 'ASIN of the product' );
        $asinVariable->default  = ' ';
        $asinVariable->value    = ' ';
        $asinVariable->order    = 1;
        $asinVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $asinVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $asinVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $asinVariable->is_point = true;
        $asinVariable->is_show  = true;

        return $asinVariable;
    }

    /**
     * 产品标题 变量
     *
     * @return AbstractVariableModule
     */
    public static function defProductTitleVariables(): AbstractVariableModule {
        $titleVariable           = TextVariableModule::new();
        $titleVariable->field    = 'title';
        $titleVariable->label    = Plugin::translation( 'title' );
        $titleVariable->desc     = Plugin::translation( 'Title of the product' );
        $titleVariable->default  = ' ';
        $titleVariable->value    = ' ';
        $titleVariable->order    = 3;
        $titleVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $titleVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $titleVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $titleVariable->is_point = true;
        $titleVariable->is_show  = true;

        return $titleVariable;
    }

    /**
     * 产品价格 变量
     *
     * @return AbstractVariableModule
     */
    public static function defPriceVariables(): AbstractVariableModule {
        $priceVariable           = TextVariableModule::new();
        $priceVariable->field    = 'price';
        $priceVariable->label    = Plugin::translation( 'price' );
        $priceVariable->desc     = Plugin::translation( 'Price of the product' );
        $priceVariable->default  = ' ';
        $priceVariable->value    = ' ';
        $priceVariable->order    = 4;
        $priceVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $priceVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $priceVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $priceVariable->is_point = true;
        $priceVariable->is_show  = true;

        return $priceVariable;
    }

    /**
     * 产品链接 变量
     *
     * @return AbstractVariableModule
     */
    public static function defUrlVariables(): AbstractVariableModule {
        $urlVariable           = TextVariableModule::new();
        $urlVariable->field    = 'product_url';
        $urlVariable->label    = Plugin::translation( 'url' );
        $urlVariable->desc     = Plugin::translation( 'Url of the product' );
        $urlVariable->default  = ' ';
        $urlVariable->value    = ' ';
        $urlVariable->order    = 5;
        $urlVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $urlVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $urlVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $urlVariable->is_point = true;
        $urlVariable->is_show  = true;

        return $urlVariable;
    }

    /**
     * 产品图片 变量
     *
     * @return AbstractVariableModule
     */
    public static function defPicUrlVariables(): AbstractVariableModule {
        $picUrlVariable           = TextVariableModule::new();
        $picUrlVariable->field    = 'pic_url';
        $picUrlVariable->label    = Plugin::translation( 'picture url' );
        $picUrlVariable->desc     = Plugin::translation( 'Picture url of the product' );
        $picUrlVariable->default  = ' ';
        $picUrlVariable->value    = ' ';
        $picUrlVariable->order    = 6;
        $picUrlVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $picUrlVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $picUrlVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $picUrlVariable->is_point = true;
        $picUrlVariable->is_show  = true;

        return $picUrlVariable;
    }

    /**
     * 产品描述 变量
     *
     * @return AbstractVariableModule
     */
    public static function defDescriptionVariables(): AbstractVariableModule {
        $descriptionVariable           = TextVariableModule::new();
        $descriptionVariable->field    = 'description';
        $descriptionVariable->label    = Plugin::translation( 'description' );
        $descriptionVariable->desc     = Plugin::translation( 'Description of the product' );
        $descriptionVariable->default  = ' ';
        $descriptionVariable->value    = ' ';
        $descriptionVariable->order    = 7;
        $descriptionVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $descriptionVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $descriptionVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $descriptionVariable->is_point = true;
        $descriptionVariable->is_show  = true;

        return $descriptionVariable;
    }

    /**
     * QA 变量
     *
     * @return AbstractVariableModule
     */
    public static function defQaVariables(): AbstractVariableModule {
        $qaVariable           = TextVariableModule::new();
        $qaVariable->field    = 'qa';
        $qaVariable->label    = Plugin::translation( 'QA' );
        $qaVariable->desc     = Plugin::translation( 'QA of the product' );
        $qaVariable->default  = ' ';
        $qaVariable->value    = ' ';
        $qaVariable->order    = 8;
        $qaVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $qaVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $qaVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $qaVariable->is_point = true;
        $qaVariable->is_show  = true;

        return $qaVariable;
    }

    /**
     * 评论变量
     *
     * @return AbstractVariableModule
     */
    public static function defCommentVariables(): AbstractVariableModule {
        $commentVariable           = TextVariableModule::new();
        $commentVariable->field    = 'comment';
        $commentVariable->label    = Plugin::translation( 'comment' );
        $commentVariable->desc     = Plugin::translation( 'Comment of the product' );
        $commentVariable->default  = ' ';
        $commentVariable->value    = ' ';
        $commentVariable->order    = 9;
        $commentVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $commentVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $commentVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $commentVariable->is_point = true;
        $commentVariable->is_show  = true;

        return $commentVariable;
    }

    /**
     * 要点变量
     *
     * @return AbstractVariableModule
     */
    public static function defPointsVariables(): AbstractVariableModule {
        $pointsVariable           = TextVariableModule::new();
        $pointsVariable->field    = 'points';
        $pointsVariable->label    = Plugin::translation( 'points' );
        $pointsVariable->desc     = Plugin::translation( 'Points of the product' );
        $pointsVariable->default  = ' ';
        $pointsVariable->value    = ' ';
        $pointsVariable->order    = 10;
        $pointsVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $pointsVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $pointsVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $pointsVariable->is_point = true;
        $pointsVariable->is_show  = true;

        return $pointsVariable;
    }
}