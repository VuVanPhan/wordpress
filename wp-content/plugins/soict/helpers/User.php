<?php

namespace Soict\Helper;

class User {

	const USER_TYPE_STUDENT = 'student';
	const USER_TYPE_COMPANY = 'company';
	const USER_TYPE_LECTURER = 'lecturer';

	protected $_user_type;
	protected $_curent_user;

	public function getUserType($id = ''){
		$wpUser = wp_get_current_user();

		if($id){
			$_wp_user_id = $id;
		}else{
			$_wp_user_id = $wpUser->ID;
		}

		if($this->_user_type){
			return $this->_user_type;
		}
		$model = \SoictApp::getModel('student')->load($_wp_user_id, 'user_id');
		if($model->getId()){
			$this->_user_type = self::USER_TYPE_STUDENT;
			return self::USER_TYPE_STUDENT;
		}
		$model = \SoictApp::getModel('company')->load($_wp_user_id, 'user_id');
		if($model->getId()){
			$this->_user_type = self::USER_TYPE_COMPANY;
			return self::USER_TYPE_COMPANY;
		}
		$model = \SoictApp::getModel('lecturer')->load($_wp_user_id, 'user_id');
		if($model->getId()){
			$this->_user_type = self::USER_TYPE_LECTURER;
			return self::USER_TYPE_LECTURER;
		}
		return '';
	}


	//get current user object
	//return Student | Company | Lecturer - object
	public function getCurrentUser() {
		$wpUser = wp_get_current_user();

		$wpUser->ID;

		$modelUser = \SoictApp::getModel('soictUser');

		switch( $this->getUserType() ){

			case self::USER_TYPE_STUDENT:
				$modelUser = \SoictApp::getModel('student')->load($wpUser->ID, 'user_id');
				break;
			case self::USER_TYPE_LECTURER:
				$modelUser = \SoictApp::getModel('lecturer')->load($wpUser->ID, 'user_id');
				break;
			case self::USER_TYPE_COMPANY:
				$modelUser = \SoictApp::getModel('company')->load($wpUser->ID, 'user_id');
				break;
		}

		return $modelUser;
	}

}
