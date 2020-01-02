<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/31
 * Time: 15:40
 */

namespace VlinkedUtils\Message\Mail;


/**
 * Class MailConfig
 * @package VlinkedUtils\Message
 */
class MailConfig
{
    /**
     * 发送的SMTP服务器
     * @var string
     */
    private $host;
    /**
     * 发件人账号
     * @var string
     */
    private $useraname;
    /**
     * 发件人密码
     * @var string
     */
    private $pasword;
    /**
     * 邮件发送端口
     * @var int
     */
    private $port;
    /**
     * 设置安全验证方式
     * @var string
     */
    private $secure;

    /**
     * MailConfig constructor.
     * @param $host
     * @param $useraname
     * @param $pasword
     * @param int $port
     */
    public function __construct($host, $useraname, $pasword, $port, $secure)
    {
        $this->host = $host;
        $this->useraname = $useraname;
        $this->pasword = $pasword;
        $this->port = $port;
        $this->secure = $secure;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUseraname()
    {
        return $this->useraname;
    }

    /**
     * @param string $useraname
     */
    public function setUseraname($useraname)
    {
        $this->useraname = $useraname;
    }

    /**
     * @return string
     */
    public function getPasword()
    {
        return $this->pasword;
    }

    /**
     * @param string $pasword
     */
    public function setPasword($pasword)
    {
        $this->pasword = $pasword;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @param string $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    }


}