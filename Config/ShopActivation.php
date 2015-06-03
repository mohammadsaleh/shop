<?php
class ShopActivation{

    public function beforeActivation(&$controller) {
        return true;
    }
    public function onActivation(Controller $controller) {
        // Add acl
        $controller->Croogo->addAco('Shop/Products/index', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Products/view', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Products/add_to_cart', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Categories/index', array('admin', 'registered', 'public'));

        $Block = ClassRegistry::init('Blocks.Block');
        $Block->create();
        $data = array(
            array(
                'Block' => array(
                    'region_id' => '4',
                    'title' => 'پرفروش ترین محصولات تست',
                    'alias' => 'most_popular',
                    'body' => '[Shop.mostPopularProducts limit="4"][element:latest_products_body]',
                    'element' => 'Shop.latest_products_element',
                    'params' => 'enclosure=false',
                    'show_title' => 1,
                    'status' => 1,
                )
            ),
            array(
                'Block' => array(
                    'region_id' => '4',
                    'title' => 'جدیدترین محصولات',
                    'alias' => 'latest_products',
                    'body' => '[p:lastest_product_index order="Product.id DESC" limit="4" element="Shop.latest_products_body" options1="1254"]',
                    'element' => 'Shop.latest_products_element',
                    'params' => 'enclosure=false',
                    'show_title' => 1,
                    'status' => 1,
                )
            )
        );
        $Block->saveAll($data);
        return true;
    }
    public function beforeDeactivation(&$controller) {
        return true;
    }
    //----------------------------------------------------------
    public function onDeactivation(Controller $controller) {
        // Remove acl
        $controller->Croogo->removeAco('Shop');

        $Block = ClassRegistry::init('Blocks.Block');
        $block1 = $Block->findByAlias('most_popular', array('id'));
        $block2 = $Block->findByAlias('latest_products', array('id'));
        $ids = array();
        if(!empty($block1)){
            array_push($ids, $block1['Block']['id']);
        }
        if(!empty($block2)){
            array_push($ids, $block2['Block']['id']);
        }
        if(!empty($ids)){
            $Block->deleteAll(array('Block.id' => $ids));
        }
        return true;
    }
}