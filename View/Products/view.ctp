<?php
    echo $this->Html->script(array(
        '/assets/js/pace.min.js',
        '/assets/js/pace.min.js',
    ));
?>
<div class="row">
    <div class="breadcrumbDiv col-lg-12">
        <ul class="breadcrumb">
            <li> <a href="index.html">Home</a> </li>
            <li> <a href="category.html">MEN COLLECTION</a> </li>
            <li> <a href="sub-category.html">TSHIRT</a> </li>
            <li class="active">Lorem ipsum dolor sit amet </li>
        </ul>
    </div>
</div>
<div class="row transitionfx">

    <div class="col-lg-6 col-md-6 col-sm-6">

        <div class="main-image sp-wrap col-lg-12 no-padding" style="display: inline-block;">
            <div class="sp-large">
                <a href="images/zoom/zoom1.jpg" class="">
                    <?php echo $this->Html->image($product['Attachment'][0]['path'], array(
                        'class' => 'img-responsive',
                        'alt' => 'img',
                    )); ?>
                </a>
            </div>
            <div class="sp-thumbs sp-tb-active">
                <?php foreach($product['Attachment'] as $attachment): ?>
                    <a href="images/zoom/zoom1.jpg" class="sp-current">
                        <?php echo $this->Html->image($attachment['path'], array(
                            'class' => 'img-responsive',
                            'alt' => 'img',
                        )); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <div class="col-lg-6 col-md-6 col-sm-5">
        <h1 class="product-title"> <?php echo $product['Product']['title']; ?></h1>
        <h3 class="product-code">Product Code : DEN1098</h3>
        <div class="rating">
            <p> <span><i class="fa fa-star"></i></span> <span><i class="fa fa-star"></i></span> <span><i class="fa fa-star"></i></span> <span><i class="fa fa-star"></i></span> <span><i class="fa fa-star-o "></i></span> <span class="ratingInfo"> <span> / </span> <a data-target="#modal-review" data-toggle="modal"> Write a review</a> </span></p>
        </div>
        <div class="product-price"> <span class="price-sales"> <?php echo number_format($product['Product']['price']); ?></span> <span class="price-standard">$95</span> </div>
        <div class="details-description">
            <p><?php echo $product['Product']['description']; ?></p>
        </div>

        <?php foreach($product['SelectableProperties'] as $property): ?>
            <?php
                $property['Property']['title'];
                $property['Property']['name'];
                $property['Property']['type'];
                foreach($property['PropertyValue'] as $propertyValue){
                    $propertyValue['id'];
                    $propertyValue['option'];
                }
            ?>
        <?php endforeach; ?>
        <div class="color-details"> <span class="selected-color"><strong>COLOR</strong></span>
            <ul class="swatches Color">
                <li class="selected"> <a style="background-color:#f1f40e"> </a> </li>
                <li> <a style="background-color:#adadad"> </a> </li>
                <li> <a style="background-color:#4EC67F"> </a> </li>
            </ul>
        </div>

        <div class="productFilter productFilterLook2">
            <div class="filterBox">
                <select style="display: none;">
                    <option value="strawberries" selected="">Quantity</option>
                    <option value="mango">1</option>
                    <option value="bananas">2</option>
                    <option value="watermelon">3</option>
                    <option value="grapes">4</option>
                    <option value="oranges">5</option>
                    <option value="pineapple">6</option>
                    <option value="peaches">7</option>
                    <option value="cherries">8</option>
                </select>
                <div class="minict_wrapper">
                    <input type="text" value="Quantity" placeholder="Quantity">
                    <ul>
                        <li data-value="strawberries" class="selected">Quantity</li>
                        <li data-value="mango" class="">1</li>
                        <li data-value="bananas" class="">2</li>
                        <li data-value="watermelon" class="">3</li>
                        <li data-value="grapes" class="">4</li>
                        <li data-value="oranges" class="">5</li>
                        <li data-value="pineapple" class="">6</li>
                        <li data-value="peaches" class="">7</li>
                        <li data-value="cherries" class="">8</li>
                        <li class="minict_empty">No results match your keyword.</li>
                    </ul>
                </div>
            </div>
            <div class="filterBox">
                <select style="display: none;">
                    <option value="strawberries" selected="">Size</option>
                    <option value="mango">XL</option>
                    <option value="bananas">XXL</option>
                    <option value="watermelon">M</option>
                    <option value="apples">L</option>
                    <option value="apples">S</option>
                </select><div class="minict_wrapper"><input type="text" value="Size" placeholder="Size"><ul><li data-value="strawberries" class="selected">Size</li><li data-value="mango" class="">XL</li><li data-value="bananas" class="">XXL</li><li data-value="watermelon" class="">M</li><li data-value="apples" class="">L</li><li data-value="apples" class="">S</li><li class="minict_empty">No results match your keyword.</li></ul></div>
            </div>
        </div>

        <div class="cart-actions">
            <div class="addto">
                <button onclick="productAddToCartForm.submit(this);" class="button btn-cart cart first" title="Add to Cart" type="button">Add to Cart</button>
                <a class="link-wishlist wishlist">Add to Wishlist</a> </div>
            <div style="clear:both"></div>
            <h3 class="incaps"><i class="fa fa fa-check-circle-o color-in"></i> In stock</h3>
            <h3 style="display:none" class="incaps"><i class="fa fa-minus-circle color-out"></i> Out of stock</h3>
            <h3 class="incaps"> <i class="glyphicon glyphicon-lock"></i> Secure online ordering</h3>
        </div>

        <div class="clear"></div>
        <div class="product-tab w100 clearfix">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                <li> <a href="#size" data-toggle="tab">Size</a></li>
                <li> <a href="#shipping" data-toggle="tab">Shipping</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="details">Sed ut eros felis. Vestibulum rutrum imperdiet nunc a interdum. In scelerisque libero ut elit porttitor commodo. Suspendisse laoreet magna nec urna fringilla viverra.<br>
                    100% Cotton<br>
                </div>
                <div class="tab-pane" id="size"> 16" waist<br>
                    34" inseam<br>
                    10.5" front rise<br>
                    8.5" knee<br>
                    7.5" leg opening<br>
                    <br>
                    Measurements taken from size 30<br>
                    Model wears size 31. Model is 6'2 <br>
                    <br>
                </div>
                <div class="tab-pane" id="shipping">
                    <table>
                        <colgroup>
                            <col style="width:33%">
                            <col style="width:33%">
                            <col style="width:33%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>Standard</td>
                            <td>1-5 business days</td>
                            <td>$7.95</td>
                        </tr>
                        <tr>
                            <td>Two Day</td>
                            <td>2 business days</td>
                            <td>$15</td>
                        </tr>
                        <tr>
                            <td>Next Day</td>
                            <td>1 business day</td>
                            <td>$30</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3">* Free on orders of $50 or more</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>

        <div style="clear:both"></div>

    </div>

</div>
<?php
    echo $this->element("Shop.recommended");
?>