<?php

namespace Soict\Controller\Adminhtml;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Company extends ControllerBackend {

	private $_action = '';
	private $_action2 = '';
	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'company_';


	public function execute(){
		$this->_collection = \SoictApp::getModel('company')->getCollection();
		$this->_paging = \SoictApp::getModel('adminhtml/paging');
		$this->_paging->setPrefix($this->_prefix);

		//load from param
		$this->_action = isset($_GET['action'])  ? $_GET['action']:'';
		$this->_action2 = isset($_GET['action2']) ? $_GET['action2']:'';
		$this->_search = isset($_GET['search'])	? $_GET['search']:'';

		$this->helper('session')->register($this->_prefix.'search', 	$this->_search);

		if($this->_action == 'delete' || $this->_action2 == 'delete'){
			$this->_forward('company/delete');
			return;
		}

		if(isset($_GET['search']) && $_GET['search'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', $_GET['s']);
		}

		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_search = $this->helper('session')->setData($this->_prefix.'search', '');
			$this->_paging->reset();
		}

		$this->_collection = $this->_paging->getPagingCollection($this->_collection);

		$this->setTemplate('company.php');
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
			if(isset($_GET[$var_name])){
				return $_GET[$var_name];
			}
			return $this->helper('session')->getData($this->_prefix.$var_name);
		}
		return '';
	}

}
