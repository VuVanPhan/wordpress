<?php
require_once('functions/student/student.php');
require_once('functions/student/notification.php');

//update more company information
add_action('wp_ajax_themex_update_user','update_student',10,0);
add_action('wp_ajax_nopriv_themex_update_user','update_student',10,0);
add_action('wp','update_student',10,1);

function update_student()
{
    $data = $_POST;
    if (isset($_POST['data'])) {
        parse_str($_POST['data'], $data);
        $data['nonce'] = $_POST['nonce'];
    }
    $student = new Student();
    if (isset($data['user_action'])) {
        $action = sanitize_title($data['user_action']);
        $redirect = false;

        if (is_user_logged_in()) {
            $ID = get_current_user_id();

            switch ($action) {
                case 'update_profile':
                    $student->updateProfile($ID, $data);
                    break;
            }
        }
//        else {
//            switch ($action) {
//                case 'register_user':
//                    $student->registerUser($data);
//                    break;
//            }
//        }
    }
}

//save company information
//add_action('register_form','show_first_name_field');
//add_action('register_post','check_fields',10,3);
//add_action('user_register', 'register_extra_company_fields');

//function register_extra_company_fields($user_id)
//{
//    $data = $_POST['data'];
//    $data1 = explode('&',$data);
//    $array_fields = array('company_name','company_phone','company_address','company_description','company_website','contact_name','contact_phone','contact_email');
//    foreach($data1 as $d){
//        $d1 = explode('=',$d);
//        if(in_array($d1[0],$array_fields)){
//            update_user_meta( $user_id, $d1[0], $d1[1]);
//        }
//    }
//    update_user_meta( $user_id, 'phone', $phone);
//    update_user_meta( $user_id, 'type', $type);
//    $wp_user_object = new WP_User($user_id);
//    if($type == '1'){
//        $wp_user_object->set_role('business');
//    }elseif($type == '2') {
//        $wp_user_object->set_role('student');
//    }
//}


//add_filter('template_include', 'renderTemplateUniversity', 100, 1);
//function renderTemplateUniversity($template) {
//    var_dump($template);
//    var_dump(get_query_var('university-internship'));
//    foreach(ThemexCore::$components['rewrite_rules'] as $key=>$rule) {
////        if($key == 'university-internship')
//        if(get_query_var($rule['name'])) {
//            if(isset($rule['authorized'])) {
//                if($rule['authorized'] && !is_user_logged_in()) {
//                    wp_redirect(SITE_URL);
//                    exit();
//                } else if(!$rule['authorized'] && is_user_logged_in()) {
//                    wp_redirect(get_author_posts_url(get_current_user_id()));
//                    exit();
//                }
//            }
//
//            $path=THEME_PATH;
//            if(file_exists(CHILD_PATH.'template-'.$key.'.php')) {
//                $path=CHILD_PATH;
//            }
//
//            $template=$path.'template-'.$key.'.php';
//        }
//    }
//    var_dump($template);
//    return $template;
//}

//auto update data by time

add_action('init', "update_all_data", 10, 0);
function update_all_data(){
    global $wpdb;
    $now = date('Y-m-d');
    $table_update_database = UNIVERSITY_PREFIX. "auto_update_data";
    $sql = "SELECT * FROM ".$table_update_database." WHERE ".$table_update_database.".created_at < \"".$now."\"";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    foreach($result as $r){
        $auto_update_data_id = $r['auto_update_data_id'];
        $wpdb->update(
            $table_update_database,
            array('created_at' => $now),
            array('auto_update_data_id' => $auto_update_data_id)
        );

        //update internship program status

        $table_program_internship = UNIVERSITY_PREFIX. "internship_program";

        //change active to processing
        $sqlActiveToProcessing = "SELECT * FROM ".$table_program_internship." WHERE
                                                                                (".$table_program_internship.".status = \"1\")
                                                                                AND (".$table_program_internship.".start_date <= \"".$now."\")
                                                                                AND (".$table_program_internship.".end_date >= \"".$now."\")";
        $activeToProcessing = array();
        $resultActiveToProcessing = $wpdb->get_results($sqlActiveToProcessing, 'ARRAY_A');
        foreach($resultActiveToProcessing as $rActiveToProcessing)
            $activeToProcessing[] = $rActiveToProcessing['internship_program_id'];
        if($activeToProcessing){
            $wpdb->query("UPDATE ".$table_program_internship." SET ".$table_program_internship.".status = \"2\" WHERE ".$table_program_internship.".internship_program_id IN (".implode(',',$activeToProcessing).")");
        }

        //change active, processing to finished
        $toFinished = array();
        $sqlToFinished = "SELECT * FROM ".$table_program_internship." WHERE
                                                                        (".$table_program_internship.".status IN (\"1\",\"2\"))
                                                                        AND (".$table_program_internship.".end_date < \"".$now."\")";
        $resultToFinished = $wpdb->get_results($sqlToFinished, 'ARRAY_A');
        foreach($resultToFinished as $rToFinished)
            $toFinished[] = $rToFinished['internship_program_id'];
        if($toFinished){
            $wpdb->query("UPDATE ".$table_program_internship." SET ".$table_program_internship.".status = \"3\" WHERE ".$table_program_internship.".internship_program_id IN (".implode(',',$toFinished).")");
        }

        $notification = new Notification();
        $notification->updateAll();
    }
}

function login_with_email_address(&$username, &$password){
    $user_login = $username;
    $user = get_user_by_email($username);
    if(!empty($user->user_login))
        $user_login = $user->user_login;
    global $wpdb;
    $usermeta_table = $wpdb->prefix. "usermeta";
    $sql = "SELECT user_id FROM ".$usermeta_table." WHERE ".$usermeta_table.".meta_key = \"student_code\"
                                                        AND ".$usermeta_table.".meta_value = \"".$username."\"";
    $result = $wpdb->get_results($sql, "ARRAY_A");
    $user_id = '';
    foreach($result as $r)
        $user_id = $r['user_id'];
    if($user_id){
        $user = get_userdata($user_id);
        $user_login = $user->user_login;
    }
	$username = $user_login;
	// var_dump($user_login);
    // return array($user_login, $password);
}
add_action('wp_authenticate','login_with_email_address');