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
	require_once('init/functions/student/programInternship.php');
	$student = new Student();
	$programInternship = new ProgramIntenrship();
	if($data = $_POST){
		if($data['request_change_company']){
			$attach_reason = '';
			if(isset($_FILES['attach_reason'])){
				$attach_reason = $_FILES['attach_reason'];
			}
			$programInternship->requestChangeCompany($data, $attach_reason);
		}
		if($data['student_information_update']){
			$registration_form = '';
			$report_internship = '';
			if(isset($_FILES['registration_form']))
				$registration_form = $_FILES['registration_form'];
			if(isset($_FILES['report_internship']))
				$report_internship = $_FILES['report_internship'];

			$programInternship->updateStudentInformation($data, $registration_form, $report_internship);
		}
	}
	$statuses = $student->getProgramStatus();
//	if($_POST){
//		$data = $_POST;
//		$file = '';
//		if(isset( $_FILES['program_student']))
//			$file = $_FILES['program_student'];
//		$university->updateProgram($data,$file,BASE_PATH);
//	}
	$program_id = $_GET['university-edit-program'];
	$programData = $student->getProgramData($program_id);
	//$students = $university->getStudentByProgramId($program_id);
	$allCompanyInProgram = $programInternship->getAllCompanyInProgram($program_id);
	$student_id = $user_id = get_current_user_id();
	$companyStudentJoined = $programInternship->getCompanyStudentJoined($program_id);
	$student_code = get_user_meta($student_id, 'student_code', true);
	$studentInfo = $student->getStudentInforWithProgram($student_code, $program_id);

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
				<div class="left"><h2><?php _e('Your internship program details', 'academy'); ?></h2></div>
				<table class="">
					<tbody>
						<tr>
							<th><?php _e('Program name','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $programData['name']; ?>
								</div>
							</td>
						</tr>
						<?php
							$maxCourse = 0;
							$year = date('Y');
							// HUST
							$maxCourse = $year - 1955;
						?>
						<tr>
							<th><?php _e('Course','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $programData['course']; ?>
								</div>
							</td>
						</tr>

						<tr>
							<th><?php _e('Class','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $studentInfo['class']; ?>
								</div>
							</td>
						</tr>

						<tr>
							<th><?php _e('Hoc phan','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $studentInfo['hoc_phan']; ?>
								</div>
							</td>
						</tr>

						<tr>
							<th><?php _e('Requirement','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $programData['requirement']; ?>
								</div>
							</td>
						</tr>

						<!-- date -->
						<tr>
							<th><?php _e('Start date (dd/mm/YYYY)','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo date('d/m/Y', strtotime($programData['start_date'])) ?>
								</div>
							</td>
						</tr>
						<tr>
							<th><?php _e('End date (dd/mm/YYYY)','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo date('d/m/Y', strtotime($programData['end_date'])) ?>
								</div>
							</td>
						</tr>
						<tr>
							<th><?php _e('Status','academy'); ?><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<?php echo $statuses[$programData['status']] ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
<!--				<button type="submit">--><?php //_e('Save Changes','academy'); ?><!--</button>-->
<!--				<a href="#" class="element-button submit-button"><span class="button-icon save"></span>--><?php //_e('Save Changes','academy'); ?><!--</a>-->
<!--				<input type="hidden" name="user_action" value="update_settings" />-->
<!--				<input type="hidden" name="nonce" value="--><?php //echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?><!--" />-->
			</form>

			<div class="clear"></div>
			<!-- student information -->
			<div class="left" style="padding-top: 15px;">
				<h2>
					<?php _e('Student information for internship', 'academy');	?>
				</h2>
			</div>
			<div class="clear"></div>
			<form action="<?php echo themex_url(); ?>" class="formatted-form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="student_information_update" value="1"/>
				<input type="hidden" name="program_id" value="<?php echo $program_id; ?>"/>
				<input type="hidden" name="student_code" value="<?php echo $student_code; ?>"/>
				<table class="user-fields">
					<tbody>
						<tr>
							<th><strong><?php _e('Name', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="name" value="<?php echo $studentInfo['name']; ?>" required />
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Class', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="class" value="<?php echo $studentInfo['class']; ?>" required />
									<p><?php echo 'CNTT, CN-CNTT 2.02?'; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Course', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="course" value="<?php echo $studentInfo['course']; ?>" required />
									<p><?php echo 'K58, 59?'; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Sex', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<select name="sex" required>
										<option value="1"><?php _e('Male', 'academy'); ?></option>
										<option value="2"><?php _e('Female', 'academy'); ?></option>
										<option value="3"><?php _e('Other', 'academy'); ?></option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Current Address', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="current_address" value="<?php echo $studentInfo['current_address']; ?>" required/>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Phone', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="phone" value="<?php echo $studentInfo['phone']; ?>" required/>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Hoc phan', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="hoc_phan" value="<?php echo $studentInfo['hoc_phan']; ?>" required/>
									<p><?php echo 'IT4991, IT4992?'; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Email', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="email" value="<?php echo $studentInfo['email']; ?>" required/>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('English skill', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="english_skill" value="<?php echo $studentInfo['english_skill']; ?>" required />
									<p><?php echo 'Tên chứng chỉ và mức độ. Ví dụ TOEIC - 600. (kể cả chứng chỉ TOEIC thi tại Trường)'; ?></p>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?php _e('Programing skills', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<input type="text" name="skill" value="<?php echo $studentInfo['skill']; ?>" required/>
									<p><?php echo 'Liệt kê các kĩ năng và mức độ (đánh giá từ 0-10) cách nhau bởi dấu ;. Ví dụ JAVA - 8; .NET - 7'; ?></p>
								</div>
							</td>
						</tr>
						<?php /*
						<tr>
							<th><strong><?php _e('Your skill', 'academy'); ?></strong><span class="span-required">*</span></th>
							<td>
								<div class="field-wrapper">
									<textarea placeholder="<?php _e('Example: PHP, Java, iOS, Android...', 'academy'); ?>" name="skill"><?php echo $studentInfo['skill']; ?></textarea>
								</div>
							</td>
						</tr>
 						*/?>
					</tbody>
				</table>
				<?php if($programData['status'] == 1 || $studentInfo['registration_form']): ?>
					<p><strong><?php _e('Registration form for aspirations', 'academy'); ?></strong></p>
					<?php if($programData['status'] == 1): ?>
						<input name="registration_form" type="file"/><a href="<?php echo get_stylesheet_directory_uri().'/init/files/student/BM01_2_1_MauPhieuDangKy.doc'; ?>"><?php _e('Example file', 'academy'); ?></a>
					<?php endif; ?>
				<?php endif; ?>
				<?php if($studentInfo['registration_form']): ?>
					<p><?php _e('Your registration file: ','academy') ?><a href="<?php echo $studentInfo['registration_form'] ?>"><?php _e('Download'); ?></a> </p>
				<?php endif; ?>
				<?php if($programData['status'] >= 2): ?>
					<p><strong><?php _e('Report for internship program', 'academy'); ?></strong></p>
					<?php if($programData['status'] == 2): ?>
						<input name="report_internship" type="file"/><a href="<?php echo get_stylesheet_directory_uri().'/init/files/student/BM01_2_5_MauBaoCaoThucTap.doc'; ?>"><?php _e('Example file', 'academy'); ?></a>
					<?php endif ?>
					<?php if($studentInfo['report_internship']): ?>
						<p><?php _e('Your report file: ','academy') ?><a href="<?php echo $studentInfo['report_internship'] ?>"><?php _e('Download'); ?></a> </p>
					<?php endif; ?>
				<?php endif; ?>
				<div class="clear"></div>
				<input class="right" type="submit" class="element-button" value="<?php _e('Save Changes', 'academy'); ?>"/>
			</form>
			<div class="clear"></div>

			<!-- company -->
			<div class="left" style="padding-top: 15px;">
				<h2>
					<?php if($companyStudentJoined): ?>
						<?php $reviewData = $programInternship->getReviewForStudent($student_id, $student_code, $program_id, $companyStudentJoined['company_id']); ?>
						<?php _e('You joined this company', 'academy'); ?>
					<?php else: ?>
						<?php _e('Company for this internship program', 'academy'); ?>
					<?php endif; ?>
				</h2>
			</div>
			<?php $requestChange = $programInternship->isRequestChangeCompany($student_code, $program_id); ?>
				<table class="shop_table shop_table_responsive customer_details">
					<thead>
						<tr>
							<?php if($companyStudentJoined): ?>
								<th class="university-name"><?php _e( 'Name', 'academy' ); ?></th>
								<th class="university-website"><?php _e( 'Website', 'academy' ); ?></th>
								<th class="university-action"></th>
								<th class="university-action">
									<?php if($requestChange): ?>
										<?php _e('Your request change company', 'academy'); ?>
									<?php endif; ?>
								</th>
							<?php else: ?>
								<th class="university-id"><?php _e('#', 'academy'); ?></th>
								<th class="university-name"><?php _e( 'Name', 'academy' ); ?></th>
								<th class="university-website"><?php _e( 'Website', 'academy' ); ?></th>
								<th class="university-action"><?php _e( 'Number of Students that can receive', 'academy' ); ?></th>
								<th class="university-action"><?php _e( 'Number of Students received', 'academy' ); ?></th>
								<th class="university-action"></th>
								<th class="university-action"></th>
							<?php endif ?>
						</tr>
					</thead>
					<tbody>
					<?php if($companyStudentJoined): ?>
						<tr>
							<td class="university-name"><?php echo $programInternship->getValueCompany($companyStudentJoined['company_id'],'company_name') ?></td>
							<td class="university-website"><?php echo $programInternship->getValueCompany($companyStudentJoined['company_id'],'company_website') ?></td>
							<td class="university-action">
								<a target="_blank" href="<?php echo get_site_url().'/?view-company='.$companyStudentJoined['company_id']; ?>"><?php _e('View', 'academy'); ?></a>
							</td>
							<?php if($reviewData): ?>
								<td class="university-action reviewed_student">
									<a href="" onclick="reviewStudent('<?php echo $student_id; ?>'); return false;"><?php _e('Review student', 'academy') ?></a>
								</td>
							<?php else: ?>
								<?php /*
								<td class="university-action">
									<a class="element-button" href="" onclick="cancelJoinCompany('<?php echo $user_id; ?>', '<?php echo $companyStudentJoined['company_id']; ?>', '<?php echo $program_id; ?>', '<?php echo $student_code; ?>'); return false;"><?php _e('Cancel','academy'); ?></a>
								</td>
 								*/?>
								<td class="university-action">
									<?php if($requestChange): ?>
										<a target="_blank" href="<?php echo get_site_url().'/?view-company='.$requestChange; ?>">
											<?php echo $programInternship->getValueCompany($requestChange, 'company_name'); ?>
										</a>
										 - <?php _e('Waiting for approve', 'academy'); ?>
										<div class="clear"></div>
										<a class="element-button" href="" onclick="cancelRequestJoinOtherCompany('<?php echo $student_code; ?>', '<?php echo $program_id; ?>'); return false;"><?php _e('Cancel request','academy'); ?></a>
									<?php else: ?>
										<a class="element-button" href="" onclick="requestJoinOtherCompany('<?php echo $user_id; ?>', '<?php echo $companyStudentJoined['company_id']; ?>', '<?php echo $program_id; ?>', '<?php echo $student_code; ?>'); return false;"><?php _e('Request To Join Other Company','academy'); ?></a>
									<?php endif; ?>
								</td>
							<?php endif; ?>
						</tr>
						<?php if($reviewData): ?>
							<?php $reason = $programInternship->getBusinessUrl(); ?>
							<tr id="review_student_<?php echo $student_id; ?>" style="display: none;">
								<td colspan="6">
									<div style="with: 48%; float: left;">
										<p><b><?php _e('Review from company', 'academy'); ?></b></p>
										<div><?php echo $reviewData['review_content'] ?></div>
										<div class="clear"></div>
										<?php if($reviewData['review_file']): ?>
											<p><?php _e('Review file: ','academy').' '; ?><a href="<?php echo $reason.'/'.$reviewData['review_file'] ?>"><?php _e('Download'); ?></a> </p>
										<?php endif; ?>
										<?php if($reviewData['attendance_file']): ?>
											<p><?php _e('Attendance file: ','academy').' '; ?><a href="<?php echo $reason.'/'.$reviewData['attendance_file'] ?>"><?php _e('Download'); ?></a> </p>
										<?php endif; ?>
									</div>
									<div style="with: 48%; float: right;">
										<p><b><?php _e('Mark from lecturer', 'academy'); ?></b></p>
										<p><?php _e('Mid-term point', 'academy'); ?></p>
										<p><b><?php echo $reviewData['mid_mark_from_lecturer'] ?></b></p>
										<p><?php _e('Final point', 'academy'); ?></p>
										<p><b><?php echo $reviewData['mark_from_lecturer'] ?></b></p>
									</div>
								</td>
							</tr>
						<?php endif; ?>
					<?php else: ?>
						<?php /*
						<?php if(!empty($allCompanyInProgram)): ?>
							<?php $i = 0; ?>
							<?php foreach($allCompanyInProgram as $companyIn): ?>
								<?php $i++ ?>
								<tr>
									<td class="university-id"><?php echo $i ?></td>
									<td class="university-name"><?php echo $programInternship->getValueCompany($companyIn['company_id'],'company_name') ?></td>
									<td class="university-website"><?php echo $programInternship->getValueCompany($companyIn['company_id'],'company_website') ?></td>
									<td class="university-action"><?php echo $companyIn['number_student']; ?></td>
									<td class="university-action"><?php echo $companyIn['number_student_received']; ?></td>
									<td class="university-action">
										<?php if($companyJoined['number_student_received'] < $companyIn['number_student']): ?>
											<a class="element-button" href="" onclick="joinCompany('<?php echo $user_id; ?>', '<?php echo $companyIn['company_id']; ?>', '<?php echo $program_id; ?>', '<?php echo $student_code; ?>'); return false;"><?php _e('Join','academy'); ?></a>
										<?php else: ?>
											<?php _e('Full', 'academy'); ?>
										<?php endif ?>
									</td>
									<td class="university-action">
										<a target="_blank" href="<?php echo get_site_url().'/?view-company='.$companyIn['company_id']; ?>"><?php _e('View', 'academy'); ?></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7"><?php _e('You have not any university pending!', 'academy'); ?></td>
							</tr>
						<?php endif; ?>
						*/ ?>
						<tr>
							<td colspan="7">
								<?php _e('You are not assigned to any company!', 'academy'); ?>
								<div class="clear"></div>
								<?php if($requestChange): ?>
									<?php _e('You requested to join company: ', 'academy'); ?>
									<a target="_blank" href="<?php echo get_site_url().'/?view-company='.$requestChange; ?>">
										<?php echo $programInternship->getValueCompany($requestChange, 'company_name'); ?>
									</a>
									- <?php _e('Waiting for approve', 'academy'); ?>
									<div class="clear"></div>
									<a class="element-button" href="" onclick="cancelRequestJoinOtherCompany('<?php echo $student_code; ?>', '<?php echo $program_id; ?>'); return false;"><?php _e('Cancel request','academy'); ?></a>
								<?php else: ?>
									<a class="element-button" href="" onclick="requestJoinOtherCompany('<?php echo $user_id; ?>', '<?php echo $companyStudentJoined['company_id']; ?>', '<?php echo $program_id; ?>', '<?php echo $student_code; ?>'); return false;"><?php _e('Request To Join Company','academy'); ?></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				<?php if(!$reviewData): ?>
					<form action="<?php echo themex_url(); ?>" class="formatted-form" method="post" enctype="multipart/form-data" id="request_change_company_<?php echo $student_id; ?>" style="padding-top: 15px; display: none;">
						<h4><?php _e('Select company to join', 'academy'); ?></h4>
						<input type="submit" class="right element-button" value="<?php _e('Request', 'academy'); ?>" style="margin-bottom: 10px;">
						<input type="hidden" name="student_id" value="<?php echo $student_id; ?>"/>
						<input type="hidden" name="student_code" value="<?php echo get_user_meta($student_id, 'student_code', true); ?>"/>
						<input type="hidden" name="program_id" value="<?php echo $program_id; ?>" />
						<input type="hidden" name="request_change_company" value="1"/>
						<p><?php _e('Confirm from company', 'academy'); ?></p><input type="file" name="attach_reason" required/>
						<div class="clear"></div>
						<textarea required placeholder="<?php _e('Your reason', 'academy'); ?>" name="reason"></textarea>

						<table class="shop_table shop_table_responsive customer_details">
							<thead>
								<tr>
									<th class="university-id"><?php _e('', 'academy'); ?></th>
									<th class="university-name"><?php _e( 'Name', 'academy' ); ?></th>
									<th class="university-website"><?php _e( 'Website', 'academy' ); ?></th>
									<th class="university-action"><?php _e( 'Number of Students that can receive', 'academy' ); ?></th>
									<th class="university-action"><?php _e( 'Number of Students received', 'academy' ); ?></th>
									<th class="university-action"></th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($allCompanyInProgram)): ?>
									<?php $i = 0; ?>
									<?php foreach($allCompanyInProgram as $companyIn): ?>
										<?php $i++ ?>
										<tr>
											<td class="university-id">
												<?php if($companyJoined['number_student_received'] < $companyIn['number_student']): ?>
													<input type="radio" name="company_selected" value="<?php echo $companyIn['company_id']; ?>"/>
												<?php else: ?>
													<?php _e('Full', 'academy'); ?>
												<?php endif; ?>
											</td>
											<td class="university-name"><?php echo $programInternship->getValueCompany($companyIn['company_id'],'company_name') ?></td>
											<td class="university-website"><?php echo $programInternship->getValueCompany($companyIn['company_id'],'company_website') ?></td>
											<td class="university-action"><?php echo $companyIn['number_student']; ?></td>
											<td class="university-action"><?php echo $companyIn['number_student_received']; ?></td>
											<?php /*
											<td class="university-action">
												<?php if($companyJoined['number_student_received'] < $companyIn['number_student']): ?>
													<a class="element-button" href="" onclick="joinCompany('<?php echo $user_id; ?>', '<?php echo $companyIn['company_id']; ?>', '<?php echo $program_id; ?>', '<?php echo $student_code; ?>'); return false;"><?php _e('Join','academy'); ?></a>
												<?php else: ?>
													<?php _e('Full', 'academy'); ?>
												<?php endif ?>
											</td>
 											*/ ?>
											<td class="university-action">
												<a target="_blank" href="<?php echo get_site_url().'/?view-company='.$companyIn['company_id']; ?>"><?php _e('View', 'academy'); ?></a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="7"><?php _e('You have not any company pending!', 'academy'); ?></td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</form>
				<?php endif; ?>
			</div>
		</div>
<?php get_footer(); ?>

<script type="text/javascript">
	//join to company
	function joinCompany(student_id, company_id, program_id, student_code){
		var r = confirm("<?php _e('Do you want to join this Company?', 'academy'); ?>");
		if (r == true) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					window.location.reload(true);
				}
			};
			var url = '<?php echo get_stylesheet_directory_uri().'/controllers/student/joinProgramInternship.php'; ?>';
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("action_program=join_company&student_id=" + student_id + "&company_id=" + company_id + "&program_id=" + program_id + "&student_code=" + student_code);
		}else{
			return false;
		}
	}

	//cancel joining to company
	function cancelJoinCompany(student_id, company_id, program_id, student_code){
		var r = confirm("<?php _e('Do you want to cancel joining this Company?', 'academy'); ?>");
		if (r == true) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					window.location.reload(true);
				}
			};
			var url = '<?php echo get_stylesheet_directory_uri().'/controllers/student/joinProgramInternship.php'; ?>';
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("action_program=cancel_join_company&student_id=" + student_id + "&company_id=" + company_id + "&program_id=" + program_id + "&student_code=" + student_code);
		}else{
			return false;
		}
	}

	//request to join other company
	function requestJoinOtherCompany(student_id, company_id, program_id, student_code){
		var request_change_company_form = document.getElementById('request_change_company_'+student_id);
		if(request_change_company_form.style.display == 'none'){
			request_change_company_form.style.display = '';
		}else{
			request_change_company_form.style.display = 'none';
		}
	}

	//cancel request to join other company
	function cancelRequestJoinOtherCompany(student_code, program_id){
		var r = confirm("<?php _e('Do you want to cancel requesting other Company?', 'academy'); ?>");
		if (r == true) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					window.location.reload(true);
				}
			};
			var url = '<?php echo get_stylesheet_directory_uri().'/controllers/student/joinProgramInternship.php'; ?>';
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("action_program=cancel_request_other_company&program_id=" + program_id + "&student_code=" + student_code);
		}else{
			return false;
		}
	}

	//show review student from company
	function reviewStudent(student_id){
		var review_student_form = document.getElementById('review_student_'+student_id);
		if(review_student_form.style.display == 'none'){
			review_student_form.style.display = '';
		}else{
			review_student_form.style.display = 'none';
		}
	}
</script>
