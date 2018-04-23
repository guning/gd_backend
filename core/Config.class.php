<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/21
 * Time: 22:30
 */

namespace core;


class Config
{
    private static $config = [];
    public static function getConfig($configName = '')
    {
        if (empty(self::$config)) {
            $dirHandle = opendir(APP_ROOT . 'config');
            while ($file = readdir($dirHandle)) {
                if ($file !== '.' && $file !== '..') {
                    $tmp = include(APP_ROOT . 'config' . SLASH . $file);
                } else {
                    continue;
                }
                if (!empty(self::$config)) {
                    self::$config = @array_merge(self::$config, $tmp);
                } else {
                    self::$config = @array_merge(array(), $tmp);
                }
            }
        }
        if (empty($configName) || empty(self::$config[$configName])) {
            return self::$config;
        } else {
            return self::$config[$configName];
        }
    }
}