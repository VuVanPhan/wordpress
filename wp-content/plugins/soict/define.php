<?php

define( 'SOICT_VERSION', '1.0' );
define( 'SOICT_MINIMUM_WP_VERSION', '3.7' );
define( 'SOICT_DELETE_LIMIT', 100000 );


if(!defined('DS')) define( 'DS'     , DIRECTORY_SEPARATOR );
define( 'SOICT_PREFIX'              , 'Soict' );
define( 'SOICT_PLUGIN_DIR'          , plugin_dir_path( __FILE__ ) );

define( 'SOICT_PLUGIN_CONTROLLER_DIR'    , SOICT_PLUGIN_DIR . 'controllers' . DS );
define( 'SOICT_PLUGIN_MODEL_DIR'         , SOICT_PLUGIN_DIR . 'models' . DS );
define( 'SOICT_PLUGIN_VIEW_DIR'          , SOICT_PLUGIN_DIR . 'views' . DS );
define( 'SOICT_PLUGIN_HELPER_DIR'        , SOICT_PLUGIN_DIR . 'helpers' . DS );
define( 'SOICT_PLUGIN_INCLUDE_DIR'       , SOICT_PLUGIN_DIR . 'includes' . DS );
define( 'SOICT_PLUGIN_PUBLIC_DIR'        , SOICT_PLUGIN_DIR . 'public' . DS );
define( 'SOICT_PLUGIN_VALIDATOR_DIR'     , SOICT_PLUGIN_DIR . 'validates' . DS );

define( 'SOICT_PLUGIN_URI'               , plugins_url('', __FILE__) );
define( 'SOICT_PLUGIN_PUBLIC_URI'        , plugins_url('/public', __FILE__) );
define( 'SOICT_PLUGIN_PUBLIC_FRONTEND_VIEW_URI'  , plugins_url('/views/frontend/public', __FILE__) );
define( 'SOICT_PLUGIN_PUBLIC_BACKEND_VIEW_URI'   , plugins_url('/views/adminhtml/public', __FILE__) );


