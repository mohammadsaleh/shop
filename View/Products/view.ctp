<?php
debug($product);die;
?>
<script>
    var combinations = <?php echo json_encode($product['Combinations'], JSON_UNESCAPED_UNICODE); ?>;
    var price = <?php echo $product['Product']['price']; ?>;
    var off = <?php echo $product['Product']['off']; ?>;
</script>