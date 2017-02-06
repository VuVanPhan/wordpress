<?php
//variables
$students = $this->getCollection(); //collection
$collection = $students;
$page = (int)$this->getCurrent('p');
$pageSize = (int)$this->getCurrent('size');
$orderby = $this->getCurrent('orderby');
$order = $this->getCurrent('order');
$search = $this->getCurrent('search');

$url = get_admin_url().'admin.php?page=soict-student';

?>
<div class="wrap about-wrap avada-wrap">
    <h1><?php echo __("Student Manage", "Soict"); ?></h1>

    <?php if(\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <div class="feature-section">

        <div class="row-line">
            <div>
                <span><?php echo __('Student', 'Soict') ?></span>
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
            <input type="hidden" name="page" value="soict-student"/>

            <p class="search-box">
                <a href="<?php echo $url ?>&reset=1" class="button" title="reset" rel="nofollow"><?php echo __('Reset Filter', 'Soict') ?></a>
            </p>
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input"><?php echo __('Search Student', 'Soict') ?>:</label>
                <input type="search" id="user-search-input" name="s" value="<?php echo $search ?>">
                <button type="submit" id="search-submit" class="button" name="search" value="Search"><?php echo __('Search', 'Soict') ?></button>
            </p>

            <div class="tablenav top">
                <!--do mass action-->
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Select bulk action', 'Soict') ?></label>
                    <select name="action" id="bulk-action-selector-top">
                        <option value="-1"><?php echo __('Bulk Actions', 'Soict') ?></option>
                        <option value="delete"><?php echo __('Delete', 'Soict') ?></option>
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
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox"></td>

                    <!--col 2 username-->
                    <th scope="col" id="username" class="manage-column column-username column-primary sortable <?php echo $this->sorted('login') ?>">
                        <a href="<?php echo $url ?>&orderby=login&order=<?php echo ($order=='desc')?'asc':'desc' ?>">
                            <span>Username</span>
                            <span class="sorting-indicator"></span>
                        </a></th>

                    <!--col 3 photo-->
                    <th scope="col" id="photo" class="manage-column column-photo sortable <?php echo $this->sorted('name') ?>">Photo</th>

                    <!--col 4 name-->
                    <th scope="col" id="name" class="manage-column column-name sortable <?php echo $this->sorted('name') ?>">Name</th>

                    <!--col 5 email-->
                    <th scope="col" id="email" class="manage-column column-email sortable <?php echo $this->sorted('email') ?>">
                        <a href="<?php echo $url ?>&orderby=email&order=<?php echo ($order=='desc')?'asc':'desc' ?>">
                            <span>Email</span>
                            <span class="sorting-indicator"></span></a></th>

                    <!--col 6 student ID-->
                    <th scope="col" id="student-id" class="manage-column column-student-id">
                        <span>Student ID</span></th>

                    <!--col 7 phone-->
                    <th scope="col" id="phone" class="manage-column column-telephone">
                        <span>Phone</span></th>

                    <!--col 8 action-->
                    <th scope="col" id="action" class="manage-column column-action">
                        <span>Action</span></th>
                </tr>
                </thead>

                <tbody id="the-list">
                <?php if ($students->getSize()): ?>
                    <?php foreach($students as $student): ?>

                    <tr id="<?php echo $student->getId() ?>">
                        <th scope="row" class="check-column">
                            <input type="checkbox" name="mass_action[]" id="user_<?php echo $student->getId() ?>" class="administrator bbp_keymaster" value="<?php echo $student->getId() ?>">
                        </th>

                        <td class="column column-username has-row-actions column-primary" data-colname="Username">
                            <strong>
                                <a href="<?php echo $url ?>-edit&id=<?php echo $student->getId() ?>"><?php echo $student->getUserLogin() ?></a>
                            </strong>
                            <br>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="<?php echo $url ?>-edit&id=<?php echo $student->getId() ?>">Edit</a>
                                </span>
                            </div>
                        </td>

                        <td class="column column-photo" data-colname="Photo">
                            <?php if($student->getUserPhoto()): ?>
                                <img src="<?php echo $student->getUserPhoto() ?>" width="42" height="42" alt=""
                                 class="avatar wp-user-avatar photo avatar-default">
                            <?php endif; ?>
                        </td>

                        <td class="column column-name" data-colname="Name"><?php echo $student->getName() ?></td>

                        <td class="column column-email" data-colname="Email"><?php echo $student->getEmail() ?></td>

                        <td class="column column-student-id" data-colname="StudentId"><?php echo $student->getStudentId() ?></td>

                        <td class="column column-telephone" data-colname="Telephone"><?php echo $student->getTelephone() ?></td>

                        <th scope="col" id="action" class="manage-column column-action">
                            <a href="javascript: confirmDelete('<?php echo $url ?>-delete&id=<?php echo $student->getId() ?>')">
                                <span class="delete">Delete</span></a></th>
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
                    <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label><select
                        name="action2" id="bulk-action-selector-bottom">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete">Delete</option>
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
