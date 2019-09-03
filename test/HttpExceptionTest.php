<?php


namespace VlinkedUtils;


require_once __DIR__ . "/../vendor/autoload.php";


//try {
//    echo Http\Client::curlGet("https://127.0.0.2", "", 1);
//} catch (Http\HttpCurlException $e) {
//    echo $e->error_msg . "\n"; // 错误信息
//    echo $e->error_code . "\n"; // 错误码
//}


try {
    echo Http\Response::json(['avc' => '2131']);
} catch (InvalidArgumentTypeException $e) {
    var_dump($e);
}
