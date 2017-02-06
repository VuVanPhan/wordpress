<?php

namespace Soict\Controller\Adminhtml\Internship;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Delete extends ControllerBackend {

	public function execute(){

		if(isset($_GET['mass_action'])){
			$this->_mass_ids = isset($_GET['mass_action'])?$_GET['mass_action']:'';
		}elseif(isset($_GET['id'])){
			$this->_mass_ids = isset($_GET['id'])?$_GET['id']:'';
		}

		if($this->_mass_ids){
			if(!is_array($this->_mass_ids)) $this->_mass_ids = array($this->_mass_ids);

			foreach($this->_mass_ids as $item_id){
				try{
					//delete mass action model
					$model = \SoictApp::getModel('internship');
					$model->setId($item_id);
					$model->delete();
				}catch(\Exception $e){
					throw new \Exception('Error when delete item '. $item_id .' '. $e->getMessage());
				}
			}
		}

		$redirect_url = 'admin.php?page=soict-internship';

		if(isset($_GET['s']) && $_GET['s'] != ''){
			$redirect_url .= '&s='.$_GET['s'];
		}
		$this->_redirect($redirect_url); //forward controller
	}


}
