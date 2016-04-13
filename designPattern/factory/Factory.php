<?php

/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/12下午5:40
 */
abstract class FactoryMethod
{
    const CHEAP = 1;
    const FAST = 2;

    abstract protected function createVehicle($type);

    public function create($type)
    {
        $obj = $this->createVehicle($type);
        $obj->setColor('#f00');
        return $obj;
    }
}


class ItalianFactory extends FactoryMethod
{
    protected function createVehicle($type)
    {
        // TODO: Implement createVehicle() method.
        switch ($type) {
            case parent::CHEAP:
                return new Bicycle();
                break;
            case parent::FAST:
                return new Ferrari();
                break;
            default:
                throw new \InvalidArgumentException("$type is not a valid vehicle");
        }
    }
}

class GermanFactory extends FactoryMethod
{
    protected function createVehicle($type)
    {
        switch ($type) {
            case parent::CHEAP:
                return new Bicycle();
                break;
            case parent::FAST:
                $obj = new Porsche();
                $obj->addTuningAMG();
                return $obj;
                break;
            default:
                throw new \InvalidArgumentException("$type is not a valid vehicle");
        }
    }
}


interface VehicleInterface
{
    public function setColor($rgb);
}

class Porsche implements VehicleInterface
{
    protected $color;

    public function setColor($rgb)
    {
        // TODO: Implement setColor() method.
    }

    public function addTuningAMG()
    {
    }
}

class Bicycle implements VehicleInterface
{
    protected $color;

    public function setColor($rgb)
    {
        // TODO: Implement setColor() method.
        $this->color = $rgb;
    }
}

class Ferrari implements VehicleInterface
{
    protected $color;

    public function setColor($rgb)
    {
        // TODO: Implement setColor() method.
        $this->color = $rgb;
    }
}