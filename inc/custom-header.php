<?php

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'stargazer_custom_header_setup', 15 );

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_custom_header_setup() {

	/* Adds support for WordPress' "custom-header" feature. */
	add_theme_support( 
		'custom-header', 
		array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 1175,
			'height'                 => 400,
			'flex-width'             => true,
			'flex-height'            => true,
			'default-text-color'     => '252525',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => 'stargazer_custom_header_wp_head',
			'admin-head-callback'    => 'stargazer_custom_header_admin_head',
			'admin-preview-callback' => 'stargazer_custom_header_admin_preview',
		)
	);

	/* Registers default headers for the theme. */
	register_default_headers(
		array(
			'horizon' => array(
				'url'           => '%s/images/headers/horizon.jpg',
				'thumbnail_url' => '%s/images/headers/horizon-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'Horizon', 'stargazer' )
			),
			'orange-burn' => array(
				'url'           => '%s/images/headers/orange-burn.jpg',
				'thumbnail_url' => '%s/images/headers/orange-burn-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'Orange Burn', 'stargazer' )
			),
			'planets-blue' => array(
				'url'           => '%s/images/headers/planets-blue.jpg',
				'thumbnail_url' => '%s/images/headers/planets-blue-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'Blue Planets', 'stargazer' )
			),
			'planet-burst' => array(
				'url'           => '%s/images/headers/planet-burst.jpg',
				'thumbnail_url' => '%s/images/headers/planet-burst-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'Planet Burst', 'stargazer' )
			),
			'space-splatters' => array(
				'url'           => '%s/images/headers/space-splatters.jpg',
				'thumbnail_url' => '%s/images/headers/space-splatters-thumb.jpg',
				/* Translators: Header image description. */
				'description'   => __( 'Space Splatters', 'stargazer' )
			),
		)
	);

	/* Load the stylesheet for the custom header screen. */
	add_action( 'admin_enqueue_scripts', 'stargazer_enqueue_admin_custom_header_styles', 5 );
}

/**
 * Enqueues the styles for the "Appearance > Custom Header" screen in the admin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_enqueue_admin_custom_header_styles( $hook_suffix ) {

	if ( 'appearance_page_custom-header' === $hook_suffix ) {
		wp_enqueue_style( 'stargazer-fonts' );
		wp_enqueue_style( 'stargazer-admin-custom-header' );
	}
}

/**
 * Callback function for outputting the custom header CSS to `wp_head`.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_custom_header_wp_head() {

	if ( !display_header_text() )
		return;

	$hex = get_header_textcolor();

	if ( empty( $hex ) )
		return;

	$style = "body.custom-header #site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}

/**
 * Callback for the admin preview output on the "Appearance > Custom Header" screen.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_custom_header_admin_preview() { ?>

			<header <?php hybrid_attr( 'header' ); ?>>

				<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

					<hgroup id="branding">
						<h1 <?php hybrid_attr( 'site-title' ); ?>><a href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 <?php hybrid_attr( 'site-description' ); ?>><?php bloginfo( 'description' ); ?></h2>
					</hgroup><!-- #branding -->

				<?php endif; // End check for header text. ?>

			</header><!-- #header -->

			<?php if ( get_header_image() && !display_header_text() ) : // If there's a header image but no header text. ?>

				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>

			<?php elseif ( get_header_image() ) : // If there's a header image. ?>

				<img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />

			<?php endif; // End check for header image. ?>

<?php }

/**
 * Callback function for outputting the custom header CSS to `admin_head` on "Appearance > Custom Header".  See 
 * the `css/admin-custom-header.css` file for all the style rules specific to this screen.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_custom_header_admin_head() {

	$hex = get_header_textcolor();

	if ( empty( $hex ) )
		return;

	$style = "#site-title a { color: #{$hex}; }";

	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
}
