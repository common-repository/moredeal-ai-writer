<?php

namespace MoredealAiWriter\application\shortcode;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\consts\ResConstant;
use MoredealAiWriter\application\models\TemplateModel;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\application\shortcode\manager\ChatTemplateManager;
use MoredealAiWriter\application\shortcode\manager\MyTplTemplateManager;
use MoredealAiWriter\application\shortcode\manager\TplTemplateManager;
use MoredealAiWriter\code\modules\scene\WPShortCodeSceneModule;
use MoredealAiWriter\code\modules\step\AbstractStepModule;
use MoredealAiWriter\code\modules\step\StepWrapper;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;

/**
 *  渲染模型
 */
class ModuleViewer {

    /**
     * @var ModuleViewer 实例对象
     */
    private static $instance = null;

    /**
     * 获取单例
     *
     * @return ModuleViewer
     */
    public static function getInstance(): ModuleViewer {
        if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 构造函数
     */
    private function __construct() {
    }

    /**
     * init
     *
     * @return void
     */
    public function init() {
        // priority = 12 because do_shortcode() is registered as a default filter on 'the_content' with a priority of 11.
        add_filter( 'the_content', array( $this, 'view_data' ), 12 );
    }

    /**
     * 渲染模型数据
     *
     * @param $content
     *
     * @return mixed
     */
    public function view_data( $content ) {
        return $content;
    }

    /**
     * 渲染模版简码数据
     *
     * @param array $attributes 参数
     * @param string $content 内容
     *
     * @return string
     */
    public function render_template( string $content = '', array $attributes = array() ): string {
        $post_id               = $this->get_post_id();
        $attributes['post_id'] = $post_id;

        $template_manager = TplTemplateManager::getInstance();
        $template         = $attributes['template'];
        $template_id      = $attributes['id'];
        $template_model   = $this->get_template_model( $template_id );
        if ( empty( $template_model ) ) {
            return 'The template does not exist. Please check if the template ID is correct.';
        }
        // error_log(json_encode($template_model->info->steps));
        // 注册脚本和样式
        $this->template_register_scripts( $template );

        // 渲染模板
        return $template_manager->render( $template, array(
            'post_id'        => $post_id,
            'post_title'     => get_the_title( $post_id ),
            'attributes'     => $attributes,
            'template'       => $template,
            'template_id'    => $template_id,
            'template_model' => $template_model,
            'title'          => $attributes['title'],
            'dark'           => $attributes['dark'],
            'content'        => $content,
            'div_id'         => uniqid( 'moredeal_ai_writer_template_' ),
        ) );
    }

    /**
     * 渲染模版简码数据
     *
     * @param array $attributes 参数
     * @param string $content 内容
     *
     * @return string
     */
    public function render_my_template( string $content = '', array $attributes = array() ): string {
        $post_id               = $this->get_post_id();
        $attributes['post_id'] = $post_id;

        $template_manager = MyTplTemplateManager::getInstance();
        $template         = $attributes['template'];
        $query            = array(
            'name'   => $attributes['name'],
            'ids'    => $attributes['ids'],
            'tags'   => $attributes['tags'],
            'scenes' => $attributes['scenes'],
            'topics' => $attributes['topics'],
        );
        unset( $attributes['name'] );
        unset( $attributes['ids'] );
        unset( $attributes['tags'] );
        unset( $attributes['scenes'] );
        unset( $attributes['topics'] );

        // 注册脚本和样式
        $this->template_register_scripts( $template );

        // 渲染模板
        return $template_manager->render( $template, array(
            'post_id'    => $post_id,
            'post_title' => get_the_title( $post_id ),
            'template'   => $template,
            'attributes' => $attributes,
            'query'      => $query,
            'title'      => $attributes['title'],
            'dark'       => $attributes['dark'],
            'content'    => $content,
            'div_id'     => uniqid( 'moredeal_ai_writer_template_' ),
        ) );
    }

    /**
     * 渲染聊天简码数据
     *
     * @param array $attributes 参数
     * @param string $content 内容
     *
     * @return string
     */
    public function render_chat( string $content = '', array $attributes = array() ): string {
        $post_id               = $this->get_post_id();
        $attributes['post_id'] = $post_id;

        $template_manager = ChatTemplateManager::getInstance();
        $template         = $attributes['template'];

        // 注册脚本和样式
        $this->chat_register_scripts( $template );

        // 渲染模板
        return $template_manager->render( $template, array(
            'post_id'    => $post_id,
            'post_title' => get_the_title( $post_id ),
            'attributes' => $attributes,
            'template'   => $template,
            'title'      => $attributes['title'],
            'content'    => $content,
        ) );
    }

    /**
     * 注册脚本
     * @return void
     */
    public function template_register_scripts( $template ) {
        wp_register_style( 'moredeal_aigc_template_vendor_style', ResConstant::MOREDEAL_AIGC_VENDOR_STYLE, array(), Plugin::script_version() );
        wp_register_style( 'moredeal_aigc_template_index_style', ResConstant::MOREDEAL_AIGC_TEMPLATE_INDEX_STYLE, array( 'moredeal_aigc_template_vendor_style' ), Plugin::script_version() );
        wp_enqueue_style( 'moredeal_aigc_template_vendor_style' );
        wp_enqueue_style( 'moredeal_aigc_template_index_style' );

        wp_register_script( 'moredeal_aigc_template_vendor_script', ResConstant::MOREDEAL_AIGC_TEMPLATE_VENDORS_SCRIPT, array(), Plugin::script_version(), true );
        wp_enqueue_script( 'moredeal_aigc_template_vendor_script' );
    }

    /**
     * 注册脚本
     * @return void
     */
    public function chat_register_scripts( $template ) {

    }

    /**
     * 获取文章 ID
     *
     * @return int
     */
    public function get_post_id(): int {
        $post_id = get_the_ID();

        if ( $post_id ) {
            return $post_id;
        }

        return 0;
    }

    /**
     * 获取模版市场数据
     *
     * @param int $template_id
     *
     * @return
     */
    public function get_template_model( int $template_id = 0 ) {

        try {
            $template_model = TemplateModel::getInstance()->templateDetail( $template_id );
        } catch ( Exception $e ) {
            return false;
        }

        if ( empty( $template_model ) ) {
            return false;
        }

        /**
         * @var $info AbstractTemplateModule
         */
        $info = $template_model->info;
        if ( empty( $info ) ) {
            return $template_model;
        }

        // 全局变量
        $info_variables = $info->variables;
        if ( ! empty( $info_variables ) ) {
            foreach ( $info_variables as $index => $variable ) {
                unset( $variable->desc );
                $info_variables[ $index ] = $variable;
            }
        }
        $info->variables = $info_variables;

        $steps = $info->steps;
        if ( empty( $steps ) ) {
            return $template_model;
        }

        $filter_steps = array();
        foreach ( $steps as $key => $step ) {

            /**
             * @var $step StepWrapper
             */
            if ( empty( $step->stepModule ) ) {
                continue;
            }

            // 去掉 desc
            unset( $step->desc );

            // 变量去掉 desc
            $variables = $step->variables;
            foreach ( $variables as $index => $variable ) {
                unset( $variable->desc );
                $variables[ $index ] = $variable;
            }
            $step->variables = $variables;

            /**
             * @var $step_module AbstractStepModule
             */
            $step_module = $step->stepModule;
            if ( empty( $step_module->key ) ) {
                continue;
            }
            unset( $step_module->desc );
            $step_variables = $step_module->variables;
            foreach ( $step_variables as $index => $variable ) {
                unset( $variable->desc );
                $step_variables[ $index ] = $variable;
            }
            $step_module->variables = $step_variables;

            $scene_keys = array_column( $step_module->scenes, 'key' );
            if ( empty( $step_module->scenes ) || in_array( WPShortCodeSceneModule::getModuleKey(), $scene_keys ) ) {
                $step->stepModule = $step_module;
                $filter_steps[]   = $step;
            }
        }

        unset( $info->desc );
        $info->steps          = array_values( $filter_steps );
        $template_model->info = $info;
        unset( $template_model->desc );

        return $template_model;
    }

}
