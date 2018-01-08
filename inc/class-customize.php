<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  4.0.0
 * @access public
 */
final class Stargazer_Customize {

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
	 * Sets up initial actions.
	 *
	 * @since  4.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'panels'   ) );
		add_action( 'customize_register', array( $this, 'sections' ) );
		add_action( 'customize_register', array( $this, 'settings' ) );
		add_action( 'customize_register', array( $this, 'controls' ) );
		add_action( 'customize_register', array( $this, 'partials' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_control_scripts' ), 0 );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'preview_enqueue' ) );
	}

	/**
	 * Sets up the customizer panels.
	 *
	 * @since  4.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function panels( $manager ) {

		$manager->add_panel(
			'theme_options',
			array(
				'priority' => 5,
				'title'    => __( 'Theme Options', 'stargazer' )
			)
		);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  4.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( stargazer_theme()->dir . 'inc/customize/section-locked.php' );

		// Register custom section types.
		$manager->register_section_type( 'Stargazer_Customize_Section_Locked' );

		// Move theme-specific sections to our theme options panel.
		$manager->get_section( 'header_image' )->panel     = 'theme_options';
		$manager->get_section( 'background_image' )->panel = 'theme_options';
		$manager->get_section( 'layout' )->panel           = 'theme_options';
		$manager->get_section( 'colors' )->panel           = 'theme_options';

		/* === Custom Sections === */

		$manager->add_section(
			new Stargazer_Customize_Section_Locked(
				$manager,
				'pro_options',
				array(
					'panel'           => 'theme_options',
					'priority'        => 995,
					'title'           => esc_html__( 'Go Pro', 'stargazer' ),
					'button'          => esc_html__( 'Unlock', 'stargazer' ),
					'active_callback' => array( $this, 'show_pro_options' )
				)
			)
		);
	}

	/**
	 * Sets up the customizer settings.
	 *
	 * @since  4.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function settings( $manager ) {

		// Set the transport property of existing settings.
		$manager->get_setting( 'blogname' )->transport              = 'postMessage';
		$manager->get_setting( 'blogdescription' )->transport       = 'postMessage';
		$manager->get_setting( 'header_textcolor' )->transport      = 'postMessage';
		$manager->get_setting( 'header_image' )->transport          = 'postMessage';
		$manager->get_setting( 'background_color' )->transport      = 'postMessage';
		$manager->get_setting( 'background_image' )->transport      = 'postMessage';
		$manager->get_setting( 'background_position_x' )->transport = 'postMessage';
		$manager->get_setting( 'background_repeat' )->transport     = 'postMessage';
		$manager->get_setting( 'background_attachment' )->transport = 'postMessage';

		/* === Pro === */

		$manager->add_setting( new WP_Customize_Filter_Setting( $manager, 'go_pro' ) );
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @since  4.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function controls( $manager ) {

		// Load custom controls.
		require_once( stargazer_theme()->dir . 'inc/customize/control-custom-html.php' );

		// Register custom control types.
		$manager->register_control_type( 'Stargazer_Customize_Control_Custom_HTML' );

		/* === Pro Options === */

		$manager->add_control(
			new Stargazer_Customize_Control_Custom_HTML(
				$manager,
				'go_pro',
				array(
					'section' => 'pro_options',
					'label'   => esc_html__( 'Go Pro', 'stargazer' ),
					'html'    => $this->get_custom_control_html()
				)
			)
		);
	}

	/**
	 * Sets up the customizer partials.
	 *
	 * @since  4.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function partials( $manager ) {}

	/**
	 * Whether to show the pro options.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return bool
	 */
	public function show_pro_options() {

		return true;//! stargazer_is_pro();
	}

	/**
	 * Returns the HTML for the custom HTML control.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return string
	 */
	public function get_custom_control_html() {

		$html = sprintf(
			'<p>%s</p>
			 <p>%s</p>
			 <p><a class="button button-primary" href="https://themehybrid.com" target="_blank">%s</a></p>',
			__( 'I have never been a fan of crippleware (i.e., "lite" themes) that upsell you all the cool stuff. With the Stargazer theme, you get the full theme.', 'stargazer' ),
			__( 'Instead, let me offer you a full year of dedicated support (forums and live chat). This includes support for all of my themes and plugins.', 'stargazer' ),
			__( 'Join The Club', 'stargazer' )
		);

		return $html;
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function register_control_scripts() {

		wp_register_script( 'stargazer-customize-controls', trailingslashit( get_template_directory_uri() ) . 'css/customize-controls.js', array( 'customize-controls' ), null, true );

		wp_register_style( 'stargazer-customize-controls', trailingslashit( get_template_directory_uri() ) . 'css/customize-controls.css' );
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @since  4.0.0
	 * @access public
	 * @return void
	 */
	public function preview_enqueue() {

		// Use the .min script if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'stargazer-customize',
			trailingslashit( get_template_directory_uri() ) . "js/customize{$suffix}.js",
			array( 'jquery' ),
			null,
			true
		);
	}
}

// Doing this customizer thang!
Stargazer_Customize::get_instance();
