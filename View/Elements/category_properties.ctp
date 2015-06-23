<?php
if(!empty($categoryProperties)){
    $inputs = array();
    foreach($categoryProperties as $property){
        $inputs[$property['Category']['title']][] = $this->element('product_category_properties_'.$property['Property']['type'], compact('property'));;
    }
    foreach($inputs as $categoryTitle => $input){
        echo $this->Html->tag('fieldset',
            $this->Html->tag(
                'legend',
                __d('shop', 'Category')
                . ' ' . __d('shop', 'properties')
                . ' : ' . __d('shop', $categoryTitle),
                array('style' => 'font-weight:bold')
            ).
            implode('', $input)
        );
    }
}