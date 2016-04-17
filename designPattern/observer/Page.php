<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/17下午8:24
 */

class Page
{
    protected $strategy = null;
    public function setStrategy($obj_strategy)
    {
        $this->strategy =  $obj_strategy;
    }

    public function Index(){
        $this->strategy->showAd();
        $this->strategy->showCategory();
    }
}