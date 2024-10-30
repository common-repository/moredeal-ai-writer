<?php

namespace MoredealAiWriter\application\models;

defined( '\ABSPATH' ) || exit;

use Exception;
use wpdb;

/**
 * 封装基本的 数据库操作，包括增删改查，表的创建和删除等
 *
 * @author MoredealAiWriter
 */
abstract class Model {

    /**
     * 新增操作
     */
    const INSERT = 1;

    /**
     * 复制操作
     */
    const COPY = 2;

    /**
     * 修改操作
     */
    const MODIFY = 3;


    /**
     * WP DB 对象, 用于操作数据库
     */
    public static $db;

    /**
     * 表名称前缀
     */
    private static $table_prefix = "wp_moredeal_aigc_";

    /**
     * 数据库表名
     *
     * @return string 表名
     */
    public abstract function table_name(): string;

    /**
     * 生成表的 SQL 语句
     *
     * @return string 建表 SQL 语句
     */
    public abstract function dump_sql(): string;

    /**
     * 获取模型
     *
     */
    public static function model() {
        return new static();
    }

    /**
     * 获取表名称前缀
     *
     * @return string 表名称前缀
     */
    protected function table_prefix(): string {
        return self::$table_prefix;
    }

    /**
     * 获取 wp 数据库操作对象
     *
     * @return wpdb 数据库操作对象
     */
    public function get_db(): wpdb {
        if ( ! self::$db ) {
            global $wpdb;
            self::$db = $wpdb;
        }

        return self::$db;
    }

    /**
     * 根据 ID 查询数据
     *
     * @param int $id ID
     * @param array $columns 查询的字段
     *
     * @return array|null 查询到的数据，或出错时为 null.
     */
    public function findById( int $id, array $columns ) {
        $sql = 'SELECT ' . $this->parseFindColumns( $columns ) . ' FROM ' . $this->table_name() . ' WHERE id = %d';

        return $this->get_db()->get_row( $this->get_db()->prepare( $sql, $id ), ARRAY_A );
    }

    /**
     * 查询条件下的记录是否存在
     *
     * @param array $params
     *
     * @return bool
     */
    public function exists( array $params ) {
        try {
            $columns = [ "id" ];

            $model = $this->get_db()->get_row( $this->prepareFindSql( $columns, $params ), ARRAY_A );
            if ( ! empty( $model ) ) {
                return true;
            }

        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return null;
        }

        return false;
    }

    /**
     * 查询条件下的一条记录
     *
     * @param array $params
     * @param array $columns
     *
     * @return array|null 查询到的数据，或出错时为 false.
     */
    public function findOne( array $params, array $columns ) {
        try {
            return $this->get_db()->get_row( $this->prepareFindSql( $columns, $params ), ARRAY_A );
        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return null;
        }
    }

    /**
     * 查询条件下的所有记录
     *
     * @param array $params
     * @param array $columns
     *
     * @return array|null 查询到的数据，或出错时为 false.
     */
    public function findList( array $params, array $columns ) {
        try {
            return $this->get_db()->get_results( $this->prepareFindSql( $columns, $params ), ARRAY_A );
        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return null;
        }
    }

    /**
     * @param $where
     *
     * @return int|false 查询到的行数，或出错时为 false.
     */
    public function count( $where = null ) {
        $sql = "SELECT COUNT(*) FROM " . $this->table_name();
        if ( $where ) {
            try {
                $sql .= $this->prepareWhere( $where );
            } catch ( Exception $e ) {
                error_log( $e->getMessage() );

                return false;
            }
        }

        return $this->get_db()->get_var( $sql );
    }

    /**
     * 新增一条数据
     *
     * @param array $item 数据
     *
     * @return int|false 插入更新的行数，或出错时为 false.
     */
    public function insert( array $item ) {
        return $this->get_db()->insert( $this->table_name(), $item );
    }

    /**
     * 根据 ID 更新
     *
     * @param array $item
     *
     * @return int|bool 更新的行数，或出错时为 false.
     */
    public function updateById( array $item ) {
        return $this->get_db()->update( $this->table_name(), $item, array( 'id' => $item['id'] ) );
    }

    /**
     * 更新部分字段
     *
     * @param array $item
     *
     * @return bool|int
     */
    public function updateField( array $item, $where ) {
        try {
            $sql = 'UPDATE ' . $this->table_name() . ' SET ' . $this->parseUpdateColumns( $item ) . $this->prepareWhere( $where );

        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return false;
        }

        return $this->get_db()->query( $sql );
    }

    /**
     * 新增或者更新数据, 并且返回新增或者修改 ID
     *
     * @param array $item 数据
     *
     * @return int|bool 更新的行数，或出错时为 false。
     */
    public function saveOrUpdate( array $item ) {
        $item['id'] = (int) $item['id'];
        if ( ! $item['id'] ) {
            $item['id'] = null;
            $this->get_db()->insert( $this->table_name(), $item );

            return $this->get_db()->insert_id;
        } else {
            $this->get_db()->update( $this->table_name(), $item, array( 'id' => $item['id'] ) );

            return $item['id'];
        }
    }

    /**
     * 根据 ID 删除一条数据
     *
     * @param $id
     *
     * @return false|int 删除的行数，或出错时为 false
     */
    public function deleteById( $id ) {
        return $this->get_db()->delete( $this->table_name(), array( 'id' => $id ), array( '%d' ) );
    }

    /**
     * 根据条件删除数据
     *
     * @param $where
     *
     * @return int|bool 删除的行数，或出错时为 false
     */
    public function deleteAll( $where ) {
        try {
            $sql = 'DELETE FROM ' . $this->table_name() . $this->prepareWhere( $where );
        } catch ( Exception $e ) {
            error_log( $e->getMessage() );

            return false;
        }

        return $this->get_db()->query( $sql );
    }

    /**
     *
     * 清理旧数据
     *
     * @param        $days
     * @param bool $optimize
     * @param string $date_field
     *
     * @return void
     */
    public function cleanOld( $days, bool $optimize = true, string $date_field = 'create_date' ) {
        $this->deleteAll( 'TIMESTAMPDIFF( DAY, ' . $date_field . ', "' . current_time( 'mysql' ) . '") > ' . $days );
        if ( $optimize ) {
            $this->optimize();
        }
    }

    /**
     * 清空表数据
     *
     * @return void
     */
    public function truncate() {
        $this->get_db()->query( 'TRUNCATE TABLE ' . $this->table_name() );
    }

    /**
     * 优化表数据
     *
     * @return void
     */
    public function optimize() {
        $this->get_db()->query( 'OPTIMIZE TABLE ' . $this->table_name() );
    }

    /**
     * 判断表是否存在
     *
     * @return bool
     */
    public function isTableExists() {
        $query = $this->get_db()->prepare( 'SHOW TABLES LIKE %s', $this->get_db()->esc_like( $this->table_name() ) );

        if ( $this->get_db()->get_var( $query ) == $this->table_name() ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 创建表
     * @return void
     */
    public function createTable() {
        $this->get_db()->query( $this->dump_sql() );
    }

    /**
     * 批量新增数据
     *
     * @param array $items 数据
     * @param int $limit 每次新增数量
     *
     * @return void
     */
    public function insertBath( array $items, int $limit = 200 ) {
        $fields      = array_keys( reset( $items ) );
        $sql         = 'INSERT INTO ' . $this->table_name() . ' (' . join( ',', $fields ) . ') VALUES ';
        $placeholder = str_repeat( '%s, ', count( $fields ) );
        $placeholder = '(' . rtrim( $placeholder, " ," ) . ')';

        $request_count = ceil( count( $items ) / $limit );
        for ( $i = 0; $i < $request_count; $i ++ ) {
            $query = $sql;
            for ( $j = $i * $limit; $j < $i * $limit + $limit; $j ++ ) {
                if ( ! isset( $items[ $j ] ) ) {
                    break;
                }
                $query .= $this->get_db()->prepare( $placeholder, $items[ $j ] ) . ', ';
            }
            $query = rtrim( $query, " ," ) . ';';
            $this->get_db()->query( $query );
        }
    }

    /**
     * 查询 SQL 组装
     *
     * @param array $columns 需要查询的列
     * @param array $params 参数
     *
     * @return string
     * @throws Exception
     */
    private function prepareFindSql( array $columns, array $params ): string {
        $sql = 'SELECT ' . $this->parseFindColumns( $columns ) . ' FROM ' . $this->table_name();
        if ( $params ) {
            $values = array();
            if ( ! empty( $params['where'] ) ) {
                $sql .= $this->prepareWhere( $params['where'] );
            }
            if ( ! empty( $params['group'] ) ) {
                $sql .= ' GROUP BY ' . $params['group'];
            }
            if ( ! empty( $params['order'] ) ) {
                $sql .= ' ORDER BY ' . $params['order'];
            }

            if ( ! empty( $params['desc'] ) ) {
                $sql .= ' DESC ';
            }

            if ( ! empty( $params['limit'] ) ) {
                $sql      .= ' LIMIT %d';
                $values[] = $params['limit'];
            }
            if ( ! empty( $params['offset'] ) ) {
                $sql      .= ' OFFSET %d';
                $values[] = $params['offset'];
            }

            if ( $values ) {
                $sql = $this->get_db()->prepare( $sql, $values );
            }
        }

        return $sql;
    }

    /**
     * 准备 Where 语句
     *
     * @param      $where
     * @param bool $include
     *
     * @return string|null
     * @throws Exception
     */
    public function prepareWhere( $where, bool $include = true ) {
        if ( $include ) {
            $sql = ' WHERE ';
        } else {
            $sql = '';
        }
        $values = array();

        if ( is_array( $where ) && isset( $where[0] ) && isset( $where[1] ) ) {
            $sql    .= $where[0];
            $values += $where[1];
        } elseif ( is_string( $where ) ) {
            $sql .= $where;
        } else {
            throw new Exception( 'Wrong WHERE params.' );
        }
        if ( $values ) {
            $sql = $this->get_db()->prepare( $sql, $values );
        }

        return $sql;
    }

    /**
     * 处理查询字段
     *
     * @param array $columns
     *
     * @return string
     */
    private function parseFindColumns( array $columns ): string {
        if ( empty( $columns ) ) {
            return '*';
        }

        return join( ", ", $columns );
    }

    /**
     * 处理update set字段
     *
     * @param array $item
     *
     * @return string
     */
    private function parseUpdateColumns( array $item ): string {

        $fields = array();
        foreach ( $item as $field => $value ) {
            if ( is_null( $value ) ) {
                $fields[] = "`$field` = NULL";
                continue;
            }

            $fields[] = "`$field` = " . '"' . $value . '"';
        }

        return implode( ', ', $fields );
    }
}
