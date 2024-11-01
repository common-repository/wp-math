<?php
/*
Plugin Name: WP math
Plugin URI: http://wpmath.g6.cz
Description: Publishing and solving mathematical documents. Plugin is using PhpMathPublisher.
Version: 0.4.5
Author: Stanislav Guncaga
Author URI: http://wpmath.g6.cz
License: GPL2
*/
include_once ("mathpublisher.php");   //PhpMathPublisher library
include_once ("functions.php");       //general functions
include_once ("core.php");            //core
include_once ("core_static.php");     //core for static feature       
include_once ("core_functions.php");  //core functions
include_once ("option.php");          //admin options
include_once ("short_code.php");      //all shortcodes functions
include_once ("math_functions.php");  //all math functions
include_once ("units.php");           //units
include_once ("core_matrix.php");     //matrix functions
include_once ("graphs.php");          //graphs

define("debug",true);



register_activation_hook(__FILE__, 'wp_math_activate');
register_deactivation_hook(__FILE__, 'wp_math_deactivate');

add_action('admin_menu', 'wp_math_menu');

add_shortcode('form', 'wp_math_form');
add_shortcode('static', 'wp_math_static');

add_filter( "the_content", "wp_math" );
if(get_option("wp_math_static")){add_filter( "content_save_pre", "wp_math_save" );}

?>