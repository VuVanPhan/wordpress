<?php

require_once SOICT_PLUGIN_MODEL_DIR.'Resource/Torm/Object.php';

class Soict_Frontend {

    private static $initiated = false;

    public function __construct(){

    }

    public function init(){
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }



    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        if (!session_id())
            session_start();

        //dispatch frontend controller request
        \SoictApp::dispatch();

        //check role user access admin
        if (
            !current_user_can( 'administrator' )
            && !current_user_can( 'editor' )
            && !current_user_can( 'author' )
        ){
            show_admin_bar( false );
        }


        //add display the header sidebar to header page
        add_action('avada_before_header_wrapper', array('Soict_Frontend', 'header_sidebar') );

        //add filter to the widget login to change lost pass url
        add_filter( 'bbp_login_widget_lostpass', array('Soict_Frontend', 'add_filter_bbp_login_widget_lostpass'));
        //add filter to the widget logout after
        add_filter( 'logout_redirect', array( \SoictApp::helper('user')->getCurrentUser(), 'logoutAfter'), 1000);

        //filter the widget login
        add_filter( 'gettext', array('Soict_Frontend', 'translate_label_lostpass'), 10, 3);

        //add memu item to nav main menu
        add_filter('wp_get_nav_menu_items', array('Soict_Frontend', 'repare_nav_menu'), 10, 10);

        //repare get user avatar
        add_filter('get_wp_user_avatar', array('Soict_Frontend', 'repareUserAvatar'), 1000, 10);
    }

    public static function header_sidebar(){
        include SoictApp::getView('header/sidebar.php');
    }

    public static function add_filter_bbp_login_widget_lostpass($lostpass){
        $url = wp_lostpassword_url( get_permalink() );
        return $url;
    }

    public static function translate_label_lostpass($text, $oldtext, $domain){
        if($domain == 'bbpress' && $oldtext == 'Lost Password'){
            return 'Forgot Your Password?';
        }
        return $text;
    }

    //prepare frontend menu with user type
    public static function repare_nav_menu($items, $menu, $args){
        return \SoictApp::getModel('menu')->initFrontendMenu($items, $menu, $args);
    }

    //user avatar
    public static function repareUserAvatar($avatar, $id_or_email, $size, $align, $alt){
        //apply_filters('wpua_get_attachment_image_src', $image_src_array, $attachment_id, $size, $icon);
        //apply_filters('get_wp_user_avatar', $avatar, $id_or_email, $size, $align, $alt);
        $user = \SoictApp::helper('user')->getCurrentUser();
        if ($user->getUserPhotoSrc()) {
            $preAvatar = preg_replace('/src=(.*?)\s+/', 'src="PREPARE_TO_REPLACE_SRC"', $avatar);
            return str_replace('PREPARE_TO_REPLACE_SRC', $user->getUserPhotoSrc(), $preAvatar);
        }
        return $avatar;
    }
}
