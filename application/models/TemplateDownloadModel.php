<?php

namespace MoredealAiWriter\application\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\step\StepManager;
use MoredealAiWriter\code\modules\template\TemplateManager;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

/**
 * 模版下载模型
 *
 * @author MoredealAiWriter
 */
class TemplateDownloadModel extends Model {

    /**
     * 实例
     * @var TemplateDownloadModel|null
     */
    private static $instance = null;
    /**
     * 主键 ID
     * @var int
     */
    public $id;
    public $template_id;
    public $temp_key;
    /**
     * 模版名称
     * @var string
     */
    public $name;
    /**
     * 模版状态
     * @var int
     */
    public $status;
    /**
     * 最后操作的人
     * @var
     */
    public $modifier;
    /**
     * 主题
     * @var
     */
    public $topics;
    public $icon;
    /**
     * 模版标签
     * @var
     */
    public $tags;
    public $image_urls;
    public $scenes;
    public $version;
    public $plugin_version;
    public $plugin_level;
    public $cost;
    public $config;
    /**
     * 模版描述
     * @var string
     */
    public $desc;
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

    public function __construct() {
    }

    /**
     * 实例
     *
     * @return TemplateDownloadModel
     */
    public static function getInstance(): TemplateDownloadModel {

        self::$instance = new self;

        return self::$instance;
    }

    public function dump_sql(): string {
        return "CREATE TABLE " . $this->table_name() . "
        (
          `id` bigint NOT NULL AUTO_INCREMENT,
          `template_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `temp_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `status` int NOT NULL,
          `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `modifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '最后操作者',
          `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
          `image_urls` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
          `scenes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
          `topics` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `version` int NOT NULL,
          `plugin_version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
          `plugin_level` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `free` tinyint(1) DEFAULT NULL,
          `audit` tinyint DEFAULT NULL,
          `cost` decimal(10,2) DEFAULT NULL,
          `config` json NOT NULL,
          `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
          `gmt_create` datetime NOT NULL COMMENT '模版创建时间',
          `gmt_modified` datetime NOT NULL COMMENT '模版更新时间',
          `is_delete` tinyint NOT NULL COMMENT '是否删除： 0：正常，1：已删除',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    }

    public function table_name(): string {
        return $this->table_prefix() . "template_download";
    }

    /**
     * 根据 ID 获取模版详情
     *
     * @param  $templateId
     *
     * @return TemplateDownloadModel|null
     * @throws Exception
     */
    public function templateDetail( $templateId ) {

        $sql    = "SELECT `id`, `template_id`, `modifier`, `temp_key`, `name`, `status`, `icon`, `tags`, `image_urls`, `topics`, `scenes`, `version`, `config`, `desc`, `gmt_create`, `gmt_modified` FROM " . $this->table_name() . " WHERE `template_id` = %s";
        $detail = $this->get_db()->get_row( $this->get_db()->prepare( $sql, $templateId ) );
        // 详情为空事后直接返回 空数组, 避免后续报错
        if ( $detail == null ) {
            return null;
        }

        return self::convert( $detail );
    }

    /**
     * @param      $data
     * @param bool $is_parse_info
     *
     * @return TemplateDownloadModel
     * @throws Exception
     */
    private static function convert( $data, bool $is_parse_info = true ): TemplateDownloadModel {
        $model = new self();

        $model = ModuleConvertUtil::convert( $model, $data );
        if ( is_string( $model->tags ) ) {
            $model->tags = explode( ',', $model->tags );
        }

        if ( is_string( $model->image_urls ) && ! empty( $model->image_urls ) ) {
            $model->image_urls = explode( ',', $model->image_urls );
        } else {
            $model->image_urls = null;
        }

        if ( is_string( $model->topics ) ) {
            $model->topics = explode( ',', $model->topics );
        }

        if ( is_string( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( array_map( 'trim', explode( ',', $model->scenes ) ) );
        } else if ( is_object( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( (array) $model->scenes );
        } else if ( is_array( $model->scenes ) ) {
            $model->scenes = SceneManager::handler_scene_keys( $model->scenes );
        } else {
            $model->scenes = SceneManager::default_scene_keys();
        }

        $info = $model->config;

        if ( is_string( $info ) ) {
            $info = json_decode( $info );
        }

        if ( is_array( $info ) ) {
            $info = (object) $info;
        }

        if ( $is_parse_info ) {
            $info         = TemplateManager::factoryByKey( $info );
            $info->scenes = SceneManager::handler_scenes( $model->scenes );
        }

        $model->info = $info;

        return $model;

    }

    /**
     * 查询下载模板列表
     *
     * @param array $params
     * @param array $columns
     *
     * @return array
     * @throws Exception
     */
    public function findList( array $params, array $columns ): array {

        $listSql  = 'SELECT `id`, `template_id` as `key`, `name`,`topics`, `config`, `image_urls`, `tags`, `icon`, `config`, `desc`,`gmt_create`, `gmt_modified` FROM ' . $this->table_name();
        $whereSql = $this->prepareWhereSql( $params );
        $listSql  = $listSql . $whereSql . " ORDER BY `gmt_modified` DESC";

        $list = $this->get_db()->get_results( $this->get_db()->prepare( $listSql ) );

        if ( ! is_array( $list ) ) {
            $list = array();
        }

        if ( count( $list ) > 0 ) {
            foreach ( $list as $index => $item ) {
                if ( is_string( $item->tags ) ) {
                    $item->tags = explode( ',', $item->tags );
                }

                if ( is_string( $item->topics ) ) {
                    $item->topics = explode( ',', $item->topics );
                }

                if ( is_string( $item->image_urls ) && ! empty( $item->image_urls ) ) {
                    $item->image_urls = explode( ',', $item->image_urls )[0];
                } else {
                    $seastarRestfulClient = new SeastarRestfulClient();
                    $image                = $seastarRestfulClient->handleCommonDefaultImage( $item->topics );
                    $item->image_urls     = $image;
                }

                $stepIcons     = array();
                $config        = json_decode( $item->config );
                $step_wrappers = $config->steps;
                foreach ( $step_wrappers as $idx => $step_wrapper ) {
                    $step_wrapper      = StepManager::factoryWrapperByKey( $step_wrapper );
                    $stepIcons[ $idx ] = $step_wrapper->stepModule->icon;
                }
                unset( $item->config );
                $item->stepIcons = $stepIcons;
            }
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
    private function prepareWhereSql( array $params ): string {
        $whereSql = ' WHERE `is_delete` = 0 ';

        if ( isset( $params['name'] ) ) {
            $whereSql .= " AND `name` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, '%' . $params['name'] . '%' );
        }

        // 用户查询
        if ( isset( $params['user_name'] ) ) {
            $whereSql .= " AND `modifier` = %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['user_name'] );
        }

        // topics 查询
        if ( isset( $params['topics'] ) && is_array( $params['topics'] ) && ! empty( $params['topics'] ) ) {
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

        return $whereSql;
    }

    /**
     * 删除模板by templateId
     *
     * @param $templateId
     *
     * @return false|int 删除的行数，或出错时为 false
     */
    public function deleteByTemplateId( $templateId ) {
        return $this->get_db()->delete( $this->table_name(), array( 'template_id' => $templateId ) );
    }
}