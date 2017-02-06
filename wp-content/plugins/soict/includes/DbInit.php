<?php

class Soict_DbInit {

	public static function run($version) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "";

		$student_table = SoictApp::getModel('resource')->getTable('student');
		$company_table = SoictApp::getModel('resource')->getTable('company');
		$lecturer_table = SoictApp::getModel('resource')->getTable('lecturer');
		$internship_program_table = SoictApp::getModel('resource')->getTable('internship');
		$internship_group_table = SoictApp::getModel('resource')->getTable('internshipGroup');
		$internship_company_table = SoictApp::getModel('resource')->getTable('internshipCompany');
		$internship_student_table = SoictApp::getModel('resource')->getTable('internshipStudent');
		$internship_lecturer_table = SoictApp::getModel('resource')->getTable('internshipLecturer');

		switch($version){
			case '1.0':

				$sql = "

					DROP TABLE IF EXISTS {$internship_company_table};
					DROP TABLE IF EXISTS {$internship_lecturer_table};
					DROP TABLE IF EXISTS {$internship_student_table};
					DROP TABLE IF EXISTS {$internship_group_table};
					DROP TABLE IF EXISTS {$internship_program_table};
					DROP TABLE IF EXISTS {$student_table};
					DROP TABLE IF EXISTS {$company_table};
					DROP TABLE IF EXISTS {$lecturer_table};

					CREATE TABLE {$student_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						user_id int(11) NOT NULL DEFAULT 0,
						name VARCHAR (255) NOT NULL DEFAULT '',
						avatar VARCHAR (255) NOT NULL DEFAULT '',
						gender VARCHAR (255) NOT NULL DEFAULT '',
						birthday DATE,
						class VARCHAR (255) NOT NULL DEFAULT '',
						grade VARCHAR (255) NOT NULL DEFAULT '',
						program_university VARCHAR (255) NOT NULL DEFAULT '',
						student_id VARCHAR (30) NOT NULL DEFAULT '',
						laptop SMALLINT (1) NOT NULL DEFAULT 0,
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
						CONSTRAINT unique_student_user_id UNIQUE (`user_id`),
						CONSTRAINT unique_student_student_id UNIQUE (`student_id`),
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$company_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						user_id int(11) NOT NULL DEFAULT 0,
						name VARCHAR (255) NOT NULL DEFAULT '',
						address VARCHAR (255) NOT NULL DEFAULT '',
						field VARCHAR (255) NOT NULL DEFAULT '',
						logo VARCHAR (255) NOT NULL DEFAULT '',
						birthday DATE,
						seniority int(6) NOT NULL DEFAULT 0,
						position VARCHAR (255) NOT NULL DEFAULT '',
						description TEXT,
						require_skill VARCHAR (255) NOT NULL DEFAULT '',
						hr_email VARCHAR (255) NOT NULL DEFAULT '',
						hr_phone VARCHAR (30) NOT NULL DEFAULT '',
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$lecturer_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						user_id int(11) NOT NULL DEFAULT 0,
						name VARCHAR (255) NOT NULL DEFAULT '',
						avatar VARCHAR (255) NOT NULL DEFAULT '',
						gender VARCHAR (255) NOT NULL DEFAULT '',
						birthday DATE,
						job VARCHAR (255) NOT NULL DEFAULT '',
						address VARCHAR (255) NOT NULL DEFAULT '',
						profession_skill VARCHAR (255) NOT NULL DEFAULT '',
						phone VARCHAR (30) NOT NULL DEFAULT '',
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$internship_program_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						title VARCHAR (255) NOT NULL DEFAULT '',
						description VARCHAR (255) NOT NULL DEFAULT '',
						from_date DATE,
						to_date DATE,
						support_phone VARCHAR (30) NOT NULL DEFAULT '',
						support_email VARCHAR (30) NOT NULL DEFAULT '',
						status VARCHAR (30) NOT NULL DEFAULT 'open',
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$internship_company_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						student_qty int(6) NOT NULL DEFAULT 0,
						internship_program_id int(11) NOT NULL,
						company_id int(11) NOT NULL,
						register_date DATE,
						FOREIGN KEY INTERNCOMPANY_REF_COMPANY (company_id) REFERENCES {$company_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY INTERNCOMPANY_REF_INTERN_PROGRAM (internship_program_id) REFERENCES {$internship_program_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$internship_lecturer_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						lecturer_id int(6) NOT NULL DEFAULT 0,
						internship_program_id int(11) NOT NULL,
						register_date DATE,
						FOREIGN KEY INTERNLECTURER_REF_LECTURER (lecturer_id) REFERENCES {$lecturer_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY INTERNLECTURER_REF_INTERN_PROGRAM (internship_program_id) REFERENCES {$internship_program_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$internship_student_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						report_file VARCHAR (225) NOT NULL DEFAULT '',
						report_date DATETIME,
						lecturer_review_text TEXT,
						lecturer_review_file VARCHAR (225) NOT NULL DEFAULT '',
						company_review_text TEXT,
						company_review_file VARCHAR (225) NOT NULL DEFAULT '',
						formula VARCHAR (255) NOT NULL DEFAULT '',
						lecturer_points FLOAT (6) NOT NULL DEFAULT 0,
						company_points FLOAT (6) NOT NULL DEFAULT 0,
						diligent_points FLOAT (6) NOT NULL DEFAULT 0,
						total_points FLOAT (6) NOT NULL DEFAULT 0,
						student_id int(6) NOT NULL DEFAULT 0,
						internship_program_id int(11) NOT NULL,
						register_date DATE,
						FOREIGN KEY INTERNSTUDENT_REF_STUDENT (student_id) REFERENCES {$student_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY INTERNSTUDENT_REF_INTERN_PROGRAM (internship_program_id) REFERENCES {$internship_program_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						PRIMARY KEY (`id`)
					) $charset_collate;


					CREATE TABLE {$internship_group_table} (
						id int(11) NOT NULL AUTO_INCREMENT,
						student_id int(11) NOT NULL DEFAULT 0,
						lecturer_id int(11) NULL,
						company_id int(11) NULL,
						internship_program_id int(11) NOT NULL DEFAULT 0,
						FOREIGN KEY GROUP_REF_STUDENT (student_id) REFERENCES {$student_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY GROUP_REF_LECTURER (lecturer_id) REFERENCES {$lecturer_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY GROUP_REF_COMPANY (company_id) REFERENCES {$company_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						FOREIGN KEY GROUP_REF_INTERN_PROG (internship_program_id) REFERENCES {$internship_program_table} (id) ON DELETE CASCADE ON UPDATE CASCADE,
						CONSTRAINT unique_group UNIQUE (`student_id`, `lecturer_id`, `company_id`, `internship_program_id`),
						PRIMARY KEY (`id`)
					) $charset_collate;


				";

				break;
			case '2.0':
				break;
			case '3.0':
				break;
			case '4.0':
				break;
		}

		return $sql;
	}


	//initial all databases
	public static function initDb(){
		$installed_ver = get_option( "soict_db_version" );
		if ( $installed_ver != SOICT_VERSION ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( self::run(SOICT_VERSION) );
			update_option( "soict_db_version", SOICT_VERSION );
		}
		return true;
	}

	//run when admin active plugin
	public static function plugin_activation(){
		self::initDb(); //initial database
	}

	//run when admin deactive plugin
	public static function plugin_deactivation(){
		//deactive plugin
	}

}
