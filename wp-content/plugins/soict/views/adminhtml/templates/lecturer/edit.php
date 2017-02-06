<?php
$lecturer = $this->getModel();
$url = get_admin_url() . 'admin.php?page=soict-lecturer';

?>
<div class="wrap" id="lecturer-edit-page">
    <h1><?php echo __("Lecturer Edit", "Soict"); ?></h1>

    <?php if (file_exists(\SoictApp::getView('notices.php', 'backend'))) include \SoictApp::getView('notices.php', 'backend'); ?>

    <h4><?php echo __("Lecturer", "Soict") ?> <a href="<?php echo $url ?>-edit" class="page-title-action">
            <?php echo __("Add New", "Soict") ?></a>
        <a href="<?php echo $url ?>" class="page-title-action">&lt;&lt;<?php echo __("Back", "Soict") ?></a></h4>

    <form action="<?php echo $url ?>-save&id=<?php echo $this->_id ?>"
          method="post" enctype="multipart/form-data" autocomplete="off">

        <h2><?php echo __("General Infomations", "Soict") ?></h2>
        <table class="form-table">
            <tbody>
            <tr class="lecturer-name-wrap">
                <th><label for="name"><?php echo __("Lecturer Name", "Soict") ?></label></th>
                <td><input type="text" name="name" id="name" value="<?php echo $lecturer->getName() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-avatar-wrap">
                <th><label for="avatar"><?php echo __("Profile Picture", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td>
                    <?php if($lecturer->getAvatar()): ?>
                        <img src="<?php echo \SoictApp::getFullUrl($lecturer->getAvatar()) ?>"
                             width="55" height="55" alt="<?php echo __("Profile Picture", "Soict") ?>"
                             class="photo"/>
                    <?php endif; ?>
                    <!--<label for="logo" class="button">Upload Logo</label>-->
                    <input type="file" name="avatar" id="avatar" value="" class="regular-text" style="display: block;"/>
                </td>
            </tr>

            <tr class="lecturer-user_login-wrap">
                <?php if ($lecturer->getUserLogin()): ?>
                    <th><label for="login-user"><?php echo __("Username", "Soict") ?> <span class="description"><?php echo __("(not edit)", "Soict") ?></span></label></th>
                    <td>
                        <a href="<?php echo get_admin_url() ?>user-edit.php?user_id=<?php echo $lecturer->getUserId() ?>"
                           title="Edit user">
                            <span id="login-user" class="regular-text"><?php echo $lecturer->getUserLogin() ?></span>
                        </a>
                    </td>
                <?php else: ?>
                    <th><label for="login-user"><?php echo __("Username", "Soict") ?></label></th>
                    <td>
                        <input type="text" name="user_name" id="login-user" autocomplete="off" class="regular-text">
                    </td>
                <?php endif; ?>
            </tr>

            <tr class="lecturer-password-wrap">
                <th><label for="name"><?php echo __("Password", "Soict") ?></label></th>
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

            <tr class="lecturer-email-wrap">
                <th><label for="email"><?php echo __("Email", "Soict") ?></label></th>
                <td><input type="text" name="email" id="email" value="<?php echo $lecturer->getEmail() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-birthday-wrap">
                <th><label for="birthday">
                        <?php echo __("Birthday", "Soict") ?>
                        <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label>
                </th>
                <td><input type="text" name="birthday" id="birthday" value="<?php echo $lecturer->getBirthday() ?>"
                           class="regular-text" placeholder="2017-12-31"></td>
            </tr>

            <tr class="lecturer-gender-wrap">
                <th><label for="gender"><?php echo __("Gender", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="gender" id="gender" value="<?php echo $lecturer->getGender() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-address-wrap">
                <th><label for="address"><?php echo __("Address", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="address" id="address" value="<?php echo $lecturer->getAddress() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-phone-wrap">
                <th><label for="hr_email"><?php echo __("Phone", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="phone" id="phone" value="<?php echo $lecturer->getPhone() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-job-wrap">
                <th><label for="job"><?php echo __("Job", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="job" id="job" value="<?php echo $lecturer->getJob() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="lecturer-profession_skill-wrap">
                <th><label for="profession_skill"><?php echo __("Profession Skill", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="profession_skill" id="profession_skill" value="<?php echo $lecturer->getProfessionSkill() ?>"
                           class="regular-text"></td>
            </tr>

            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save Lecturer", "Soict") ?>"/>
        </p>
    </form>

</div>
