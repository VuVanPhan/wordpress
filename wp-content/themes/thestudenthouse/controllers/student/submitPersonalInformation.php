<?php
/** Load WordPress Bootstrap */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
if($_POST){
    $data = $_POST;
    $insertData = $data;
    $insertData['user_id'] = 1;

    global $wpdb;
    $table_internship_student_cv = $wpdb->prefix. "internship_student_cv";


    $wpdb->insert(
        $table_internship_student_cv,
        $insertData
    );
    var_dump($insertData);die();
    //wp_redirect(get_site_url().'/internship-cv');
}