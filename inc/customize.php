<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Theme Customizer setup.
add_action( 'customize_register', 'stargazer_customize_register' );

// Register scripts and styles for the controls.
add_action( 'customize_controls_enqueue_scripts', 'stargazer_register_control_scripts', 0 );


function stargazer_register_control_scripts() {

	wp_enqueue_script( 'stargazer-customize-controls', get_template_directory_uri() . '/js/customize-controls.js', array( 'customize-controls' ), null, true );

	wp_enqueue_style( 'stargazer-customize-controls',  get_template_directory_uri() . '/css/customize-controls.css' );
}

/**
 * Sets up the theme customizer sections, controls, and settings.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $manager
 * @return void
 */
function stargazer_customize_register( $manager ) {

	// Load JavaScript files.
	add_action( 'customize_preview_init', 'stargazer_enqueue_customizer_scripts' );

	// Enable live preview for WordPress theme features.
	$manager->get_setting( 'blogname' )->transport              = 'postMessage';
	$manager->get_setting( 'blogdescription' )->transport       = 'postMessage';
	$manager->get_setting( 'header_textcolor' )->transport      = 'postMessage';
	$manager->get_setting( 'header_image' )->transport          = 'postMessage';
	$manager->get_setting( 'background_color' )->transport      = 'postMessage';
	$manager->get_setting( 'background_image' )->transport      = 'postMessage';
	$manager->get_setting( 'background_position_x' )->transport = 'postMessage';
	$manager->get_setting( 'background_repeat' )->transport     = 'postMessage';
	$manager->get_setting( 'background_attachment' )->transport = 'postMessage';


	/* === Panels === */

	$manager->add_panel(
		'theme_options',
		array(
			'priority' => 5,
			'title'    => __( 'Theme Options', 'stargazer' )
		)
	);

	/* === Sections === */

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'inc/customize/section-locked.php' );

		// Register custom section types.
		$manager->register_section_type( 'Stargazer_Customize_Section_Locked' );


	// Move theme-specific sections to our theme options panel.
	$manager->get_section( 'header_image' )->panel     = 'theme_options';
	$manager->get_section( 'background_image' )->panel = 'theme_options';
	$manager->get_section( 'layout' )->panel           = 'theme_options';
	$manager->get_section( 'colors' )->panel           = 'theme_options';

	$manager->add_section(
		new Stargazer_Customize_Section_Locked(
			$manager,
			'pro_options',
			array(
				'panel'           => 'theme_options',
				'priority'        => 995,
				'title'           => esc_html__( 'Go Pro', 'stargazer' ),
				'button'          => esc_html__( 'Unlock', 'stargazer' ),
			//	'active_callback' => '__return_true'
			)
		)
	);

		// Load custom controls.
		require_once( trailingslashit( get_template_directory() ) . 'inc/customize/control-custom-html.php' );

		// Register custom control types.
		$manager->register_control_type( 'Stargazer_Customize_Control_Custom_HTML' );


		$manager->add_control(
			'show_header_icon',
			array(
				'label'           => esc_html__( 'Always Display Header Icon', 'extant' ),
				'description'     => __( 'Icon is only shown on mobile devices by default.', 'extant' ),
				'section'         => 'pro_options',
				'type'            => 'checkbox'
			)
		);


		$manager->add_setting( new WP_Customize_Filter_Setting( $manager, 'go_pro' ) );
		$manager->add_control(
			new Stargazer_Customize_Control_Custom_HTML(
				$manager,
				'go_pro',
				array(
					'section' => 'pro_options',
					'label'   => esc_html__( 'Go Pro', 'extant' ),
					'html'    => stargazer_get_custom_control_html()
				)
			)
		);
}

function stargazer_get_custom_control_html() {


		$html = sprintf(
			'<p>%s</p>
			 <p>%s</p>
			 <p><a class="button button-primary" href="http://themehybrid.com/club" target="_blank">%s</a></p>',
			__( 'I have never been a fan of crippleware (i.e., "lite" themes) that upsell you all the cool stuff. With the Extant theme, you get the full theme.', 'extant' ),
			__( 'Instead, let me offer you a full year of dedicated support (forums and live chat). This includes support for all of my themes and plugins.', 'extant' ),
			__( 'Join The Club', 'extant' )
		);

		return $html;
	}

/**
 * Loads theme customizer JavaScript.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_enqueue_customizer_scripts() {

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
