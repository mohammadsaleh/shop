<?php
Croogo::hookComponent('*', 'Shop.Shop');
Croogo::hookHelper('*', 'Shop.Shop');
Croogo::hookBehavior('FactureItem', 'Shop.Shop');

CroogoNav::add('sidebar', 'shop', array(
    'title' => __d('shop', 'Shop Center'),
    'url' => '#',
    'icon' => array('shopping-cart', 'larg'),
    'weight' => '54',
    'children' => array(
        'categories' => array(
            'title' => __d('shop', 'Categories'),
            'url' => array(
                'admin' => true,
                'plugin' => 'shop',
                'controller' => 'categories',
                'action' => 'index'
            )
        ),
        'properties' => array(
            'title' => __d('shop', 'Category Properties'),
            'url' => array(
                'admin' => true,
                'plugin' => 'shop',
                'controller' => 'properties',
                'action' => 'index'
            )
        ),
        'products' => array(
            'title' => __d('shop', 'Products'),
            'url' => array(
                'admin' => true,
                'plugin' => 'shop',
                'controller' => 'products',
                'action' => 'index'
            )
        ),

    )
));