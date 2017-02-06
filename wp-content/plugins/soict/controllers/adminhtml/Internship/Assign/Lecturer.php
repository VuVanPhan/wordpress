<?php

namespace Soict\Controller\Adminhtml\Internship\Assign;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Lecturer extends ControllerBackend {

	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'ass_lecturer_';

	private $_internship_id;

	public function execute(){
		if(isset($_GET['id'])){
			$this->_internship_id = $_GET['id'];
			$this->helper('session')->setData($this->_prefix.'internship_id', $_GET['id']);
		}else{
			$this->_internship_id = $this->helper('session')->getData($this->_prefix.'internship_id');
		}

		//do actions
		if(isset($_GET['action']) && $this->_internship_id){
			switch($_GET['action']){
				case 'submit_assign':
					if(isset($_GET['checked_student']) && count($_GET['checked_student'])
						&& isset($_GET['checked_company']) && $_GET['checked_company']
						&& isset($_GET['checked_lecturer']) && $_GET['checked_lecturer']){

						foreach($_GET['checked_student'] as $id){
							$group = \SoictApp::getModel('internship/group');
							$group->setData(array(
								'internship_program_id' => $this->_internship_id,
								'student_id'	=>	$id,
								'company_id'	=>	$_GET['checked_company'],
								'lecturer_id'	=>	$_GET['checked_lecturer'],
							));
							$group->save();
						}

						$intrnLec = \SoictApp::getModel('internship/lecturer');
						$intrnLec->setData(array(
							'internship_program_id' => $this->_internship_id,
							'lecturer_id'	=>	$_GET['checked_lecturer'],
							'register_date' => 	date('Y-m-d H:i:s')
						))->save();
					}
					break;
				case 'delete':
					if(isset($_GET['item_id']) && $_GET['item_id']){
						$group = \SoictApp::getModel('internship/group');
						$group->setId($_GET['item_id']);
						$group->delete();
					}
					break;
				case 'search':
					$this->helper('session')->setData($this->_prefix.'search', $_GET['s']);
					$this->_search = $this->helper('session')->getData($this->_prefix.'search');
					break;
				default:
					break;
			}

		}


		//load from param
//		$this->_search = isset($_GET['search'])	? $_GET['search']:'';
//
//		if(isset($_GET['search']) && $_GET['search'] != ''){
//			$this->_search = $this->helper('session')->setData($this->_prefix.'search', $_GET['s']);
//		}

		$this->_paging = $this->getPaging();
		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', '');
			$this->_paging->reset();
		}


		$this->setTemplate('internship/assign/lecturer.php');
	}

	//return the lecturers
	public function getLecturers(){
		$lecturers = \SoictApp::getModel('lecturer')->getCollection();
		return $lecturers;
	}

	//return the companies assigned
	public function getCompanies(){
		$companies = \SoictApp::getModel('company')->getCollection();

		$internshipComs = \SoictApp::getModel('internship/company')->getCollection();
		$internshipComs->getSelect()->where('internship_program_id', $this->_internship_id);
		$comsInInternship = array();
		foreach($internshipComs->getSelect() as $internCom){
			$comsInInternship[] = $internCom['company_id'];
		}

		$companies->getSelect()->where('id', $comsInInternship);

		return $companies;
	}

	//return the students unassigned
	public function getStudents(){
		return $this->getStudentsUnassigned();
	}

	//return the students unassinged
	public function getStudentsUnassigned(){
		$students = \SoictApp::getModel('student')->getCollection();

		$studentsAssigned = $this->getStudentsAssigned();
		$studentsAssignedIds = array();
		foreach($studentsAssigned->getSelect() as $student){
			$studentsAssignedIds[] = $student['id'];
		}

		$internshipStudents = \SoictApp::getModel('internship/student')->getCollection();
		$internshipStudents->getSelect()->where('internship_program_id', $this->_internship_id);
		$internshipStudents->getSelect()->and('NOT student_id', $studentsAssignedIds);
		$studentsInInternship = array();
		foreach($internshipStudents->getSelect() as $internStu){
			$studentsInInternship[] = $internStu['student_id'];
		}

		$students->getSelect()->where('id', $studentsInInternship);

		return $students;
	}

	public function getStudentsAssigned(){
		$students = \SoictApp::getModel('student')->getCollection();

		$groups = \SoictApp::getModel('internship/group')->getCollection();
		$groups->getSelect()->where('internship_program_id', $this->_internship_id);
		$assigneds = array();
		foreach($groups->getSelect() as $grp){
			$assigneds[] = $grp['student_id'];
		}
		$students->getSelect()->where('id', $assigneds);

		return $students;
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

	public function getStudentName($id){
		$conn = \SoictApp::getModel('student')->getCollection();
		$conn->getSelect()->select('name')
			->where('id', $id)->limit(1);
		$row = $conn->getSelect()->fetch();
		return isset($row['name']) ? $row['name'] : '';
	}

	public function getStudentId($id){
		$conn = \SoictApp::getModel('student')->getCollection();
		$conn->getSelect()->select('student_id')
			->where('id', $id)->limit(1);
		$row = $conn->getSelect()->fetch();
		return isset($row['student_id']) ? $row['student_id'] : '';
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

	//get paging list
	public function getPaging(){
		if(!$this->_paging){
			$this->_paging = \SoictApp::getModel('adminhtml/paging');
			$this->_paging->setPrefix($this->_prefix);
		}
		return $this->_paging;
	}

	public function sorted($by){
		if($this->_paging && $this->_paging->getOrderBy() == $by){
			return 'sorted '. $this->_paging->getOrder();
		}
		return '';
	}

	//get current value from session
	public function getCurrent($var_name){
		if($var_name){
			return $this->helper('session')->getData($this->_prefix.$var_name);
		}
		return '';
	}

	//get internship object
	public function getInternship(){
		if($this->_internship_id){
			return \SoictApp::getModel('internship')->load($this->_internship_id);
		}
		return \SoictApp::getModel('internship');
	}
}
