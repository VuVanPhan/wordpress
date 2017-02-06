<?php

/** Load WordPress Bootstrap */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

if(!get_current_user_id()){
    wp_redirect(get_site_url().'/register');
    return;

}
/** Include company class */
require_once('../../init/functions/company/company.php');
$company = new Company();
if($_GET){
    $courseCompanyId = $_GET['internship_course_company_id'];
    $company->registerStudentToCourseProgram($courseCompanyId);
    wp_redirect(get_site_url().'/internship-information');
}