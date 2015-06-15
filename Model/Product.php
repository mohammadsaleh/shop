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
            'unique' => true,
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
            foreach($data['ProductMeta'] as $key => $value){
                $propertyId = explode('_', $key);
                array_push($data['ProductMeta'], array(
                    'property_id' => $propertyId[1],
                    'property_value' => $value
                ));
                unset($data['ProductMeta'][$key]);
            }
        }
        //Process product images, using dropzone plugin
//        if(CakeSession::check('Attachments')){
//            $data['Attachment'] = CakeSession::read('Attachments');
//        }
        $result = parent::saveAssociated($data);
//        CakeSession::delete('Attachments');
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
                if($this->hasAnyProductMeta($result)){
                    foreach($result['ProductMeta'] as $key => $item){
                        $result['ProductMeta']['property_'.$item['property_id']] = $item['property_value'];
                        unset($result['ProductMeta'][$key]);
                    }
                }
            }
        }else{
            // set index image as path in Attachment array
            foreach($results as &$result){
                if(isset($result['Attachment'])){
                    foreach($result['Attachment'] as $attachment){
                        $result['Attachment']['path'] = '';
                        if($attachment['ShopProductsAttachment']['is_index']){
                            $result['Attachment']['path'] = $attachment['path'];
                            break;
                        }
                    }
                }
            }
        }
        return $results;
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
            $this->query($sql);
        }
    }
}
