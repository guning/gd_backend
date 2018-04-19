<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/9
 * Time: 23:55
 */
include '../Loader.php';
try {
    foreach (\core\Config::getConfig('table_config') as $tableConfig) {
        echo $tableConfig['table'] . "\n";
        $table = \core\TableCreate::create()
            ->table($tableConfig['table'])
            ->fieldType($tableConfig['field'][0], $tableConfig['field'][1], $tableConfig['field'][2])
            ->primaryKey($tableConfig['primary_key'])
            ->setKey($tableConfig['key'])
            ->setForeignKey($tableConfig['foreign_key'])
            ->run();
        echo $table . "\n";
        \core\DB::getInstance(\core\Config::getConfig('db_config'))->exec($table, []);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
