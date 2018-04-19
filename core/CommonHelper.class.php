<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/21
 * Time: 21:54
 */

namespace core;


class CommonHelper
{
    public static function uniqidName() {
        return md5(microtime() . uniqid() . rand(1,10000));
    }
}