<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * Category Model
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 * @property Product $Product
 */
class Category extends ShopAppModel {


    public $actsAs = array(
        'Tree'
    );
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentCategory' => array(
			'className' => 'Shop.Category',
			'foreignKey' => 'parent_id',
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
		'ChildCategory' => array(
			'className' => 'Shop.Category',
			'foreignKey' => 'parent_id',
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
		'Product' => array(
			'className' => 'Shop.Product',
			'foreignKey' => 'category_id',
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
        'Property' => array(
			'className' => 'Shop.Property',
			'foreignKey' => 'category_id',
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

	);

    /**
     * Get all properties of given category_id
     * @param null $categoryId
     * @return mixed
     */
    public function getCategoryProperties($categoryId = null, $selectableProperties = false){
        $allParentsCategoryId = $this->getPath($categoryId);
        $categoryIds = Set::extract('{n}.Category.id', $allParentsCategoryId);
        $this->Property->unbindModel(
            array('hasMany' => array('ProductMeta'))
        );
        $conditions = array('Property.category_id' => $categoryIds);
        if($selectableProperties){
            $conditions['Property.selectable_on_order'] = true;
        }
        $categoryProperties = $this->Property->find('all', array(
            'fields' => array('Property.*', 'Category.id', 'Category.title'),
            'conditions' => $conditions,
            'recursive' => 1
        ));
        return $categoryProperties;
    }

}
