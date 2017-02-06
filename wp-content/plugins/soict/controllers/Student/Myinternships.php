<?php

namespace Soict\Controller\Student;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Myinternships extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('student/myinternships.php');
		$this->setTitle('Các khóa thực tập của tôi');
		
		if ($this->getCollection()->getSize() == 1) {
			$this->_forward('student/myinternships/view');
		}

	}


	public function getCollection(){
		if(!$this->_collection){
			$studentId = \SoictApp::helper('user')->getCurrentUser()->getId();
			$this->_collection = \SoictApp::getModel('internship')->getCollection();
			//$this->_collection->getSelect()->where('status', 'open');

			$internshipIds = array();
			$filterStudent = \SoictApp::getModel('internship/student')->getCollection();
			$filterStudent->getSelect()->where('student_id', $studentId);

			foreach ($filterStudent as $row) {
				$internshipIds[] = $row['internship_program_id'];
			}

			$this->_collection->getSelect()->where('id', $internshipIds); //where id in array()

			$this->getPaging()->setOrderBy('from_date', 'desc');
			$this->_collection = $this->getPaging()->getPagingCollection($this->_collection);
		}

		return $this->_collection;
	}

	public function getPaging(){
		if(!$this->_paging){
			$this->_paging = \SoictApp::getModel('toolbar/paging');
		}
		return $this->_paging;
	}

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
