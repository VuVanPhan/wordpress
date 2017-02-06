<?php

namespace Soict\Controller\Student\Report;

use \Soict\ControllerFrontend;

require_once SOICT_PLUGIN_DIR.'includes/ControllerFrontend.php';

class Downloadfile extends ControllerFrontend {


	public function execute(){

		if (isset($_GET['internship']) && $_GET['internship'] != ''
			&& isset($_GET['company']) && $_GET['company'] != '') {

			$student = \SoictApp::helper('user')->getCurrentUser(); //company user

			//protect student under company download file
			$groups = \SoictApp::getModel('internship/group')->getCollection();
			$groups->getSelect()->where('student_id', $student->getId())
				->and('internship_program_id', $_GET['internship'])
				->and('company_id', $_GET['company']);

			if ($groups->getSize() <= 0) {
				header($_SERVER["SERVER_PROTOCOL"] . " 401 Access denied.");
				echo "401 Access denied.";
				exit;
			}

			$internStudent = \SoictApp::getModel('internship/student')->getCollection();
			$internStudent->getSelect()
				->where('student_id', $student->getId())
				->and('internship_program_id', $_GET['internship'])
				->limit(1);

			$internStudent = $internStudent->getFirstItem();

			if (isset($_GET['type']) && $_GET['type'] == 'lecturer') {
				$file = ABSPATH . trim($internStudent->getLecturerReviewFile(), DS);
			} elseif (isset($_GET['type']) && $_GET['type'] == 'company') {
				$file = ABSPATH . trim($internStudent->getCompanyReviewFile(), DS);
			} else {
				$file = ABSPATH . trim($internStudent->getReportFile(), DS);
			}

			if (file_exists($file) && is_file($file)) {
				header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;
			}

		}

		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not found.");
		exit;
	}


}
