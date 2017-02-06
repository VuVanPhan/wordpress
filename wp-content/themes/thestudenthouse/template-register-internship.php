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
require_once('init/functions/company/company.php');
$student = new Student();
$companyObject = new Company();
$companyIds = $student->getAllProgramIds();
$status = $student->getProgramStatus();
$companyList = $student->getAllCurrentCompanyCanRegister();
$companyInformation = array();

foreach ($companyList as $company) {
    $companyInformation[]= array(
        'internship_course_company_id' => $company['internship_course_company_id'],
        'id' =>   $company['ID'],
        'name' =>   $company['display_name'],
        'website' =>   $company['user_url'],
        'can_receive' => $company['can_receive'],
        'free_slot' => $company['free_slot'],
    );
}

?>
<?php get_header(); ?>
    <div class="user-profile">
        <div class="column">
            <div class="message">
                <?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
            </div>
            <div class="left"><h2>Đăng kí thông tin thực tập</h2></div>
            <div class="clear"></div>
            <div>
                <table class="shop_table shop_table_responsive customer_details">
                    <thead>
                    <tr>
                        <th class="company-id">STT</th>
                        <th class="company-name">Tên công ty</th>
                        <th class="company-website">Website</th>
                        <th class="company-can-receive">Sinh viên có thể nhân</th>
                        <th class="company-received">Số lượng đã đăng ký</th>
                        <th class="company-view">Xem</th>
                        <th class="company-register">Đăng ký</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $index = 1;?>
                    <?php if(!empty($companyInformation)): ?>
                        <?php foreach($companyInformation as $company): ?>
                            <tr>
                                <td class="program-id"><?php echo $index; ?></td>
                                <td class="program-name"><?php echo $company['name'] ?></td>
                                <td class="program-course"><?php echo $company['website'] ?></td>
                                <td class="program-start"><?php echo $company['can_receive']; ?></td>
                                <td class="program-end"><?php echo $companyObject->numberOfStudentRegisterCourseProgram($company['internship_course_company_id']); ?></td>
                                <td class="program-action"><a href="<?php echo get_site_url().'/?view-company='.$company['internship_course_company_id']; ?>">Thông tin chi tiết</a> </td>
                                <?php if (!$companyObject->isRegisterCourseProgram($company['internship_course_company_id'])): ?>
                                <td class="program-action"><a href="<?php echo get_stylesheet_directory_uri().'/controllers/student/joinCompany.php?internship_course_company_id='.$company['internship_course_company_id']; ?>">Đăng ký</a> </td>
                                <?php else:?>
                                <td class="program-action">Đã đăng ký</td>
                                <?php endif;?>
                            </tr>
                        <?php $index++;endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Không có công ty nào!</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php //get_sidebar('profile-right'); ?>
    </div>
<?php get_footer(); ?>