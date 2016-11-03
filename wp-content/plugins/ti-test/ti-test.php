<?php
/*
Plugin Name: Ti Test
Description: Test plugin for Demo
Version: 1.0.0
Author: Pranita
Author URI: http://www.timeinc.com/
License: GPL
*/

/*
*  Test
*/
add_filter( 'the_content', 'titest_custom_message');
function titest_custom_message($content) {
  echo "Hello World!!"." ".$content;
}
