<?php
/**
 * Sets up custom filters and actions for the theme.  This does things like sets up sidebars, menus, scripts,
 * and lots of other awesome stuff that WordPress themes do.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Excerpt-related filters.
add_filter( 'excerpt_length', 'stargazer_excerpt_length' );

# Modifies the theme layout.
add_filter( 'theme_mod_theme_layout', 'stargazer_mod_theme_layout', 15 );

# Adds custom attributes to the subsidiary sidebar.
add_filter( 'hybrid_attr_sidebar', 'stargazer_sidebar_subsidiary_class', 10, 2 );

# Appends comments link to status posts.
add_filter( 'the_content', 'stargazer_status_content', 9 ); // run before wpautop()

# Modifies the framework's infinity symbol.
add_filter( 'hybrid_aside_infinity', 'stargazer_aside_infinity' );

# Filters the calendar output.
add_filter( 'get_calendar', 'stargazer_get_calendar' );

# Embed wrap.
add_filter( 'embed_oembed_html', 'stargazer_maybe_wrap_embed', 10, 2 );

# Filters the [audio] shortcode output.
add_filter( 'wp_audio_shortcode', 'stargazer_audio_shortcode', 10, 4 );

# Filter the [video] shortcode attributes.
add_filter( 'shortcode_atts_video', 'stargazer_video_atts' );

# Remove WP's excerpt more filter on embeds.
remove_filter( 'excerpt_more', 'wp_embed_excerpt_more', 20 );

/**
 * Modifies the theme layout on attachment pages.  If a specific layout is not selected and the global layout
 * isn't set to '1c-narrow', this filter will change the layout to '1c'.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $layout
 * @return string
 */
function stargazer_mod_theme_layout( $layout ) {

	if ( is_attachment() && wp_attachment_is_image() ) {
		$post_layout = hybrid_get_post_layout( get_queried_object_id() );

		if ( ! $post_layout || 'default' === $post_layout && '1c-narrow' !== $layout )
			$layout = '1c';
	}

	return $layout;
}

/**
 * Adds the comments link to status posts' content.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $content
 * @return string
 */
function stargazer_status_content( $content ) {

	if ( ! is_singular() && has_post_format( 'status' ) && in_the_loop() && ( have_comments() || comments_open() ) )
		$content .= sprintf( ' <a class="comments-link" href="%s">%s</a>', esc_url( get_permalink() ), number_format_i18n( get_comments_number() ) );

	return $content;
}

/**
 * Filter's Hybrid Core's infinity symbol for aside posts.  This changes the symbol to a comments link if
 * the post's comments are open or if the post has comments.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function stargazer_aside_infinity( $html ) {

	if ( have_comments() || comments_open() )
		$html = sprintf( ' <a class="comments-link" href="%s">%s</a>', esc_url( get_permalink() ), number_format_i18n( get_comments_number() ) );

	return $html;
}

/**
 * Adds a custom excerpt length.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $length
 * @return int
 */
function stargazer_excerpt_length( $length ) {
	return 30;
}

/**
 * Adds a custom class to the 'subsidiary' sidebar.  This is used to determine the number of columns used to
 * display the sidebar's widgets.  This optimizes for 1, 2, and 3 columns or multiples of those values.
 *
 * Note that we're using the global $sidebars_widgets variable here. This is because core has marked
 * wp_get_sidebars_widgets() as a private function. Therefore, this leaves us with $sidebars_widgets for
 * figuring out the widget count.
 * @link http://codex.wordpress.org/Function_Reference/wp_get_sidebars_widgets
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $context
 * @return array
 */
function stargazer_sidebar_subsidiary_class( $attr, $context ) {

	if ( 'subsidiary' === $context ) {
		global $sidebars_widgets;

		if ( is_array( $sidebars_widgets ) && !empty( $sidebars_widgets[ $context ] ) ) {

			$count = count( $sidebars_widgets[ $context ] );

			if ( 1 === $count )
				$attr['class'] .= ' sidebar-col-1';

			elseif ( ! ( $count % 3 ) || $count % 2 )
				$attr['class'] .= ' sidebar-col-3';

			elseif ( ! ( $count % 2 ) )
				$attr['class'] .= ' sidebar-col-2';
		}
	}

	return $attr;
}

/**
 * Turns the IDs into classes for the calendar.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $calendar
 * @return string
 */
function stargazer_get_calendar( $calendar ) {
	return preg_replace( '/id=([\'"].*?[\'"])/i', 'class=$1', $calendar );
}

/**
 * Wraps embeds with `.embed-wrap` class.
 *
 * @since  2.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function stargazer_wrap_embed_html( $html ) {

	return $html && is_string( $html ) ? sprintf( '<div class="embed-wrap">%s</div>', $html ) : $html;
}

/**
 * Checks embed URL patterns to see if they should be wrapped in some special HTML, particularly
 * for responsive videos.
 *
 * @author     Automattic
 * @link       http://jetpack.me
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @since  2.0.0
 * @access public
 * @param  string  $html
 * @param  string  $url
 * @return string
 */
function stargazer_maybe_wrap_embed( $html, $url ) {

	if ( ! $html || ! is_string( $html ) || ! $url )
		return $html;

	$do_wrap = false;

	$patterns = array(
		'#http://((m|www)\.)?youtube\.com/watch.*#i',
		'#https://((m|www)\.)?youtube\.com/watch.*#i',
		'#http://((m|www)\.)?youtube\.com/playlist.*#i',
		'#https://((m|www)\.)?youtube\.com/playlist.*#i',
		'#http://youtu\.be/.*#i',
		'#https://youtu\.be/.*#i',
		'#https?://(.+\.)?vimeo\.com/.*#i',
		'#https?://(www\.)?dailymotion\.com/.*#i',
		'#https?://dai.ly/*#i',
		'#https?://(www\.)?hulu\.com/watch/.*#i',
		'#https?://wordpress.tv/.*#i',
		'#https?://(www\.)?funnyordie\.com/videos/.*#i',
		'#https?://vine.co/v/.*#i',
		'#https?://(www\.)?collegehumor\.com/video/.*#i',
		'#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
	);

	$patterns = apply_filters( 'stargazer_maybe_wrap_embed_patterns', $patterns );

	foreach ( $patterns as $pattern ) {

		$do_wrap = preg_match( $pattern, $url );

		if ( $do_wrap )
			return stargazer_wrap_embed_html( $html );
	}

	return $html;
}

/**
 * Adds a featured image (if one exists) next to the audio player.  Also adds a section below the player to
 * display the audio file information (toggled by custom JS).
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @param  array   $atts
 * @param  object  $audio
 * @param  object  $post_id
 * @return string
 */
function stargazer_audio_shortcode( $html, $atts, $audio, $post_id ) {

	// Don't show in the admin.
	if ( is_admin() )
		return $html;

	// If we have an actual attachment to work with, use the ID.
	if ( is_object( $audio ) ) {
		$attachment_id = $audio->ID;

	} else if ( $post_id && hybrid_attachment_is_audio( $post_id ) ) {

		$attachment_id = $post_id;

	} // Else, get the ID via the file URL.
	else {
		$extensions = join( '|', wp_get_audio_extensions() );

			preg_match(
				'/(src|' . $extensions . ')=[\'"](.+?)[\'"]/i',
				preg_replace( '/(\?_=[0-9])/i', '', $html ),
				$matches
			);

			if ( ! empty( $matches ) ) {

				$dir  = wp_upload_dir();
				$file = parse_url( $matches[ 2 ] );

				if ( isset( $dir['baseurl'] ) && isset( $file['path'] ) )
					$attachment_id = attachment_url_to_postid( trim( str_replace( $dir['baseurl'], '', $file['path'] ), '/' ) );
			}
	}

	// If an attachment ID was found.
	if ( !empty( $attachment_id ) ) {

		// Get the attachment's featured image.
		$image = get_the_image(
			array(
				'post_id'      => $attachment_id,
				'image_class'  => 'audio-image',
				'link_to_post' => is_attachment() ? false : true,
				'echo'         => false
			)
		);

		// If there's no attachment featured image, see if there's one for the post.
		if ( empty( $image ) && ! empty( $post_id ) )
			$image = get_the_image( array( 'image_class' => 'audio-image', 'link_to_post' => false, 'echo' => false ) );

		// Add a wrapper for the audio element and image.
		if ( ! empty( $image ) ) {
			$image = preg_replace( array( '/width=[\'"].+?[\'"]/i', '/height=[\'"].+?[\'"]/i' ), '', $image );
			$html = '<div class="audio-shortcode-wrap">' . $image . $html . '</div>';
		}
	}

	return $html;
}

/**
 * Retrieves an attachment ID based on an attachment file URL.
 *
 * @copyright Pippin Williamson
 * @license   http://www.gnu.org/licenses/gpl-2.0.html
 * @link      http://pippinsplugins.com/retrieve-attachment-id-from-image-url/
 *
 * @since  2.0.0
 * @access public
 * @param  string  $url
 * @return int
 */
function stargazer_get_attachment_id_from_url( $url ) {
	global $wpdb;

	$prefix = $wpdb->prefix;
	$posts = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $url ) );

	return array_shift( $posts );
}

/**
 * Featured image for self-hosted videos.  Checks the vidoe attachment for sub-attachment images.  If
 * none exist, checks the current post (if in The Loop) for its featured image.  If an image is found,
 * it's used as the "poster" attribute in the [video] shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $out
 * @return array
 */
function stargazer_video_atts( $out ) {

	// Don't show in the admin.
	if ( is_admin() )
		return $out;

	// Only run if the user didn't set a 'poster' image.
	if ( empty( $out['poster'] ) ) {

		// Check the 'src' attribute for an attachment file.
		if ( ! empty( $out['src'] ) )
			$attachment_id = stargazer_get_attachment_id_from_url( $out['src'] );

		// If we couldn't get an attachment from the 'src' attribute, check other supported file extensions.
		if ( empty( $attachment_id ) ) {

			$default_types = wp_get_video_extensions();

			foreach ( $default_types as $type ) {

				if ( ! empty( $out[ $type ] ) ) {
					$attachment_id = stargazer_get_attachment_id_from_url( $out[ $type ] );

					if ( ! empty( $attachment_id ) )
						break;
				}
			}
		}

		// If there's an attachment ID at this point.
		if ( ! empty( $attachment_id ) ) {

			// Get the attachment's featured image.
			$image = get_the_image(
				array(
					'post_id'      => $attachment_id,
					'size'         => 'full',
					'format'       => 'array',
					'echo'         => false
				)
			);
		}

		// If no image has been found and we're in the post loop, see if the current post has a featured image.
		if ( empty( $image ) && get_post() )
			$image = get_the_image( array( 'size' => 'full', 'format' => 'array', 'echo' => false ) );

		// Set the 'poster' attribute if we have an image at this point.
		if ( ! empty( $image ) )
			$out['poster'] = $image['src'];
	}

	return $out;
}

/**
 * Adds a section below the player to  display the video file information (toggled by custom JS).
 *
 * @since  1.0.0
 * @access public
 * @param  string  $html
 * @param  array   $atts
 * @param  object  $audio
 * @return string
 */
function stargazer_video_shortcode( $html, $atts, $video ) {
	return $html;
}
