<?php

namespace Soict\Controller;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Company extends ControllerFrontend {

	public function execute(){
		$this->_redirect('company/internships');
	}

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
