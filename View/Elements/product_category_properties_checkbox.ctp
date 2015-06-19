<div class="pr pr-checkbox">
    <div class="title in-blc">
        <h5><?php echo $property['Property']['title']?> : </h5>
    </div>
    <div class="value in-blc">
    <?php
    foreach($property['PropertyValue'] as $propertyValue){
    ?>
        <div class="checkbox in-blc">
            <?php
            echo $this->Form->checkbox(
                'ProductMeta.property_'.$propertyValue['property_id'].'.'.$propertyValue['id'],
                array(
                    'hiddenField' => false
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
