<?php

namespace Soict\Controller\Company\Internships;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Registering extends ControllerFrontend {

	protected $_registered = false;

	public function execute(){
		$hasError = false;

		$this->setTemplate('company/internships/registering.php');
		$this->setTitle(__('Đăng ký - SV Thực tập'));

		if ( isset($_POST['qty']) && $_POST['qty'] == '' ) {
			$this->setNotice1(__('Không nhập số lượng sinh viên đăng ký'));
			return;
		}

		try{
			if($this->hasRegistered()){
				$hasError = true;
				throw new \Exception(__('Bạn đã đăng ký'));
			}

			if (isset($_POST['qty']) && $_POST['qty'] > 0) {
				$company = \SoictApp::helper('user')->getCurrentUser();

				if ($company) {

					$companyRegister = \SoictApp::getModel('internship/company');
					$companyRegister->setData(
						array(
							'student_qty' => (int) $_POST['qty'],
							'internship_program_id' => $this->getInternship()->getId(),
							'company_id' => $company->getId(),
							'register_date' => date('Y-m-d H:i:s'),
						)
					)->save();
					$this->setNotice3(__('Đã ghi nhận số lượng '.$_POST['qty'].' sinh viên đăng ký thực tập kỳ này'));
					return;
				}
				$hasError = true;
				throw new \Exception(__('Có lỗi hệ thống'));
			}

			if (isset($_POST['qty']) && ($_POST['qty'] == '' || $_POST['qty'] <= 0)) {
				$hasError = true;
				throw new \Exception(__('Só lượng sinh viên đăng ký không hợp lệ'));
			}


		}catch(\Exception $e){
			if ($hasError) {
				$this->setNotice2($e->getMessage());
			}
		}

	}


	public function getInternship(){
		if(isset($_GET['internship'])){
			return \SoictApp::getModel('internship')->load($_GET['internship']);
		}
		return false;
	}

	public function hasRegistered() {

		if (!$this->_registered) {

			$company = \SoictApp::helper('user')->getCurrentUser();
			$companyRegister = \SoictApp::getModel('internship/company')->getCollection();
			$companyRegister->getSelect()
				->where('internship_program_id', $this->getInternship()->getId())
				->where('company_id', $company->getId());
			if($companyRegister->getSize()){
				$this->_registered = true;
				return true;
			}
		}

		return $this->_registered;
	}


	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
