<?php

namespace Soict\Controller\Adminhtml\Company;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Edit extends ControllerBackend {

	public function execute(){

		$this->_id = isset($_GET['id'])?$_GET['id']:'';

		$this->setTemplate('company/edit.php');
	}

	//get the item
	public function getModel(){
		if($this->_id){
			return \SoictApp::getModel('company')->load($this->_id);
		}

		$company = \SoictApp::getModel('company');

		if($this->helper('session')->getData('company_post')) {
			$company->setData($this->helper('session')->getData('company_post'));
		}

		return $company;
	}

}
