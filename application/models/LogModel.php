<?php

namespace MoredealAiWriter\application\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use MoredealAiWriter\application\consts\Constant;
use MoredealAiWriter\code\extend\LogExtend\LogExtend;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\scene\SceneManager;
use MoredealAiWriter\code\modules\util\ModuleConvertUtil;
use mysqli_result;

/**
 * LogModel class file
 *
 * @author MoredealAiWriter
 */
class LogModel extends Model {

    public $id;

    /**
     * ip地址
     */
    public $ip_address;

    /**
     * session_id
     */
    public $session_id;

    /**
     * 用户类型：登录用户，游客
     * @var
     */
    public $user_type;

    /**
     * 用户唯一标识
     * @var
     */
    public $user_id;

    /**
     * 用户名
     * @var
     */
    public $user_name;
    /**
     * 模块type
     * @var string
     */
    public $model_type;
    /**
     * 算法模型
     * @var
     */
    public $model;
    /**
     * 模版id
     * @var
     */
    public $template_id;

    /**
     * 模版名
     * @var
     */
    public $template_name;
    /**
     * 模版key
     * @var
     */
    public $template_key;
    /**
     * 使用场景
     * @var string
     */
    public $scene;
    /**
     * 步骤key
     * @var
     */
    public $step_key;
    /**
     * 实例id
     * @var
     */
    public $instance_id;
    /**
     * 单价
     * @var
     */
    public $price;
    /**
     * 总价
     * @var
     */
    public $total_price;
    /**
     * token标记 0：用户端 1：服务端
     * @var string
     */
    public $token_mark;
    /**
     * api 模型
     */
    public $api;
    /**
     * token使用量
     * @var int
     */
    public $token_usage;
    /**
     * 请求时间
     * @var
     */
    public $start_time;
    /**
     * 响应时间
     * @var
     */
    public $end_time;

    /**
     * 操作耗时
     * @var
     */
    public $diff_time;

    /**
     * 请求参数
     * @var string
     */
    public $request;
    /**
     * 响应参数
     * @var string
     */
    public $response;
    /**
     * 响应是否成功
     * @var bool
     */
    public $success = false;

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

    private static $instance = null;


    public function __construct() {
    }

    public static function getInstance(): LogModel {

        self::$instance = new static();

        return self::$instance;
    }

    public function table_name(): string {
        return $this->table_prefix() . "log";
    }

    public function dump_sql(): string {
        return "CREATE TABLE " . $this->table_name() . "
            (
              `id` bigint NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
              `session_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
              `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
              `user_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
              `user_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
              `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
              `scene` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '场景',
              `template_id` bigint DEFAULT NULL,
              `template_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
              `template_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
              `instance_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
              `step_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
              `api` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
              `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '算法模型',
              `price` decimal(10,6) DEFAULT NULL,
              `total_price` decimal(10,6) DEFAULT NULL,
              `token_usage` bigint DEFAULT NULL COMMENT 'token使用量',
              `token_mark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'token标记 0：用户端 1：服务端',
              `start_time` datetime NOT NULL COMMENT '请求时间',
              `end_time` datetime NOT NULL COMMENT '响应时间',
              `diff_time` bigint DEFAULT NULL,
              `request` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '请求参数',
              `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '响应参数',
              `success` tinyint NOT NULL COMMENT '是否成功',
              `gmt_create` datetime DEFAULT NULL COMMENT '创建时间',
              `gmt_modified` datetime DEFAULT NULL COMMENT '更新时间',
              `is_delete` tinyint DEFAULT NULL COMMENT '是否删除： 0：正常，1：已删除',
              PRIMARY KEY (`id`),
              KEY `idx_user_name` (`user_name`),
              KEY `idx_time` (`start_time`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
    }

    const GENERIC_QUERY_FIELD = "`id`, `session_id`, `ip_address`, `user_id`, `user_type`, `user_name`, `model_type`, `scene`, `template_key`, `template_name`, `instance_id`, `template_id`, `step_key`, `model`, `api`, `price`, `request`, `response`, `total_price`, `token_usage`, `start_time`, `diff_time`, `success`";

    /**
     * 分页获取模版列表
     *
     * @param array $params
     *
     * @return array
     */
    public function page( array $params ): array {
        $limit   = $params['limit'];
        $current = $params['current'];
        $offset  = ( $current - 1 ) * $limit;

        $pageSql  = 'SELECT ' . self::GENERIC_QUERY_FIELD . ' FROM ' . $this->table_name();
        $whereSql = $this->preparePageWhereSql( $params );

        $orderSql = '';
        if ( ! empty( $params['order'] ) ) {
            $orderSql .= ' ORDER BY ' . $params['order'];
        } else {
            $orderSql .= ' ORDER BY `start_time` DESC';
        }

        if ( ! empty( $params['desc'] ) ) {
            $orderSql .= ' DESC ';
        }

        $pageSql = $pageSql . $whereSql . $orderSql . " LIMIT %d, %d";

        // 查询列表
        $list = $this->get_db()->get_results( $this->get_db()->prepare( $pageSql, $offset, $limit ) );

        // 查询数据为空时候，返回空数组
        if ( ! is_array( $list ) ) {
            $list = array();
        }

        if ( count( $list ) > 0 ) {
            // 查询总数
            $total = $this->get_db()->get_var( 'SELECT COUNT(*) FROM ' . $this->table_name() . $whereSql );

            foreach ( $list as $index => $log ) {
                $log_object = get_object_vars( $log );

                // 使用user统一
                if ( empty( $log_object['user_name'] ) ) {
                    $log_object['user'] = $log_object['session_id'];
                } else {
                    $log_object['user'] = $log_object['user_name'];
                }

                // 处理请求值
                $request = $log_object['request'];
                $content = '';
                if ( ! empty( $request ) ) {
                    $data = json_decode( $request, true );

                    if ( ! empty( $data['messages'][0]['content'] ) ) {
                        $content = $data['messages'][0]['content'];
                    } else {
                        $content = $request;
                    }

                }
                $log_object['request'] = $content;

                // 处理返回值
                $response = $log_object['response'];
                $result   = array();
                if ( ! empty( $response ) ) {
                    $data = json_decode( $response, true );

                    if ( ! empty( $data['choices'] ) && is_array( $data['choices'] ) ) {
                        foreach ( $data['choices'] as $choice ) {
                            if ( isset( $choice['message'] ) ) {
                                $content  = trim( $choice['message']['content'] );
                                $result[] = $content;
                            }
                        }
                    } else {
                        $result[] = $response;
                    }
                }

                $log_object['response'] = $result;

                unset( $log_object['id'] );
                unset( $log_object['user_id'] );
                unset( $log_object['model_type'] );
                unset( $log_object['template_key'] );
                unset( $log_object['instance_id'] );
                unset( $log_object['step_key'] );
                unset( $log_object['model'] );
                unset( $log_object['api'] );
                unset( $log_object['price'] );

                if ( $log_object['success'] == 1 ) {
                    $log_object['success'] = true;
                } else {
                    $log_object['success'] = false;
                }

                $list[ $index ] = $log_object;
            }

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

        $whereSql = ' WHERE `is_delete` = 0 ';

        if ( isset( $params['user_name'] ) ) {
            $whereSql .= " AND `user_name` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['user_name'] . '%' );

            $whereSql .= " OR `session_id` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, '%' . $params['user_name'] . '%' );
        }

        if ( isset( $params['template_name'] ) ) {
            $whereSql .= " AND `template_name` LIKE %s";
            $whereSql = $this->get_db()->prepare( $whereSql, '%' . $params['template_name'] . '%' );
        }

        if ( isset( $params['start_time'] ) && is_array( $params['start_time'] ) ) {
            $whereSql .= " AND `start_time` > %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['start_time'][0] );

            $whereSql .= " AND `start_time` < %s";
            $whereSql = $this->get_db()->prepare( $whereSql, $params['start_time'][1] );

        }


        return $whereSql;
    }

    /**
     * 将数组或者对象转为该模型
     *
     * @param      $data object
     * @param bool $is_parse_info
     *
     * @return LogModel
     */
    public static function convert( $data, bool $is_parse_info = true ): LogModel {
        $model = new self();
        $model = ModuleConvertUtil::convert( $model, $data );
        $info  = $model->info;
        if ( is_string( $info ) ) {
            $info = json_decode( $info );
        }
        if ( is_array( $info ) ) {
            $info = (object) $info;
        }
        if ( $is_parse_info ) {
            try {
                $info = LogExtend::factoryObject( $model->type, $info );
            } catch ( Exception $e ) {
                $info = $model->info;
            }
        }
        $model->info = $info;

        return $model;
    }

    /**
     * 获取时间范围内这个用户消耗的总token量
     *
     * @param $user_id
     * @param $start_time
     * @param $end_time
     *
     * @return integer
     */
    public function getTokenUsageByUserIdAndTimeRange( $user_id, $start_time, $end_time ): int {

        $sql = "SELECT IFNULL(SUM(wp_moredeal_aigc_log.token_usage), 0) as token_usage FROM "
               . $this->table_name()
               . sprintf( " WHERE user_id = '%s' AND start_time > '%s' AND start_time < '%s' ", $user_id, $start_time, $end_time );

        return $this->get_db()->get_var( $sql );
    }

    /**
     * @param AbstractContextModule $context
     * @param $message
     *
     * @return void
     * @throws Exception
     */
    public function addErrorLog( AbstractContextModule $context, $message ) {

        $logModel = LogModel::getInstance();
        // ip地址
        $ip_address           = $_SERVER['REMOTE_ADDR'];
        $logModel->ip_address = $ip_address;

        if ( ! session_id() ) {
            session_start();
        }

        $session              = session_id();
        $logModel->session_id = $session;

        $user_id   = wp_get_current_user()->ID;
        $user_name = wp_get_current_user()->user_login;

        if ( $user_id == 0 || empty( $user_name ) ) {
            $logModel->user_id   = $session;
            $logModel->user_type = Constant::GUESTS;
        } else {
            $logModel->user_id   = $user_id;
            $logModel->user_type = Constant::USER;
        }

        $logModel->user_name = $user_name;

        $scene_key = $context->get_scene_key();
        $scene     = SceneManager::factoryScene( $scene_key );

        $logModel->scene         = $scene->name;
        $logModel->template_name = $context->getTemplate()->name;
        $logModel->template_key  = $context->getTemplate()->key;
        $logModel->instance_id   = $context->getInstanceId();
        $logModel->template_id   = $context->getTemplate()->id;
        $logModel->step_key      = $context->getStepField();

        $logModel->request  = $context->getStepVariable( "prompt" );
        $logModel->response = $message;

        $logModel->success = false;

        $logModel->token_usage = 0;
        $logModel->diff_time   = 0;

        $logModel->start_time   = date( 'Y-m-d H:i:s' );
        $logModel->end_time     = date( 'Y-m-d H:i:s' );
        $logModel->gmt_create   = date( 'Y-m-d H:i:s' );
        $logModel->gmt_modified = date( 'Y-m-d H:i:s' );
        $logModel->is_delete    = 0;

        $this->arrayToSqlInsert( get_object_vars( $logModel ) );

        error_log( "error log inset" );
    }

    /**
     * 插入日志
     *
     * @param $data
     *
     * @return bool|int|mysqli_result|resource|null
     */
    function arrayToSqlInsert( $data ) {

        $tableName = $this->table_name();

        $keys   = array_map( 'addslashes', array_keys( $data ) );
        $values = array_map( function ( $value ) {
            if ( $value === null ) {
                return 'NULL';
            } else if ( is_numeric( $value ) ) {
                return $value;
            } else if ( is_bool( $value ) ) {
                return $value ? '1' : '0';
            } else {
                return "'" . addslashes( $value ) . "'";
            }
        }, array_values( $data ) );

        $sql = "INSERT INTO $tableName (`" . implode( '`, `', $keys ) . "`) VALUES (" . implode( ', ', $values ) . ")";

        return $this->get_db()->query( $sql );
    }


}
