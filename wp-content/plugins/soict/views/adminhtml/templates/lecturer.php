<?php
//variables
$collection = $this->getCollection(); //collection
$page = (int)$this->getCurrent('p');
$pageSize = (int)$this->getCurrent('size');
$orderby = $this->getCurrent('orderby');
$order = $this->getCurrent('order');
$search = $this->getCurrent('search');

$url = get_admin_url() . 'admin.php?page=soict-lecturer';

?>
<div class="wrap about-wrap avada-wrap">
    <h1><?php echo __("Lecturer Manage", "Soict"); ?></h1>

    <?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <div class="feature-section">

        <div class="row-line">
            <div>
                <span><?php echo __('Lecturer', 'Soict') ?></span>
                <a href="<?php echo $url ?>-edit"
                   class="page-title-action"><?php echo __('Add New', 'Soict') ?></a>
            </div>
            <span><?php echo __('Or') ?></span>
            <form action="<?php echo $url ?>-importCsv" method="post" enctype="multipart/form-data">
                <label for="import-csv"><?php echo __('Import from CSV:') ?></label>
                <input id="import-csv" type="file" name="fileCsv" />
                <button class="import-btn" type="submit" name="submit-file-csv"><?php echo __('Upload') ?></button>
            </form>
            <div>
                <a href="<?php echo \SoictApp::getPublicUrl('files/import_student_sample.csv', 'backend')
                ?>"><?php echo __('Download')?></a> sample import file.</div>
        </div>

        <form action="<?php echo $url ?>" method="get">
            <input type="hidden" name="page" value="soict-lecturer"/>

            <p class="search-box">
                <a href="<?php echo $url ?>&reset=1" class="button" title="reset" rel="nofollow"><?php echo __("Reset Filter", "Soict") ?></a>
            </p>
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input"><?php echo __("Search Lecturer", "Soict") ?>:</label>
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

                    <!--col 2 username-->
                    <th scope="col" id="user-login" class="manage-column column-userlogin sortable
                    <?php echo $this->sorted('user_login') ?>">
                        <a href="<?php echo $url ?>&orderby=user_login&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Username', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 3 name-->
                    <th scope="col" id="name" class="manage-column column-name sortable
                    <?php echo $this->sorted('name') ?>">
                        <a href="<?php echo $url ?>&orderby=name&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Name', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 4 avatar-->
                    <th scope="col" id="avatar" class="manage-column column-avatar">
                        <span><?php echo __('Photo', 'Soict') ?></span></th>

                    <!--col 5 gender-->
                    <th scope="col" id="gender"
                        class="manage-column column-address sortable <?php echo $this->sorted('gender') ?>">
                        <a href="<?php echo $url ?>&orderby=gender&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Gender', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 6 birthday-->
                    <th scope="col" id="birthday"
                        class="manage-column column-address sortable <?php echo $this->sorted('birthday') ?>">
                        <a href="<?php echo $url ?>&orderby=birthday&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Birthday', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 7 phone-->
                    <th scope="col" id="phone" class="manage-column column-telephone">
                        <span><?php echo __('HR Phone', 'Soict') ?></span></th>

                    <!--col 8 action-->
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

                            <td class="column-name has-row-actions column-primary" data-colname="Username">
                                <strong><a href="<?php echo $url ?>-edit&id=<?php echo $item->getId() ?>">
                                        <?php echo $item->getUserLogin() ?></a></strong>
                                <br>
                                <div class="row-actions">
                                    <span class="edit">
                                        <a href="<?php echo $url ?>-edit&id=<?php echo $item->getId() ?>">Edit</a>
                                    </span>
                                </div>
                            </td>

                            <td class="column column-name" data-colname="Name"><?php echo $item->getName() ?></td>

                            <td class="column column-avatar"
                                data-colname="avatar">
                                <?php if($item->getAvatar()): ?>
                                    <img src="<?php echo \SoictApp::getFullUrl($item->getAvatar()) ?>" width="32" height="32" alt=""
                                         class="avatar avatar-32 wp-user-avatar wp-user-avatar-32 photo avatar-default">
                                <?php endif; ?>
                            </td>

                            <td class="column column-gender"
                                data-colname="Gender"><?php echo $item->getGender() ?></td>

                            <td class="column column-birthday"
                                data-colname="Birthday"><?php echo $item->getBirthday() ?></td>

                            <td class="column column-phone"
                                data-colname="Phone"><?php echo $item->getPhone() ?></td>

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
                        <td colspan="8" style="align-content: center;text-align: center;">
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
