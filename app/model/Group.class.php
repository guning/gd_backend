<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/14
 * Time: 0:29
 */

namespace app\model;


class Group extends Common
{
    protected $table = '`group`';
    public function getGroups($systemUserId, $appId)
    {
        $sql = "SELECT id,name FROM {$this->table} WHERE sys_user_id=:sid AND app_id=:aid";
        $params = [
            'sid' => $systemUserId,
            'aid' => $appId
        ];
        $res = $this->select($sql, $params);
        return $res;
    }

    public function find($systemUserId, $appId, $groupName) {
        $sql = "SELECT id FROM {$this->table} WHERE sys_user_id=:sid AND app_id=:aid AND name=:name LIMIT 1";
        $params = [
            'sid' => $systemUserId,
            'aid' => $appId,
            'name' => $groupName
        ];
        $tmp = $this->select($sql, $params);
        if (count($tmp) == 0) {
            $this->insert([
                'sys_user_id' => $systemUserId,
                'app_id' => $appId,
                'name' => $groupName,
                'ctime' => time(),
                'utime' => time()
            ]);
            $tmp['id'] = $this->getLastInsertId();
        } else {
            $tmp = array_pop($tmp);
        }
        return $tmp;
    }
}