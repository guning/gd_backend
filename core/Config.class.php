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
    public static function getConfig($configName = '') {
        $config = [];
        $dirHandle = opendir(APP_ROOT . 'config');
        while ($file = readdir($dirHandle)) {
            if ($file !== '.' && $file !== '..')
                $tmp = include(APP_ROOT . 'config' . SLASH . $file);
            if (!empty($config)) {
                $config = @array_merge($config, $tmp);
            } else {
                $config = @array_merge(array(), $tmp);
            }
        }
        if (empty($configName) || empty($config[$configName])) {
            return $config;
        } else {
            return $config[$configName];
        }
    }
}