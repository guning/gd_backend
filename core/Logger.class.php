<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/21
 * Time: 22:48
 */

namespace core;


class Logger
{
    public static function __callStatic($name, $param)
    {
        $fileName = substr($name, 0, -3);
        $msg = array_shift($param);
        if (empty($msg)) {
            $msg = 'record time';
        }
        if (is_array($msg)) {
            $msg = json_encode($msg);
        }

        self::errorLog(Config::getConfig('log_path') . "$fileName.log", date("Ymd H:i:s") . " " . $msg . PHP_EOL);
    }

    private static function errorLog($logPath, $msg)
    {
        error_log($msg, 3, $logPath);
    }
}