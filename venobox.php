<?php     namespace ng_venobox;

/*
Plugin Name: Venobox Lightbox
Plugin URI: http://wpbeaches.com/
Description: Venobox Lightbox - responsive lightbox for video, iframe and images
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



  wp_enqueue_script( 'venobox-js' );
  wp_enqueue_style( 'venobox-css' );

     $data = array (

      'ng_venobox' => array(

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
    wp_enqueue_script ( 'venobox-init' , plugins_url( '/js/venobox-init.js',  __FILE__ ), array( 'venobox-js' ), '1.6.0', false );
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
        __( 'Venobox Lightbox Plugin','venobox' ), //$page_title
        __( 'Venobox Lightbox', 'venobox' ), //$menu_title
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
