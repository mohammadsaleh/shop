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
    /**
     * @param mixed $results
     * @param bool $primary
     * @return mixed
     */
    public function afterFind($results, $primary = false){
        foreach($results as &$result){
            $pictures = explode(',', $result['ProductCombination']['pictures']);
            if(!empty($pictures)){
                $result['ProductCombination']['pictures'] = array_fill_keys(explode(',', $result['ProductCombination']['pictures']), 1);
            }
        }
        return $results;
    }

}
