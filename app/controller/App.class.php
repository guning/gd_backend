<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/5/4
 * Time: 9:21
 */

include 'Common.class.php';

use app\model\App as AppModel;
use core\File;
class App extends Common
{
    private $systemUserId = 0;
    protected function auth()
    {
        // TODO: Implement auth() method.
        $this->systemUserId = 1;
        return true;
    }

    public function addApp() {
        $data = json_decode($_POST['data'], true);
        $applicationId = $data['applicationId'];
        $file = $_FILES['file'];
        if (empty($file) || empty($applicationId)) {
            \core\Logger::errorLog('参数不完整：' . json_encode($data), json_encode($file));
            self::$response['status'] = -1;
            self::$response['msg'] = '提交参数不完整';
        } else {
            $app = new AppModel();
            if (!$app->addApp($this->systemUserId, $file, $applicationId)) {
                self::$response['status'] = '-2';
                self::$response['msg'] = '上传文件失败';
            } else {
                self::$response['msg'] = '上传成功';
            }
        }
        return $this->toJsonResponse();
    }

    public function downloadApp() {
        $appId = $_GET['appId'];
        $appModel = new AppModel();
        $app = $appModel->getAppById($appId);
        if (empty($app)) {
            self::$response['status'] = '-503';
            self::$response['msg'] = 'app不存在';
            return $this->toJsonResponse();
        }
        $app = array_shift($app);
        $applicationId = $app['name'];
        $filename = $app['app_file'] . '.apk';
        $file = new File([], $applicationId, 'apk');
        $filePath = $file->getFile();
        if (!$filePath) {
            self::$response['status'] = '-403';
            self::$response['msg'] = '文件不存在';
            return $this->toJsonResponse();
        } else {
            $fileHandle=fopen($filePath,"rb");
            if($fileHandle===false){
                self::$response['status'] = '-503';
                self::$response['msg'] = '文件无法打开';
                return $this->toJsonResponse();
            }
            header('Content-type:application/octet-stream; charset=utf-8');
            header("Content-Transfer-Encoding: binary");
            header("Accept-Ranges: bytes");
            //文件大小
            header("Content-Length: ".filesize($filePath));
             //触发浏览器文件下载功能
            header('Content-Disposition:attachment;filename="'.urlencode($filename).'"');
            while (!feof($fileHandle)) {
                echo fread($fileHandle, 10240);
            }
            fclose($fileHandle);
        }
    }

    public function getApp() {
        $appModel = new AppModel();
        self::$response['data'] = $appModel->getList($this->systemUserId);
        return $this->toJsonResponse();
    }
}