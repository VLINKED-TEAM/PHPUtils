<?php


namespace VlinkedUtils\Http;


use http\Exception\RuntimeException;
use VlinkedUtils\AssertionException;
use VlinkedUtils\Http\callback\OnResponse;
use VlinkedUtils\Json;
use VlinkedUtils\JsonException;

class VlinkedApiClient
{


    private $appid;

    private $appkey;


    /**
     * RequestApiHandler constructor.
     * @param $appid string appid
     * @param $appkey string appkey
     */
    public function __construct($appid, $appkey)
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
    }


    /**
     * 一个get请求
     * @param $apiPath
     * @param $param
     * @param bool $needSign
     * @return mixed
     * @throws \RuntimeException
     * @throws HttpCurlException
     */
    public function doGet($apiPath, $param, $needSign = true)
    {

        return $responseArr = $this->doRequest($apiPath, $param, $needSign, 'get');

    }

    /**
     * 一个post请求
     * @param $apiPath
     * @param $param
     * @param bool $needSign
     * @return mixed
     * @throws \RuntimeException
     * @throws HttpCurlException
     */
    public function doPost($apiPath, $param, $needSign = true)
    {

        return $responseArr = $this->doRequest($apiPath, $param, $needSign, 'post');

    }


    /**
     * @param $apiPath string
     * @param $param array
     * @param bool $needSign
     * @param string $type
     * @return mixed
     * @throws HttpCurlException
     * @throws \RuntimeException
     */
    private function doRequest($apiPath, $param, $needSign = true, $type = 'get')
    {
        $t = time();
        $sign = "";
        if ($needSign) {
            $sign = $this->calcRequestSign($param, $t);
        }
        /**
         * 请求url以及三个参数
         */
        $finalPath = $apiPath . "?appid=" . $this->appid . "&sign=" . $sign . "&t=" . $t;

        /**
         * 发起请求
         */
        $response = "";
        if ($type === 'get') {
            $finalPath .= "&" . http_build_query($param);
            $response = Client::curlGet($finalPath, null);

        } else {
            $response = Client::curlPost($finalPath, $param);
        }
        print_r($response);
        if (is_null($response)) {
            throw new \RuntimeException("数据返回为空");
        }
        $arrResponse = json_decode($response, true);
        if ($error = json_last_error()) {
            throw new \RuntimeException($error);
        }
        if (!$this->verifyResponseSign($arrResponse)) {
            throw new \RuntimeException("响应数据签名校验失败");
        }
        return $arrResponse;

    }

    /**
     * 响应结果校验
     * @param array $responseData
     * @return bool
     */
    public function verifyResponseSign(array $responseData)
    {
        $code = $responseData['code'];
        $time = $responseData['time'];
        $sign = $responseData['sign'];
        $calc = md5($code . $this->appid . $this->appkey . $time);
        return $sign == $calc;
    }

    /**
     * @param $params
     * @param $t string
     * @return string
     */
    private function calcRequestSign($params, $t)
    {
        ksort($params);
        $fullStr = "t=" . $t . "&";
        foreach ($params as $key => $val) {
            $fullStr .= $key . "=" . $val . "&";
        }
        $fullStr .= "secret_key=" . $this->appkey;
        $fullStr = strtolower($fullStr);
        return md5($fullStr);
    }


}