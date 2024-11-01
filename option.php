<?php
function wp_math_menu() {
  add_options_page('WP Math', 'WP Math', 'manage_options', 'wp_math', 'wp_math_options');
  }
  
function wp_math_options() {
  include("admin_menu.php");
  }
?>