<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/11
 * Time: 23:59
 */

namespace core;


class MD
{
    private static $path = APP_ROOT . 'mdFile' . SLASH ;
    public static function getContent($filename, $ext = 'md') {
        $content = '';
        if (file_exists(self::$path . $filename . '.' . $ext)) {
            $content = file_get_contents(self::$path . $filename . '.' . $ext);
        }
        return $content;
    }

    public static function setContent($filename, $content, $ext = 'md') {
        $res = file_put_contents(self::$path . $filename . '.' . $ext, $content);
        return $res !== false;
    }
}