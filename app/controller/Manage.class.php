<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/7
 * Time: 0:13
 */

include 'Common.class.php';

use app\model\App;
use app\model\Group;
use app\model\SystemUser;
use app\model\AppUser;
class Manage extends Common
{
    private $model = [];
    private $systemUserId = 0;

    protected function auth()
    {
        // TODO: Implement auth() method.
        $this->systemUserId = 1;
        return true;
    }

    public function __construct()
    {
        $this->model = [
            'app' => new App(),
            'appUser' => new AppUser(),
            'group' => new Group(),
            'systemUser' => new SystemUser()
        ];
    }


    public function api()
    {
        $rdata = array();
        if (isset($_POST['data'])) {
            $rdata = json_decode($_POST['data'], true);
        }
        $data = array();
        $code = 100;
        $statement = 'success';
        switch ($this->args[0]) {
            case 'getApps':
                $data = $this->getApps();
                break;
            case 'getGroupsList':
                $data = $this->getGroupsList($rdata['appid']);
                break;
            case 'getUsersList':
                $data = $this->getUsersList($rdata['appid'], $rdata['groupid']);
                break;
            case 'modifyUserGroup':
                $data = $this->modifyUserGroup($rdata['userid'], $rdata['appid'], $rdata['groupname']);
                break;
            default:
                \core\Logger::errorLog('Warning : access to a undefined api: ' . $_SERVER['REQUEST_URI']);
                $code = -1;
                $statement = 'api not exist';
        }
        return json_encode(array(
            'code' => $code,
            'statement' => $statement,
            'data' => $data
        ));
    }

    private function getApps() {
        $tmp = $this->model['app']->getList($this->systemUserId);
        if (count($tmp) == 0) {
            $tmp[] = [
                'id' => '',
                'name' => ''
            ];
        }
        return $tmp;
    }
    private function getGroupsList($appId)
    {
        $users = $this->getUsersList($appId);
        $tmpGroups = $this->model['group']->getGroups($this->systemUserId, $appId);
        $groups = [
            [
                'id' => 0,
                'name' => 'All'
            ]
        ];
        if (count($tmpGroups) != 0) {
            $groups = array_merge($groups, $tmpGroups);
        }

        return [
            'groups' => $groups,
            'users' => $users
        ];
    }

    private function getUsersList($appId, $groupId = 0)
    {
        $tmp = $this->model['appUser']->getAppUsers($this->systemUserId, $appId, $groupId);
        if (count($tmp) == 0) {
            $users = [
                [
                    'id' => '',
                    'name' => '',
                    'group' => ''
                ]
            ];
        } else {
            foreach ($tmp as $row) {
                $users[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'group' => $row['gname']
                ];
            }
        }
        return $users;
    }

    private function modifyUserGroup($userId, $appId, $groupName)
    {
        $tmp = $this->model['group']->find($this->systemUserId, $appId, $groupName);
        $this->model['appUser']->updateGroup($userId, $tmp['id']);
        return array();
    }

}