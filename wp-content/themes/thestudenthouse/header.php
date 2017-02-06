<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>

    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo THEME_URI; ?>js/html5.js"></script>

<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="site-wrap">
    <div class="header-wrap">
        <header class="site-header">
            <div class="row" style="width: 100%">
                <div class="site-logo left">
                    <a href="<?php echo SITE_URL; ?>" rel="home">
                        <img src="http://www.soict.hust.edu.vn/~soict2016/images/HUST_logo.jpg" style="height: 150px" />
                        <img src="<?php echo ThemexCore::getOption('site_logo', THEME_URI . 'images/logo.png'); ?>"
                             alt="<?php bloginfo('name'); ?>"/>
                    </a>
                    <span style="font-size: 25px;">CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP DÀNH CHO SINH VIÊN</span>
                </div>
                <!-- /logo -->
                <div class="header-options right clearfix">
                    <div class="login-options right">
                        <?php if (is_user_logged_in()) { ?>


                            <div class="left">
                                <span
                                    style="line-height: 30px;vertical-align: middle;"><?php echo "Xin chào " . ThemexUser::$data['user']['profile']['full_name'] . ' !'; ?></span>
                            </div>

                            <div class="button-wrap left">
                                <a href="<?php echo wp_logout_url(SITE_URL); ?>" class="element-button dark">
                                    <span class="button-icon logout"></span><?php _e('Sign Out', 'academy'); ?>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="button-wrap left tooltip login-button" style="opacity: 1">
                                <a href="#" class="element-button dark"><span
                                        class="button-icon login"></span><?php _e('Sign In', 'academy'); ?></a>
                                <div class="tooltip-wrap">
                                    <div class="tooltip-text">
                                        <form action="<?php echo AJAX_URL; ?>" class="ajax-form popup-form"
                                              method="POST">
                                            <div class="message"></div>
                                            <div class="field-wrap">
                                                <input type="text" name="user_login"
                                                       value="<?php _e('Username', 'academy'); ?>"/>
                                            </div>
                                            <div class="field-wrap">
                                                <input type="password" name="user_password"
                                                       value="<?php _e('Password', 'academy'); ?>"/>
                                            </div>
                                            <div class="button-wrap left nomargin">
                                                <a href="#"
                                                   class="element-button submit-button"><?php _e('Sign In', 'academy'); ?></a>
                                            </div>
                                            <?php if (ThemexFacebook::isActive()) { ?>
                                                <div class="button-wrap left">
                                                    <a href="<?php echo ThemexFacebook::getURL(); ?>"
                                                       title="<?php _e('Sign in with Facebook', 'academy'); ?>"
                                                       class="element-button facebook-button">
                                                        <span class="button-icon facebook"></span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <div class="button-wrap switch-button left">
                                                <a href="#" class="element-button dark"
                                                   title="<?php _e('Password Recovery', 'academy'); ?>">
                                                    <span class="button-icon help"></span>
                                                </a>
                                            </div>
                                            <input type="hidden" name="user_action" value="login_user"/>
                                            <input type="hidden" name="user_redirect"
                                                   value="<?php echo esc_attr(themex_value($_POST, 'user_redirect')); ?>"/>
                                            <input type="hidden" name="nonce" class="nonce"
                                                   value="<?php echo wp_create_nonce(THEMEX_PREFIX . 'nonce'); ?>"/>
                                            <input type="hidden" name="action" class="action"
                                                   value="<?php echo THEMEX_PREFIX; ?>update_user"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tooltip-wrap password-form">
                                    <div class="tooltip-text">
                                        <form action="<?php echo AJAX_URL; ?>" class="ajax-form popup-form"
                                              method="POST">
                                            <div class="message"></div>
                                            <div class="field-wrap">
                                                <input type="text" name="user_email"
                                                       value="<?php _e('Email', 'academy'); ?>"/>
                                            </div>
                                            <div class="button-wrap left nomargin">
                                                <a href="#"
                                                   class="element-button submit-button"><?php _e('Reset Password', 'academy'); ?></a>
                                            </div>
                                            <input type="hidden" name="user_action" value="reset_password"/>
                                            <input type="hidden" name="nonce" class="nonce"
                                                   value="<?php echo wp_create_nonce(THEMEX_PREFIX . 'nonce'); ?>"/>
                                            <input type="hidden" name="action" class="action"
                                                   value="<?php echo THEMEX_PREFIX; ?>update_user"/>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="button-wrap left">
                                <?php do_action('facebook_login_button'); ?>
                            </div>

                            <?php if (get_option('users_can_register')) { ?>
                                <div class="button-wrap left">
                                    <a href="<?php echo ThemexCore::getURL('register'); ?>" class="element-button">
                                        <span class="button-icon register"></span><?php _e('Register', 'academy'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <!-- /login options -->

                    <!-- /	Harry Deleted
							<div class="search-form right">
								<?php get_search_form(); ?>
							</div>
						End delete -->

                    <!-- Harry Delete
						<?php if ($code = ThemexCore::getOption('sharing')) { ?>
						<div class="button-wrap share-button tooltip right">
							<a href="#" class="element-button dark"><span class="button-icon plus nomargin"></span></a>
							<div class="tooltip-wrap">
								<div class="corner"></div>
								<div class="tooltip-text"><?php echo themex_html($code); ?></div>
							</div>
						</div>
						
						<?php } ?>
						End Delete Share button -->
                </div>
                <!-- /header options -->
                <!-- /	Harry Deleted
						<div class="mobile-search-form">
							<?php get_search_form(); ?>
						</div>
					
					<nav class="header-navigation right">
						<?php wp_nav_menu(array('theme_location' => 'main_menu', 'container_class' => 'menu')); ?>
						<div class="select-menu select-element redirect">
							<span></span>
							<?php ThemexInterface::renderDropdownMenu('main_menu'); ?>							
						</div>
						
					</nav>
					End delete -->
            </div>
        </header>
        <!-- /header -->
    </div>

    <div class="featured-content">
        <div class="substrate">
            <?php ThemexStyle::renderBackground(); ?>
        </div>
        <?php if (is_front_page() && is_page()) { ?>
            <?php get_template_part('module', 'slider'); ?>
        <?php } else { ?>
            <div class="row">
                <?php if (is_singular('course')) { ?>
                    <?php get_template_part('module', 'course'); ?>
                <?php } else { ?>
                    <?php /*
				<div class="page-title">
					<h1 class="nomargin"><?php ThemexInterface::renderPageTitle(); ?></h1>
				</div>
				<!-- /page title -->				
				*/ ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo get_site_url(); ?>"> <span class="glyphicon glyphicon-home"></span> Trang
                        chủ</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Chương Trình Thực Tập Doanh Nghiệp
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo get_site_url() . '/quy-trinh-thuc-hien'; ?>">Quy trình thực hiện</a></li>
                        <li><a href="<?php echo get_site_url() . '/noi-dung-thuc-tap'; ?>">Nội dung thực tập</a></li>
                        <li><a href="<?php echo get_site_url() . '/phuong-phap-danh-gia'; ?>">Phương pháp đánh giá</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo get_site_url().'/thong-bao'; ?>">Thông báo</a></li>
                <li><a href="<?php echo get_site_url().'/huong-dan'; ?>">Hướng dẫn</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cá nhân
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>">Thông tin cá nhân</a></li>
                        <li><a href="<?php echo get_site_url() . '/register-internship=1'; ?>">Đăng ký công ty thực
                                tập</a></li>
                        <li><a href="<?php echo get_site_url() . '/internship-information=1'; ?>">Thông tin thực tập</a>
                        </li>
                        <li><a href="<?php echo get_site_url() . '/internship-result=1'; ?>">Kết quả thực tập</a></li>
                        <li><a href="<?php echo get_site_url() . '/internship-report=1'; ?>">Nộp báo cáo</a></li>
                    </ul>
                </li>

                <?php if ( current_user_can( 'administrator' ) ) {?>
                    <li><a href="<?php echo get_site_url().'/internship-cv=1'; ?>">Tạo sinh viên</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>


    <!-- /featured -->
    <div class="main-content">
        <div class="row">