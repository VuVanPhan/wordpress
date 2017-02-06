<?php

namespace Soict\Model;

use \Torm\Object as TormObject;

require_once 'Resource/Torm/Object.php';
require_once 'Resource/Student.php';

class SoictUser extends TormObject {

	protected $_user;

	protected $_logout_redirect_to;


	//for save user email or change to wp user
	public function saveUserEmail($email){
		if($this->getUser()){
			$user = new \WP_User($this->getData('user_id'));
			$user->user_email = $email;
			wp_update_user($user);
		}
		return $this;
	}

	public function changeUserLogin($newname){
		if($this->getUser()){
			$user = \SoictApp::getModel('user')->load($this->getData('user_id'));
			$user->setData('user_login', $newname);
			$user->save();
		}
		return $this;
	}

	//for save user email or change to wp user
	public function updateUserEmail($email){
		if($this->getUser()){
			$user = new \WP_User($this->getData('user_id'));
			$user->user_email = $email;
			wp_update_user($user);
		}
		return $this;
	}

	public function updatePassword($password){
		if($this->getUser()){
			$user = new \WP_User($this->getData('user_id'));
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

	public function getUserEmail(){
		if($this->getUser()){
			return $this->getUser()->getUserEmail();
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

	//return photo with full url path
	public function getUserPhoto() {

		if (strpos(\SoictApp::getUrlPath(get_wp_user_avatar_src( $this->getUserId())), 'http') === 0) {
			return get_wp_user_avatar_src( $this->getUserId());
		}

		if (file_exists( get_home_path() . trim(\SoictApp::getUrlPath(get_wp_user_avatar_src( $this->getUserId())), DS) )) {
			return \SoictApp::getFullUrl(get_wp_user_avatar_src( $this->getUserId()));
		}

		return '';
	}

	//get user photo img src path
	//child class must implement this function
	public function getUserPhotoSrc() {
		if ($this->getAvatar()) {
			return $this->getAvatar();
		}
		return '';
	}

	public function setLogoutRedirect($redirect_to) {
		$this->_logout_redirect_to = $redirect_to;
		return $this;
	}

	public function getLogoutRedirect() {
		return $this->_logout_redirect_to;
	}

	//function run when apply filters logout_redirect
	public function logoutAfter($redirect_to) {
		if ($this->_logout_redirect_to) {
			return $this->_logout_redirect_to;
		}
		return get_home_url();
		//return $redirect_to;
	}

	protected function _afterLoad(){
		//$this->getUser();
		return $this;
	}

}
