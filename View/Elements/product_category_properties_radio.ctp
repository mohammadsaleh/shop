<div class="pr pr-radio">
    <div class="title in-blc">
        <h5><?php echo $property['Property']['title']?> : </h5>
    </div>
    <div class="value in-blc">
    <?php
    foreach($property['PropertyValue'] as $propertyValue){
    ?>
        <div class="radio in-blc">
            <?php
            echo $this->Form->radio(
                'ProductMeta.property_'.$propertyValue['property_id'],
                array($propertyValue['id'] => ''),
                array(
                    'label' => false
                )
            );
            ?>
            <label for=""><?php echo $propertyValue['option']?></label>
        </div>
    <?php
    }
    ?>
    </div>
</div>
