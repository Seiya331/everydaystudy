<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/11下午1:54
 */


/**
 * [意图]
 * 1. 保证一个类只有一个实例,并且提供一个访问它的全局访问点
 * 2. 它必须自行创建这个实例
 * 3. 必须自行向整个系统提供这个实例
 * [使用]
 * 1.php的应用主要用于数据库操作,所以一个应用会存在大量的数据库操作,如果使用单例模式,可以避免大量的new 操作消耗资源
 * 2.如果系统中需要一个类来全局控制某些配置信息,那么使用单例模式可以很方便的实现.
 * 3.再一次页面请求中,方便进行调试,因为所有的代码(数据库操作类db)都集中在一个类中,可以在类中设置钩子,输出日志,从而避免导出的var_dump echo
 *
 * **
 * 设计模式之单例模式
 * $_instance必须声明为静态的私有变量
 * 构造函数和析构函数必须声明为私有,防止外部程序new
 * 类从而失去单例模式的意义
 * getInstance()方法必须设置为公有的,必须调用此方法
 * 以返回实例的一个引用
 * ::操作符只能访问静态变量和静态函数
 * new对象都会消耗内存
 * 使用场景:最常用的地方是数据库连接。
 * 使用单例模式生成一个对象后，
 * 该对象可以被其它众多对象所使用。
 *
 */
class Singleton
{
    private static $_instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance(){
        if(!self::$_instance instanceof  self){
            self::$_instance = new self();
        }
        return  self::$_instance;
    }


}