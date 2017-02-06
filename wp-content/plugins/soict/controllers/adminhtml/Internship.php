<?php

namespace Soict\Controller\Adminhtml;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Internship extends ControllerBackend {

	private $_action = '';
	private $_action2 = '';
	private $_search = '';

	private $_collection;
	private $_paging;
	private $_prefix = 'internship';


	public function execute(){
		$this->_collection = \SoictApp::getModel('internship')->getCollection();
		$this->_paging = \SoictApp::getModel('adminhtml/paging');
		$this->_paging->setPrefix($this->_prefix);

		//load from param
		$this->_action = isset($_GET['action'])  ? $_GET['action']:'';
		$this->_action2 = isset($_GET['action2']) ? $_GET['action2']:'';
		$this->_search = isset($_GET['search'])	? $_GET['search']:'';

		$this->helper('session')->register($this->_prefix.'search', 	$this->_search);

		if($this->_action == 'delete' || $this->_action2 == 'delete'){
			$this->_forward('internship/delete');
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

		$this->setTemplate('internship.php');
	}

	public function getCollection(){
		$collection = $this->_collection;

		$_where = '';
		if($this->_search){
			$_where = "title LIKE '%$this->_search%' OR description LIKE '%$this->_search%' OR from_date LIKE '%$this->_search%'
			OR to_date LIKE '%$this->_search%' OR support_phone LIKE '%$this->_search%'
			OR support_email LIKE '%$this->_search%'";
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
			return $this->helper('session')->getData($this->_prefix.$var_name);
		}
		return '';
	}

}
