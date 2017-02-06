<?php get_sidebar('profile-left'); ?>
<?php
	require_once('init/functions/student/student.php');
	$student = new Student();
	$universityIds = $student->getAllUniversityIds();
//foreach ($universityIds as $universityId) {
//	var_dump($student->getValueUniversity($universityId,'university_name'));
//}

?>
<div class="column fivecol">
	<?php ThemexInterface::renderTemplateContent('profile'); ?>
	<form action="<?php echo themex_url(); ?>" class="formatted-form" method="POST" id="cv-form">
		<div class="message">
			<?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
		</div>
		<?php
			$ID = get_current_user_id();
			$meta=get_user_meta($ID);
		?>
		<h1>Thông tin cá nhân</h1>
		<div class="form-group required">
			<label for="name">Họ và tên</label>
			<input type="text" class="form-control required" id="student_name" name="student_name" value="<?php echo esc_attr(themex_value($meta, 'student_name')); ?>" placeholder="Họ tên">
		</div>
		<div class="form-group required">
			<label for="class">Lớp</label>
			<input type="text" class="form-control required" id="student_class" name="student_class" value="<?php echo esc_attr(themex_value($meta, 'student_class')); ?>" placeholder="Lớp">
			<small id="classHelp" class="form-text text-muted">CNTT, CN-CNTT 2.02?</small>
		</div>
		<div class="form-group required">
			<label for="grade">Khóa</label>
			<input type="text" class="form-control required" id="student_grade" name="student_grade" value="<?php echo esc_attr(themex_value($meta, 'student_grade')); ?>" placeholder="Khóa">
			<small id="classHelp" class="form-text text-muted">K58, 59?</small>
		</div>
		<fieldset class="form-group required">
			<label>Chương trình đào tạo</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="program_university" value="1" <?php if (themex_value($meta, 'program_university')==1) echo 'checked';?>>
					Cử nhân
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="program_university" value="2" <?php if (themex_value($meta, 'program_university')==2) echo 'checked';?>>
					Kỹ sư
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="program_university" value="3" <?php if (themex_value($meta, 'program_university')==3) echo 'checked';?>>
					CLC
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="program_university" value="4" <?php if (themex_value($meta, 'program_university')==4) echo 'checked';?>>
					Việt Nhật
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="program_university"  value="5" <?php if (themex_value($meta, 'program_university')==5) echo 'checked';?> />
					Khác
				</label>
			</div>
		</fieldset>
		<div class="form-group required">
			<label for="student-id">Mã số sinh viên</label>
			<input type="text" class="form-control required" id="student-id" name="student_id" value="<?php echo esc_attr(themex_value($meta, 'student_id')); ?>"  placeholder="MSSV">
		</div>
		<fieldset class="form-group required">
			<label>Giới tính</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="gender" id="male" value="1" <?php if (themex_value($meta, 'gender')==1) echo 'checked';?>>
					Nam
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input required" name="gender" id="female" value="2" <?php if (themex_value($meta, 'gender')==2) echo 'checked';?>>
					Nữ
				</label>
			</div>
		</fieldset>
		<fieldset class="form-group">
			<label>Laptop</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="laptop" id="laptop-yes" value="1" <?php if (themex_value($meta, 'laptop')==1) echo 'checked';?>>
					Có
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="laptop" id="laptop-no" value="2" <?php if (themex_value($meta, 'laptop')==2) echo 'checked';?>>
					Không
				</label>
			</div>
		</fieldset>
		<div class="form-group required">
			<label for="address">Địa chỉ hiện tại</label>
			<input type="text" class="form-control required" id="address" name="address"  value="<?php echo esc_attr(themex_value($meta, 'address')); ?>"  placeholder="Địa chỉ">
		</div>

		<div class="form-group required">
			<label for="telephone">Điện thoại</label>
			<input type="text" class="form-control required" id="telephone" name="telephone" value="<?php echo esc_attr(themex_value($meta, 'telephone')); ?>" placeholder="Điện thoại">
		</div>

		<div class="form-group required">
			<label for="email">Địa chỉ email</label>
			<input type="email" class="form-control required" id="email" name="email" value="<?php echo esc_attr(themex_value($meta, 'email')); ?>" placeholder="Email">
		</div>

		<div class="form-group required">
			<label for="subject">Mã môn học</label>
			<input type="text" class="form-control required" id="subject" name="subject" value="<?php echo esc_attr(themex_value($meta, 'subject')); ?>"  aria-describedby="subjectHelp">
			<small id="subjectHelp" class="form-text text-muted">IT4991, IT4992,...</small>
		</div>

		<h1>Kĩ năng</h1>
		<div class="form-group required">
			<label for="english">Kỹ năng Tiếng Anh</label>
			<input type="text" class="form-control required" id="english" name="english" value="<?php echo esc_attr(themex_value($meta, 'english')); ?>"  aria-describedby="englishHelp" placeholder="Kỹ năng Tiếng Anh">
			<small id="englishHelp" class="form-text text-muted">Các chứng chỉ đã có. VD: TOEIC - 600; IELTS - 6.0;... (kể cả chứng chỉ thi TOEIC tại Trường)</small>
		</div>

		<div class="form-group required">
			<label for="programming-skill">Kỹ năng lập trình ở mức độ - có thể sử dụng</label>
			<input type="text" class="form-control required" id="programming-skill" name="programming_skill" value="<?php echo esc_attr(themex_value($meta, 'programming_skill')); ?>" aria-describedby="programmingHelp" placeholder="Kỹ năng lập trình">
			<small id="programmingHelp" class="form-text text-muted">Liệt kê các kỹ năng, cách bởi dấu ;. VD: JAVA; .NET;...</small>
		</div>

		<div class="form-group required">
			<label for="programming-skill-good">Kỹ năng lập trình ở mức độ - thành thạo</label>
			<input type="text" class="form-control required" id="programming-skill-good" name="programming_skill_good" value="<?php echo esc_attr(themex_value($meta, 'programming_skill_good')); ?>"  aria-describedby="programmingGoodHelp" placeholder="Kỹ năng lập trình">
			<small id="programmingGoodHelp" class="form-text text-muted">Liệt kê các kỹ năng, cách bởi dấu ;. VD: JAVA; .NET;...</small>
		</div>

		<div class="form-group required">
			<label for="programming-skill-best">Kỹ năng lập trình ở mức độ - làm chủ được công nghệ, đã có kinh nghiệm thực tế</label>
			<input type="text" class="form-control required" id="programming-skill-best" name="programming_skill_best" value="<?php echo esc_attr(themex_value($meta, 'programming_skill_best')); ?>"  aria-describedby="programmingBestHelp" placeholder="Kỹ năng lập trình">
			<small id="programmingBestHelp" class="form-text text-muted">Liệt kê các kỹ năng, cách bởi dấu ;. VD: JAVA; .NET;...</small>
		</div>

		<div class="form-group">
			<label for="networking-skill">Kỹ năng quản trị hệ thống, quản trị mạng</label>
			<input type="text" class="form-control" id="networking-skill" name="networking_skill" value="<?php echo esc_attr(themex_value($meta, 'networking_skill')); ?>" aria-describedby="networkingHelp" placeholder="Networking">
			<small id="networkingHelp" class="form-text text-muted">Liệt kê các kỹ năng, cách bởi dấu ;. VD: Firewall; DNS;...</small>
		</div>

		<div class="form-group">
			<label for="networking-certificate">Các kỹ năng và chứng chỉ khác (nếu có)</label>
			<input type="text" class="form-control" id="networking-certificate" name="skill_certificate" value="<?php echo esc_attr(themex_value($meta, 'skill_certificate')); ?>" aria-describedby="networkingCerHelp" placeholder="Certificate">
			<small id="networkingCerHelp" class="form-text text-muted">Liệt kê các kỹ năng. VD: CCNA; Data mining; MCSA;...</small>
		</div>
		<h1>Nội dung thực tập</h1>
		<div class="form-group">
			<label for="internship-experience">Kinh nghiệm thực tập</label>
			<input type="text" class="form-control" id="internship-experience" value="<?php echo esc_attr(themex_value($meta, 'internship_experience')); ?>" name="internship_experience" aria-describedby="expHelp">
			<small id="expHelp" class="form-text text-muted">Nêu tên công ty và thời gian thực tập. Mỗi công ty 1 dòng. VD: 08/2015 - 02/2016: BKAV</small>
		</div>

		<fieldset class="form-group">
            <?php $internArea = explode(',', esc_attr(themex_value($meta, 'intern_area')))?>
			<label>Lĩnh vực mong muốn thực tập</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area1" value="1"
                        <?php if (in_array(1, $internArea)) echo 'checked'; ?>>
					Mobile Android
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area2" value="2"
                        <?php if (in_array(2, $internArea)) echo 'checked'; ?>>
					Mobile IOS
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area3" value="3"
                        <?php if (in_array(3, $internArea)) echo 'checked'; ?>>
					JAVA programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area4" value="4"
                        <?php if (in_array(4, $internArea)) echo 'checked'; ?>>
					.NET programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area5" value="5"
                        <?php if (in_array(5, $internArea)) echo 'checked'; ?>/>
					PHP programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area6" value="6"
                        <?php if (in_array(6, $internArea)) echo 'checked'; ?>/>
					Sys admin (quản trị hệ thống cloud, database, server...)
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area7" value="7"
                        <?php if (in_array(7, $internArea)) echo 'checked'; ?>/>
					Web programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area8" value="8"
                        <?php if (in_array(8, $internArea)) echo 'checked'; ?>/>
					Desktop app programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area9" value="9"
                        <?php if (in_array(9, $internArea)) echo 'checked'; ?>/>
					Server side, system programming
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area10" value="10"
                        <?php if (in_array(10, $internArea)) echo 'checked'; ?>/>
					Embedded
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" name="intern_area[]" id="intern-area11" value="11"
                        <?php if (in_array(11, $internArea)) echo 'checked'; ?>/>
					Khác
				</label>
			</div>
		</fieldset>

		<h1>Dành cho sinh viên đã có địa chỉ thực tập</h1>
		<div class="form-group">
			<label for="internship-company">Tên công ty (nếu đã được nhận thực tập và có dấu xác nhận)</label>
			<input type="text" class="form-control" id="internship-company" name="internship_company" value="<?php echo esc_attr(themex_value($meta, 'internship_company')); ?>" aria-describedby="internComHelp">
			<small id="internComHelp" class="form-text text-muted">Thời gian thực tập tại công ty phải trùng hoặc bao phủ thời gian đợt thực tập</small>
		</div>

		<div class="form-group">
			<label for="hr">Tên người phụ trách tuyển dụng phía công ty</label>
			<input type="text" class="form-control" id="hr" name="hr" value="<?php echo esc_attr(themex_value($meta, 'hr')); ?>">
		</div>

		<div class="form-group">
			<label for="hr-email">Email người phụ trách</label>
			<input type="email" class="form-control" id="hr-email" name="hr_email" value="<?php echo esc_attr(themex_value($meta, 'hr_email')); ?>" >
		</div>

		<div class="form-group">
			<label for="hr-phone">SĐT liên hệ của người phụ trách</label>
			<input type="text" class="form-control" id="hr-phone" name="hr_phone" value="<?php echo esc_attr(themex_value($meta, 'hr_phone')); ?>">
		</div>
		<input id="input_submit_form" type="submit" value="<?php _e('Save Changes','academy'); ?>" />
<!--		<a href="#" class="element-button submit-button"><span class="button-icon save"></span>--><?php //_e('Save Changes','academy'); ?><!--</a>-->
		<input type="hidden" name="user_action" value="update_profile" />
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
	</form>
	<script>
//		$('document').ready(function () {
//			var v = $("#cv-form").validate();
//		});
	</script>
	<script type="text/javascript">
		var university = document.getElementById('university');
		var student_code = document.getElementById('student_code');
		var student_course = document.getElementById('student_course');
		var student_code_input = document.getElementById('student_code_input');
		function selectUniversity(){
			if(university.value){
				student_code.style.display = '';
				student_course.style.display = '';
				student_code_input.required = 'required';
			}else{
				student_code_input.removeAttribute("required");
				student_code.style.display = 'none';
				student_code_input.value = '';
				student_course.style.display = 'none';
			}
		}

		if(university.value) {
			student_code.style.display = '';
			student_course.style.display = '';
			student_code_input.required = 'required';
		}

		//view University information
		function viewUniversity(){
			var url = "<?php echo get_site_url().'/?view-university='; ?>";
			if(university.value){
				window.open(url+university.value, '_blank');
			}
		}

		//validate student code
		function validate_code(){
			var student_code_value = student_code_input.value;
			var input_submit_form = document.getElementById('input_submit_form');
			input_submit_form.disabled = "disabled";
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function () {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					var response = xhttp.responseText;
					var code_error = document.getElementById('code_error');
					input_submit_form.removeAttribute("disabled");
					if(response == '1'){
						student_code_input.value = '';
						code_error.style.display = '';
						student_code_input.style.borderColor ="#ff0000";
					}else{
						code_error.style.display = 'none';
						student_code_input.style.borderColor = "";
					}
				}
			};
			var url = '<?php echo get_stylesheet_directory_uri().'/controllers/student/validateStudentCode.php'; ?>';
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("student_code_value=" + student_code_value);
		}
	</script>
</div>