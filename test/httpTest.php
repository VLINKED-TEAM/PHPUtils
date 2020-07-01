<?php


require "../vendor/autoload.php";

use VlinkedUtils\Http;


$data = ["xml" => "233",
    "key" => "333+3+2="];
try {
    $list = Http\Client::curlPostRawJson("http://localhost:8080/22", $data);
    var_dump($list);
} catch (Http\HttpCurlException $e) {
    echo $e->getMessage();
    echo $e->getCode();
}