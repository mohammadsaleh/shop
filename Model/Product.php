<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * Product Model
 *
 * @property Category $Category
 * @property ProductMeta $ProductMeta
 */
class Product extends ShopAppModel {


    private $__hasProductMeta = false;

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
			'foreignKey' => 'product_id',
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
    public $hasAndBelongsToMany = array(
        'Attachment' => array(
            'className' => 'Nodes.Node',
            'joinTable' => 'shop_products_attachments',
            'foreignKey' => 'product_id',
            'associationForeignKey' => 'attachment_id',
            'unique' => false,
            'conditions' => '',
            'fields' => 'id, title, slug, mime_type, path, type',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function saveAssociated($data = NULL, $options = Array()){
        if($this->hasAnyProductMeta($data)){
            $this->__hasProductMeta = true;
            foreach($data['ProductMeta'] as $key => $values){
                $propertyId = explode('_', $key);
                if(is_array($values)){
                    foreach($values as $value => $isSet){
                        array_push($data['ProductMeta'], array(
                            'ProductMeta' => array(
                                'property_id' => $propertyId[1],
                                'property_value' => $value
                            )
                        ));
                    }
                }else{
                    $value = $values;
                    array_push($data['ProductMeta'], array(
                        'property_id' => $propertyId[1],
                        'property_value' => $value
                    ));
                }

                unset($data['ProductMeta'][$key]);
            }
        }
        $this->__deleteAttachment($data);
        $result = parent::saveAssociated($data);
        return $result;
    }

    public function afterSave($created, $options = Array()){
        if($this->__hasProductMeta){
            $this->ProductMeta->deleteAll(array('product_id' => $this->id));
        }
    }

    /**
     * Check if product has any another field ( product meta )
     * @param array $data
     * @return bool
     */
    public function hasAnyProductMeta($data = array()){
        return isset($data['ProductMeta']) && !empty($data['ProductMeta']);
    }

    /**
     * @param mixed $results
     * @param bool $primary
     * @return mixed
     */
    public function afterFind($results, $primary = false){
        //check if in admin then reformat PropertyMeta values
        $request = Router::getRequest();
        if(isset($request->params['admin']) && $request->params['admin']){
            foreach($results as &$result){
                $result['Combinations'] = array();
                if($this->hasAnyProductMeta($result)){
                    foreach($result['ProductMeta'] as $key => $item){
                        if($item['Property']['type'] == 'checkbox'){
                            $result['ProductMeta']['property_'.$item['property_id']][$item['property_value']] = true;
                        }else{
                            $result['ProductMeta']['property_'.$item['property_id']] = $item['property_value'];
                        }
                        unset($result['ProductMeta'][$key]);
                    }
                }
                $result['Combinations'] = $this->__getCombinations($result['Product']['id']);
            }
        }else{
            // set index image as path in Attachment array
            foreach($results as &$result){
                $result['Combinations'] = array();
                if(isset($result['Attachment']) && !empty($result['Attachment'])){
                    $attachments = $result['Attachment'];
                    $result['Attachment']['path'] = $result['Attachment'][0]['path'];
                    foreach($attachments as $attachment){
                        if($attachment['ShopProductsAttachment']['is_index']){
                            $result['Attachment']['path'] = $attachment['path'];
                            break;
                        }
                    }
                }
                $result['Combinations'] = $this->__getCombinations($result['Product']['id']);
                $combinations = [];
                foreach($result['Combinations'] as $combination){
                    $key = $combination['ProductCombination']['id'];
                    if(!isset($combinations[$key])){
                        $combinations[$key] = $combination['ProductCombination'];
                    }
                    $property = $combination['Property'];
                    $property['uniqueId'] = $combination['PropertyValue']['id'];
                    $property['PropertyValue'] = $combination['PropertyValue']['option'];
                    $combinations[$key]['Properties'][] = $property;
                }
                $result['Combinations'] = $combinations;
            }
        }
        return $results;
    }

    private function __getCombinations($productId = null){
        $combinations = $this->ProductMeta->CombinationsProperty->find('all', array(
            'recursive' => -1,
            'fields' => array(
                'ProductCombination.*',
                'PropertyValue.id',
                'PropertyValue.option',
                'Property.id',
                'Property.name',
                'Property.title',
                'Property.type',
            ),
            'conditions' => array('ProductMeta.product_id' => $productId),
            'joins' => array(
                array(
                    'table' => 'shop_product_metas',
                    'alias' => 'ProductMeta',
                    'type' => 'LEFT',
                    'conditions' => array('CombinationsProperty.product_meta_id = ProductMeta.id'),
                ),
                array(
                    'table' => 'shop_product_combinations',
                    'alias' => 'ProductCombination',
                    'type' => 'LEFT',
                    'conditions' => array('ProductCombination.id = CombinationsProperty.product_combination_id'),
                ),
                array(
                    'table' => 'shop_properties',
                    'alias' => 'Property',
                    'type' => 'LEFT',
                    'conditions' => array('Property.id = ProductMeta.property_id'),
                ),
                array(
                    'table' => 'shop_property_values',
                    'alias' => 'PropertyValue',
                    'type' => 'LEFT',
                    'conditions' => array('PropertyValue.id = ProductMeta.property_value'),
                ),
            )
        ));
        return $combinations;
    }
    private function __deleteAttachment(&$data = array()){
        if(isset($data['Attachment'])){
            $attachmentIds = $data['Attachment'];
            if(isset($data['Product']['id']) && !empty($data['Product']['id'])){
                $sql = '
                    DELETE FROM '.$this->hasAndBelongsToMany['Attachment']['joinTable'].'
                    WHERE
                        product_id = '.$data['Product']['id'].'
                        AND attachment_id NOT IN ('. implode(',', $attachmentIds) .')
                ';
                $this->query($sql);
                $sql = '
                    SELECT attachment_id
                    FROM '.$this->hasAndBelongsToMany['Attachment']['joinTable'].'
                    WHERE
                        product_id = '.$data['Product']['id'].'
                ';
                $attachmentIds = $this->query($sql);
                $attachmentIds = Set::extract('/shop_products_attachments/attachment_id', $attachmentIds);
                $data['Attachment'] = array_diff($data['Attachment'], $attachmentIds);
            }
        }
    }
    public function update_attachment($data = array(), $where = array()){
        if(!empty($data)){
            $setValues = array();
            $whereValues = array();
            foreach($data as $key => $value){
                $setValues[] = $key . ' = ' . $value;
            }
            foreach($where as $key => $value){
                $whereValues[] = $key . ' = ' . $value;
            }
            $sql = '
                UPDATE '.$this->hasAndBelongsToMany['Attachment']['joinTable'].'
                SET '. implode(',', $setValues) .'
                WHERE '. implode(' AND ', $whereValues) .'
           ';
            return $this->query($sql);
        }
        return false;
    }
    public function insert_attachmet($productId, $attachmentId){
        $sql = '
            SELECT id
            FROM '.$this->hasAndBelongsToMany['Attachment']['joinTable'].'
            WHERE
                product_id = '.$productId.'
                AND attachment_id = '.$attachmentId.'
        ';
        $result = $this->query($sql);
        if(empty($result)){
            $sql = '
                INSERT INTO '.$this->hasAndBelongsToMany['Attachment']['joinTable'].'
                (product_id, attachment_id)
                VALUES ('.$productId.', '.$attachmentId.')
            ';
            $this->query($sql);
        }
        return true;
    }
}
