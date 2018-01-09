<?php
/**
 * Handles the setup and usage of the WordPress custom backgrounds feature.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Filter the background color late.
add_filter( 'theme_mod_background_color', 'stargazer_background_color', 95 );

/**
 * If the color is `ffffff` (white), return an empty string for the background color.  This is because the
 * theme's main container's background is also white.  In this case, we drop some margins/padding so that
 * the theme design flows better and doesn't appear that we have large, empty areas.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $color
 * @return string
 */
function stargazer_background_color( $color ) {
	return 'ffffff' === $color ? '' : $color;
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
