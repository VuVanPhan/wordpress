<?php

namespace Soict\Model;

use \Torm\Object as TormObject;

require_once 'Resource/Torm/Object.php';
require_once 'Resource/Student.php';

class User extends TormObject {

	const TABLE_NAME = 'users'; //wp user

	public function __construct(){
		parent::__construct();
		$this->init(self::TABLE_NAME, 'ID');
	}

}
