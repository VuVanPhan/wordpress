<?php

namespace Soict\Controller\Company\Internships;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Register extends ControllerFrontend {


	public function execute(){
		$this->setTemplate('company/internships/register.php');
		$this->setTitle('Đăng ký - SV Thực tập');

		//die('aha');
	}


	public function getInternship(){
		if(isset($_GET['internship'])){
			return \SoictApp::getModel('internship')->load($_GET['internship']);
		}
		return false;
	}

}
