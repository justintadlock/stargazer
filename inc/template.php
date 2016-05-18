<?php
/**
 * Template-related functions.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Gets the embed template used for embedding posts from the site.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_get_embed_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// Assume the theme developer is creating an attachment template.
	if ( 'attachment' === $post_type ) {
		remove_filter( 'the_content',       'prepend_attachment'          );
		remove_filter( 'the_excerpt_embed', 'wp_embed_excerpt_attachment' );

		$type = hybrid_get_attachment_type();

		$templates[] = "embed-attachment-{$type}.php";
		$templates[] = "embed/attachment-{$type}.php";
	}

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based off post type and post format.
		$templates[] = "embed-{$post_type}-{$post_format}.php";
		$templates[] = "embed/{$post_type}-{$post_format}.php";

		// Template based off the post format.
		$templates[] = "embed-{$post_format}.php";
		$templates[] = "embed/{$post_format}.php";
	}

	// Template based off the post type.
	$templates[] = "embed-{$post_type}.php";
	$templates[] = "embed/{$post_type}.php";

	// Fallback 'embed/content.php' template.
	$templates[] = 'embed/content.php';

	// Apply filters to the templates array.
	$templates = apply_filters( 'stargazer_embed_template_hierarchy', $templates );

	// Locate the template.
	$template = locate_template( $templates );

	// If template is found, include it.
	if ( apply_filters( 'stargazer_embed_template', $template, $templates ) )
		include( $template );
}

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

/**
 * Checks if a widget exists.  Pass in the widget class name.  This function is useful for 
 * checking if the widget exists before directly calling `the_widget()` within a template.
 *
 * @since  3.0.0
 * @access public
 * @param  string  $widget
 * @return bool
 */
function stargazer_widget_exists( $widget ) {
	global $wp_widget_factory;

	return isset( $wp_widget_factory->widgets[ $widget ] );
}
