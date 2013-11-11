<?php

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'stargazer_custom_background_setup', 15 );

/* Filter the background color late. */
add_filter( 'theme_mod_background_color', 'stargazer_background_color', 95 );

/* Register default background images. */
add_filter( 'hybrid_default_backgrounds', 'stargazer_default_backgrounds' );

/**
 * Adds support for the WordPress 'custom-background' theme feature.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_custom_background_setup() {

	add_theme_support(
		'custom-background',
		array(
			'default-color' => '2d2d2d',
			'default-image' => '',
		)
	);
}

/**
 * If the color is `ffffff` (white), return an empty string for the background color.  This is because the 
 * theme's main container's background is also white.  In this case, we drop some margins/padding so that 
 * the theme design flows better and doesn't appear that we have large, empty areas.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $color
 * @return string
 */
function stargazer_background_color( $color ) {
	return 'ffffff' === $color ? '' : $color;
}

/**
 * Registers custom backgrounds for the theme.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_default_backgrounds( $backgrounds ) {

	$_backgrounds = array(
		'dark-orange-cross' => array(
			'url'           => '%s/images/backgrounds/dark-orange-cross.png',
			'thumbnail_url' => '%s/images/backgrounds/dark-orange-cross.png',
		),
		'star-field-dark' => array(
			'url'           => '%s/images/backgrounds/star-field-dark.jpg',
			'thumbnail_url' => '%s/images/backgrounds/star-field-dark.jpg',
		),
	);

	return array_merge( $backgrounds, $_backgrounds );
}
