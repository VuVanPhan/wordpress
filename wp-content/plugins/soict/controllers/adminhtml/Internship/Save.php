<?php

namespace Soict\Controller\Adminhtml\Internship;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Save extends ControllerBackend {

	public function execute(){

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			try{

				//saving model
				$this->_id = isset($_GET['id'])?$_GET['id']:'';
				$model = $this->getModel();
				if($this->_id){
					$model->addData($_POST);
					$model->setId($this->_id);
				}else{
					$model->setData($_POST);
				}

				$model->save(); //save model

				if(!$model->getId()) {
					$this->helper('session')->setData('internship_post', $_POST);
					$this->setNotice3('Error when save'); //message
				}else{
					$this->helper('session')->clear('internship_post');
				}

			}catch(\Exception $e){
				throw new \Exception('Error when saving Internship data '. $e->getMessage());
			}

			$this->_redirect('admin.php?page=soict-internship-edit&id='.$model->getId()); //forward controller
		}else{
			$this->setBody('Not accept request method '. $_SERVER['REQUEST_METHOD']);
		}
	}

	//get the item
	public function getModel(){
		if($this->_id){
			return \SoictApp::getModel('internship')->load($this->_id);
		}
		return \SoictApp::getModel('internship');
	}

}
