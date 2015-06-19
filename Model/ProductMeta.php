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
		),

	);

    public function afterFind($results, $primary = false){
        foreach($results as &$result){
            if(isset($result['ProductMeta']['property_id'])){
                $propertyInfo = $this->__getPropertyInfo($result['ProductMeta']['property_id']);
                $propertyValueInfo = $this->__getPropertyValue($propertyInfo['type'], $result['ProductMeta']['property_value']);
                if(!$propertyValueInfo){
                    $propertyValueInfo = $result['ProductMeta']['property_value'];
                }
                $result['ProductMeta']['Property'] = $propertyInfo;
                $result['ProductMeta']['Property']['value'] = $propertyValueInfo;
            }else{
                $result['ProductMeta']['Property'] = array();
            }
        }
        return $results;
    }

    private function __getPropertyInfo($propertyId = null){
        $propertyInfo = $this->Property->find('first', array(
            'recursive' => -1,
            'conditions' => array('Property.id' => $propertyId)
        ));
        return array_shift($propertyInfo);
    }

    private function __getPropertyValue($propertyType, $propertyValueId){
        if(in_array($propertyType, array('select','radio','checkbox'))){
            $propertyValueInfo = $this->Property->PropertyValue->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'PropertyValue.id' => $propertyValueId,
                ),
            ));
            $propertyValueInfo = array_shift($propertyValueInfo);
            return $propertyValueInfo['option'];
        }
        return null;
    }
}
