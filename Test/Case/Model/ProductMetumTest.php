<?php
App::uses('ProductMetum', 'Shop.Model');

/**
 * ProductMetum Test Case
 *
 */
class ProductMetumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.product_metum',
		'plugin.shop.product',
		'plugin.shop.property'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductMetum = ClassRegistry::init('Shop.ProductMetum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductMetum);

		parent::tearDown();
	}

}
