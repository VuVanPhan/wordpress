<?php
    /** Load WordPress Bootstrap */
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );

    /** Include company class */
    require_once('../../init/functions/student/programInternship.php');
    if($_POST){
        $data = $_POST;
        $student_code = $data['student_code_value'];
        $student_id = get_current_user_id();
        global $wpdb;
        $dublicate = '';
        $student_meta = $wpdb->prefix.'usermeta';
        $sql = "SELECT user_id FROM ".$student_meta." WHERE (".$student_meta.".meta_key = \"student_code\")
                                                                AND (".$student_meta.".meta_value = \"".$student_code."\")
                                                                AND (".$student_meta.".user_id != \"".$student_id."\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        foreach($result as $r)
            $dublicate = $r['user_id'];
        if($dublicate){
            echo "1";
        }else{
            echo "2";
        }
    }