<?php

namespace Soict\Model\Internship;

require_once SOICT_PLUGIN_MODEL_DIR.'Resource/Torm/Object.php';

class Lecturer extends \Torm\Object {

	const TABLE_NAME = 'soict_internship_lecturer';

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'id');
	}

}
