=== Plugin Name ===

Contributors: neilgee
Donate link: http://wpbeaches.com/
Tags: lightbox, video, responsive, modal, pop-up
Requires at least: 4.0
Tested up to: 4.5
Stable tag: 1.3.0
Plugin Name: VenoBox Lightbox
Plugin URI: http://wpbeaches.com
Description: Responsive video and image pop-up lightbox
Author: Neil Gee
Version: 1.3.0
Author URI: http://wpbeaches.com/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

This plugin adds the VenoBox Responsive Lightbox to links to display Vimeo and YouTube videos, images, iframe or inline content in a lightbox display.


== Description ==

This plugin adds the VenoBox Responsive Lightbox to links, displaying videos; YouTube, Vimeo, images, iframe, Google Maps or other inline content in a responsive lightbox display.

Plugin option to open all linked images and galleries in WordPress in Lightbox mode.

The big difference compared to many others plugins like this is that VenoBox calculates the max width of the image displayed and preserves its height if is taller than the window (so in small devices you can scroll down the content, avoiding vertical microscopic resized images).


== Installation ==

This section describes how to install the plugin:

1. Upload the `venobox-lightbox` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Options are in Settings => Venobox Lightbox



== Usage ==

Comprehensive usage is documented in the WP Admin > Dashboard > Settings > VenoBox Lightbox.

There are manual markup instructions for videos and iframes and automated options for images.

Ability to enable/disable VenoBox gallery for images on a per post/page/custom post type level.


== Screenshots ==

1. VenoBox Lightbox Plugin Options

2. Lightbox interface

3. Post/Page metabox to toggle on/off

4. Choose between alt, title and caption as the Title for the lightbox Title.


== Changelog ==

= 1.3.0 =
* 05/07/16
* I18n ready - plugin internationalised
* Higher z-index on lightbox overlay
* Used more up to date mark up on Settings API
* Added a wp_add_inline_style css
* Added a styling option to change the generic lightbox background color supporting alpha transparency, in a rgba format

= 1.2.1 =
* 03/07/16
* Added option to choose either alt text, title text or caption text to use as the Title value in lightbox mode for images - alt text is set as default.

= 1.2.0 =
* 02/07/16
* Added post/page/custom post type metabox with ability to enable/disable VenoBox for images.
  This metabox is only visible if the 'Add Lightbox for all linked images' Plugin Option is enabled.

= 1.1.0 =
* 20/06/16
* Add extra plugin options:
 - Option make all existing and future linked images and galleries open in lightbox mode.
 - Option to use and display alt text from image as the title displayed in lightbox.
 - Option to add all images on same page to paginate(show previous and next icons) whilst in lightbox mode.

= 1.0.0 =
* 15/06/16
* Initial release.
