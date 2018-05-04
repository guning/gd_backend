<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/13
 * Time: 23:23
 */

namespace app\model;

use core\Config;
use core\Logger;
use core\File;

class App extends Common
{
    protected $table = 'app';

    public function getList($systemUserId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE sys_user_id=:id";
        $params = ['id' => $systemUserId];
        $res = $this->select($sql, $params);
        return $res;
    }

    public function getApp($name)
    {
        $sql = "SELECT id, sys_user_id FROM {$this->table} WHERE name=:name";
        $params = ['name' => $name];
        $res = $this->select($sql, $params);
        return $res;
    }

    public function getAppById($id)
    {
        $sql = "SELECT name, app_file FROM {$this->table} WHERE id=:id";
        $params = ['id' => $id];
        $res = $this->select($sql, $params);
        return $res;
    }

    public function addApp($systemUserId, $file, $applicationId)
    {
        if (!$this->validateFile($file)) {
            Logger::errorLog('文件验证未通过' . json_encode($file));
            return false;
        }
        $uploadFile = new File($file['tmp_name'], $applicationId, 'apk');
        $filename = $uploadFile->upload();
        if (!$filename) {
            Logger::errorLog('文件上传失败' . json_encode($file));
            return false;
        }
        $data = [
            'sys_user_id' => $systemUserId,
            'app_file' => $filename,
            'name' => $applicationId,
            'ctime' => time(),
            'utime' => time()
        ];
        $res = $this->insert($data);
        if (!$res) {
            Logger::errorLog('写入数据库失败' . json_encode($data));
            return false;
        }
        return true;
    }

    private function validateFile($file)
    {
       if (substr($file['name'], -3) !== 'apk') {
           return false;
       }
       if ($file['size'] > Config::getConfig('uploadLimit') * 1024 * 1024) {
           return false;
       }
       if ($file['type'] != 'application/vnd.android.package-archive') {
           return false;
       }
       return true;
    }

}