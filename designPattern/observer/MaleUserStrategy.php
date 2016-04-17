<?php
/**
 * Created by PhpStorm.
 * User: guojiezhu
 * Date: 16/4/17下午8:22
 */

namespace observer;

class MaleUserStrategy implements UserStrgegy
{
    public function showAd()
    {
        // TODO: Implement showAd() method.
        echo 'IPHONE PLUS';
    }

    public function showCategory()
    {
        // TODO: Implement showCategory() method.
        echo '电子产品';
    }
}