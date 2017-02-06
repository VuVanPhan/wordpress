<?php

namespace Soict\Controller\Adminhtml;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Dashboard extends ControllerBackend {

	public function execute(){
		$this->setTemplate('dashboard.php');
	}

	public function getStudentCount() {
		return \SoictApp::getModel('student')->getCollection()->getSize();
	}

	public function getCompanyCount() {
		return \SoictApp::getModel('company')->getCollection()->getSize();
	}

	public function getLecturerCount() {
		return \SoictApp::getModel('lecturer')->getCollection()->getSize();
	}

	public function getInternshipCount() {
		return \SoictApp::getModel('internship')->getCollection()->getSize();
	}
}
