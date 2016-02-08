<?php
$selectOptions = Set::combine($property['PropertyValue'], '{n}.id', '{n}.option');
$productMeta = Set::combine($productMeta, '{n}.ProductMeta.property_value', '{n}.ProductMeta');
$productMetaIds = array_keys($productMeta);
//echo'<pre/>';print_r($productMetaIds);die;
?>
<div class="pr pr-colorbox">
    <div class="title in-blc">
        <h5><?php echo $property['Property']['title']?> : </h5>
    </div>
    <div class="value in-blc">
        <div class="colorbox in-blc">
            <fieldset id="attributes" class="attribute_fieldset">
                <div class="attribute_list">
                    <ul id="color_to_pick_list" class="clearfix">
                        <?php foreach($selectOptions as $propertyValueId => $optionValue): ?>
                            <li class="<?php if(array_search($propertyValueId, $productMetaIds))echo 'color-pick-selected'; ?>">
                                <a href="#" data-option-id="<?php echo $propertyValueId; ?>" class="color_pick" style="background: #<?php echo $optionValue; ?>"></a>
                                <input type="checkbox" <?php if(array_search($propertyValueId, $productMetaIds))echo 'checked'; ?> id="color_pick_hidden" class="color_pick_hidden" name="data[ProductMeta][property_<?php echo $property['Property']['id']; ?>][<?php echo $propertyValueId; ?>]" value="<?php echo $propertyValueId; ?>">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div> <!-- end attribute_list -->
            </fieldset>
        </div>
    </div>
</div>

<style>
    #attributes {
        padding-bottom: 12px;
        padding-top: 6px;
        border: none;
    }
    #attributes .attribute_list {
        display: inline-block;
        margin-top: 25px;
        margin-bottom: -15px;
    }
    #attributes .attribute_list #color_to_pick_list {
        list-style-type: none;
    }
    #attributes .attribute_list ul {
        clear: both;
    }
    #attributes .attribute_list #color_to_pick_list li {
        float: right;
        margin: 0 0 0 5px;
        padding: 0;
        display: block;
        overflow: hidden;
        height: 18px;
        width: 18px;
        clear: none;
        list-style: none;
    }
    #attributes .attribute_list #color_to_pick_list li a.color_pick {
        display: block;
        height: 18px;
        width: 18px;
        cursor: pointer;
    }
    .color-pick-selected{
        border: 2px solid #4c4c4c;
    }
</style>
<script>
    $(function(){
        $(".color_pick").on("click", function(e){
            e.preventDefault();
            var $this = $(this);
            var $input = $this.siblings("input");
            var $checked = $input.prop("checked");
            if($checked){
                $this.parents("li").removeClass("color-pick-selected");
                $input.prop("checked", false);
            }else{
                $this.parents("li").addClass("color-pick-selected");
                $input.prop("checked", true);
            }
        });
    });
</script>