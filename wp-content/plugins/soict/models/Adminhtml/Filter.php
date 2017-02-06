<?php

namespace Soict\Model\Adminhtml;

use \Torm\Object as TormObject;

require_once 'Resource/Torm/Object.php';

class Filter extends TormObject {

	private $_page = 1;
	private $_page_size = 10;
	private $_orderby = '';
	private $_order = 'desc';
	private $_search = '';

	protected $_collection;

	public function __construct(){
		//load from param
		$this->_page = isset($_GET['p'])?$_GET['p']:$this->_page;
		$this->_orderby = isset($_GET['orderby'])?$_GET['orderby']:'';
		$this->_order = isset($_GET['order'])?$_GET['order']:'';
		$this->_action = isset($_GET['action'])  ? $_GET['action']:'';
		$this->_action2 = isset($_GET['action2']) ? $_GET['action2']:'';
		$this->_search = isset($_GET['search'])?$_GET['search']:'';

		//load from session
		$this->_sessionRegister('p', 		$this->_page);
		$this->_sessionRegister('orderby', 	$this->_orderby);
		$this->_sessionRegister('order', 	$this->_order);
		$this->_sessionRegister('search', 	$this->_search);

		//load from session
		$this->_sessionLoad('size', 	$this->_page_size);
		$pageSize = $this->_page_size;
		if(isset($_GET['size-top']) && $_GET['size-top'] != $this->_page_size) $pageSize = $_GET['size-top'];
		if(isset($_GET['size-bot']) && $_GET['size-bot'] != $this->_page_size) $pageSize = $_GET['size-bot'];
		$this->_page_size = $pageSize;
		$this->_sessionRegister('size', 	$this->_page_size);

		if(isset($_GET['search']) && $_GET['search'] != ''){
			$this->_search = $this->_setSessionData('search', $_GET['s']);
		}

		if(isset($_GET['reset']) && $_GET['reset'] != ''){
			$this->_page = $this->_setSessionData('p', 1);
			$this->_page_size = $this->_setSessionData('size', 10);
			$this->_orderby = $this->_setSessionData('orderby', '');
			$this->_order = $this->_setSessionData('order', '');
			$this->_search = $this->_setSessionData('search', '');
		}
	}

	public function setCollection($collection){
		$this->_collection = $collection;
		return $this;
	}

	//get and store to session
	protected function _sessionRegister($name, &$var_name){
		if($name && isset($_SESSION)){
			//load from session
			if(isset($_SESSION['student_list_'.$name]) && !$var_name){
				$var_name = $_SESSION['student_list_'.$name];
			}else{
				$_SESSION['student_list_'.$name] = $var_name;
			}
		}
		return $var_name;
	}

	//load data from session and return data loaded
	protected function _sessionLoad($name, &$var){
		if($name && isset($_SESSION)){
			if(isset($_SESSION['student_list_'.$name])){
				$var = $_SESSION['student_list_'.$name];
			}
		}
		return $var;
	}

	//get and store to session
	protected function _sessionData($name, $value = ''){
		if($name && isset($_SESSION)){
			//load from session
			if(isset($_SESSION['student_list_'.$name]) && !$value){
				return $_SESSION['student_list_'.$name];
			}else{
				$_SESSION['student_list_'.$name] = $value;
				return $value;
			}
		}
		return $value;
	}

	//get and store to session
	protected function _setSessionData($name, $reset_value){
		if($name && isset($_SESSION['student_list_'.$name])){
			$_SESSION['student_list_'.$name] = $reset_value;
		}
		return $reset_value;
	}

	//get and store to session
	protected function _getSessionData($name){
		if($name && isset($_SESSION['student_list_'.$name])){
			return $_SESSION['student_list_'.$name];
		}
		return '';
	}
}
