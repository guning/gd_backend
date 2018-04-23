<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/4/19
 * Time: 20:45
 */

namespace core;

use Pheanstalk\Pheanstalk;
class Beanstalkd
{
    private $pheanstalk = null;
    private static $_instance = null;
    private static $host, $port;
    public static function getInstance($host="127.0.0.1", $port="11300")
    {
        if (self::$_instance == null) {
            self::$host = $host;
            self::$port = $port;
            self::$_instance = new Beanstalkd();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $this->pheanstalk = new Pheanstalk(self::$host, self::$port);
    }

    public function setMessage($tube, $message, $delay=0, $priority=1024, $ttl = 60)
    {
        $this->pheanstalk->useTube($tube)->put($message, $priority, $delay, $ttl);
    }

    public function getMessage($tube)
    {
        $job = $this->pheanstalk->watch($tube)->ignore("default")->reserve();
        return $job;
    }

    public function delete($job)
    {
        $this->pheanstalk->delete($job);
    }

    public function getPheanstalk() {
        return $this->pheanstalk;
    }

    public function checkConnect()
    {
        return $this->pheanstalk->getConnection()->isServiceListening();
    }
}