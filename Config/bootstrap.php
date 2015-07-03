<?php
App::uses('Dropzone', 'Dropzone.Lib');
Dropzone::load('Shop.default');

Croogo::hookAdminTab('Products/admin_add', 'Properties', 'Shop.product_category_properties');
Croogo::hookAdminTab('Products/admin_edit', 'Properties', 'Shop.product_category_properties');

Croogo::hookAdminTab('Products/admin_add', 'Combinations', 'Shop.product_combinations');
Croogo::hookAdminTab('Products/admin_edit', 'Combinations', 'Shop.product_combinations');

Croogo::hookAdminRowAction('Categories/admin_index', __d('shop', 'Add Property'), 'admin:true/plugin:shop/controller:properties/action:add/:id');

Croogo::hookComponent('*', 'Shop.Shop');
Croogo::hookHelper('*', 'Shop.Shop');
Croogo::hookBehavior('FactureItem', 'Shop.Shop');

$Localization = new L10n();
Croogo::mergeConfig('Wysiwyg.actions', array(
    'Products/admin_edit' => array(
        array(
            'elements' => 'ProductDescription',
            'preset' => 'full',
            'language' => $Localization->map(Configure::read('Site.locale')),
        ),
    ),
));

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