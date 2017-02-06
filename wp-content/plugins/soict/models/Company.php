<?php

namespace Soict\Model;

require_once SOICT_PLUGIN_MODEL_DIR.'SoictUser.php';

class Company extends SoictUser {

	protected $_user;

	const TABLE_NAME = 'soict_company';

	public function __construct(){
		parent::__construct();
	}

	protected function _init(){
		return array(self::TABLE_NAME, 'id');
	}


	//for save user email or change to wp user
	public function saveUserEmail($email){
		if($this->getUser()){
			$user = new \WP_User($this->getUserId());
			$user->user_email = $email;
			wp_update_user($user);
		}
		return $this;
	}

	public function updatePassword($password){
		if($this->getUser()){
			$user = new \WP_User($this->getUserId());
			$user->user_pass = $password;
			wp_update_user($user);
		}
		return $this;
	}

	public function getUserLogin(){
		if($this->getUser()){
			return $this->getUser()->getUserLogin();
		}
		return '';
	}

	public function getUser(){
		if(!$this->_user){
			$user = \SoictApp::getModel('user')->load($this->getUserId());
			if($user->getId()){
				$this->_user = $user;
				$this->setData('user_id', $user->getId());
				$this->setData('email', $user->getUserEmail());
			}
		}
		return $this->_user;
	}

	//check is registered internship
	//param $id object or string id Internship
	public function isRegisteredInternship($id) {

		if( is_object($id) ) {
			$id = $id->getId();
		}

		$internshipComs = \SoictApp::getModel('internship/company')->getCollection();

		$internshipComs->getSelect()->select('id')
			->where('internship_program_id', $id)
			->and('company_id', $this->getId());

		if ($internshipComs->getSize()) {
			return true;
		}
		return false;
	}

	public function getUserPhoto(){
		return parent::getUserPhoto();
	}

	protected function _afterLoad(){
		//$this->getUser();
		return $this;
	}



}
