<?php
CroogoRouter::connect('/', array(
    'plugin' => 'shop',
    'controller' => 'products',
    'action' => 'index'
));
Router::promote();
CroogoRouter::connect('/users/users/edit/*', array(
    'plugin' => 'shop',
    'controller' => 'shop_users',
    'action' => 'edit'
));