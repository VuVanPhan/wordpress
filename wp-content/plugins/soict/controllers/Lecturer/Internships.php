<?php

namespace Soict\Controller\Lecturer;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Internships extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('lecturer/internships.php');
		$this->setTitle('Các chương trình thực tập');


	}


	public function getCollection(){
		if(!$this->_collection){
			$this->_collection = \SoictApp::getModel('internship')->getCollection();
			$this->_collection->getSelect()->where('status', 'open');

			//filter by internship / lecturer
			$internCom = \SoictApp::getModel('internship/lecturer')->getCollection();
			$assigneds = array();
			$dataJoin = array();
			$lecturer = \SoictApp::helper('user')->getCurrentUser();
			$internCom->getSelect()->where('lecturer_id', $lecturer->getId());

			foreach($internCom->getSelect() as $internshipCompany){
				$assigneds[] = $internshipCompany['internship_program_id'];
				$data = (array) $internshipCompany->jsonSerialize();
				unset($data['id']);
				$dataJoin[$internshipCompany['internship_program_id']] = $data;
			}

			$this->_collection->getSelect()->and('id', $assigneds);

			//join to internship_group
			$joinedGroups = array();
			$internGroup = \SoictApp::getModel('internship/group')->getCollection();
			$internGroup->getSelect()
				->select('internship_program_id', 'COUNT(student_id) AS student_qty')
				->where('lecturer_id', $lecturer->getId())
				->and('internship_program_id', $assigneds)
				->group('internship_program_id');
			foreach($internGroup->getSelect() as $internshipGroup){
				$data = (array) $internshipGroup->jsonSerialize();
				unset($data['internship_program_id']);
				$joinedGroups[$internshipGroup['internship_program_id']] = $data;
			}

			//add join data internship
			foreach ($this->_collection as $dataItem) {
				$this->_collection->removeItemByKey($dataItem->getId());
				$dataItem->addData($dataJoin[$dataItem->getId()]);
				$dataItem->addData($joinedGroups[$dataItem->getId()]);
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
