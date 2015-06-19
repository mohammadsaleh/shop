<style>
    .in-blc{
        display: inline-block
    }
    .pr .title{
        min-width: 100px;
    }
    .pr .value{
        width: 80%;
    }
    .pr-checkbox .checkbox{
        margin-left: 15px;
    }
    .pr-selectbox .selectbox{
        vertical-align: sub;
        margin-left: 15px;
    }
    .pr-radio .radio{
        vertical-align: sub;
        margin-left: 15px;
    }

</style>
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