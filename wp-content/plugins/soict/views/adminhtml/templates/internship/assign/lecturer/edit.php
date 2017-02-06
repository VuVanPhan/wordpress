<?php
//variables
$internship = $this->getInternship();
//$collection = $this->getCollection(); //collection

$url = get_admin_url() . 'admin.php?page=soict-internship';
$grid_url = $url . '-assign-lecturer-edit';

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
            <input type="hidden" name="page" value="soict-internship-assign-lecturer-edit"/>
            <input type="hidden" name="id" value="<?php echo $this->getGroupId() ?>"/>
            <input type="hidden" name="internship_id" value="<?php echo $this->getInternshipId() ?>"/>
            <input type="hidden" name="student_id" value="<?php echo $this->getStudentId() ?>"/>
            <input type="hidden" name="company_id" value="<?php echo $this->getCompanyId() ?>"/>

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

            <div class="lecturer-row assign-lecturer">
                <button type="submit" name="action" value="save" class="button">
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


    </div>

    <div class="avada-thanks">
        <p class="description"><?php echo __("Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict"); ?></p>
    </div>
</div>
