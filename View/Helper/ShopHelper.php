<?php
App::uses('StringConvertor', 'Croogo.Lib/Utility');

class ShopHelper extends AppHelper{

    protected $_stringConverter = null;

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->_stringConverter = new StringConverter();
        $this->__setupEvent();
    }

    private function __setupEvent(){
        $eventManager = $this->_View->getEventManager();
        $eventManager->attach(array($this, 'filter'), 'Helper.Layout.beforeFilter', array(
            'passParams' => true
        ));
    }

    public function filter(&$content, $options = array()) {
        $productsBlks = $this->_stringConverter->parseString('products|p',$content);
        foreach($productsBlks as $alias => $options){
            $content = str_replace($content, $this->productList($alias, $options), $content);
        }
        if(empty($productsBlks)){
            $categoriesBlks = $this->_stringConverter->parseString('categories|c', $content);
            foreach($categoriesBlks as $alias => $options){
                $content = str_replace($content, $this->categoriesTreePanel($alias, $options), $content);
            }
        }
        return $content;
    }

    private function productList($alias, $options = array()) {
        $options = array_merge(array(
            'element' => 'Shop.block_product_list_body'
        ), $options);

        $output = $this->_View->element($options['element'], array(
            'alias' => $alias,
            'productList' => $this->_View->viewVars['products_for_layout'][$alias],
            'options' => $options
        ));
        return $output;
    }
    private function categoriesTreePanel($alias, $options = array()){
        $options = array_merge(array(
            'element' => 'Shop.categories_tree_panel'
        ), $options);
        $output = $this->_View->element($options['element'], array(
            'alias' => $alias,
            'categoriesTree' => $this->_View->viewVars['subCategories_tree_panel_for_layout'][$alias],
            'options' => $options
        ));
        return $output;
    }
}