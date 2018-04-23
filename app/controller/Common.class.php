<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/9
 * Time: 0:10
 */

abstract class Common
{
    protected $args = [];

    abstract protected function auth();
    protected function beforeRun($method) {
        $methods = get_class_methods($this);
        if (!in_array($method, $methods)) {
            \core\Logger::errorLog('Warning : access to a undefined method: ' . $_SERVER['REQUEST_URI']);
            $this->afterRun('404');
        }
    }

    public function run($method, $args = []) {
        try {
            $this->beforeRun($method);
            if (!$this->auth()) {
                $this->afterRun('403 forbidden');
            }
            $this->args = $args;
            $res = $this->$method();
            $this->afterRun($res);
        } catch (Exception $e) {
            \core\Logger::errorLog($e->getMessage());
            $this->afterRun("something wrong!");
        }
    }

    private function test()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    }
    protected function afterRun($content) {
        echo $content;
        exit;
    }
}