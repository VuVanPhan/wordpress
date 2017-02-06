<?php

namespace Torm\DbObject;

use \Torm\Data;
use \Torm\DbObject\ResourceInterfacet;

require_once dirname(__FILE__) . '/../Data.php';
require_once 'ResourceInterface.php';

class ResourceCollection extends Data implements \IteratorAggregate, \Countable {

    const SORT_ORDER_ASC = 'ASC';
    const SORT_ORDER_DESC = 'DESC';

    private $_isLoaded = false;
    private $_resource;
    private $_items = [];
    private $_conn;
    private $_select;
    private $_totalRecords = null;


    /**
     * Current page number for items pager
     *
     * @var int
     */
    protected $_curPage = 1;
    /**
     * Pager page size
     *
     * if page size is false, then we works with all items
     *
     * @var int|false
     */
    protected $_pageSize = false;


    public function __construct(ResourceInterface $resource, $conn){
        $this->_resource = $resource;
        $this->_conn = $conn;
    }

    public function setResource($resource){
        $this->_resource = $resource;
    }

    public function getResource(){
        return $this->_resource;
    }

    public function setConnection($conn){
        $this->_conn = $conn;
    }

    public function getConnection(){
        return $this->_conn;
    }

    public function getSelect(){
        if($this->_select){
            return $this->_select;
        }
        if(is_object($this->_resource)){
            $tableName = $this->_resource->getTableName();
            $this->_select = $this->_resource->getConnection()->$tableName();
            return $this->_select;
        }
        throw new \Exception('No resource set for model resource collection');
    }

    //count by select sql
    public function getSelectCount(){
        return $this->getSelectCountSql()->count("*");
    }

    //return select sql of count
    public function getSelectCountSql(){
        $countSelect = clone $this->getSelect();
        $countSelect->select($this->_resource->getMainId());
        return $countSelect;
    }


    /**
     * Retrieve count of collection loaded items
     *
     * @return int
     */
    public function count()
    {
        $this->load();
        return count($this->_items);
    }

    /**
     * Get current collection page
     *
     * @param  int $displacement
     * @return int
     */
    public function setCurPage($curPage = 1)
    {
        $this->_curPage = (int)$curPage;
        return $this;
    }
    /**
     * Get current collection page
     *
     * @param  int $displacement
     * @return int
     */
    public function getCurPage($displacement = 0)
    {
        if ($this->_curPage + $displacement < 1) {
            return 1;
        } elseif ($this->_curPage + $displacement > $this->getLastPageNumber()) {
            return $this->getLastPageNumber();
        } else {
            return $this->_curPage + $displacement;
        }
    }
    /**
     * Set collection page size
     *
     * @param   int $size
     * @return $this
     */
    public function setPageSize($size)
    {
        $this->_pageSize = $size;
        return $this;
    }
    /**
     * Retrieve collection page size
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->_pageSize;
    }

    /**
     * Retrieve collection last page number
     *
     * @return int
     */
    public function getLastPageNumber()
    {
        $collectionSize = (int)$this->getSize();
        if (0 === $collectionSize) {
            return 1;
        } elseif ($this->_pageSize) {
            return ceil($collectionSize / $this->_pageSize);
        } else {
            return 1;
        }
    }

    //total page number
    public function getTotalPage(){
        return $this->getLastPageNumber();
    }


    /**
     * Retrieve collection all items count
     *
     * @return int
     */
    public function getSize()
    {
        $this->load();
        if ($this->_totalRecords === null) {
            $this->_totalRecords = $this->getSelectCount();
        }
        return intval($this->_totalRecords);
    }


    /**
     * Retrieve collection first item
     *
     * @return \DataObject
     */
    public function getFirstItem()
    {
        $this->load();
        if (count($this->_items)) {
            reset($this->_items);
            return current($this->_items);
        }
        return new \Torm\Data();
    }
    /**
     * Retrieve collection last item
     *
     * @return \DataObject
     */
    public function getLastItem()
    {
        $this->load();
        if (count($this->_items)) {
            return end($this->_items);
        }
        return null;
    }
    /**
     * Retrieve collection items
     *
     * @return \DataObject[]
     */
    public function getItems()
    {
        $this->load();
        return $this->_items;
    }

    /**
     * Adding item to item array
     *
     * @param  \Torm\Data $item
     * @return $this
     * @throws \Exception
     */
    public function addItem(\Torm\Data $item)
    {
        $itemId = $this->_getItemId($item);
        if ($itemId !== null) {
            if (isset($this->_items[$itemId])) {
                throw new \Exception(
                    'Item (' . get_class($item) . ') with the same ID "' . $item->getId() . '" already exists.'
                );
            }
            $this->_items[$itemId] = $item;
        } else {
            $this->_addItem($item);
        }
        return $this;
    }
    /**
     * Add item that has no id to collection
     *
     * @param \Torm\Data $item
     * @return $this
     */
    protected function _addItem($item)
    {
        $this->_items[] = $item;
        return $this;
    }
    /**
     * Retrieve item id
     *
     * @param \Torm\Data $item
     * @return mixed
     */
    protected function _getItemId(\Torm\Data $item)
    {
        return $item->getId();
    }
    /**
     * Retrieve ids of all items
     *
     * @return array
     */
    public function getAllIds()
    {
        $ids = [];
        foreach ($this->getItems() as $item) {
            $ids[] = $this->_getItemId($item);
        }
        return $ids;
    }
    /**
     * Remove item from collection by item key
     *
     * @param   mixed $key
     * @return $this
     */
    public function removeItemByKey($key)
    {
        if (isset($this->_items[$key])) {
            unset($this->_items[$key]);
        }
        return $this;
    }
    /**
     * Remove all items from collection
     *
     * @return $this
     */
    public function removeAllItems()
    {
        $this->_items = [];
        return $this;
    }
    /**
     * Clear collection
     *
     * @return $this
     */
    public function clear()
    {
        $this->_setIsLoaded(false);
        $this->_items = [];
        return $this;
    }


    /**
     * Walk through the collection and run model method or external callback
     * with optional arguments
     *
     * Returns array with results of callback for each item
     *
     * @param string $callback
     * @param array $args
     * @return array
     */
    public function walk($callback, array $args = [])
    {
        $results = [];
        $useItemCallback = is_string($callback) && strpos($callback, '::') === false;
        foreach ($this->getItems() as $id => $item) {
            if ($useItemCallback) {
                $cb = [$item, $callback];
            } else {
                $cb = $callback;
                array_unshift($args, $item);
            }
            $results[$id] = call_user_func_array($cb, $args);
        }
        return $results;
    }
    /**
     * @param string|array $objMethod
     * @param array $args
     * @return void
     */
    public function each($objMethod, $args = [])
    {
        foreach ($args->_items as $k => $item) {
            $args->_items[$k] = call_user_func($objMethod, $item);
        }
    }

    /**
     * Implementation of \IteratorAggregate::getIterator()
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $this->load();
        return new \ArrayIterator($this->_items);
    }

    //load collection
    public function load(){
        if($this->getSelect()){
            if(!$this->_isLoaded){
                $this->removeAllItems();
                $this->_setIsLoaded(true);

                //add limit paging
                if($this->getPageSize()){
                    $this->getSelect()->limit($this->getPageSize(),
                        ($this->getCurPage() * $this->getPageSize() - $this->getPageSize()));
                }

                foreach($this->getSelect() as $id => $row){
                    $item = clone $this->_resource->getObject();
                    $item->setData($row->jsonSerialize());
                    $this->addItem($item);
                }

            }
        }
        return $this;
    }
    /**
     * Retrieve collection loading status
     *
     * @return bool
     */
    public function isLoaded()
    {
        return $this->_isLoaded;
    }

    public function setLoaded($flag){
        $this->_loaded = $flag;
    }

    public function __toString(){
        return (string) $this->getSelect()->__toString();
    }

    /**
     * Set collection loading status flag
     *
     * @param bool $flag
     * @return $this
     */
    protected function _setIsLoaded($flag = true)
    {
        $this->_isLoaded = $flag;
        return $this;
    }
}
