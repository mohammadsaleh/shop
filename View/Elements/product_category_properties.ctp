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
    #product-category-properties{
        padding: 15px;
    }
</style>
<div id="product-category-properties">
    <?php
    echo $this->element('category_properties', compact('categoryProperties'));
    ?>
</div>
<?php
$this->start('script');
?>
<script>
    $(document).ready(function(){
        $('select#ProductCategoryId').on('change', function(){
            var url = '<?php echo Router::url(array('action' => 'get_category_properties'))?>'
            $.post(url, {category_id : this.value},"json")
                .success(function(data){
                    $('#product-category-properties').html(data);
                })
        });
    });
</script>
<?php
$this->end();
?>