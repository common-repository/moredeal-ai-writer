<?php

namespace MoredealAiWriter\application\helpers;

defined( '\ABSPATH' ) || exit;

/**
 * 日期时间处理类
 *
 * @author MoredealAiWriter
 */
class DateHelper {

    /**
     * 将过期时间转换为剩余时间
     *
     * @param $expireTime
     *
     * @return string
     */
    public static function formatExpireTimeToTimeLeft( $expireTime ): string {
        $future_date  = strtotime( $expireTime );
        $current_date = time();
        $time_left    = $future_date - $current_date;

        $days = floor( $time_left / ( 60 * 60 * 24 ) ); // 计算剩余天数
        // $hours = floor( ( $time_left - ( $days * 60 * 60 * 24 ) ) / ( 60 * 60 ) ); // 计算剩余小时数
        // $minutes = floor( ( $time_left - ( $days * 60 * 60 * 24 ) - ( $hours * 60 * 60 ) ) / 60 ); // 计算剩余分钟数
        // $seconds = floor( $time_left - ( $days * 60 * 60 * 24 ) - ( $hours * 60 * 60 ) - ( $minutes * 60 ) ); // 计算剩余秒数
        // 'Time remaining: ' .
        return $days . " day " /*. $hours . " hours " . $minutes . " minutes " . $seconds . " seconds"*/ ;
    }

}