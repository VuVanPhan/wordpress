<?php

namespace Soict\Controller\Company;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class My_internships extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('company/my-internships.php');
		$this->setTitle('Các chương trình thực tập');


	}


	public function getCollection(){
		if(!$this->_collection){
			$this->_collection = \SoictApp::getModel('internship')->getCollection();
			$this->_collection->getSelect()->where('status', 'open');

			//filter by internship / company
			$internCom = \SoictApp::getModel('internship/company')->getCollection();
			$assigneds = array();
			$dataJoin = array();
			$company = \SoictApp::helper('user')->getCurrentUser();
			$internCom->getSelect()->where('company_id', $company->getId());
			foreach($internCom->getSelect() as $internshipCompany){
				$assigneds[] = $internshipCompany['internship_program_id'];
				$data = (array) $internshipCompany->jsonSerialize();
				unset($data['id']);
				$dataJoin[$internshipCompany['internship_program_id']] = $data;
			}

			$this->_collection->getSelect()->and('id', $assigneds);

			//add join data internship company registered
			foreach ($this->_collection as $dataItem) {
				//unset($dataJoin[$dataItem->getId()]['id']); //remove id key
				$this->_collection->removeItemByKey($dataItem->getId());
				$dataItem->addData($dataJoin[$dataItem->getId()]);
				$this->_collection->addItem($dataItem);
			}

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
