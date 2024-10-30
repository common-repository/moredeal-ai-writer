<?php

namespace MoredealAiWriter\application\models;

use Exception;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;

defined( '\ABSPATH' ) || exit;

class UseLimitModel extends Model {

    /**
     * 默认分页大小
     * @var array
     */
    const PAGE_DEFAULT_PARAMS = array( 'limit' => 100, 'current' => 1 );

    /**
     * 实例
     * @var UseLimitModel|null
     */
    private static $instance = null;

    public $id;

    public $name;

    /**
     * 用户限制范围
     * @var
     */
    public $scope;

    /**
     * 限制类型 0：token 1：step
     * @var
     */
    public $type;

    /**
     * 限制大小
     * @var
     */
    public $limits;

    /**
     * 限制有效时长
     * @var
     */
    public $time;

    /**
     * 提示语
     * @var
     */
    public $tips;

    /**
     * 指定范围
     * @var
     */
    public $specify_users;

    /**
     * 忽略范围
     * @var
     */
    public $ignore_users;

    /**
     * 时间
     * @var
     */
    public $date_time;

    /**
     * 创建时间
     * @var
     */
    public $gmt_create;

    /**
     * 更新时间
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

    public static function getInstance(): UseLimitModel {

        self::$instance = new self();

        return self::$instance;
    }

    /**
     * 获取默认配置
     *
     * @param $scope
     *
     * @return UseLimitModel
     */
    public static function getDefaultInstance( $scope ): UseLimitModel {
        $model               = new UseLimitModel();
        $model->id           = 1;
        $model->name         = 'Default limits';
        $model->scope        = $scope;
        $model->type         = 'Token';
        $model->limits       = '5000';
        $model->time         = 'Day';
        $model->tips         = 'You have reached the limit.';
        $model->gmt_create   = current_time( 'mysql' );
        $model->gmt_modified = current_time( 'mysql' );
        $model->date_time    = current_time( 'Y-m-d' );
        $model->is_delete    = 0;

        return $model;
    }

    /**
     * 数据库表名
     *
     * @return string 表名
     */
    public function table_name(): string {
        return $this->table_prefix() . "uselimit";
    }

    /**
     * 生成表的 SQL 语句
     *
     * @return string 建表 SQL 语句
     */
    public function dump_sql(): string {
        return "CREATE TABLE " . $this->table_name() . "
        (
          `id` int NOT NULL AUTO_INCREMENT,
          `name` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `scope` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '限制范围',
          `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '限制类型',
          `time` varchar(64) COLLATE utf8mb4_general_ci NOT NULL COMMENT '限制时间',
          `limits` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '限制数',
          `tips` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '限制提示',
          `specify_users` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '指定限制范围',
          `ignore_users` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '忽略限制范围',
          `date_time` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
          `gmt_create` datetime NOT NULL,
          `gmt_modified` datetime NOT NULL,
          `is_delete` int NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
		";

    }

    const INCLUDE_COLUMNS_ARRAY = [
        "id",
        "name",
        "scope",
        "type",
        "time",
        "limits",
        "tips",
        "specify_users",
        "ignore_users",
        "date_time"
    ];

    /**
     * 新增限制
     *
     * @param UseLimitModel $model
     *
     * @return false|int 插入成功返回自增主键 ID，或出错时为 false
     */
    public function createTemplate( UseLimitModel $model ) {
        $insert = $this->insert( (array) $model );
        if ( ! $insert ) {
            return false;
        }

        return $this->get_db()->insert_id;
    }

    /**
     * 入参解析与校验
     *
     * @param $params
     * @param int $option_type
     *
     * @return UseLimitModel
     * @throws Exception
     */
    public static function parseAndVerify( $params, int $option_type ): UseLimitModel {
        if ( $option_type > 4 || $option_type < 1 ) {
            throw new Exception( "The option type is not support" );
        }

        $params = json_decode( $params );

        if ( $option_type == self::MODIFY ) {
            if ( ! isset( $params->id ) ) {
                throw new Exception( 'The ID is required' );
            }
        }

        if ( ! isset( $params->name ) ) {
            throw new Exception( 'The name is required' );
        }

        if ( ! isset( $params->scope ) ) {
            throw new Exception( 'The scope is required' );
        }

        if ( ! isset( $params->type ) ) {
            throw new Exception( 'The type is required' );
        }

        if ( ! isset( $params->time ) ) {
            throw new Exception( 'The time is required' );
        }

        if ( ! isset( $params->limits ) ) {
            throw new Exception( 'The limits is required' );
        }

        // 默认忽略创建者
        $current_user = wp_get_current_user();
        if ( empty( $params->ignore_users ) ) {
            $params->ignore_users = [ $current_user->ID ];
        }

        $model = new self();
        $model = ModuleConvertUtil::convert( $model, $params );

        if ( self::INSERT == $option_type ) {
            if ( isset( $model->id ) || property_exists( $model, 'id' ) ) {
                unset( $model->id );
            }

//            $list = UseLimitModel::getInstance()->findListByScope( $model->scope );
//            if ( ! empty( $list ) ) {
//                throw new Exception( 'There is only one configured for ' . $model->scope );
//            }

//            if ( $model->scope == Constant::GUESTS ) {
//                $list = UseLimitModel::getInstance()->findListByScope( $model->scope );
//
//                if ( ! empty( $list ) ) {
//                    throw new Exception( 'There is only one configured for Guests.' );
//                }
//            }

            // 创建时间
            $model->gmt_create = current_time( 'mysql' );
            $model->date_time  = current_time( 'Y-m-d' );
        }

        // 是否删除
        $model->is_delete = 0;

        // 修改时间
        $model->gmt_modified = current_time( 'mysql' );

        if ( ! empty( $model->specify_users ) && is_array( $model->specify_users ) ) {
            $model->specify_users = implode( ',', $model->specify_users );
        }

        if ( ! empty( $params->ignore_users ) && is_array( $model->ignore_users ) ) {
            $model->ignore_users = implode( ',', $model->ignore_users );
        }

        return $model;

    }

    /**
     * 根据 ID 获取使用限制详情
     *
     * @param int $id 记录 ID
     *
     * @return UseLimitModel|null
     * @throws Exception
     */
    public function uselimitDetail( int $id ): UseLimitModel {

        $sql    = "SELECT `id`, `name`,`scope`, `type`, `time`, `limits`, `tips`, `specify_users`, `ignore_users`, `date_time`, `gmt_create`, `gmt_modified`, `is_delete` FROM " . $this->table_name() . " WHERE `id` = %d";
        $detail = $this->get_db()->get_row( $this->get_db()->prepare( $sql, $id ) );
        // 详情为空事后直接返回 空数组, 避免后续报错
        if ( $detail == null ) {
            return new UseLimitModel();
        }

        return self::convert( $detail );
    }

    /**
     * 将数组或者对象转为该模型
     *
     * @param $data
     *
     * @return UseLimitModel
     */
    public static function convert( $data ): UseLimitModel {
        $model = new self();
        $model = ModuleConvertUtil::convert( $model, $data );

        if ( ! empty( $model->specify_users ) ) {
            $arr                  = explode( ',', $model->specify_users );
            $arr                  = array_map( 'intval', $arr );
            $model->specify_users = $arr;

        }

        if ( ! empty( $model->ignore_users ) ) {

            $arr = explode( ',', $model->ignore_users );
            $arr = array_map( 'intval', $arr );

            $model->ignore_users = $arr;

        }

        return $model;

    }

    /**
     *
     * 根据限制范围查找限制列表
     *
     * @param $scope
     *
     * @return array
     */
    public function findListByScope( $scope ): array {
        $params = [
            "where" => "scope=" . "'" . $scope . "'"
        ];

        $list = $this->findList( $params, self::INCLUDE_COLUMNS_ARRAY );

        if ( count( $list ) > 0 ) {
            foreach ( $list as $index => $item ) {
                $uselimit       = self::convert( $item );
                $list[ $index ] = $uselimit;
            }
        }

        return $list;
    }

    /**
     * 分页默认参数
     *
     * @return array
     */
    public static function page_default_params(): array {
        return self::PAGE_DEFAULT_PARAMS;
    }

    public function page( $params ): array {
        $default_params = UseLimitModel::page_default_params();

        // 分页数据处理
        if ( empty( $params['limit'] ) ) {
            $params['limit'] = $default_params['limit'];
        }
        $limit = $params['limit'];

        if ( empty( $params['current'] ) ) {
            $params['current'] = $default_params['current'];
        }
        $current = $params['current'];
        $offset  = ( $current - 1 ) * $limit;

        $pageSql  = 'SELECT `id`, `name`,`scope`, `type`, `time`, `limits`, `tips`, `specify_users`, `ignore_users`, `date_time`, `gmt_create`, `gmt_modified`, `is_delete` FROM ' . $this->table_name();
        $whereSql = $this->preparePageWhereSql( $params );
        $pageSql  = $pageSql . $whereSql . " ORDER BY `gmt_modified` DESC LIMIT %d, %d";

        // 查询列表
        $list = $this->get_db()->get_results( $this->get_db()->prepare( $pageSql, $offset, $limit ) );
        // 查询数据为空时候，返回空数组
        if ( ! is_array( $list ) ) {
            $list = array();
        }

        if ( count( $list ) > 0 ) {
            foreach ( $list as $index => $item ) {
                $uselimit       = self::convert( $item );
                $list[ $index ] = $uselimit;
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
     * 获取 WHERE 查询条件
     *
     * @param array $params
     *
     * @return string
     */
    private function preparePageWhereSql( array $params ): string {
        return ' WHERE `is_delete` = 0 ';
    }


    /**
     * 查询限制用户的所有条件
     *
     * @param $user_id
     *
     * @return array
     */
    public function findUselimitData( $user_id ): array {

        // 查询条件：行数据中「忽略字段不包含」并且 「指定字段为空或者用户未被指定」
        $where = sprintf(
            "scope = '%s' AND ((ISNULL(specify_users) OR specify_users = '') AND NOT find_in_set('%s', ignore_users)) OR find_in_set('%s', specify_users)",
            Constant::USER, $user_id, $user_id
        );

        $params = [
            "where" => $where
        ];


        $list = $this->findList( $params, self::INCLUDE_COLUMNS_ARRAY );

        if ( count( $list ) > 0 ) {
            foreach ( $list as $index => $item ) {
                $uselimit       = self::convert( $item );
                $list[ $index ] = $uselimit;
            }
        }

        return $list;
    }


    /**
     * getTime
     *
     * @return mixed
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * getLimits
     *
     * @return mixed
     */
    public function getLimits() {
        return $this->limits;
    }

    /**
     * 日期转换成具体值
     *
     * @return int
     */
    public function getTimeValue(): int {
        switch ( $this->time ) {
            case Constant::DAY:
                return 1;
            case Constant::WEEK:
                return 7;
            case Constant::MON:
                return 30;
            default:
                return 0;
        }
    }

    /**
     * 获取限制记录开始的时间
     *
     * @return false|string|null
     */
    public function getLimitsStartTime( $time ) {
        $current_time = time();
        $start_time   = null;

        switch ( $time ) {
            case Constant::DAY:
                $start_time = strtotime( 'today', $current_time );
                break;
            case Constant::WEEK:
                $start_time = strtotime( 'monday this week', $current_time );
                break;
            case Constant::MON:
                $start_time = strtotime( date( 'Y-m-01', $current_time ) );
                break;
        }

        return $start_time ? date( 'Y-m-d H:i:s', $start_time ) : null;
    }

    /**
     * 获取距离最后的时间
     *
     * @param $time
     *
     * @return false|string|null
     */
    public function getLastTime( $time ) {
        $current_time = time();
        $last_time    = null;

        switch ( $time ) {
            case Constant::DAY:
                $last_time = strtotime( date( 'Y-m-d 23:59:59', $current_time ) );
                break;
            case Constant::WEEK:
                $last_time = strtotime( 'sunday this week 23:59:59', $current_time );
                break;
            case Constant::MON:
                $last_time = strtotime( date( 'Y-m-t 00:00:00', $current_time ) );
                break;
        }

        return $last_time ? date( 'Y-m-d H:i:s', $last_time ) : null;
    }

    /**
     * 获取相隔的天数
     *
     * @param $time
     *
     * @return int|string
     */
    public function getLeftTime( $time ) {
        switch ( $time ) {
            case Constant::DAY:
                return 1;
            case Constant::WEEK:
                $weekday = date( 'w' );

                return $weekday == 0 ? 0 : 7 - $weekday;
            case Constant::MON:
                return date( 't', strtotime( 'last day of this month' ) ) - date( 'd' ) + 1;
        }

        return 1;
    }

}