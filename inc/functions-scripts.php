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

# Remove locale stylsheet (load later). @see https://core.trac.wordpress.org/ticket/36839
remove_action( 'embed_head', 'locale_stylesheet' );

# Modifies the framework's infinity symbol.
add_filter( 'hybrid_aside_infinity', 'stargazer_aside_infinity' );

# Adds custom settings for the visual editor.
add_filter( 'tiny_mce_before_init', 'stargazer_tiny_mce_before_init' );
add_filter( 'mce_css',              'stargazer_mce_css'              );

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

/**
 * Callback function for adding editor styles.  Use along with the add_editor_style() function.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function stargazer_get_editor_styles() {

	// Set up an array for the styles.
	$editor_styles = array();

	// Add the theme's editor styles.
	$editor_styles[] = stargazer_get_parent_editor_stylesheet_uri();

	// If a child theme, add its editor styles.
	if ( is_child_theme() && $style = stargazer_get_editor_stylesheet_uri() )
		$editor_styles[] = stargazer_get_editor_stylesheet_uri();

	// Add the locale stylesheet.
	$editor_styles[] = get_locale_stylesheet_uri();

	// Uses Ajax to display custom theme styles added via the Theme Mods API.
	$editor_styles[] = add_query_arg( 'action', 'stargazer_editor_styles', admin_url( 'admin-ajax.php' ) );

	// Return the styles.
	return $editor_styles;
}

/**
 * Returns the active theme editor stylesheet URI.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_editor_stylesheet_uri() {

	$style_uri = '';
	$suffix    = hybrid_get_min_suffix();
	$dir       = trailingslashit( get_stylesheet_directory() );
	$uri       = trailingslashit( get_stylesheet_directory_uri() );

	if ( $suffix && file_exists( "{$dir}css/editor-style{$suffix}.css" ) )
		$style_uri = "{$uri}css/editor-style{$suffix}.css";

	else if ( file_exists( "{$dir}css/editor-style.css" ) )
		$style_uri = "{$uri}css/editor-style.css";

	return $style_uri;
}

/**
 * Returns the parent theme editor stylesheet URI.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_parent_editor_stylesheet_uri() {

	$style_uri = '';
	$suffix    = hybrid_get_min_suffix();
	$dir       = trailingslashit( get_template_directory() );
	$uri       = trailingslashit( get_template_directory_uri() );

	if ( $suffix && file_exists( "{$dir}css/editor-style{$suffix}.css" ) )
		$style_uri = "{$uri}css/editor-style{$suffix}.css";

	else if ( file_exists( "{$dir}css/editor-style.css" ) )
		$style_uri = "{$uri}css/editor-style.css";

	return $style_uri;
}

/**
 * Adds the <body> class to the visual editor.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $settings
 * @return array
 */
function stargazer_tiny_mce_before_init( $settings ) {

	$settings['body_class'] = join( ' ', get_body_class() );

	return $settings;
}

/**
 * Removes the media player styles from the visual editor since we're loading our own.
 *
 * @since  1.1.0
 * @access public
 * @param  string  $mce_css
 * @return string
 */
function stargazer_mce_css( $mce_css ) {
	$version = 'ver=' . $GLOBALS['wp_version'];

	$mce_css = str_replace( includes_url( "js/mediaelement/mediaelementplayer.min.css?$version" ) . ',', '', $mce_css );
	$mce_css = str_replace( includes_url( "js/mediaelement/wp-mediaelement.css?$version" ) . ',',        '', $mce_css );

	return $mce_css;
}
