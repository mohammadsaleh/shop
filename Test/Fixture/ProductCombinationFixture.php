<?php
/**
 * ProductCombinationFixture
 *
 */
class ProductCombinationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'inc_price' => array('type' => 'float', 'null' => true, 'default' => '0', 'unsigned' => false),
		'inc_weight' => array('type' => 'float', 'null' => true, 'default' => '0', 'unsigned' => false),
		'number' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'publish_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'default' => array('type' => 'text', 'null' => true, 'default' => 'b\'0\'', 'length' => 1),
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
			'inc_price' => 1,
			'inc_weight' => 1,
			'number' => 1,
			'publish_date' => '2015-07-04 21:25:49',
			'default' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
