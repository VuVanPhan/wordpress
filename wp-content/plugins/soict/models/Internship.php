<?php

namespace Soict\Model;

require_once SOICT_PLUGIN_MODEL_DIR.'SoictUser.php';

class Internship extends SoictUser {

	const TABLE_NAME = 'soict_internship_program';

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'id');
	}



}
