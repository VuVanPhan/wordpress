<?php
/**
 * University
 *
 * Handles companies data
 *
 * @class Notification
 * @author Michael
 */
class Notification {

    /**
     * update all
     */

    public function updateAll(){
        global $wpdb;
        $notification_table = UNIVERSITY_PREFIX.'notification';
        //all program active
        $allProgramActive = self::getAllProgramActive();
        if($allProgramActive){
            $programBefore7days = array();
            $programBefore3days = array();

            $now = date('Y-m-d');

            $before7days = date_create($now);
            date_add($before7days, date_interval_create_from_date_string('7 days'));
            $before7days = date_format($before7days, 'Y-m-d');

            $before3days = date_create($now);
            date_add($before3days, date_interval_create_from_date_string('3 days'));
            $before3days = date_format($before3days, 'Y-m-d');
            foreach($allProgramActive as $pActive){
                if(($pActive['start_date'] >= $now) && ($pActive['start_date'] <= $before7days)){
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pActive['internship_program_id']."\"
                                                                            AND ".$notification_table.".before_7_day_start = \"1\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if(!$result)
                        $programBefore7days[] = $pActive;
                }

                if(($pActive['start_date'] >= $now) && ($pActive['start_date'] <= $before3days)){
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pActive['internship_program_id']."\"
                                                                            AND ".$notification_table.".before_3_day_start = \"1\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if(!$result)
                        $programBefore3days[] = $pActive;
                }
            }
            if($programBefore7days){
                foreach($programBefore7days as $pBefore7days){
                    self::sendEmailToStudentDoesNotChooseCompanyBeforeStart7days($pBefore7days);
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pActive['internship_program_id']."\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if($result){
                        $wpdb->update(
                            $notification_table,
                            array('before_7_day_start' => '1'),
                            array('program_id' => $pActive['internship_program_id'])
                        );
                    }else{
                        $wpdb->insert(
                            $notification_table,
                            array(
                                'program_id' => $pActive['internship_program_id'],
                                'before_7_day_start' => '1'
                            )
                        );
                    }
                }
            }
            if($programBefore3days){
                foreach($programBefore3days as $pBefore3days){
                    self::sendEmailToLecturerAssignStudentToCompanyBeforeStart3days($pBefore3days);
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pActive['internship_program_id']."\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if($result){
                        $wpdb->update(
                            $notification_table,
                            array('before_3_day_start' => '1'),
                            array('program_id' => $pActive['internship_program_id'])
                        );
                    }else{
                        $wpdb->insert(
                            $notification_table,
                            array(
                                'program_id' => $pActive['internship_program_id'],
                                'before_3_day_start' => '1'
                            )
                        );
                    }
                }
            }
        }

        $allProgramProcessing = self::getAllProgramProcessing();
        if($allProgramProcessing){
            $programBefore7daysFinish = array();
            $programBefore3daysFinish = array();

            $now = date('Y-m-d');

            $before7daysFinish = date_create($now);
            date_add($before7daysFinish, date_interval_create_from_date_string('7 days'));
            $before7daysFinish = date_format($before7daysFinish, 'Y-m-d');

            $before3daysFinish = date_create($now);
            date_add($before3daysFinish, date_interval_create_from_date_string('3 days'));
            $before3daysFinish = date_format($before3daysFinish, 'Y-m-d');
            foreach($allProgramProcessing as $pProcessing){
                if(($pProcessing['end_date'] >= $now) && ($pProcessing['end_date'] <= $before7daysFinish)){
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pProcessing['internship_program_id']."\"
                                                                            AND ".$notification_table.".before_7_day_finish = \"1\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if(!$result)
                        $programBefore7daysFinish[] = $pProcessing;
                }

                if(($pProcessing['end_date'] >= $now) && ($pProcessing['end_date'] <= $before3daysFinish)){
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pProcessing['internship_program_id']."\"
                                                                            AND ".$notification_table.".before_3_day_finish = \"1\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if(!$result)
                        $programBefore3daysFinish[] = $pProcessing;
                }
            }
            if($programBefore7daysFinish){
                foreach($programBefore7daysFinish as $pBefore7daysFinish){
                    self::sendEmailToStudentBeforeProgramInternshipFinish7days($pBefore7daysFinish);
                    self::sendEmailToCompanyBeforeProgramInternshipFinish7days($pBefore7daysFinish);
                    self::sendEmailToLecturerBeforeProgramInternshipFinish7days($pBefore7daysFinish);
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pProcessing['internship_program_id']."\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if($result){
                        $wpdb->update(
                            $notification_table,
                            array('before_7_day_finish' => '1'),
                            array('program_id' => $pProcessing['internship_program_id'])
                        );
                    }else{
                        $wpdb->insert(
                            $notification_table,
                            array(
                                'program_id' => $pProcessing['internship_program_id'],
                                'before_7_day_finish' => '1'
                            )
                        );
                    }
                }
            }
            if($programBefore3daysFinish){
                foreach($programBefore3daysFinish as $pBefore3daysFinish){
                    self::sendEmailToStudentBeforeProgramInternshipFinish3days($pBefore3daysFinish);
                    $sql = "SELECT program_id FROM ".$notification_table." WHERE ".$notification_table.".program_id = \"".$pProcessing['internship_program_id']."\"";
                    $result = $wpdb->get_results($sql, "ARRAY_A");
                    if($result){
                        $wpdb->update(
                            $notification_table,
                            array('before_3_day_finish' => '1'),
                            array('program_id' => $pProcessing['internship_program_id'])
                        );
                    }else{
                        $wpdb->insert(
                            $notification_table,
                            array(
                                'program_id' => $pProcessing['internship_program_id'],
                                'before_3_day_finish' => '1'
                            )
                        );
                    }
                }
            }
        }
    }

    /**
     *get all programs active
     */

    public function getAllProgramActive(){
        global $wpdb;
        $table_internship_program = UNIVERSITY_PREFIX . "internship_program";
        $sql = "SELECT * FROM ".$table_internship_program." WHERE ".$table_internship_program.".status = \"1\"";
//        $program_ids = array();
        $result = $wpdb->get_results($sql, 'ARRAY_A');
//        foreach ($result as $r)
//            $program_ids[] = $r['internship_program_id'];
        return $result;
    }

    /**
     *get all programs processing
     */

    public function getAllProgramProcessing(){
        global $wpdb;
        $table_internship_program = UNIVERSITY_PREFIX . "internship_program";
        $sql = "SELECT * FROM ".$table_internship_program." WHERE ".$table_internship_program.".status = \"2\"";
//        $program_ids = array();
        $result = $wpdb->get_results($sql, 'ARRAY_A');
//        foreach ($result as $r)
//            $program_ids[] = $r['internship_program_id'];
        return $result;
    }

    /**
     * get value university from id and meta key
     */

    public function getValueUniversity($university_id,$meta_key){
        global $wpdb;
        $university_usermeta = UNIVERSITY_PREFIX."usermeta";
        $sql = "SELECT meta_value FROM ".$university_usermeta." WHERE ".$university_usermeta.".user_id = \"".$university_id."\" AND ".$university_usermeta.".meta_key = \"".$meta_key."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $value = '';
        foreach ($result as $r)
            $value = $r['meta_value'];
        return $value;
    }

    /**
     * get university email
     */

    public function getUniversityEmail($university_id){
        global $wpdb;
        $university_user = UNIVERSITY_PREFIX."users";
        $sql = "SELECT user_email FROM ".$university_user." WHERE ".$university_user.".ID = \"".$university_id."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $value = '';
        foreach ($result as $r)
            $value = $r['user_email'];
        return $value;
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
     * get company email
     */

    public function getCompanyEmail($company_id){
        global $wpdb;
        $company_user = COMPANY_PREFIX."users";
        $sql = "SELECT user_email FROM ".$company_user." WHERE ".$company_user.".ID = \"".$company_id."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $value = '';
        foreach ($result as $r)
            $value = $r['user_email'];
        return $value;
    }

    /**
     * get all lecturers by university id
     */

    public function getAllLecturerByUniversity($university_id){
        global $wpdb;
        $table_lecturer = UNIVERSITY_PREFIX . "university_lecturer";
        $sql = "SELECT user_id FROM ".$table_lecturer." WHERE ".$table_lecturer.".university_id = ".$university_id;
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        return $result;
    }

    /**
     * send email to notify and choose company for student with new program internship
     */
    public function sendEmailToStudentInNewProgramInternship(){

    }

    /**
     * send email notify companies partner about new program internship
     */
    public function sendEmailToCompanyPartnerNewProgramInternship(){

    }

    /**
     * send email to notify student does not choose company before 7days starting
     */

    public function sendEmailToStudentDoesNotChooseCompanyBeforeStart7days($program){
        global $wpdb;
        $company_internship_student_program_table = COMPANY_PREFIX . "internship_student_program";
        $student_code = array();
        $student_code[] = 0;
        $sql = "SELECT student_code FROM ". $company_internship_student_program_table . " WHERE ".$company_internship_student_program_table.".program_id = \"".$program['internship_program_id']."\"";
        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach($result as $r)
            $student_code[] = $r['student_code'];
        $students = array();
        $table_internship_student = UNIVERSITY_PREFIX . "internship_student";
        $sql = "SELECT * FROM ".$table_internship_student." WHERE ".$table_internship_student.".code NOT IN (".implode(',',$student_code).")
                                                            AND ".$table_internship_student.".internship_program_id = \"".$program['internship_program_id']."\"";
        $students = $wpdb->get_results($sql, "ARRAY_A");
        if($students){
            $university_id = $program['user_id'];
            $university_name = self::getValueUniversity($university_id, 'university_name');
            $university_email = self::getUniversityEmail($university_id);
            foreach($students as $student) {
                $user_email = $student['email'];
                $attachments = '';
                $subject = "[Thông báo] ".$program['name']." của ".$university_name;
                $message = "Chào " . $student['name'] . ",\r\n";
                $message .= "\r\n";
                $message .= "Bạn có tên trong danh sách ".$program['name']." của ".$university_name. "\r\n";
                $message .= "Chương trình thực tập được bắt đầu từ ".date('d-m-Y', strtotime($program['start_date']))." tới ".date('d-m-Y', strtotime($program['end_date'])). "\r\n";
                $message .= "Yêu cầu cụ thể của chương trình thực tập: \r\n";
                $message .= $program['requirement']."\r\n";
                $message .= "\r\n";
                $message .= "Mong bạn nhanh chóng đăng nhập, điền thông tin cá nhân và lựa chọn công ty thực tập tại: http://soict.thestudenthouse.org/student/register/ \r\n";
                $message .= "\r\n";
                $message .= "Trân trọng, \r\n";
                $message .= $university_name. "\r\n";
                $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                wp_mail($user_email, $subject, $message, $headers, $attachments);
            }
        }
    }

    /**
     * send email to lecture to assign student to company with all students do not choose company before 3days starting
     */
    public function sendEmailToLecturerAssignStudentToCompanyBeforeStart3days($program){
        global $wpdb;
        $company_internship_student_program_table = COMPANY_PREFIX . "internship_student_program";
        $student_code = array();
        $student_code[] = 0;
        $sql = "SELECT student_code FROM ". $company_internship_student_program_table . " WHERE ".$company_internship_student_program_table.".program_id = \"".$program['internship_program_id']."\"";
        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach($result as $r)
            $student_code[] = $r['student_code'];
        $students = array();
        $table_internship_student = UNIVERSITY_PREFIX . "internship_student";
        $sql = "SELECT * FROM ".$table_internship_student." WHERE ".$table_internship_student.".code NOT IN (".implode(',',$student_code).")
                                                                                                AND ".$table_internship_student.".internship_program_id = \"".$program['internship_program_id']."\"";
        $students = $wpdb->get_results($sql, "ARRAY_A");
        if($students){
            $university_id = $program['user_id'];
            $university_name = self::getValueUniversity($university_id, 'university_name');
            $university_email = self::getUniversityEmail($university_id);
            $lecturers = self::getAllLecturerByUniversity($university_id);
            if($lecturers) {
                foreach ($lecturers as $lecturer) {
                    $lecturer_email = self::getUniversityEmail($lecturer['user_id']);
                    $lecturer_name = self::getValueUniversity($lecturer['user_id'], 'first_name');
                    $attachments = '';
                    $subject = "[Thông báo] Chỉ định thực tập cho sinh viên";
                    $message = "Kính gửi " . $lecturer_name . ",\r\n";
                    $message .= "\r\n";
                    $message .= "Một số sinh viên trong kỳ thực tập " . $program['name'] . " vẫn chưa lựa chọn công ty để thực tập. \r\n";
                    $message .= "Vì vậy, xin quý thầy cô liên lạc và chỉ định công ty thực tập cho những sinh viên này. \r\n";
                    $message .= "http://soict.thestudenthouse.org/university/ \r\n";
                    $message .= "\r\n";
                    $message .= "Trân trọng, \r\n";
                    $message .= $university_name . "\r\n";
                    $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                    wp_mail($lecturer_email, $subject, $message, $headers, $attachments);
                }
            }
        }
    }

    /**
     * send email to student before program internship finish 7days
     */
    public function sendEmailToStudentBeforeProgramInternshipFinish7days($program){
        global $wpdb;
        $students = array();
        $table_internship_student = UNIVERSITY_PREFIX . "internship_student";
        $sql = "SELECT * FROM ".$table_internship_student." WHERE ".$table_internship_student.".internship_program_id = \"".$program['internship_program_id']."\"";
        $students = $wpdb->get_results($sql, "ARRAY_A");
        if($students){
            $university_id = $program['user_id'];
            $university_name = self::getValueUniversity($university_id, 'university_name');
            $university_email = self::getUniversityEmail($university_id);
            foreach($students as $student) {
                $user_email = $student['email'];
                $attachments = '';
                $subject = "[Thông báo] Chương trình ".$program['name']." thực tập sắp kết thúc";
                $message = "Chào " . $student['name'] . ",\r\n";
                $message .= "\r\n";
                $message .= "Chương trình thực tập ".$program['name']." của ".$university_name. "sẽ kết thúc vào ngày ".date('d-m-Y', strtotime($program['end_date']))."! \r\n";
                $message .= "Vì vậy hãy cố gắng hoàn thành tốt các công việc được giao trước khi chương trình thực tập kết thúc để có thể nhận được kết quả đánh giá tốt nhất. \r\n";
                $message .= "\r\n";
                $message .= "Trân trọng, \r\n";
                $message .= $university_name. "\r\n";
                $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                wp_mail($user_email, $subject, $message, $headers, $attachments);
            }
        }
    }

    /**
     * send email to company before program internship finish 7days
     */
    public function sendEmailToCompanyBeforeProgramInternshipFinish7days($program){
        global $wpdb;
        $company_internship_program_table = COMPANY_PREFIX . "internship_program_joined";
        $companies = array();
        $program_id = $program['internship_program_id'];
        $sql = "SELECT company_id FROM ".$company_internship_program_table." WHERE ".$company_internship_program_table.".program_id = \"".$program_id."\"";
        $companies = $wpdb->get_results($sql, 'ARRAY_A');
        if($companies){
            $university_id = $program['user_id'];
            $university_name = self::getValueUniversity($university_id, 'university_name');
            $university_email = self::getUniversityEmail($university_id);
            foreach($companies as $company){
                $company_id = $company['company_id'];
                $company_name = self::getValueCompany($company_id, 'company_name');
                $company_email = self::getCompanyEmail($company_id);
                $attachments = '';
                $subject = "[Thông báo] Chương trình ".$program['name']." thực tập sắp kết thúc";
                $message = "Kính gửi Công ty " . $company_name . ",\r\n";
                $message .= "\r\n";
                $message .= "Chương trình thực tập ".$program['name']." của ".$university_name. "sẽ kết thúc vào ngày ".date('d-m-Y', strtotime($program['end_date']))."! \r\n";
                $message .= "Vì vậy chúng tôi thông báo để quý Công ty được biết và có những đánh giá sớm dành cho các sinh viên thực tập tại Công ty. \r\n";
                $message .= "\r\n";
                $message .= "Trân trọng, \r\n";
                $message .= $university_name. "\r\n";
                $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                wp_mail($company_email, $subject, $message, $headers, $attachments);
            }
        }
    }

    /**
     * send email to lecturer before program internship finish 7days
     */
    public function sendEmailToLecturerBeforeProgramInternshipFinish7days($program){
        $university_id = $program['user_id'];
        $university_name = self::getValueUniversity($university_id, 'university_name');
        $university_email = self::getUniversityEmail($university_id);
        $lecturers = self::getAllLecturerByUniversity($university_id);
        if($lecturers) {
            foreach ($lecturers as $lecturer) {
                $lecturer_email = self::getUniversityEmail($lecturer['user_id']);
                $lecturer_name = self::getValueUniversity($lecturer['user_id'], 'first_name');
                $attachments = '';
                $subject = "[Thông báo] Chương trình ".$program['name']." thực tập sắp kết thúc";
                $message = "Kính gửi " . $lecturer_name . ",\r\n";
                $message .= "\r\n";
                $message .= "Chương trình thực tập ".$program['name']." của ".$university_name. "sẽ kết thúc vào ngày ".date('d-m-Y', strtotime($program['end_date']))."! \r\n";
                $message .= "Vì vậy xin quý thầy cô có những đánh giá sớm dành cho các sinh viên trong kỳ thực tập. \r\n";
                $message .= "http://soict.thestudenthouse.org/university/ \r\n";
                $message .= "\r\n";
                $message .= "Trân trọng, \r\n";
                $message .= $university_name . "\r\n";
                $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                wp_mail($lecturer_email, $subject, $message, $headers, $attachments);
            }
        }
    }

    /**
     * send email to student before program internship finish 3days to get review
     */
    public function sendEmailToStudentBeforeProgramInternshipFinish3days($program){
        global $wpdb;
        $students = array();
        $table_internship_student = UNIVERSITY_PREFIX . "internship_student";
        $sql = "SELECT * FROM ".$table_internship_student." WHERE ".$table_internship_student.".internship_program_id = \"".$program['internship_program_id']."\"";
        $students = $wpdb->get_results($sql, "ARRAY_A");
        if($students){
            $university_id = $program['user_id'];
            $university_name = self::getValueUniversity($university_id, 'university_name');
            $university_email = self::getUniversityEmail($university_id);
            foreach($students as $student) {
                $user_email = $student['email'];
                $attachments = '';
                $subject = "[Thông báo] Chương trình ".$program['name']." thực tập sắp kết thúc";
                $message = "Gửi " . $student['name'] . ",\r\n";
                $message .= "\r\n";
                $message .= "Chương trình thực tập ".$program['name']." của ".$university_name. " sắp kết thúc! \r\n";
                $message .= "Bạn hãy nhanh chóng lấy dấu xác nhận thực tập và đánh giá thực tập của công ty và để nộp cho giảng viên quản lý. \r\n";
                $message .= "\r\n";
                $message .= "Trân trọng, \r\n";
                $message .= $university_name. "\r\n";
                $headers = "From: " . $university_name . " <" . $university_email . ">" . "\r\n";
                wp_mail($user_email, $subject, $message, $headers, $attachments);
            }
        }
    }
}