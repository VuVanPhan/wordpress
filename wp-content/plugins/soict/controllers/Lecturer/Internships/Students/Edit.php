<?php

namespace Soict\Controller\Lecturer\Internships\Students;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Edit extends ControllerFrontend {


	public function execute(){
		$this->setTemplate('lecturer/internships/students-edit.php');
		$this->setTitle('Xem | Đánh giá SV');

		if ( !isset($_GET['student']) || $_GET['student'] == '' ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}

		if ( !isset($_GET['internship']) || $_GET['internship'] == '' ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}


		//save POST data
		if (isset($_POST['action']) && $_POST['action'] == 'save') {
			if ($this->getInternshipStudent()) {

				$internStudent = $this->getInternshipStudent();

				//upload file
				if(isset($_FILES['lecturer_review_file']['name']) && $_FILES['lecturer_review_file']['tmp_name'] != ''){

					if ( filesize($_FILES['lecturer_review_file']['tmp_name']) > 104857600) {

						$this->setNotice2(__('File size limit is 100MB.'));

					} else {

						if ( ! function_exists( 'wp_handle_upload' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/media.php' );
						}

						$time = current_time('mysql');
						$file = wp_handle_upload($_FILES['lecturer_review_file'], array( 'test_form' => false ), $time);

						if (isset($file['error'])) {
							$this->setNotice2(__('Save file not successfully.'));
						} else {
							$internStudent->setData('lecturer_review_file', \SoictApp::getDirPath($file['file']));
						}

					}
				}

				$review_text = (isset($_POST['lecturer_review_text'])) ? $_POST['lecturer_review_text'] : '';
				$review_points = (isset($_POST['lecturer_points'])) ? $_POST['lecturer_points'] : '';

				$internStudent->setData('lecturer_review_text', $review_text);
				$internStudent->setData('lecturer_points', $review_points);

				$internStudent->save();//save data

				$this->setNotice3(__('Save success'));
			}
		}

	}


	public function getStudent() {
		if (isset($_GET['student']) && $_GET['student'] != '') {
			return \SoictApp::getModel('student')->load($_GET['student']);
		}
		return false;
	}

	public function getInternship() {
		if(isset($_GET['internship']) && $_GET['internship'] != ''){
			return \SoictApp::getModel('internship')->load($_GET['internship']);
		}
		return false;
	}

	public function getInternshipStudent() {
		if ($this->getStudent() && $this->getInternship()) {
			$collect =  \SoictApp::getModel('internship/student')->getCollection();
			$collect->getSelect()->where('student_id', $this->getStudent()->getId())
				->and('internship_program_id', $this->getInternship()->getId());
			return $collect->getFirstItem();
		}
		return false;
	}

	//get company by student and internship of this lecturer
	public function getCompany(){
		if ($this->getStudent() && $this->getInternship()) {
			$collect =  \SoictApp::getModel('internship/group')->getCollection();
			$collect->getSelect()->where('student_id', $this->getStudent()->getId())
				->and('internship_program_id', $this->getInternship()->getId())
				->and('lecturer_id', $this->getLecturer()->getId())
				->limit(1);
			$group = $collect->getFirstItem();

			$company =  \SoictApp::getModel('company')->load($group->getCompanyId());

			return $company;

		}
		return false;
	}

	public function getLecturer(){
		return \SoictApp::helper('user')->getCurrentUser();
	}

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
