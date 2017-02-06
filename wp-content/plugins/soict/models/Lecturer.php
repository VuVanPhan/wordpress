<?php

namespace Soict\Model;

require_once SOICT_PLUGIN_MODEL_DIR.'SoictUser.php';

class Lecturer extends SoictUser {

	protected $_user;

	const TABLE_NAME = 'soict_lecturer';

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'id');
	}


	protected function _afterLoad(){
		//$this->getUser();
		return $this;
	}

	public function getUserPhoto(){
		return parent::getUserPhoto();
	}
}
