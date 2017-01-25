<?php

/*
Plugin Name: Ti Ad Product
Description: Adds a button to visual editor.
Author: Pranita
*/


/*
 * enqueue TinyMCE plugin script with its ID.
 */
function enqueue_plugin_scripts($plugin_array) {
    $plugin_array["adproduct_button_plugin"] =  plugin_dir_url(__FILE__) . "index.js";
    return $plugin_array;
}
add_filter("mce_external_plugins", "enqueue_plugin_scripts");


/*
 * register custom buttons with their id.
 */
function register_buttons_editor($buttons) {
    array_push($buttons, "adproduct");
    return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");


/*
 * Add styles & scripts of ti-ad-product plugin
 */
function tiadproduct_enqueue_script() {
	wp_enqueue_script( 'adproduct-script', plugin_dir_url(__FILE__) . 'js/adproduct.js', false );
  wp_enqueue_script( 'adproduct-style', plugin_dir_url(__FILE__) . 'css/adproduct.css', false );
}
add_action( 'wp_enqueue_scripts', 'tiadproduct_enqueue_script' );


/*
 * Add a shortcode to render quiz
 */
function adproduct_shortcode_function($atts) {
    extract(shortcode_atts(array(
        'qsrc' => '',
        'qid' => '',
     ), $atts));
    return '<iframe id="quiz-app-frame" src="https://adproduct.timeinc.com/#/Render?quizId='. $qid . '&quizDataUrl='. $qsrc . '" style="width:100%; frameborder="0""></iframe>';
}
add_shortcode('adproduct', 'adproduct_shortcode_function');
