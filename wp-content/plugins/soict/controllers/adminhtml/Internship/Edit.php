<?php

namespace Soict\Controller\Adminhtml\Internship;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Edit extends ControllerBackend {

	public function execute(){
		$this->_id = isset($_GET['id'])?$_GET['id']:'';

		$this->setTemplate('internship/edit.php');
	}

	//get the item
	public function getModel(){
		if($this->_id){
			return \SoictApp::getModel('internship')->load($this->_id);
		}

		$company = \SoictApp::getModel('internship');

		if($this->helper('session')->getData('internship_post')) {
			$company->setData($this->helper('session')->getData('internship_post'));
		}

		return $company;
	}


}
