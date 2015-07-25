<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * Property Model
 *
 * @property ProductMeta $ProductMeta
 * @property PropertyValue $PropertyValue
 */
class Property extends ShopAppModel {

    private $__existPropertyValuesIds = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Shop.Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ProductMeta' => array(
			'className' => 'Shop.ProductMeta',
			'foreignKey' => 'property_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PropertyValue' => array(
			'className' => 'Shop.PropertyValue',
			'foreignKey' => 'property_id',
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

    public function beforeSave($options = array()){
        if(isset($this->data['Property']['searchable'])){
            $this->data['Property']['searchable'] = !!$this->data['Property']['searchable'];
        }
        if(isset($this->data['Property']['hidden'])){
            $this->data['Property']['hidden'] = !!$this->data['Property']['hidden'];
        }
        if(isset($this->data['Property']['selectable_on_order'])){
            $this->data['Property']['selectable_on_order']= !!$this->data['Property']['selectable_on_order'];
        }
        return true;
    }

    public function saveAssociated($data = NULL, $options = Array()){
        $propertyValues = array();
        if($data['Property']['type'] != 'text'){
            $propertyValues = Set::extract('{n}.option', $data['PropertyValue']);
            $propertyValues = array_shift($propertyValues);
            $propertyValues = explode(',', str_replace('،', ',', $propertyValues));
            $data['PropertyValue'] = array_map(function($value){return ['option' => trim($value)];}, $propertyValues);
        }else{
            unset($data['PropertyValue']); //?
        }
        if(isset($data['Property']['id']) && !empty($propertyValues)){
            $this->__processExistPropertyValues($data, $propertyValues);
        }
        return parent::saveAssociated($data);
    }

    private function __processExistPropertyValues(&$data, $propertyValues = array()){
        $existPropertyValues = $this->PropertyValue->find('all', array(
            'recursive' => -1,
            'fields' => array('id', 'option'),
            'conditions' => array(
                'property_id' => $data['Property']['id'],
                'option' => $propertyValues
            )
        ));
        $existPropertyValues = Set::combine($existPropertyValues, '{n}.PropertyValue.id', '{n}.PropertyValue.option');
        foreach($data['PropertyValue'] as $key => $propertyValue){
            if(in_array($propertyValue['option'], $existPropertyValues)){
                unset($data['PropertyValue'][$key]);
            }
        }
        $this->__existPropertyValuesIds = array_keys($existPropertyValues);
    }

    public function afterSave($created, $options = Array()){
        $this->PropertyValue->deleteAll(array(
            'PropertyValue.property_id' => $this->id,
            'NOT' => array(
                'PropertyValue.id' => $this->__existPropertyValuesIds
            )
        ));
    }

}
