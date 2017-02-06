<link href="<?php echo get_stylesheet_directory_uri().'/init/skin/css/menu.css' ?>" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" src="<?php echo get_stylesheet_directory_uri().'/init/skin/js/easytabs.js' ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri().'/init/skin/css/tab/easy-responsive-tabs.css' ?>" />
<script src="<?php echo get_stylesheet_directory_uri().'/init/skin/js/tab/jquery-1.9.1.min.js' ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri().'/init/skin/js/tab/easyResponsiveTabs.js' ?>"></script>
<?php
	include('init/functions/company/company.php');
	$company = new Company();
	$user_id = get_current_user_id();
	$companyData = $company->getCompanyData($user_id);
?>
<?php get_header(); ?>
<div class="user-profile">
	<?php get_sidebar('profile-left'); ?>
    <div class="column fivecol" >
    <div id="companyTab">
        <ul class="resp-tabs-list hor_1">
            <li><?php _e('Company profile','academy') ?></li>
            <li><?php _e('Internship Program','academu') ?></li>
            <li>Horizontal 3</li>
        </ul>
        <div class="resp-tabs-container hor_1">
            <div class="column">
                <form action="<?php echo get_stylesheet_directory_uri().'/controllers/company/submitCompany.php'; ?>" class="formatted-form" method="POST">
                    <div class="message">
                        <?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
                    </div>
                    <table class="user-fields">
                        <tbody>
                            <tr>
                                <th><?php _e('Company name','academy'); ?></th>
                                <td>
                                    <div class="field-wrapper">
                                        <input type="text" name="name" value="<?php echo $companyData['name']; ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e('Description','academy'); ?></th>
                            </tr>
                        </tbody>
                    </table>
                    <?php ThemexInterface::renderEditor('description', $companyData['description']); ?>
                    <input type="hidden" name="company_id" value="<?php echo $companyData['company_id']; ?>" />
                    <button type="submit" class="element-button submit-button"><span class="button-icon save"></span><?php _e('Save Changes','academy'); ?></button>
                </form>
            </div>
            <div id="tabcontent2">
                zfdsfd
            </div>
        </div>
    </div>
    </div>
	<?php get_sidebar('profile-right'); ?>
</div>
<?php get_footer(); ?>

<!--Plug-in Initialisation-->
<script type="text/javascript">
    $(document).ready(function() {
        //Horizontal Tab
        $('#companyTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        // Child Tab
        $('#ChildVerticalTab_1').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true,
            tabidentify: 'ver_1', // The tab groups identifier
            activetab_bg: '#fff', // background color for active tabs in this group
            inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
            active_border_color: '#c1c1c1', // border color for active tabs heads in this group
            active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
        });

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
