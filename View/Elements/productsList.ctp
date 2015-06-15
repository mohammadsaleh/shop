<?php $paginator = $this->Paginator; ?>
<div class="col-lg-9 col-md-9 col-sm-12">
    <div class="w100 productFilter clearfix">
        <p class="pull-left"> Showing <strong>12</strong> products </p>
        <div class="pull-right ">
            <div class="change-order pull-right">
                <select class="form-control" name="orderby">
                    <option selected="selected">Default sorting</option>
                    <option value="popularity">Sort by popularity</option>
                    <option value="rating">Sort by average rating</option>
                    <option value="date">Sort by newness</option>
                    <option value="price">Sort by price: low to high</option>
                    <option value="price-desc">Sort by price: high to low</option>
                </select>
            </div>
            <div class="change-view pull-right"> <a href="#" title="Grid" class="grid-view"> <i class="fa fa-th-large"></i> </a> <a href="#" title="List" class="list-view "><i class="fa fa-th-list"></i></a> </div>
        </div>
    </div>

    <div class="row  categoryProduct xsResponse clearfix">
        <?php
            foreach($products as $product){
                echo $this->element('Shop.category_product_box', compact('product'));
            }
        ?>
    </div>

    <div class="w100 categoryFooter">
        <div class="pagination pagination-large">
            <ul class="pagination">
                <?php
                echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                ?>
            </ul>
        </div>
    </div>

</div>