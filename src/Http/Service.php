<?php


namespace VlinkedUtils\Http;


class Service
{
    /**
     * 服务器端响应 json 返回
     * @param array $arr
     * @param bool $exit 是否在输出后结束响应
     * @return string
     * @throws \Exception
     */
    public static function responseJson(array $arr, $exit = true)
    {
        header("Content-Type: application/json");
        if (!is_array($arr)) {
            throw  new \Exception("arr 必须传入 数组类型");
        }
        $json_str = json_encode($arr, JSON_UNESCAPED_UNICODE);
        if ($exit) {
            ob_clean();
            echo $json_str;
            exit();
        } else {
            return $json_str;
        }
    }




}