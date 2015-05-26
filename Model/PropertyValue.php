<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * PropertyValue Model
 *
 * @property Property $Property
 */
class PropertyValue extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Property' => array(
			'className' => 'Shop.Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
