<?php

namespace VlinkedUtils\Message\Mail;


use PHPMailer;

/**
 * 邮件通知类
 * Class Mailer
 * @package VlinkedUtils\Message
 */
class Mailer
{
    /**
     * @param MailConfig $mailConfig
     * @param MailMessage $mailMessage
     * @throws \phpmailerException
     */
    public static function sendMail($mailConfig, $mailMessage)
    {
        //实例化PHPMailer核心类
        $mail = new PHPMailer();
        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;

        //链接qq域名邮箱的服务器地址
        $mail->Host = $mailConfig->getHost();

        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = $mailConfig->getSecure();

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = $mailConfig->getPort();

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = '';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $mailConfig->getUseraname();

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = $mailConfig->getUseraname();

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = $mailConfig->getPasword();

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = $mailConfig->getUseraname();

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        foreach ($mailMessage->getRecevie() as $k => $v) {
            $mail->addAddress($v, $mailConfig->getUseraname()); //添加收件人（地址，昵称）
            $mail->isHTML(false); //支持html格式内容
            $mail->Body = $mailMessage->getContent(); //邮件主体内容
            $mail->send();
        }
    }
}