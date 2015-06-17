<?php
class ShopShortcodes{

    public function mostPopularProducts($options = null, $body = null, $shortcodeTag = null, $instance = null){
        $options = array_merge(array(
            'limit' => 4,
            'element' => 'Shop.latest_product_body'
        ), $options);
        $Product = ClassRegistry::init('Product');
        $Product->virtualFields = array('count_sells' => 'COUNT(FactureItem.id)');
        $productList = $Product->find('all', array(
            'joins' => array(
                array(
                    'table' => 'facture_items',
                    'alias' => 'FactureItem',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'FactureItem.model = "Product"',
                        'FactureItem.foreign_key = Product.id'
                    )
                ),
            ),
            'group' => array('Product.id HAVING COUNT(FactureItem.id) > 0'),
            'order' => array('count_sells DESC'),
            'limit' => $options['limit']
        ));
        $instance->set(compact('productList'));
//        return $instance->element($options['element'], compact('productList'));
    }

    public function parallax_image($options = null, $body = null, $shortcodeTag = null, $instance = null){
        $options = array_merge(array(
            'attachment_id' => null,
            'block_alias' => time()
        ), $options);
        if($options['attachment_id']){
            $Attachment = ClassRegistry::init('FileManager.Attachment');
            $image = $Attachment->find('first', array(
                'recursive' => -1,
                'fields' => array('Attachment.path'),
                'conditions' => array(
                    'Attachment.id' => $options['attachment_id'],
                    'Attachment.type' => 'attachment',
                )
            ));
            if(!empty($image)){
                $imagePath = $instance->request->webroot.$image['Attachment']['path'];
                $instance->set('parallaxImageUrl_'.$options['block_alias'], $imagePath);
            }
        }
    }

}