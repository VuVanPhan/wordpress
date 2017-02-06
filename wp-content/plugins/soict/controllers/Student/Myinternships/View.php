<?php

namespace Soict\Controller\Student\Myinternships;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class View extends ControllerFrontend {

	private $_collection;
	private $_paging;

	private $_internship;
	private $_internshipStudent;
	private $_student;
	private $_lecturer;
	private $_company;

	public function execute(){
		$this->setTemplate('student/myinternships/view.php');
		$this->setTitle('Các công ty thực tập');

		if ( !$this->getInternship() ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}

		$model = $this->getInternshipStudent();

		//upload file
		if(isset($_FILES['report_file']['name']) && $_FILES['report_file']['tmp_name'] != ''){

			if ( filesize($_FILES['report_file']['tmp_name']) > 104857600) {

				$this->setNotice2(__('File size limit is 100MB.'));

			} else {

				if ( ! function_exists( 'wp_handle_upload' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/media.php' );
				}

				$time = current_time('mysql');
				$file = wp_handle_upload($_FILES['report_file'], array( 'test_form' => false ), $time);

				if (isset($file['error'])) {
					$this->setNotice2(__('Save file not successfully.'));
				} else {
					$model->setData('report_file', \SoictApp::getDirPath($file['file']));
					$model->save();
				}

			}
		}

	}

	//return student
	public function getStudent() {
		if (!$this->_student) {
			$this->_student = \SoictApp::helper('user')->getCurrentUser();
		}
		return $this->_student;
	}

	public function getCollection(){
		if(!$this->_collection){
			$studentId = $this->getStudent()->getId();
			$this->_collection = \SoictApp::getModel('internship')->getCollection();
			//$this->_collection->getSelect()->where('status', 'open');

			$internshipIds = array();
			$filterStudent = \SoictApp::getModel('internship/student')->getCollection();
			$filterStudent->getSelect()->where('student_id', $studentId);

			foreach ($filterStudent as $row) {
				$internshipIds[] = $row['internship_program_id'];
			}

			$this->_collection->getSelect()->where('id', $internshipIds); //where id in array()

			$this->getPaging()->setOrderBy('from_date', 'desc');
			$this->_collection = $this->getPaging()->getPagingCollection($this->_collection);
		}

		return $this->_collection;
	}

	//get my internship
	public function getInternship(){

		if ( !$this->_internship ) {
			if(isset($_GET['internship']) && $_GET['internship'] != ''){
				$this->_internship = \SoictApp::getModel('internship')->load($_GET['internship']);
			} elseif ($this->getCollection()->getSize() == 1) {
				$this->_internship = $this->getCollection()->getFirstItem();
			}
		}

		return $this->_internship;
	}

	// get internship student object
	public function getInternshipStudent() {

		if (!$this->_internshipStudent && $this->getInternship()) {
			$studentId = $this->getStudent()->getId();
			$internStudent = \SoictApp::getModel('internship/student')->getCollection();
			$internStudent->getSelect()->where('student_id', $studentId)
				->and('internship_program_id', $this->getInternship()->getId())
				->limit(1);

			$this->_internshipStudent = $internStudent->getFirstItem();
		}

		return $this->_internshipStudent;
	}

	public function getCompany() {
		if (!$this->_company) {
			$studentId = $this->getStudent()->getId();
			$internGroup = \SoictApp::getModel('internship/group')->getCollection();
			$internGroup->getSelect()->where('student_id', $studentId)
				->and('internship_program_id', $this->getInternship()->getId())
				->limit(1);

			$this->_company = \SoictApp::getModel('company')->load($internGroup->getFirstItem()->getCompanyId());
		}

		return $this->_company;
	}

	public function getLecturer() {
		if (!$this->_lecturer) {

			$studentId = $this->getStudent()->getId();
			$internGroup = \SoictApp::getModel('internship/group')->getCollection();
			$internGroup->getSelect()->where('student_id', $studentId)
				->and('internship_program_id', $this->getInternship()->getId())
				->and('company_id', $this->getCompany()->getId())
				->limit(1);

			$lecturerId = $internGroup->getFirstItem()->getLecturerId();

			$this->_lecturer = \SoictApp::getModel('lecturer')->load($lecturerId);
		}

		return $this->_lecturer;
	}

	public function getPaging(){
		if(!$this->_paging){
			$this->_paging = \SoictApp::getModel('toolbar/paging');
		}
		return $this->_paging;
	}

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
