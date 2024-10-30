<?php

namespace MoredealAiWriter\application\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\admin\GeneralConfig;
use MoredealAiWriter\code\modules\scene\AbstractSceneModule;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\Base64SaveStepModule;
use MoredealAiWriter\code\modules\step\CreatePostStepModule;
use MoredealAiWriter\code\modules\step\OpenApiStepModule;
use MoredealAiWriter\code\modules\step\StabilityAiImageStepModule;
use MoredealAiWriter\code\modules\step\StepManager;
use MoredealAiWriter\code\modules\step\StepWrapper;
use MoredealAiWriter\code\modules\template\AbstractTemplateModule;
use MoredealAiWriter\code\modules\template\TemplateFactory;
use MoredealAiWriter\code\modules\template\TemplateManager;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * TemplateModel class file
 *
 * @author MoredealAiWriter
 */
class TemplateModel extends Model {

    /**
     * 实例
     * @var TemplateModel|null
     */
    private static $instance = null;
    /**
     * 主键 ID
     * @var int
     */
    public $id;
    /**
     * 模版id
     * @var string
     */
    public $template_id;
    /**
     * 模版名称
     * @var string
     */
    public $name;
    /**
     * 模版类型
     * @var string
     */
    public $type;
    /**
     * 模版key
     * @var string
     */
    public $temp_key;
    /**
     * 版本
     * @var int
     */
    public $version;
    /**
     * 模版状态
     * @var int
     */
    public $status;
    /**
     * 模版描述
     * @var string
     */
    public $desc;
    /**
     * 模版标签
     * @var
     */
    public $tags;
    /**
     * 模版主题
     * @var
     */
    public $topics;

    /**
     * icon
     * @var
     */
    public $icon;

    /**
     * 修改人
     * @var
     */
    public $modifier;

    /**
     * 场景
     * @var
     */
    public $scenes;
    /**
     * 模版详细配置信息
     * @var string
     */
    public $info;

    /**
     * 上传时间
     * @var
     */
    public $update_time;

    /**
     * 模版创建时间
     * @var
     */
    public $gmt_create;
    /**
     * 模版更新时间
     * @var
     */
    public $gmt_modified;
    /**
     * 是否删除
     * @var int
     */
    public $is_delete;
    /**
     * 变量提示
     *
     * @var
     */
    public $_variableToTips;

    /**
     * @var array
     */
    public $stepIcons;

    /**
     * 默认分页大小
     * @var array
     */
    const PAGE_DEFAULT_PARAMS = array( 'limit' => 10000, 'current' => 1 );

    /**
     * 需要查询的字段
     */
    const GENERIC_QUERY_FIELD = "`id`, `name`, `template_id`, `modifier`,`update_time`,`temp_key`, `version`, `topics`, `icon`, `type`, `desc`, `status`, `tags`, `scenes`, `gmt_create`, `gmt_modified`";

    /**
     * 分页默认参数
     *
     * @return array
     */
    public static function page_default_params(): array {
        return self::PAGE_DEFAULT_PARAMS;
    }

    /**
     * 通用查询字段
     *
     * @param bool $include_info
     *
     * @return string
     */
    public static function generic_query_field( bool $include_info = false ): string {
        if ( $include_info ) {
            return self::GENERIC_QUERY_FIELD . ", `info`";
        }

        return self::GENERIC_QUERY_FIELD;
    }

    /**
     * 实例
     *
     * @return TemplateModel
     */
    public static function getInstance(): TemplateModel {

        self::$instance = new static();

        return self::$instance;
    }

    /**
     * 构建模版
     *
     * @param AbstractTemplateModule $template
     *
     * @return TemplateModel
     */
    public static function buildByTemplate( AbstractTemplateModule $template ): TemplateModel {
        $model           = self::getInstance();
        $model->temp_key = $template->key;
        $model->scenes   = SceneManager::get_scene_keys( $template->scenes );
        $model->icon     = $template->icon;
        $model->info     = $template;
        $model->topics   = $model->buildTopics( $template->topics );
        $model->tags     = $model->buildTags( $template->tags );

        unset( $model->id );
        unset( $model->status );
        unset( $model->gmt_create );
        unset( $model->gmt_modified );
        unset( $model->is_delete );

        return $model;
    }

    /**
     * 构建标签
     *
     * @param $tags
     *
     * @return array
     */
    public function buildTags( $tags ): array {
        if ( is_string( $tags ) && ! empty( $tags ) ) {
            return array_map( 'trim', explode( ',', $tags ) );
        }

        if ( is_array( $tags ) ) {
            return $tags;
        }

        if ( is_object( $tags ) ) {
            return (array) $tags;
        }

        return array();
    }

    /**
     * 构建主题
     *
     * @param $topics
     *
     * @return array
     */
    public function buildTopics( $topics ): array {
        if ( is_string( $topics ) && ! empty( $topics ) ) {
            return array_map( 'trim', explode( ',', $topics ) );
        }

        if ( is_array( $topics ) ) {
            return $topics;
        }

        if ( is_object( $topics ) ) {
            return (array) $topics;
        }

        return array();
    }

    /**
     * @param $params string
     * @param $option_type int 选项类型, 1: 新增 2: 复制, 3: 修改
     *
     * @return TemplateModel
     * @throws Exception
     */
    public static function parseAndVerify( $params, int $option_type ): TemplateModel {

        if ( $option_type > 4 || $option_type < 1 ) {
            throw new Exception( "The option type is not support" );
        }

        $params = json_decode( $params );

        if ( $option_type == self::MODIFY ) {
            if ( ! isset( $params->id ) ) {
                throw new Exception( 'The template id is required' );
            }
        }

        if ( ! isset( $params->temp_key ) || ! in_array( $params->temp_key, array_column( TemplateFactory::getTemplateRecommend(), 'key' ) ) ) {
            throw new Exception( 'The template key is required or not support this key' );
        }

        if ( ! isset( $params->info ) ) {
            throw new Exception( "The template info data is required" );
        }

        if ( $option_type < 4 ) {
            if ( ! isset( $params->name ) ) {
                throw new Exception( 'The template name is required' );
            }
        }

        // 转换为 TemplateModel
        $model = self::convert( $params );
        if ( self::INSERT == $option_type || self::COPY == $option_type ) {
            if ( isset( $model->id ) || property_exists( $model, 'id' ) ) {
                unset( $model->id );
            }
            // 状态
            $model->status = 0;
            // 创建时间
            $model->gmt_create = current_time( 'mysql' );
            // 最后修改人
            $model->modifier = wp_get_current_user()->user_login;
        }

        // 是否删除
        $model->is_delete = 0;
        // 修改时间
        $model->gmt_modified = current_time( 'mysql' );

        /**
         * @var AbstractTemplateModule $info
         */
        $info = $model->info;

        // 标签
        if ( is_array( $model->tags ) ) {
            $model->tags = implode( ',', $model->tags );
        }

        // 主题
        if ( is_array( $model->topics ) ) {
            $model->topics = implode( ',', $model->topics );
        }

        // 组装校验场景
        $sceneList      = array();
        $handler_scenes = SceneManager::handler_scene_keys( $model->scenes );
        try {
            foreach ( $handler_scenes as $index => $scene_key ) {
                /**
                 * @var $scene AbstractSceneModule
                 */
                $scene = SceneManager::factoryScene( $scene_key );
                // 校验场景信息
                $scene->save_before( $scene, $info );
                $sceneList[ $index ] = $scene;
            }

            // 校验模版 step 信息
            self::verifyStep( $model );
        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
        // 场景
        $info->scenes = $sceneList;
        // 场景
        $model->scenes = implode( ',', $handler_scenes );
        // info
        $model->info = json_encode( $model->info );

        return $model;
    }

    /**
     * 校验 step。
     *
     * @param TemplateModel $model
     *
     * @return void
     * @throws Exception
     */
    private static function verifyStep( TemplateModel $model ) {
        /**
         * @var AbstractTemplateModule $info
         */
        $info = $model->info;

        /**
         * @var StepWrapper[] $stepList
         */
        $stepList = $info->steps;
        // 校验，step 最起码配置一个
        if ( ! is_array( $stepList ) || empty( $stepList ) || count( $stepList ) < 1 ) {
            throw new Exception( 'Template steps are required and at least one step needs to be configured！' );
        }
        $functionalSteps = StepManager::get_functional_step_keys();
        $countSteps      = count( $stepList );
        // 校验，如果只有一个 step 的时候，stepModule key 不能为 $functionalSteps 中的 step
        if ( $countSteps == 1 ) {
            $oneStepWrapper = $stepList[0];
            $oneStep        = $oneStepWrapper->stepModule;
            if ( in_array( $oneStep->key, $functionalSteps ) ) {
                throw new Exception( 'The step cannot be ' . $oneStepWrapper->label . '(' . $oneStep->name . ') when there is only one step！' );
            }
        }
        // 校验 如果 key 在 $functionalSteps 中，那么该 step 在 $stepModule 只能有一个且该 step 的下一个的 step 不能为 $standardSteps 中的 step
        $standardSteps       = StepManager::get_standard_steps();
        $functionalStepCount = StepManager::get_functional_step_keys_count();
        foreach ( $stepList as $index => $stepWrapper ) {
            $stepModule = $stepWrapper->stepModule;
            if ( in_array( $stepModule->key, $functionalSteps ) ) {
                $functionalStepCount[ $stepModule->key ] ++;
                if ( $functionalStepCount[ $stepModule->key ] > 1 ) {
                    throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step can only be configured once！' );
                }
                if ( $stepModule->key == Base64SaveStepModule::getModuleKey() ) {
                    if ( $index == 0 ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step cannot be the first step！' );
                    }
                    // 该步骤上一步，必须是生成图片步骤
                    $prevStepWrapper = $stepList[ $index - 1 ];
                    $prevStep        = $prevStepWrapper->stepModule;
                    if ( $prevStep->key != StabilityAiImageStepModule::getModuleKey() ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step must be followed by ' . $prevStepWrapper->label . '(' . $prevStep->key . ') step！' );
                    }
                }
                if ( $stepModule->key == CreatePostStepModule::getModuleKey() ) {
                    if ( $index == 0 ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step cannot be the first step！' );
                    }

                    // 该步骤前面的步骤不能少于三个
                    if ( $index < 3 ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step must be preceded by three Generate Text Step！' );
                    }

                    // 该步骤前面的步骤里面必须含有三个 OpenApiStepModule
                    $openApiStepCount = 0;
                    for ( $i = 0; $i < $index; $i ++ ) {
                        $prevStepWrapper = $stepList[ $i ];
                        $prevStep        = $prevStepWrapper->stepModule;
                        if ( $prevStep->key == OpenApiStepModule::getModuleKey() ) {
                            $openApiStepCount ++;
                        }
                    }
                    if ( $openApiStepCount < 3 ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step must be followed by three Generate Text Step！' );
                    }
                }
                if ( $index != $countSteps - 1 ) {
                    $nextStepWrapper = $stepList[ $index + 1 ];
                    $nextStep        = $nextStepWrapper->stepModule;
                    if ( in_array( $nextStep->key, $standardSteps ) ) {
                        throw new Exception( 'The ' . $stepWrapper->label . '(' . $stepModule->name . ') step cannot be followed by ' . $nextStepWrapper->label . '(' . $nextStep->key . ') step！' );
                    }
                }
            }
        }
    }

    /**
     * 根据name查询模型
     *
     * @param $name
     *
     * @return array | null
     */
    public function findByName( $name ) {

        $sql = 'SELECT ' . self::generic_query_field() . ' FROM ' . $this->table_name() . ' WHERE `name` = %s ';

        try {
            return $this->get_db()->get_row( $this->get_db()->prepare( $sql, $name ), ARRAY_A );
        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return null;
        }

    }

    /**
     * 建表 SQL
     * @return string
     */
    public function dump_sql(): string {
        return "CREATE TABLE " . $this->table_name() . "
        (
          `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '模板自增id',
          `template_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '模版id',
          `name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '模版名称',
          `modifier` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '修改者',
          `temp_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '模版key',
          `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '模版类型',
          `status` tinyint DEFAULT NULL COMMENT '模版状态，0：启用，1：禁用',
          `version` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '模版描述',
          `tags` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '模版标签，多个以逗号分割',
          `topics` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '主题',
          `scenes` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '场景',
          `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
          `info` json NOT NULL COMMENT '模版详细配置信息',
          `update_time` datetime DEFAULT NULL COMMENT '模版上传时间',
          `gmt_create` datetime DEFAULT NULL COMMENT '模版创建时间',
          `gmt_modified` datetime DEFAULT NULL COMMENT '模版更新时间',
          `is_delete` tinyint DEFAULT NULL COMMENT '是否删除： 0：正常，1：已删除',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;	
		";
    }

    /**
     * 表成名
     * @return string
     */
    public function table_name(): string {
        return $this->table_prefix() . "template";
    }

    /**
     * 分页获取模版列表
     *
     * @param array $params
     *
     * @return array
     * @throws Exception
     */
    public function page( array $params ): array {
        $user_template_permission = GeneralConfig::getUserTemplatePermission();

        if ( $user_template_permission ) {
            $user_id   = wp_get_current_user()->ID;
            $user_name = wp_get_current_user()->user_login;
            if ( ! current_user_can( 'administrator', $user_id ) ) {
                $params['user_name'] = $user_name;
            }
        }

        $default_params = TemplateModel::page_default_params();

        if ( empty( $params['limit'] ) ) {
            $params['limit'] = $default_params['limit'];
        }
        $limit = $params['limit'];

        if ( empty( $params['current'] ) ) {
            $params['current'] = $default_params['current'];
        }
        $current = $params['current'];
        $offset  = ( $current - 1 ) * $limit;

        $pageSql  = 'SELECT ' . self::generic_query_field( true ) . ' FROM ' . $this->table_name();
        $whereSql = $this->prepare_page_where_sql( $params );
        $pageSql  = $pageSql . $whereSql . " ORDER BY `gmt_modified` DESC LIMIT %d, %d";
        // 查询列表
        $list = $this->get_db()->get_results( $this->get_db()->prepare( $pageSql, $offset, $limit ) );

        // 查询数据为空时候，返回空数组
        if ( ! is_array( $list ) ) {
            $list = array();
        }

        if ( count( $list ) > 0 ) {
            foreach ( $list as $index => $item ) {
                $stepIcons = array();
                $template  = self::convert( $item );
                /**
                 * @var $info AbstractTemplateModule
                 */
                $info = $template->info;
                /**
                 * @var $step_wrappers StepWrapper[]
                 */
                $step_wrappers = $info->steps;
                foreach ( $step_wrappers as $step_wrapper ) {
                    $step        = $step_wrapper->stepModule;
                    $stepIcons[] = $step->icon;
                }
                unset( $template->info );
                unset( $template->is_delete );
                $template->stepIcons = $stepIcons;
                $list[ $index ]      = $template;
            }
            // 查询总数
            $total = $this->get_db()->get_var( 'SELECT COUNT(*) FROM ' . $this->table_name() . $whereSql );
        } else {
            $total = 0;
        }

        return array(
            'list'    => $list,
            'total'   => intval( $total ),
            'current' => $current,
            'limit'   => $limit
        );
    }

    /**
     * 分页获取模版列表
     *
     * @param array $params
     *
     * @return array
     * @throws Exception
     */
    public function listTemplate( array $params ): array {

        $pageSql  = 'SELECT ' . self::generic_query_field() . ' FROM ' . $this->table_name();
        $whereSql = $this->prepare_page_where_sql( $params );
        $pageSql  = $pageSql . $whereSql . " ORDER BY `gmt_modified` DESC";
        // 查询列表
        $list = $this->get_db()->get_results( $this->get_db()->prepare( $pageSql ) );

        // 查询数据为空时候，返回空数组
        if ( ! is_array( $list ) ) {
            $list = array();
        }
        foreach ( $list as $index => $item ) {
            $template = self::convert( $item, false );
            if ( ! empty( $params['is_easy_template'] ) ) {
                // unset 除了 id，名称，描述, 场景以外的所有字段
                unset( $template->template_id );
                unset( $template->temp_key );
                unset( $template->type );
                unset( $template->status );
                unset( $template->version );
                unset( $template->tags );
                unset( $template->topics );
                unset( $template->icon );
                unset( $template->update_time );
                unset( $template->gmt_create );
                unset( $template->gmt_modified );
                unset( $template->_variableToTips );
                unset( $template->stepIcons );
                unset( $template->modifier );
            }
            unset( $template->info );
            unset( $template->is_delete );
            $list[ $index ] = $template;
        }

        return $list;
    }

    /**
     * 获取 WHERE 查询条件
     *
     * @param array $params
     *
     * @return string
     */
    private function prepare_page_where_sql( array $params ): string {

        $whereSql = ' WHERE `is_delete` = 0 ';

        // 模版状态查询
        if ( isset( $params['status'] ) ) {
            $whereSql .= " AND `status` = %d";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['status'] );
        }

        // 模版名称模糊查询
        if ( isset( $params['name'] ) ) {
            $whereSql .= " AND `name` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, '%' . $params['name'] . '%' );
        }

        // 模版场景查询
        if ( isset( $params['scenes'] ) ) {
            $whereSql .= " AND `scenes` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, '%' . $params['scenes'] . '%' );
        }

        // 用户查询
        if ( isset( $params['user_name'] ) ) {
            $whereSql .= " AND `modifier` = %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['user_name'] );
        }

        // topics 查询
        if ( ! empty( $params['topics'] ) && is_array( $params['topics'] ) ) {
            // topics 为数组时候，循环 or 查询组成一个，OR 部分用 () 包裹
            $topicsSql = ' AND (';
            foreach ( $params['topics'] as $index => $topic ) {
                if ( $index > 0 ) {
                    $topicsSql .= ' OR ';
                }
                $topicsSql .= "`topics` LIKE %s";
                $topicsSql = $this->get_db()->prepare( $topicsSql, '%' . $topic . '%' );
                if ( $index == count( $params['topics'] ) - 1 ) {
                    $topicsSql .= ')';
                }
            }
            $whereSql .= $topicsSql;
        }

        // tags 查询
        if ( ! empty( $params['tags'] ) && is_array( $params['tags'] ) ) {
            // tags 为数组时候，循环 or 查询组成一个，OR 部分用 () 包裹
            $tagsSql = ' AND (';
            foreach ( $params['tags'] as $index => $tag ) {
                if ( $index > 0 ) {
                    $tagsSql .= ' OR ';
                }
                $tagsSql .= "`tags` LIKE %s";
                $tagsSql = $this->get_db()->prepare( $tagsSql, '%' . $tag . '%' );
                if ( $index == count( $params['tags'] ) - 1 ) {
                    $tagsSql .= ')';
                }
            }
            $whereSql .= $tagsSql;
        }

        return $whereSql;
    }

    /**
     * 将数组或者对象转为该模型
     *
     * @param      $data object
     * @param bool $is_parse_info 是否解析 info 字段为具体的魔板类型数据
     *
     * @return TemplateModel
     * @throws Exception
     */
    public static function convert( $data, bool $is_parse_info = true ): TemplateModel {
        $model = new self();
        /**
         * @var $model TemplateModel
         */
        $model = ModuleConvertUtil::convert( $model, $data );

        if ( empty( $model->temp_key ) && ! empty( $model->type ) ) {
            $model->temp_key = $model->type;
        }

        $model->tags   = $model->buildTags( $model->tags );
        $model->topics = $model->buildTopics( $model->topics );

        if ( is_string( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( array_map( 'trim', explode( ',', $model->scenes ) ) );
        } else if ( is_object( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( (array) $model->scenes );
        } else if ( is_array( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( $model->scenes );
        } else {
            $model->scenes = SceneManager::default_scene_keys();
        }

        $info = $model->info;
        if ( is_string( $info ) ) {
            $info = json_decode( $info );
        }
        if ( is_array( $info ) ) {
            $info = (object) $info;
        }
        if ( $is_parse_info ) {
            try {
                $info = TemplateManager::factoryByKey( $info );
                if ( ! empty( $model->name ) ) {
                    $info->name = $model->name;
                }
                $info->scenes = SceneManager::handler_scenes( $model->scenes );

            } catch ( Exception $e ) {
                throw new Exception( $model->name . $e->getMessage() );
            }
        }
        $model->info = $info;

        return $model;
    }

    /**
     * 根据 ID 获取模版详情
     *
     * @param int $tmpId 模版 ID
     *
     * @return TemplateModel|null
     * @throws Exception
     */
    public function templateDetail( int $tmpId ) {

        $sql    = "SELECT " . self::generic_query_field( true ) . " FROM " . $this->table_name() . " WHERE `id` = %d";
        $detail = $this->get_db()->get_row( $this->get_db()->prepare( $sql, $tmpId ) );
        // 详情为空事后直接返回 空数组, 避免后续报错
        if ( $detail == null ) {
            return null;
        }

        return self::convert( $detail );
    }

    /**
     * 复制模版
     *
     * @param TemplateModel $model 模版信息
     *
     * @return int|false 复制成功返回自增主键 ID，或出错时为 false
     */
    public function copyTemplate( TemplateModel $model ) {

        return $this->createTemplate( $model );
    }

    /**
     * 新增模版
     *
     * @param $model TemplateModel 模版信息
     *
     * @return int|false 插入成功返回自增主键 ID，或出错时为 false
     */
    public function createTemplate( TemplateModel $model ) {

        if ( isset( $model->id ) || property_exists( $model, 'id' ) ) {
            unset( $model->id );
        }

        if ( isset( $model->_variableToTips ) || property_exists( $model, '_variableToTips' ) ) {
            unset( $model->_variableToTips );
            unset( $model->stepIcons );
        }

        $insert = $this->insert( (array) $model );
        if ( ! $insert ) {
            return false;
        }

        return $this->get_db()->insert_id;
    }

    /**
     * 更新模版
     *
     * @param $model TemplateModel 模版信息
     *
     * @return int|false 更新成功返回主键 ID，或出错时为 false
     */
    public function modifyTemplate( TemplateModel $model ) {

        if ( empty( $model->id ) ) {
            return false;
        }

        if ( isset( $model->_variableToTips ) || property_exists( $model, '_variableToTips' ) ) {
            unset( $model->_variableToTips );
            unset( $model->stepIcons );
        }

        $update = $this->updateById( (array) $model );
        if ( ! $update ) {
            return false;
        }

        return $model->id;
    }

    /**
     * 删除模版
     *
     * @param int  $tmpId 模版 ID
     * @param bool $isTombstones 是否放入回收站, 是否为逻辑删除，默认为 true，false 时候彻底删除
     *
     * @return bool|int 删除成功返回主键 ID，或出错时为 false
     */
    public function deleteTemplate( int $tmpId, bool $isTombstones = true ) {
        if ( $isTombstones ) {
            $model            = new TemplateModel();
            $model->id        = $tmpId;
            $model->is_delete = 1;

            if ( isset( $model->_variableToTips ) || property_exists( $model, '_variableToTips' ) ) {
                unset( $model->_variableToTips );
                unset( $model->stepIcons );
            }

            $update = $this->updateById( (array) $model );
            if ( ! $update ) {
                return false;
            }

            return $tmpId;

        }

        $delete = $this->deleteById( $tmpId );
        if ( ! $delete ) {
            return false;
        }

        return $tmpId;
    }

    /**
     * 获取标签集合
     *
     * @return array
     */
    public function getTags(): array {
        $sql = "SELECT GROUP_CONCAT(distinct `tags` ) FROM " . $this->table_name() . " WHERE `tags` <> ''";

        $tags = $this->get_db()->get_var( $sql );


        if ( ! empty( $tags ) && is_string( $tags ) ) {
            $tags = explode( ',', $tags );
        } else {
            $tags = array();
        }

        return $tags;
    }
}
