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
        return $this->redis->lSet($key, $index, $value);
    }

    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count<0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部
     *
     * @param unknown $key
     * @param unknown $count
     * @param unknown $value
     */
    public function lRem($key, $count, $value)
    {
        return $this->redis->lRem($key, $value, $count);
    }

    /********有序集合排序操作*************/

    public function zadd($key, $order, $value)
    {
        return $this->redis->zAdd($key, $order, $value);
    }

    public function zIncrBy($key, $value, $num)
    {
        return $this->redis->zIncrBy($key, $value, $num);

    }

    public function zRem($key, $value)
    {
        return $this->redis->zRem($key, $value);
    }

    /**
     * 集合以order递增排列后，0表示第一个元素，-1表示最后一个元素
     *
     * @param string $key
     * @param int    $start
     * @param int    $end
     *
     * @return array|bool
     */
    public function zRange($key, $start, $end)
    {
        return $this->redis->zRange($key, $start, $end);
    }

    /**
     * 集合以order递减排列后，0表示第一个元素，-1表示最后一个元素
     *
     * @param string $key
     * @param int    $start
     * @param int    $end
     *
     * @return array|bool
     */
    public function zRevRange($key, $start, $end)
    {
        return $this->redis->zRevRange($key, $start, $end);
    }

    /**
     * 集合以order递增排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     *
     * @param string $key
     * @param int    $start
     * @param int    $end
     *
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     * @return array|bool
     */

    public function zRangeByScore($key, $start = '-inf', $end = "+inf", $option = array())
    {
        return $this->redis->zRangeByScore($key, $start, $end, $option);
    }

    /**
     * 集合以order递减排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     *
     * @param string $key
     * @param int    $start
     * @param int    $end
     *
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     * @return array|bool
     */
    public function zRevRangeByScore($key, $start = '-inf', $end = "+inf", $option = array())
    {
        return $this->redis->zRevRangeByScore($key, $start, $end, $option);
    }

    public function zCount($key, $start, $end)
    {
        return $this->redis->zCount($key, $start, $end);
    }

    public function zScore($key, $value)
    {
        return $this->redis->zScore($key, $value);
    }

    public function zRank($key, $value)
    {
        return $this->redis->zRank($key, $value);
    }

    public function zRevRank($key, $value)
    {
        return $this->redis->zRevRange($key, $value);
    }

    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->redis->zRemRangeByScore($key, $start, $end);
    }

    public function zCard($key)
    {
        return $this->redis->zCard($key);
    }


    /*************redis　无序集合操作命令*****************/

    public function sMember($key)
    {
        return $this->redis->sMembers($key);
    }

    public function sDiff($key1, $key2)
    {
        return $this->redis->sDiff($key1, $key2);
    }

    /**
     * 添加集合。由于版本问题，扩展不支持批量添加。这里做了封装
     *
     * @param unknown      $key
     * @param string|array $value
     */
    public function sAdd($key, $value)
    {
        if (!is_array($value)) {
            $arr = array($value);
        } else {
            $arr = $value;
        }
        foreach ($arr as $row) {
            $this->redis->sAdd($key, $row);
        }
    }


    public function scard($key)
    {
        return $this->redis->sCard($key);
    }

    public function sRem($key)
    {
        return $this->redis->sRem($key);
    }

    /*************redis管理操作命令*****************/

    /**
     * 选择数据库
     *
     * @param int $dbId 数据库ID号
     *
     * @return bool
     */
    public function select($dbId)
    {
        return $this->redis->select($dbId);
    }

    public function flushDb()
    {
        return $this->redis->flushDB();
    }

    public function info()
    {
        return $this->redis->info();
    }

    public function save()
    {
        return $this->redis->save();
    }

    /**
     * 异步保存到数据
     * @return bool
     */
    public function bgSave()
    {
        return $this->redis->bgsave();
    }

    public function lastSave()
    {
        return $this->redis->lastSave();
    }

    /**
     * 返回key,支持*多个字符，?一个字符
     * 只有*　表示全部
     * @param string $key
     * @return array
     */
    public function keys($key)
    {
        return $this->redis->keys($key);
    }

    public function del($key)
    {
        return $this->redis->del($key);
    }

    public function exits($key)
    {
        return $this->redis->exists($key);
    }

    public function expire($key,$expire)
    {
        return $this->redis->expire($key,$expire);
    }

    /**
      * 返回一个key还有多久过期，单位秒
      * @param unknown $key
      */
    public function ttl($key)
    {
        return $this->redis->ttl($key);
    }

    public function expireAt($key,$time)
    {
        return $this->redis->expireAt($key,$time);
    }

    public function close()
    {
        return $this->redis->close();
    }

    /**
     * 关闭所有连接
     */
    public static function closeAll()
    {
        foreach(self::$_instance as $o)
        {
            if($o instanceof self)
                $o->close();
        }
    }

    public function dbSize()
    {
        return $this->redis->dbSize();
    }

    public function randomKey()
    {
        return $this->redis->randomKey();
    }

    /*********************事务的相关方法************************/

    /**
     * 监控key,就是一个或多个key添加一个乐观锁
     * 在此期间如果key的值如果发生的改变，刚不能为key设定值
     * 可以重新取得Key的值。
     * @param unknown $key
     */
    public function watch($key)
    {
        return $this->redis->watch($key);
    }

    /**
     * 取消当前链接对所有key的watch
     *  EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了
     */
    public function unwatch()
    {
        return $this->redis->unwatch();
    }

    /**
     * 开启一个事务
     * 事务的调用有两种模式Redis::MULTI和Redis::PIPELINE，
     * 默认是Redis::MULTI模式，
     * Redis::PIPELINE管道模式速度更快，但没有任何保证原子性有可能造成数据的丢失
     */
    public function multi($type=\Redis::MULTI)
    {
        return $this->redis->multi($type);
    }

    /**
     * 执行一个事务
     * 收到 EXEC 命令后进入事务执行，事务中任意命令执行失败，其余的命令依然被执行
     */
    public function exec()
    {
        return $this->redis->exec();
    }

    /**
     * 回滚一个事务
     */
    public function discard()
    {
        return $this->redis->discard();
    }
}
