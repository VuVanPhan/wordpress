<?php
/*
Template Name: Profile Settings
*/
?>
<?php
if(!get_current_user_id()){
	wp_redirect(get_site_url().'/register');
	return;
}
?>
<?php
	defined('BASE_PATH') || define('BASE_PATH', dirname(__FILE__) . '/');
	require_once('init/functions/student/student.php');
	$student = new Student();
	$university_id = $_GET['view-university'];
//	$universityData = $student->getUniversityDataById($university_id);
	//$students = $university->getStudentByProgramId($program_id);
?>
<?php get_header(); ?>
	<div class="user-profile">
		<?php get_sidebar('profile-left'); ?>
		<div class="column eightcol">
			<form action="<?php echo themex_url(); ?>" class="formatted-form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="program_id" value="<?php echo $program_id; ?>" />
				<div class="message">
					<?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
				</div>
				<div class="left"><h2><?php _e('University Details', 'academy'); ?></h2></div>
				<div class="clear"></div>
				<?php if($student->getValueUniversity($university_id,'university_logo')): ?>
					<img width="200" alt="" class="avatar" src="<?php echo $student->getValueUniversity($university_id,'university_logo'); ?>">
				<?php endif; ?>
				<table class="">
					<tbody>
					<tr>
						<th><?php _e('University Name','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $student->getValueUniversity($university_id,'university_name'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('University Phone','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $student->getValueUniversity($university_id,'university_phone'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('University Address','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $student->getValueUniversity($university_id,'university_address'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th><?php _e('University Website','academy'); ?><span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<a href="<?php echo $student->getValueUniversity($university_id,'university_website'); ?>"><?php echo $student->getValueUniversity($university_id,'university_website'); ?></a>
							</div>
						</td>
					</tr>
					<?php if($uFacebook = $student->getValueUniversity($university_id,'university_facebook')): ?>
						<tr>
							<th><?php _e('Facebook','academy'); ?></th>
							<td>
								<div class="field-wrapper">
									<a href="<?php echo $uFacebook ?>" ><?php echo $uFacebook ?></a>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					<?php if($uTwitter = $student->getValueUniversity($university_id,'university_twitter')): ?>
						<tr>
							<th><?php _e('Twitter','academy'); ?></th>
							<td>
								<div class="field-wrapper">
									<a href="<?php echo $uTwitter ?>"><?php echo $uTwitter ?></a>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					<?php if($uLinkedIn = $student->getValueUniversity($university_id,'university_linkedin')): ?>
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
<?php get_footer(); ?>
