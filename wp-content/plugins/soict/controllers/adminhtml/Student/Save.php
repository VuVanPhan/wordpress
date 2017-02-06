<?php

namespace Soict\Controller\Adminhtml\Student;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class Save extends ControllerBackend {

	public function execute(){

		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			try{
				//saving model
				$this->_id = isset($_GET['id'])?$_GET['id']:'';
				$model = $this->getStudent();
				if($this->_id){
					$model->addData($_POST);
					$model->setId($this->_id);
				}else{
					$model->setData($_POST);
				}

				if($model->getUserId()){
					//update user
					if(isset($_POST['email']) && $_POST['email'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_email' => $_POST['email'] ));
					}
					if(isset($_POST['user_pass']) && $_POST['user_pass'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_pass' => $_POST['user_pass'] ));
					}
					if(isset($_POST['student_id']) && $_POST['student_id'] != ''){
						$model->changeUserLogin($_POST['student_id']);
					}

				}else{
					//create new user
					if(isset($_POST['student_id']) && $_POST['student_id'] != '' && isset($_POST['email']) && $_POST['email'] != ''){
						$pwd = (isset($_POST['user_pass']) && $_POST['user_pass'] != '')
							? $_POST['user_pass'] : md5(srand((int)microtime()*1000));
						$id = wp_create_user($_POST['student_id'], $pwd, $_POST['email']);
						if($id){
							$model->setUserId((int)$id);
						}
					}else{
						$this->setNotice3('Can not create user with empty Username and Email'); //message
					}
				}

				//save data model
				$model->save();

				if(!$model->getId()) {
					$this->helper('session')->setData('student_post', $_POST);
					$this->setNotice3('Error when save'); //message
				}else{
					$this->helper('session')->clear('student_post');
				}

			}catch(\Exception $e){
				throw new \Exception('Error when saving Student data '. $e->getMessage());
			}

			$this->_redirect('admin.php?page=soict-student-edit&id='.$model->getId()); //forward controller
		}else{
			$this->setBody('Not accept request method '. $_SERVER['REQUEST_METHOD']);
		}
	}

	//get the item
	public function getStudent(){
		if($this->_id){
			return \SoictApp::getModel('student')->load($this->_id);
		}
		return \SoictApp::getModel('student');
	}

}
