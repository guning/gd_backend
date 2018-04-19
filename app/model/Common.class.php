<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2018/3/13
 * Time: 18:57
 */

namespace app\model;

use core\DB;
use core\Config;
class Common
{
    protected $table;
    private $db = null;

    public function __construct($db_config = [])
    {
        if (empty($db_config)) {
            $db_config = Config::getConfig('db_config');
        }
        $this->db = DB::getInstance($db_config);
    }

    public function insert($arr)
    {
        $tmp = $this->formatArray($arr);
        $strArrayKeys = $tmp['strArrayKeys'];
        $params = $tmp['format'];
        $strFormatKeys = $tmp['strFormatKeys'];

        $sql = "INSERT INTO {$this->table} ({$strArrayKeys}) VALUES ({$strFormatKeys})";
        return $this->db->exec($sql, $params);
    }

    public function select($sql, $arr)
    {
        $params = [];
        if (!empty($arr)) {
            $tmp = $this->formatArray($arr);
            $params = $tmp['format'];
        }
        $res = $this->db->exec($sql, $params);
        $res->setFetchMode(\PDO::FETCH_ASSOC);
        return $res->fetchAll();
    }

    public function delete($condition)
    {
        $tmp = $this->formatArray($condition);
        $params = $tmp['format'];
        $tmp = [];
        foreach ($condition as $key => $value) {
            $tmp[] = "{ $key } = :{ $key }";
        }
        $strCondition = implode(' AND ', $tmp);
        $sql = "DELETE FROM {$this->table} WHERE {$strCondition}";
        return $this->db->exec($sql, $params);
    }

    public function update($condition, $arr)
    {
        $tmpCondition = $this->formatArray($condition);
        $tmpArr = $this->formatArray($arr);

        $tmp = [];
        foreach ($condition as $key => $value) {
            $tmp[] = "{$key} = :{$key}";
        }
        $strCondition = implode(' AND ', $tmp);

        $tmp = [];
        foreach ($arr as $key => $value) {
            $tmp[] = "{$key} = :{$key}";
        }
        $strParams = implode(',', $tmp);

        $sql = "UPDATE {$this->table} SET {$strParams} WHERE {$strCondition}";
        return $this->db->exec($sql, array_merge($tmpArr['format'], $tmpCondition['format']));
    }

    private function formatArray($arr) {
        $arrKey = array_keys($arr);
        $res = [
            'strArrayKeys' => implode(',', $arrKey),
            'format' => [],
            'strFormatKeys' => ''
        ];
        $tmp = [];
        foreach ($arr as $k => $v) {
            $tmp[':' . $k] = $v;
        }
        $res['format'] = $tmp;
        $res['strFormatKeys'] = implode(',', array_keys($tmp));
        return $res;
    }

    public function getLastInsertId() {
        return $this->db->getDB()->lastInsertId();
    }

}