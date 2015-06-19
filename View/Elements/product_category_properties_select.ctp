<div class="pr pr-selectbox">
    <div class="title in-blc">
        <h5><?php echo $property['Property']['title']?> : </h5>
    </div>
    <div class="value in-blc">
        <div class="selectbox in-blc">
            <?php
                echo $this->Form->select(
                    'ProductMeta.property_'.$property['Property']['id'] ,
                    Set::combine($property['PropertyValue'], '{n}.id', '{n}.option'),
                    array(
                        'label' => false,
                        'div' => false,
                ));
            ?>
        </div>
    </div>
</div>