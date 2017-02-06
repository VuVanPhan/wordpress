<?php

namespace Soict\Controller\Adminhtml\Internship\Assign;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Company extends ControllerBackend {

	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'ass_company_';

	private $_internship_id;

	public function execute(){
		if(isset($_GET['id'])){
			$this->_internship_id = $_GET['id'];
			$this->helper('session')->setData($this->_prefix.'internship_id', $_GET['id']);
		}else{
			$this->_internship_id = $this->helper('session')->getData($this->_prefix.'internship_id');
		}
		//do action
		//$_GET['id'] is internship id
		if(isset($_GET['action']) && isset($_GET['id']) && $_GET['id'] != ''){
			if($_GET['action'] == 'assign'){
				if(isset($_GET['mass_action']) && count($_GET['mass_action'])){
					$qty = isset($_GET['student_qty']) ? $_GET['student_qty']:'';
					foreach($_GET['mass_action'] as $id){
						$internCom = \SoictApp::getModel('internship/company');
						$internCom->setData(array(
							'internship_program_id'=>$_GET['id'],
							'student_qty'	=>	$qty,
							'company_id'	=>	$id,
							'register_date' => 	date('Y-m-d H:i:s')
						));
						$internCom->save();
					}
				}
			}
		}

		$this->_collection = \SoictApp::getModel('company')->getCollection();
		$this->_paging = \SoictApp::getModel('adminhtml/paging');
		$this->_paging->setPrefix($this->_prefix);

		//load from param
		$this->_search = isset($_GET['search'])	? $_GET['search']:'';

		$this->helper('session')->register($this->_prefix.'search', 	$this->_search);

		if(isset($_GET['search']) && $_GET['search'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', $_GET['s']);
		}

		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', '');
			$this->_paging->reset();
		}

		$this->_collection = $this->_paging->getPagingCollection($this->_collection);

		$this->setTemplate('internship/assign/company.php');
	}

	public function getCollection(){
		$collection = $this->_collection;

		$_where = '';
		if($this->_search){
			$_where = "name LIKE '%$this->_search%' OR address LIKE '%$this->_search%' OR field LIKE '%$this->_search%'
			OR seniority LIKE '%$this->_search%' OR description LIKE '%$this->_search%'
			OR hr_email LIKE '%$this->_search%' OR hr_phone LIKE '%$this->_search%' ";
		}

		if($_where){
			$collection->getSelect()->where($_where);
		}

		$internCom = \SoictApp::getModel('internship/company')->getCollection();
		$assigneds = array();
		$internCom->getSelect()->where('internship_program_id', $this->_internship_id);
		foreach($internCom->getSelect() as $internshipCompany){
			$assigneds[] = $internshipCompany['company_id'];
		}

		if(count($assigneds)){
			$collection->getSelect()->and('NOT id', $assigneds);
		}

		return $collection;
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
