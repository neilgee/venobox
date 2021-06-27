<?php
/**
 * Plugin Name: VenoBox Lightbox
 * Plugin URI: https://wordpress.org/plugins/venobox-lightbox/
 * Description: VenoBox Lightbox - responsive lightbox for video, iframe and images
 * Author: <a href="https://wpbeaches.com">Neil Gowran</a>, <a href="https://veno.es">Nicola Franchini</a>
 * Version: 2.0.8
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: venobox-lightbox
 * Domain Path: /languages
 *
 * @package Venobox Lightbox
 */
define( 'VENOBOX_LIGHTBOX_VERSION', '2.0.8' );
if ( ! class_exists( 'VenoBox_Lightbox', false ) ) {
	require_once dirname( __FILE__ ) . '/inc/class-venobox-lightbox.php';
}
// Get it started.
venobox_lightbox();
