<?php
/**
 * Template-related functions.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013 - 2018, Justin Tadlock
 * @link       https://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Prints the the post format permalink.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_post_format_permalink() {
	echo stargazer_get_post_format_permalink();
}

/**
 * Returns the post permalink (URL) with the post format as the link text.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_post_format_permalink() {

	$format = get_post_format();

	return $format ? sprintf( '<a href="%s" class="post-format-link"><span class="screen-reader-text">%s</span></a>', esc_url( get_permalink() ), get_post_format_string( $format ) ) : '';
}
