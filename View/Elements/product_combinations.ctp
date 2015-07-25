<?php
//debug($this->request->data);die;
$combinationProperties = array();
echo $this->Form->input('ProductCombination.id');
foreach($categoryProperties as $property){
    if(($property['Property']['type'] === 'checkbox') && $property['Property']['selectable_on_order']){
        $combinationProperties[] = $property;
    }
}
$propertiesLables = Set::combine($combinationProperties, '{n}.Property.id', '{n}.Property.title');
echo $this->Form->input('combinationLabel', array(
    'name' => false,
    'label' => __d('shop', 'Property Name'),
    'options' => $propertiesLables,
    'div' => array(
        'style' => 'width:35%;display:inline-block'
    )
));

$totalPropertyValueOptions = array();
foreach($combinationProperties as $property){
    $propertyValueOptions = array();
    if(isset($this->request->data['ProductMeta']['property_'.$property['Property']['id']])){
        $productCombinationPropertyValueIds = array_keys($this->request->data['ProductMeta']['property_'.$property['Property']['id']]);
        $propertyValueOptions = Set::combine($property['PropertyValue'], '{n}.id', '{n}.option');

        foreach($propertyValueOptions as $key => $option){
            if(!in_array($key, $productCombinationPropertyValueIds)){
                unset($propertyValueOptions[$key]);
            }else{
                $propertyValueOptions[] = array(
                    'name' => $option,
                    'value' => $property['Property']['id'].'-'.$key,
                    'class' => 'pr-'.$property['Property']['id']
                );
                unset($propertyValueOptions[$key]);
            }
        }
        $totalPropertyValueOptions = $totalPropertyValueOptions + $propertyValueOptions;
    }
}
echo $this->Form->input('combinationValues', array(
    'name' => false,
    'label' => __d('shop', 'Property Values'),
    'options' => $totalPropertyValueOptions,
    'div' => array(
        'style' => 'width:30%;display:inline-block'
    )
));
echo $this->Form->button('<i class="icon-plus"></i>', array(
    'type' => 'button',
    'name' => false,
    'id' => 'add-combination',
    'class' => 'btn-success',
));
?>
<div style="position: relative">
<?php
echo $this->Form->input('ProductCombination.combinations', array(
    'label' => false,
    'options' => (isset($this->request->data['ProductCombination']['combinations'])) ? $this->request->data['ProductCombination']['combinations'] : array(),
    'multiple' => 'multiple',
    'hiddenField' => false,
    'div' => array(
        'style' => 'width:67.5%;display:inline-block;margin-right: 10px;',
    )
));
echo $this->Form->button('<i class="icon-minus"></i>', array(
    'name' => false,
    'id' => 'delete-combination',
    'class' => 'btn-danger',
    'type' => 'button',
    'style' => 'display:inline-block;margin:0;position:absolute;top:10px',
));
?>
</div>
<?php
echo $this->Form->input('ProductCombination.inc_price', array(
    'label' => __d('shop', 'Increment on Price'),
    'div' => array(
        'style' => 'width:30%;display:inline-block'
    )
));
echo $this->Form->input('ProductCombination.inc_weight', array(
    'label' => __d('shop', 'Increment on Weight'),
    'div' => array(
        'style' => 'width:30%;display:inline-block'
    )
));
echo $this->Form->input('ProductCombination.number', array(
    'label' => __d('shop', 'Number'),
    'div' => array(
        'style' => 'width:30%;display:inline-block'
    )
));
echo $this->Form->input('ProductCombination.pictures', array(
    'type' => 'hidden',
));
?>
<style>
    .combination-pictures .thumbnails{
        margin-bottom: 30px;
    }
    .combination-pictures .img-polaroid{
        box-shadow: none;
        border-radius: 3px;
    }
    .combination-pictures .item > img{
        padding: 4px;
        cursor: pointer;
    }
    .combination-pictures .item img.selected{
        border: 5px solid #96E50C;
        padding: 0;
    }
</style>
<div class="input text combination-pictures">
    <label><?php echo __d('shop', 'Pictures');?></label>
    <div class="thumbnails">
        <?php
        foreach($this->request->data['Attachment'] as $attachment){
        ?>
            <div class="span2 item">
                <?php
                echo $this->Form->input('ProductCombination.pictures.'.$attachment['id'], array(
                    'type' => 'checkbox',
                    'hiddenField' => false,
                    'style' => 'display:none',
                    'div' => false,
                    'label' => false,
                ));
                echo $this->html->image($attachment['path'], array(
                    'alt' => $attachment['title'],
                    'class' => 'img-polaroid',
                    'id' => 'img-'.$attachment['id']
                ))
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
echo $this->Form->input('ProductCombination.default', array(
    'label' => __d('shop', 'set as default combination'),
     'type' => 'checkbox',
     'hiddenField' => false,
    'div' => array(
        'style' => 'width:33%'
    )
));
$tableHeaders = array(
    __d('shop', 'id'),
    __d('shop', 'combinations'),
    __d('shop', 'inc price'),
    __d('shop', 'inc weight'),
    __d('shop', 'number'),
    array(__d('croogo', 'Actions') => array('class' => 'actions'))
);
$tableRows = array();
foreach($this->request->data['Combinations'] as $combination){
    $row = array();
    $row[] = $combination['id'];
    $combinations = Set::combine($combination['Properties'], array('{0}:{1}', '{n}.title', '{n}.PropertyValue'), '{n}.id');
    $row[] = implode(' | ', array_keys($combinations));
    $row[] = $combination['inc_price'];
    $row[] = $combination['inc_weight'];
    $row[] = $combination['number'];
    $actions = array();
    $actions[] = $this->Html->link(
        '<i class="icon-pencil icon-large"></i>',
        '#',
        array(
            'escape' => false,
            'class' => 'edit-combination',
            'id' => 'combination-record-'.$combination['id'],
            'data-id' => $combination['id']
        )
    );
    $actions[] = $this->Html->link(
        '<i class="icon-trash icon-large"></i>',
        '#',
        array(
            'escape' => false,
            'class' => 'delete-combination delete',
            'id' => 'combination-record-'.$combination['id'],
        )
    );
    $row[] = $this->Html->div('item-actions', implode(' ', $actions));
    $tableRows[] = $this->Html->tableCells($row);
}
?>
<hr />
<div style="margin: 0 5px 20px 5px">
    <?php echo $this->Html->tag('h5', __d('shop', 'Combinations List'));?>
    <table class="table table-striped">
        <?php echo $this->Html->tag('thead',$this->Html->tableHeaders($tableHeaders));?>
        <?php echo $this->Html->tag('tbody',implode('', $tableRows));?>
    </table>
</div>


<?php
$this->append('script');
?>
<script>
    $(document).ready(function(){
        var productCombinations = <?php echo json_encode($this->request->data['Combinations'])?>;

        $('.edit-combination').on('click', function(e){
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 800);
            var combinationId = $(this).data('id');
            var combinationObject = productCombinations[combinationId];
            $('input[name="data[ProductCombination][id]"]').val(combinationId);
            $('input[name="data[ProductCombination][inc_price]"]').val(combinationObject.inc_price);
            $('input[name="data[ProductCombination][inc_weight]"]').val(combinationObject.inc_weight);
            $('input[name="data[ProductCombination][number]"]').val(combinationObject.number);
            $('input[name="data[ProductCombination][default]"]').prop('checked', !!parseInt(combinationObject.default));

            var combinations = '';
            $.each(combinationObject.Properties, function(key, property){
                var option = '<option class="pr-'+property.id+'" value="'+property.id+'-'+property.PropertyValueId+'">'+property.title+" : "+property.PropertyValue+'</option>';
                combinations += option;
            })
            $('select[name="data[ProductCombination][combinations][]"]').html(combinations);

            $('.combination-pictures .item img').removeClass('selected');
            $.each(combinationObject.pictures, function(key, checked){
                $('input[name="data[ProductCombination][pictures]['+key+']"]').prop('checked', true);
                $('img#img-'+key).addClass('selected');
            })
        });

        $('#ProductCombinationLabel').on('change', function(){
            var propertyId = $(this).val();
            $('#ProductCombinationValues option').css('display', 'none');
            $('#ProductCombinationValues option.pr-'+propertyId).css('display', 'block');
            $('#ProductCombinationValues').val($('#ProductCombinationValues option.pr-'+propertyId+':first').val());
        });
        $('#ProductCombinationLabel').trigger('change');

        $('button#delete-combination').on('click', function (){
            $('#ProductCombinationCombinations option:selected').remove();
        });
        $('button#add-combination').on('click', function () {
            var propertyName = $('#ProductCombinationLabel option:selected').val();
            var propertyValue = $('#ProductCombinationValues option:selected').val();
            if($('#ProductCombinationCombinations option[class=pr-'+propertyName+']').length){
                $('#dialog').modal();
                return false;
            }else{
                var propertyName_text = $('#ProductCombinationLabel option:selected').text();
                var propertyValue_text = $('#ProductCombinationValues option:selected').text();
                var option = '<option class="pr-'+propertyName+'" value="'+propertyValue+'">'+propertyName_text+" : "+propertyValue_text+'</option>';
                $('#ProductCombinationCombinations').append(option);
            }
        });
        var selectAllCombinations = function(){
            var selectBox = document.getElementById('ProductCombinationCombinations');
            console.log(selectBox.options.length);
            for (var i = 0; i < selectBox.options.length; i++){
                selectBox.options[i].selected = true;
            }
        };
        $('form#ProductAdminEditForm').submit(function () {
            selectAllCombinations();
            return true;
        });

        $('.combination-pictures .item img').on('click', function(){
            if(!$(this).prev('input[type="checkbox"]').prop('checked')){
                $(this).prev('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
                $(this).addClass('selected');
            }else{
                $(this).prev('input[type="checkbox"]').prop('checked', false).removeAttr('checked');
                $(this).removeClass('selected');
            }
        });


    });
</script>
<?php
$this->end();
?>
<!--شما فقط می‎توانید یک ترکیب در هر نوع از ویژگی‎ها اضافه کنید.-->
<div id="dialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">
            <?php echo __d('shop', 'Warning');?>
        </h3>
    </div>
    <div class="modal-body">
        <p>
            <?php echo __d('shop', 'You can add just one combination of each properties');?>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">
            <?php echo __d('shop', 'Close');?>
        </button>
    </div>
</div>