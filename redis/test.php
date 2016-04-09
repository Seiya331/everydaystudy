<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/9上午11:11
 */

include_once 'autoload.php';

//$data = redisDb::getInstance()->set('key','2222');

$new = redisDb::getInstance()->getRedis();

var_dump($new);