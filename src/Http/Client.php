<?php


namespace VlinkedUtils\Http;


class Client
{

    /**
     * 发起一个curl 的get 请求
     * @param string $url 接口地址 不带 ？
     * @param string $getParam 数据参数
     * @param int $timeout 请求超时时间
     * @return bool|string
     * @throws HttpCurlException
     */
    public static function curlGet($url = '', $getParam = '', $timeout = 10)
    {
        if (is_array($getParam)) {
            $getParam = http_build_query($getParam);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $getParam);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回文件流而不是输出
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new HttpCurlException($ch);
        }
        curl_close($ch);
        return $data;
    }

    /**
     * @param string $url 地址
     * @param string $postData 请求的数据
     * @param array $options 设置
     * @param int $timeout 设置cURL允许执行的最长秒数
     * @return bool|string
     * @throws HttpCurlException
     */
    public static function curlPost($url = '', $postData = '', $options = array(), $timeout = 20)
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new HttpCurlException($ch);
        }
        curl_close($ch);
        return $data;
    }

    // 下载图片





}