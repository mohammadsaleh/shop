<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * CombinationsProperty Model
 *
 * @property ProductCombination $ProductCombination
 * @property ProductMeta $ProductMeta
 */
class CombinationsProperty extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ProductCombination' => array(
			'className' => 'Shop.ProductCombination',
			'foreignKey' => 'product_combination_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProductMeta' => array(
			'className' => 'Shop.ProductMeta',
			'foreignKey' => 'product_meta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
