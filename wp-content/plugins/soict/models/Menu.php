<?php

namespace Soict\Model;

require_once 'Resource/Torm/Object.php';

class Menu extends \Torm\Object {

	const USER_TYPE_STUDENT = 'student';
	const USER_TYPE_COMPANY = 'company';
	const USER_TYPE_LECTURER = 'lecturer';

	protected $_user_type;

	public function __construct(){
		parent::__construct();
	}

	public function getMenuOptions(){
		return array(
			self::USER_TYPE_STUDENT => array(
				'id' => '',
				'title' => __('Cá nhân', 'Soict'),
				'url' => trim(home_url(), '/').'/student/',
				'submenu' => array(
					array(
						'title' => __('Thông tin cá nhân'),
						'url'	=> trim(home_url(), '/').'/student/myinfo',
					),
					array(
						'title' => __('Đăng ký công ty thực tập'),
						'url'	=> trim(home_url(), '/').'/student/internships',
					),
					array(
						'title' => __('Thông tin thực tập'),
						'url'	=> trim(home_url(), '/').'/student/myinternships',
					),
					/*array(
						'title' => __('Kết quả thực tập'),
						'url'	=> trim(home_url(), '/').'/student/internshipresult',
					),*/
				)
			),
			self::USER_TYPE_COMPANY => array(
				'id' => '',
				'title' => __('Doanh nghiệp', 'Soict'),
				'url' => trim(home_url(), '/').'/company/',
				'submenu' => array(
					array(
						'title' => __('Các chương trình thực tập', 'Soict'),
						'url' => trim(home_url(), '/').'/company/my-internships'
					),
					array(
						'title' => __('Thông tin thực tập', 'Soict'),
						'url' => trim(home_url(), '/').'/company/internships'
					),
				)
			),
			self::USER_TYPE_LECTURER => array(
				'id' => '',
				'title' => __('Giảng viên', 'Soict'),
				'url' => trim(home_url(), '/').'/lecturer/',
				'submenu' => array()
			),
		);
	}

	public function initFrontendMenu($items, $menu, $args){

		switch($this->getUserType()){
			case self::USER_TYPE_STUDENT:
				$items = $this->addMenu($items);
				break;

			case self::USER_TYPE_COMPANY:
				$items = $this->addMenu($items);
				break;

			case self::USER_TYPE_LECTURER:
				$items = $this->addMenu($items);
				break;

			default:
				return $items;
				break;
		}

		return $items;
	}


	//detect user type of soict
	public function getUserType($id = ''){
		return \SoictApp::helper('user')->getUserType($id);
	}

	public function addMenu($items){
		$mnOptions = $this->getMenuOptions();
		if(isset($mnOptions[$this->getUserType()])){
			$items = $this->_addMenuOption($items, $mnOptions[$this->getUserType()]);
		}
		return $items;
	}

	protected function _addMenuOption($items, $options, $parent = '0'){
		if(isset($options['url'])){
			$options = array($options);
		}
		foreach ($options as $mnItem) {
			if(!isset($mnItem['url'])) return $items;
			if(!isset($mnItem['id']) || $mnItem['id'] == '') $mnItem['id'] = count($items);
			$order = count($items) + 1;
			$item = $this->addMenuItem($mnItem['id'], $mnItem['url'], $mnItem['title'], $order, $parent);
			array_push($items, $item);
			if(isset($mnItem['submenu']) && is_array($mnItem['submenu']) && !empty($mnItem['submenu'])){
				$items = $this->_addMenuOption($items, $mnItem['submenu'], $mnItem['id']);
			}
		}
		return $items;
	}

	public function addMenuItem($id, $url, $title, $order = '0', $parent = '0'){
		$data = array(
			'post_author' => 1,
			'url' => $url,
			'title' => $title,
			'menu_order' => $order,
			'db_id' => $id,
			'menu_item_parent' => $parent,
			'type_label' => 'custom',
			'classes' => array('soict-menu-item'),
			'type' => 'custom',
			'filter' => 'raw',

			'post_title' => '',
			'post_content' => '',
			'object' => 'custom',
			'post_type' => 'nav_menu_item',
			'post_name' => 'custom-menu',
			'post_status' => 'publish',
			'fusion_menu_style' => '',
			'fusion_megamenu_icon' => '',
			'fusion_megamenu_status' => '',
			'fusion_megamenu_width' => '',
			'fusion_megamenu_columns' => 'auto',
			'fusion_megamenu_columnwidth' => ''
		);

		$post = new \WP_Post((object)$data);

		return $post;
	}

}
