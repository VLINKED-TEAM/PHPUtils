<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/31
 * Time: 15:40
 */

namespace VlinkedUtils\Message;


class MessageContent
{


    private $content;

    private $recevie = [];

    /**
     * MessageContent constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {

        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getRecevie()
    {
        return $this->recevie;
    }

    /**
     * @param array $recevie
     */
    public function setRecevie($recevie)
    {
        $this->recevie = $recevie;
    }


}
