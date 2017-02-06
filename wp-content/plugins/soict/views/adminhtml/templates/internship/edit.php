<?php
$internship = $this->getModel();
$url = get_admin_url() . 'admin.php?page=soict-internship';

?>
<div class="wrap" id="internship-edit-page">
    <h1><?php echo __("Internship Edit", "Soict"); ?></h1>

    <?php if (file_exists(\SoictApp::getView('notices.php', 'backend'))) include \SoictApp::getView('notices.php', 'backend'); ?>


    <h4>
        <span><?php echo __("Internship", "Soict") ?></span>
        <a href="<?php echo $url ?>" class="page-title-action">&lt;&lt;<?php echo __("Back", "Soict") ?></a>
        <a href="<?php echo $url ?>-edit" class="page-title-action">
            <?php echo __("Add New", "Soict") ?></a>
        <?php if($internship->getId()): ?>
        &nbsp;&nbsp;&nbsp;
        <!--<a href="<?php /*echo $url */?>-assign-company&id=<?php /*echo $internship->getId() */?>" class="page-title-action"><?php /*echo __("Add Company", "Soict") */?></a>-->
        <a href="<?php echo $url ?>-assigned-company&id=<?php echo $internship->getId() ?>" class="page-title-action heavy"><?php echo __("Company", "Soict") ?></a>
        &nbsp;&nbsp;&nbsp;
        <!--<a href="<?php /*echo $url */?>-assign-student&id=<?php /*echo $internship->getId() */?>" class="page-title-action"><?php /*echo __("Add Student", "Soict") */?></a>-->
        <a href="<?php echo $url ?>-assigned-student&id=<?php echo $internship->getId() ?>" class="page-title-action heavy"><?php echo __("Student", "Soict") ?></a>
            &nbsp;&nbsp;&nbsp;
            <a href="<?php echo $url ?>-assign-lecturer&id=<?php echo $internship->getId() ?>" class="page-title-action heavy"><?php echo __("Assign Lecturer", "Soict") ?></a>
        <?php endif; ?>
    </h4>


    <form action="<?php echo $url ?>-save&id=<?php echo $this->_id ?>"
          method="post" enctype="multipart/form-data" autocomplete="off">

        <h2><?php echo __("General Infomations", "Soict") ?></h2>
        <table class="form-table">
            <tbody>

            <tr class="internship-title-wrap">
                <th><label for="title"><?php echo __("Internship Title", "Soict") ?></label></th>
                <td><input type="text" name="title" id="title" value="<?php echo $internship->getTitle() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="internship-from_date-wrap">
                <th><label for="from_date"><?php echo __("From date", "Soict") ?></label></th>
                <td>
                    <input type="text" name="from_date" id="from_date" value="<?php echo $internship->getFromDate() ?>"
                           class="regular-text" placeholder="2017-12-31">
                </td>
            </tr>

            <tr class="internship-to_date-wrap">
                <th><label for="to_date"><?php echo __("To date", "Soict") ?></label></th>
                <td><input type="text" name="to_date" id="to_date" value="<?php echo $internship->getToDate() ?>"
                           class="regular-text" placeholder="2017-12-31"></td>
            </tr>


            <tr class="internship-support_phone-wrap">
                <th><label for="support_phone"><?php echo __("Support phone", "Soict") ?> <span class="optional-field">
                            <?php echo __("(optional)", "Soict") ?></span>
                    </label></th>
                <td><input type="text" name="support_phone" id="support_phone" value="<?php echo $internship->getSupportPhone() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="internship-support_email-wrap">
                <th><label for="support_email"><?php echo __("Support email", "Soict") ?> <span class="optional-field">
                            <?php echo __("(optional)", "Soict") ?></span></label></th>
                <td><input type="text" name="support_email" id="support_email" value="<?php echo $internship->getSupportEmail() ?>"
                           class="regular-text"></td>
            </tr>

            <tr class="internship-description-wrap">
                <th>
                    <label for="description">
                        <?php echo __("Description", "Soict") ?> <span class="optional-field">
                            <?php echo __("(optional)", "Soict") ?></span>
                    </label>
                </th>
                <td>
                    <textarea id="description" name="description" cols="120" rows="10"><?php echo $internship->getDescription() ?></textarea>
                </td>
            </tr>

            <tr class="internship-status-wrap">
                <th><label for="status"><?php echo __("Status", "Soict"); ?></label></th>
                <td>
                    <select name="status" id="status">
                        <!--<option value="">— <?php /*echo __("Please select", "Soict"); */?> —</option>-->
                        <option <?php if($internship->getStatus() == 'open') echo 'selected="selected"' ?> value="open"><?php echo __("Open", "Soict"); ?></option>
                        <option <?php if($internship->getStatus() == 'closed') echo 'selected="selected"' ?> value="closed"><?php echo __("Closed", "Soict"); ?></option>

                    </select>
                </td>
            </tr>

            </tbody>
        </table>
        <script type="text/javascript">
            $j = jQuery.noConflict();
            $j(document).ready(function(){
                $j('#from_date').datepicker({dateFormat: "yy-mm-dd"});
                $j('#to_date').datepicker({dateFormat: "yy-mm-dd"});
           });
        </script>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save Internship", "Soict") ?>"/>
        </p>
    </form>

</div>
