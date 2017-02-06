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
	require_once('init/functions/student/programInternship.php');
	$programInternship = new ProgramIntenrship();
	$companyCourse = $_GET['view-company'];
	$companyCourseDetail = $programInternship->getCompanyDetailByCompanyCourse($companyCourse);
	$company_id = $companyCourseDetail['company_id'];
//	$universityData = $student->getUniversityDataById($university_id);
	//$students = $university->getStudentByProgramId($program_id);
?>
<?php get_header(); ?>
	<div class="user-profile">

		<div class="column eightcol">
			<form action="<?php echo themex_url(); ?>" class="formatted-form" method="post" enctype="multipart/form-data">
				<div class="message">
					<?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
				</div>
				<div class="left"><h2>Thông tin về công ty</h2></div>
				<div class="clear"></div>
				<?php if($programInternship->getValueCompany($company_id,'company_logo')): ?>
					<img width="200" alt="" class="avatar" src="<?php echo $programInternship->getValueCompany($company_id,'company_logo'); ?>">
				<?php endif; ?>
				<table class="">
					<tbody>
					<tr>
						<th>Tên công ty<span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_name'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th>Số điện thoại công ty<span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_phone'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th>Địa chỉ công ty<span class="span-required">*</span></th>
						<td>
							<div class="field-wrapper">
								<?php echo $programInternship->getValueCompany($company_id,'company_address'); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th>Website công ty<span class="span-required">*</span></th>
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
			</form>

			<div class="clear"></div>
			<br /> 	<br />
			<div class="left"><h2>Thông tin chi tiết về kì thực tập tại công ty</h2></div>
			<div class="clear"></div>
			<div>
				<div class="form-group">
					<label for="can_receive">Số lượng sinh viên có thể nhận: <?php echo $companyInformation['can_receive'];?></label>
				</div>
				<div class="form-group">
					<label for="skill">Yêu cầu về kiến thức</label>
					<p><?php echo $companyCourseDetail['skill'];?></p>
				</div>
				<div class="form-group">
					<label for="description">Nội dung công việc trong quá trình thực tập</label>
					<p><?php echo $companyCourseDetail['description'];?></p>
				</div>
				<div class="form-group">
					<label for="asset">Cơ sở vật chất</label>
					<p><?php echo $companyCourseDetail['asset'];?></p>
				</div>
				<div class="form-group">
					<label for="description_time_can_receive">Khi nào có thể nhận sinh viên</label>
					<p><?php echo $companyCourseDetail['description_time_can_receive'];?></p>
				</div>

			</div>

		</div>
	</div>
<?php get_footer(); ?>