<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/31
 * Time: 15:45
 */

namespace VlinkedUtils\Message\Mail;


use http\Exception\RuntimeException;
use VlinkedUtils\Validators;
use VlinkedUtils\Message\MessageContent;

/**
 * Class MailMessage
 * @package VlinkedUtils\Message
 */
class MailMessage extends MessageContent
{


    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    /**
     * MailMessage constructor.
     * @param string $titile
     * @param string $conten
     * @param array $recivers
     * @param bool $isHtml
     * @throws \Exception
     */
    public function __construct($titile, $conten, $recivers)
    {
        $this->setTitle($titile);
        $this->setContent($conten);
        $this->setRecevie($recivers);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @throws \Exception
     */
    public function setTitle($title)
    {
        $this->title = $title;
        if(empty($title)){
            throw  new \Exception("标题不能为空");
        }
    }

    /**
     * @param array $recevie
     * @throws \Exception
     */
    public function setRecevie($recevie)
    {
//         进过一些处理检查内容必选为 邮箱地址
//       if ( Validators::everyIs($recevie,"email")){
//           throw  new \Exception("检查接受者格式必须为email");
//       }
       parent::setRecevie($recevie);
    }

}