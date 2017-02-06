<?php
/**
 * @package Akismet
 */
/*
Plugin Name: Soict
Plugin URI: https://magestore.com/
Description: Plugin di kem voi theme soict_thuctap, student, company, lecturer
Version: 1.0
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: soict
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

require_once plugin_dir_path( __FILE__ ).'define.php';

require_once SOICT_PLUGIN_DIR.'includes/App.php';
require_once SOICT_PLUGIN_DIR.'includes/DbInit.php';

register_activation_hook( __FILE__, array('Soict_DbInit', 'plugin_activation') );
//register_deactivation_hook( __FILE__, array('ClassObjects\Soict', 'plugin_deactivation') );


if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( SOICT_PLUGIN_DIR . 'backend.php' );
	$backend = new Soict_Backend();
	add_action( 'init', array( $backend, 'init' ) );
}else{
	require_once( SOICT_PLUGIN_DIR . 'frontend.php' );
	$frontend = new Soict_Frontend();
	add_action( 'init', array( $frontend, 'init' ), 1 );
}

require_once SOICT_PLUGIN_DIR.'includes/functions.php';
