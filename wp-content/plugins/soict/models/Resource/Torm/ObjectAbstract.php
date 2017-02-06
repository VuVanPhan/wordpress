<?php
/**
 * Torm is Tit ORM library
 * License belong to Tit - Robert
 * Designed by Robert
 */
namespace Torm;

use \Torm\Data;
use \Torm\ObjectInterface;
use \Torm\DbObject\Resource;
use \Torm\DbObject\ResourceInerface;

require_once 'Data.php';
require_once 'ObjectInterface.php';
require_once 'DbObject/Resource.php';
require_once 'DbObject/ResourceInterface.php';
require_once 'DbObject/ResourceCollection.php';

class ObjectAbstract extends Data implements ObjectInterface {

	private $_main_id = 'id';
	private $_resource;

	public function __construct($data = [], ResourceInerface $resource = null, $table = '', $_main_id = ''){
		if(!$resource){
			$this->_resource = new Resource($this);
		}else{
			$this->_resource = $resource;
		}
		//init table
		$init = $this->_init();
		if($table) $init[0] = $table;
		if($_main_id) $init[1] = $_main_id;
		$this->init($init[0], $init[1]);
	}

	public function init($_table, $_main_id){
		if(is_object($this->_resource)){
			$this->_resource->setTableName($_table);
			$this->_resource->setMainId($_main_id);
			$this->_setMainId($_main_id);
		}
		return $this;
	}

	//Initial database resource connection
	protected function _init(){
		return array('', 'id');
	}

	protected function _setMainId($key){
		$this->_main_id = $key;
		return $this;
	}

	public function getMainId(){
		return $this->_main_id;
	}

	public function getId(){
		if(parent::getId()){
			return parent::getId();
		}
		return $this->getData($this->getMainId());
	}

	//load object data to model by id
	public function load($id, $field_name = ''){
		if(!is_string($id) && !is_int($id)){
			return $this; //not accept $id is not string or not int
		}
		$this->_beforeLoad();
		if($this->_resource){
			if($field_name){
				$this->_resource->loadBy($field_name, $id);
			}else{
				$this->setData($this->getMainId(), $id);
				$this->_resource->loadObject();
			}
		}
		$this->_afterLoad();
		return $this;
	}

	//get objects of an model
	//return object array interator
	public function getCollection(){
		if($this->_resource->getCollection()){
			return $this->_resource->getCollection();
		}
		return false;
	}

	//save to database of this object
	//return bool
	public function save(){
		if($this->_resource){
			$this->_resource->setObject($this);
			return $this->_resource->save();
		}
		return false;
	}

	//delete to database of this object
	//return id primary key of object if success or false
	public function delete(){
		if($this->_resource){
			return $this->_resource->deleteObject($this);
		}
		return false;
	}

	//update $data array to internal data
	public function update($data = array()){
		return $this->addData($data);
	}

	public function getResource(){
		return $this->_resource;
	}


	public function __destruct(){
		$this->unsetData();
	}


	protected function _beforeLoad(){
		return $this;
	}

	protected function _afterLoad(){
		return $this;
	}
}
