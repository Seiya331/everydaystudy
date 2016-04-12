<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/12下午4:18
 */

/**
 * 简单工厂方法
 * 目的:
 * 简单的创建对象工厂模式
 * 和静态工厂模式不同,简单工厂是非静态的
 * 使用工厂的多个实例,通过传递参数使他们各不相同,你可以通过集成扩展工厂来改变工厂的行为,并用它来创建测试时会用到的模拟对象
 *
 */

class SimpleFactory
{
    protected $typeList;
    public function __construct()
    {
        $this->typeList = array(
            'bicycle' => 'Bicycle',
            'other' => 'Scooter'
        );
    }
    public function createVehicle($type)
    {
        if(!array_key_exists($type,$this->typeList))
        {
            throw new \InvalidArgumentException("$type is not valid vehicle");
        }

        $className = $this->typeList[$type];
        return new $className;
    }
}


interface VehicleInterface
{
    public function driveTo($destination);
}

class Bicycle implements VehicleInterface
{
    public function driveTo($destination)
    {
        echo 'bicycle to '.$destination;
    }
}

class Scooter implements VehicleInterface
{
    public function driveTo($destination)
    {
        // TODO: Implement driveTo() method.
        echo 'scooter to '.$destination;
    }
}



$factory = new SimpleFactory();

$bicycle = $factory->createVehicle('bicycle');

$bicycle ->driveTo('Paris');