<?php
$company = $this->getModel();
$url = get_admin_url() . 'admin.php?page=soict-company';

?>
<div class="wrap" id="company-edit-page">
    <h1><?php echo __("Company Edit", "Soict"); ?></h1>

    <?php if (file_exists(\SoictApp::getView('notices.php', 'backend'))) include \SoictApp::getView('notices.php', 'backend'); ?>

    <h4><?php echo __("Company", "Soict") ?> <a href="<?php echo $url ?>-edit" class="page-title-action">
            <?php echo __("Add New", "Soict") ?></a>
        <a href="<?php echo $url ?>" class="page-title-action">&lt;&lt;<?php echo __("Back to Company", "Soict") ?></a></h4>

    <form action="<?php echo $url ?>-save&id=<?php echo $this->_id ?>"
          method="post" enctype="multipart/form-data" autocomplete="off">

        <h2><?php echo __("General Infomations", "Soict") ?></h2>
        <table class="form-table">
            <tbody>
            <tr class="company-name-wrap">
                <th><label for="name"><?php echo __("Company Name", "Soict") ?></label></th>
                <td><input type="text" name="name" id="name" value="<?php echo $company->getName() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-logo-wrap">
                <th><label for="logo"><?php echo __("Logo", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td>
                    <?php if($company->getLogo()): ?>
                    <img src="<?php echo \SoictApp::getFullUrl($company->getLogo()) ?>" width="55" height="55" alt="<?php echo __("Company Logo", "Soict") ?>"
                         class="photo"/>
                    <?php endif; ?>
                    <!--<label for="logo" class="button">Upload Logo</label>-->
                    <input type="file" name="logo" id="logo" value="" class="regular-text" style="display: block;"/>
                </td>
            </tr>

            <tr class="company-user_login-wrap">
                <?php if ($company->getUserLogin()): ?>
                    <th><label for="login-user"><?php echo __("Username", "Soict") ?> <span class="description"><?php echo __("(not edit)", "Soict") ?></span></label></th>
                    <td>
                        <a href="<?php echo get_admin_url() ?>user-edit.php?user_id=<?php echo $company->getUserId() ?>"
                           title="Edit user">
                            <span id="login-user" class="regular-text"><?php echo $company->getUserLogin() ?></span>
                        </a>
                    </td>
                <?php else: ?>
                    <th><label for="login-user"><?php echo __("Username", "Soict") ?></label></th>
                    <td>
                        <input type="text" name="user_name" id="login-user" autocomplete="off" class="regular-text">
                    </td>
                <?php endif; ?>
            </tr>

            <tr class="company-name-wrap">
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

            <tr class="company-email-wrap">
                <th><label for="email"><?php echo __("Email", "Soict") ?></label></th>
                <td><input type="text" name="email" id="email" value="<?php echo $company->getEmail() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-hr_email-wrap">
                <th><label for="hr_email"><?php echo __("HR Email", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="hr_email" id="hr_email" value="<?php echo $company->getHrEmail() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-address-wrap">
                <th><label for="address"><?php echo __("Address", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="address" id="address" value="<?php echo $company->getAddress() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-hr_phone-wrap">
                <th><label for="hr_email"><?php echo __("HR Phone", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="hr_phone" id="hr_phone" value="<?php echo $company->getHrPhone() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-field-wrap">
                <th><label for="field"><?php echo __("Field", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="field" id="field" value="<?php echo $company->getField() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="company-birthday-wrap">
                <th><label for="field"><?php echo __("Birthday", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="birthday" id="birthday" value="<?php echo $company->getBirthday() ?>"
                           placeholder="2017-12-31" class="regular-text"></td>
            </tr>

            <tr class="company-seniority-wrap">
                <th><label for="field"><?php echo __("Seniority", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="seniority" id="seniority" value="<?php echo $company->getSeniority() ?>"
                           placeholder="Year" class="regular-text"></td>
            </tr>

            <tr class="company-description-wrap">
                <th><label for="field"><?php echo __("Description", "Soict") ?> <span class="optional-field"><?php echo __("(optional)", "Soict") ?></span></label></th>
                <td>
                    <textarea id="description" name="description" cols="120" rows="10"
                              value="<?php echo $company->getDescription() ?>"></textarea>
                </td>
            </tr>

            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save Company", "Soict") ?>"/>
        </p>
    </form>

</div>
