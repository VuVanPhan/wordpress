<?php
$student = $this->getStudent();
$url = get_admin_url().'admin.php?page=soict-student';

?>
<div class="wrap" id="student-edit-page">
    <h1><?php echo __("Student Edit", "Soict"); ?></h1>

    <?php if(file_exists( \SoictApp::getView('notices.php', 'backend'))) include \SoictApp::getView('notices.php', 'backend'); ?>

    <h4><?php echo __("Student", "Soict"); ?>
        <a href="<?php echo $url ?>-edit" class="page-title-action">
            <?php echo __("Add New", "Soict"); ?></a>
        <a href="<?php echo $url ?>" class="page-title-action">&lt;&lt; <?php echo __("Back to Student", "Soict"); ?></a>
    </h4>

    <form action="<?php echo $url ?>-save&id=<?php echo $this->_id ?>" method="post">

        <h2><?php echo __("General Infomations", "Soict"); ?></h2>
        <table class="form-table">
            <tbody>
                <tr class="student-name-wrap">
                    <th><label for="name"><?php echo __("Student Name", "Soict"); ?></label></th>
                    <td><input type="text" name="name" id="name" value="<?php echo $student->getName() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-student_id-wrap">
                    <th><label for="student_id">
                            <?php echo __("Student ID", "Soict"); ?> <span class="description">
                                <?php echo __('(required)', 'Soict') ?>
                            </span></label>
                    </th>
                    <td>
                        <input type="text" name="student_id" id="student_id" value="<?php echo $student->getUserLogin() ?>" class="regular-text">
                        <?php if($student->getUserId()): ?>
                        <a href="<?php echo get_admin_url() ?>user-edit.php?user_id=<?php echo $student->getUserId() ?>">
                            <span><?php echo __('Edit Userlogin', 'Soict') ?></span></a>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr class="company-name-wrap">
                    <th><label for="pass1"><?php echo __("Password", "Soict") ?>
                            <span class="description">
                                <?php echo __('(required)', 'Soict') ?>
                            </span></label></th>
                    <td>
                        <div class="wp-pwd">
                        <span class="password-input-wrapper">
                            <input type="password" id="pass1" name="user_pass" class="regular-text strong"
                                   autocomplete="off">
                            <input type="text" id="pass1-text" name="user_pass_text" class="regular-text strong"
                                   autocomplete="off">
                        </span>
                            <button type="button" class="button button-secondary wp-hide-pw"
                                    title="<?php echo __("Show Password", "Soict") ?>"
                                    data-title-hide="<?php echo __("Show Password", "Soict") ?>"
                                    data-title-show="<?php echo __("Hide Password", "Soict") ?>">
                                <span class="dashicons dashicons-hidden"></span>
                                <span class="text show"><?php echo __("Show", "Soict") ?></span>
                                <span class="text hide" style="display: none;"><?php echo __("Hide", "Soict") ?></span>
                            </button>
                        </div>
                        <script type="text/javascript">
                            $j = jQuery.noConflict();
                            $j(document).ready(function () {
                                $j('#pass1').keypress(function (evt) {
                                    var newValue = $j(evt.target).val() + evt.key
                                    $j('#pass1-text').val(newValue);
                                }).change(function (evt) {
                                    $j('#pass1-text').val($j(evt.target).val());
                                });
                                $j('#pass1-text').keypress(function (evt) {
                                    var newValue = $j(evt.target).val() + evt.key
                                    $j('#pass1').val(newValue);
                                }).change(function (evt) {
                                    $j('#pass1').val($j(evt.target).val());
                                });
                                $j('.wp-hide-pw').click(function () {
                                    if ($j(this).children('.dashicons').hasClass('dashicons-hidden')) {
                                        $j(this).children('.dashicons').removeClass('dashicons-hidden').addClass('dashicons-visibility');
                                        $j(this).children('.text.show').hide();
                                        $j(this).children('.text.hide').show();
                                        $j('.password-input-wrapper').addClass('show-password');
                                        $j(this).attr('title', $j(this).attr('data-title-show')); //change title button
                                    } else {
                                        $j(this).children('.dashicons').removeClass('dashicons-visibility').addClass('dashicons-hidden');
                                        $j(this).children('.text.show').show();
                                        $j(this).children('.text.hide').hide();
                                        $j('.password-input-wrapper').removeClass('show-password');
                                        $j(this).attr('title', $j(this).attr('data-title-hide')); //change title button
                                    }
                                });
                            });
                        </script>
                    </td>
                </tr>

                <tr class="student-email-wrap">
                    <th><label for="email"><?php echo __("Email", "Soict"); ?>
                            <span class="description">
                                <?php echo __('(required)', 'Soict') ?>
                            </span></label></th>
                    <td><input type="text" name="email" id="email" value="<?php echo $student->getUserEmail() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-gender-wrap">
                    <th><label for="gender"><?php echo __("Gender", "Soict"); ?></label></th>
                    <td>
                        <select name="gender" id="gender">
                            <option value="">— <?php echo __("Please select", "Soict"); ?> —</option>
                            <option <?php if($student->getGender() == 'male') echo 'selected="selected"' ?> value="male"><?php echo __("Male", "Soict"); ?></option>
                            <option <?php if($student->getGender() == 'female') echo 'selected="selected"' ?> value="female"><?php echo __("Female", "Soict"); ?></option>
                        </select>
                    </td>
                </tr>

                <tr class="student-birthday-wrap">
                    <th><label for="birthday"><?php echo __("Birthday", "Soict"); ?></label></th>
                    <td><input type="text" name="birthday" id="birthday" value="<?php echo $student->getBirthday() ?>" class="regular-text" placeholder="2017-12-31"></td>
                </tr>

                <tr class="student-class-wrap">
                    <th><label for="class"><?php echo __("Class", "Soict"); ?></label></th>
                    <td><input type="text" name="class" id="class" value="<?php echo $student->getClass() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-grade-wrap">
                    <th><label for="grade"><?php echo __("Grade", "Soict"); ?></label></th>
                    <td><input type="text" name="grade" id="grade" value="<?php echo $student->getGrade() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-university-wrap">
                    <th><label for="program_university"><?php echo __("Program/University", "Soict"); ?></label></th>
                    <td><input type="text" name="program_university" id="program_university" value="<?php echo $student->getProgramUniversity() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-address-wrap">
                    <th><label for="address"><?php echo __("Address", "Soict"); ?></label></th>
                    <td><input type="text" name="address" id="address" value="<?php echo $student->getAddress() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-telephone-wrap">
                    <th><label for="telephone"><?php echo __("Telephone", "Soict"); ?></label></th>
                    <td><input type="text" name="telephone" id="telephone" value="<?php echo $student->getTelephone() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-english-wrap">
                    <th><label for="english"><?php echo __("English Level", "Soict"); ?></label></th>
                    <td><input type="text" name="english" id="english" value="<?php echo $student->getEnglish() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-programming_skill-wrap">
                    <th><label for="programming_skill"><?php echo __("Programming Skill", "Soict"); ?></label></th>
                    <td><input type="text" name="programming_skill" id="programming_skill" value="<?php echo $student->getProgrammingSkill() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-networking_skill-wrap">
                    <th><label for="networking_skill"><?php echo __("Networking Skill", "Soict"); ?></label></th>
                    <td><input type="text" name="networking_skill" id="networking_skill" value="<?php echo $student->getNetworkingSkill() ?>" class="regular-text"></td>
                </tr>

                <tr class="student-certificate-wrap">
                    <th><label for="certificate"><?php echo __("Certificate", "Soict"); ?></label></th>
                    <td><input type="text" name="certificate" id="certificate" value="<?php echo $student->getCertificate() ?>" class="regular-text"></td>
                </tr>

            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save Student", "Soict"); ?>">
        </p>
    </form>

</div>
