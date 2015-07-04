<?php
/**
 * CombinationsPropertyFixture
 *
 */
class CombinationsPropertyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'product_combination_id' => array('type' => 'biginteger', 'null' => true, 'default' => null, 'unsigned' => false),
		'product_meta_id' => array('type' => 'biginteger', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '',
			'product_combination_id' => '',
			'product_meta_id' => ''
		),
	);

}
