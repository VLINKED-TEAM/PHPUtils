# 使用说明
需要已经安装好 [composer](https://docs.phpcomposer.com/)  环境




# 目录结构

```text
├── Arrays.php    
├── Container.php
├── Date.php
├── Http
│   ├── Client.php
│   └── Response.php
├── Json.php
├── Log
│   └── FileLog.php
├── Lottery
│   ├── Lottery.php
│   └── models.php
├── Objects.php
├── Random.php
├── Servers.php
├── Strings.php
├── Validators.php
└── exception.php

```

# 模块说明

## Arrays 数组操作相关的拓展工具函数


### ::get 获取数组中的key的values

**参数说明**

- array $arr 需要取出数据的数组 比如 $_GET
- $key 需要取出的key 比如 一维数组 `openid` 二维数组 `[userinfo,openid]` 等效 `userinfo.openid`
- $default = null 当key不存在的时候返回的默认值

**例子**

```PHP
<?php
namespace VlinkedUtils;

require_once  "具体路径"."/vendor/autoload.php";

$arr = [
    'test' =>
        [
            'ddd' => [
                "ssa" => 12121
            ],
            "de" => "adasd1s"
        ]
];

  echo Arrays::get($arr,['test','de']).PHP_EOL; 
 // adasd1s
 
  echo Arrays::get($arr,'test.de');
 // adasd1s
 
  echo Arrays::get($arr,['test','ddd','ssa']).PHP_EOL; 
// 12121

  echo Arrays::get($arr,['test2'],'ok').PHP_EOL;
// ok

  var_export(Arrays::get($arr,['test3']));
 //  "Missing item '212'." 这里会抛出异常 InvalidArgumentTypeException
 
  var_export(Arrays::get($arr,['test3'],null));
  // NULL
   
```

### ::toObject 将数组中的key 变成obj的属性 value变成obj属性的值

**参数说明**

- $arr 需要用来添加的数组 
- $obj 被添加的对象


**例子**

```PHP
<?php

$obj_arr = [
    'age'=>12,
    'email'=>"231@126.com",
    'phone'=>"12312312321"
];

class User{
    public $name;

    /**
     * User constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

}


$user = new User('jrexe');

var_dump(Arrays::toObject($obj_arr,$user));

/***
* object(VlinkedUtils\User)#3 (4) {
    ["name"]=>
    string(5) "jrexe"
    ["age"]=>
    int(12)
    ["email"]=>
    string(18) "231@126.com"m"
    ["phone"]=>
    string(11) "12312312321"
  }

 */

var_dump($user->age);
///int(12)

```
## toXml 数组转xml无<verison> 头
**参数说明**

- $arr 待转换数组


**返回值**

xml 字符串 


**例子**


```php
<?

$arr = [
    'test' =>
        [
            'ddd' => [
                "ssa" => 12121
            ],
            "de" => "adasd1s"
        ]
];
echo Arrays::toXml($arr);
// {"test":{"ddd":{"ssa":12121},"de":"adasd1s"}}

```

## ~~toXmlCDATA 数组转xml代 CDATA~~ 待完善


## Container  判断app内置浏览器（浏览器的userAgent）
容器 


**目前已经有的判断**

 * @method static isWeChat 微信内置浏览器
 * @method static isREL 融e联内置浏览器
 * @method static isREG 融e购内置浏览器
 * @method static isZhenuanSchool 正元校园内置浏览器
 
**使用方法**

```php
<?php
var_dump(Container::isWeChat());// 单个判断 在微信浏览器运用时为 true
var_dump(Container::isREL()); // 单个判断

var_dump(Container::detection()); // 检测用法 返回获取当前能够识别的浏览器
var_dump(Container::detection() === Container::WeChat); // 检测用法二



```

## Date 与日期相关的工具方法，包括生成订单号




## Http

## Objects
## Servers
## Strings
## Validators
