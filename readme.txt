=== Plugin Name ===

Contributors: neilgee
Donate link: https://www.paypal.com/au/cgi-bin/webscr?cmd=_flow&SESSION=UTMvXh9tc4f-d1yspwlf9gW0wyybSe1mzkx1p1to3k1VqHoWE7AulrQABSi&dispatch=5885d80a13c0db1f8e263663d3faee8d64813b57e559a2578463e58274899069
Tags: lightbox, video, responsive, modal, pop-up, gallery, images
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 1.5.1
Plugin Name: VenoBox Lightbox
Plugin URI: http://wpbeaches.com
Description: Responsive video and image pop-up lightbox
Author: Neil Gowran
Version: 1.5.1
Author URI: http://wpbeaches.com/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

This plugin adds the VenoBox Responsive Lightbox to links to display Vimeo and YouTube videos, images, galleries, iframe, inline content in a lightbox.


== Description ==

This plugin adds the VenoBox Responsive Lightbox to links, displaying YouTube and Vimeo videos, images, galleries, iframe, Google Maps or other inline content in a responsive lightbox display.

Plugin option to open all linked images and galleries in WordPress in Lightbox mode.

The big difference compared to many others plugins like this is that VenoBox calculates the max width of the image displayed and preserves its height if is taller than the window (so in small devices you can scroll down the content, avoiding vertical microscopic resized images).

Option to disable Beaver Builder lightbox plugin.

<a href="http://themes.wpbeaches.com/venobox/">Demo containing images and videos</a>

== Installation ==

This section describes how to install the plugin:

1. Upload the `venobox-lightbox` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Options are in Settings => Venobox Lightbox



== Usage ==

Comprehensive usage is documented in the WP Admin > Dashboard > Settings > VenoBox Lightbox.

There are manual markup instructions for videos and iframes and automated options for images.

Ability to enable/disable VenoBox gallery for images on a per post/page/custom post type level.

<a href="http://themes.wpbeaches.com/venobox/">Demo containing images and videos</a>


== Screenshots ==

1. VenoBox Lightbox Plugin Options

2. Lightbox interface

3. Post/Page metabox to toggle on/off

4. Choose between alt, title and caption as the Title for the lightbox Title.


== Changelog ==

= 1.5.1
* 3/11/18
* Add Beaver Builder filter to override magnificpopup light box


= 1.5.0
* 1/9/18
* Added support for FacetWP and Search & FIlter Pro - when pages are ajax refreshed the lightbox will continue to work - enable in options.


= 1.4.5
* 1/9/18
* Upgraded to core VenoBox 1.8.5


= 1.4.4
* 14/4/18
* Update wp-color-picker to 2.1.3
* Upgraded to core VenoBox 1.8.3
* Core version has additional spinner kits, spinner is hidden if a modal box is used
* Updated code on removing Beaver Builder lightbox magnificpopup with a later priority


= 1.4.3
* 17/11/17
* Update wp-color-picker to 2.1.2 to be compatible with WP 4.9


= 1.4.2
* 23/9/17
* Option to disable Beaver Builder lightbox if using the BB plugin. Note - if you are also using BB Theme itself then additionally you need to disable lightbox in Customizer.


= 1.4.1 =
* 16/7/17
* Higher z-index layer on lightbox overlay
* Re-work post metabox to disable VenoBox on a post/page basis, previous metabox conflict with Beaver Builder. Checkbox now positioned in Publish metabox area.
* Load minified scripts on admin settings page
* Swap tab order in settings - Plugin Options / Markup Instructions


= 1.4.0 =
* 7/7/17
* Upgraded to core VenoBox 1.8.2
* Added a legacy mark up box to update any manual data attributes code as the data attribute usage has changed.
* Position title and pagination top or bottom.
* Added pre-loader spinner choice.
* Change navigation and title colors.
* Ability to autoplay videos. Credit @codibit - https://github.com/codibit


= 1.3.7 =
* 12/11/16
* Changed the way the 'Disable VenoBox' metabox works from the post editor, now when VenoBox is disabled the styles and scripts won't load for that post/page, so better page load overall.


= 1.3.6 =
* 22/07/16
* Add option for inline content background color.
* Frame width and color only apply to images.
* Add option of "None" when setting Title value in lightbox mode.


= 1.3.5 =
* 16/07/16
* Add option for automatically enabling YouTube and Vimeo videos in lightbox mode.
* Refactored jQuery code.


= 1.3.4 =
* 12/07/16
* Fix for iframes scrolling issue on ios.
* Add support for Jetpack Tiled Galleries.


= 1.3.3 =
* 10/07/16
* Enhancement - if more than one WordPress gallery is on a page, each gallery will only show their own images when cycling through in the lightbox mode overlay.
* Fix - call close button more efficiently.


= 1.3.2 =
* 08/07/16
* Tweak - will not override attribute 'data-gall' if already set.
* Tweak - add in .jpeg images, if all images options is enabled.
* Link to more examples, online documentation.
* Add options for lightbox content to have a border and a border color.


= 1.3.1 =
* 06/07/16
* Fix - set text domain correctly.


= 1.3.0 =
* 05/07/16
* I18n ready - plugin internationalised.
* Higher z-index on lightbox overlay.
* Used more up to date mark up on Settings API.
* Added a wp_add_inline_style css.
* Added a styling option to change the generic lightbox background color supporting alpha transparency, in a rgba format.


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
