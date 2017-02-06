<?php

namespace Soict\Controller\Adminhtml\Student;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Edit extends ControllerBackend {

	public function execute(){

		$this->_id = isset($_GET['id'])?$_GET['id']:'';

		//$student = $this->getStudent();

		$this->setTemplate('student/edit.php');
	}

	//get the item
	public function getStudent(){
		if($this->_id){
			return \SoictApp::getModel('student')->load($this->_id);
		}

		$student = \SoictApp::getModel('student');

		if($this->helper('session')->getData('lecturer_post')) {
			$student->setData($this->helper('session')->getData('lecturer_post'));
		}

		return $student;
	}

}
