<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/18
 * Time: 0:19
 */

require_once('env.php');
spl_autoload_register('__autoload__');

function __autoload__($name) {
    $defaultName = str_replace('\\', SLASH, $name) . '.class.php';
    if (file_exists(APP_ROOT . $defaultName)) {
        require APP_ROOT. $defaultName;
    } else if (file_exists(SCRIPT_PATH . $defaultName)) {
        require SCRIPT_PATH . $defaultName;
    }
    require APP_ROOT . 'vendor' . SLASH . 'autoload.php';
}