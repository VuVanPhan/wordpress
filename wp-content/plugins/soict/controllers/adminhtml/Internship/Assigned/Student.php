<?php

namespace Soict\Controller\Adminhtml\Internship\Assigned;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Student extends ControllerBackend {

	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'ass_student_';

	private $_internship_id;

	public function execute(){
		if(isset($_GET['id'])){
			$this->_internship_id = $_GET['id'];
			$this->helper('session')->setData($this->_prefix.'internship_id', $_GET['id']);
		}else{
			$this->_internship_id = $this->helper('session')->getData($this->_prefix.'internship_id');
		}

		//load from param
		$this->_search = isset($_GET['search'])	? $_GET['search']:'';

		$this->helper('session')->register($this->_prefix.'search', $this->_search);

		if(isset($_GET['search']) && $_GET['search'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', $_GET['s']);
		}

		$this->_paging = \SoictApp::getModel('adminhtml/paging');
		$this->_paging->setPrefix($this->_prefix);

		//do action reset
		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', '');
			$this->_paging->reset();
		}

		//do action unassign
		if(isset($_GET['action']) && $this->_internship_id){
			if($_GET['action'] == 'unassign'){
				if(isset($_GET['mass_action']) && count($_GET['mass_action'])){
					$assignedStudents = \SoictApp::getModel('internship/student')->getCollection();
					$assignedStudents->getSelect()->where('internship_program_id', $this->_internship_id);
					$assignedStudents->getSelect()->and('student_id', $_GET['mass_action']);
					foreach($assignedStudents as $assigned){
						$assigned->delete();
					}

					$this->_redirect('admin.php?page=soict-internship-assigned-student&id='.$this->_internship_id);
					return;
				}
			}
		}

		$this->_collection = $this->getCollection();
		$this->_collection = $this->_paging->getPagingCollection($this->_collection);

		$this->setTemplate('internship/assigned/student.php');
	}

	public function getCollection(){

		if(!$this->_collection){
			$this->_collection = \SoictApp::getModel('student')->getCollection();
		}

		$_where = '';
		if($this->_search){
			$_where = "name LIKE '%$this->_search%' OR student_id LIKE '%$this->_search%'
			OR email LIKE '%$this->_search%' OR telephone LIKE '%$this->_search%'";
		}

		if($_where){
			$this->_collection->getSelect()->where($_where);
		}

		$internStu = \SoictApp::getModel('internship/student')->getCollection();
		$assigneds = array();
		$internStu->getSelect()->where('internship_program_id', $this->_internship_id);
		foreach($internStu->getSelect() as $internStudent){
			$assigneds[] = $internStudent['student_id'];
		}

		$this->_collection->getSelect()->and('id', $assigneds);

		return $this->_collection;
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
