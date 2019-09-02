<?php
/**
 *
 * 部分来之 https://github.com/nette/utils
 */

namespace VlinkedUtils;


class Arrays
{
    /**
     * 获取数组中的key 对应的 values
     * @param array $arr
     * @param string|int|array $key one or more keys
     * @return mixed
     * @throws  \Exception
     */
    public static function get(array $arr, $key, $default = null)
    {
        foreach (is_array($key) ? $key : [$key] as $k) {
            if (is_array($arr) && array_key_exists($k, $arr)) {
                $arr = $arr[$k];
            } else {
                if (func_num_args() < 3) {
                    throw new \Exception("Missing item '$k'.");
                }
                return $default;
            }
        }
        return $arr;
    }

    /**
     * 将数组转成对象
     * @param array $arr
     * @return object
     */
    public static function toObject(array $arr, $obj)
    {
        foreach ($arr as $k => $v) {
            $obj->$k = $v;
        }
        return $obj;
    }


    /**
     * 数组转XML 无 version 信息
     * @param array $data 字典
     * @return string xml 字符串
     */
    public static function toXml($data)
    {
        $xml = '';
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($val) || is_object($val)) ? self::toXml($val) : $val;
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }
}