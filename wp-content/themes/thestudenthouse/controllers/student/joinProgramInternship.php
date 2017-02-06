<?php
    /** Load WordPress Bootstrap */
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );

    /** Include company class */
    require_once('../../init/functions/student/programInternship.php');
    $programInternship = new ProgramIntenrship();
    if($_POST){
        $data = $_POST;
        $action = $data['action_program'];
        switch ($action) {
            case 'join_company':
                $programInternship->joinCompany($data);
                break;
            case 'cancel_join_company':
                $programInternship->cancelJoinCompany($data);
                break;
            case 'cancel_request_other_company':
                $programInternship->cancelRequestChangeCompany($data);
                break;
        }
    }