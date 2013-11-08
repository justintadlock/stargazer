<?php
/**
 * Hybrid Core Experimental - Experimental features for future Hybrid Core versions.
 *
 * Group of functions and filters likely to be include in a future version of the Hybrid Core framework.  
 * This file is a test run of these new features.  This means that the contents of this file will 
 * probably be removed in a future version of this theme.
 *
 * @package Stargazer
 * @since   0.1.0
 */

/* Filters the calendar output. */
add_filter( 'get_calendar', 'stargazer_get_calendar' );

/* Modifies the arguments and output of wp_link_pages(). */
add_filter( 'wp_link_pages_args', 'stargazer_link_pages_args' );
add_filter( 'wp_link_pages_link', 'stargazer_link_pages_link' );

/* Filters to add microdata support to common template tags. */
add_filter( 'the_author_posts_link',          'stargazer_the_author_posts_link'          );
add_filter( 'get_comment_author_link',        'stargazer_get_comment_author_link'        );
add_filter( 'get_comment_author_url_link',    'stargazer_get_comment_author_url_link'    );
add_filter( 'comment_reply_link',             'stargazer_comment_reply_link_filter'      );
add_filter( 'get_avatar',                     'stargazer_get_avatar'                     );
add_filter( 'post_thumbnail_html',            'stargazer_post_thumbnail_html'            );
add_filter( 'comments_popup_link_attributes', 'stargazer_comments_popup_link_attributes' );


/**
 * Wraps the output of `wp_link_pages()` with `<p class="page-links">`.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $args
 * @return array
 */
function stargazer_link_pages_args( $args ) {
	$args['before'] = str_replace( '<p>', '<p class="page-links">', $args['before'] );
	return $args;
}

/**
 * Wraps page "links" that aren't actually links (just text) with `<span class="page-numbers">` so that they 
 * can also be styled.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $link
 * @return string
 */
function stargazer_link_pages_link( $link ) {

	if ( 0 !== strpos( $link, '<a' ) )
		$link = "<span class='page-numbers'>{$link}</span>";

	return $link;
}

/**
 * Adds microdata to the author posts link.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $link
 * @return string
 */
function stargazer_the_author_posts_link( $link ) {

	$pattern = array(
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replace = array(
		'$1 class="url fn n" itemprop="url"$2',
		'$1<span itemprop="name">$2</span>$3'
	);

	return preg_replace( $pattern, $replace, $link );
}

/**
 * Adds microdata to the comment author link.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $link
 * @return string
 */
function stargazer_get_comment_author_link( $link ) {

	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2',
		'$1<span itemprop="name">$2</span>$3'
	);

	return preg_replace( $patterns, $replaces, $link );
}

/**
 * Adds microdata to the comment author URL link.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $link
 * @return string
 */
function stargazer_get_comment_author_url_link( $link ) {

	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i"
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2'
	);

	return preg_replace( $patterns, $replaces, $link );
}

/**
 * Adds microdata to the comment reply link.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $link
 * @return string
 */
function stargazer_comment_reply_link_filter( $link ) {
	return preg_replace( '/(<a\s)/i', '$1itemprop="replyToUrl"', $link );
}

/**
 * Adds microdata to avatars.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $avatar
 * @return string
 */
function stargazer_get_avatar( $avatar ) {
	return preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $avatar );
}

/**
 * Adds microdata to the post thumbnail HTML.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $html
 * @return string
 */
function stargazer_post_thumbnail_html( $html ) {
	return preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $html );
}

/**
 * Adds microdata to the comments popup link.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function stargazer_comments_popup_link_attributes( $attr ) {
	return 'itemprop="discussionURL"';
}

/**
 * Turns the IDs into classes for the calendar.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $calendar
 * @return string
 */
function stargazer_get_calendar( $calendar ) {
	return preg_replace( '/id=([\'"].*?[\'"])/i', 'class=$1', $calendar );
}
