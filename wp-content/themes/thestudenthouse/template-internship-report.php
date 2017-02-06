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
require_once('init/functions/student/student.php');

$student = new Student();
$programs = $student->getCourseInformationByStudentId();
$programIdArray = array();
foreach ($programs as $program) {
    $programId = $program['internship_course_program_id'];
    $programDetail = $student->getProgramDetailByProgramId($programId);
    $programIdArray[] = array(
        'program_id' => $programId,
        'program_name' => $programDetail['name']

    );
}

if ($_POST) {
    $data = $_POST;
    if(isset($_FILES['report_file'])) {
        global $wpdb;
        $program_id = $data['program_id'];
        $student_id = get_current_user_id();
        $data['student_id'] = $student_id;
        $table_intership_student_report = STUDENT_PREFIX. "internship_student_report";
        $reportFile = $_FILES['report_file'];
        if($reportFile['name'] || $reportFile['name']) {
            $upload_dir = wp_upload_dir();
            $base_path = $upload_dir['path'];
            $base_path = explode('wp-content', $base_path);
            $base = $base_path[0];
            $path = $base . 'media/studentreport/studentinfo/' . $program_id . '/' . str_replace(' ', '', $student_id);

            if (!is_dir($base . 'media')) {
                mkdir($base . 'media', 0777);
            }
            if (!is_dir($base . 'media/studentreport')) {
                mkdir($base . 'media/studentreport', 0777);
            }
            if (!is_dir($base . 'media/studentreport/studentinfo')) {
                mkdir($base . 'media/studentreport/studentinfo', 0777);
            }
            if (!is_dir($base . 'media/studentreport/studentinfo/' . $program_id)) {
                mkdir($base . 'media/studentreport/studentinfo/' . $program_id, 0777);
            }
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }


            if ($reportFile['name']) {
                $target_path = $path . '/' . basename($reportFile['name']);
                move_uploaded_file($reportFile['tmp_name'], $target_path);
                $data['report_link'] = 'media/studentreport/studentinfo/' . $program_id . '/' . str_replace(' ', '', $student_id) . '/' . $reportFile['name'];
                $sql = "SELECT * FROM ".$table_intership_student_report. " WHERE student_id=".$student_id." AND program_id=".$program_id;
                $result = $wpdb->get_results($sql, "ARRAY_A");
                if (!count($result)) {
                    $wpdb->insert(
                        $table_intership_student_report,
                        $data
                    );
                } else {
                    $wpdb->update(
                        $table_intership_student_report,
                        $data,
                        array(
                            'student_id' => $student_id,
                            'program_id' => $program_id
                        )
                    );
                }



            }
        }
    }

}

?>

<?php get_header(); ?>
<h1>Nộp báo cáo</h1>
<p>Tải mẫu báo cáo tại <a href="<?php echo get_stylesheet_directory_uri().'/init/files/student/BM01_2_5_MauBaoCaoThucTap.doc'; ?>">Đây</a></p>
<br /><br />
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputFile">Báo cáo thực tập</label>
            <div>
                <label for="course-university">Chọn học phần</label>
                <div class="clear"></div>
                <select class="selectpicker" id="course-university" name="program_id">
                    <option value="">--Chọn học phần--</option>
                    <?php foreach ($programIdArray as $program): ?>
                        <option value="<?php echo $program['program_id'];?>"><?php echo $program['program_name'];?></option>
                    <?php endforeach; ?>
                </select>
                <div class="clear"></div>
                <div id="report-file-information"></div>
                <input type="file" class="form-control-file" id="exampleInputFile" name="report_file" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Chọn file để nộp báo cáo</small>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php get_footer(); ?>

<script>
    $(document).ready(function () {
        $('#course-university').change(function () {
            getReport();
        });
    });

    function getReport() {
        $.ajax(
            {
                url: '<?php echo get_stylesheet_directory_uri().'/controllers/student/getReportInformation.php'; ?>',
                method: 'POST',
                data: {
                    'student_id' : <?php echo get_current_user_id(); ?>,
                    'program_id' : $('#course-university').val()
                },
                success: function (result) {
                    $('#report-file-information').html(result);
                }
            }
        );
    }
</script>
