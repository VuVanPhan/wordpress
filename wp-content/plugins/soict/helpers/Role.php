<?php

namespace Soict\Helper;

class Role {

	public function __construct(){

	}

	public function getValue($name){
		return \SoictApp::getModel('role')->getRoleValue($name);
	}


}
