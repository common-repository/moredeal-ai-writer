<?php

namespace MoredealAiWriter\code\modules\step;

defined( '\ABSPATH' ) || exit;

use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\ResponseConstant;
use MoredealAiWriter\code\consts\ResponseStyleConstant;
use MoredealAiWriter\code\modules\step\response\RedirectResponseModule;
use MoredealAiWriter\code\modules\variable\ProductVariableModule;
use MoredealAiWriter\code\modules\variable\SelectionVariableModule;
use MoredealAiWriter\code\modules\variable\VariableFactory;

/**
 * 步骤管理
 *
 * @author MoredealAiWriter
 */
class StepFactory {

    /**
     * 国际化步骤
     *
     * @param string $label
     * @param string $buttonLabel
     * @param string $desc
     * @param AbstractStepModule $stepModule
     *
     * @return StepWrapper
     */
    public static function defTranslationStepWrapper( string $label, string $buttonLabel, string $desc, AbstractStepModule $stepModule ): StepWrapper {
        $wrapper              = new StepWrapper();
        $wrapper->field       = str_ireplace( " ", "_", strtoupper( $label ) );
        $wrapper->label       = Plugin::translation( $label );
        $wrapper->buttonLabel = Plugin::translation( $buttonLabel );
        if ( empty( $desc ) ) {
            $desc = Plugin::translation( $stepModule->desc );
        } else {
            $desc = Plugin::translation( $desc );
        }
        $wrapper->desc       = $desc;
        $wrapper->stepModule = $stepModule;

        return $wrapper;
    }

    /**
     * OpenAi 步骤
     *
     * @param      $label
     * @param      $button_label
     * @param      $desc
     * @param      $default_prompt
     * @param bool $is_show 是否显示
     *
     * @return StepWrapper
     */
    public static function defAllCustomTextStep( $label, $button_label, $desc, $default_prompt = null, bool $is_show = false ): StepWrapper {
        if ( ! is_string( $label ) || empty( $label ) ) {
            $label = 'Generate Text';
        }
        if ( ! is_string( $button_label ) || empty( $button_label ) ) {
            $button_label = $label;
        }
        if ( ! is_string( $desc ) || empty( $desc ) ) {
            $desc = 'you can ask the AI to perform various tasks for you. You can ask it to write, rewrite, or translate an article, categorize words or elements into groups, write an email, etc.';
        }

        $text_step = OpenApiStepModule::new();
        foreach ( $text_step->variables as $variable ) {
            if ( $variable->field == 'prompt' ) {
                $variable->is_show = $is_show;
                if ( is_string( $default_prompt ) && ! empty( $default_prompt ) ) {
                    $variable->value = $default_prompt;
                }
            }
        }

        return self::defTranslationStepWrapper( $label, $button_label, $desc, $text_step );
    }

    /**
     * OpenAi 步骤
     *
     * @param      $label
     * @param      $desc
     * @param      $default_prompt
     * @param bool $is_show 是否显示
     *
     * @return StepWrapper
     */
    public static function defCustomTextStep( $label, $desc, $default_prompt = null, bool $is_show = false ): StepWrapper {
        return self::defAllCustomTextStep( $label, $label, $desc, $default_prompt, $is_show );
    }

    /**
     * 默认生成文字步骤
     *
     * @param bool $is_show
     *
     * @return StepWrapper
     */
    public static function defDefaultTextStep( bool $is_show = true ): StepWrapper {
        $text_wrapper = static::defCustomTextStep( null, null, null, $is_show );
        $text_wrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $text_wrapper;
    }

    /**
     * MetaBox 场景的步骤
     *
     * @param $label
     * @param $desc
     * @param $default_prompt
     * @param $variable_desc
     *
     * @return StepWrapper
     */
    public static function defMetaBoxContentStep( $label, $desc, $default_prompt, $variable_desc ): StepWrapper {
        $step_wrapper = static::defCustomTextStep( $label, $desc, $default_prompt );

        $stepModule = $step_wrapper->stepModule;
        $variables  = $stepModule->variables;
        foreach ( $variables as $index => $variable ) {
            if ( $variable->field == 'n' ) {
                $variable->default = 5;
            }
            $variables[ $index ] = $variable;
        }
        $stepModule->variables    = $variables;
        $step_wrapper->stepModule = $stepModule;
        $step_wrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );
        $step_wrapper->variables = [
            VariableFactory::defContentVariable( Plugin::translation( $variable_desc ) ),
        ];

        return $step_wrapper;
    }

    /**
     * BlockRight 场景的步骤
     *
     * @param $label
     * @param $desc
     * @param $default_prompt
     * @param $variable_desc
     *
     * @return StepWrapper
     */
    public static function defBlockRightContentStep( $label, $desc, $default_prompt, $variable_desc ): StepWrapper {
        $step_wrapper = static::defCustomTextStep( $label, $desc, $default_prompt );
        $step_wrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );
        $step_wrapper->variables = [
            VariableFactory::defContentVariable( Plugin::translation( $variable_desc ) ),
        ];

        return $step_wrapper;
    }

    /**
     * 根据内容生成图片的内容步骤
     *
     *
     * @return StepWrapper
     */
    public static function defImageContentTextStep(): StepWrapper {
        $content_wrapper = static::defCustomTextStep( 'Content', 'Please enter the content of the image', "I want you to act as a copywriter and I'll provide a piece of content, create a short, unchanged phrase that does not change the semantics of the original and extracts the keywords, which is the Content: {STEP.CONTENT.CONTENT}" );
        $content_wrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );
        $content_wrapper->variables = array( VariableFactory::defContentVariable( Plugin::translation( 'Please enter the content of the image' ) ) );

        return $content_wrapper;
    }

    // article steps start =====

    /**
     * 定义生成文章标题步骤
     *
     * @return StepWrapper
     */
    public static function defArticleTitleStep(): StepWrapper {
        $titleStepWrapper = static::defAllCustomTextStep(
            'Title',
            'Generate Title',
            'Title of the article',
            "Write a title for an article about \"{GLOBAL.TOPIC}\" in {GLOBAL.LANGUAGE}. Style: {GLOBAL.WRITING_STYLE}. Tone: {GLOBAL.WRITING_TONE}. Must be between 40 and 60 characters"
        );

        $titleStepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_INPUT()->getValue() );

        return $titleStepWrapper;
    }

    /**
     * 定义生成文章段落步骤
     *
     * @return StepWrapper
     */
    public static function defArticleSectionsStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Sections',
            'Generate Sections',
            "Add, rewrite, remove, or reorganize those sections as you wish before (re)clicking on 'Generate Content'. Markdown format is recommended.",
            "Write {STEP.SECTIONS.SECTIONS} consecutive headings for an article about \"{STEP.TITLE._OUT}\", in {GLOBAL.LANGUAGE}. Style: {GLOBAL.WRITING_STYLE}. Tone: {GLOBAL.WRITING_TONE}.\nEach heading is between 40 and 60 characters.\nUse Markdown for the headings (## )."
        );

        $stepWrapper->variables = array( VariableFactory::defArticleSectionsVariables() );
        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;
    }

    /**
     * 定义生成文章内容步骤
     *
     * @return StepWrapper
     */
    public static function defArticleContentStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Content',
            'Generate Content',
            "You can modify the content before using 'Create Post'. Markdown is supported, and will be converted to HTML when the post is created.",
            "Write an article about \"{STEP.TITLE._OUT}\" in {GLOBAL.LANGUAGE}. The article is organized by the following headings:\n{STEP.SECTIONS._OUT}\nWrite {STEP.CONTENT._IN.PARAGRAPHS} paragraphs per heading.\nUse Markdown for formatting.\nAdd an introduction prefixed by \"<!--- ===INTRO: --->\", and a conclusion prefixed by \"<!--- ===OUTRO: --->\".\nStyle: {GLOBAL.WRITING_STYLE}. Tone: {GLOBAL.WRITING_TONE}."
        );

        $stepWrapper->variables = array( VariableFactory::defArticleParagraphsVariables() );
        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;
    }

    /**
     * 定义生成文章摘要步骤
     *
     * @return StepWrapper
     */
    public static function defArticleExcerptStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Excerpt',
            'Generate Excerpt',
            'Excerpt description of the article',
            "Write an excerpt for an article about \"{STEP.TITLE._OUT}\" in {GLOBAL.LANGUAGE}. Style: {GLOBAL.WRITING_STYLE}. Tone: {GLOBAL.WRITING_TONE}. Must be between 40 and 60 characters."
        );
        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;
    }

    // article steps end =====

    // product step start =====

    /**
     * 商品报告-查询商品信息
     *
     * @return StepWrapper
     */
    public static function defProductSearchStep(): StepWrapper {
        $product_wrapper              = static::defDefaultProductsStep( 'Products' );
        $product_wrapper->buttonLabel = Plugin::translation( 'Search Products' );

        return $product_wrapper;
    }

    /**
     * 商品报告-优化标题
     *
     * @return StepWrapper
     */
    public static function defProductOptimizationTitleStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Title',
            'Optimization Title',
            'Enter the product title to optimize the title.',
            "Regenerate a new product title from the provided product \ntitle: {STEP.PRODUCTS.TITLE}.\ndescription: {STEP.PRODUCTS.DESCRIPTION}.\nThe newly generated product title is more appropriate to the product.The newly generated product title is concise, atmospheric, and between 200 and 400 characters."
        );

        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;
    }

    /**
     * 商品报告-优化描述
     *
     * @return StepWrapper
     */
    public static function defProductOptimizationDescriptionStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Description',
            'Optimization Description',
            'Enter the product description to optimize the description.',
            "According to the product.\ndescription: \"{STEP.PRODUCTS.DESCRIPTION}\".\ncreate a new description. The new product description should not deviate from the original meaning. \nThe new product description should be softer and more attractive to users. Promote the desire to buy; Don't be too vulgar"
        );

        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;
    }

    /**
     * 商品报告-优化Points
     *
     * @return StepWrapper
     */
    public static function defProductOptimizationPointsStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Points',
            'Optimization Points',
            'Enter the product points to optimize the points.',
            "I will provide the Amazon products information.\ndescription: \"{STEP.REPORT.DESCRIPTION}\".\nfivePoint: \"{STEP.PRODUCTS.POINTS}\".\nYou can generate a new fivePoint according to the description and fivePoint.The new fivePoint need to fit the information of the product. More in line with commodity."
        );

        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );

        return $stepWrapper;

    }

    /**
     * 商品报告-生成报告步骤
     *
     * @return StepWrapper
     */
    public static function defProductReportStep(): StepWrapper {
        $stepWrapper = static::defAllCustomTextStep(
            'Report',
            'Generate Report',
            'Generate analysis reports for commodities',
            "I will provide the Amazon products information and you can make a commodity analysis report.\nThe report mainly consists of six points: price, product composition/material/process, comments and feedback, merchant service, usage scenario and user portrait;\nEach point analyzes three results, each of which is condensed to  between 500 and 1000 characters.\nAccording to the results analysis percentage, the total score is 100;\nReturn it to me in Markdown format for {STEP.REPORT.LANGUAGE};\nproducts information is:\nAsin: \"{STEP.PRODUCTS.CODE}\".\ntitle: \"{STEP.PRODUCTS.TITLE}\".\nprices: \"{STEP.PRODUCTS.PRICE}\".\ndescription: \"{STEP.PRODUCTS.DESCRIPTION}\".\nfivePoint: \"{STEP.PRODUCTS.POINTS}\".\ncomment: \"{STEP.PRODUCTS.COMMENT}\".\nQA: \"{STEP.PRODUCTS.QA}\"."
        );

        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );
        $stepWrapper->variables = [
            SelectionVariableModule::defLanguageVariables()
        ];

        return $stepWrapper;
    }

    // product step end =====

    /**
     * 生成文章标题步骤
     *
     * @return StepWrapper
     */
    public static function defPostTitleStep(): StepWrapper {
        return static::defMetaBoxContentStep(
            'Generate Title',
            'Generate Post Title, In Post Meta Box Scene Use, You Can Use It In Edit Post Page For Generate Post Title',
            'Using the same original language (english), create a short but SEO-friendly title for this text: {STEP.GENERATE_TITLE.CONTENT}',
            'Use this content to generate the title you want'
        );
    }

    /**
     * 生成文章摘录步骤
     *
     * @return StepWrapper
     */
    public static function defPostExcerptStep(): StepWrapper {
        return static::defMetaBoxContentStep(
            'Generate Excerpt',
            'Generate Post Excerpt, In Post Meta Box Scene Use, You Can Use It In Edit Post Page For Generate Post Excerpt',
            'Using the same original language (english), create a SEO-friendly introduction to this text, 120 to 170 characters max, no URLs: {STEP.GENERATE_EXCERPT.CONTENT}',
            'Use this content to generate the excerpt you want'
        );
    }

    /**
     * 翻译文本步骤
     *
     * @return StepWrapper
     */
    public static function defTranslateTextStep(): StepWrapper {
        $step_wrapper = static::defCustomTextStep(
            'Translate Text',
            'Translate Text, You Can Use It In Edit Post Page For Translate Post Content Or Other Scene',
            'translate in {STEP.TRANSLATE_TEXT.LANGUAGE} language, these texts: {STEP.TRANSLATE_TEXT.CONTENT}'
        );

        $step_wrapper->setResponseStyle( ResponseStyleConstant::STYLE_TEXT()->getValue() );
        $step_wrapper->variables = [
            VariableFactory::defContentVariable( Plugin::translation( 'The text content you want to translate' ) ),
            SelectionVariableModule::defLanguageVariables(),
        ];

        return $step_wrapper;
    }

    /**
     * 改进写作步骤
     *
     * @return StepWrapper
     */
    public static function defImproveWritingStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Improve Writing',
            'Improve Writing, You Can Use It In Edit Post Page For Improve Writing Post Content Or Other Scene',
            'I want you to act as an English translator, spelling corrector and improver. I will speak to you in any language and you will detect the language, translate it and answer in the corrected and improved version of my text, in English. I want you to replace my simplified A0-level words and sentences with more beautiful and elegant, upper level English words and sentences. Keep the meaning same, but make them more literary. I want you to only reply the correction, the improvements and nothing else, do not write explanations. My first sentence is: {STEP.IMPROVE_WRITING.CONTENT}',
            'The text content you want to improve writing'
        );
    }

    /**
     * 续写文本
     *
     * @return StepWrapper
     */
    public static function defContinueWritingStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Continue Writing',
            'Continue Writing, You Can Use It In Edit Post Page For Continue Writing Post Content Or Other Scene',
            'I need you to serve as my content continuation assistant and provide me with content to continue writing. Before starting the writing, please read the text I provided carefully and understand its background, emotions, and themes. Next, please continue writing in a coherent and engaging way, ensuring that the original style and context are maintained. Please only return the content continuation, without including any other information. Your continuation should be consistent with the original language and clear, accurate, specific, and fluent. Here is my content:{STEP.GENERATE.CONTENT}',
            'The text content you want to continue writing'
        );
    }

    /**
     * 增强文本
     *
     * @return StepWrapper
     */
    public static function defMakeLongerStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Make Longer',
            'Make Longer, You Can Use It In Edit Post Page For Make Longer Post Content Or Other Scene',
            "I want you to act as a writing coach and help me extend my text. Think about your audience and the purpose of your writing. Who are you writing for and what message do you want to convey? Once you have a clear understanding of your audience and purpose, you can start to think about how to extend your text.One way to do this is to include more examples and details. Think about the key points you want to make and try to provide specific examples or anecdotes that illustrate those points. This will help to make your writing more vivid and engaging for your readers.Another way to extend your text is to add more background information or context. If you're writing about a complex topic, it can be helpful to provide some additional context or background information to help your readers understand the subject matter better. This will also help to establish your credibility as a writer.Finally, make sure to revise and edit your writing carefully. This will help you to identify areas where you could add more detail or explanation, and to ensure that your writing is clear, concise, and effective in conveying your message.Just give me the extending text, no more other informations. \nHere is my first text: {STEP.MAKE_LONGER.CONTENT}",
            'The text content you want to make longer'
        );
    }

    /**
     * 总结文本
     *
     * @return StepWrapper
     */
    public static function defSummarizeTextStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Summarize Text',
            'Summarize Text, You Can Use It In Edit Post Page For Summarize Post Content Or Other Scene',
            "I want you to act as a summarizer and help me condense a long piece of text. To summarize effectively, read carefully, identify key points, condense into a clear summary, maintain the author's meaning, and revise carefully. My first text is: {STEP.SUMMARIZE_TEXT.CONTENT}.",
            'The text content you want to summarize'
        );
    }

    /**
     * 总结文本成为表格
     *
     * @return StepWrapper
     */
    public static function defSummarizeTableStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Summarize Table',
            'Summarize Table, You Can Use It In Edit Post Page For Summarize Post Table Or Other Scene',
            "I want you to act as a 'Content Converter', take the given text or data and organize it into a well-structured table format in Markdown. Make sure to arrange the information in appropriate columns and rows, using headers to label each category, and include any relevant formatting to make the table easy to read and understand.Just reply in Markdown, don't need any type content else. Here is my first content: {STEP.SUMMARIZE_TABLE.CONTENT}",
            'The text content you want to summarize table'
        );
    }

    /**
     * 生成表格的步骤
     *
     * @return StepWrapper
     */
    public static function defGenerateTableStep(): StepWrapper {
        return static::defBlockRightContentStep(
            'Generate Table',
            'Generate Table, You Can Use It In Edit Post Page For Generate Content To Table Or Other Scene',
            "I want you to act as a 'Content Converter', take the given text or data and organize it into a well-structured table format in Markdown. Make sure to arrange the information in appropriate columns and rows, using headers to label each category, and include any relevant formatting to make the table easy to read and understand.Just reply in Markdown, don't need any type content else. Here is my first content: {STEP.GENERATE_TABLE.CONTENT}",
            'Use this content to generate the table you want'
        );
    }

    /**
     * 生成图片的步骤
     *
     * @param      $label
     * @param      $desc
     * @param      $default_prompt
     * @param bool $is_show
     *
     * @return StepWrapper
     */
    public static function defCustomImageStep( $label, $desc, $default_prompt = null, bool $is_show = false ): StepWrapper {
        if ( ! is_string( $label ) || empty( $label ) ) {
            $label = 'Generate Images';
        }
        if ( ! is_string( $desc ) || empty( $desc ) ) {
            $desc = 'You can enter a prompt to generate the image you desire.';
        }

        $image_step = StabilityAiImageStepModule::new();
        foreach ( $image_step->variables as $variable ) {
            if ( $variable->field == 'prompt' ) {
                $variable->is_show = $is_show;
                if ( is_string( $default_prompt ) && ! empty( $default_prompt ) ) {
                    $variable->value = $default_prompt;
                }
            }
        }

        return self::defTranslationStepWrapper( $label, $label, $desc, $image_step );
    }

    /**
     * 图片步骤
     *
     * @param bool $is_show 是否显示
     *
     * @return StepWrapper
     */
    public static function defDefaultImageStep( bool $is_show = true ): StepWrapper {
        return static::defCustomImageStep( null, null, null, $is_show );
    }

    /**
     * 根据图文本生成图片的 生成图片步骤
     *
     * @return StepWrapper
     */
    public static function defContentImageStep(): StepWrapper {
        return static::defCustomImageStep( null, null, '{STEP.CONTENT._OUT}' );
    }

    /**
     * 查询商品步骤
     *
     * @param $label
     * @param $desc
     *
     * @return StepWrapper
     */
    public static function defDefaultProductsStep( $label = null, $desc = null ): StepWrapper {
        if ( ! is_string( $label ) || empty( $label ) ) {
            $label = 'Search Products';
        }
        if ( ! is_string( $desc ) || empty( $desc ) ) {
            $desc = 'Search for the desired product information based on multiple search criteria.';
        }

        $stepWrapper            = self::defTranslationStepWrapper( $label, $label, $desc, SearchProductStepModule::new() );
        $stepWrapper->variables = array(
            ProductVariableModule::defKeywordVariables(),
            ProductVariableModule::defASINVariables(),
            ProductVariableModule::defProductTitleVariables(),
            ProductVariableModule::defPriceVariables(),
            ProductVariableModule::defUrlVariables(),
            ProductVariableModule::defPicUrlVariables(),
            ProductVariableModule::defDescriptionVariables(),
            ProductVariableModule::defPointsVariables(),
            ProductVariableModule::defQaVariables(),
            ProductVariableModule::defCommentVariables(),
        );
        $stepWrapper->setStepResponse( RedirectResponseModule::defArrayResponse() );
        $stepWrapper->setResponseType( ResponseConstant::TYPE_ARRAY()->getValue() );
        $stepWrapper->setResponseStyle( ResponseStyleConstant::STYLE_PRODUCT()->getValue() );

        return $stepWrapper;
    }

    /**
     * 生成文章步骤，
     *
     * @param  $label
     * @param  $desc
     *
     * @return StepWrapper
     */
    public static function defDefaultCreatePostStep( $label = null, $desc = null ): StepWrapper {
        if ( ! is_string( $label ) || empty( $label ) ) {
            $label = 'Create Post';
        }
        if ( ! is_string( $desc ) || empty( $desc ) ) {
            $desc = 'Take the generated content and create a new post';
        }
        $stepWrapper = self::defTranslationStepWrapper( $label, $label, $desc, CreatePostStepModule::new() );
        $stepWrapper->setStepResponse( RedirectResponseModule::defResponse() );

        return $stepWrapper;
    }

    /**
     * 保存图片步骤，保存到 Wordpress 的媒体库
     *
     * @param  $label
     * @param  $desc
     *
     * @return StepWrapper
     */
    public static function defDefaultSaveImagesStep( $label = null, $desc = null ): StepWrapper {
        if ( ! is_string( $label ) || empty( $label ) ) {
            $label = 'Save Images';
        }
        if ( ! is_string( $desc ) || empty( $desc ) ) {
            $desc = 'Save the generated image to your media library.';
        }
        $stepWrapper = self::defTranslationStepWrapper( $label, $label, $desc, Base64SaveStepModule::new() );
        $stepWrapper->setStepResponse( RedirectResponseModule::defResponse() );

        return $stepWrapper;
    }

}
