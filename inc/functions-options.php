<?php
/**
 * Functions that deal with theme options.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013 - 2018, Justin Tadlock
 * @link       https://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the primary color.
 *
 * @since  4.0.0
 * @access public
 * @return string
 */
function stargazer_get_color_primary() {

	return hybrid_get_theme_mod( 'color_primary', '' );
}

/**
 * Conditional tag to check whether the user is running the pro version.
 *
 * @since  4.0.0
 * @access public
 * @return bool
 */
function stargazer_is_pro() {

	return apply_filters( 'stargazer_is_pro', false );
}
