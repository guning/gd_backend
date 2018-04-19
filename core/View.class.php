<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/2
 * Time: 12:10
 */

namespace core;


class View
{
    public static function get($templateName, $vars = []) {
        extract($vars, EXTR_OVERWRITE);

        ob_start();
        ob_implicit_flush(0);

        include TEMPLATE_PATH . $templateName . '.html';

        $content = ob_get_clean();
        return $content;
    }
}