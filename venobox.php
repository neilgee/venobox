<?php     namespace ng_venobox;

/*
Plugin Name: VenoBox Lightbox
Plugin URI: http://wpbeaches.com/
Description: VenoBox Lightbox - responsive lightbox for video, iframe and images
Author: Neil Gee
Version: 1.0.0
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

    'ng_numeratio'  => '',
    'ng_infinigall' => '',
);
$options = wp_parse_args( $options, $options_default );


  wp_enqueue_script( 'venobox-js' );
  wp_enqueue_style( 'venobox-css' );

     // Creating our jQuery variables here from our database options, these will be passed to jQuery init script via wp_localize_script
     $data = array (

      'ng_venobox' => array(
        'ng_numeratio'  => (bool)$options['ng_numeratio'],
        'ng_infinigall' => (bool)$options['ng_infinigall'],
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
  echo'<label for="ng_infinigall">' . esc_attr_e( 'Add Infinite gallery previous and next to Lightbox for multiple items on page','venobox') . '</label>';

}
