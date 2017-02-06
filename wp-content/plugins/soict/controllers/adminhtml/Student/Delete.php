<?php

namespace Soict\Controller\Adminhtml\Student;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Delete extends ControllerBackend {

	public function execute(){

		//if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
						$model = \SoictApp::getModel('student');
						$model->load($item_id);
						$model->setId($item_id);

						if (wp_delete_user( $model->getUserId())) {
							$model->delete();
						}

					}catch(\Exception $e){
						throw new \Exception('Error when delete item '. $item_id .' '. $e->getMessage());
					}
				}
			}

			$redirect_url = 'admin.php?page=soict-student';

			if(isset($_GET['paged']) && $_GET['paged'] != ''){
				$redirect_url .= '&paged='.$_GET['paged'];
			}

			if(isset($_GET['s']) && $_GET['s'] != ''){
				$redirect_url .= '&s='.$_GET['s'];
			}
			$this->_redirect($redirect_url); //forward controller
		//}else{
		//	$this->setBody('Not accept request method '. $_SERVER['REQUEST_METHOD']);
		//}
	}

	public function getCollection(){
		$student = \SoictApp::getModel('student');
		$collection = $student->getCollection();


		return $collection;
	}

	public function sorted($by){
		if($this->_orderby == $by){
			return 'sorted '. $this->_order;
		}
		return '';
	}
}
