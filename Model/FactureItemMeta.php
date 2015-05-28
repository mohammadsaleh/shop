<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * FactureItemMetum Model
 *
 * @property FactureItem $FactureItem
 * @property Property $Property
 */
class FactureItemMeta extends ShopAppModel {

    public $tablePrefix = '';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FactureItem' => array(
			'className' => 'Payment.FactureItem',
			'foreignKey' => 'facture_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Property' => array(
			'className' => 'Shop.Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
