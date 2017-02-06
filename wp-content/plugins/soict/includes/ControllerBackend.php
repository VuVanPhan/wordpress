<?php

namespace Soict;

//use \Soict\ControllerAbstract;

require_once 'ControllerAbstract.php';

class ControllerBackend extends ControllerAbstract{

	private $_notice1 = '';
	private $_notice2 = '';
	private $_notice3 = '';

	public function __construct(){
		$this->setArea('backend');
		return parent::__construct();
	}

	public function setNotice1($message){
		$this->_notice1 = $message;
		if(isset($_SESSION)){
			$_SESSION['soict_admin_notice1'] = $this->_notice1;
		}
	}

	public function getNotice1($clear = true){
		if(isset($_SESSION['soict_admin_notice1'])){
			$this->_notice1 = $_SESSION['soict_admin_notice1'];
		}
		$message = $this->_notice1;

		if($clear){
			$_SESSION['soict_admin_notice1'] = '';
			$this->_notice1 = '';
		}

		return $message;
	}

	public function setNotice2($message){
		$this->_notice2 = $message;
		if(isset($_SESSION)){
			$_SESSION['soict_admin_notice2'] = $this->_notice2;
		}
	}

	public function getNotice2($clear = true){
		if(isset($_SESSION['soict_admin_notice2'])){
			$this->_notice2 = $_SESSION['soict_admin_notice2'];
		}
		$message = $this->_notice2;

		if($clear){
			$_SESSION['soict_admin_notice2'] = '';
			$this->_notice2 = '';
		}

		return $message;
	}

	public function setNotice3($message){
		$this->_notice3 = $message;
		if(isset($_SESSION)){
			$_SESSION['soict_admin_notice3'] = $this->_notice3;
		}
	}

	public function getNotice3($clear = true){
		if(isset($_SESSION['soict_admin_notice3'])){
			$this->_notice3 = $_SESSION['soict_admin_notice3'];
		}
		$message = $this->_notice3;

		if($clear){
			$_SESSION['soict_admin_notice3'] = '';
			$this->_notice3 = '';
		}

		return $message;
	}

	public function display(){
		echo $this->getDisplay();
	}

	//forward backend controller
	protected function _forward($controller){
		if(!is_object($controller)){
			$controller = \SoictApp::getController($controller, 'backend');
		}
		if($controller){
			$controller->execute();
		}else{
			throw new \Exception('Forward backend controller not found');
		}
	}


	protected function _redirect($url_path){
		header('Location: '.get_admin_url('', $url_path));
		exit;
	}
}
