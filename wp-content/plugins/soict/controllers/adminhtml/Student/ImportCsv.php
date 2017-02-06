<?php

namespace Soict\Controller\Adminhtml\Student;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class ImportCsv extends ControllerBackend {

	/**
	 * Import with columns student_id, user_pass, name, email, birthday, gender, telephone, address
	 */
	public function execute(){

		if (isset($_FILES['fileCsv']['name']) && $_FILES['fileCsv']['tmp_name'] != '') {
			$target = DS. 'tmp'. DS .'soict_upload_tmp';

			if (!file_exists($target)) {
				mkdir($target);
			}

			$file = $target. DS. $_FILES['fileCsv']['name'];

			move_uploaded_file( $_FILES['fileCsv']['tmp_name'], $file );

			$csv = \SoictApp::getModel('filesystem/csv');

			$data = $csv->getData($file);

			$countImportSuccess = 0;
			$countImportError = 0;

			if (count($data)) {

				$rowTitle = [];
				$rowPare = [];
				$startImport = false;

				foreach ($data as $row) {

					$student = \SoictApp::getModel('student');

					//get first row if match column
					if (in_array('student_id', $row) && in_array('name', $row) && in_array('email', $row)) {
						$startImport = true;
						$rowTitle = $row;

						foreach ($row as $key => $col) {
							$rowPare[$col] = $key;
						}

						continue;
					}

					if ($startImport) {
						foreach ($row as $key => $col) {
							$student->setData($rowTitle[$key], $col);
						}

						//create new user
						if ($student->getData('student_id') != '' && $student->getData('email') != '') {

							try {
								if ($student->getData('user_pass')) {
									$pwd = $student->getData('user_pass');
								} else {
									$pwd = md5(srand((int)microtime()*1000));
								}
								$id = wp_create_user($student->getData('student_id'), $pwd, $student->getData('email'));

								if ($id && is_numeric($id) && !is_object($id)) {
									$student->setUserId((int)$id);
									$student->save();
									$countImportSuccess++;
								} else {
									$countImportError++;
								}
							} catch(\Exception $e) {

							}

						} else {
							$this->setNotice3('Can not create user with empty Username and Email'); //message
						}

					}
				}

			}

			//$message = '';

			$message = $countImportSuccess . ' import successfully. ';

			if ($countImportError) {
				$message = $countImportError . ' import error.';
			}

			$this->setNotice3(__($message)); //message

		} else {
			$this->setNotice3(__('Upload failed.')); //message
		}

		$this->_redirect('admin.php?page=soict-student'); //forward controller
	}



}
