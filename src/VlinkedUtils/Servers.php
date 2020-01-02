<?php


namespace VlinkedUtils;


/**
 * $_SERVER 相关处理
 * Class Servers
 * @package VlinkedUtils
 */
class Servers
{


    public static function getUsersAgent()
    {
        return self::getENV("HTTP_USER_AGENT");
    }

    public static function getENV($key)
    {
        if (isset($_SERVER)) {
            $val = isset($_SERVER[$key]) ? $_SERVER[$key] : "";
        } else {
            $val = getenv($key) ? getenv($key) : "";
        }
        return $val;
    }

    public static function getClientIP()
    {
        //判断服务器是否允许$_SERVER
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            //不允许就使用getenv获取
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        $arr_ip = explode(',', $realip);
        $realip = trim($arr_ip[count($arr_ip) - 1]);
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        return !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    }


}