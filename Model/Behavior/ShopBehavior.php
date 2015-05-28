<?php
App::uses('ModelBehavior', 'Model');
class ShopBehavior extends ModelBehavior{

    public function setup(Model $model, $config = array()){
        $model->bindModel(array(
            'hasMany' => array(
                'FactureItemMeta' => array(
                    'className' => 'Shop.FactureItemMeta',
                    'foreignKey' => 'facture_item_id',
                    'dependent' => false,
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'limit' => '',
                    'offset' => '',
                    'exclusive' => '',
                    'finderQuery' => '',
                    'counterQuery' => ''
                )
            )
        ), false);
    }
}