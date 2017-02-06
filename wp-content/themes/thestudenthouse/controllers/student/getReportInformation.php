<?php
/** Load WordPress Bootstrap */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

/** Include company class */
require_once('../../init/functions/student/programInternship.php');
require_once('../../init/functions/student/student.php');
$student = new Student();

if($_POST){
    $studentId = $_POST['student_id'];
    $programId = $_POST['program_id'];
    $reportLink = $student->getStudentReport($studentId, $programId);
    if ($reportLink) {
        $html = "<h2>Đã nộp báo cáo. Download báo cáo đã nộp tại <a href=".get_site_url()."/".$reportLink.">Đây</a> </h2>";
        echo $html;
    } else {
        echo 'Chưa nộp báo cáo học phần';
    }
}