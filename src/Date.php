<?php


namespace VlinkedUtils;


class Date
{
    /**
     * 第一次使用composer 来生产工具包
     */
    public static function getDateTime(){
        echo date(DATE_ATOM);
    }
}
