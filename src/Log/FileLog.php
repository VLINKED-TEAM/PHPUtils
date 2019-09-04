<?php


namespace VlinkedUtils\Log;

/**
 * Class FileLog
 * @method Info
 * @method Log
 * @method Debug
 * @method Error
 * @package VlinkedUtils\Log
 */
class FileLog
{

    static function dolog($desc = '', $datas = '')
    {
        $time = date('H:i:s', time());
        $filename = LOG_DIR . date('Y-m-d', time()) . '.log';
        if (is_array($datas)) {
            file_put_contents($filename, "[{$time}] {$desc}\n" . var_export($datas, true) . "\n\n", FILE_APPEND);
        } else {
            file_put_contents($filename, "[$time] {$desc}\n" . $datas . "\n\n", FILE_APPEND);
        }
    }

    public static function __callStatic($name, $arguments)
    {
        self::dolog($name, $arguments);
    }

}