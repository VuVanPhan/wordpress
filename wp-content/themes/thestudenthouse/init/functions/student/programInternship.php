<?php
/**
 * Program Internship
 *
 * Handles companies data
 *
 * @class ProgramIntenrship
 * @author Michael
 */
 
class ProgramIntenrship extends Student {
    /* Eden*/
    public function getCompanyDetailByCompanyCourse($companyCourseId) {
        global $wpdb;
        $table_company_course_company = COMPANY_PREFIX . "internship_course_company";
        $sql = "SELECT * FROM ".$table_company_course_company ." WHERE ".$table_company_course_company.
            ".internship_course_company_id = ".$companyCourseId;
        $programs = $wpdb->get_results($sql, 'ARRAY_A');
        foreach ($programs as $program) {
            $programs = $program;
            break;
        }
        return $programs;
    }

    /* End Eden*/

    /**
     * get all companies that join program by program id
     */
    public function getAllCompanyInProgram($program_id){
        global $wpdb;
        $company_internship_program_table = COMPANY_PREFIX.'internship_program_joined';
        $getCompanyIdsSql = "SELECT company_id, status, number_student, number_student_received FROM ".$company_internship_program_table." WHERE (".$company_internship_program_table.".program_id = ".$program_id.") AND (".$company_internship_program_table.".status = 1)";
        $result = $wpdb->get_results($getCompanyIdsSql, 'ARRAY_A');
        return $result;
    }

    /**
     * get value company from id and meta key
     */


    public function getValueCompany($company_id,$meta_key){
        global $wpdb;
        $company_usermeta = COMPANY_PREFIX."usermeta";
        $sql = "SELECT meta_value FROM ".$company_usermeta." WHERE ".$company_usermeta.".user_id = \"".$company_id."\" AND ".$company_usermeta.".meta_key = \"".$meta_key."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $value = '';
        foreach ($result as $r)
            $value = $r['meta_value'];
        return $value;
    }

    /**
     * join to company
     */
    public function joinCompany($data){
        $student_id = $data['student_id'];
        $company_id = $data['company_id'];
        $program_id = $data['program_id'];
        $student_code = $data['student_code'];
        if($student_id && $company_id && $program_id){
            global $wpdb;
            $company_internship_student_program_table = COMPANY_PREFIX . "internship_student_program";
            $wpdb->insert(
                $company_internship_student_program_table,
                array(
                    'company_id' => $company_id,
                    'student_id' => $student_id,
                    'student_code' => $student_code,
                    'program_id' => $program_id,
                    'created_at' => date('Y-m-d')
                )
            );

            $company_internship_program_table = COMPANY_PREFIX.'internship_program_joined';
            $numberStudentReceived = 0;
            $numberStudentReceivedSql = "SELECT number_student_received FROM ".$company_internship_program_table." WHERE (".$company_internship_program_table.".program_id = ".$program_id.") AND (".$company_internship_program_table.".company_id = ".$company_id.")";
            $result = $wpdb->get_results($numberStudentReceivedSql, 'ARRAY_A');
            foreach($result as $r)
                $numberStudentReceived = $r['number_student_received'];

            $wpdb->update(
                $company_internship_program_table,
                array('number_student_received' => $numberStudentReceived + 1),
                array(
                    'company_id' => $company_id,
                    'program_id' => $program_id
                    )
            );
        }
    }

    /**
     * cancel joining to company
     */
    public function cancelJoinCompany($data){
        $student_id = $data['student_id'];
        $company_id = $data['company_id'];
        $program_id = $data['program_id'];
        $student_code = $data['student_code'];
        if($student_code && $company_id && $program_id){
            global $wpdb;
            $company_internship_student_program_table = COMPANY_PREFIX . "internship_student_program";
            $wpdb->delete(
                $company_internship_student_program_table,
                array(
                    'company_id' => $company_id,
//                    'student_id' => $student_id,
                    'student_code' => $student_code,
                    'program_id' => $program_id,
                    'created_at' => date('Y-m-d')
                )
            );

            $company_internship_program_table = COMPANY_PREFIX.'internship_program_joined';
            $numberStudentReceived = 0;
            $numberStudentReceivedSql = "SELECT number_student_received FROM ".$company_internship_program_table." WHERE (".$company_internship_program_table.".program_id = ".$program_id.") AND (".$company_internship_program_table.".company_id = ".$company_id.")";
            $result = $wpdb->get_results($numberStudentReceivedSql, 'ARRAY_A');
            foreach($result as $r)
                $numberStudentReceived = $r['number_student_received'];

            $wpdb->update(
                $company_internship_program_table,
                array('number_student_received' => $numberStudentReceived - 1),
                array(
                    'company_id' => $company_id,
                    'program_id' => $program_id
                )
            );
        }
    }

    /**
     * get Company that student joined
     */

    public function getCompanyStudentJoined($program_id){
        $student_id = get_current_user_id();
        $student_code = get_user_meta($student_id, 'student_code', true);
        global $wpdb;
        $company_internship_student_program_table = COMPANY_PREFIX."internship_student_program";
        $sql = "SELECT company_id, program_id FROM ".$company_internship_student_program_table." WHERE ".$company_internship_student_program_table.".student_code = \"".$student_code."\" AND ".$company_internship_student_program_table.".program_id = \"".$program_id."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        foreach($result as $r)
            return $r;
    }

    /**
     * get review for student
     */
    public function getReviewForStudent($student_id, $student_code, $program_id, $company_id){
        global $wpdb;
        $company_internship_student_program_review_table = COMPANY_PREFIX . "internship_student_program_review";
        $selectExist = "SELECT * FROM ".$company_internship_student_program_review_table."
                                                WHERE (".$company_internship_student_program_review_table.".student_code = \"".$student_code."\")
                                                    AND (".$company_internship_student_program_review_table.".program_id = \"".$program_id."\")
                                                    AND (".$company_internship_student_program_review_table.".company_id = \"".$company_id."\")
                                                    ";
        $result = $wpdb->get_results($selectExist, 'ARRAY_A');
        $reviewData = '';
        foreach($result as $r)
            $reviewData = $r;
        return $reviewData;
    }

    /**
     * get business url
     */
    public function getBusinessUrl(){
        global $wpdb;
        $business_option_table = COMPANY_PREFIX.'options';
        $sql = "SELECT option_value FROM ".$business_option_table."
                                                WHERE (".$business_option_table.".option_name = \"siteurl\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        foreach($result as $r)
            return $r['option_value'];
    }

    /**
     * request change company to join
     */
    public function requestChangeCompany($data, $attach_reason){
        $student_id = $data['student_id'];
        $program_id = $data['program_id'];
        $student_code = $data['student_code'];
        $reason = $data['reason'];
        $company_id = $data['company_selected'];
        global $wpdb;
        $company_internship_student_request_join_company_table = COMPANY_PREFIX. "internship_student_request_join_company";
        $sql = "SELECT company_id FROM ".$company_internship_student_request_join_company_table." WHERE ".$company_internship_student_request_join_company_table.".student_code = \"".$student_code."\"
                                                                                                    AND ".$company_internship_student_request_join_company_table.".program_id = \"".$program_id."\"
                                                                                                    ";
        $upload_dir = wp_upload_dir();
        $base_path = $upload_dir['path'];
        $base_path = explode('wp-content', $base_path);
        $base = $base_path[0];
        $path = $base . 'media/thestudenthouse/studentinfo/changecompany/' . $program_id . '/' . str_replace(' ', '', $student_code);
        if (!is_dir($base . 'media')) {
            mkdir($base . 'media', 0777);
        }
        if (!is_dir($base . 'media/thestudenthouse')) {
            mkdir($base . 'media/thestudenthouse', 0777);
        }
        if (!is_dir($base . 'media/thestudenthouse/studentinfo')) {
            mkdir($base . 'media/thestudenthouse/studentinfo', 0777);
        }
        if (!is_dir($base . 'media/thestudenthouse/studentinfo/changecompany')) {
            mkdir($base . 'media/thestudenthouse/studentinfo/changecompany', 0777);
        }
        if (!is_dir($base . 'media/thestudenthouse/studentinfo/changecompany/' . $program_id)) {
            mkdir($base . 'media/thestudenthouse/studentinfo/changecompany/' . $program_id, 0777);
        }
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        $target_path = $path . '/' . basename($attach_reason['name']);
        move_uploaded_file($attach_reason['tmp_name'], $target_path);
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        if($result){
            $wpdb->update(
                $company_internship_student_request_join_company_table,
                array(
                    'company_id' => $company_id,
                    'student_id' => $student_id,
                    'reason' => $reason,
                    'reason_file' => 'media/thestudenthouse/studentinfo/changecompany/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $attach_reason['name'],
                ),
                array(
                    'student_code' => $student_code,
                    'program_id' => $program_id
                )
            );
        }else{
            $wpdb->insert(
                $company_internship_student_request_join_company_table,
                array(
                    'student_code' => $student_code,
                    'program_id' => $program_id,
                    'company_id' => $company_id,
                    'student_id' => $student_id,
                    'reason' => $reason,
                    'reason_file' => 'media/thestudenthouse/studentinfo/changecompany/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $attach_reason['name'],
                )
            );
        }
    }

    /**
     * cancel request change company to join
     */
    public function cancelRequestChangeCompany($data){
        $program_id = $data['program_id'];
        $student_code = $data['student_code'];
        global $wpdb;
        $company_internship_student_request_join_company_table = COMPANY_PREFIX. "internship_student_request_join_company";
        $wpdb->delete(
            $company_internship_student_request_join_company_table,
            array(
                'student_code' => $student_code,
                'program_id' => $program_id
            )
        );
    }

    /**
     * is requested Change Company
     */
    public function isRequestChangeCompany($student_code, $program_id){
        $company_id = '';
        global $wpdb;
        $company_internship_student_request_join_company_table = COMPANY_PREFIX. "internship_student_request_join_company";
        $sql = "SELECT company_id FROM ".$company_internship_student_request_join_company_table." WHERE ".$company_internship_student_request_join_company_table.".student_code = \"".$student_code."\"
                                                                                                    AND ".$company_internship_student_request_join_company_table.".program_id = \"".$program_id."\"
                                                                                                    ";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        foreach($result as $r)
            $company_id = $r['company_id'];
        return $company_id;
    }

    /**
     * update student information for internship
     */
    public function updateStudentInformation($data, $registration_form, $report_internship){
        umask(0);
        global $wpdb;
        $university_internship_student_table = UNIVERSITY_PREFIX.'internship_student';
        $program_id = $data['program_id'];
        $student_code = $data['student_code'];
        $skill = $data['skill'];
        unset($data['student_information_update']);
        unset($data['program_id']);
        unset($data['student_code']);
        if($registration_form['name'] || $report_internship['name']) {
            $upload_dir = wp_upload_dir();
            $base_path = $upload_dir['path'];
            $base_path = explode('wp-content', $base_path);
            $base = $base_path[0];
            $path = $base . 'media/thestudenthouse/studentinfo/' . $program_id . '/' . str_replace(' ', '', $student_code);
            if (!is_dir($base . 'media')) {
                mkdir($base . 'media', 0777);
            }
            if (!is_dir($base . 'media/thestudenthouse')) {
                mkdir($base . 'media/thestudenthouse', 0777);
            }
            if (!is_dir($base . 'media/thestudenthouse/studentinfo')) {
                mkdir($base . 'media/thestudenthouse/studentinfo', 0777);
            }
            if (!is_dir($base . 'media/thestudenthouse/studentinfo/' . $program_id)) {
                mkdir($base . 'media/thestudenthouse/studentinfo/' . $program_id, 0777);
            }
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            if ($registration_form['name']) {
                $target_path = $path . '/' . basename($registration_form['name']);
                move_uploaded_file($registration_form['tmp_name'], $target_path);
                $data['registration_form'] = 'media/thestudenthouse/studentinfo/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $registration_form['name'];
                $wpdb->update(
                    $university_internship_student_table,
                    $data,
//                    array(
//                        'registration_form' => 'media/thestudenthouse/studentinfo/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $registration_form['name'],
//                        'skill' => $skill
//                    ),
                    array(
                        'code' => $student_code,
                        'internship_program_id' => $program_id
                    )
                );
            }
            if ($report_internship['name']) {
                $target_path_att = $path . '/' . basename($report_internship['name']);
                move_uploaded_file($report_internship['tmp_name'], $target_path_att);
                $data['report_internship'] = 'media/thestudenthouse/studentinfo/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $report_internship['name'];
                $wpdb->update(
                    $university_internship_student_table,
                    $data,
//                    array(
//                        'report_internship' => 'media/thestudenthouse/studentinfo/' . $program_id . '/' . str_replace(' ','',$student_code) . '/' . $report_internship['name'],
//                        'skill' => $skill
//                    ),
                    array(
                        'code' => $student_code,
                        'internship_program_id' => $program_id
                    )
                );
            }
        }else{
            $wpdb->update(
                $university_internship_student_table,
                $data,
//                array(
//                    'skill' => $skill
//                ),
                array(
                    'code' => $student_code,
                    'internship_program_id' => $program_id
                )
            );
        }
    }
}
