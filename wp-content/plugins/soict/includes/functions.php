<?php

//register sidebar area for header right - login
register_sidebar(array(
	'id'    => 'header_bottom_sidebar',
	'name' => 'Header Bottom Sidebar',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<div class="soict-widget-title"><span>',
	'after_title' => '</span></div>',
));

add_action( 'admin_enqueue_scripts', 'enqueue_date_picker');
add_action( 'wp_enqueue_scripts', 'enqueue_date_picker_frontend' );
/**
 * Enqueue the date picker
 */
function enqueue_date_picker(){

	wp_enqueue_script(
		'jquery-ui-1.12.1.custom',
		SOICT_PLUGIN_URI.'/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
		time(),
		true
	);
	wp_enqueue_style( 'jquery-ui-datepicker', SOICT_PLUGIN_URI.'/lib/jquery-ui-1.12.1.custom/jquery-ui.min.css',
		array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'),
		time(),
		true
	);
}

function enqueue_date_picker_frontend (){

	return;

	wp_enqueue_script(
		'jquery-ui-1.12.1.custom-css',
		SOICT_PLUGIN_URI.'/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js',
		array(),
		time(),
		true
	);
	wp_enqueue_style( 'jquery-ui-datepicker-css', SOICT_PLUGIN_URI.'/lib/jquery-ui-1.12.1.custom/jquery-ui.min.css',
		array(),
		time(),
		true
	);
}