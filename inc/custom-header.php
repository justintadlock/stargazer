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

# Custom header color for embeds.
add_action( 'embed_head', 'stargazer_custom_header_embed_head', 26 );

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
