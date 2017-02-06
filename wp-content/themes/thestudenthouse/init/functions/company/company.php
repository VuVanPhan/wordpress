<?php
/**
 * Student
 *
 * Handles companies data
 *
 * @class Student
 * @author Michael
 */

class Company {
    public function registerStudentToCourseProgram($companyCourse) {
        $studentId = get_current_user_id();
        if($studentId){
            global $wpdb;
            $table_internship_student_company_course = STUDENT_PREFIX . "internship_student_company_course";
            $wpdb->insert(
                $table_internship_student_company_course,
                array(
                    'student_id' => $studentId,
                    'internship_course_company_id' => $companyCourse
                )
            );

        }
    }

    public function isRegisterCourseProgram($courseProgram) {
        global $wpdb;
        $studentId = get_current_user_id();
        $programs = array();
        if($studentId){
            $table_internship_student_company_course = STUDENT_PREFIX . "internship_student_company_course";
            $sql = "SELECT * FROM ".$table_internship_student_company_course ." WHERE ".$table_internship_student_company_course.".student_id = ".$studentId.
                " AND ".$table_internship_student_company_course.".internship_course_company_id = ".$courseProgram;

            $programs = $wpdb->get_results($sql, 'ARRAY_A');
            if (count($programs)) {
                return true;
            }
        }
        return false;
    }

    public function numberOfStudentRegisterCourseProgram($courseProgram) {
        global $wpdb;
        $studentId = get_current_user_id();
        $programs = array();
        if($studentId){
            $table_internship_student_company_course = STUDENT_PREFIX . "internship_student_company_course";
            $sql = "SELECT * FROM ".$table_internship_student_company_course ." WHERE ".$table_internship_student_company_course.".internship_course_company_id = ".$courseProgram;

            $programs = $wpdb->get_results($sql, 'ARRAY_A');
        }
        return count($programs);       
    }


}