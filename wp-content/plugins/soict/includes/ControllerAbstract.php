<?php

namespace Soict;

class ControllerAbstract {

	protected $_template = '';
	protected $_area = 'frontend';
	protected $_title = '';
	protected $_body = '';

	protected $_helper;
	protected $_http_header;

	protected $_is_stop_controller = false;

	public function __construct(){
	}

	//get model helper for all controller
	public function helper($name){
		if(!$this->_helper){
			$this->_helper = \SoictApp::helper($name);
		}
		return $this->_helper;
	}

	public function setArea($area){
		$this->_area = $area;
	}

	public function getArea(){
		return $this->_area;
	}

	public function getTemplate(){
		return $this->_template;
	}

	public function init(){
		return $this->execute();
	}

	//run default of controller
	public function execute(){
		return $this;
	}

	public function setStop($flag = true) {
		$this->_is_stop_controller = $flag;
		return $this;
	}

	public function isStop() {
		return $this->_is_stop_controller;
	}

	/**
	 * @param $template_name file path to template
	 */
	public function setTemplate($template_name){
		$this->_template = $template_name;
	}

	public function setBody($content){
		$this->_body = $content;
	}

	public function getBody(){
		return $this->_body;
	}

	//add to before | after | or default replace
	public function getDisplay($content = '', $addTo = ''){

		if ($this->isStop()) {
			return '';
		}

		if($this->getBody()){
			return $this->getBody();
		}

		if(!$this->_template){
			throw new \Exception('Not set template to the controller '.__FILE__.':'.__LINE__);
		}
		try{
			ob_start();
			$view = \SoictApp::getView($this->_template, $this->_area );
			if($view) include $view;
		}catch(Exception $e){
			ob_get_clean();
			throw $e;
		}
		$html = ob_get_clean();

		if($content){
			if($addTo == 'before'){
				return $content . $html;
			}elseif($addTo == 'after'){
				return $html . $content;
			}else{
				return $content;
			}
		}

		return $html;
	}

	public function display(){
		echo $this->getDisplay();
	}

	public function setHeader($http_header){
		$this->_http_header = $http_header;
		return $this;
	}

	public function sendHeader($code = 200, $message = 'OK'){
		if($this->_http_header){
			header($this->_http_header);
		}else{
			header('HTTP/1.1 '.$code.' '.$message);
		}
	}

	public function setTitle($title){
		$this->_title = $title;
		return $this;
	}

	protected function _forward($controller){
		if(!is_object($controller)){
			$controller = \SoictApp::getController($controller, $this->getArea());
		}
		if($controller){
			$this->setStop(true);
			$controller->init();
		}else{
			throw new \Exception('Forward frontend controller not found');
		}
	}

	protected function _redirect($url_path){
		header('Location: '.get_site_url('', $url_path));
		exit;
	}

}
