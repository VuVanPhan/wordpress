<?php

namespace Soict\Controller\Adminhtml\Lecturer;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Edit extends ControllerBackend {

	public function execute(){

		$this->_id = isset($_GET['id'])?$_GET['id']:'';

		$this->setTemplate('lecturer/edit.php');
	}

	//get the item
	public function getModel(){
		if($this->_id){
			return \SoictApp::getModel('lecturer')->load($this->_id);
		}

		$company = \SoictApp::getModel('lecturer');

		if($this->helper('session')->getData('lecturer_post')) {
			$company->setData($this->helper('session')->getData('lecturer_post'));
		}

		return $company;
	}

}
