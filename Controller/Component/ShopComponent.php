<?php
App::uses('Component', 'Controller');
App::uses('StringConverter', 'Croogo.Lib/Utility');

class ShopComponent extends Component{

    private $__controller = null;
    private $__stringConverter = null;
    private $__productsForLayout = array();

    public function initialize(Controller $controller){
        $this->__controller = $controller;
        $this->__stringConverter = new StringConverter();
    }

    public function startup(Controller $controller){
        if (!isset($controller->request->params['admin']) && !isset($controller->request->params['requested'])) {
            $this->__processBlocksData();
        }
    }

    private function __processBlocksData(){
        $blocksForLayouts = $this->__controller->Blocks->blocksForLayout;
        foreach($blocksForLayouts as $region => $blocks){
            foreach($blocks as $block){
                $this->__productsForLayout = Hash::merge(
                    $this->__productsForLayout,
                    $this->__stringConverter->parseString('products|p',
                        $block['Block']['body'],
                        array('convertOptionsToArray' => true)
                    )
                );
            }
        }

        $_productOptions = array(
            'find' => 'all',
            'conditions' => array(),
            'order' => 'Product.id ASC',
            'limit' => 10,
        );
        $Product = ClassRegistry::init('Shop.Product');
        foreach($this->__productsForLayout as $alias => &$options){
            $options = Hash::merge($_productOptions, $options);
            $options['limit'] = str_replace('"', '', $options['limit']);
            $options = $Product->find($options['find'], array(
                'conditions' => $options['conditions'],
                'order' => $options['order'],
                'limit' => $options['limit'],
            ));
        }
    }

    public function beforeRender(Controller $controller){
        if(!empty($this->__productsForLayout)){
            $this->__controller->set('products_for_layout', $this->__productsForLayout);
        }
        if (!isset($controller->request->params['admin'])) {
            $Product = ClassRegistry::init('Shop.Product');
            $categories_for_layout = $Product->Category->generateTreeList();
            $this->__controller->set('categories_for_layout', $categories_for_layout);
        }
    }
}