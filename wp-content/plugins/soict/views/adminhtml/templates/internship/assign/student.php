<?php
//variables
$internship = $this->getInternship();
$collection = $this->getCollection(); //collection
$page = (int)$this->getCurrent('p');
$pageSize = (int)$this->getCurrent('size');
$orderby = $this->getCurrent('orderby');
$order = $this->getCurrent('order');
$search = $this->getCurrent('search');

$url = get_admin_url() . 'admin.php?page=soict-internship';
$grid_url = $url . '-assign-student';
$url_student = get_admin_url() . 'admin.php?page=soict-student';

?>
<div class="wrap about-wrap avada-wrap">
    <h3><?php echo __("Assign student to internship \"".$internship->getTitle().'"', "Soict"); ?></h3>

    <?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <div class="feature-section">

        <h4>
            <!--<a href="<?php /*echo $url */?>-edit&id=<?php /*echo $internship->getId() */?>" class="page-title-action">&lt;&lt;<?php /*echo __('Back', 'Soict') */?></a>-->
            <!--&nbsp;&nbsp;&nbsp;-->
            <a href="<?php echo $url ?>-assigned-student&id=<?php echo $internship->getId() ?>" class="page-title-action">&lt;&lt;<?php echo __("Back", "Soict") ?></a>
        </h4>

        <form action="<?php echo $grid_url ?>" method="get">
            <input type="hidden" name="page" value="soict-internship-assign-student"/>
            <input type="hidden" name="id" value="<?php echo $internship->getId() ?>"/>

            <p class="search-box">
                <a href="<?php echo $grid_url ?>&reset=1" class="button" title="reset" rel="nofollow"><?php echo __('Reset Filter', 'Soict') ?></a>
            </p>
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input"><?php echo __('Search Student:') ?></label>
                <input type="search" id="user-search-input" name="s" value="<?php echo $search ?>">
                <button type="submit" id="search-submit" class="button" name="search" value="Search"><?php echo __('Search', 'Soict') ?></button>
            </p>

            <div class="tablenav top">
                <!--do mass action-->
                <div class="alignleft actions">
                    <button type="submit" id="assign" class="button action" name="action" value="assign">
                        <?php echo __('Assign selected item(s)', 'Soict') ?></button>
                </div>

                <?php include \SoictApp::getView('grid/paging.php', 'backend') ?>

                <br class="clear">

            </div>

            <table class="wp-list-table widefat fixed striped">

                <thead>
                <tr>
                    <!--col 1 checkbox-->
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox"></td>

                    <!--col 2 student_id-->
                    <th scope="col" id="student_id" class="manage-column column-student_id sortable
                    <?php echo $this->sorted('student_id') ?>">
                        <a href="<?php echo $grid_url ?>&orderby=student_id&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Student ID', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 3 name-->
                    <th scope="col" id="name" class="manage-column column-name sortable
                    <?php echo $this->sorted('name') ?>">
                        <a href="<?php echo $grid_url ?>&orderby=name&order=<?php echo ($order == 'desc') ? 'asc' : 'desc' ?>">
                            <span><?php echo __('Name', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a>
                    </th>

                    <!--col 4 photo-->
                    <th scope="col" id="photo" class="manage-column column-photo
                    sortable <?php echo $this->sorted('name') ?>"><?php echo __('Photo', 'Soict') ?></th>

                    <!--col 5 email-->
                    <th scope="col" id="email" class="manage-column column-email sortable <?php echo $this->sorted('email') ?>">
                        <a href="<?php echo $grid_url ?>&orderby=email&order=<?php echo ($order=='desc')?'asc':'desc' ?>">
                            <span><?php echo __('Email', 'Soict') ?></span>
                            <span class="sorting-indicator"></span></a></th>

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

                        <td class="column-student_id has-row-actions column-primary" data-colname="Student ID">
                            <strong><a href="<?php echo $url_student ?>-edit&id=<?php echo $item->getId() ?>">
                                    <?php echo $item->getUserLogin() ?></a></strong>
                            <br>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="<?php echo $url_student ?>-edit&id=<?php echo $item->getId() ?>">
                                        <?php echo __('Edit', 'Soict') ?>
                                    </a>
                                </span>
                            </div>
                        </td>

                        <td class="column column-name" data-colname="Name"><?php echo $item->getName() ?></td>

                        <td class="column column-photo" data-colname="Photo">
                            <?php if($item->getUserPhoto()): ?>
                                <img src="<?php echo $item->getUserPhoto() ?>" width="52" height="52" alt=""
                                     class="avatar wp-user-avatar photo avatar-default">
                            <?php endif; ?>
                        </td>

                        <td class="column column-email" data-colname="Email"><?php echo $item->getEmail() ?></td>

                    </tr>

                <?php endforeach; ?>
                    <script type="text/javascript">
                        $j = jQuery.noConflict();
                        function confirmDelete(url){
                            if(confirm('<?php echo __('Are you sure?', 'Soict') ?>')){
                                window.location.href = url;
                            }
                            return false;
                        }
                    </script>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="align-content: center;text-align: center;">
                            <?php echo __('No Data found', 'Soict') ?>
                        </td>
                    </tr>
                <?php endif; ?>

                </tfoot>

            </table>

            <div class="tablenav bottom">

                <?php include \SoictApp::getView('grid/paging-bottom.php', 'backend') ?>

                <br class="clear">

            </div>
        </form>

    </div>

    <div class="avada-thanks">
        <p class="description"><?php echo __("Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict"); ?></p>
    </div>
</div>
