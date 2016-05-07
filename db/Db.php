<?php
namespace Db;
/**
 * db 类study.
 * User: zhuguojie
 * Date: 16/4/26
 * Time: 下午6:30
 */
class Db
{
    public static  $_instance = null;
    private $_link;
    private $conf;

    /**
     *
     */
    public static function getInstance()
    {
        new self();
    }

    private function __construct(){
        $this->conf = parse_ini_file('./mysql.ini.php',true);
        $dsn ='mysql:dbname='.$this->conf['dbname'].';host='.$this->conf['host'];
        try{
            $this->_link = new PDO($dsn,$this->conf['user'],$this->conf['password']);
        }catch (\PDOException $e){
            echo 'Connection failed:'.$e->getMessage();
        }
    }

    private function __clone(){}

}

Db::getInstance();