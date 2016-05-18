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
     * 单例
     */
    public static function getInstance()
    {
        if(!self::$_instance instanceof  self )
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function __clone(){}

    private function __construct(){
        $this->conf = parse_ini_file('./mysql.ini.php',true);

        $dsn ='mysql:dbname='.$this->conf['dbname'].';host='.$this->conf['host'];
        try{
            $this->_link = new \PDO($dsn,$this->conf['user'],$this->conf['password']);
        }catch (\PDOException $e){
            echo 'Connection failed:'.$e->getMessage();
        }
    }

    public function query($sql)
    {
        $result = $this->_link ->query($sql,\PDO::FETCH_ASSOC);
        return $result;
    }

    public function select($sql) {
        $result = $this ->query($sql);
        return $result->fetchAll();

    }


    public function findOne($sql)
    {
        $result = $this->query($sql);
        return $result->fetch();
    }



}

$db = Db::getInstance();
$info = $db ->findOne('select * from accounts limit 10');

var_dump($info);exit;