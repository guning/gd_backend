<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/14
 * Time: 0:27
 */

namespace app\model;


class AppUser extends Common
{
    protected $table = 'app_user';

    public function getAppUsers($systemUserId, $appId, $groupId)
    {
        $sql = "SELECT a.id,a.name,b.name as gname 
                  FROM {$this->table} a 
                  LEFT JOIN 
                  `group` b on a.group_id=b.id 
                  WHERE a.sys_user_id=:sid AND a.app_id=:aid";
        $params = [
            'sid' => $systemUserId,
            'aid' => $appId
        ];
        if ($groupId != 0) {
            $sql .= " AND a.group_id=:gid";
            $params = array_merge($params, ['gid' => $groupId]);
        }
        $res = $this->select($sql, $params);
        return $res;
    }

    public function updateGroup($userId, $groupId) {
        $this->update(['id' => $userId], ['group_id' => $groupId, 'utime' => time()]);
        if ($this->getLastInsertId() == 0) {
            return false;
        }
        return true;
    }

    public function insertUser($user) {
        $this->insert($user);
    }
}