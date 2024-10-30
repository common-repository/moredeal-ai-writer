<?php

namespace MoredealAiWriter\application\models;

defined( '\ABSPATH' ) || exit;

/**
 * 模版实例模型
 *
 * @author MoredealAiWriter
 */
class TemplateInstanceModel extends Model {

    /**
     * 实例
     * @var TemplateInstanceModel|null
     */
    private static $instance = null;

    /**
     * 实例
     *
     * @return TemplateInstanceModel
     */
    public static function getInstance(): TemplateInstanceModel {
//		if ( self::$instance == null ) {
//			self::$instance = new self;
//		}
        self::$instance = new self;

        return self::$instance;
    }

    /**
     * 表名称
     * @return string
     */
    public function table_name(): string {
        return $this->table_prefix() . "template_instance";
    }

    /**
     * 建表 SQL
     * @return string
     */
    public function dump_sql(): string {
        return "CREATE TABLE `" . $this->table_name() . "` (
		  `id` bigint NOT NULL COMMENT '模版 ID',
		  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '模版名称',
		  `status` tinyint DEFAULT NULL COMMENT '模版状态，0：启用，1：禁用',
		  `desc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '模版描述',
		  `tags` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '模版标签，多个以逗号分割',
		  `info` json DEFAULT NULL COMMENT '模版详细配置信息',
		  `gmt_create` datetime DEFAULT NULL COMMENT '模版创建时间',
		  `gmt_modified` datetime DEFAULT NULL COMMENT '模版更新时间',
		  `is_delete` tinyint DEFAULT NULL COMMENT '是否删除： 0：正常，1：已删除',
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;	
		";
    }

    /**
     * 分页获取模版列表
     *
     * @param array $params
     *
     * @return array
     */
    public function page( array $params ): array {
        if ( ! isset( $params['limit'] ) ) {
            $params['limit'] = 10;
        }
        $limit = $params['limit'];

        if ( ! isset( $params['current'] ) ) {
            $params['current'] = 1;
        }
        $current = $params['current'];
        $offset  = ( $current - 1 ) * $limit;

        $pageSql  = 'SELECT `id`, `name`, `desc`, `status`, `tags`, `gmt_create`, `gmt_modified` FROM ' . $this->table_name();
        $whereSql = $this->preparePageWhereSql( $params );
        $pageSql  = $pageSql . $whereSql . " ORDER BY `gmt_modified` DESC LIMIT %d, %d";

        // 查询列表
        $list = $this->get_db()->get_results( $this->get_db()->prepare( $pageSql, $offset, $limit ), ARRAY_A );

        // 查询数据为空时候，返回空数组
        if ( ! is_array( $list ) ) {
            $list = array();
        }

        if ( count( $list ) <= 0 ) {
            $total = 0;
        } else {
            // 查询总数
            $total = $this->get_db()->get_var( 'SELECT COUNT(*) FROM ' . $this->table_name() . $whereSql );
        }

        return array(
            'list'    => $list,
            'total'   => intval( $total ),
            'current' => $current,
            'limit'   => $limit
        );
    }

    /**
     * 根据 ID 获取模版详情
     *
     * @param int $tmpId 模版 ID
     *
     * @return array
     */
    public function templateDetail( int $tmpId ): array {

        $sql    = "SELECT `id`, `name`, `desc`, `status`, `tags`, `info`, `gmt_create`, `gmt_modified` FROM " . $this->table_name() . " WHERE `id` = %d";
        $detail = $this->get_db()->get_row( $this->get_db()->prepare( $sql, $tmpId ), ARRAY_A );
        // 详情为空事后直接返回 空数组, 避免后续报错
        if ( ! is_array( $detail ) ) {
            return array();
        }

//		$detail['info'] = json_decode( $detail['info'], true );

        return $detail;
    }

    /**
     * 获取 WHERE 查询条件
     *
     * @param array $params
     *
     * @return string
     */
    private function preparePageWhereSql( array $params ): string {

        $whereSql = ' WHERE `is_delete` = 0 ';

        // 模版状态查询
        if ( isset( $params['status'] ) ) {
            $whereSql .= " AND `status` = %d";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['status'] );
        }
        // 模版名称模糊查询
        if ( isset( $params['name'] ) ) {
            $whereSql .= " AND `name` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['name'] . '%' );
        }

        return $whereSql;
    }

}