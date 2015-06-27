<?php
CroogoRouter::connect('/', array(
    'plugin' => 'shop',
    'controller' => 'products',
    'action' => 'index'
));
Router::promote();
CroogoRouter::connect('/register', array(
    'plugin' => 'shop',
    'controller' => 'shop_users',
    'action' => 'add'
));
CroogoRouter::connect('/users/users/edit/*', array(
    'plugin' => 'shop',
    'controller' => 'shop_users',
    'action' => 'edit'
));
CroogoRouter::connect('/users/users/add/*', array(
    'plugin' => 'shop',
    'controller' => 'shop_users',
    'action' => 'add',
));
CroogoRouter::connect('/users/users/login/*', array(
    'plugin' => 'shop',
    'controller' => 'shop_users',
    'action' => 'login',
));


CroogoRouter::connect(
    '/shop/category/:id/*',
    array(
        'plugin' => 'shop',
        'controller' => 'categories',
        'action' => 'index',
    ),
    array(
        'id' => '[0-9]+',
        'pass' => array('id')
    )
);
