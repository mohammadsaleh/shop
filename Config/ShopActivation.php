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
        return true;
    }
    public function beforeDeactivation(&$controller) {
        return true;
    }
    //----------------------------------------------------------
    public function onDeactivation(Controller $controller) {
        // Remove acl
        $controller->Croogo->removeAco('Shop');
        return true;
    }
}