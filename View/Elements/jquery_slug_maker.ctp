<?php
echo $this->Html->script('Shop.jquery.custom.slug.js', false);
$this->append('script');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#<?php echo $origin; ?>").slug({
            slug:'<?php echo $target; ?>',
            hide:false
        });
    });
</script>
<?php
$this->end();