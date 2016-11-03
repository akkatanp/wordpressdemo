<?php

/*
Plugin Name: Ti UGC Uploader
Description: Adds a menu for UGC uploader.
Author: Pranita
*/

/*
 *  Create a Page - UGC Uploader
 */
add_action('admin_menu', 'ugc_page_create');
function ugc_page_create() {
    $page_title = 'UGC Uploader Admin Page';
    $menu_title = 'UGC Uploader';
    $capability = 'edit_posts';
    $menu_slug = 'ugcuploader_page';
    $function = 'ugc_page_display';
    $icon_url = 'dashicons-format-gallery';
    $position = 24;

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

/*
 * Content of Page
 */
function ugc_page_display() {
    echo '<h1>UGC Photo Uploader</h1>';
    echo '<iframe id="ugc-app-frame" src="http://ugcuploader.us-east-1.elasticbeanstalk.com/#/Editor/Dashboard" style="width:100%; height: 2000px;" frameborder="0"></iframe>';
}