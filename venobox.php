<?php     namespace ng_venobox;

/*
Plugin Name: VenoBox Lightbox
Plugin URI: http://wpbeaches.com/
Description: VenoBox Lightbox - responsive lightbox for video, iframe and images
Author: Neil Gee
Version: 1.2.1
Author URI: http://wpbeaches.com
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: venobox
Domain Path: /languages/
*/


  // If called direct, refuse
  if ( ! defined( 'ABSPATH' ) ) {
          die;
  }

/* Assign global variables */

$plugin_url = WP_PLUGIN_URL . '/venobox';
$options = array();

/**
 * Register our text domain.
 *
 * @since 1.0.0
 */


function load_textdomain() {
  load_plugin_textdomain( 'venobox', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_textdomain' );

/**
 * Register and Enqueue Scripts and Styles
 *
 * @since 1.0.0
 */

//Script-tac-ulous -> All the Scripts and Styles Registered and Enqueued
function scripts_styles() {

$options = get_option( 'venobox_settings' );

  wp_register_script ( 'venobox-js' , plugins_url( '/js/venobox.min.js',  __FILE__ ), array( 'jquery' ), '1.6.0', false );
  wp_register_style ( 'venobox-css' , plugins_url( '/css/venobox.css',  __FILE__ ), '' , '1.6.0', 'all' );
  wp_register_script ( 'venobox-init' , plugins_url( '/js/venobox-init.js',  __FILE__ ), array( 'venobox-js' ), '1.6.0', false );

// Add new plugin options defaults here, set them to blank, this will avoid PHP notices of undefined, if new options are introduced to the plugin and are not saved or udated then the setting will be defined.
$options_default = array(

    'ng_numeratio'    => '',
    'ng_infinigall'   => '',
    'ng_all_images'   => '',
    'ng_all_lightbox' => '',
    'ng_title_select' => 1,

);
$options = wp_parse_args( $options, $options_default );


  wp_enqueue_script( 'venobox-js' );
  wp_enqueue_style( 'venobox-css' );

     // Creating our jQuery variables here from our database options, these will be passed to jQuery init script via wp_localize_script
     $data = array (

      'ng_venobox' => array(
        'ng_numeratio'    => (bool)$options['ng_numeratio'],
        'ng_infinigall'   => (bool)$options['ng_infinigall'],
        'ng_all_images'   => (bool)$options['ng_all_images'],
        'ng_all_lightbox' => (bool)$options['ng_all_lightbox'],
        'ng_title_select' => (int)$options['ng_title_select'],

      ),
  );

     //add filter
    $data = apply_filters( 'ng_venoboxVars', $data );

    // Pass PHP variables to jQuery script
    wp_localize_script( 'venobox-init', 'venoboxVars', $data );
    //Access jQuery variable using venoboxVars.ng_venobox

    wp_enqueue_script( 'venobox-init' );

}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\scripts_styles' );

/**
 * Add scripts in back-end for demo purpose.
 *
 * @since 1.0.0
 */
function admin_venobox($hook) {
    if ( 'settings_page_venobox' != $hook ) {
        return;
    }

    wp_enqueue_script ( 'venobox-js' , plugins_url( '/js/venobox.min.js',  __FILE__ ), array( 'jquery' ), '1.6.0', false );
    wp_enqueue_style ( 'venobox-css' , plugins_url( '/css/venobox.css',  __FILE__ ), '' , '1.6.0', 'all' );
    wp_enqueue_script ( 'venobox-init-admin' , plugins_url( '/js/venobox-init-admin.js',  __FILE__ ), array( 'venobox-js' ), '1.6.0', false );
}
add_action( 'admin_enqueue_scripts',  __NAMESPACE__ . '\\admin_venobox' );

/**
 * Create the plugin option page.
 *
 * @since 1.0.0
 */

function plugin_page() {

    /*
     * Use the add options_page function
     * add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function )
     */

     add_options_page(
        __( 'VenoBox Lightbox Plugin','venobox' ), //$page_title
        __( 'VenoBox Lightbox', 'venobox' ), //$menu_title
        'manage_options', //$capability
        'venobox', //$menu-slug
        __NAMESPACE__ . '\\plugin_options_page' //$function
      );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\plugin_page' );

/**
 * Include the plugin option page.
 *
 * @since 1.0.0
 */

function plugin_options_page() {

    if( !current_user_can( 'manage_options' ) ) {

      wp_die( "Hall and Oates 'Say No Go'" );
    }

   require( 'inc/options-page-wrapper.php' );
}

/**
 * Register our option fields
 *
 * @since 1.0.0
 */
// Check validation
function plugin_settings() {
  register_setting(
        'ng_settings_group', //option name
        'venobox_settings'// option group setting name and option name
     //  __NAMESPACE__ . '\\venobox_validate_input' //sanitize the inputs
  );

  add_settings_section(
        'ng_venobox_section', //declare the section id
        'VenoBox Settings', //page title
         __NAMESPACE__ . '\\ng_venobox_section_callback', //callback function below
        'venobox' //page that it appears on

    );

  add_settings_section(
        'ng_venobox_section_markup', //declare the section id
        'VenoBox Markup', //page title
         __NAMESPACE__ . '\\ng_venobox_section_markup_callback', //callback function below
        'venobox-markup' //page that it appears on

    );

  add_settings_field(
        'ng_all_images', //unique id of field
        'Add All Linked Images To LightBox', //title
         __NAMESPACE__ . '\\ng_all_images_callback', //callback function below
        'venobox', //page that it appears on
        'ng_venobox_section' //settings section declared in add_settings_section
    );

  add_settings_field(
        'ng_all_lightbox', //unique id of field
        'Display Previous/Next Icons', //title
         __NAMESPACE__ . '\\ng_all_lightbox_callback', //callback function below
        'venobox', //page that it appears on
        'ng_venobox_section' //settings section declared in add_settings_section
    );

  add_settings_field(
        'ng_title_select', //unique id of field
        'Choose which Title text to use in LightBox', //title
         __NAMESPACE__ . '\\ng_title_select_callback', //callback function below
        'venobox', //page that it appears on
        'ng_venobox_section' //settings section declared in add_settings_section
    );

  add_settings_field(
        'ng_numeratio', //unique id of field
        'Display Pagination', //title
         __NAMESPACE__ . '\\ng_numeratio_callback', //callback function below
        'venobox', //page that it appears on
        'ng_venobox_section' //settings section declared in add_settings_section
    );

  add_settings_field(
        'ng_infinigall', //unique id of field
        'Infinite Gallery', //title
         __NAMESPACE__ . '\\ng_infinigall_callback', //callback function below
        'venobox', //page that it appears on
        'ng_venobox_section' //settings section declared in add_settings_section
    );
}

add_action('admin_init', __NAMESPACE__ . '\\plugin_settings');

/**
 * Register our section call back
 * (not much happening here)
 * @since 1.0.0
 */

function ng_venobox_section_callback() {

}

/**
 *  Add Lightbox for all existing and future linked images
 *
 * @since 1.1.0
 */

function ng_all_images_callback() {
$options = get_option( 'venobox_settings' );

if( !isset( $options['ng_all_images'] ) ) $options['ng_all_images'] = '';

  echo'<input type="checkbox" id="ng_all_images" name="venobox_settings[ng_all_images]" value="1"' . checked( 1, $options['ng_all_images'], false ) . '/>';
  echo'<label for="ng_all_images">' . esc_attr_e( 'Add Lightbox for all linked images','venobox') . '</label>';

}

/**
 *  Add Previous & Next icons in Lightbox
 *
 * @since 1.1.0
 */

function ng_all_lightbox_callback() {
$options = get_option( 'venobox_settings' );

if( !isset( $options['ng_all_lightbox'] ) ) $options['ng_all_lightbox'] = '';

  echo'<input type="checkbox" id="ng_all_lightbox" name="venobox_settings[ng_all_lightbox]" value="1"' . checked( 1, $options['ng_all_lightbox'], false ) . '/>';
  echo'<label for="ng_all_lightbox">' . esc_attr_e( 'Add Previous & Next icons in Lightbox, to navigate multiple items','venobox') . '</label>';

}


/**
 *  Choose either alt or title attribute or caption value for lightbox title value
 *
 * @since 1.2.1
 */

function ng_title_select_callback() {
$options = get_option( 'venobox_settings' );

if( !isset( $options['ng_title_select'] ) ) $options['ng_title_select'] = 1;

    $html = '<input type="radio" id="use_alt_value" name="venobox_settings[ng_title_select]" value="1"' . checked( 1, $options['ng_title_select'], false ) . '/>';
    $html .= '<label for="use_alt_value">ALT text value</label>';

    $html .= '<input type="radio" id="use_title_value" name="venobox_settings[ng_title_select]" value="2"' . checked( 2, $options['ng_title_select'], false ) . '/>';
    $html .= '<label for="use_title_value">Title text value</label>';

    $html .= '<input type="radio" id="use_caption_value" name="venobox_settings[ng_title_select]" value="3"' . checked( 3, $options['ng_title_select'], false ) . '/>';
    $html .= '<label for="use_caption_value">Caption text value</label>';

    echo $html;
}

/**
 *  Add Pagination to Lightbox Head for multiple items on page
 *
 * @since 1.0.0
 */

function ng_numeratio_callback() {
$options = get_option( 'venobox_settings' );

if( !isset( $options['ng_numeratio'] ) ) $options['ng_numeratio'] = '';

  echo'<input type="checkbox" id="ng_numeratio" name="venobox_settings[ng_numeratio]" value="1"' . checked( 1, $options['ng_numeratio'], false ) . '/>';
  echo'<label for="ng_numeratio">' . esc_attr_e( 'Show Pagination of Mulitple Items in Top Left in Title Bar','venobox') . '</label>';

}

/**
 *  Add Infinite gallery previous and next to Lightbox Head for multiple items on page
 *
 * @since 1.0.0
 */

function ng_infinigall_callback() {
$options = get_option( 'venobox_settings' );

if( !isset( $options['ng_infinigall'] ) ) $options['ng_infinigall'] = '';

  echo'<input type="checkbox" id="ng_infinigall" name="venobox_settings[ng_infinigall]" value="1"' . checked( 1, $options['ng_infinigall'], false ) . '/>';
  echo'<label for="ng_infinigall">' . esc_attr_e( 'Add Infinite gallery, which allows continous toggling of items on page in lightbox mode','venobox') . '</label>';

}

/**
 *  Metabox markup per post/page
 *
 * @since 1.2.0
 */

function meta_box_markup($post) {
  wp_nonce_field(basename(__FILE__), "venobox_nonce");
  $venobox_stored_meta = get_post_meta( $post->ID );
  ?>

  <label for="_venobox_check">
    <input type="checkbox" name="_venobox_check" id="_venobox_check" value="yes" <?php if ( isset ( $venobox_stored_meta ['_venobox_check'] ) ) checked( $venobox_stored_meta['_venobox_check'][0], 'yes' ); ?> />
    <?php _e( 'Disable VenoBox', 'venobox' )?>
  </label>

  <?php
}

/**
 *  Save metabox markup per post/page
 *
 * @since 1.2.0
 */

function save_custom_meta_box( $post_id ) {
  // Checks save status
 $is_autosave = wp_is_post_autosave( $post_id );
 $is_revision = wp_is_post_revision( $post_id );
 $is_valid_nonce = ( isset( $_POST[ 'venobox_nonce' ] ) && wp_verify_nonce( $_POST[ 'venobox_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

 // Exits script depending on save status
   if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
       return;
   }

 // Checks for input and sanitizes/saves if needed
 // if( isset( $_POST[ '_venobox_check' ] ) ) {
 //     update_post_meta( $post_id, '_venobox_check', sanitize_text_field( $_POST[ '_venobox_check' ] ) );
 // }

 // Checks for input and saves
 // http://themefoundation.com/wordpress-meta-boxes-guide/
  if( isset( $_POST[ '_venobox_check' ] ) ) {
      update_post_meta( $post_id, '_venobox_check', 'yes' );
  }
  else {
      update_post_meta( $post_id, '_venobox_check', '' );
  }
}
add_action('save_post', __NAMESPACE__ . '\\save_custom_meta_box', 10, 2);

/**
 *  Add Metabox per post/page and any registered custom post type
 *
 * @since 1.2.0
 */
function add_custom_meta_box() {
  $options = get_option( 'venobox_settings' );
if( !empty( $options['ng_all_images'] ) ){
//https://thomasgriffin.io/how-to-automatically-add-meta-boxes-to-custom-post-types/
    $post_types = get_post_types();
    foreach ( $post_types as $post_type ) {
    add_meta_box('venobox-meta-box', __('Disable VenoBox Lightbox', 'venobox'), __NAMESPACE__ . '\\meta_box_markup', $post_type, 'side', 'default', null);
    }
  }
}
add_action('add_meta_boxes', __NAMESPACE__ . '\\add_custom_meta_box');


/**
 *  Remove Venobox per post/page/cpt setting
 *
 * @since 1.2.0
 */

function venobox_no_add( $classes ) {

  /* Get the current post ID. */
  $post_id = get_the_ID();

  /* If we have a post ID, proceed. */
  if ( !empty( $post_id ) ) {

    /* Get the custom post class. */
    $is_venobox_checked = get_post_meta( $post_id, '_venobox_check', true );

    /* If a post class was input, sanitize it and add it to the post class array. */
    if ( $is_venobox_checked )
      $classes[] = 'novenobox';
  }

  return $classes;
}

add_filter( 'post_class', __NAMESPACE__ . '\\venobox_no_add' );
