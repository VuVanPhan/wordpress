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
require_once('init/functions/student/student.php');
$student = new Student();
$studentResult = array();
$studentInfo = $student->getStudentRate();

    $programId = $studentInfo['program_id'];
    $programDetail = $student->getProgramDetailByProgramId($programId);
    $studentResult[] = array(
        'name' => $programDetail['name'],
        'rate1' => $studentInfo['rate_1'],
        'rate2' => $studentInfo['rate_2'],
        'company_score' => $studentInfo['company_score'],
        'report_score' => $studentInfo['report_score']
    );


?>
<?php get_header(); ?>
    <table class="shop_table shop_table_responsive customer_details">
        <thead>
        <tr>
            <th>Tên môn học</th>
            <th class="rate-1">Đánh giá lần 1</th>
            <th class="rate-2">Đánh giá lần 2</th>
            <th class="score-company">Điểm công ty</th>
            <th class="score-report">Điểm báo cáo</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($studentResult as $result): ?>
        <tr>
            <td><?php echo $result['name'];?></td>
            <td><?php echo $result['rate1'];?></td>
            <td><?php echo $result['rate2'];?></td>
            <td><?php echo $result['company_score'];?></td>
            <td><?php echo $result['report_score'];?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php get_footer(); ?>