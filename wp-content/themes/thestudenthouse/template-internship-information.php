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
$programs = $student->getCourseInformationByStudentId();

$status = $student->getProgramStatus();
?>
<?php get_header(); ?>
    <div class="user-profile">
        <div class="container">
            <div class="message">
                <?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
            </div>
            <div class="left"><h2>Danh sách các chương trình thực tập</h2></div>
            <div class="clear"></div>
            <div>
                <table class="shop_table shop_table_responsive customer_details">
                    <thead>
                    <tr>
                        <th class="program-id"><?php _e( 'ID', 'academy' ); ?></th>
                        <th class="program-name"><?php _e( 'Name', 'academy' ); ?></th>
                        <th class="program-course"><?php _e( 'Course', 'academy' ); ?></th>
                        <th class="program-start"><?php _e( 'Start date', 'academy' ); ?></th>
                        <th class="program-end"><?php _e( 'End date', 'academy' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($programs)): ?>
                        <?php $i = 1;?>
                        <?php foreach($programs as $program): ?>
                            <?php

                                $programId = $program['internship_course_program_id'];
                                $programDetail = $student->getProgramDetailByProgramId($programId);

                            ?>
                            <tr>
                                <td class="program-id"><?php echo $i ?></td>
                                <td class="program-name"><?php echo $programDetail['name'] ?></td>
                                <td class="program-course"><?php echo $programDetail['course_code'] ?></td>
                                <td class="program-start"><?php echo date('d/m/Y', strtotime($programDetail['start_date'])); ?></td>
                                <td class="program-end"><?php echo date('d/m/Y', strtotime($programDetail['end_date'])); ?></td>
                            </tr>
                        <?php $i++;endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7"><?php _e('You have not any internship program!', 'academy'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php //get_sidebar('profile-right'); ?>
    </div>
<?php get_footer(); ?>