<?php
/**
 * VenoBox Lighbox
 *
 * @since  1.0.0
 *
 * @category  WordPress_Plugin
 * @package   VenoBox Lighbox
 * @author    Author: Neil Gowran, Nicola Franchini
 * @link      https://wordpress.org/plugins/venobox-lightbox/
 */

/**
 * Main plugin class
 *
 * @since  1.0.0
 */
class VenoBox_Lightbox {
	/**
	 * VenoBox js version
	 *
	 * @var version
	 */
	public $vb_version = '1.9.3';
	/**
	 * Holds an instance of the object
	 *
	 * @var VenoBox_Lightbox
	 */
	protected static $instance = null;
	/**
	 * Returns the running object
	 *
	 * @return VenoBox_Lightbox
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->hooks();
		}
		return self::$instance;
	}

	/**
	 * Init plugin
	 */
	public function __construct() {
		// Nothing here.
	}

	/**
	 * Initiate hooks
	 */
	public function hooks() {
		// Plugin text domain.
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'plugin_page' ) );
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );
		add_action( 'after_setup_theme', array( $this, 'vb_woocommerce_settings' ), 99 );


		// WP 3.0+.
		add_action( 'add_meta_boxes', array( $this, 'post_options_metabox' ) );
		add_action( 'save_post', array( $this, 'vbmeta_save' ) );
	}

	/**
	 * Add the venobox option metabox to all post types
	 */
	public function post_options_metabox() {
		add_meta_box( 'post_options', __( 'VenoBox Lightbox', 'venobox-lightbox' ), array( $this, 'vbmeta_create' ), get_post_types(), 'side', 'low' );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'venobox-lightbox', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}

	/**
	 * Setup JavaScript and CSS
	 */
	public function enqueue_scripts() {

		/* Get the current post ID. */
		$post_id = get_the_ID();
		$disable_venobox = get_post_meta( $post_id, '_venobox_check', true );

		$options = get_option( 'venobox_settings' );
		$options_default = array(
			'ng_numeratio'          => '',
			'ng_numeratio_position' => 'top',
			'ng_infinigall'         => '',
			'ng_all_images'         => '',
			'ng_title_select'       => 1,
			'ng_title_position'     => 'top',
			'ng_all_videos'         => '',
			'ng_border_width'       => '',
			'ng_border_color'       => 'rgba(255,255,255,1)',
			'ng_preloader'          => 'double-bounce',
			'ng_nav_elements'       => '#fff',
			'ng_nav_elements_bg'    => 'rgba(0,0,0,0.85)',
			'ng_autoplay'           => false,
			'ng_overlay'            => 'rgba(0,0,0,0.85)',
			'ng_bb_lightbox'        => false,
			'ng_vb_legacy_markup'   => false,
			'ng_vb_woocommerce'     => false,
			'ng_vb_facetwp'         => false,
			'ng_vb_searchfp'        => false,
			'ng_arrows'        		=> '',
			'ng_vb_share'           => array(),
		);
		$options = wp_parse_args( $options, $options_default );

		$debug = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';
		
		if( $disable_venobox=='' ){
		wp_enqueue_style( 'venobox-css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/venobox' . $debug . '.css', array(), $this->vb_version, 'all' );
		wp_enqueue_script( 'venobox-js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/venobox' . $debug . '.js', array( 'jquery' ), $this->vb_version, true );
		wp_register_script( 'venobox-init', plugin_dir_url( dirname( __FILE__ ) ) . 'js/venobox-init.js', array( 'venobox-js' ), VENOBOX_LIGHTBOX_VERSION, true );
		}

		// Disable jQuery MagnificPopUp used on BeaverBuilder.
		if ( $options['ng_bb_lightbox'] ) {
			add_action( 'wp_print_scripts', array( $this, 'remove_magnificpopup' ), 100 );
			add_filter( 'fl_builder_override_lightbox', '__return_true' );
		}

		 // Creating our jQuery variables here from our database options, these will be passed to jQuery init script via wp_localize_script.

		// adjust number to px value.
		$ng_border_width = isset( $options['ng_border_width'] ) ? $options['ng_border_width'] . 'px' : '';

		$data = array(
			'disabled' => $disable_venobox,
			'ng_numeratio'          => (bool) $options['ng_numeratio'],
			'ng_numeratio_position' => $options['ng_numeratio_position'],
			'ng_infinigall'         => (bool) $options['ng_infinigall'],
			'ng_all_images'         => (bool) $options['ng_all_images'],
			'ng_title_select'       => (int) $options['ng_title_select'],
			'ng_title_position'     => $options['ng_title_position'],
			'ng_all_videos'         => (bool) $options['ng_all_videos'],
			'ng_border_width'       => $ng_border_width,
			'ng_border_color'       => $options['ng_border_color'],
			'ng_autoplay'           => (bool) $options['ng_autoplay'],
			'ng_overlay'            => $options['ng_overlay'],
			'ng_nav_elements'       => $options['ng_nav_elements'],
			'ng_nav_elements_bg'    => $options['ng_nav_elements_bg'],
			'ng_preloader'          => $options['ng_preloader'],
			'ng_vb_legacy_markup'   => (bool) $options['ng_vb_legacy_markup'],
			'ng_vb_woocommerce'     => (bool) $options['ng_vb_woocommerce'],
			'ng_bb_lightbox'        => (bool) $options['ng_bb_lightbox'],
			'ng_vb_facetwp'         => (bool) $options['ng_vb_facetwp'],
			'ng_vb_searchfp'        => (bool) $options['ng_vb_searchfp'],
			'ng_arrows'        		=> (bool) $options['ng_arrows'],
			'ng_vb_share'           => $options['ng_vb_share'],

		);

		// Access variables from venobox-init using venoboxVars.
		wp_localize_script( 'venobox-init', 'venoboxVars', $data );
		wp_enqueue_script( 'venobox-init' );
	}

	/**
	 * Disable jQuery MagnificPopUp
	 */
	public function remove_magnificpopup() {
		wp_dequeue_script( 'jquery-magnificpopup' );
		wp_dequeue_style( 'jquery-magnificpopup' );
	}

	/**
	 * Add scripts in back-end for demo purpose.
	 *
	 * @param str $hook settings page.
	 */
	public function admin_scripts( $hook ) {
		if ( 'settings_page_venobox' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-venobox', plugin_dir_url( dirname( __FILE__ ) ) . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '3.0.0', true );
		wp_enqueue_style( 'venobox-css', plugin_dir_url( dirname( __FILE__ ) ) . 'css/venobox.min.css', array(), $this->vb_version, 'all' );
		wp_enqueue_script( 'venobox-js', plugin_dir_url( dirname( __FILE__ ) ) . 'js/venobox.min.js', array( 'jquery' ), $this->vb_version, true );
		wp_enqueue_script( 'venobox-init-admin', plugin_dir_url( dirname( __FILE__ ) ) . 'js/venobox-init-admin.js', array( 'venobox-js' ), VENOBOX_LIGHTBOX_VERSION, true );
		
	}

	/**
	 * Create the plugin option page.
	 */
	public function plugin_page() {
		add_options_page(
			__( 'VenoBox Lightbox Plugin', 'venobox-lightbox' ), // $page_title.
			__( 'VenoBox Lightbox', 'venobox-lightbox' ), // $menu_title.
			'manage_options', // $capability.
			'venobox', // $menu-slug.
			array( $this, 'plugin_options_page' ) // $function.
		);
	}

	/**
	 * Include the plugin option page.
	 */
	public function plugin_options_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( "Hall and Oates 'Say No Go'" );
		}
		require_once dirname( __FILE__ ) . '/options-page-wrapper.php';
	}

	/**
	 * Register our option fields
	 */
	public function plugin_settings() {
		register_setting(
			'ng_settings_group', // option name.
			'venobox_settings'// option group setting name and option name.
		);
		add_settings_section(
			'ng_venobox_section', // declare the section id.
			__( 'VenoBox Settings', 'venobox-lightbox' ), // page title.
			array( $this, 'ng_venobox_section_callback' ), // callback function below.
			'venobox' // page that it appears on.
		);
		add_settings_field(
			'ng_all_images', // unique id of field.
			__( 'Enable VenoBox for Images', 'venobox-lightbox' ), // title.
			array( $this, 'ng_all_images_callback' ), // callback function below.
			'venobox', // page that it appears on.
			'ng_venobox_section' // settings section declared in add_settings_section.
		);
		add_settings_field(
			'ng_title_select',
			__( 'Item Title', 'venobox-lightbox' ),
			array( $this, 'ng_title_select_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_title_position',
			__( 'Title Position', 'venobox-lightbox' ),
			array( $this, 'ng_title_position_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_numeratio',
			__( 'Gallery Numeration', 'venobox-lightbox' ),
			array( $this, 'ng_numeratio_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_numeratio_position',
			__( 'Numeration Position', 'venobox-lightbox' ),
			array( $this, 'ng_numeratio_position_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_infinigall',
			__( 'Infinite Gallery', 'venobox-lightbox' ),
			array( $this, 'ng_infinigall_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_arrows',
			__( 'Disable Arrow Navigation', 'venobox-lightbox' ),
			array( $this, 'ng_arrows_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_overlay',
			__( 'Overlay Color', 'venobox-lightbox' ),
			array( $this, 'ng_overlay_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_nav_elements',
			__( 'Navigation & Title Color', 'venobox-lightbox' ),
			array( $this, 'ng_nav_elements_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_nav_elements_bg',
			__( 'Title and share bar background', 'venobox-lightbox' ),
			array( $this, 'ng_nav_elements_bg_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_border_width',
			__( 'Frame Border Thickness', 'venobox-lightbox' ),
			array( $this, 'ng_border_width_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_border_color',
			__( 'Frame Border Color', 'venobox-lightbox' ),
			array( $this, 'ng_border_color_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_all_videos',
			__( 'Enable VenoBox for YouTube and Vimeo videos', 'venobox-lightbox' ),
			array( $this, 'ng_all_videos_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_autoplay',
			__( 'Autoplay', 'venobox-lightbox' ),
			array( $this, 'ng_autoplay_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_preloader',
			__( 'Preloader Type', 'venobox-lightbox' ),
			array( $this, 'ng_preloader_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_vb_share',
			__( 'Share Buttons', 'venobox-lightbox' ),
			array( $this, 'ng_vb_share_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_vb_woocommerce',
			__( 'Support WooCommerce', 'venobox-lightbox' ),
			array( $this, 'ng_vb_woocommerce_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_vb_facetwp',
			__( 'Support FacetWP', 'venobox-lightbox' ),
			array( $this, 'ng_vb_facetwp_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_vb_searchfp',
			__( 'Support Search & Filter Pro', 'venobox-lightbox' ),
			array( $this, 'ng_vb_searchfp_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_bb_lightbox',
			__( 'Disable Beaver Builder Lightbox', 'venobox-lightbox' ),
			array( $this, 'ng_bb_lightbox_callback' ),
			'venobox',
			'ng_venobox_section'
		);
		add_settings_field(
			'ng_vb_legacy_markup',
			__( 'Update Legacy Attributes', 'venobox-lightbox' ),
			array( $this, 'ng_vb_legacy_markup_callback' ),
			'venobox',
			'ng_venobox_section'
		);
	}

	/**
	 * Register our section call back
	 * (not much happening here)
	 */
	public function ng_venobox_section_callback() {

	}



	/**
	 *  Add Lightbox for all images and galleries
	 */
	public function ng_all_images_callback() {

		$options = get_option( 'venobox_settings' );
		$ng_all_images = isset( $options['ng_all_images'] ) ? $options['ng_all_images'] : '';
		?>
		<fieldset>
			<label for="ng_all_images">
				<input name="venobox_settings[ng_all_images]" type="checkbox" id="ng_all_images" value="1" <?php checked( 1, $ng_all_images, true ); ?> />
				<span><?php esc_attr_e( 'Add Lightbox for all linked images & galleries', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 *  Add Lightbox for all videos
	 */
	public function ng_all_videos_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_all_videos = isset( $options['ng_all_videos'] ) ? $options['ng_all_videos'] : '';
		?>
		<fieldset>
			<label for="ng_all_videos">
				<input name="venobox_settings[ng_all_videos]" type="checkbox" id="ng_all_videos" value="1" <?php checked( 1, $ng_all_videos, true ); ?> />
				<span><?php esc_attr_e( 'Add Lightbox for all the links to YouTube and Vimeo videos', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Add Option to autoplay videos
	 * Credit @codibit - @link https://github.com/codibit
	 *
	 * @link https://github.com/neilgee/venobox/pull/1/commits/52319bbd7612752428ca5766fb359d14e0439b28
	 */
	public function ng_autoplay_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_autoplay = isset( $options['ng_autoplay'] ) ? $options['ng_autoplay'] : '';
		?>
		<fieldset>
			<label for="ng_autoplay">
				<input name="venobox_settings[ng_autoplay]" type="checkbox" id="ng_autoplay" value="1" <?php checked( 1, $ng_autoplay, true ); ?> />
				<span><?php esc_attr_e( 'Autoplay videos', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 *  Choose either alt or title attribute or caption value for lightbox title value
	 */
	public function ng_title_select_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_title_select = isset( $options['ng_title_select'] ) ? $options['ng_title_select'] : '';
		?>
		<fieldset>
			<label title='g:i a'>
				<input type="radio" name="venobox_settings[ng_title_select]" value="1" <?php checked( 1, $ng_title_select, true ); ?> />
				<span><?php esc_attr_e( 'ALT text value', 'venobox-lightbox' ); ?></span>
			</label><br>
			<label title='g:i a'>
				<input type="radio" name="venobox_settings[ng_title_select]" value="2" <?php checked( 2, $ng_title_select, true ); ?> />
				<span><?php esc_attr_e( 'Title text value', 'venobox-lightbox' ); ?></span>
			</label><br>
			<label title='g:i a'>
				<input type="radio" name="venobox_settings[ng_title_select]" value="3" <?php checked( 3, $ng_title_select, true ); ?> />
				<span><?php esc_attr_e( 'Caption text value', 'venobox-lightbox' ); ?></span>
			</label><br>
			<label title='g:i a'>
				<input type="radio" name="venobox_settings[ng_title_select]" value="4" <?php checked( 4, $ng_title_select, true ); ?> />
				<span><?php esc_attr_e( 'None', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 *  Position title - top or bottom
	 */
	public function ng_title_position_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_title_position = isset( $options['ng_title_position'] ) ? $options['ng_title_position'] : 'top';
		?>
		<select name="venobox_settings[ng_title_position]" id="ng_title_position">
			<option value="top" <?php selected( $ng_title_position, 'top' ); ?>>top</option>
			<option value="bottom" <?php selected( $ng_title_position, 'bottom' ); ?>>bottom</option>
		</select>
		<?php
	}

	/**
	 *  Add Pagination to Lightbox Head for multiple items on page
	 */
	public function ng_numeratio_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_numeratio = isset( $options['ng_numeratio'] ) ? $options['ng_numeratio'] : '';
		?>
		<fieldset>
			<label for="ng_numeratio">
				<input name="venobox_settings[ng_numeratio]" type="checkbox" id="ng_numeratio" value="1" <?php checked( 1, $ng_numeratio, true ); ?> />
				<span><?php esc_attr_e( 'Show Pagination for Multiple Items', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 *  Disable Arrow Previous & Next
	 */
	public function ng_arrows_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_arrows = isset( $options['ng_arrows'] ) ? $options['ng_arrows'] : '';
		?>
		<fieldset>
			<label for="ng_arrows">
				<input name="venobox_settings[ng_arrows]" type="checkbox" id="ng_arrows" value="1" <?php checked( 1, $ng_arrows, true ); ?> />
				<span><?php esc_attr_e( 'Disable Previous & Next Arrows', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}


	/**
	 *  Position Pagination - top or bottom
	 */
	public function ng_numeratio_position_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_numeratio_position = isset( $options['ng_numeratio_position'] ) ? $options['ng_numeratio_position'] : 'top';
		?>
		<select name="venobox_settings[ng_numeratio_position]" id="ng_numeratio_position">
			<option value="top" <?php selected( $ng_numeratio_position, 'top' ); ?>>top</option>
			<option value="bottom" <?php selected( $ng_numeratio_position, 'bottom' ); ?>>bottom</option>
		</select>
		<?php
	}

	/**
	 *  Add Infinite gallery previous and next to Lightbox Head for multiple items on page
	 */
	public function ng_infinigall_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_infinigall = isset( $options['ng_infinigall'] ) ? $options['ng_infinigall'] : '';
		?>
		<fieldset>
			<label for="ng_infinigall">
				<input name="venobox_settings[ng_infinigall]" type="checkbox" id="ng_infinigall" value="1" <?php checked( 1, $ng_infinigall, true ); ?> />
				<span><?php esc_attr_e( 'Allow continous navigation, jumping from last to first item and vice versa', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 *  Add default rgba overlay color
	 *
	 * @link https://github.com/23r9i0/wp-color-picker-alpha/blob/master/dist/wp-color-picker-alpha.min.js
	 */
	public function ng_overlay_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_overlay = isset( $options['ng_overlay'] ) ? $options['ng_overlay'] : 'rgba(0,0,0,0.85)';
		?>
		<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)" name="venobox_settings[ng_overlay]" value="<?php echo esc_attr( $ng_overlay ); ?>"/>
		<?php
	}

	/**
	 *  Add Navigation & Title color
	 */
	public function ng_nav_elements_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_nav_elements = isset( $options['ng_nav_elements'] ) ? $options['ng_nav_elements'] : '#fff';
		?>
		<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(255,255,255,1)" name="venobox_settings[ng_nav_elements]" value="<?php echo esc_attr( $ng_nav_elements ); ?>"/>
		<?php
	}

	/**
	 *  Add Navigation & Title background
	 */
	public function ng_nav_elements_bg_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_nav_elements_bg = isset( $options['ng_nav_elements_bg'] ) ? $options['ng_nav_elements_bg'] : 'rgba(0,0,0,0.85)';
		?>
		<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(0,0,0,0.85)" name="venobox_settings[ng_nav_elements_bg]" value="<?php echo esc_attr( $ng_nav_elements_bg ); ?>"/>
		<?php
	}

	/**
	 *  Add default border width for content
	 */
	public function ng_border_width_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_border_width = isset( $options['ng_border_width'] ) ? $options['ng_border_width'] : '';
		?>
		<input type="number" class="regular-text" name="venobox_settings[ng_border_width]" value="<?php echo esc_attr( $ng_border_width ); ?>"/>
		<?php
	}

	/**
	 *  Add default border color for content
	 */
	public function ng_border_color_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_border_color = isset( $options['ng_border_color'] ) ? $options['ng_border_color'] : 'rgba(255,255,255,1)';
		?>
		<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(255,255,255,1)" name="venobox_settings[ng_border_color]" value="<?php echo esc_attr( $ng_border_color ); ?>"/>
		<?php
	}

	/**
	 *  Add Preloader Icon
	 */
	public function ng_preloader_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_preloader = isset( $options['ng_preloader'] ) ? $options['ng_preloader'] : '';
		?>
		<select name="venobox_settings[ng_preloader]" id="ng_preloader">
			<option value="none"<?php selected( $ng_preloader, 'none' ); ?> >none</option>
			<option value="double-bounce"<?php selected( $ng_preloader, 'double-bounce' ); ?>>double-bounce</option>
			<option value="rotating-plane"<?php selected( $ng_preloader, 'rotating-plane' ); ?>>rotating-plane</option>
			<option value="wave"<?php selected( $ng_preloader, 'wave' ); ?> >wave</option>
			<option value="wandering-cubes"<?php selected( $ng_preloader, 'wandering-cubes' ); ?>>wandering-cubes</option>
			<option value="spinner-pulse"<?php selected( $ng_preloader, 'spinner-pulse' ); ?>>spinner-pulse</option>
			<option value="three-bounce"<?php selected( $ng_preloader, 'three-bounce' ); ?>>three-bounce</option>
			<option value="cube-grid"<?php selected( $ng_preloader, 'cube-grid' ); ?>>cube-grid</option>
			<option value="chasing-dots"<?php selected( $ng_preloader, 'chasing-dots' ); ?>>chasing-dots</option>
			<?php
			/**
			 * // Disable these because we cant assign custom color via js to :after pseudo elements
			<option value="circle"<?php selected( $ng_preloader, 'circle' ); ?>>circle</option>
			<option value="fading-circle"<?php selected( $ng_preloader, 'fading-circle' ); ?>>fading-circle</option>
			<option value="folding-cube"<?php selected( $ng_preloader, 'folding-cube' ); ?>>folding-cube</option>
			 */
			?>
		</select>
		<?php
	}

	/**
	 * Social share buttons
	 */
	public function ng_vb_share_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_share = isset( $options['ng_vb_share'] ) ? (array) $options['ng_vb_share'] : [];
		?>
		<fieldset>
			<label for="ng_vb_share_facebook">
				<input type='checkbox' name='venobox_settings[ng_vb_share][]' id="ng_vb_share_facebook" <?php checked( in_array( 'facebook', $ng_vb_share ), 1 ); ?> value='facebook'>
				<span><?php esc_attr_e( 'Facebook', 'venobox_settings' ); ?></span>
			</label><br>
			<label for="ng_vb_share_twitter">
				<input type='checkbox' name='venobox_settings[ng_vb_share][]' id="ng_vb_share_twitter" <?php checked( in_array( 'twitter', $ng_vb_share ), 1 ); ?> value='twitter'>
				<span><?php esc_attr_e( 'Twitter', 'venobox_settings' ); ?></span>
			</label><br>
			<label for="ng_vb_share_pinterest">
				<input type='checkbox' name='venobox_settings[ng_vb_share][]' id="ng_vb_share_pinterest" <?php checked( in_array( 'pinterest', $ng_vb_share ), 1 ); ?> value='pinterest'>
				<span><?php esc_attr_e( 'Pinterest', 'venobox_settings' ); ?></span>
			</label><br>
			<label for="ng_vb_share_linkedin">
				<input type='checkbox' name='venobox_settings[ng_vb_share][]' id="ng_vb_share_linkedin" <?php checked( in_array( 'linkedin', $ng_vb_share ), 1 ); ?> value='linkedin'>
				<span><?php esc_attr_e( 'LinkedIn', 'venobox_settings' ); ?></span>
			</label><br>
			<label for="ng_vb_share_download">
				<input type='checkbox' name='venobox_settings[ng_vb_share][]' id="ng_vb_share_download" <?php checked( in_array( 'download', $ng_vb_share ), 1 ); ?> value='download'>
				<span><?php esc_attr_e( 'Download', 'venobox_settings' ); ?></span>
			</label>
		</fieldset>
		<p><?php esc_attr_e( 'Share buttons available for images and videos', 'venobox-lightbox' ); ?></p>
		<?php
	}

	/**
	 * Update legacy ,markup for data attributes
	 */
	public function ng_vb_legacy_markup_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_legacy_markup = isset( $options['ng_vb_legacy_markup'] ) ? $options['ng_vb_legacy_markup'] : '';
		?>
		<fieldset>
			<label for="ng_vb_legacy_markup">
				<input name="venobox_settings[ng_vb_legacy_markup]" type="checkbox" id="ng_vb_legacy_markup" value="1" <?php checked( 1, $ng_vb_legacy_markup, true ); ?> />
				<span><?php esc_attr_e( 'Update legacy Data Attributes', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Disable Beaver Builder Lightbox
	 */
	public function ng_bb_lightbox_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_bb_lightbox = isset( $options['ng_bb_lightbox'] ) ? $options['ng_bb_lightbox'] : '';
		?>
		<fieldset>
			<label for="ng_bb_lightbox">
				<input name="venobox_settings[ng_bb_lightbox]" type="checkbox" id="ng_bb_lightbox" value="1" <?php checked( 1, $ng_bb_lightbox, true ); ?> />
				<span><?php esc_attr_e( 'Disable Beaver Builder Lightbox', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Support for FacetWP
	 */
	public function ng_vb_facetwp_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_facetwp = isset( $options['ng_vb_facetwp'] ) ? $options['ng_vb_facetwp'] : '';
		?>
		<fieldset>
			<label for="ng_vb_facetwp">
				<input name="venobox_settings[ng_vb_facetwp]" type="checkbox" id="ng_vb_facetwp" value="1" <?php checked( 1, $ng_vb_facetwp, true ); ?> />
				<span><?php esc_attr_e( 'Support for FacetWP', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Support for Search & Filter Pro
	 */
	public function ng_vb_searchfp_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_searchfp = isset( $options['ng_vb_searchfp'] ) ? $options['ng_vb_searchfp'] : '';
		?>
		<fieldset>
			<label for="ng_vb_searchfp">
				<input name="venobox_settings[ng_vb_searchfp]" type="checkbox" id="ng_vb_searchfp" value="1" <?php checked( 1, $ng_vb_searchfp, true ); ?> />
				<span><?php esc_attr_e( 'Support for Search & Filter Pro', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Support for WooCommerce
	 */
	public function ng_vb_woocommerce_callback() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_woocommerce = isset( $options['ng_vb_woocommerce'] ) ? $options['ng_vb_woocommerce'] : '';
		?>
		<fieldset>
			<label for="ng_vb_woocommerce">
				<input name="venobox_settings[ng_vb_woocommerce]" type="checkbox" id="ng_vb_woocommerce" value="1" <?php checked( 1, $ng_vb_woocommerce, true ); ?> />
				<span><?php esc_attr_e( 'Support for WooCommerce', 'venobox-lightbox' ); ?></span>
			</label>
		</fieldset>
		<?php
	}

	/**
	 * Include WooCommerce Settings
	 * Remove Supports for zoom/slider/gallery
	 * @since 2.0.7
	 */
	public function vb_woocommerce_settings() {
		$options = get_option( 'venobox_settings' );
		$ng_vb_woocommerce = isset( $options['ng_vb_woocommerce'] ) ? $options['ng_vb_woocommerce'] : '';

		if ( class_exists( 'WooCommerce' ) && $ng_vb_woocommerce == '1') {
			remove_theme_support( 'wc-product-gallery-zoom' );
			remove_theme_support( 'wc-product-gallery-lightbox' );
			remove_theme_support( 'wc-product-gallery-slider' );
		}
	}

	/**
	 * Create VenoBox Meta
	 *
	 * @link https://gist.github.com/emilysnothere/943ea6274dc160cec271
	 */
	public function vbmeta_create() {
		$post_id = get_the_ID();
		$value = get_post_meta( $post_id, '_venobox_check', true );
		wp_nonce_field( 'venobox_nonce_' . $post_id, 'venobox_nonce' );
		?>
		<div class="misc-pub-section misc-pub-section-last">
			<label><input type="checkbox" value="1" <?php checked( $value, true, true ); ?> name="_venobox_check" /><?php esc_attr_e( 'Disable VenoBox', 'venobox' ); ?></label>
		</div>
		<?php
	}

	/**
	 * Save VenoBox Meta
	 *
	 * @param int $post_id post ID.
	 */
	public function vbmeta_save( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$venobox_nonce = filter_input( INPUT_POST, 'venobox_nonce', FILTER_SANITIZE_STRING );
		if ( ! $venobox_nonce || ! wp_verify_nonce( $venobox_nonce, 'venobox_nonce_' . $post_id ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$venobox_check = filter_input( INPUT_POST, '_venobox_check', FILTER_SANITIZE_STRING );
		if ( $venobox_check ) {
			update_post_meta( $post_id, '_venobox_check', $venobox_check );
		} else {
			delete_post_meta( $post_id, '_venobox_check' );
		}
	}

}

/**
 * Helper function to get/return the VenoBox_Lightbox object
 *
 * @return VenoBox_Lightbox object
 */
function venobox_lightbox() {
	return VenoBox_Lightbox::get_instance();
}