<?php

class Soict_Backend {

    private $_slug = 'soict';

    private static $initiated = false;

    public function __construct(){

    }

    public function init(){
        if ( ! self::$initiated ) {
            $this->init_hooks();
        }
    }


    /**
     * Initializes WordPress hooks
     */
    private function init_hooks() {
        self::$initiated = true;
        if (!session_id())
            session_start();
        //global $current_user;
        //$user_roles = $current_user->roles;

        //protect backend user
        $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
        if (
            !current_user_can( 'administrator' )
            && !current_user_can( 'editor' )
            && !current_user_can( 'author' )
            && is_user_logged_in()
        ){
            exit( wp_redirect( $redirect ) );
        }

        //init backend menu
        //self::menus();
        add_action( 'admin_menu', array($this, 'add_menus') );


    }


    public function add_menus(){
        global $submenu;
        //add menu with string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function, string $icon_url, int $position
        add_menu_page( 'SOICT', 'SOICT', 'manage_options', $this->_slug, array($this, 'dispatch_menus'),
            \SoictApp::getImageUrl('soict-menu-icon.png', 'backend'), 2 );

        add_submenu_page( $this->_slug, __('Internship'), __('Internship'), 'manage_options', $this->_slug.'-internship', array($this, 'dispatch_menus'));
        add_submenu_page( $this->_slug, __('Student'), __('Student'), 'manage_options', $this->_slug.'-student', array($this, 'dispatch_menus'));
        add_submenu_page( $this->_slug, __('Company'), __('Company'), 'manage_options', $this->_slug.'-company', array($this, 'dispatch_menus'));
        add_submenu_page( $this->_slug, __('Lecturer'), __('Lecturer'), 'manage_options', $this->_slug.'-lecturer', array($this, 'dispatch_menus'));
        add_submenu_page( $this->_slug, __('Soict Settings'), __('Settings'), 'administrator', $this->_slug.'-setting', array($this, 'dispatch_menus'));

        $submenu['soict'][0][0] = 'Dashboard';

        //add submenu level 3 auto dispatch controller
        $_page = isset($_GET['page'])?$_GET['page']:'/';
        $sub_slug = str_replace($this->_slug, '', $_page);
        if($sub_slug){
            $sub_slug1 = explode('-', $sub_slug);
            $sub_slug1 = $sub_slug1[0];
            $sub_slug2 = str_replace($sub_slug1, '', $sub_slug);
            add_submenu_page(  $this->_slug.'-'.$sub_slug1, '', '', 'manage_options', $this->_slug.$sub_slug1.$sub_slug2, array($this, 'dispatch_menus'));
        }

    }

    public function dispatch_menus(){
        $_page = isset($_GET['page'])?$_GET['page']:'/';
        $sub_slug = str_replace($this->_slug, '', $_page);
        if($sub_slug == '') $sub_slug = 'dashboard'; //default sub slug
        //trim slug and convert to controller name
        $controllerName = str_replace('-', '/', trim($sub_slug, '-'));
        $controller = \SoictApp::getController($controllerName, 'backend');
        if($controller){
            $controller->init();
            $controller->display();
        }
    }
}
