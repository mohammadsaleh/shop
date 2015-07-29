<?php
$data = $this->request->data;
echo $this->Form->input('type', array(
    'label' =>  __d('shop', 'Type'),
    'options' => array(
        'text' => __d('shop', 'Text'),
        'radio' => __d('shop', 'Radio'),
        'checkbox' => __d('shop', 'Checkbox'),
        'select' => __d('shop', 'Select'),
        'color' => __d('shop', 'Color')
    )
));
if(!empty($data) && $data['Property']['type'] == 'text'){
    echo $this->Html->div("propValueOption text-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $this->Form->input('PropertyValue.0.option.', array(
            'label' => false,
            'style' => 'display: block;',
            'disabled' => false,
            'value' => $data['PropertyValue'][0]['option'],
        ))
    );
}elseif(!empty($data) && $data['Property']['type'] != 'text'){
    echo $this->Html->div("propValueOption text-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $this->Form->input('PropertyValue.0.option.', array(
            'label' => false,
            'disabled' => true,
        )),array(
            'style' => 'display: none;',
        )
    );
}else{
    echo $this->Html->div("propValueOption text-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $this->Form->input('PropertyValue.0.option.', array(
            'label' => false,
        ))
    );
}
if(!empty($data) && ($data['Property']['type'] == 'radio' || $data['Property']['type'] == 'checkbox' || $data['Property']['type'] == 'select') ){
    $optionsContent = '';
    $index = 0;
    foreach($data['PropertyValue'] as $propertyValue){
        $isLastIteration = ($index == (count($data['PropertyValue']) - 1));
        $optionsContent .= $this->Html->div("selective-option-content",
            $this->Form->input('PropertyValue.0.option.', array(
                'data-type' => 'selective',
                'style' => 'width:82%;',
                'label' => false,
                'class' => 'form-control',
                'value' => $propertyValue['option'],
            )) .
            $this->Form->button('<i class="icon-plus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-success',
                'id' => 'add-property-value-option',
                'style' => 'margin: -50px 0 0 10px;height: 30px;float:left;' . (($isLastIteration)?'display: block;':'display: none;'),
                'data-type' => 'selective',
            ]) .
            $this->Form->button('<i class="icon-minus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-danger',
                'id' => 'remove-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;' . (($isLastIteration)?'display: none;':'display: block;')
            ])
        );
        $index++;
    }
    echo $this->Html->div("propValueOption selective-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $optionsContent
        , array(
            'style' => 'display:block;'
        )
    );
}else{
    echo $this->Html->div("propValueOption selective-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $this->Html->div("selective-option-content",
            $this->Form->input('PropertyValue.0.option.', array(
                'data-type' => 'selective',
                'style' => 'width:82%;',
                'label' => false,
                'class' => 'form-control',
                'disabled',
            )) .
            $this->Form->button('<i class="icon-plus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-success',
                'id' => 'add-property-value-option',
                'disabled',
                'style' => 'margin: -50px 0 0 10px;height: 30px;float:left;',
                'data-type' => 'selective',
            ]) .
            $this->Form->button('<i class="icon-minus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-danger',
                'id' => 'remove-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;display:none;'
            ])
        )
        , array(
            'style' => 'display:none;'
        )
    );
}
if(!empty($data) && $data['Property']['type'] == 'color'){
    $optionsContent = '';
    $index = 0;
    foreach($data['PropertyValue'] as $propertyValue){
        $isLastIteration = ($index == (count($data['PropertyValue']) - 1));
        $optionsContent .= $this->Html->div("selective-option-content",
            $this->Form->input('PropertyValue.0.option.', array(
                'data-type' => 'color',
                'style' => 'width:72%;border-color: #' . $propertyValue['option'] . ';',
                'label' => false,
                'class' => 'form-control picker',
                'id' => 'picker',
                'value' => $propertyValue['option'],
            )) .
            $this->Form->button('<i class="icon-plus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-success',
                'id' => 'add-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;' . (($isLastIteration)?'display: block;':'display: none;'),
                'data-type' => 'color',
            ]) .
            $this->Form->button('<i class="icon-minus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-danger',
                'id' => 'remove-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;' . (($isLastIteration)?'display:none':'display:block'),
            ])
        );
        $index++;
    }
    echo $this->Html->div("propValueOption color-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $optionsContent, array(
            'style' => 'display:block;'
        )
    );
}else{
    echo $this->Html->div("propValueOption color-option",
        "<label style='padding-right: 10px;'>" . __d('shop', 'Options') . "</label>" .
        $this->Html->div("selective-option-content",
            $this->Form->input('PropertyValue.0.option.', array(
                'data-type' => 'color',
                'style' => 'width:72%;border-color: rgb(28, 145, 230);',
                'label' => false,
                'class' => 'form-control picker',
                'id' => 'picker',
                'value' => '3289c7',
                'disabled',
            )) .
            $this->Form->button('<i class="icon-plus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-success',
                'id' => 'add-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;',
                'data-type' => 'color',
            ]) .
            $this->Form->button('<i class="icon-minus"></i>', [
                'type' => 'button',
                'class' => 'btn btn-default btn-danger',
                'id' => 'remove-property-value-option',
                'style' => 'margin: -50px 0 0 10px;float:left;height: 30px;display:none;'
            ])
        )
        , array(
            'style' => 'display:none;'
        )
    );
}
?>
<?php
    echo $this->Html->css(array(
        'Shop.colpick',
    ));
    echo $this->Html->script(array(
        'Shop.colpick',
    ));
?>
<style>
    .selective-option-content .picker {
        border-right:30px solid rgb(28, 145, 230);
    }
</style>
<script>
    $(function(){
        function colorPicker(){
            $('.picker').colpick({
                layout:'hex',
                submit:0,
                colorScheme:'dark',
                onChange:function(hsb,hex,rgb,el,bySetColor) {
                    $(el).css('border-color','#'+hex);
                    // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                    if(!bySetColor) $(el).val(hex);
                }
            }).keyup(function(){
                $(this).colpickSetColor(this.value);
            });
        }
        colorPicker();
        $("body").on("click", ".picker", function(){
            colorPicker();
        });
        function selectOptionType(_class){
            $(".propValueOption").css("display", "none");
            $("." + _class).css("display", "block");
            $(".propValueOption input").prop("disabled", true);
            $("." + _class + " input").prop("disabled", false);
        }
        $("select[name='data[Property][type]']").on("change", function(e){
            switch($(this).val()){
                case 'text':
                    selectOptionType("text-option");
                    break;
                case 'radio':
                case 'select':
                case 'checkbox':
                    selectOptionType("selective-option");
                    break;
                case 'color':
                    selectOptionType("color-option");
                    break;
                default :
                    break;
            }
        });
        $("body").on("keyup", ".propValueOption input", function() {
            if($.trim($(this).val()) != ''){
                $(this).parent("div").siblings("button#add-property-value-option").prop("disabled", false);
            }else{
                $(this).parent("div").siblings("button#add-property-value-option").prop("disabled", true);
            }
        }).on("click", "button#add-property-value-option", function(){
            var parent_container = $(this).parents(".propValueOption");
            var selective_option = parent_container.find("div.selective-option-content").last();
            parent_container.append(selective_option.clone());
            var prevOptions = parent_container.find("div.selective-option-content:not(:last-child)");
            prevOptions.find("button#add-property-value-option").css("display", "none");
            prevOptions.find("button#remove-property-value-option").css("display", "block");
            var lastOption = parent_container.find("div.selective-option-content").last();
            lastOption.find("input").val("");
            var newBtnAdd = lastOption.find("button#add-property-value-option");
            if(newBtnAdd.data("type") == 'selective'){
                newBtnAdd.prop("disabled", true);
            }
        }).on("click", "button#remove-property-value-option", function(){
            var option = $(this).parents(".selective-option-content");
            option.remove();
        });
    });
</script>