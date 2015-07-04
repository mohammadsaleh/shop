<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ProductCombination Model
 *
 * @property CombinationsProperty $CombinationsProperty
 */
class ProductCombination extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CombinationsProperty' => array(
			'className' => 'Shop.CombinationsProperty',
			'foreignKey' => 'product_combination_id',
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
	);

}
