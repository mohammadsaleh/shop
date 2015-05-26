<?php
App::uses('FactureItemMetum', 'Shop.Model');

/**
 * FactureItemMetum Test Case
 *
 */
class FactureItemMetumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.facture_item_metum',
		'plugin.shop.facture_item',
		'plugin.shop.property'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactureItemMetum = ClassRegistry::init('Shop.FactureItemMetum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactureItemMetum);

		parent::tearDown();
	}

}
