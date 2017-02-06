<?php

namespace Soict\Helper;

class Session {
	
	const SESSION_PREFIX = 'soict_session_';

	public function __construct(){
		if (!session_id())
			session_start();
	}

	//get and store to session
	public function register($name, &$var_name){
		if($name && isset($_SESSION)){
			//load from session
			if(isset($_SESSION[self::SESSION_PREFIX.$name]) && !$var_name){
				$var_name = $_SESSION[self::SESSION_PREFIX.$name];
			}else{
				$_SESSION[self::SESSION_PREFIX.$name] = $var_name;
			}
		}
		return $var_name;
	}

	//load data from session and return data loaded
	public function load($name, &$var){
		if($name && isset($_SESSION)){
			if(isset($_SESSION[self::SESSION_PREFIX.$name])){
				$var = $_SESSION[self::SESSION_PREFIX.$name];
			}
		}
		return $var;
	}

	//get session data
	public function getData($name){
		if($name && isset($_SESSION[self::SESSION_PREFIX.$name])){
			return $_SESSION[self::SESSION_PREFIX.$name];
		}
		return '';
	}

	//get and store to session
	public function setData($name, $reset_value){
		if($name && isset($_SESSION)){
			$_SESSION[self::SESSION_PREFIX.$name] = $reset_value;
		}
		return $reset_value;
	}

	public function clear($name){
		if(isset($_SESSION[self::SESSION_PREFIX.$name])){
			unset($_SESSION[self::SESSION_PREFIX.$name]);
			return true;
		}
		return false;
	}
}
