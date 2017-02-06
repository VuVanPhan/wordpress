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
$grid_url = $url . '-assign-lecturer';

?>
<div class="wrap about-wrap avada-wrap">
    <h3><?php echo __("Assign lecturer to internship \"".$internship->getTitle().'"', "Soict"); ?></h3>

    <?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <div class="feature-section">

        <h4>
            <a href="<?php echo $url ?>-edit&id=<?php echo $internship->getId() ?>"
               class="page-title-action">&lt;&lt;<?php echo __('Back', 'Soict') ?></a>
        </h4>

        <!--Assign form-->
        <form id="assign-form" action="<?php echo $grid_url ?>" method="get">
            <input type="hidden" name="page" value="soict-internship-assign-lecturer"/>
            <input type="hidden" name="id" value="<?php echo $internship->getId() ?>"/>

            <div class="lecturer-col lecturer-col-1">
                <div class="tablenav top">
                    <span class="col-name-title"><?php echo __('Student', 'Soict') ?></span>
                    <?php include \SoictApp::getView('grid/paging-small.php', 'backend') ?>
                    <br class="clear">
                </div>

                <div class="table-wrap">
                    <div class="table-title">
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                            <tr>
                                <!--col 1 checkbox-->
                                <td id="cb" class="manage-column column-cb check-column">
                                    <label class="screen-reader-text" for="cb-select-all-1">
                                        <?php echo __("Select All", "Soict") ?></label>
                                    <input id="cb-select-all-1" type="checkbox"></td>
                                <!--col 2 -->
                                <th scope="col" class="manage-column column-name">
                                    <span><?php echo __('', 'Soict') ?></span>
                                </th>

                                <!--col 3 -->
                                <th scope="col" class="manage-column column-student_id">
                                    <span><?php echo __('Student ID', 'Soict') ?></span>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-scroll">
                        <table class="wp-list-table widefat fixed striped">
                            <tbody>
                            <?php $studens = $this->getStudents() ?>
                            <?php if ($studens->getSize()): ?>
                                <?php foreach ($studens as $item): ?>
                                    <tr id="<?php echo $item->getId() ?>">
                                        <th scope="row" class="check-column">
                                            <input type="checkbox" name="checked_student[]" id="item_<?php echo $item->getId() ?>"
                                                   class="administrator bbp_keymaster" value="<?php echo $item->getId() ?>">
                                        </th>

                                        <td class="column column-name">
                                            <label for="item_<?php echo $item->getId() ?>"><?php echo $item->getName() ?></label>
                                        </td>

                                        <td class="column column-student_id"><?php echo $item->getStudentId() ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="align-content: center;text-align: center;">
                                        <?php echo __('No Data found', 'Soict') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="lecturer-col lecturer-col-2">
                <div class="tablenav top"><?php echo __('Company', 'Soict') ?></div>

                <div class="table-wrap">
                    <div class="table-scroll">
                        <table class="wp-list-table widefat fixed striped">
                            <colgroup>
                                <col width="30"/>
                                <col />
                            </colgroup>
                            <tbody>
                            <?php $companies = $this->getCompanies() ?>
                            <?php if ($companies->getSize()): ?>
                                <?php foreach ($companies as $item): ?>
                                    <tr id="<?php echo $item->getId() ?>">
                                        <td class="column column-radio">
                                            <input type="radio" id="company-<?php echo $item->getId() ?>"
                                                   name="checked_company" value="<?php echo $item->getId() ?>"
                                                   class="administrator bbp_keymaster"/>
                                        </td>

                                        <td class="column column-name">
                                            <label for="company-<?php echo $item->getId() ?>">
                                                <?php echo $item->getName() ?>
                                            </label>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" style="align-content: center;text-align: center;">
                                        <?php echo __('No Data found', 'Soict') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="lecturer-col lecturer-col-3">
                <div class="tablenav top"><?php echo __('Lecturer', 'Soict') ?></div>
                <div class="table-wrap">
                    <div class="table-scroll">
                        <table class="wp-list-table widefat fixed striped">
                            <colgroup>
                                <col width="30"/>
                                <col />
                            </colgroup>
                            <tbody>
                            <?php $lecturers = $this->getLecturers() ?>
                            <?php if ($lecturers->getSize()): ?>
                                <?php foreach ($lecturers as $item): ?>
                                    <tr id="<?php echo $item->getId() ?>">
                                        <td class="column column-radio">
                                            <input type="radio" id="lecturer-<?php echo $item->getId() ?>"
                                                   name="checked_lecturer" value="<?php echo $item->getId() ?>"
                                                   class="administrator bbp_keymaster"/>
                                        </td>

                                        <td class="column column-name">
                                            <label for="lecturer-<?php echo $item->getId() ?>">
                                                <?php echo $item->getName() ?>
                                            </label></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" style="align-content: center;text-align: center;">
                                        <?php echo __('No Data found', 'Soict') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="lecturer-row">
                <button type="submit" name="action" value="submit_assign" class="button">
                    <span class="submit-button-text"><?php echo __('Submit Assign', 'Soict') ?></span></button>
            </div>

        </form>
        <script type="text/javascript">
            $j = jQuery.noConflict();
            var hasSubmit = false;
            $j('#assign-form').submit(function(e){
                hasSubmit = true;
                if(!validateAssignForm(this)){
                    e.preventDefault();
                }
            });
            $j('#assign-form input').click(function(e){
                if(hasSubmit){
                    validateAssignForm($j('#assign-form'));
                }
            });

            function validateAssignForm(form){
                var passed = false;
                var error = [];
                $j(form).find('.table-wrap').each(function(){
                    var value = '';
                    $j(this).find('input').each(function(){
                        if($j(this).is(":checked")){
                            value = 1;
                            return;
                        }
                    });
                    if(value == ''){
                        passed = false;
                        error.push(1);
                        $j(this).addClass('not-valid');
                    }else{
                        passed = true;
                        $j(this).removeClass('not-valid');
                    }
                });
                if(error.length || !passed){
                    return false;
                }
                return true;
            }

        </script>

        <!--List assigned-->
        <form action="<?php echo $grid_url ?>" method="get">
            <input type="hidden" name="page" value="soict-internship-assign-lecturer"/>
            <input type="hidden" name="id" value="<?php echo $internship->getId() ?>"/>

            <p class="search-box">
                <a href="<?php echo $grid_url ?>&reset=1" class="button" title="reset" rel="nofollow"><?php echo __('Reset Filter', 'Soict') ?></a>
            </p>
            <p class="search-box">
                <label class="screen-reader-text" for="user-search-input"><?php echo __('Search Student:') ?></label>
                <input type="search" id="user-search-input" name="s" value="<?php echo $search ?>">
                <button type="submit" id="search-submit" class="button" name="action" value="search"><?php echo __('Search', 'Soict') ?></button>
            </p>

            <div class="tablenav top">
                <?php include \SoictApp::getView('grid/paging.php', 'backend') ?>
                <br class="clear">
            </div>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <!--col 1 -->
                    <th scope="col" id="student" class="manage-column column-student">
                        <span><?php echo __('Student', 'Soict') ?></span>
                    </th>


                    <!--col 2 -->
                    <th scope="col" id="company_name" class="manage-column column-company_name">
                        <span><?php echo __('Company', 'Soict') ?></span>
                    </th>

                    <!--col 3-->
                    <th scope="col" id="lecturer" class="manage-column column-lecturer">
                        <span><?php echo __('Lecturer', 'Soict') ?></span>
                    </th>

                    <!--col 4-->
                    <th scope="col" id="action" class="manage-column column-action">
                        <span><?php echo __('Action', 'Soict') ?></span>
                    </th>

                    <!--col 5-->
                    <th scope="col" id="assign-lecturer" class="manage-column assign-lecturer">
                        <span><?php echo __('', 'Soict') ?></span>
                    </th>
                </tr>
                </thead>

                <tbody id="the-list">
                <?php if ($collection->getSize()): ?>
                    <?php foreach ($collection as $item): ?>

                    <tr id="row-item-<?php echo $item->getId() ?>">
                        <!--<th scope="row" class="check-column">
                            <input type="checkbox" name="mass_action[]" id="item_<?php /*echo $item->getId() */?>"
                                   class="administrator bbp_keymaster" value="<?php /*echo $item->getId() */?>">
                        </th>-->

                        <td class="column column-student_name column-primary">
                            <span><?php echo __($this->getStudentName($item->getStudentId()), 'Soict') ?></span>
                        </td>

                        <td class="column column-company_name">
                            <span><?php echo __($this->getCompanyName($item->getCompanyId()), 'Soict') ?></span>
                        </td>

                        <td class="column column-lecturer_name">
                            <span><?php echo __($this->getLecturerName($item->getLecturerId()), 'Soict') ?></span>
                        </td>

                        <td class="column column-action">
                            <a href="javascript: confirmDelete('<?php echo $grid_url ?>&action=delete&item_id=<?php echo $item->getId() ?>')">
                                <span><?php echo __('Delete', 'Soict') ?></span></a>
                        </td>

                        <td class="column assign-lecturer">
                            <?php if(!$item->getLecturerId()): ?>
                                <a href="<?php echo $grid_url ?>-edit&id=<?php echo $item->getId()
                                ?>&internship_id=<?php echo $internship->getId()
                                ?>&student_id=<?php echo $item->getStudentId() ?>&company_id=<?php echo $item->getStudentId() ?>">
                                    <span><?php echo __('Assign lecturer', 'Soict') ?></span></a>
                            <?php endif; ?>
                        </td>
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

                </tbody>

            </table>

        </form>
    </div>

    <div class="avada-thanks">
        <p class="description"><?php echo __("Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict"); ?></p>
    </div>
</div>
