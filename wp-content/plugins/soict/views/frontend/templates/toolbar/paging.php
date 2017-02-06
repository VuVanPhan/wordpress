<?php
//vars:
$page = (int)$this->getPaging()->getCurPage();
$pageSize = (int)$this->getPaging()->getPageSize();
$orderby = $this->getPaging()->getOrderBy();
$order = $this->getPaging()->getOrder();
?>
<!--Paging navigation-->
<div class="tablenav-pages">
    <span class="displaying-num">
        <span class="paging-input">
            <label for="current-page-size" class="current-page-size">Page Size</label>
            <input class="current-page-size" id="current-page-size" type="text" name="size-top"
                   value="<?php echo $pageSize ?>" size="1"/>
        </span>
    </span>
    <span class="displaying-num"><?php echo __($collection->getSize() . ' items', 'Soict') ?></span>
    <span class="pagination-links">
        <?php if ($page == 1): ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">&laquo;</span>
        <?php else: ?>
            <a class="tablenav-pages-navspan first-page" href="<?php echo $grid_url ?>?_curpage=1">
                <span aria-hidden="true">&laquo;</span>
            </a>
        <?php endif; ?>

        <?php if ($page > 1): ?>
            <a class="tablenav-pages-navspan prev-page" href="<?php echo $grid_url ?>?_curpage=<?php echo $page - 1 ?>">
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        <?php else: ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">&lsaquo;</span>
        <?php endif; ?>

        <span class="paging-input">
            <input class="current-page" id="current-page-selector" type="text" name="_curpage"
                   value="<?php echo $page ?>" size="1"
                   aria-describedby="table-paging">
            <span class="tablenav-paging-text"> of <span class="total-pages"><?php echo $page ?></span></span>
        </span>

        <?php if ($page < $collection->getTotalPage()): ?>
            <a class="tablenav-pages-navspan next-page" href="<?php echo $grid_url ?>?_curpage=<?php echo $page + 1 ?>">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        <?php else: ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">&rsaquo;</span>
        <?php endif; ?>

        <?php if ($page == $collection->getTotalPage()): ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">&raquo;</span>
        <?php else: ?>
            <a class="tablenav-pages-navspan last-page"
               href="<?php echo $grid_url ?>?_curpage=<?php echo $collection->getTotalPage() ?>">
                <span aria-hidden="true">&raquo;</span>
            </a>
        <?php endif; ?>
    </span>
</div>
<!--End paging navigation-->
