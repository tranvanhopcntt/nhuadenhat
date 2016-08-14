<?php

namespace Application\Utility;

class Utility
{
    public function getMenus($controllerName)
    {
        $menus = array(
            'Home' => array(
                'classActive' => '',
                'class' => 'item-435',
                'name' => 'Home'
            ),
            'Introduction' => array(
                'classActive' => '',
                'class' => 'item-586',
                'name' => 'Introduction'
            ),
            'Product' => array(
                'classActive' => '',
                'class' => 'item-587',
                'name' => 'Product'
            ),
            'News' => array(
                'classActive' => '',
                'class' => 'item-588',
                'name' => 'News'
            ),
            'Project' => array(
                'classActive' => '',
                'class' => 'item-589',
                'name' => 'Project'
            ),
            'Network' => array(
                'classActive' => '',
                'class' => 'item-590',
                'name' => 'Network'
            ),
            'Quotes' => array(
                'classActive' => '',
                'class' => 'item-591',
                'name' => 'Quotes'
            ),
        );

        if(isset($menus[$controllerName]))
            $menus[$controllerName]['classActive'] = 'current active';

        return $menus;
    }
}