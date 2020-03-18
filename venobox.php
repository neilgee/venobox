<?php
/**
 * Plugin Name: VenoBox Lightbox
 * Plugin URI: https://wordpress.org/plugins/venobox-lightbox/
 * Description: VenoBox Lightbox - responsive lightbox for video, iframe and images
 * Author: Neil Gowran, Nicola Franchini
 * Version: 2.0.1
 * Author URI: http://wpbeaches.com - http://veno.es
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: venobox-lightbox
 * Domain Path: /languages
 *
 * @package Venobox Lightbox
 */

if ( ! class_exists( 'VenoBox_Lightbox', false ) ) {
	require_once dirname( __FILE__ ) . '/inc/class-venobox-lightbox.php';
}
// Get it started.
venobox_lightbox();
