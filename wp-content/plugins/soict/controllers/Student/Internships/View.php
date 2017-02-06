<?php

namespace Soict\Controller\Student\Internships;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class View extends ControllerFrontend {

	private $_collection;
	private $_paging;

	public function execute(){
		$this->setTemplate('student/internships/view.php');
		$this->setTitle('Các công ty thực tập');

		if ( !isset($_GET['internship']) || $_GET['internship'] == '' ) {
			$this->setNotice1(__('Không tìm thấy dữ liệu'));
			return;
		}


		if (isset($_GET['register-company']) && $_GET['register-company'] != '') {

			$studentId = \SoictApp::helper('user')->getCurrentUser()->getId();
			//check is registered
			$groups = \SoictApp::getModel('internship/group')->getCollection();
			$groups->getSelect()->where('internship_program_id', $_GET['internship'])
				->and('company_id', $_GET['register-company'])
				->and('student_id', $studentId);

			if ($groups->getSize() <= 0) {

				if ($this->onlyRegisterOneCompany($_GET['internship'])) {

					if (!$this->isFullSlot( $_GET['register-company'], $_GET['internship'] )) {
						$internGroup = \SoictApp::getModel('internship/group');
						$internGroup->setData(
							array(
								'internship_program_id' => $_GET['internship'],
								'company_id' => $_GET['register-company'],
								'student_id' => $studentId,
								//'lecturer_id' => 0,
							)
						);

						$internGroup->save();

						//save internship student
						$internStudent = \SoictApp::getModel('internship/student');
						$internStudent->setData(
							array(
								'internship_program_id' => $_GET['internship'],
								'student_id' 			=> $studentId,
								'register_date' 		=> date('Y-m-d H:i:s'),
							)
						);
						$internStudent->save();

						$this->setNotice3(__('Chúc mừng bạn đã đăng ký thành công.'));

					} else {

						$this->setNotice2(__('Số lượng đăng ký đã tới hạn.'));

					}
				} else {
					$this->setNotice2(__('Bạn đã đăng ký vào công ty khác.'));
				}
			} else {

				$this->setNotice2(__('Bạn đã đăng ký không thể đăng ký lại.'));

			}

			$this->_redirect('student/internships/view?internship=' . $_GET['internship'] );

		}

	}


	public function getCollection(){
		if (!isset($_GET['internship']) || $_GET['internship'] == '') {
			return false;
		}
		if(!$this->_collection){

			//get main collection
			$this->_collection = \SoictApp::getModel('company')->getCollection();

			//get company filter
			$coms = \SoictApp::getModel('internship/company')->getCollection();
			$coms->getSelect()
				->where('internship_program_id', $_GET['internship']);

			$companyIds = array();
			$companyJoined = array();
			foreach ($coms->getSelect() as $row) {
				$companyIds[] = $row['company_id'];
				$companyJoined[$row['company_id']] = array(
					'register_date'=>$row['register_date'],
					'student_qty'=>$row['student_qty'],
				);
			}

			//where in array
			$this->_collection->getSelect()->where('id', $companyIds);

			//join to internship_group
			$joinedGroups = array();
			$internGroup = \SoictApp::getModel('internship/group')->getCollection();
			$internGroup->getSelect()
				->select('company_id', 'COUNT(student_id) AS registered_qty')
				->where('company_id', $companyIds)
				->and('internship_program_id', $_GET['internship'])
				->group('company_id');
			foreach($internGroup->getSelect() as $row){
				$data = (array) $row->jsonSerialize();
				unset($data['company_id']);
				$joinedGroups[$row['company_id']] = array('registered_qty' => $data['registered_qty']);
			}

			//add join data internship
			foreach ($this->_collection as $dataItem) {
				$this->_collection->removeItemByKey($dataItem->getId());

				$dataItem->addData($companyJoined[$dataItem->getId()]);

				$joinRegisQty = (isset($joinedGroups[$dataItem->getId()])) ?
					$joinedGroups[$dataItem->getId()] : array('registered_qty' => 0);

				$dataItem->addData($joinRegisQty);
				$this->_collection->addItem($dataItem);
			}

			$this->getPaging()->setOrderBy('name', 'asc');
			$this->_collection = $this->getPaging()->getPagingCollection($this->_collection);
		}

		return $this->_collection;
	}

	public function onlyRegisterOneCompany( $internship_id ) {
		$studentId = \SoictApp::helper('user')->getCurrentUser()->getId();
		$internGroup = \SoictApp::getModel('internship/group')->getCollection();
		$internGroup->getSelect()
			->select('student_id')
			->and('internship_program_id', $internship_id)
			->and('student_id', $studentId)
			->limit(1);

		if ($internGroup->getSize() > 0) {
			return false;
		}

		return true;
	}

	public function isFullSlot( $company_id, $internship_id ) {
		//get student qty max
		$coms = \SoictApp::getModel('internship/company')->getCollection();
		$coms->getSelect()->select('student_qty')
			->where('internship_program_id', $internship_id)
			->and('company_id', $company_id)
			->limit(1);


		$qtyMax = $coms->getSelect() [0]['student_qty'];

		//join to internship_group
		$internGroup = \SoictApp::getModel('internship/group')->getCollection();
		$internGroup->getSelect()
			->select('COUNT(student_id) AS `registered_qty`')
			->where('company_id', $company_id)
			->and('internship_program_id', $internship_id)
			->group('company_id');

		$registeredQty = ($internGroup->getSize()) ? $internGroup->getSelect() [0]['registered_qty'] : 0;

		if ( $qtyMax <= $registeredQty ) {
			return true;
		}

		return false;
	}

	public function getInternship(){
		if(isset($_GET['internship']) && $_GET['internship'] != ''){
			return \SoictApp::getModel('internship')->load($_GET['internship']);
		}
		return false;
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
