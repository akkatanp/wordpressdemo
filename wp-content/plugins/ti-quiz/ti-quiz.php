<?php
/*
Plugin Name: Ti Quiz
Description: Quiz and poll plugin
Version: 1.0.0
Author: Pranita
Author URI: http://www.timeinc.com/
License: GPL
*/

/*
 * Maintain version for plugin
 */
add_option( TIQUIZ_VERSION_KEY, TIQUIZ_VERSION_NUM );
if (!defined( 'TIQUIZ_VERSION_KEY' )) {
    define( 'TIQUIZ_VERSION_KEY', 'myplugin_version' );
}
if (!defined( 'TIQUIZ_VERSION_NUM' )) {
    define( 'TIQUIZ_VERSION_NUM', '1.0' );
}

/*
 * Create Cusrom Post type
 */
add_action( 'init', 'tiquiz_custom_post_type', 0 );
function tiquiz_custom_post_type() {
// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Quizzes', 'Post Type General Name', 'twentysixteen' ),
		'singular_name'       => _x( 'Quiz', 'Post Type Singular Name', 'twentysixteen' ),
		'menu_name'           => __( 'Quizzes', 'twentysixteen' ),
		'parent_item_colon'   => __( 'Parent Quiz', 'twentysixteen' ),
		'all_items'           => __( 'All Quizzes', 'twentysixteen' ),
		'view_item'           => __( 'View Quiz', 'twentysixteen' ),
		'add_new_item'        => __( 'Add New Quiz', 'twentysixteen' ),
		'add_new'             => __( 'Add New', 'twentysixteen' ),
		'edit_item'           => __( 'Edit Quiz', 'twentysixteen' ),
		'update_item'         => __( 'Update Quiz', 'twentysixteen' ),
		'search_items'        => __( 'Search Quiz', 'twentysixteen' ),
		'not_found'           => __( 'Not Found', 'twentysixteen' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentysixteen' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __( 'quizzes', 'twentysixteen' ),
		'description'         => __( 'Quizzes and Polls', 'twentysixteen' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'genres' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	register_post_type( 'quizzes', $args );
}

/* Filter the single_template with our custom function*/
add_filter( 'single_template', 'tiquiz_template' );
function tiquiz_template( $template ) {
    global $post;

    if ( $post->post_type == "quizzes" ){

        $plugin_path = plugin_dir_path( __FILE__ );

        // The name of custom post type single template
        $template_name = 'single-quizzes.php';

        if( $template === get_stylesheet_directory() . '/' . $template_name
            || !file_exists($plugin_path . $template_name )) {
            return $template;
        }
        return $plugin_path . $template_name;
    }
    return $template;
}

/*
 * Add stylesheets
 */
add_action( 'wp_enqueue_scripts', 'tiquiz_enqueue_styles' );
function tiquiz_enqueue_styles() {
   wp_enqueue_style( 'tiquiz', plugins_url( '/css/tiquiz_style.css', __FILE__ ) );
}

/*
 * Activate plugins
 */
register_activation_hook( __FILE__, 'tiquiz_activate_plugins' );
function tiquiz_activate_plugins() {
  if ( !is_plugin_active('advanced-custom-fields/acf.php' ) ) {
    activate_plugin("advanced-custom-fields/acf.php");
  }
  if ( !is_plugin_active('acf-repeater/acf-repeater.php' ) ) {
    activate_plugin("acf-repeater/acf-repeater.php");
  }
}

/*
 * Deactivate plugins
 */
register_deactivation_hook(__FILE__,'tiquiz_deactivate');
function tiquiz_deactivate(){
  $dependent = 'acf-repeater/acf-repeater.php';
  if( is_plugin_active($dependent) ){
       add_action( 'update_option_active_plugins', 'tiquiz_deactivate_dependent_repeater' );
  }
  $dependent_acf = 'advanced-custom-fields/acf.php';
  if( is_plugin_active($dependent_acf) ){
       add_action( 'update_option_active_plugins', 'tiquiz_deactivate_dependent_acf' );
  }
}

function tiquiz_deactivate_dependent_repeater(){
     $dependent = 'acf-repeater/acf-repeater.php';
     deactivate_plugins( $dependent );
}

function tiquiz_deactivate_dependent_acf(){
     $dependent = 'advanced-custom-fields/acf.php';
     deactivate_plugins( $dependent );
}

/*
 * Registering ACF field groups
 */
add_action( 'acf/register_fields', 'tiquiz_create_fields' );
function tiquiz_create_fields() {
  if(function_exists("register_field_group")) {
    register_field_group(array (
      'id' => 'acf_quiz',
      'title' => 'Quiz',
      'fields' => array (
        array (
          'key' => 'field_57ad796d261a8',
          'label' => 'Quiz Type',
          'name' => 'quiz_type',
          'type' => 'select',
          'required' => 1,
          'choices' => array (
            'Quiz' => 'Quiz',
            'Poll' => 'Poll',
          ),
          'default_value' => 'Quiz',
          'allow_null' => 0,
          'multiple' => 0,
        ),
        array (
          'key' => 'field_57a85f521a0f1',
          'label' => 'Questions',
          'name' => 'questions',
          'type' => 'repeater',
          'sub_fields' => array (
            array (
              'key' => 'field_57a85f881a0f2',
              'label' => 'Question',
              'name' => 'question',
              'type' => 'wysiwyg',
              'column_width' => '',
              'default_value' => '',
              'toolbar' => 'full',
              'media_upload' => 'yes',
            ),
            array (
              'key' => 'field_57aac0c715383',
              'label' => 'Layout',
              'name' => 'layout',
              'type' => 'select',
              'column_width' => '',
              'choices' => array (
                'Grid' => 'Grid',
                'List' => 'List',
              ),
              'default_value' => 'Grid',
              'allow_null' => 0,
              'multiple' => 0,
            ),
            array (
              'key' => 'field_57a85ff213f04',
              'label' => 'Answers',
              'name' => 'answers',
              'type' => 'repeater',
              'column_width' => '',
              'sub_fields' => array (
                array (
                  'key' => 'field_57a8600613f05',
                  'label' => 'answer',
                  'name' => 'answer',
                  'type' => 'wysiwyg',
                  'column_width' => '',
                  'default_value' => '',
                  'toolbar' => 'full',
                  'media_upload' => 'yes',
                ),
                array (
                  'key' => 'field_57a8619c8c910',
                  'label' => 'Is this option the correction answer',
                  'name' => 'correct_answer',
                  'type' => 'true_false',
                  'instructions' => 'Only for Quiz',
                  'column_width' => '',
                  'message' => '',
                  'default_value' => 0,
                ),
              ),
              'row_min' => 0,
              'row_limit' => '',
              'layout' => 'row',
              'button_label' => 'Add Answer',
            ),
          ),
          'row_min' => 0,
          'row_limit' => '',
          'layout' => 'row',
          'button_label' => 'Add Quiz',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options' => array (
        'position' => 'normal',
        'layout' => 'no_box',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
