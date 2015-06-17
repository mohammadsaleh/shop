<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapseCategory" class="collapseWill">
                <span class="pull-left">
                    <i class="fa fa-caret-right"></i>
                </span> <?php echo __d('shop', 'Category'); ?>
            </a>
        </h4>
    </div>
    <div id="collapseCategory" class="panel-collapse collapse in">
        <div class="panel-body">
            <?php echo $this->Custom->showSidebarCategories($categoriesTree); ?>
        </div>
    </div>
</div>
