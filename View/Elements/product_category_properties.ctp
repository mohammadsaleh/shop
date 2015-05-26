<?php
if(!empty($categoryProperties)){
    $inputs = array();
    foreach($categoryProperties as $property){
        $inputs[$property['Category']['title']][] = $this->Form->input('ProductMeta.property_'.$property['Property']['id'] , array(
            'label' => $property['Property']['title'],
            'type' => $property['Property']['type'],
            'options' => Set::extract('{n}.option', $property['PropertyValue']),
            'div' => array(
                'style' => 'width:50%'
            ),
            'legend' => $property['Property']['title']
        ));
    }
    foreach($inputs as $categoryTitle => $input){
        echo $this->Html->tag('fieldset',
            $this->Html->tag('legend', __d('shop', $categoryTitle).': ', array('style' => 'font-weight:bold')).
            implode('', $input)
        );
    }
}