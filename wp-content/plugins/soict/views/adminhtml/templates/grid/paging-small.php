<?php
//use vars
//$collection from parent template
if(!isset($grid_url)){
    $grid_url = $url; //fix for update to old url
}
?>
<!--paging navigation-->
<div class="tablenav-pages">
    <span class="pagination-links">
        <?php if ($page == 1): ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
        <?php else: ?>
            <a class="first-page" href="<?php echo $grid_url ?>&p=1">
                <span class="screen-reader-text">First page</span>
                <span aria-hidden="true">«</span>
            </a>
        <?php endif; ?>

        <?php if ($page > 1): ?>
            <a class="prev-page" href="<?php echo $grid_url ?>&p=<?php echo $page - 1 ?>">
                <span class="screen-reader-text">Previous page</span>
                <span aria-hidden="true">‹</span>
            </a>
        <?php else: ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
        <?php endif; ?>

        <span class="paging-input">
            <label for="current-page-selector" class="screen-reader-text">Current Page</label>
            <input class="current-page" id="current-page-selector" type="text" name="p"
                   value="<?php echo $page ?>" size="1"
                   aria-describedby="table-paging">
            <span class="tablenav-paging-text"> of <span
                    class="total-pages"><?php echo $collection->getTotalPage() ?></span></span>
        </span>

        <?php if ($page < $collection->getTotalPage()): ?>
            <a class="next-page" href="<?php echo $grid_url ?>&p=<?php echo $page + 1 ?>">
                <span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span>
            </a>
        <?php else: ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">›</span>
        <?php endif; ?>

        <?php if ($page == $collection->getTotalPage()): ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
        <?php else: ?>
            <a class="last-page" href="<?php echo $grid_url ?>&p=<?php echo $collection->getTotalPage() ?>">
                <span class="screen-reader-text">Last page</span>
                <span aria-hidden="true">»</span>
            </a>
        <?php endif; ?>
    </span>
</div>
<!--End paging navigation-->
