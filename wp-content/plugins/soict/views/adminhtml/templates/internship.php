<?php
//variables
$collection = $this->getCollection(); //collection
$page = (int)$this->getCurrent('p');
$pageSize = (int)$this->getCurrent('size');
$orderby = $this->getCurrent('orderby');
$order = $this->getCurrent('order');
$search = $this->getCurrent('search');

$url = get_admin_url() . 'admin.php?page=soict-internship';

?>
<div class="wrap about-wrap avada-wrap">
    <h1><?php echo __("Internship Program Manage", "Soict"); ?></h1>

    <?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <div class="feature-section">

        <h4><?php echo __("Internship", "Soict") ?> <a href="<?php echo $url ?>-edit" class="page-title-action">
                <?php echo __("Add New", "Soict") ?>
            </a>
        </h4>

        <form action="<?php echo $url ?>" method="get">
            <input type="hidden" name="page" value="soict-internship"/>

            <p class="search-box">
                <a href="<?php echo $url ?>&reset=1" class="button" title="reset" rel="nofollow"><?php echo __("Reset Filter", "Soict") ?></a>
            </p>
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input"><?php echo __("Search Internship", "Soict") ?>:</label>
                <input type="search" id="user-search-input" name="s" value="<?php echo $search ?>">
                <button type="submit" id="search-submit" class="button" name="search" value="Search"><?php echo __("Search", "Soict") ?></button>
            </p>

            <div class="tablenav top">
                <!--do mass action-->
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">
                        <?php echo __("Select bulk action", "Soict") ?></label>
                    <select name="action" id="bulk-action-selector-top">
                        <option value="-1"><?php echo __("Bulk Actions", "Soict") ?></option>
                        <option value="delete"><?php echo __("Delete", "Soict") ?></option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Apply">
                </div>

                <?php include \SoictApp::getView('grid/paging.php', 'backend') ?>

                <br class="clear">

            </div>

            <table class="wp-list-table widefat fixed striped">

                <thead>
                <tr>
                    <!--col 1 checkbox-->
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">
                            <?php echo __("Select All", "Soict") ?></label>
                        <input id="cb-select-all-1" type="checkbox"></td>

                    <!--col 2 title-->
                    <th scope="col" id="title" class="manage-column column-title sortable
                    <?php echo $this->sorted('title') ?>">
                        <a href="<?php echo $url ?>&orderby=title&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Title', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 3 description-->
                    <th scope="col" id="description" class="manage-column column-description">
                        <span><?php echo __('Description', 'Soict') ?></span>
                    </th>

                    <!--col 4 from_date-->
                    <th scope="col" id="from_date" class="manage-column column-from_date sortable
                    <?php echo $this->sorted('from_date') ?>">
                        <a href="<?php echo $url ?>&orderby=from_date&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('From Date', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 5 to_date-->
                    <th scope="col" id="to_date" class="manage-column column-from_date sortable
                    <?php echo $this->sorted('to_date') ?>">
                        <a href="<?php echo $url ?>&orderby=to_date&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('To Date', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 6 action-->
                    <th scope="col" id="action" class="manage-column column-action">
                        <span>Action</span></th>
                </tr>
                </thead>

                <tbody id="the-list">
                <?php if ($collection->getSize()): ?>
                    <?php foreach ($collection as $item): ?>

                        <tr id="<?php echo $item->getId() ?>">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="mass_action[]" id="item_<?php echo $item->getId() ?>"
                                       class="administrator bbp_keymaster" value="<?php echo $item->getId() ?>">
                            </th>

                            <td class="column-title has-row-actions column-primary" data-colname="Title">
                                <strong><a href="<?php echo $url ?>-edit&id=<?php echo $item->getId() ?>">
                                        <?php echo $item->getTitle() ?></a></strong>
                                
                                <div class="row-actions">
                                    <span class="edit">
                                        <a href="<?php echo $url ?>-edit&id=<?php echo $item->getId() ?>">
                                            <?php echo __('Edit', 'Soict') ?>
                                        </a>
                                    </span>
                                </div>
                            </td>

                            <td class="column column-description" data-colname="Description"><?php echo $item->getDescription() ?></td>

                            <td class="column column-from-date"
                                data-colname="From Date"><?php echo $item->getFromDate() ?></td>

                            <td class="column column-to-date"
                                data-colname="To Date"><?php echo $item->getToDate() ?></td>

                            <th class="column column-action" scope="col" id="action">
                                <a href="javascript: confirmDelete('<?php echo $url ?>-delete&id=<?php echo $item->getId() ?>')">
                                    <span class="delete"><?php echo __("Delete", "Soict") ?></span></a></th>
                        </tr>

                    <?php endforeach; ?>
                    <script type="text/javascript">
                        $j = jQuery.noConflict();
                        function confirmDelete($url){
                            if(confirm('<?php echo __('Are you sure?', 'Soict') ?>')){
                                window.location.href = $url;
                            }
                            return false;
                        }
                    </script>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="align-content: center;text-align: center;">
                            <?php echo __('No Data found', 'Soict') ?>
                        </td>
                    </tr>
                <?php endif; ?>

                </tfoot>

            </table>

            <div class="tablenav bottom">

                <!--do mass action-->
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">
                        <?php echo __("Select bulk action", "Soict") ?>
                    </label>
                    <select name="action2" id="bulk-action-selector-bottom">
                        <option value="-1"><?php echo __("Bulk Actions", "Soict") ?></option>
                        <option value="delete"><?php echo __("Delete", "Soict") ?></option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Apply">
                </div>

                <?php include \SoictApp::getView('grid/paging-bottom.php', 'backend') ?>

                <br class="clear">

            </div>
        </form>

    </div>

    <div class="avada-thanks">
        <p class="description"><?php echo __("Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict"); ?></p>
    </div>
</div>
