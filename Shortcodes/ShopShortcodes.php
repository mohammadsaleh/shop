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
            'recursive' => -1,
            'fields' => array('Product.*', 'Attachment.path', 'count_sells'),
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
                array(
                    'table' => 'shop_products_attachments',
                    'alias' => 'ProductAttachment',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'ProductAttachment.product_id = Product.id',
                        'ProductAttachment.is_index = 1',
                    )
                ),
                array(
                    'table' => 'nodes',
                    'alias' => 'Attachment',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Attachment.id = ProductAttachment.attachment_id',
                    )
                )
            ),
            'group' => array('Product.id HAVING COUNT(FactureItem.id) > 0'),
            'order' => array('count_sells DESC'),
            'limit' => $options['limit']
        ));
        $instance->set(compact('productList'));
//        return $instance->element($options['element'], compact('productList'));
    }

}