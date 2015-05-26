<?php
App::uses('PropertyValue', 'Shop.Model');

/**
 * PropertyValue Test Case
 *
 */
class PropertyValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.property_value',
		'plugin.shop.property',
		'plugin.shop.product_metum',
		'plugin.shop.product',
		'plugin.shop.category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PropertyValue = ClassRegistry::init('Shop.PropertyValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PropertyValue);

		parent::tearDown();
	}

}
