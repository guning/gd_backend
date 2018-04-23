<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/10
 * Time: 10:35
 */

include 'Common.class.php';
use core\View;
use app\model\Article;
class Home extends Common
{
    private $model;
    protected function auth()
    {
        return true;
    }
    public function __construct() {
        $this->model = new Article();
    }

    public function show() {
        $content = View::get('index');
        return $content;
    }

    public function api() {
        return print_r(json_decode($_POST['data'], true));
    }
    public function testapi() {
        return $_POST['data'];
    }
}