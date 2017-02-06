<?php

namespace Soict\Controller\Adminhtml\Company;

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

				if(isset($_FILES['logo']) && isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ''){
					//upload file
					if ( ! function_exists( 'wp_handle_upload' ) ) {
						require_once( ABSPATH . 'wp-admin/includes/media.php' );
					}
					//$uploadedfile = $_FILES['logo'];
					//$upload_overrides = array( 'test_form' => false );
					//$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
					$attachment_id = media_handle_upload( 'logo', null, array() );

					if ( is_wp_error( $attachment_id ) ) {
						$this->setNotice3('Upload file error '.$attachment_id->get_error_message()); //message
					} else {
						//success
						/*
						$attachment = array('url', 'sizes'=>[
							'full'=>['width', 'height', 'orientation'=>'landscape', 'url'],
							'large', 'medium', 'thumbnail']
						);
						*/
						if ( ($attachment = wp_prepare_attachment_for_js( $attachment_id )) ){
							if(isset($attachment['url'])){
								$urlPath = \SoictApp::getUrlPath($attachment['url']);
								$model->setLogo($urlPath);
							}
						}else{
							$this->setNotice3('Upload file error'); //message
						}
					}
				}

				if($model->getUser()){
					//update user
					if(isset($_POST['email']) && $_POST['email'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_email' => $_POST['email'] ));
					}
					if(isset($_POST['user_pass']) && $_POST['user_pass'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_pass' => $_POST['user_pass'] ));
					}

				}else{
					//create new user
					if(isset($_POST['user_name']) && $_POST['user_name'] != '' && isset($_POST['email']) && $_POST['email'] != ''){
						$pwd = (isset($_POST['user_pass']) && $_POST['user_pass'] != '')
							? $_POST['user_pass'] : md5(srand((int)microtime()*1000));
						$id = wp_create_user($_POST['user_name'], $pwd, $_POST['email']);
						if($id){
							$model->setUserId((int)$id);
						}
					}else{
						$this->setNotice3('Can not create user with empty Username and Email'); //message
					}
				}

				$model->save(); //save model

				if(!$model->getId()) {
					$this->helper('session')->setData('company_post', $_POST);
					$this->setNotice3('Error when save'); //message
				}else{
					$this->helper('session')->clear('company_post');
				}

			}catch(\Exception $e){
				throw new \Exception('Error when saving Company data '. $e->getMessage());
			}

			$this->_redirect('admin.php?page=soict-company-edit&id='.$model->getId()); //forward controller
		}else{
			$this->setBody('Not accept request method '. $_SERVER['REQUEST_METHOD']);
		}
	}

	//get the item
	public function getModel(){
		if($this->_id){
			return \SoictApp::getModel('company')->load($this->_id);
		}
		return \SoictApp::getModel('company');
	}

}
