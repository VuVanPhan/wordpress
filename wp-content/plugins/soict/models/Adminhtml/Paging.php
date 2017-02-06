<?php

namespace Soict\Model\Adminhtml;

use \Torm\Object as TormObject;

require_once SOICT_PLUGIN_MODEL_DIR.'Resource/Torm/Object.php';

class Paging extends TormObject {

	const DEFAULT_PAGE_SIZE = 20;
	const DEFAULT_ORDER = 'desc';

	private $_page = 1;
	private $_page_size = 10;
	private $_orderby = '';
	private $_order = 'desc';

	private $_prefix = 'grid_';

	protected $_collection;

	public function __construct(){
	}

	protected function _initPaging(){
		//load from param
		$this->_orderby = isset($_GET['orderby'])?$_GET['orderby']:'';
		$this->_order = isset($_GET['order'])?$_GET['order']:'';

		//load from session
		$this->sessionHelper()->register($this->_prefix.'orderby', $this->_orderby);
		$this->sessionHelper()->register($this->_prefix.'order', 	$this->_order);

		//load page num from session
		$this->sessionHelper()->load($this->_prefix.'p', 	$this->_page);
		$page = isset($_GET['p']) ? $_GET['p'] : $this->_page;
		$page_bot = isset($_GET['p2']) ? $_GET['p2']:$this->_page;
		if($page != $this->_page) $this->_page = $page;
		elseif($page_bot != $this->_page) $this->_page = $page_bot;
		$this->sessionHelper()->register($this->_prefix.'p', $this->_page);

		//load from session
		if(!$this->_page_size) $this->_page_size = self::DEFAULT_PAGE_SIZE;
		$this->sessionHelper()->load($this->_prefix.'size', 	$this->_page_size);
		$pageSize = $this->_page_size;
		if(isset($_GET['size-top']) && $_GET['size-top'] != $this->_page_size) $pageSize = $_GET['size-top'];
		if(isset($_GET['size-bot']) && $_GET['size-bot'] != $this->_page_size) $pageSize = $_GET['size-bot'];
		$this->_page_size = $pageSize;
		$this->sessionHelper()->register($this->_prefix.'size', 	$this->_page_size);
	}

	public function setCollection($collection){
		$this->_collection = $collection;
		return $this;
	}

	public function getCollection(){
		return $this->_collection;
	}

	public function getOrderBy(){
		return $this->_orderby;
	}

	public function getOrder(){
		return $this->_order;
	}

	public function getPageSize(){
		return $this->_page_size;
	}

	public function getCurPage(){
		return $this->_page;
	}

	public function setPrefix($prefix){
		$this->_prefix = $prefix;
		return $this;
	}

	public function getPrefix(){
		return $this->_prefix;
	}

	public function setGridPrefix($prefix){
		$this->_prefix = $prefix;
		return $this;
	}

	public function getGridPrefix(){
		return $this->_prefix;
	}

	public function reset(){
		$this->sessionHelper()->setData($this->_prefix.'p', 1);
		$this->sessionHelper()->setData($this->_prefix.'size', self::DEFAULT_PAGE_SIZE);
		$this->sessionHelper()->setData($this->_prefix.'orderby', '');
		$this->sessionHelper()->setData($this->_prefix.'order', self::DEFAULT_ORDER);
	}

	public function getPagingCollection($collection = ''){
		$this->_initPaging();

		if($collection){
			$this->setCollection($collection);
		}

		$collection = $this->getCollection();

		//order
		if($this->_orderby){
			if($this->_order){
				$collection->getSelect()->order($this->_orderby.' '.$this->_order);
			}else{
				$collection->getSelect()->order($this->_orderby.' DESC');
			}
		}

		//paging
		$collection->setPageSize($this->_page_size);
		if($this->_page){
			$collection->setCurPage($this->_page);
		}

		return $collection;
	}

	protected function sessionHelper(){
		return \SoictApp::helper('session');
	}
}
