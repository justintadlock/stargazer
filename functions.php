<?php
/**
 * @package    Stargazer
 * @subpackage Functions
 * @version    0.1.0
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/******************************************************************/

/* === Temporary functionality until we wrap everything up. === */

// temp
add_action( 'wp_enqueue_scripts', 'stargazer_enqueue_styles', 5 );

// temp
function stargazer_enqueue_styles() {


	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	$dir = trailingslashit( get_template_directory_uri() );

	wp_enqueue_style( 'sg-g-fonts',  "http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic|Open+Sans:300,400,600,700" );
//	wp_enqueue_style( 'sg-g2-fonts', "http://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic&text=%26" );

	wp_enqueue_style( 'sg-one-five', "{$dir}library/css/one-five.min.css" );
	wp_enqueue_style( 'sg-gallery',  "{$dir}library/css/gallery.min.css"  );
	wp_enqueue_style( 'sg-mejs',     "{$dir}css/mediaelement/mediaelement.min.css" );
	wp_enqueue_style( 'sg-fonts',    "{$dir}css/genericons.css" );
	wp_enqueue_style( 'sg-layout',   "{$dir}css/layout.css" );
	wp_enqueue_style( 'sg-defaults', "{$dir}css/defaults.css" );
	wp_enqueue_style( 'sg-m-query',  "{$dir}css/media-queries.css" );

	if ( is_child_theme() )
		wp_enqueue_style( 'parent', "{$dir}style.css" );

	wp_enqueue_style( 'sg-style',    get_stylesheet_uri() );
}

/******************************************************************************/

/* Get the template directory and make sure it has a trailing slash. */
$stargazer_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and launch it. */
require_once( $stargazer_dir . 'library/hybrid.php' );
new Hybrid();

/* Load theme-specific files. */
require_once( $stargazer_dir . 'inc/hybrid-core-x.php'         );
require_once( $stargazer_dir . 'inc/stargazer.php'             );
require_once( $stargazer_dir . 'inc/custom-background.php'     );
require_once( $stargazer_dir . 'inc/custom-header.php'         );
require_once( $stargazer_dir . 'inc/custom-colors.php'         );
require_once( $stargazer_dir . 'inc/customize.php'             );

/* Set up the theme early. */
add_action( 'after_setup_theme', 'stargazer_theme_setup', 5 );

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_theme_setup() {

	/* Load widgets. */
	add_theme_support( 'hybrid-core-widgets' );

	/* Theme layouts. */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => __( '1 Column Wide',                'stargazer' ),
			'1c-narrow' => __( '1 Column Narrow',              'stargazer' ),
			'2c-l'      => __( '2 Columns: Content / Sidebar', 'stargazer' ),
			'2c-r'      => __( '2 Columns: Sidebar / Content', 'stargazer' )
		),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
	);

	/* Enable custom template hierarchy. */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Breadcrumbs. Yay! */
	add_theme_support( 'breadcrumb-trail' );

	/* Pagination. */
	add_theme_support( 'loop-pagination' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Whistles plugin. */
	add_theme_support( 'whistles', array( 'styles' => true ) );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Editor styles. */
	//add_editor_style( stargazer_get_editor_styles() );

	/* Handle content width for embeds and images. */
	// Note: this is the largest size based on the theme's various layouts.
	hybrid_set_content_width( 1025 );
}
