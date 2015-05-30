<?php
CroogoRouter::connect('/', array(
    'plugin' => 'shop',
    'controller' => 'products',
    'action' => 'index'
));
Router::promote();