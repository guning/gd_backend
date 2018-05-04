<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/5/2
 * Time: 10:51
 */

include 'Common.class.php';

use app\model\App;
use app\model\AppUser;
class Api extends Common
{
    protected function auth()
    {
        // TODO: Implement auth() method.
        return true;
    }

    public function getTopics() {
        $uid = trim($_GET['uid']);
        $applicationId = trim($_GET['applicationId']);
        $name = md5($uid.time());
        $appModel = new App();
        $app = $appModel->getApp($applicationId);
        if (empty($app)) {
            return json_encode([
                'status' => -1,
                'msg' => 'cannot get app',
                'data' => [
                ]
            ]);
        }
        $user = [
            'sys_user_id' => $app[0]['sys_user_id'],
            'app_id' => $app[0]['id'],
            'name' => $name,
            'groupId' => 0,
            'ctime' => time(),
            'utime' => time()
        ];
        $userModel = new AppUser();
        $userModel->insertUser($user);
        $clientId = $userModel->getLastInsertId();

        return json_encode([
            'status' => 0,
            'msg' => '',
            'data' => [
                'clientName' => $name,
                'topics' => [
                    'appId' . $app['id'],
                    'clientId' . $clientId
                ]
            ]
        ]);
    }
}