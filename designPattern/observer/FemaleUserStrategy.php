<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/17下午8:16
 */

namespace observer;

class FemaleUserStrategy implements UserStrgegy
{
    public function showAd()
    {
        // TODO: Implement showAd() method.
        echo '2016年女新款';
    }

    public function showCategory()
    {
        // TODO: Implement showCategory() method.
        echo '2016年女新款';
    }
}