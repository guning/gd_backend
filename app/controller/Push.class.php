<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/7
 * Time: 0:10
 */

include 'Common.class.php';

use app\model\App;
class Push extends Common
{
    private $model = null;
    private $systemUserId = 0;

    public function __construct()
    {
        $this->model = [
            'app' => new App()
        ];

    }

    protected function auth()
    {
        // TODO: Implement auth() method.
        $this->systemUserId = 1;
        return true;
    }

    public function api()
    {
        $rdata = array();
        if (isset($_POST['data'])) {
            $rdata = json_decode($_POST['data'], true);
        }
        $code = 100;
        $data = array();
        $statement = 'success';
        switch ($this->args[0]) {
            case 'getApps':
                $data = $this->getApps();
                break;
            case 'getGroups':
                $data = $this->getGroups($rdata['appid']);
                break;
            case 'push':
                $data = $this->pushMes(array(
                    'appid' => (int) $rdata['appid'],
                    'platform' => (int) $rdata['platform'],
                    'title' => substr($rdata['title'], 0, 20),
                    'content' => substr($rdata['content'], 0, 50),
                    'group' => (int) $rdata['group']['type'],
                    'target' => $rdata['group']['ext'],
                    'time' => $rdata['time'] + time()
                ));
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

    private function pushMes($data)
    {
        return array();
    }

    private function getApps()
    {
        $tmp = $this->model['app']->getList($this->systemUserId);
        if (count($tmp) == 0) {
            $tmp[] = [
                'id' => '',
                'name' => ''
            ];
        }
        return $tmp;
    }
    private function getGroups($appId)
    {
        return array(
            array(
                'id' => 1,
                'name' => 'group1'
            ),
            array(
                'id' => 2,
                'name' => 'group2'
            )
        );
    }
}