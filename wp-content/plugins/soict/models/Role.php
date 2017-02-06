<?php

namespace Soict\Model;

use \Torm\Object as TormObject;

require_once 'Resource/Torm/Object.php';

class Role extends TormObject{

	const TABLE_NAME = 'soict_role';

	protected function _init(){
		return array(self::TABLE_NAME, 'id');
	}

	public function getRoleValue( $roleName ){
		$this->load( $roleName, 'role_name');
		return $this->getData('role_value');
	}

}
