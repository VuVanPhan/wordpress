<?php
/*
Template Name: Profile Settings
*/
?>
<?php
	defined('BASE_PATH') || define('BASE_PATH', dirname(__FILE__) . '/');
	require_once('init/functions/student/programInternship.php');
	$programInternship = new ProgramIntenrship();
	$company_id = $_GET['view-company-popup'];
//	$universityData = $student->getUniversityDataById($university_id);
	//$students = $university->getStudentByProgramId($program_id);
?>
<?php //get_header(); ?>
	<div class="user-profile">
		<?php //get_sidebar('profile-left'); ?>
		<div class="column eightcol">
			<form action="<?php echo themex_url(); ?>" class="formatted-form" method="post" enctype="multipart/form-data">
				<div class="message">
					<?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
				</div>
				<div class="left"><h2><?php _e('Company Details', 'academy'); ?></h2></div>
				<div class="clear"></div>
				<?php if($programInternship->getValueCompany($company_id,'company_logo')): ?>
					<img width="200" alt="" class="avatar" src="<?php echo $programInternship->getValueCompany($company_id,'company_logo'); ?>">
				<?php endif; ?>
				<table class="">
					<tbody>
					<tr>
						<th><?php _e('Company Name','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_name'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('Company Phone','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_phone'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('Company Address','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_address'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('Company Website','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<a href="<?php echo $programInternship->getValueCompany($company_id,'company_website'); ?>"><?php echo $programInternship->getValueCompany($company_id,'company_website'); ?></a>
							</div>
						</td>
					</tr>
					<?php if($uFacebook = $programInternship->getValueCompany($company_id,'company_facebook')): ?>
						<tr>
							<th><?php _e('Facebook','academy'); ?></th>
							<td>
								<div class="field-wrapper">
									<a href="<?php echo $uFacebook ?>" ><?php echo $uFacebook ?></a>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					<?php if($uTwitter = $programInternship->getValueCompany($company_id,'company_twitter')): ?>
						<tr>
							<th><?php _e('Twitter','academy'); ?></th>
							<td>
								<div class="field-wrapper">
									<a href="<?php echo $uTwitter ?>"><?php echo $uTwitter ?></a>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					<?php if($uLinkedIn = $programInternship->getValueCompany($company_id,'company_linkedin')): ?>
						<tr>
							<th><?php _e('LinkedIn','academy'); ?></th>
							<td>
								<div class="field-wrapper">
									<a href="<?php echo $uLinkedIn ?>"><?php echo $uLinkedIn ?></a>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					<!-- end add more type for customer - Michael -->

					</tbody>
				</table>
<!--				<button type="submit">--><?php //_e('Save Changes','academy'); ?><!--</button>-->
<!--				<a href="#" class="element-button submit-button"><span class="button-icon save"></span>--><?php //_e('Save Changes','academy'); ?><!--</a>-->
<!--				<input type="hidden" name="user_action" value="update_settings" />-->
<!--				<input type="hidden" name="nonce" value="--><?php //echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?><!--" />-->
			</form>

			<div class="clear"></div>
		</div>
	</div>
<?php //get_footer(); ?>