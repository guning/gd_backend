<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/18
 * Time: 0:29
 */
if (PATH_SEPARATOR == ';') {
    define('SLASH', '\\');
} else {
    define('SLASH', '/');
}

define('APP_ROOT', dirname(__FILE__) . SLASH);
define('CONFIG_PATH', APP_ROOT . 'config' . SLASH);
define('CORE_PATH', APP_ROOT . 'core' . SLASH);
define('SCRIPT_PATH', APP_ROOT . 'script' . SLASH);
define('TEMPLATE_PATH', APP_ROOT . 'resources' . SLASH . 'template' . SLASH);
