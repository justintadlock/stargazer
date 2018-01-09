<?php
/**
 * Scripts and styles.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Load scripts/styles.
add_action( 'wp_enqueue_scripts',    'stargazer_enqueue'       );
add_action( 'enqueue_embed_scripts', 'stargazer_embed_enqueue' );

# Remove locale stylesheet (load later). @see https://core.trac.wordpress.org/ticket/36839
remove_action( 'embed_head', 'locale_stylesheet' );

# Modifies the framework's infinity symbol.
add_filter( 'hybrid_aside_infinity', 'stargazer_aside_infinity' );

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

	// Styles

	wp_enqueue_style( 'stargazer-fonts'        );
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

	wp_enqueue_style( 'stargazer-fonts'        );
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
