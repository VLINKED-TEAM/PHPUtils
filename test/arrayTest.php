<?php

namespace VlinkedUtils;

require_once __DIR__ . "/../vendor/autoload.php";

$arr = ['test' => ['ddd' => 1, "21" => 21]];


try {
    echo Arrays::toXml($arr);
} catch (InvalidArgumentTypeException $e) {
    var_dump($e->getMessage());
}
