<?php
/**
 *
 * 部分来之 https://github.com/nette/utils
 */

namespace VlinkedUtils;

class Arrays
{
    /**获取数组中的key 对应的 values 可以设置初始值
     * @param array $arr
     * @param $key
     * @param null $default
     * @return array|mixed|null
     * @throws InvalidArgumentTypeException
     */
    public static function get(array $arr, $key, $default = null)
    {
        foreach (is_array($key) ? $key : [$key] as $k) {
            if (is_array($arr) && array_key_exists($k, $arr)) {
                $arr = $arr[$k];
            } else {
                if (func_num_args() < 3) {
                    throw new InvalidArgumentTypeException("Missing item '$k'.");
                }
                return $default;
            }
        }
        return $arr;
    }

    /**
     * 将数组转成对象
     * @param array $arr
     * @param object $obj
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
     * @throws InvalidArgumentTypeException
     */
    public static function toXml(array $data)
    {
        $xml = '';
        if (!is_array($data)) {
            throw new InvalidArgumentTypeException(" Argument need array type");
        }
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml .= "<$key>";
            $xml .= (is_array($val) || is_object($val)) ? self::toXml($val) : $val;
            list($key,) = explode(' ', $key);
            $xml .= "</$key>";
        }
        return $xml;
    }

    /**
     * 数组转XML 无 version 信息 toXmlCDATA
     * @param array $data 字典
     * @return string xml 字符串
     * @throws InvalidArgumentTypeException
     */
    public static function toXmlCDATA(array $data)
    {
        $xml = '';
        if (!is_array($data)) {
            throw new InvalidArgumentTypeException(" Argument need array type");
        }
        foreach ($data as $key => $val) {
            $xml .= "<$key>";
            if (is_array($val) || is_object($val)) {
                $xml .= self::toXmlCDATA($val);
            } else {
                if (is_numeric($val)) {
                    $xml .= $val;
                } else {
                    $xml .= "<![CDATA[{$val}]]>";
                }
            }
            $xml .= "</$key>";
        }
        return $xml;
    }

    /**
     * 子元素计数器
     * @param array $array
     * @param int $pid
     * @return array
     */
    public static function countChildren($array, $pid)
    {
        $counter = [];
        foreach ($array as $item) {
            $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
            $count++;
            $counter[$item[$pid]] = $count;
        }
        return $counter;
    }

    /**
     * 数组层级缩进转换
     * @param array $array 源数组
     * @param int $pid
     * @param int $level
     * @return array
     */
    public static function arrayToLevel($array, $pid = 0, $level = 1)
    {
        static $list = [];
        foreach ($array as $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $list[] = $v;
                array2level($array, $v['id'], $level + 1);
            }
        }
        return $list;
    }
}