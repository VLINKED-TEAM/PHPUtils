<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/31
 * Time: 15:54
 */

require "../vendor/autoload.php";

use VlinkedUtils\Message\Mail\Mailer;
use VlinkedUtils\Env;
use VlinkedUtils\Message\Mail\MailConfig;
use VlinkedUtils\Message\Mail\MailMessage;


$mailConfig = new MailConfig("smtp.126.com", Env::get("mail.username"), Env::get("mail.password"), 465, 'ssl');
$mailMessage = new MailMessage("测试", "测试", ["735825608@qq.com", "307880931@qq.com"]);

Mailer::sendMail($mailConfig, $mailMessage);

