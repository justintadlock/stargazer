<?php
/**
 * Scripts and styles.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013 - 2018, Justin Tadlock
 * @link       https://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load scripts/styles.
add_action( 'wp_enqueue_scripts',    'stargazer_enqueue'       );
add_action( 'enqueue_embed_scripts', 'stargazer_embed_enqueue' );

# Remove locale stylesheet (load later). @see https://core.trac.wordpress.org/ticket/36839
remove_action( 'embed_head', 'locale_stylesheet' );

# Modifies the framework's infinity symbol.
add_filter( 'hybrid_aside_infinity', 'stargazer_aside_infinity' );

# Custom header color for embeds.
add_action( 'embed_head', 'stargazer_custom_header_embed_head', 26 );

/**
 * Load scripts/styles on the front end.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_enqueue() {

	// Scripts

	wp_add_inline_script( 'wp-mediaelement', stargazer_get_mediaelement_inline_script() );

	wp_enqueue_script( 'stargazer' );

	// Fonts

	hybrid_enqueue_font( 'stargazer' );

	// Styles

	wp_enqueue_style( 'hybrid-one-five'        );
	wp_enqueue_style( 'hybrid-gallery'         );
	wp_enqueue_style( 'stargazer-mediaelement' );
	wp_enqueue_style( 'stargazer-media'        );

	if ( is_child_theme() )
		wp_enqueue_style( 'hybrid-parent' );

	wp_enqueue_style( 'hybrid-style' );
}

/**
 * Load scripts/styles for embeds.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_embed_enqueue() {

	wp_add_inline_script( 'wp-mediaelement', stargazer_get_mediaelement_inline_script() );

	wp_enqueue_script( 'stargazer' );

	hybrid_enqueue_font( 'stargazer' );

	wp_enqueue_style( 'hybrid-one-five'        );
	wp_enqueue_style( 'stargazer-mediaelement' );
	wp_enqueue_style( 'stargazer-media'        );
	wp_enqueue_style( 'stargazer-embed'        );
	wp_enqueue_style( 'stargazer-locale'       );
}

/**
 * Returns custom Mediaelement settings script.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_mediaelement_inline_script() {

	return "( function( window ) {

		var settings = window._wpmejsSettings || {};

		settings.features = [ 'progress', 'playpause', 'volume', 'tracks', 'current', 'duration', 'fullscreen' ];
	} )( window );";
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
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.  This also fixes WordPress
 * not correctly handling the theme's default background color.
 *
 * @link http://core.trac.wordpress.org/ticket/16919
 * @link http://core.trac.wordpress.org/ticket/21510
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_custom_background_callback() {

	// Get the background image.
	$image = get_background_image();

	// If there's an image, just call the normal WordPress callback. We won't do anything here.
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	// Get the background color.
	$color = get_background_color();

	// If no background color, return.
	if ( empty( $color ) )
		return;

	// Use 'background' instead of 'background-color'.
	$style = "background: #{$color};";

?>
<style type="text/css" id="custom-background-css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}
