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

# Register custom image sizes.
add_action( 'init', 'stargazer_register_image_sizes', 5 );

# Register custom menus.
add_action( 'init', 'stargazer_register_menus', 5 );

# Register custom layouts.
add_action( 'hybrid_register_layouts', 'stargazer_register_layouts' );

# Register sidebars.
add_action( 'widgets_init', 'stargazer_register_sidebars', 5 );

# Register scripts/styles.
add_action( 'wp_enqueue_scripts',    'stargazer_register_scripts',      0 );
add_action( 'enqueue_embed_scripts', 'stargazer_register_scripts',      0 );
add_action( 'wp_enqueue_scripts',    'stargazer_register_styles',       0 );
add_action( 'enqueue_embed_scripts', 'stargazer_register_styles',       0 );

# Load scripts/styles.
add_action( 'wp_enqueue_scripts',    'stargazer_enqueue'       );
add_action( 'enqueue_embed_scripts', 'stargazer_embed_enqueue' );

# Remove locale stylsheet (load later). @see https://core.trac.wordpress.org/ticket/36839
remove_action( 'embed_head', 'locale_stylesheet' );

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

# Adds custom settings for the visual editor.
add_filter( 'tiny_mce_before_init', 'stargazer_tiny_mce_before_init' );
add_filter( 'mce_css',              'stargazer_mce_css'              );

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
 * Registers custom image sizes for the theme.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_register_image_sizes() {

	// Sets the 'post-thumbnail' size.
	set_post_thumbnail_size( 175, 131, true );

	// Adds the 'stargazer-full' image size.
	add_image_size( 'stargazer-full', 1025, 500, false );
}

/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_register_menus() {
	register_nav_menu( 'primary',   _x( 'Primary',   'nav menu location', 'stargazer' ) );
	register_nav_menu( 'secondary', _x( 'Secondary', 'nav menu location', 'stargazer' ) );
	register_nav_menu( 'social',    _x( 'Social',    'nav menu location', 'stargazer' ) );
}

/**
 * Registers sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_register_sidebars() {

	hybrid_register_sidebar(
		array(
			'id'          => 'primary',
			'name'        => _x( 'Primary', 'sidebar', 'stargazer' ),
			'description' => __( 'The main sidebar. It is displayed on either the left or right side of the page based on the chosen layout.', 'stargazer' )
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'subsidiary',
			'name'        => _x( 'Subsidiary', 'sidebar', 'stargazer' ),
			'description' => __( 'A sidebar located in the footer of the site. Optimized for one, two, or three widgets (and multiples thereof).', 'stargazer' )
		)
	);
}

/**
 * Registers custom layouts.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function stargazer_register_layouts() {

	hybrid_register_layout( '1c',        array( 'label' => __( '1 Column Wide',                'stargazer' ), 'image' => '%s/images/layouts/1c.png' ) );
	hybrid_register_layout( '1c-narrow', array( 'label' => __( '1 Column Narrow',              'stargazer' ), 'image' => '%s/images/layouts/1c-narrow.png' ) );
	hybrid_register_layout( '2c-l',      array( 'label' => __( '2 Columns: Content / Sidebar', 'stargazer' ), 'image' => '%s/images/layouts/2c-l.png' ) );
	hybrid_register_layout( '2c-r',      array( 'label' => __( '2 Columns: Sidebar / Content', 'stargazer' ), 'image' => '%s/images/layouts/2c-r.png' ) );
}

/**
 * Registers custom scripts.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_register_scripts() {

	$suffix = hybrid_get_min_suffix();

	wp_register_script( 'stargazer', trailingslashit( get_template_directory_uri() ) . "js/stargazer{$suffix}.js", array( 'jquery' ), null, true );

	wp_localize_script(
		'stargazer',
		'stargazer_i18n',
		array(
			'search_toggle' => __( 'Expand Search Form', 'stargazer' )
		)
	);
}

/**
 * Registers custom stylesheets for the front end.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_register_styles() {

	$suffix = hybrid_get_min_suffix();

	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	wp_register_style( 'stargazer-fonts',        '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic|Open+Sans:300,400,600,700' );
	wp_register_style( 'stargazer-mediaelement', trailingslashit( get_template_directory_uri() ) . "css/mediaelement{$suffix}.css" );
	wp_register_style( 'stargazer-media',        trailingslashit( get_template_directory_uri() ) . "css/media{$suffix}.css" );
	wp_register_style( 'stargazer-embed',        trailingslashit( get_template_directory_uri() ) . "css/embed{$suffix}.css" );

	// Registering locale style for embeds. @see https://core.trac.wordpress.org/ticket/36839
	wp_register_style( 'stargazer-locale', get_locale_stylesheet_uri() );
}

/**
 * Load scripts/styles on the front end.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_enqueue() {

	// Scripts

	wp_add_inline_script( 'wp-mediaelement', stargazer_get_mediaelement_inline_script() );

	wp_enqueue_script( 'stargazer' );

	// Styles

	wp_enqueue_style( 'stargazer-fonts'        );
	wp_enqueue_style( 'hybrid-one-five'        );
	wp_enqueue_style( 'hybrid-gallery'         );
	wp_enqueue_style( 'stargazer-mediaelement' );
	wp_enqueue_style( 'stargazer-media'        );

	if ( is_child_theme() )
		wp_enqueue_style( 'hybrid-parent' );

	wp_enqueue_style( 'hybrid-style' );
}

/**
 * Load scripts/styles for embeds.
 *
 * @since  3.0.0
 * @access public
 * @return void
 */
function stargazer_embed_enqueue() {

	wp_add_inline_script( 'wp-mediaelement', stargazer_get_mediaelement_inline_script() );

	wp_enqueue_script( 'stargazer' );

	wp_enqueue_style( 'stargazer-fonts'        );
	wp_enqueue_style( 'hybrid-one-five'        );
	wp_enqueue_style( 'stargazer-mediaelement' );
	wp_enqueue_style( 'stargazer-media'        );
	wp_enqueue_style( 'stargazer-embed'        );
	wp_enqueue_style( 'stargazer-locale'       );
}

/**
 * Returns custom Mediaelement settings script.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_mediaelement_inline_script() {

	return "( function( window ) {

		var settings = window._wpmejsSettings || {};

		settings.features = [ 'progress', 'playpause', 'volume', 'tracks', 'current', 'duration', 'fullscreen' ];
	} )( window );";
}

/**
 * Callback function for adding editor styles.  Use along with the add_editor_style() function.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function stargazer_get_editor_styles() {

	// Set up an array for the styles.
	$editor_styles = array();

	// Add the theme's editor styles.
	$editor_styles[] = stargazer_get_parent_editor_stylesheet_uri();

	// If a child theme, add its editor styles.
	if ( is_child_theme() && $style = stargazer_get_editor_stylesheet_uri() )
		$editor_styles[] = stargazer_get_editor_stylesheet_uri();

	// Add the locale stylesheet.
	$editor_styles[] = get_locale_stylesheet_uri();

	// Uses Ajax to display custom theme styles added via the Theme Mods API.
	$editor_styles[] = add_query_arg( 'action', 'stargazer_editor_styles', admin_url( 'admin-ajax.php' ) );

	// Return the styles.
	return $editor_styles;
}

/**
 * Returns the active theme editor stylesheet URI.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_editor_stylesheet_uri() {

	$style_uri = '';
	$suffix    = hybrid_get_min_suffix();
	$dir       = trailingslashit( get_stylesheet_directory() );
	$uri       = trailingslashit( get_stylesheet_directory_uri() );

	if ( $suffix && file_exists( "{$dir}css/editor-style{$suffix}.css" ) )
		$style_uri = "{$uri}css/editor-style{$suffix}.css";

	else if ( file_exists( "{$dir}css/editor-style.css" ) )
		$style_uri = "{$uri}css/editor-style.css";

	return $style_uri;
}

/**
 * Returns the parent theme editor stylesheet URI.
 *
 * @since  3.0.0
 * @access public
 * @return string
 */
function stargazer_get_parent_editor_stylesheet_uri() {

	$style_uri = '';
	$suffix    = hybrid_get_min_suffix();
	$dir       = trailingslashit( get_template_directory() );
	$uri       = trailingslashit( get_template_directory_uri() );

	if ( $suffix && file_exists( "{$dir}css/editor-style{$suffix}.css" ) )
		$style_uri = "{$uri}css/editor-style{$suffix}.css";

	else if ( file_exists( "{$dir}css/editor-style.css" ) )
		$style_uri = "{$uri}css/editor-style.css";

	return $style_uri;
}

/**
 * Adds the <body> class to the visual editor.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $settings
 * @return array
 */
function stargazer_tiny_mce_before_init( $settings ) {

	$settings['body_class'] = join( ' ', get_body_class() );

	return $settings;
}

/**
 * Removes the media player styles from the visual editor since we're loading our own.
 *
 * @since  1.1.0
 * @access public
 * @param  string  $mce_css
 * @return string
 */
function stargazer_mce_css( $mce_css ) {
	$version = 'ver=' . $GLOBALS['wp_version'];

	$mce_css = str_replace( includes_url( "js/mediaelement/mediaelementplayer.min.css?$version" ) . ',', '', $mce_css );
	$mce_css = str_replace( includes_url( "js/mediaelement/wp-mediaelement.css?$version" ) . ',',        '', $mce_css );

	return $mce_css;
}

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
 * Enqueues scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_enqueue_scripts() {}

/**
 * Loads stylesheets.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function stargazer_enqueue_styles() {}

/**
 * Registers stylesheets for use in the admin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_admin_register_styles() {}

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
