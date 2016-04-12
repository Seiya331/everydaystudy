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
        $obj -> setColor('#f00');
        return $obj;
    }
}



