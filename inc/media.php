<?php
/**
 * Functions and filters for handling media in the theme.
 *
 * @package Stargazer
 * @since   0.1.0
 */

/* Filters the [audio] shortcode. */
add_filter( 'wp_audio_shortcode', 'stargazer_audio_shortcode', 10, 4 );

/* Filters the [video] shortcode. */
add_filter( 'wp_video_shortcode', 'stargazer_video_shortcode', 10, 3 );

/* Filter the [video] shortcode attributes. */
add_filter( 'shortcode_atts_video', 'stargazer_video_atts' );

/**
 * Adds a featured image (if one exists) next to the audio player.  Also adds a section below the player to 
 * display the audio file information (toggled by custom JS).
 *
 * @since  0.1.0
 * @access public
 * @param  string  $html
 * @param  array   $atts
 * @param  object  $audio
 * @param  object  $post_id
 * @return string
 */
function stargazer_audio_shortcode( $html, $atts, $audio, $post_id ) {

	/* Don't show in the admin. */
	if ( is_admin() )
		return $html;

	/* If we have an actual attachment to work with, use the ID. */
	if ( is_object( $audio ) ) {
		$attachment_id = $audio->ID;
	}

	/* Else, get the ID via the file URL. */
	else {
		preg_match( '/src=[\'"](.+?)[\'"]/i', $html, $matches );

		if ( !empty( $matches ) )
			$attachment_id = hybrid_get_attachment_id_from_url( $matches[1] );
	}

	/* If an attachment ID was found. */
	if ( !empty( $attachment_id ) ) {

		/* Get the attachment's featured image. */
		$image = get_the_image( 
			array( 
				'post_id'      => $attachment_id,  
				'image_class'  => 'audio-image',
				'link_to_post' => is_attachment() ? false : true, 
				'echo'         => false 
			) 
		);

		/* If there's no attachment featured image, see if there's one for the post. */
		if ( empty( $image ) && !empty( $post_id ) )
			$image = get_the_image( array( 'image_class' => 'audio-image', 'link_to_post' => false, 'echo' => false ) );

		/* Add a wrapper for the audio element and image. */
		if ( !empty( $image ) )
			$html = '<div class="audio-shortcode-wrap">' . $image . $html . '</div>';

		/* If not viewing an attachment page, add the media info section. */
		if ( !is_attachment() ) {
			$html .= '<div class="media-shortcode-extend">';
			$html .= '<div class="media-info audio-info">';
			$html .= hybrid_media_meta( array( 'post_id' => $attachment_id, 'echo' => false ) );
			$html .= '</div>';
			$html .= '<a class="media-info-toggle">' . __( 'Audio Info', 'stargazer' ) . '</a>';
			$html .= '</div>';
		}
	}

	return $html;
}

/**
 * Adds a section below the player to  display the video file information (toggled by custom JS).
 *
 * @since  0.1.0
 * @access public
 * @param  string  $html
 * @param  array   $atts
 * @param  object  $audio
 * @return string
 */
function stargazer_video_shortcode( $html, $atts, $video ) {

	/* Don't show on single attachment pages or in the admin. */
	if ( is_attachment() || is_admin() )
		return $html;

	/* If we have an actual attachment to work with, use the ID. */
	if ( is_object( $video ) ) {
		$attachment_id = $video->ID;
	}

	/* Else, get the ID via the file URL. */
	else {
		preg_match( '/src=[\'"](.+?)[\'"]/i', $html, $matches );

		if ( !empty( $matches ) )
			$attachment_id = hybrid_get_attachment_id_from_url( $matches[1] );
	}

	/* If an attachment ID was found, add the media info section. */
	if ( !empty( $attachment_id ) ) {

		$html .= '<div class="media-shortcode-extend">';
		$html .= '<div class="media-info video-info">';
		$html .= hybrid_media_meta( array( 'post_id' => $attachment_id, 'echo' => false ) );
		$html .= '</div>';
		$html .= '<a class="media-info-toggle">' . __( 'Video Info', 'stargazer' ) . '</a>';
		$html .= '</div>';
	}

	return $html;
}

/**
 * Featured image for self-hosted videos.  Checks the vidoe attachment for sub-attachment images.  If 
 * none exist, checks the current post (if in The Loop) for its featured image.  If an image is found, 
 * it's used as the "poster" attribute in the [video] shortcode.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $out
 * @return array
 */
function stargazer_video_atts( $out ) {

	/* Don't show in the admin. */
	if ( is_admin() )
		return $out;

	/* Only run if the user didn't set a 'poster' image. */
	if ( empty( $out['poster'] ) ) {

		/* Check the 'src' attribute for an attachment file. */
		if ( !empty( $out['src'] ) )
			$attachment_id = hybrid_get_attachment_id_from_url( $out['src'] );

		/* If we couldn't get an attachment from the 'src' attribute, check other supported file extensions. */
		if ( empty( $attachment_id ) ) {

			$default_types = wp_get_video_extensions();

			foreach ( $default_types as $type ) {

				if ( !empty( $out[ $type ] ) ) {
					$attachment_id = hybrid_get_attachment_id_from_url( $out[ $type ] );

					if ( !empty( $attachment_id ) )
						break;
				}
			}
		}

		/* If there's an attachment ID at this point. */
		if ( !empty( $attachment_id ) ) {

			/* Get the attachment's featured image. */
			$image = get_the_image( 
				array( 
					'post_id'      => $attachment_id, 
					'size'         => 'full',
					'format'       => 'array',
					'echo'         => false
				) 
			);
		}

		/* If no image has been found and we're in the post loop, see if the current post has a featured image. */
		if ( empty( $image ) && get_post() )
			$image = get_the_image( array( 'size' => 'full', 'format' => 'array', 'echo' => false ) );

		/* Set the 'poster' attribute if we have an image at this point. */
		if ( !empty( $image ) )
			$out['poster'] = $image['src'];
	}

	return $out;
}
