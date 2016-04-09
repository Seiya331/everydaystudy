<?php

/**
 * redisDb 链接库
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/9上午11:05
 * 说明，任何为false的串，存在redis中都是空串。
 * 只有在key不存在时，才会返回false。
 *
 */
class redisDb
{

    protected static $_instance = null;

    protected $redis = '';


    protected $expire_time;

    protected $host;

    protected $port;

    private function __construct($config)
    {
        $this->redis = new Redis();
        $this->host = $config['host'];
        $this->port = $config['port'];
        $connect = $this->redis->connect($this->host, $this->port, $config['timeout']);
        if (!$connect) {
            exit('redis 链接失败');
        }
        if ($config['timeout'] > 0) {
            $this->expire_time = time() + $config['timeout'];
        } else {
            $this->expire_time = 0;
        }

    }

    public static function getInstance()
    {
        $config = config::redisConfig();
        $k = md5(implode(',', $config));
        if (!(self::$_instance[$k] instanceof self)) {
            self::$_instance[$k] = new self($config);
            self::$_instance[$k]->k = $k;
            self::$_instance[$k]->db_id = $config['db_id'];
            if ($config['db_id'] != 0) {
                self::$_instance[$k]->select($config['db_id']);
            }
        } else if (self::$_instance[$k]->expire_time > 0 && self::$_instance[$k]->expire_time < time()) {
            self::$_instance[$k]->close();
            self::$_instance[$k] = new self($config);
            self::$_instance[$k]->k = $k;
            self::$_instance[$k]->db_id = $config['db_id'];
            if ($config['db_id'] != 0) {
                self::$_instance[$k]->select($config['db_id']);
            }
        }
        return self::$_instance[$k];

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
        exit('forbide');
    }

    //获取redis
    public function getRedis()
    {
        return $this->redis;
    }

    public function getRedisStatus()
    {
        return $this->redis->ping();
    }
    /***** --------字符串类型的相关操作 ---------**/

    /**
     * 设置字符串
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
        if (emtpy($key)) return false;
        return $this->redis->set($key, $value);
    }

    /**
     * 获取redis 的值
     *
     * @param $key
     *
     * @return bool|string
     */
    public function get($key)
    {
        if (emtpy($key)) return false;
        return $this->redis->get($key);
    }

    /**
     * 设置带过期时间的值
     *
     * @param $key
     * @param $expire
     * @param $value
     *
     * @return mixed
     */
    public function setex($key, $expire, $value)
    {
        return $this->redis->setex($key, $expire, $value);
    }

    /**
     * 设置值,存在则不作任何操作
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function setnx($key, $value)
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * 批量设置值
     *
     * @param $array
     *
     * @return bool
     */
    public function mset($array)
    {
        return $this->redis->mset($array);
    }

    /**
     * 批量获取值
     *
     * @param $array
     *
     * @return bool
     */
    public function mget($array)
    {
        return $this->redis->mget($array);
    }

    /**
     * 检查是否存在
     *
     * @param $key
     *
     * @return bool
     */
    public function sexits($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * 删除key
     * $redis->delete('key1', 'key2');          // return 2
     * $redis->delete(array('key3', 'key4'));   // return 2
     *
     *
     * @param $key
     *
     * @return bool
     */
    public function delete($key)
    {
        return $this->redis->delete($key);
    }

    /**
     * 增加一个数值 key 对应的value不为整数,报错
     *
     * @param $key
     *
     * @return int|string
     */
    public function incr($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * 减少指定的
     *
     * @param $key
     *
     * @return int
     */
    public function decr($key)
    {
        return $this->redis->decr($key);
    }

    /**
     * 增加指定的数字
     *
     * @param $key
     * @param $num
     *
     * @return int
     */
    public function incrby($key, $num)
    {
        return $this->redis->incrBy($key, $num);
    }

    /**
     * 减少指定的数字
     *
     * @param $key
     * @param $num
     *
     * @return int
     */
    public function dcerby($key, $num)
    {
        return $this->redis->decrBy($key, $num);
    }

    /**
     * 获取长度
     *
     * @param $key
     *
     * @return int
     */
    public function getstrlen($key)
    {
        return $this->redis->strlen($key);
    }


    /***-------散列类型--------------**/

    /**
     * @param $key
     * @param $field
     * @param $value
     *
     * @return array
     */
    public function hSet($key, $field, $value)
    {
        return $this->redis->hSet($key, $field, $value);
    }


    public function hGet($key, $field)
    {
        return $this->redis->hGet($key, $field);
    }

    public function hExists($key, $field)
    {
        return $this->redis->hExists($key, $field);
    }

    public function hDel($key, $field)
    {
        $filed_array = explode(',', $field);
        if (emtpy($filed_array)) return false;
        $del_nums = 0;
        foreach ($filed_array as $value) {
            $value = trim($value);
            $this->redis->hDel($key, $value);
            $del_nums += 1;
        }
        return $del_nums;
    }

    public function hLen($key)
    {
        return $this->redis->hLen($key);
    }

    public function hSetNx($key, $field, $value)
    {
        return $this->redis->hSetNx($key, $field, $value);
    }

    public function hmset($key, $value)
    {
        if (!is_array($value)) return false;
        return $this->redis->hMset($key, $value);
    }

    public function hmget($key, $field)
    {
        if (!is_array($field))
            $field = explode(',', $field);
        return $this->redis->hMGet($key, $field);
    }

    public function hIncrBy($key, $field, $value)
    {
        return $this->redis->hIncrBy($key, $field, $value);
    }

    public function hKeys($keys)
    {
        return $this->redis->hKeys($keys);
    }

    /**
     * 返回所有hash表的字段值，为一个索引数组
     *
     * @param string $key
     *
     * @return array|bool
     */
    public function hValue($key)
    {
        return $this->redis->hVals($key);
    }

    /**
     * @param $key
     *
     * @return array
     */
    public function hgetall($key)
    {
        return $this->redis->hGetAll($key);
    }



    /*********************队列操作命令************************/

    /**
     * 右侧存储
     *
     * @param $key
     * @param $value
     *
     * @return int
     */
    public function rPush($key, $value)
    {
        return $this->redis->rPush($key, $value);
    }

    public function rPop($key)
    {
        return $this->redis->rPop($key);
    }

    public function lPush($key, $value)
    {
        return $this->redis->lPush($key, $value);
    }

    public function lPop($key)
    {
        return $this->redis->lPop($key);
    }

    /**
     * 队尾插入数据,如果key 不存在,则什么也不做
     *
     * @param $key
     * @param $value
     *
     * @return int
     */
    public function rPushx($key, $value)
    {
        return $this->redis->rPushx($key, $value);
    }

    public function lPushx($key, $value)
    {
        return $this->redis->lPushx($key, $value);
    }

    /**
     * 获取长度
     *
     * @param $key
     *
     * @return int
     */
    public function lLen($key)
    {
        return $this->redis->lLen($key);
    }

    /**
     * 获取指定的数据的范围
     *
     * @param $key
     * @param $start
     * @param $end
     *
     * @return array
     */
    public function lRange($key, $start, $end)
    {
        return $this->redis->lRange($key, $start, $end);
    }

    public function lIndex($key, $index)
    {
        return $this->redis->lIndex($key, $index);
    }

    public function lSet($key, $index, $value)
    {
        return $this->redis->lSet($key,$index,$value);
    }

    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count<0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部
     * @param unknown $key
     * @param unknown $count
     * @param unknown $value
     */
    public function lRem($key,$count,$value)
    {
        return $this->redis->lRem($key,$value,$count);
    }
}