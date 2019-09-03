<?php


namespace VlinkedUtils;


/**
 * 与时间和日期相关的工具函数
 * Class Date
 * @package VlinkedUtils
 */
class Date
{
    const DATE_FMT_MYSQL_DATETIME = "Y-m-d H:i:s";
    const DATE_FMT_ONLY_YMD = "Ymd";
    const DATE_FMT_NO_SPACE = "YmdHis";


    /**
     * 获取日期以及日期格式话函数
     * @throws InvalidArgumentTypeException
     * @param $fmt
     * @param bool|string $now
     * @return string

     */
    public static function formatDate($fmt = Date::DATE_FMT_MYSQL_DATETIME, $now = true)
    {
        date_default_timezone_set('PRC');
        if (is_bool($now) && $now === true) {
            $time = time();
        } else {
            $time = strtotime($now);
            if ($time === false) {
                throw new InvalidArgumentTypeException("strtotime error timestr:[{$now}]" );
            }
        }
        return date($fmt, $time);

    }

    /**
     * 获得当前时间MYSQL数据库的时间戳
     * @return string
     */
    public static function getNowDateTimeMysql()
    {
        return self::formatDate(self::DATE_FMT_MYSQL_DATETIME);
    }

    /**
     * 生成与时间相关的订单号
     * @param string $perfix 前缀
     * @param string $interpolatory 最后插值
     * @return string
     */
    public static function genOrderId($perfix = "", $interpolatory = "")
    {
        return $perfix . self::formatDate(DATE::DATE_FMT_NO_SPACE) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT) . $interpolatory;
    }
}
