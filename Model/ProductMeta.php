<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ProductMeta Model
 *
 * @property Product $Product
 * @property Property $Property
 */
class ProductMeta extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Product' => array(
			'className' => 'Shop.Product',
			'foreignKey' => 'product_id',
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

    public function afterFind($results, $primary = false){
        foreach($results as &$result){
            if(isset($result['ProductMeta']['property_id'])){
                $propertyInfo = $this->Property->find('first', array(
                    'recursive' => -1,
                    'conditions' => array('Property.id' => $result['ProductMeta']['property_id'])
                ));
                $result['ProductMeta']['Property'] = array_shift($propertyInfo);
            }else{
                $result['ProductMeta']['Property'] = array();
            }
        }
        return $results;
    }

}
