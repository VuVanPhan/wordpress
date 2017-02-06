<?php

namespace Soict\Controller\Adminhtml\Internship\Assign\Lecturer;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Edit extends ControllerBackend {

	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'ass_lecturer_edit_';

	private $_internship_id;
	private $_student_id;
	private $_company_id;
	private $_group_id;

	public function execute(){
		if(isset($_GET['id'])){
			$this->_group_id = $_GET['id'];
			$this->helper('session')->setData($this->_prefix.'group_id', $_GET['id']);
		}else{
			$this->_group_id = $this->helper('session')->getData($this->_prefix.'group_id');
		}

		if(isset($_GET['internship_id'])){
			$this->_internship_id = $_GET['internship_id'];
			$this->helper('session')->setData($this->_prefix.'internship_id', $_GET['internship_id']);
		}else{
			$this->_internship_id = $this->helper('session')->getData($this->_prefix.'internship_id');
		}

		if(isset($_GET['student_id'])){
			$this->_student_id = $_GET['student_id'];
			$this->helper('session')->setData($this->_prefix.'student_id', $_GET['student_id']);
		}else{
			$this->_student_id = $this->helper('session')->getData($this->_prefix.'student_id');
		}

		if(isset($_GET['company_id'])){
			$this->_company_id = $_GET['company_id'];
			$this->helper('session')->setData($this->_prefix.'company_id', $_GET['company_id']);
		}else{
			$this->_company_id = $this->helper('session')->getData($this->_prefix.'company_id');
		}

		//do actions
		if(isset($_GET['action']) && $_GET['action'] == 'save'){

			if (isset($_GET['checked_lecturer']) && $_GET['checked_lecturer'] != '') {
				
				$group = \SoictApp::getModel('internship/group')->load($this->_group_id);
				$group->setLecturerId($_GET['checked_lecturer']);
				$group->save();

				$this->_redirect('admin.php?page=soict-internship-assign-lecturer&id='.$this->_internship_id);
				exit;
			}

		}

		$this->setTemplate('internship/assign/lecturer/edit.php');
	}

	public function getGroupId() {
		return $this->_group_id;
	}

	public function getInternshipId() {
		return $this->_internship_id;
	}

	public function getCompanyId() {
		return $this->_company_id;
	}

	public function getStudentId() {
		return $this->_student_id;
	}

	//return the lecturers
	public function getLecturers(){
		$lecturers = \SoictApp::getModel('lecturer')->getCollection();
		return $lecturers;
	}

	//return the students unassigned
	public function getStudent(){
		return \SoictApp::getModel('student')->load($this->_student_id);
	}

	//get internship object
	public function getInternship(){
		if($this->_internship_id){
			return \SoictApp::getModel('internship')->load($this->_internship_id);
		}
		return \SoictApp::getModel('internship');
	}

	//get internship groups
	public function getCollection(){
		if(!$this->_collection){
			$this->_collection = \SoictApp::getModel('internship/group')->getCollection();
		}

		$this->_collection = $this->getPaging()->getPagingCollection($this->_collection);

		//search or

		//search by student name
		$studentSearch = array();
		if($this->_search){
			$studentsSearching = \SoictApp::getModel('student')->getCollection();
			$studentsSearching->getSelect()->where("name LIKE '%$this->_search%'");
			foreach($studentsSearching->getSelect() as $row){
				$studentSearch[] = $row['id'];
			}
		}

		//search by company name
		$companySearch = array();
		if($this->_search){
			$companySearching = \SoictApp::getModel('company')->getCollection();
			$companySearching->getSelect()->where("name LIKE '%$this->_search%'");
			foreach($companySearching->getSelect() as $row){
				$companySearch[] = $row['id'];
			}
		}

		//search by company name
		$lecturerSearch = array();
		if($this->_search){
			$lecturerSearching = \SoictApp::getModel('lecturer')->getCollection();
			$lecturerSearching->getSelect()->where("name LIKE '%$this->_search%'");
			foreach($lecturerSearching->getSelect() as $row){
				$lecturerSearch[] = $row['id'];
			}
		}

		if(count($studentSearch))
			$this->_collection->getSelect()->where('student_id', $studentSearch);
		if(count($companySearch))
			$this->_collection->getSelect()->or('company_id', $companySearch);
		if(count($lecturerSearch))
			$this->_collection->getSelect()->or('lecturer_id', $lecturerSearch);

		//var_dump($this->_collection->__toString());die;

		return $this->_collection;
	}

	public function getCompanyName($id){
		$conn = \SoictApp::getModel('company')->getCollection();
		$conn->getSelect()->select('name')
			->where('id', $id)->limit(1);
		$row = $conn->getSelect()->fetch();
		return isset($row['name']) ? $row['name'] : '';
	}

	public function getLecturerName($id){
		$conn = \SoictApp::getModel('lecturer')->getCollection();
		$conn->getSelect()->select('name')
			->where('id', $id)->limit(1);
		$row = $conn->getSelect()->fetch();
		return isset($row['name']) ? $row['name'] : '';
	}


	//get current value from session
	public function getCurrent($var_name){
		if($var_name){
			return $this->helper('session')->getData($this->_prefix.$var_name);
		}
		return '';
	}


}
