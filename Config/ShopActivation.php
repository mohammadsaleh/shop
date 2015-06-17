<?php
class ShopActivation{

    public $regions = array(
        'index_product_center' => 'index_product_center',
        'category_page' => 'category_page',
        'category_side_panel' => 'category_side_panel',
        'index_top_slider' => 'index_top_slider',
    );
    public $blocks = array();

    public function beforeActivation(&$controller) {
        return true;
    }
    public function onActivation(Controller $controller) {
        $this->addPermissions($controller);
        $this->addRegions();
        $this->addBlocks();
        return true;
    }
    public function beforeDeactivation(&$controller) {
        return true;
    }
    //----------------------------------------------------------
    public function onDeactivation(Controller $controller) {
        $controller->Croogo->removeAco('Shop');
        $this->removeBlocks();
        $this->removeRegions();
        return true;
    }


    public function addRegions(){
        $Region = ClassRegistry::init('Blocks.Region');
        foreach($this->regions as $alias => $title){
            $Region->Create();
            $Region->save(array(
                'Region' => array(
                    'title' => $title,
                    'alias' => $alias
                )
            ));
            $this->regions[$alias] = $Region->id;
        }
    }
    public function addBlocks(){
        $Block = ClassRegistry::init('Blocks.Block');
        $blocks = $this->getBlocks();
        $Block->create();
        $Block->saveAll($blocks);
    }
    public function addPermissions(&$controller){
        $controller->Croogo->addAco('Shop/Products/index', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Products/view', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Products/add_to_cart', array('admin', 'registered', 'public'));
        $controller->Croogo->addAco('Shop/Categories/index', array('admin', 'registered', 'public'));
    }
    
    public function removeBlocks(){
        $Block = ClassRegistry::init('Blocks.Block');
        $blocks = $this->getBlocks();
        $ids = array();
        foreach($blocks as $block){
            $result = $Block->findByAlias($block['Block']['alias'], array('id'));
            if(!empty($result)){
                array_push($ids, $result['Block']['id']);
            }
        }
        if(!empty($ids)){
            $Block->deleteAll(array('Block.id' => $ids));
        }
    }
    public function removeRegions(){
        $Region = ClassRegistry::init('Blocks.Region');
        $aliases = array_keys($this->regions);
        $Region->deleteAll(array('Region.alias' => $aliases));
    }

    public function getBlocks(){
        return array(
            array(
                'Block' => array(
                    'region_id' => $this->regions['index_product_center'],
                    'title' => 'پرفروش ترین محصولات',
                    'alias' => 'most_popular',
                    'body' => '[Shop.mostPopularProducts limit="4"][element:carousel_product_body]',
                    'element' => 'Shop.carousel_product_element',
                    'params' => 'enclosure=false',
                    'show_title' => 1,
                    'status' => 1,
                    'visibility_roles' => '',
                )
            ),
            array(
                'Block' => array(
                    'region_id' => $this->regions['index_product_center'],
                    'title' => 'جدیدترین محصولات',
                    'alias' => 'latest_products',
                    'body' => '[p:lastest_product_index order="Product.id DESC" limit="4" element="Shop.carousel_product_body" options1="1254"]',
                    'element' => 'Shop.carousel_product_element',
                    'params' => 'enclosure=false',
                    'show_title' => 1,
                    'status' => 1,
                    'visibility_roles' => '',
                )
            ),
            array(
                'Block' => array(
                    'region_id' => $this->regions['index_top_slider'],
                    'title' => 'اسلایدر',
                    'alias' => 'tshop_slider',
                    'body' => '[AparnicSlider:tshop_slider slug="tshop_slider"]',
                    'element' => 'AparnicSlider.element_empty',
                    'params' => 'enclosure=false',
                    'show_title' => 0,
                    'status' => 1,
                    'visibility_roles' => '',
                )
            ),
        );
    }
}