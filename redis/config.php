<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/9上午11:42
 */


class config{
    public  static function redisConfig(){
        return array(
            'host' => '127.0.1',
            'port' => 6379,
            'timeout' => 3000,
            'db_id' => 0
        );
    }
}