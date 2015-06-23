<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * Property Model
 *
 * @property ProductMeta $ProductMeta
 * @property PropertyValue $PropertyValue
 */
class Property extends ShopAppModel {


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
        if($data['Property']['type'] != 'text'){
            $propertyValues = Set::extract('{n}.option', $data['PropertyValue']);
            $options = array_shift($propertyValues);
            $options = explode(',', $options);
            $data['PropertyValue'] = array_map(function($value){return ['option' => trim($value)];}, $options);
        }else{
            unset($data['PropertyValue']);
        }
        return parent::saveAssociated($data);
    }

    public function afterSave($created, $options = Array()){
        $this->PropertyValue->deleteAll(array('property_id' => $this->id));
    }

}
