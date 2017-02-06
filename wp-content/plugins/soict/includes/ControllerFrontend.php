<?php

namespace Soict;

//use \Soict\ControllerAbstract;

require_once 'ControllerAbstract.php';

class ControllerFrontend extends ControllerAbstract{

	private $_notice1 = '';
	private $_notice2 = '';
	private $_notice3 = '';

	public function __construct(){
		$this->setArea('frontend');
		add_filter( 'template_include', array($this, 'changeTemplate'), 1);
		add_filter( 'pre_get_document_title', array($this, 'getFilterTitle'), 1000);
		add_filter( 'the_content', array($this, 'getDisplayContent'), 1000);
		return parent::__construct();
	}

	//filter action
	public function getDisplayContent($content){
		return $this->getDisplay($content);
	}

	//filter action
	public function getFilterTitle($title){
		$this->sendHeader();
		if($this->_title){
			return $this->_title;
		}
		$this->_title = $title;
		return $this->_title;
	}

	public function init(){
		$this->_permission();
		return parent::init();
	}

	public function display(){
		parent::display();
	}

	protected function _isAllowed(){
		return true;
	}

	protected function _permission(){
		if(!$this->_isAllowed()){
			header('Location: '. get_home_url() .'/404.html?m=access denied');
			exit;
		}
	}

	protected function _getRole($role_key = ''){
		\SoictApp::helper('role')->getValue($role_key);
	}

	//change template page for frontend layout
	public function changeTemplate(){
		return SOICT_PLUGIN_VIEW_DIR . 'frontend'.DS.'templates'.DS.'page'.DS.'default.php';
	}

	//set notice message error
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
}
