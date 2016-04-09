<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/9上午11:11
 */


spl_autoload_register('autoload');


function autoload($class){
    $true_class = './'.$class.'.php';
    if(file_exists($true_class)){
        include_once $true_class;
    }
}