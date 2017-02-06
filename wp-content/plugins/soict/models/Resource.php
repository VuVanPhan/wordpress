<?php

namespace Soict\Model;

class Resource {

	public function getTable($name){
		require_once 'Resource/'.ucfirst($name).'.php';
		$className = 'Soict\\Model\\Resource\\'.ucfirst($name);
		return $className::getName();
	}


}
