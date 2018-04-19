<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/7
 * Time: 15:06
 */

namespace core;


class Auth
{
    const realm = "guning@2017";

    public static function auth($userList)
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Access denied!!!';
            exit;
        } else {
            if (isset($userList[$_SERVER['PHP_AUTH_USER']])) {
                if ($userList[$_SERVER['PHP_AUTH_USER']] === md5($_SERVER['PHP_AUTH_PW'])) {
                    return true;
                }
            }
            return false;
        }
    }
}