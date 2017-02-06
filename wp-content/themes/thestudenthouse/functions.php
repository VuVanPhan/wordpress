<?php
//add_action('init','ok');
//function ok(){
//   echo  get_user_meta(95,'phone',true); die('1111');
//}

//include_once(get_stylesheet_directory().'/framework/classes/widgets/themex.user.php');

define('UNIVERSITY_PREFIX', 'university_');
define('COMPANY_PREFIX', 'company_');
define('STUDENT_PREFIX', 'student_');
if(is_admin()){
    require_once('init/admin-functions.php');
}else{
    require_once('init/frontend-functions.php');
}

require_once('init/all-functions.php');
// create new table
add_action('init', 'create_new_database',10,0);
function create_new_database(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_internship_student_cv = $wpdb->prefix. "internship_student_cv";

    if($wpdb->get_var("SHOW TABLES LIKE '$table_internship_student_cv'") != $table_internship_student_cv) {
        $sql = "CREATE TABLE $table_internship_student_cv (
          internship_student_cv int(11) NOT NULL AUTO_INCREMENT,
          user_id int(11) NOT NULL DEFAULT '0',
          name VARCHAR (255) NOT NULL DEFAULT '',
          class VARCHAR (255) NOT NULL DEFAULT '',
          grade VARCHAR (255) NOT NULL DEFAULT '',
          program_university VARCHAR (255) NOT NULL DEFAULT '',
          student_id VARCHAR (30) NOT NULL DEFAULT '',
          gender SMALLINT (1) NOT NULL DEFAULT '0',
          laptop SMALLINT (1) NOT NULL DEFAULT '0',
          address VARCHAR (255) NOT NULL DEFAULT '',
          telephone VARCHAR (30) NOT NULL DEFAULT '',
          email VARCHAR (255) NOT NULL DEFAULT '',
          subject VARCHAR (255) NOT NULL DEFAULT '',
          english VARCHAR (255) NOT NULL DEFAULT '',
          programming_skill VARCHAR (255) NOT NULL DEFAULT '',
          programming_skill_good VARCHAR (255) NOT NULL DEFAULT '',
          programming_skill_best VARCHAR (255) NOT NULL DEFAULT '',
          networking_skill VARCHAR (255) NOT NULL DEFAULT '',
          certificate VARCHAR (255) NOT NULL DEFAULT '',
          internship_experience VARCHAR (255) NOT NULL DEFAULT '',
          intern_area VARCHAR (255) NOT NULL DEFAULT '',
          internship_company VARCHAR (255) NOT NULL DEFAULT '',
          hr VARCHAR (255) NOT NULL DEFAULT '',
          hr_email VARCHAR (255) NOT NULL DEFAULT '', 
          hr_phone VARCHAR (30) NOT NULL DEFAULT '', 
          UNIQUE KEY internship_student_cv (internship_student_cv)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    $table_internship_student_company_course = STUDENT_PREFIX. "internship_student_company_course";

    if($wpdb->get_var("SHOW TABLES LIKE '$table_internship_student_company_course'") != $table_internship_student_company_course) {
        $sql = "CREATE TABLE $table_internship_student_company_course (
          internship_student_company_course_id int(11) NOT NULL AUTO_INCREMENT,
          student_id int(11) NOT NULL DEFAULT '0',
          internship_course_company_id int(11) NOT NULL DEFAULT '0',
          UNIQUE KEY internship_student_company_course_id (internship_student_company_course_id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    $table_internship_student_report = STUDENT_PREFIX. "internship_student_report";

    if($wpdb->get_var("SHOW TABLES LIKE '$table_internship_student_report'") != $table_internship_student_report) {
        $sql = "CREATE TABLE $table_internship_student_report (
          internship_student_report_id int(11) NOT NULL AUTO_INCREMENT,
          student_id int(11) NOT NULL DEFAULT '0',
          program_id int(11) NOT NULL DEFAULT '0',
          report_link text NULL,
          UNIQUE KEY internship_student_report_id (internship_student_report_id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
