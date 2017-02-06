<?php

namespace Soict\Model\Internship;

require_once SOICT_PLUGIN_MODEL_DIR.'Resource/Torm/Object.php';

class Company extends \Torm\Object {

	const TABLE_NAME = 'soict_internship_company';

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'id');
	}

}
