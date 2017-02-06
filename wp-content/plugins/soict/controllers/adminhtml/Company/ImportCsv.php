<?php

namespace Soict\Controller\Adminhtml\Company;

use \Soict\ControllerBackend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerBackend.php';

class ImportCsv extends ControllerBackend {

	/**
	 * Import with columns user_name, user_pass, name, email, hr_email, hr_phone, address, birthday, seniority, description, field
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

					$company = \SoictApp::getModel('company');

					//get first row if match column
					if (in_array('user_name', $row) && in_array('name', $row) && in_array('email', $row)) {
						$startImport = true;
						$rowTitle = $row;

						foreach ($row as $key => $col) {
							$rowPare[$col] = $key;
						}

						continue;
					}

					if ($startImport) {
						foreach ($row as $key => $col) {
							$company->setData($rowTitle[$key], $col);
						}

						//create new user
						if ($company->getData('user_name') != '' && $company->getData('email') != '') {

							try {
								if ($company->getData('user_pass')) {
									$pwd = $company->getData('user_pass');
								} else {
									$pwd = md5(srand((int)microtime()*1000));
								}

								$id = wp_create_user($company->getData('user_name'), $pwd, $company->getData('email'));

								if ($id && is_numeric($id) && !is_object($id)) {
									$company->setUserId((int)$id);
									$company->save();
									$countImportSuccess++;
								} else {
									$countImportError++;

									if (is_object($id) && isset($id->errors ["existing_user_login"][0])) {
										$this->setNotice3($id->errors ["existing_user_login"][0]); //message
									}

								}

							} catch (\Exception $e) {

							}

						} else {
							$this->setNotice3('Can not create company with empty Username and Email'); //message
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

		$this->_redirect('admin.php?page=soict-company'); //forward controller
	}



}
