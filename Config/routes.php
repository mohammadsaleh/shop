<?php
CroogoRouter::connect('/', array(
    'plugin' => 'shop',
    'controller' => 'products',
    'action' => 'index'
));
Router::promote();

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
