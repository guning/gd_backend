<?php

/**
 * todo:
 * User: guning
 * DateTime: 2017-11-22 10:26
 */

namespace core;
class TableCreate
{
    private static $_instance = null;
    private $table = '';
    private $fieldType = [
        //"id" => "int(10) unsigned not null auto_increment",
        "ctime" => "int(10) unsigned not null",
        "utime" => "int(10) unsigned not null"
    ];
    private $primaryKey = 'id';
    private $foreignKeys = [];
    private $keys = [];
    private $engine = 'InnoDB';
    private $charset = 'utf8';
    private $collate = 'utf8_unicode_ci';

    public function run()
    {
        $this->verify([$this->table, $this->fieldType, $this->primaryKey, $this->engine, $this->charset, $this->collate]);
        $sql = '';
        $cols = [];
        $sql .= "create table if not EXISTS `{$this->table}` (\n";
        $cols[] = "`{$this->primaryKey}` int(10) unsigned not null auto_increment";
        foreach ($this->fieldType as $field => $conf) {
            $cols[] = "`{$field}` {$conf}";
        }
        $cols[] = "primary key (`{$this->primaryKey}`)";
        if (count($this->foreignKeys) > 0) {
            $cols[] = $this->parseForeignKey();
        }
        if (count($this->keys) > 0) {
            $cols[] = $this->parseKey();
        }
        $sql .= implode(",\n", $cols);
        $sql .= "\n)engine={$this->engine} default charset={$this->charset} collate={$this->collate};";
        return $sql;
    }

    public static function create()
    {
        self::$_instance = new TableCreate();
        return self::$_instance;
    }

    private function verify($vars)
    {
        if (empty(self::$_instance)) {
            throw new \Exception('pls call the create function first');
            exit;
        }
        foreach ($vars as $var) {
            if (empty($var)) {
                throw new \Exception('function can not be called at this time');
                exit;
            }
        }
    }

    private function __construct()
    {

    }

    public function table($table)
    {
        $this->verify([1]);
        $this->table = $table;
        return self::$_instance;
    }

    public function fieldType($names, $types, $exts)
    {
        $this->verify([1]);
        $tmp = [];
        foreach ($names as $key => $name) {
            $type = $types[$key];
            $ext = $exts[$key];
            $tmp[$name] = "{$type} {$ext}";
        }
        $this->fieldType = array_merge($tmp, $this->fieldType);
        return self::$_instance;
    }

    public function primaryKey($field)
    {
        $this->verify([1]);
        $this->primaryKey = $field;
        return self::$_instance;
    }

    public function engine($engine)
    {
        $this->verify([1]);
        $this->engine = $engine;
        return self::$_instance;
    }

    public function charset($charset)
    {
        $this->verify([1]);
        $this->charset = $charset;
        return self::$_instance;
    }

    public function collate($collate)
    {
        $this->verify([1]);
        $this->collate = $collate;
        return self::$_instance;
    }

    public function setForeignKey($foreignKeys)
    {
        $this->verify([1]);//instance
        $this->foreignKeys = $foreignKeys;
        return self::$_instance;
    }

    public function setKey($keys)
    {
        $this->verify([1]);
        $this->keys = $keys;
        return self::$_instance;
    }

    private function parseForeignKey()
    {
        $res = [];
        foreach ($this->foreignKeys as $foreignKey) {
            $res[] = "CONSTRAINT `{$foreignKey['name']}` FOREIGN KEY (`{$foreignKey['key']}`) ".
            "REFERENCES `{$foreignKey['foreign_table']}` (`{$foreignKey['foreign_key']}`) {$foreignKey['extra']}";
        }
        return implode(",\n", $res);
    }

    private function parseKey()
    {
        $res = [];
        foreach ($this->keys as $key) {
            $res[] = "KEY `{$key['name']}` (" . implode(',', array_map([$this, 'addDot'], $key['field'])) . ")";
        }
        return implode(",\n", $res);
    }

    private function addDot($k) {
        return "`{$k}`";
    }

}