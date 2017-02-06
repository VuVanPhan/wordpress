<?php

namespace Soict\Controller\Company;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class View extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('company/view.php');
		$this->setTitle('View | Công ty');

		if ( !isset($_GET['company']) || $_GET['company'] == '' ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}


	}



	public function getCompany(){
		if(isset($_GET['company']) && $_GET['company'] != ''){
			return \SoictApp::getModel('company')->load($_GET['company']);
		}
		return false;
	}

	

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
