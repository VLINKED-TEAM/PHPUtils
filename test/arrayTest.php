<?php

namespace VlinkedUtils;

require_once __DIR__ . "/../vendor/autoload.php";

$arr = [
    'test' =>
        [
            'ddd' => [
                "ssa" => 12121
            ],
            "de" => "adasd1s"
        ]
];

try {
    echo Arrays::toXmlCDATA($arr);
    echo "\t\n";
    echo Arrays::toXml($arr);
    echo "\t\n";
} catch (InvalidArgumentTypeException $e) {
    var_dump($e->getMessage());
}
