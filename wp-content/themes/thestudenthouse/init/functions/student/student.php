<?php
/**
 * Student
 *
 * Handles companies data
 *
 * @class Student
 * @author Michael
 */
 
class Student {

/**
 * get all University
 */
    public function getAllUniversityIds(){
        global $wpdb;
        $university_users_table = UNIVERSITY_PREFIX."users";
        $university_usermeta = UNIVERSITY_PREFIX."usermeta";

        //get all university ids
        $sql = "SELECT * FROM ".$university_usermeta." WHERE ".$university_usermeta.".meta_key = \"".UNIVERSITY_PREFIX."capabilities\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $universityIds = array();
        foreach($result as $r){
            $capabilities = maybe_unserialize($r['meta_value']);
            foreach($capabilities as $cap=>$key){
                if($cap != 'administrator' && $cap != 'lecturer')
                    $universityIds[] = $r['user_id'];
            }
        }

        //get all university data
        $univesity = array();
//        var_dump($universityIds);
//        $universityIds = join(',',$universityIds);
//        $sql = "SELECT * FROM ".$university_usermeta." WHERE ".$university_usermeta.".user_id in (".$universityIds.")";
//        var_dump($sql);
//        $result = $wpdb->get_results($sql, 'ARRAY_A');
//        foreach($result as $r) {
//            var_dump($r);
//            echo "<br /><br />";
//        }
        return $universityIds;
    }

    /* Eden */
    public function getAllCurrentCompanyCanRegister() {
        global $wpdb;
        $studentId = get_current_user_id();
        $company = array();
        if($studentId){
            $table_company_course_company = COMPANY_PREFIX . "internship_course_company";
            $table_company_users = COMPANY_PREFIX . "users";
            $sql = "SELECT * FROM ".$table_company_course_company." JOIN ".$table_company_users. " ON "
                . $table_company_course_company.".company_id=".$table_company_users.".ID";

            $company = $wpdb->get_results($sql, 'ARRAY_A');
        }

        return $company;
    }

    /* Eden */

    /**
     * get value university from id and meta key
     */

    public function getValueUniversity($university_id,$meta_key){
        global $wpdb;
        $university_users_table = UNIVERSITY_PREFIX."users";
        $university_usermeta = UNIVERSITY_PREFIX."usermeta";
        $sql = "SELECT meta_value FROM ".$university_usermeta." WHERE ".$university_usermeta.".user_id = \"".$university_id."\" AND ".$university_usermeta.".meta_key = \"".$meta_key."\"";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $value = '';
        foreach ($result as $r)
            $value = $r['meta_value'];
        return $value;
    }

    public function getStudentReport($studentId, $programId) {
        global $wpdb;
        $table_internship_student_report = STUDENT_PREFIX. "internship_student_report";
        $sql = "SELECT * FROM ".$table_internship_student_report. " 
        WHERE student_id=".$studentId." AND program_id=".$programId;
        $result = $wpdb->get_results($sql, "ARRAY_A");
        $value = array();
        foreach ($result as $r) {
            $value = $r;
            break;
        }
        if (count($result)){
            return $value['report_link'];
        } else {
            return null;
        }

    }

    /**
     * get university data by id
     */

    public function getUniversityDataById($university_id){
        global $wpdb;
        $universityData = '';
        $university_usermeta = UNIVERSITY_PREFIX . "usermeta";
        $sql = "SELECT * FROM ".$university_usermeta ." WHERE ".$university_usermeta.".user_id = ".$university_id;
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $universityData = $result;
//        foreach($result as $r)
//            $universityData = $r;
        return $universityData;
    }

    /**
     * Updates user profile
     *
     * @access public
     * @param int $ID
     * @param array $data
     * @return void
     */
    public static function updateProfile($ID, $data) {
        //student name
        if(isset($data['student_name'])) {
            update_user_meta($ID, 'student_name', sanitize_text_field($data['student_name']));
        }
        if(isset($data['student_class'])) {
            update_user_meta($ID, 'student_class', sanitize_text_field($data['student_class']));
        }
        if(isset($data['student_grade'])) {
            update_user_meta($ID, 'student_grade', sanitize_text_field($data['student_grade']));
        }
        if(isset($data['program_university'])) {
            update_user_meta($ID, 'program_university', sanitize_text_field($data['program_university']));
        }
        if(isset($data['student_id'])) {
            update_user_meta($ID, 'student_id', sanitize_text_field($data['student_id']));
        }
        if(isset($data['gender'])) {
            update_user_meta($ID, 'gender', sanitize_text_field($data['gender']));
        }
        if(isset($data['laptop'])) {
            update_user_meta($ID, 'laptop', sanitize_text_field($data['laptop']));
        }
        if(isset($data['address'])) {
            update_user_meta($ID, 'address', sanitize_text_field($data['address']));
        }
        if(isset($data['telephone'])) {
            update_user_meta($ID, 'telephone', sanitize_text_field($data['telephone']));
        }
        if(isset($data['email'])) {
            update_user_meta($ID, 'email', sanitize_text_field($data['email']));
        }
        if(isset($data['subject'])) {
            update_user_meta($ID, 'subject', sanitize_text_field($data['subject']));
        }
        if(isset($data['english'])) {
            update_user_meta($ID, 'english', sanitize_text_field($data['english']));
        }
        if(isset($data['programming_skill'])) {
            update_user_meta($ID, 'programming_skill', sanitize_text_field($data['programming_skill']));
        }
        if(isset($data['programming_skill_good'])) {
            update_user_meta($ID, 'programming_skill_good', sanitize_text_field($data['programming_skill_good']));
        }
        if(isset($data['programming_skill_best'])) {
            update_user_meta($ID, 'programming_skill_best', sanitize_text_field($data['programming_skill_best']));
        }
        if(isset($data['networking_skill'])) {
            update_user_meta($ID, 'networking_skill', sanitize_text_field($data['networking_skill']));
        }
        if(isset($data['skill_certificate'])) {
            update_user_meta($ID, 'skill_certificate', sanitize_text_field($data['skill_certificate']));
        }
        if(isset($data['internship_experience'])) {
            update_user_meta($ID, 'internship_experience', sanitize_text_field($data['internship_experience']));
        }
        if(isset($data['intern_area'])) {
            update_user_meta($ID, 'intern_area', implode(',',$data['intern_area']));
        }
        if(isset($data['internship_company'])) {
            update_user_meta($ID, 'internship_company', sanitize_text_field($data['internship_company']));
        }
        if(isset($data['hr'])) {
            update_user_meta($ID, 'hr', sanitize_text_field($data['hr']));
        }
        if(isset($data['hr_email'])) {
            update_user_meta($ID, 'hr_email', sanitize_text_field($data['hr_email']));
        }
        if(isset($data['hr_phone'])) {
            update_user_meta($ID, 'hr_phone', sanitize_text_field($data['hr_phone']));
        }
    }

    /**
     * get all program Ids by student code
     */

    public function getAllProgramIds(){
        global $wpdb;
        $user_id = get_current_user_id();
        $student_code = get_user_meta($user_id,'student_code',true);
        if($user_id){
            $internship_student_table = UNIVERSITY_PREFIX . "internship_student";
            $sql = "SELECT internship_program_id FROM ".$internship_student_table ." WHERE ".$internship_student_table.".code = \"".$student_code."\" ORDER BY ".$internship_student_table.".internship_program_id DESC";
            $programs = $wpdb->get_results($sql, 'ARRAY_A');
        }
        return $programs;
    }

    /**
     * get program data by id
     */

    public function getProgramData($program_id){
        global $wpdb;
        $programData = '';
        $internship_program_table = UNIVERSITY_PREFIX . "internship_program";
        $sql = "SELECT * FROM ".$internship_program_table ." WHERE ".$internship_program_table.".internship_program_id = ".$program_id;
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        foreach($result as $r)
            $programData = $r;
        return $programData;
    }

    public function getAllCompanyList() {
        global $wpdb;
        $companyData = '';
        $company_user_table = UNIVERSITY_PREFIX . "users";
        $sql = "SELECT * FROM ".$company_user_table;
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        return $result;
    }

    /**
     * status of programs
     */
    public function getProgramStatus(){
        $status =  array(
            '0' => __('Inactive','academy'),
            '1' => __('Active','academy'),
            '2' => __('Procesing','academy'),
            '3' => __('Finished','academy'),
            '4' => __('Cancel','academy')
        );
        return $status;
    }

    /**
     * get student infor for program
     */

    public function getStudentInforWithProgram($student_code, $program_id){
        global $wpdb;
        $studentInfo = '';
        $table_internship_student = UNIVERSITY_PREFIX . "internship_student";
        $sql = "SELECT * FROM ".$table_internship_student." WHERE ".$table_internship_student.".code = \"".$student_code."\"
                                                              AND ".$table_internship_student.".internship_program_id = \"".$program_id."\"";
        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach ($result as $r)
            $studentInfo = $r;
        return $studentInfo;

    }

    public function getCourseInformationByStudentId() {
        global $wpdb;
        $table_internship_student_company_course = STUDENT_PREFIX . "internship_student_company_course";
        $table_company_course_company = COMPANY_PREFIX . "internship_course_company";
        $table_internship_course_program = UNIVERSITY_PREFIX . "internship_course_program";
        $studentId = get_current_user_id();
        $sql = "SELECT * FROM ".$table_internship_student_company_course." JOIN ".$table_company_course_company. " ON "
            . $table_internship_student_company_course.".internship_course_company_id=".$table_company_course_company.".internship_course_company_id".
            " WHERE ".$table_internship_student_company_course. ".student_id = ".$studentId;

        $students = $wpdb->get_results($sql, 'ARRAY_A');
        return $students;
    }

    public function getAllStudentCv() {
        global $wpdb;
        $studentInfo = '';
        $table_internship_student_cv = $wpdb->prefix."internship_student_cv";
        $sql = "SELECT * FROM ".$table_internship_student_cv;
        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach ($result as $r)
            $studentInfo = $r;
        return $studentInfo;
    }

    public function getStudentCvById($id) {
        global $wpdb;
        $studentInfo = '';
        $table_internship_student_cv = $wpdb->prefix."internship_student_cv";
        $sql = "SELECT * FROM ".$table_internship_student_cv." WHERE ".$table_internship_student_cv.".user_id = \"".$id."\"";

        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach ($result as $r)
            $studentInfo = $r;

        return $studentInfo;       
    }

    public function getStudentRate() {
        global $wpdb;
        $studentId = get_current_user_id();
        $tableRate = UNIVERSITY_PREFIX."internship_program_student_rate";
        $sql = "SELECT * FROM ".$tableRate." WHERE ".$tableRate.".student_id = \"".$studentId."\"";
        $studentInfo = array();
        $result = $wpdb->get_results($sql, "ARRAY_A");
        foreach ($result as $r) {
            $studentInfo = $r;
            break;
        }
        return $studentInfo;
    }

    public function getProgramDetailByProgramId($program_id) {
        global $wpdb;
        $user_id = get_current_user_id();
        $programData = array();
        if($user_id){
            $internship_program_table = UNIVERSITY_PREFIX . "internship_course_program";
            //$sql = "SELECT * FROM ".$internship_program_table ." WHERE (".$internship_program_table.".user_id = ".$user_id.") AND (".$internship_program_table.".internship_program_id = ".$program_id.") ORDER BY ".$internship_program_table.".internship_program_id DESC";
            $sql = "SELECT * FROM ".$internship_program_table ." WHERE (".$internship_program_table.".internship_course_program_id = ".$program_id.") ORDER BY ".$internship_program_table.".internship_course_program_id DESC";
            $programs = $wpdb->get_results($sql, 'ARRAY_A');
            foreach($programs as $program){
                $programData = $program;
                break;
            }
            return $programData;
        }
        return $programData;

    }
}