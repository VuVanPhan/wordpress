<?php

namespace Soict\Controller\Student;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Internships extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('student/internships.php');
		$this->setTitle('Các khóa thực tập');


	}


	public function getCollection(){
		if(!$this->_collection){
			$this->_collection = \SoictApp::getModel('internship')->getCollection();
			$this->_collection->getSelect()->where('status', 'open');
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
