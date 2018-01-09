<?php
/**
 * "The universe is vast and we are so small. There is only one thing we can ever truly control...Whether
 * we are good or evil." ~ Oma Desala (Stargate SG-1)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Stargazer
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for launching the theme and setup configuration.
 *
 * @since  4.0.0
 * @access public
 */
final class Stargazer_Theme {

	/**
	 * Directory path to the theme folder.
	 *
	 * @since  4.0.0
	 * @access public
	 * @var    string
	 */
	public $dir = '';

	/**
	 * Directory URI to the theme folder.
	 *
	 * @since  4.0.0
	 * @access public
	 * @var    string
	 */
	public $uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  4.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Initial theme setup.
	 *
	 * @since  4.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		$this->dir = trailingslashit( get_template_directory()     );
		$this->uri = trailingslashit( get_template_directory_uri() );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  4.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Load the Hybrid Core framework and theme files.
		require_once( $this->dir . 'library/hybrid.php' );

		// Load theme includes.
		require_once( $this->dir . 'inc/class-custom-colors.php'  );
		require_once( $this->dir . 'inc/class-customize.php'      );
		require_once( $this->dir . 'inc/template.php'             );
		require_once( $this->dir . 'inc/functions-attr.php'       );
		require_once( $this->dir . 'inc/functions-filters.php'    );
		require_once( $this->dir . 'inc/functions-scripts.php'    );
		require_once( $this->dir . 'inc/functions-deprecated.php' );
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  4.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Theme setup.
		add_action( 'after_setup_theme', array( $this, 'theme_setup'             ),  5 );
		add_action( 'after_setup_theme', array( $this, 'custom_header_setup'     ), 15 );
		add_action( 'after_setup_theme', array( $this, 'custom_background_setup' ), 15 );

		// Register menus.
		add_action( 'init', array( $this, 'register_menus' ) );

		// Register image sizes.
		add_action( 'init', array( $this, 'register_image_sizes' ) );

		// Register sidebars.
		add_action( 'widgets_init', array( $this, 'register_sidebars' ), 5 );

		// Register layouts.
		add_action( 'hybrid_register_layouts', array( $this, 'register_layouts' ) );

		// Register scripts, styles, and fonts.
		add_action( 'wp_enqueue_scripts',    array( $this, 'register_scripts' ), 0 );
		add_action( 'enqueue_embed_scripts', array( $this, 'register_scripts' ), 0 );
	}

	/**
	 * The theme setup function.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function theme_setup() {

		// Theme layouts.
		add_theme_support( 'theme-layouts', array( 'default' => '2c-l' ) );

		// Enable custom template hierarchy.
		add_theme_support( 'hybrid-core-template-hierarchy' );

		// The best thumbnail/image script ever.
		add_theme_support( 'get-the-image' );

		// Breadcrumbs. Yay!
		add_theme_support( 'breadcrumb-trail' );

		// Nicer [gallery] shortcode implementation.
		add_theme_support( 'cleaner-gallery' );

		// Automatically add feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// Support selective refresh of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Whistles plugin.
		add_theme_support( 'whistles', array( 'styles' => true ) );

		// Post formats.
		add_theme_support(
			'post-formats',
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' )
		);

		// Adds custom logo support
		add_theme_support(
			'custom-logo',
			array(
				'height'     => 78,
				'flex-width' => true
			)
		);

		// Gutenberg editor support.
		add_theme_support( 'editor-color-palette', '#cc4a00', '#252525', '#2d2d2d', '#ffffff' );

		add_theme_support( 'gutenberg',
			array(
				'colors' => array( '#cc4a00', '#252525', '#2d2d2d', '#ffffff' ),
			)
		);

		// Handle content width for embeds and images.
		// Note: this is the largest size based on the theme's various layouts.
		hybrid_set_content_width( 1025 );
	}

	/**
	 * Adds support for the WordPress 'custom-header' theme feature.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function custom_header_setup() {

		// Adds support for WordPress' "custom-header" feature.
		add_theme_support(
			'custom-header',
			array(
				'default-image'          => '%s/images/headers/orange-burn.jpg',
				'random-default'         => false,
				'width'                  => 1175,
				'height'                 => 400,
				'flex-width'             => true,
				'flex-height'            => true,
				'default-text-color'     => '252525',
				'header-text'            => true,
				'uploads'                => true,
				'wp-head-callback'       => 'stargazer_custom_header_wp_head'
			)
		);

		// Registers default headers for the theme.
		register_default_headers(
			array(
				'horizon' => array(
					'url'           => '%s/images/headers/horizon.jpg',
					'thumbnail_url' => '%s/images/headers/horizon-thumb.jpg',
					// Translators: Header image description.
					'description'   => __( 'Horizon', 'stargazer' )
				),
				'orange-burn' => array(
					'url'           => '%s/images/headers/orange-burn.jpg',
					'thumbnail_url' => '%s/images/headers/orange-burn-thumb.jpg',
					// Translators: Header image description.
					'description'   => __( 'Orange Burn', 'stargazer' )
				),
				'planets-blue' => array(
					'url'           => '%s/images/headers/planets-blue.jpg',
					'thumbnail_url' => '%s/images/headers/planets-blue-thumb.jpg',
					// Translators: Header image description.
					'description'   => __( 'Blue Planets', 'stargazer' )
				),
				'planet-burst' => array(
					'url'           => '%s/images/headers/planet-burst.jpg',
					'thumbnail_url' => '%s/images/headers/planet-burst-thumb.jpg',
					// Translators: Header image description.
					'description'   => __( 'Planet Burst', 'stargazer' )
				),
				'space-splatters' => array(
					'url'           => '%s/images/headers/space-splatters.jpg',
					'thumbnail_url' => '%s/images/headers/space-splatters-thumb.jpg',
					// Translators: Header image description.
					'description'   => __( 'Space Splatters', 'stargazer' )
				),
			)
		);
	}

	/**
	 * Adds support for the WordPress 'custom-background' theme feature.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function custom_background_setup() {

		add_theme_support(
			'custom-background',
			array(
				'default-color'    => '2d2d2d',
				'default-image'    => '',
				'wp-head-callback' => 'stargazer_custom_background_callback',
			)
		);
	}

	/**
	 * Registers nav menus.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function register_menus() {

		register_nav_menu( 'primary',   _x( 'Primary',   'nav menu location', 'stargazer' ) );
		register_nav_menu( 'secondary', _x( 'Secondary', 'nav menu location', 'stargazer' ) );
		register_nav_menu( 'social',    _x( 'Social',    'nav menu location', 'stargazer' ) );
	}

	/**
	 * Registers image sizes.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function register_image_sizes() {

		// Sets the 'post-thumbnail' size.
		set_post_thumbnail_size( 175, 131, true );

		// Adds the 'stargazer-full' image size.
		add_image_size( 'stargazer-full', 1025, 500, false );
	}

	/**
	 * Registers sidebars.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	function register_sidebars() {

		hybrid_register_sidebar(
			array(
				'id'          => 'primary',
				'name'        => _x( 'Primary', 'sidebar', 'stargazer' ),
				'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'stargazer' )
			)
		);

		hybrid_register_sidebar(
			array(
				'id'          => 'subsidiary',
				'name'        => _x( 'Subsidiary', 'sidebar', 'stargazer' ),
				'description' => __( 'A sidebar located in the footer of the site. Optimized for one, two, or three widgets (and multiples thereof).', 'stargazer' )
			)
		);
	}

	/**
	 * Registers layouts.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function register_layouts() {

		hybrid_register_layout( '1c',        array( 'label' => __( '1 Column Wide',                'stargazer' ), 'image' => '%s/images/layouts/1c.png' ) );
		hybrid_register_layout( '1c-narrow', array( 'label' => __( '1 Column Narrow',              'stargazer' ), 'image' => '%s/images/layouts/1c-narrow.png' ) );
		hybrid_register_layout( '2c-l',      array( 'label' => __( '2 Columns: Content / Sidebar', 'stargazer' ), 'image' => '%s/images/layouts/2c-l.png' ) );
		hybrid_register_layout( '2c-r',      array( 'label' => __( '2 Columns: Sidebar / Content', 'stargazer' ), 'image' => '%s/images/layouts/2c-r.png' ) );
	}

	/**
	 * Registers scripts/styles.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function register_scripts() {

		$suffix = hybrid_get_min_suffix();

		// Scripts.
		wp_register_script( 'stargazer', trailingslashit( get_template_directory_uri() ) . "js/stargazer{$suffix}.js", array( 'jquery' ), null, true );

		wp_localize_script(
			'stargazer',
			'stargazer_i18n',
			array(
				'search_toggle' => __( 'Expand Search Form', 'stargazer' )
			)
		);

		// Fonts.
		hybrid_register_font( 'stargazer', array(
			'family' => array(
				'droid-serif' => 'Droid+Serif:400,700,400italic,700italic',
				'open-sans'   => 'Open+Sans:300,400,600,700'
			),
			'subset' => array( 'latin', 'latin-ext' )
		) );

		// Styles.
		wp_deregister_style( 'mediaelement' );
		wp_deregister_style( 'wp-mediaelement' );

		wp_register_style( 'stargazer-mediaelement', trailingslashit( get_template_directory_uri() ) . "css/mediaelement{$suffix}.css" );
		wp_register_style( 'stargazer-media',        trailingslashit( get_template_directory_uri() ) . "css/media{$suffix}.css" );
		wp_register_style( 'stargazer-embed',        trailingslashit( get_template_directory_uri() ) . "css/embed{$suffix}.css" );

		// Registering locale style for embeds. @see https://core.trac.wordpress.org/ticket/36839
		wp_register_style( 'stargazer-locale', get_locale_stylesheet_uri() );
	}
}

/**
 * Gets the instance of the `Stargazer_Theme` class.  This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  4.0.0
 * @access public
 * @return object
 */
function stargazer_theme() {
	return Stargazer_Theme::get_instance();
}

// Let's roll!
stargazer_theme();
