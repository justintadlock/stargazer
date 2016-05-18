<?php
/**
 * Handles the setup and usage of the WordPress custom headers feature.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Call late so child themes can override.
add_action( 'after_setup_theme', 'stargazer_custom_header_setup', 15 );

# Custom header color for embeds.
add_action( 'embed_head', 'stargazer_custom_header_embed_head', 26 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_custom_header_setup() {

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
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_custom_header_wp_head() {

	if ( ! display_header_text() )
		return;

	$hex = get_header_textcolor();

	if ( ! $hex )
		return;

	$style = "body.custom-header #site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Uses the correct color for the site title on embeds.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_custom_header_embed_head() {

	$hex = get_header_textcolor();

	if ( ! $hex )
		return;

	$style = ".wp-embed-site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Enqueues the styles for the "Appearance > Custom Header" screen in the admin.
 *
 * @since      1.0.0
 * @deprecated 2.0.0
 * @access     public
 * @return     void
 */
function stargazer_enqueue_admin_custom_header_styles( $hook_suffix ) {}

/**
 * Callback for the admin preview output on the "Appearance > Custom Header" screen.
 *
 * @since       1.0.0
 * @deprecated  2.0.0
 * @access      public
 * @return      void
 */
function stargazer_custom_header_admin_preview() {}

/**
 * Callback function for outputting the custom header CSS to `admin_head` on "Appearance > Custom Header".  See
 * the `css/admin-custom-header.css` file for all the style rules specific to this screen.
 *
 * @since       1.0.0
 * @deprecated  2.0.0
 * @access      public
 * @return      void
 */
function stargazer_custom_header_admin_head() {}
