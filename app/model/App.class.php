<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/13
 * Time: 23:23
 */

namespace app\model;

class App extends Common
{
    protected $table = 'app';

    public function getList($systemUserId) {
        $sql = "SELECT id, name FROM {$this->table} WHERE sys_user_id=:id";
        $params = [ 'id' => $systemUserId ];
        $res = $this->select($sql, $params);
        return $res;
    }
}