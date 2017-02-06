<?php

namespace Soict\Controller\Company\My_internships;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Students extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('company/my-internships/students.php');
		$this->setTitle('DS Sinh viên');

		if ( !isset($_GET['internship']) || $_GET['internship'] == '' ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}


	}


	public function getCollection(){
		if (!isset($_GET['internship']) || $_GET['internship'] == '') {
			return false;
		}
		if(!$this->_collection){
			$groups = \SoictApp::getModel('internship/group')->getCollection();

			$groups->getSelect()
				->where('company_id', \SoictApp::helper('user')->getCurrentUser()->getId())
				->and('internship_program_id', $_GET['internship']);

			$students = array();

			foreach ($groups->getSelect() as $groupItem) {
				$students[] = $groupItem['student_id'];
			}

			//add where by student id
			$this->_collection = \SoictApp::getModel('internship/student')->getCollection();

			$this->_collection->getSelect()
				->where('student_id', $students)
				->and('internship_program_id', $_GET['internship']);

			$this->getPaging()->setOrderBy('register_date', 'desc');
			$this->_collection = $this->getPaging()->getPagingCollection($this->_collection);
		}

		return $this->_collection;
	}

	public function getStudent($student_id){
		return \SoictApp::getModel('student')->load($student_id);
	}

	public function getInternship(){
		if(isset($_GET['internship']) && $_GET['internship'] != ''){
			return \SoictApp::getModel('internship')->load($_GET['internship']);
		}
		return false;
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
