<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/14
 * Time: 0:29
 */

namespace app\model;

use core\Beanstalkd;
class Message extends Common
{
    protected $table = 'message';

    public function insertMes($systemUserId, $rData) {
        $pushDelay = $rData['time'];
        unset($rData['time']);
        $tmp = [
            'sys_user_id' => $systemUserId,
            'push_time' => $pushDelay + time(),
            'ctime' => time(),
            'utime' => time()
        ];
        $data = array_merge($rData, $tmp);
        $this->insert($data);
        $data['id'] = $this->getLastInsertId();
        Beanstalkd::getInstance()->setMessage(date("YmdH"), json_encode($data),  $pushDelay);//每个小时一个tube
    }
}