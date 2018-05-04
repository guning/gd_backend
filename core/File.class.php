<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/5/4
 * Time: 12:47
 */

namespace core;


class File
{
    private $file = [];
    private static $storagePath = APP_ROOT . 'runtime' . SLASH . 'apk' . SLASH;

    public function __construct($file, $fileUnique, $ext)
    {
        $this->file = [
            'tmp' => $file,
            'fileUnique' => $fileUnique,
            'ext' => '.' . $ext
        ];
    }

    public function upload()
    {
        $filename = $this->getFilename($this->file['fileUnique']);
        $res = move_uploaded_file($this->file['tmp'], $this->getPathFilename($filename));
        if (!$res) {
            return false;
        }
        return $filename;
    }

    private function getFilename($fileUnique)
    {
        return md5($fileUnique);
    }

    private function getPathFilename($filename)
    {
        return self::$storagePath . $filename . $this->file['ext'];
    }

    public function getFile($filename = '') {
        if (empty($filename)) {
            $filename = $this->getFilename($this->file['fileUnique']);
        }
        $filePath = $this->getPathFilename($filename);
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }
        return $filePath;
    }

}