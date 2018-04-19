<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/18
 * Time: 0:31
 */
include 'Loader.php';
//TableCreate::create()->table('test')->fieldType(['test'], ['int(10)'], ['not null'])->primaryKey('id')->run();
//var_dump($_SERVER['REQUEST_URI']);
/*try {
    $db = \core\DB::getInstance()->getDB();

    $res = $db->query('SELECT id,title,summary,update_time as time FROM article WHERE status=1 AND user_id=1 limit 1');
    $res->setFetchMode(PDO::FETCH_ASSOC);
    var_dump($res->fetchAll());
} catch (Exception $e) {
    var_dump($e->getMessage());
}*/
echo time();
