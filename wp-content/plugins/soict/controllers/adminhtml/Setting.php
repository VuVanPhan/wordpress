<?php

namespace Soict\Controller\Adminhtml;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Setting extends ControllerBackend {

	public function execute(){
		$this->setTemplate('setting.php');
	}

}
