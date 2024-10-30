<?php

namespace MoredealAiWriter\code\modules\util;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\code\modules\template\ArticleTemplateModule;
use MoredealAiWriter\code\modules\template\ContinueWritingTemplateModule;
use MoredealAiWriter\code\modules\template\GenerateTableTemplateModule;
use MoredealAiWriter\code\modules\template\ImageByTextTemplateModule;
use MoredealAiWriter\code\modules\template\ImgTemplateModule;
use MoredealAiWriter\code\modules\template\ImproveWritingTemplateModule;
use MoredealAiWriter\code\modules\template\MakeLongerTemplateModule;
use MoredealAiWriter\code\modules\template\PostExcerptTemplateModule;
use MoredealAiWriter\code\modules\template\PostTitleTemplateModule;
use MoredealAiWriter\code\modules\template\ProductTemplateModule;
use MoredealAiWriter\code\modules\template\SummarizeTableTemplateModule;
use MoredealAiWriter\code\modules\template\SummarizeTextTemplateModule;
use MoredealAiWriter\code\modules\template\TemplateFactory;
use MoredealAiWriter\code\modules\template\TextTemplateModule;
use MoredealAiWriter\code\modules\template\TranslateTextTemplateModule;

/**
 * 模版配置工具类
 *
 * @autor MoredealAiWriter
 */
class TemplateConfigUtil {

    /**
     * 获取推荐模版
     * @return array
     */
    public static function getTemplateRecommend(): array {
        return array(
            TextTemplateModule::new()->getInfo(),
            ImgTemplateModule::new()->getInfo(),
            ArticleTemplateModule::new()->getInfo(),
            ImageByTextTemplateModule::new()->getInfo(),
            ProductTemplateModule::new()->getInfo(),
            PostTitleTemplateModule::new()->getInfo(),
            PostExcerptTemplateModule::new()->getInfo(),
            TranslateTextTemplateModule::new()->getInfo(),
            ImproveWritingTemplateModule::new()->getInfo(),
            MakeLongerTemplateModule::new()->getInfo(),
            SummarizeTextTemplateModule::new()->getInfo(),
            ContinueWritingTemplateModule::new()->getInfo(),
            SummarizeTableTemplateModule::new()->getInfo(),
            GenerateTableTemplateModule::new()->getInfo(),
        );
    }

}