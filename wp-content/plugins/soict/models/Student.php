<?php

namespace Soict\Model;

require_once SOICT_PLUGIN_MODEL_DIR.'SoictUser.php';

class Student extends SoictUser {

	const TABLE_NAME = 'soict_student';

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'id');
	}


	protected function _afterLoad(){
		//$this->getUser();
		return $this;
	}

	public function getUserPhoto(){

		if (strpos(\SoictApp::getUrlPath(get_wp_user_avatar_src( $this->getUserId())), 'http') === 0) {
			return get_wp_user_avatar_src( $this->getUserId());
		}

		if (file_exists( get_home_path() . trim(\SoictApp::getUrlPath(get_wp_user_avatar_src( $this->getUserId())), DS) )) {
			return \SoictApp::getFullUrl(get_wp_user_avatar_src( $this->getUserId()));
		}

		return '';
	}

	//get user photo img src path
	public function getUserPhotoSrc() {
		if ($this->getAvatar()) {
			return get_home_url(null, $this->getAvatar());
		}
		return '';
	}

}
