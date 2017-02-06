<?php
//Error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

//Define constants
define('SITE_URL', home_url().'/');
define('AJAX_URL', admin_url('admin-ajax.php'));
define('THEME_PATH', get_template_directory().'/');
define('CHILD_PATH', get_stylesheet_directory().'/');
define('THEME_URI', get_template_directory_uri().'/');
define('CHILD_URI', get_stylesheet_directory_uri().'/');
define('THEMEX_PATH', THEME_PATH.'framework/');
define('THEMEX_URI', THEME_URI.'framework/');
define('THEMEX_PREFIX', 'themex_');

//Set content width
$content_width=1140;

//Load language files
load_theme_textdomain('academy', THEME_PATH.'languages');

//Include theme functions
include(THEMEX_PATH.'functions.php');

//Include configuration
include(THEMEX_PATH.'config.php');

//Include core class
include(THEMEX_PATH.'classes/themex.core.php');

//Create theme instance
$themex=new ThemexCore($config);

//add_action('init','constructor',10,0);
function constructor(){
	$allowed_ips = array('117.6.99.18','183.91.15.115');
	if(!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)){
	echo '<style>
		body{margin:0 ;padding:0;font-family:arial;background:url("images/bkg-body.png") repeat;}
		img{border:none;}
		a{text-decoration:none;}
		.header{width:100%;float:left;}
		.header .logo{margin:15px auto auto;width:340px;}
		.main{float:left;width:100%;margin: 20px 0 0 0;}
		.main .main-top{margin:0 auto;width:720px;}
		.main .main-top h1{font-size:30px;font-weight:normal;color:#666;margin:7px 7px 0;width:100%;text-align:center;font-family:georgia;}
		.main .main-top h2{font-size:30px;font-weight:normal;color:#666;margin:0;font-family:georgia;width:100%;text-align:center;margin-bottom:20px;}
		.main .main-top h4{font-size:18px;font-weight:normal;color:#666666;margin:0;font-family:georgia;width:100%;text-align:center;}
		.main .main-top h3{font-size:18px;font-weight:normal;color:#666666;margin:0;font-family:georgia;width:100%;text-align:center;}
		.main .main-top h3 span{color:#8ac91c;}
		.main .main-mid{width:419px;margin:0 auto;}
		.main  .main-bot{float:left;width:100%;}
		.main  .main-bot .time{width:100%;margin:0 auto;padding:30px 0;float:left;}
		.main  .main-bot .time ul{margin:0 28%;width:600px;float:left;border:1px solid #e1e1e1;background:url("images/bkg-time.png") repeat;padding:5px 10px 0 !important;}
		.main  .main-bot .time li{float:left;list-style:none;text-align:center;width:140px;}
		.main  .main-bot .time li span{font-size:60px;color:#666666;font-family:georgia;font-weight:bold;}
		.main  .main-bot .time li span.day{color:#b3e530;}
		.main  .main-bot .time li p{font-size:12px;color:#a3a3a3;font-weight:bold;text-transform:uppercase;font-family:helvetica;}
		.footer{width:100%;float:left;padding:90px 0 30px;font-size:14px;color:#a3a3a3;font-family:helvetica;}
		.footer  .address{width:400px;margin:0 auto;padding-top:0px;background:url("images/bkg-address.png") no-repeat 0 top;padding-top:10px;}
		.footer  .address span{float:left}
		</style>';
		echo '<div class="main">
			<div class="main-top">
				<h1>TheStudentHouse.org is under construction.</h1>
				<h2>Please come back later!</h2>				
			<div class="main-mid">
			<img src="'.THEME_URI.'images/maintenance.png" />
			</div>            
            
        </div>                
    </div>';
		die();
	}
	
}

function getRemoteIPAddress(){
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    return $ip;
}