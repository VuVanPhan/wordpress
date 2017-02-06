<?php

namespace Torm\DbObject;

use \Torm\Connection;
use \Torm\Data;
use \Torm\DbObject\ResourceInterface;
use \Torm\DbObject\ResourceCollection;

require_once dirname(__FILE__). '/../Connection.php';
require_once dirname(__FILE__) . '/../Data.php';
require_once 'ResourceInterface.php';

class Resource extends Data implements ResourceInterface {

    private $_conn;
    private $_connObject;
    private $_collection;
    private $_object;
    private $_main_id = 'id';
    private $_table_name = '';

    //$table can table resource object or table name string
    /**
     * Resource constructor.
     * @param object $object
     * @param $table string | object
     * @param string $main_id
     * @param string $collection
     */
    public function __construct($object, $table = '', $main_id = '', $resourceCollection = ''){
        if(is_object($object)){
            $this->setObject($object);
        }

        if($table){
            $this->_table_name = $table;
        }

        if($object){
            $this->_object = $object;
        }

        if($main_id){
            $this->_main_id = $main_id;
        }

        $this->_connObject = new Connection(); //create new connect object
        $this->_updateConnection(); //and set connection resource to this

        if(is_object($resourceCollection)){
            $this->_collection = $resourceCollection;
        }

        if(!is_object($this->_collection)){
            $this->_collection = new ResourceCollection($this, $this->_conn);
        }
    }

    protected function _updateConnection(){
        if(!$this->_connObject){
            $this->_connObject = new Connection();
        }
        $this->setConnection($this->_connObject->getConnection($this->_main_id));
        return $this;
    }

    public function setTableName($table_name){
        $this->_table_name = $table_name;
        return $this;
    }

    public function getTableName($objectName = ''){
        global $wpdb;
        if($objectName){
            if(\SoictApp::getModel($objectName))
                return $wpdb->prefix . \SoictApp::getModel($objectName)->getTableName();
        }
        return $wpdb->prefix . $this->_table_name;
    }

    public function setMainId($main_id){
        $this->_main_id = $main_id;
        $this->_updateConnection(); //update primary to get connection by main_id
        return $this;
    }

    public function getMainId(){
        return $this->_main_id;
    }

    public function setObject($object){
        $this->_object = $object;
        return $this;
    }

    public function getObject(){
        return $this->_object;
    }

    public function loadObject($object = ''){
        if($object){
            $this->_object = $object;
        }
        if(is_object($this->_object)){
            if(is_object($this->_conn)){
                $tableName = $this->getTableName();
                $rows = $this->_conn->$tableName()
                    ->select("*")
                    ->where($this->_main_id ." = '".$this->_object->getData($this->_main_id)."'")
                    ->limit(1);

                foreach($rows as $id => $columnsData){
                    $this->_object->setData($columnsData->jsonSerialize());
                    break;
                }
            }
        }
        return $this;
    }

    public function loadBy($key, $value){
        if(is_object($this->_object)){
            if(is_object($this->_conn)){
                $tableName = $this->getTableName();
                $rows = $this->_conn->$tableName()
                    ->select("*")
                    ->where($key." = ?", $value)
                    ->limit(1);
                foreach($rows as $id => $columnsData){
                    $this->_object->setData($columnsData->jsonSerialize());
                    break;
                }
            }
        }
    }

    //save model to database
    public function save(){
        if(is_object($this->_object)){
            if(is_object($this->_conn)){
                $tableName = $this->getTableName();
                $mainId = $this->getMainId();
                //$this->_conn->__set('debug', true);
                $table = clone $this->_conn->$tableName();
                $table->select($this->_main_id)
                    ->where( $mainId, $this->_object->getData($mainId))
                    ->limit(1);

                $resRow = '';
                if(count($table)){
                    $table = $this->_conn->$tableName();
                    $table->select("")
                        ->where($mainId, $this->_object->getData($mainId))
                        ->limit(1);

                    foreach($table as $id => $row){
                        $data = $this->_getDataFilteredByColumns();
                        $row->update($data);
                        $resRow = $row;
                        break;
                    }

                }else{
                    $table = $this->_conn->$tableName();
                    $resRow = $table->insert($this->_getDataFilteredByColumns());
                }

                if($resRow){
                    $this->_object->setData($resRow->jsonSerialize());
                }else{
                    $this->_object->setData(array());
                }

                return true;
            }
        }
        return false;
    }

    //return last id when delete success
    public function deleteObject($object = ''){
        if(!is_object($object)){
            $object = $this->_object;
        }
        if(is_object($object)){
            if(is_object($this->_conn) && is_object($object->getResource())){
                $tableName = $this->getTableName();
                $mainId = $object->getResource()->getMainId();
                $rows = $this->_conn->$tableName()
                    ->select('')
                    ->where( $mainId ." = ?", $object->getData($mainId))
                    ->limit(1);
                $id = $object->getData($mainId);
                if(count($rows) && isset($rows[$id])){
                    if($rows[$id]->delete())
                        return $id;
                }
            }
        }
        return false;
    }

    public function setConnection($conn){
        $this->_conn = $conn;
        return $this;
    }

    public function getConnection(){
        return $this->_conn;
    }

    public function getCollection(){
        return $this->_collection;
    }

    //data in object is filtered by columns in database and ignore not match column
    protected function _getDataFilteredByColumns(){
        $objectTableName = $this->getTableName();
        $connClone = clone $this->_conn;
        $tableName = 'INFORMATION_SCHEMA.COLUMNS';
        $table = $connClone->$tableName(); //get current table
        $conn = new \Torm\Connection();
        $dbName = $conn->getDbName();
        $table->select('COLUMN_NAME')->where('table_name = \''.$objectTableName.'\' AND table_schema = \''.$dbName.'\'');
        $data = array();
        foreach($table as $row){
            if(($value = $this->_object->getData($row['COLUMN_NAME']))){
                $data[$row['COLUMN_NAME']] = $value;
            }
        }
        return $data;
    }
}
