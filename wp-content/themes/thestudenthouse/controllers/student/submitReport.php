<?php
/** Load WordPress Bootstrap */
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

/** Include company class */
require_once('../../init/functions/student/programInternship.php');
if($_POST){
    echo 'Chưa làm gì đâu';
    wp_redirect(get_site_url().'/internship-report');
}