<?php

namespace Soict\Controller\Adminhtml;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Lecturer extends ControllerBackend {

	private $_action = '';
	private $_action2 = '';
	private $_search = '';

	private $_collection;
	private $_paging;


	public function execute(){
		$this->_collection = \SoictApp::getModel('lecturer')->getCollection();
		$this->_paging = \SoictApp::getModel('adminhtml/paging');

		//load from param
		$this->_action = isset($_GET['action'])  ? $_GET['action']:'';
		$this->_action2 = isset($_GET['action2']) ? $_GET['action2']:'';
		$this->_search = isset($_GET['search'])	? $_GET['search']:'';

		$this->helper('session')->register('search', 	$this->_search);

		if($this->_action == 'delete' || $this->_action2 == 'delete'){
			$this->_forward('lecturer/delete');
			return;
		}

		if(isset($_GET['search']) && $_GET['search'] != ''){
			$this->_search = $this->helper('session')->setData('search', $_GET['s']);
		}

		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_search = $this->helper('session')->setData('search', '');
			$this->_paging->reset();
		}

		$this->_collection = $this->_paging->getPagingCollection($this->_collection);

		$this->setTemplate('lecturer.php');
	}

	public function getCollection(){
		$collection = $this->_collection;

		$_where = '';
		if($this->_search){
			$_where = "name LIKE '%$this->_search%' OR gender LIKE '%$this->_search%' OR birthday LIKE '%$this->_search%'
			OR job LIKE '%$this->_search%' OR address LIKE '%$this->_search%'
			OR profession_skill LIKE '%$this->_search%' OR phone LIKE '%$this->_search%' ";
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
			return $this->helper('session')->getData($var_name);
		}
		return '';
	}

}
