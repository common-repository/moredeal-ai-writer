<?php

namespace MoredealAiWriter\code\modules\variable;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarAigcRestfulClient;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\VariableConstant;
use MoredealAiWriter\code\consts\VariableGroupConstant;
use MoredealAiWriter\code\consts\VariableStyleConstant;

/**
 * 图片变量
 *
 * @author MoredealAiWriter
 */
class  ImageVariableModule extends AbstractVariableModule {

    /**
     * 对象转换时候使用
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
     * 生成图片数量 变量
     *
     * @return AbstractVariableModule
     */
    public static function defNumberVariables(): AbstractVariableModule {
        $numberVariable           = ImageVariableModule::new();
        $numberVariable->field    = 'number';
        $numberVariable->label    = Plugin::translation( 'number' );
        $numberVariable->desc     = Plugin::translation( 'The number of images to generate. Must be between 1 and 10.' );
        $numberVariable->order    = 0;
        $numberVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $numberVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $numberVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $numberVariable->is_point = true;
        $numberVariable->is_show  = true;
        $numberVariable->value    = 1;
        $numberVariable->default  = 1;
        $numberVariable->addOption( '1', 1 );
        $numberVariable->addOption( '2', 2 );
        $numberVariable->addOption( '3', 3 );
        $numberVariable->addOption( '4', 4 );
        $numberVariable->addOption( '5', 5 );
        $numberVariable->addOption( '6', 6 );

        return $numberVariable;
    }

    /**
     * 图片尺寸大小 变量
     *
     * @return AbstractVariableModule
     */
    public static function defSizeVariables(): AbstractVariableModule {
        $sizeVariable           = ImageVariableModule::new();
        $sizeVariable->field    = 'size';
        $sizeVariable->label    = Plugin::translation( 'size' );
        $sizeVariable->desc     = Plugin::translation( 'The size of the generated images. Must be one of 256x256, 512x512, or 1024x1024.' );
        $sizeVariable->order    = 1;
        $sizeVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $sizeVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $sizeVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $sizeVariable->is_point = true;
        $sizeVariable->is_show  = true;
        $sizeVariable->default  = '256x256';
        $sizeVariable->value    = '256x256';
        $sizeVariable->addOption( '256x256', '256x256' );
        $sizeVariable->addOption( '512x512', '512x512' );
        $sizeVariable->addOption( '1024x1024', '1024x1024' );

        return $sizeVariable;


    }

    /**
     * 默认 Prompt 变量
     *
     * @return AbstractVariableModule
     */
    public static function defPromptVariables(): AbstractVariableModule {
        $promptVariable           = TextVariableModule::new();
        $promptVariable->field    = 'prompt';
        $promptVariable->label    = Plugin::translation( 'prompt' );
        $promptVariable->desc     = Plugin::translation( 'A text description of the desired image(s). The maximum length is 1000 characters.' );
        $promptVariable->value    = 'japan, tokyo, trees, izakaya, anime oil painting, high resolution, ghibli inspired';
        $promptVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $promptVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $promptVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $promptVariable->is_point = true;
        $promptVariable->is_show  = true;

        return $promptVariable;
    }

    /**
     * StabilityAi 引擎变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiEngineIdVariable(): AbstractVariableModule {
        $engineIdVariable           = ImageVariableModule::new();
        $engineIdVariable->field    = 'engine_id';
        $engineIdVariable->label    = Plugin::translation( 'Engine Id' );
        $engineIdVariable->desc     = Plugin::translation( 'The Engine Id of the generated images.' );
        $engineIdVariable->order    = 1;
        $engineIdVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $engineIdVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $engineIdVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $engineIdVariable->is_point = true;
        $engineIdVariable->is_show  = false;
        $engineIdVariable->default  = 'stable-diffusion-v1-5';
        $engineIdVariable->value    = 'stable-diffusion-v1-5';

        $result = SeastarAigcRestfulClient::getInstance()->list_engine();
        if ( empty( $result['success'] ) || empty( $result['data'] ) ) {
            $engineIdVariable->addOption( 'Stable Diffusion v1.5', 'stable-diffusion-v1-5' );

            return $engineIdVariable;
        }
        foreach ( $result['data'] as $item ) {
            $engineIdVariable->addOption( $item['name'], $item['id'] );
        }

        return $engineIdVariable;
    }

    /**
     * StabilityAi 图片Size 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiSizeVariable(): AbstractVariableModule {
        $sizeVariable           = ImageVariableModule::new();
        $sizeVariable->field    = 'size';
        $sizeVariable->label    = Plugin::translation( 'Size' );
        $sizeVariable->desc     = Plugin::translation( 'The size of the generated images.' );
        $sizeVariable->order    = 2;
        $sizeVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $sizeVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $sizeVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $sizeVariable->is_point = true;
        $sizeVariable->is_show  = true;
        $sizeVariable->default  = '512x512';
        $sizeVariable->value    = '512x512';
        $sizeVariable->addOption( '512x512', '512x512' );
        $sizeVariable->addOption( '512x768', '512x768' );
        $sizeVariable->addOption( '512x1024', '512x1024' );
        $sizeVariable->addOption( '768x768', '768x768' );
        $sizeVariable->addOption( '768x1024', '768x1024' );
        $sizeVariable->addOption( '1024x1024', '1024x1024' );

        return $sizeVariable;
    }

    /**
     * StabilityAi 图片数量 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiNumberVariables(): AbstractVariableModule {
        $nameVariable           = ImageVariableModule::new();
        $nameVariable->field    = 'number';
        $nameVariable->label    = Plugin::translation( 'Number' );
        $nameVariable->desc     = Plugin::translation( 'The number of images to generate. Must be between 1 and 10.' );
        $nameVariable->order    = 3;
        $nameVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $nameVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $nameVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $nameVariable->is_point = true;
        $nameVariable->is_show  = true;
        $nameVariable->value    = 1;
        $nameVariable->default  = 1;
        $nameVariable->addOption( '1', 1 );
        $nameVariable->addOption( '2', 2 );
        $nameVariable->addOption( '3', 3 );
        $nameVariable->addOption( '4', 4 );
        $nameVariable->addOption( '5', 5 );
        $nameVariable->addOption( '6', 6 );
        $nameVariable->addOption( '7', 7 );
        $nameVariable->addOption( '8', 8 );
        $nameVariable->addOption( '9', 9 );
        $nameVariable->addOption( '10', 10 );

        return $nameVariable;
    }

    /**
     * StabilityAi 图片 Step 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiStepVariables(): AbstractVariableModule {
        $stepVariable           = ImageVariableModule::new();
        $stepVariable->field    = 'steps';
        $stepVariable->label    = Plugin::translation( 'Steps' );
        $stepVariable->desc     = Plugin::translation( 'the step of the generated images. Number of diffusion steps to run' );
        $stepVariable->order    = 4;
        $stepVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $stepVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $stepVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $stepVariable->is_point = true;
        $stepVariable->is_show  = false;
        $stepVariable->value    = 30;
        $stepVariable->default  = 30;
        $stepVariable->addOption( '15', 15 );
        $stepVariable->addOption( '30', 30 );
        $stepVariable->addOption( '50', 50 );
        $stepVariable->addOption( '100', 100 );
        $stepVariable->addOption( '150', 150 );

        return $stepVariable;
    }

    /**
     * StabilityAi 图片 CfgScale 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiCfgScaleVariables(): AbstractVariableModule {
        $cfgScaleVariable           = ImageVariableModule::new();
        $cfgScaleVariable->field    = 'cfg_scale';
        $cfgScaleVariable->label    = Plugin::translation( 'cfgScale' );
        $cfgScaleVariable->desc     = Plugin::translation( "the cfgScale of the generated images. Which sampler to use for the diffusion process. If this value is omitted we'll automatically select an appropriate sampler for you." );
        $cfgScaleVariable->order    = 5;
        $cfgScaleVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $cfgScaleVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $cfgScaleVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $cfgScaleVariable->is_point = true;
        $cfgScaleVariable->is_show  = false;
        $cfgScaleVariable->value    = 7;
        $cfgScaleVariable->default  = 7;
        $cfgScaleVariable->addOption( '1', 1 );
        $cfgScaleVariable->addOption( '2', 2 );
        $cfgScaleVariable->addOption( '3', 3 );
        $cfgScaleVariable->addOption( '4', 4 );
        $cfgScaleVariable->addOption( '5', 5 );
        $cfgScaleVariable->addOption( '6', 6 );
        $cfgScaleVariable->addOption( '7', 7 );
        $cfgScaleVariable->addOption( '8', 8 );
        $cfgScaleVariable->addOption( '9', 9 );
        $cfgScaleVariable->addOption( '10', 10 );
        $cfgScaleVariable->addOption( '11', 11 );
        $cfgScaleVariable->addOption( '12', 12 );
        $cfgScaleVariable->addOption( '13', 13 );
        $cfgScaleVariable->addOption( '14', 14 );
        $cfgScaleVariable->addOption( '15', 15 );
        $cfgScaleVariable->addOption( '16', 16 );
        $cfgScaleVariable->addOption( '17', 17 );
        $cfgScaleVariable->addOption( '18', 18 );
        $cfgScaleVariable->addOption( '19', 19 );
        $cfgScaleVariable->addOption( '20', 20 );
        $cfgScaleVariable->addOption( '21', 21 );
        $cfgScaleVariable->addOption( '22', 22 );
        $cfgScaleVariable->addOption( '23', 23 );
        $cfgScaleVariable->addOption( '24', 24 );
        $cfgScaleVariable->addOption( '25', 25 );
        $cfgScaleVariable->addOption( '26', 26 );
        $cfgScaleVariable->addOption( '27', 27 );
        $cfgScaleVariable->addOption( '28', 28 );
        $cfgScaleVariable->addOption( '29', 29 );
        $cfgScaleVariable->addOption( '30', 30 );
        $cfgScaleVariable->addOption( '31', 31 );
        $cfgScaleVariable->addOption( '32', 32 );
        $cfgScaleVariable->addOption( '33', 33 );
        $cfgScaleVariable->addOption( '34', 34 );
        $cfgScaleVariable->addOption( '35', 35 );

        return $cfgScaleVariable;
    }

    /**
     * StabilityAi 图片 ClipGuidancePreset 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiClipGuidancePresetVariables(): AbstractVariableModule {
        $clipGuidancePresetVariable           = ImageVariableModule::new();
        $clipGuidancePresetVariable->field    = 'clip_guidance_preset';
        $clipGuidancePresetVariable->label    = Plugin::translation( 'clipGuidancePreset' );
        $clipGuidancePresetVariable->desc     = Plugin::translation( 'the clipGuidancePreset of the generated images. ' );
        $clipGuidancePresetVariable->order    = 6;
        $clipGuidancePresetVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $clipGuidancePresetVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $clipGuidancePresetVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $clipGuidancePresetVariable->is_point = true;
        $clipGuidancePresetVariable->is_show  = false;
        $clipGuidancePresetVariable->value    = 'NONE';
        $clipGuidancePresetVariable->default  = 'NONE';
        $clipGuidancePresetVariable->addOption( 'FAST_BLUE', 'FAST_BLUE' );
        $clipGuidancePresetVariable->addOption( 'FAST_GREEN', 'FAST_GREEN' );
        $clipGuidancePresetVariable->addOption( 'NONE', 'NONE' );
        $clipGuidancePresetVariable->addOption( 'SIMPLE', 'SIMPLE' );
        $clipGuidancePresetVariable->addOption( 'SLOW', 'SLOW' );
        $clipGuidancePresetVariable->addOption( 'SLOWER', 'SLOWER' );
        $clipGuidancePresetVariable->addOption( 'SLOWEST', 'SLOWEST' );

        return $clipGuidancePresetVariable;
    }

    /**
     * StabilityAi 图片 sampler 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiSamplerVariables(): AbstractVariableModule {
        $samplerVariable           = ImageVariableModule::new();
        $samplerVariable->field    = 'sampler';
        $samplerVariable->label    = Plugin::translation( 'sampler' );
        $samplerVariable->desc     = Plugin::translation( "the sampler of the generated images. Which sampler to use for the diffusion process. If this value is omitted we'll automatically select an appropriate sampler for you." );
        $samplerVariable->order    = 7;
        $samplerVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $samplerVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $samplerVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $samplerVariable->is_point = true;
        $samplerVariable->is_show  = false;
        $samplerVariable->value    = '';
        $samplerVariable->default  = '';
        $samplerVariable->addOption( 'DDIM', 'DDIM' );
        $samplerVariable->addOption( 'DDPM', 'DDPM' );
        $samplerVariable->addOption( 'K_DPMPP_2M', 'K_DPMPP_2M' );
        $samplerVariable->addOption( 'K_DPMPP_2S_ANCESTRAL', 'K_DPMPP_2S_ANCESTRAL' );
        $samplerVariable->addOption( 'K_DPM_2', 'K_DPM_2' );
        $samplerVariable->addOption( 'K_DPM_2_ANCESTRAL', 'K_DPM_2_ANCESTRAL' );
        $samplerVariable->addOption( 'K_EULER', 'K_EULER' );
        $samplerVariable->addOption( 'K_EULER_ANCESTRAL', 'K_EULER_ANCESTRAL' );
        $samplerVariable->addOption( 'K_HEUN', 'K_HEUN' );
        $samplerVariable->addOption( 'K_LMS', 'K_LMS' );

        return $samplerVariable;
    }

    /**
     * StabilityAi 图片 StylePreset 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiStylePresetVariables(): AbstractVariableModule {
        $samplerVariable           = ImageVariableModule::new();
        $samplerVariable->field    = 'style_preset';
        $samplerVariable->label    = Plugin::translation( 'Style Preset' );
        $samplerVariable->desc     = Plugin::translation( 'Pass in a style preset to guide the image model towards a particular style. This list of style presets is subject to change' );
        $samplerVariable->order    = 8;
        $samplerVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $samplerVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $samplerVariable->style    = VariableStyleConstant::STYLE_SELECT()->getValue();
        $samplerVariable->is_point = true;
        $samplerVariable->is_show  = true;
        $samplerVariable->value    = 'enhance';
        $samplerVariable->default  = 'enhance';
        $samplerVariable->addOption( '3D Model', '3d-model' );
        $samplerVariable->addOption( 'Analog Film', 'analog-film' );
        $samplerVariable->addOption( 'Anime', 'anime' );
        $samplerVariable->addOption( 'Cinematic', 'cinematic' );
        $samplerVariable->addOption( 'Comic Book', 'comic-book' );
        $samplerVariable->addOption( 'Digital Art', 'digital-art' );
        $samplerVariable->addOption( 'Enhance', 'enhance' );
        $samplerVariable->addOption( 'Fantasy Art', 'fantasy-art' );
        $samplerVariable->addOption( 'Isometric', 'isometric' );
        $samplerVariable->addOption( 'Line Art', 'line-art' );
        $samplerVariable->addOption( 'Low Poly', 'low-poly' );
        $samplerVariable->addOption( 'Modeling Compound', 'modeling-compound' );
        $samplerVariable->addOption( 'Neon Punk', 'neon-punk' );
        $samplerVariable->addOption( 'Origami', 'origami' );
        $samplerVariable->addOption( 'Photographic', 'photographic' );
        $samplerVariable->addOption( 'Pixel Art', 'pixel-art' );
        $samplerVariable->addOption( 'Tile Texture', 'tile-texture' );

        return $samplerVariable;
    }

    /**
     * StabilityAi 图片 seed 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiSeedVariables(): AbstractVariableModule {
        $promptVariable           = ImageVariableModule::new();
        $promptVariable->field    = 'seed';
        $promptVariable->label    = Plugin::translation( 'Seed' );
        $promptVariable->desc     = Plugin::translation( 'Random noise seed (omit this option or use 0 for a random seed, [0, 4294967295L])' );
        $promptVariable->order    = 9;
        $promptVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $promptVariable->style    = VariableStyleConstant::STYLE_INPUT()->getValue();
        $promptVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $promptVariable->is_point = true;
        $promptVariable->is_show  = false;
        $promptVariable->value    = 0;
        $promptVariable->default  = 0;

        return $promptVariable;
    }

    /**
     * StabilityAi 图片 prompt 变量
     *
     * @return AbstractVariableModule
     */
    public static function defStabilityAiPromptVariables(): AbstractVariableModule {
        $promptVariable           = ImageVariableModule::new();
        $promptVariable->field    = 'prompt';
        $promptVariable->label    = Plugin::translation( 'prompt' );
        $promptVariable->desc     = Plugin::translation( 'the prompt of the generated images. The prompt is a string that will be displayed on the generated image. ' );
        $promptVariable->order    = 10;
        $promptVariable->type     = VariableConstant::TYPE_TEXT()->getValue();
        $promptVariable->style    = VariableStyleConstant::STYLE_TEXT()->getValue();
        $promptVariable->group    = VariableGroupConstant::GROUP_MODEL()->getValue();
        $promptVariable->is_point = true;
        $promptVariable->is_show  = true;
        $promptVariable->value    = 'Steampunk submarine exploring a coral reef, surrounded by exotic sea creatures and vibrant coral, detailed, surreal, steampunk style';
        $promptVariable->default  = 'Steampunk submarine exploring a coral reef, surrounded by exotic sea creatures and vibrant coral, detailed, surreal, steampunk style';

        return $promptVariable;
    }

    /**
     * StabilityAi 全部变量
     *
     * @return array
     */
    public static function defStabilityAiVariables(): array {
        return [
//            ImageVariableModule::defStabilityAiEngineIdVariable(),
            self::defStabilityAiSizeVariable(),
            self::defStabilityAiStepVariables(),
            self::defStabilityAiNumberVariables(),
            self::defStabilityAiCfgScaleVariables(),
            self::defStabilityAiClipGuidancePresetVariables(),
            self::defStabilityAiSamplerVariables(),
            self::defStabilityAiStylePresetVariables(),
            self::defStabilityAiSeedVariables(),
            self::defStabilityAiPromptVariables(),
        ];
    }
}
