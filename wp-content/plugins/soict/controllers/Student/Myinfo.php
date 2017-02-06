<?php

namespace Soict\Controller\Student;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Myinfo extends ControllerFrontend {

	public function execute(){
		$this->setTemplate('student/myinfo.php');
		$this->setTitle('Thông tin cá nhân');

		if (isset($_POST['action']) && $_POST['action'] == 'save') {
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				try{
					//saving model

					$model = $this->getStudent();

					if (isset($_POST['student_id'])) unset($_POST['student_id']);

					$model->addData($_POST);

					//update user
					if(isset($_POST['email']) && $_POST['email'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_email' => $_POST['email'] ));
					}
					if(isset($_POST['user_pass']) && $_POST['user_pass'] != ''){
						wp_update_user(array( 'ID'=>$model->getUserId(), 'user_pass' => $_POST['user_pass'] ));
					}

					/*if(isset($_POST['student_id']) && $_POST['student_id'] != ''){
						$model->changeUserLogin($_POST['student_id']);
					}*/

					// upload file
					// save avatar upload
					if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['tmp_name'] != ''){

						if ( filesize($_FILES['avatar']['tmp_name']) > 104857600) {

							$this->setNotice2(__('File size limit is 100MB.'));

						} else {

							if ( ! function_exists( 'wp_handle_upload' ) ) {
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
							}

							$time = current_time('mysql');
							$file = wp_handle_upload($_FILES['avatar'], array( 'test_form' => false ), $time);

							//resize image
							$image = wp_get_image_editor( $file['file'] );
							if ( ! is_wp_error( $image ) ) {
								//$image->rotate( 90 );
								$image->resize( 400, 400, false ); //not crop
								$image->save( $file['file'] );
							}

							if (isset($file['error'])) {
								$this->setNotice2(__('Save file not successfully.'));
							} else {
								$model->setAvatar(\SoictApp::getDirPath($file['file']));
							}

						}
					}


					//save data model
					$model->save();

					if(!$model->getId()) {
						throw new \Exception(__('Error when save'));
					}

				}catch(\Exception $e){
					$this->setNotice2( __('Error when saving Student data ') . $e->getMessage());
				}

				//$this->_redirect(''); //forward controller
			}

		} else {


		}


	}

	public function getStudent(){
		return \SoictApp::helper('user')->getCurrentUser();
	}

	protected function _isAllowed(){
		if ( ! \SoictApp::helper('user')->getCurrentUser()->getId() ) {
			return false;
		}
		return true;
	}
}
