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

$stargazer_dir = trailingslashit( get_template_directory() );

require_once( $stargazer_dir . 'library/hybrid.php' );
new Hybrid();

require_once( $stargazer_dir . 'inc/hybrid-core-x.php'         );
require_once( $stargazer_dir . 'inc/media.php'                 );
require_once( $stargazer_dir . 'inc/stargazer.php'             );
require_once( $stargazer_dir . 'inc/custom-background.php'     );
require_once( $stargazer_dir . 'inc/custom-header.php'         );
require_once( $stargazer_dir . 'inc/customize.php'             );


// temp
add_action( 'wp_enqueue_scripts', 'stargazer_enqueue_styles', 5 );

// temp
function stargazer_enqueue_styles() {


	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );

	$dir = trailingslashit( get_template_directory_uri() );

	wp_enqueue_style( 'sg-g-fonts',  "http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic|Open+Sans:300,400,600,700" );
	wp_enqueue_style( 'sg-g2-fonts', "http://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic&text=%26" );

	wp_enqueue_style( 'sg-one-five', "{$dir}library/css/one-five.min.css" );
	wp_enqueue_style( 'sg-gallery',  "{$dir}library/css/gallery.min.css"  );
	wp_enqueue_style( 'sg-mejs',     "{$dir}css/mediaelement/mediaelement.min.css" );
	wp_enqueue_style( 'sg-fonts',    "{$dir}css/genericons.css" );
	wp_enqueue_style( 'sg-layout',   "{$dir}css/layout.css" );
	wp_enqueue_style( 'sg-defaults', "{$dir}css/defaults.css" );
	wp_enqueue_style( 'sg-m-query',  "{$dir}css/media-queries.css" );

	wp_enqueue_style( 'sg-style',    get_stylesheet_uri() );
}


//add_action( 'wp_head', 'stargazer_custom_colors' );

function stargazer_custom_colors() {

	$style     = '';
	$secondary = get_theme_mod( 'color_secondary', '' );
	$menu_bg   = get_theme_mod( 'color_menu_background', '' );

	$menu_bg_rgb = join( ', ', stargazer_hex_to_rgb( $menu_bg ) );

	$style .= "#menu-primary, #footer { background-color: #{$secondary}; }";

	$style .= "#menu-primary li li a { background-color: rgba( {$menu_bg_rgb}, 0.971 ); }";
	$style .= "#menu-primary ul ul > li:nth-child( odd ) a { background-color: rgba( {$menu_bg_rgb}, 0.975 ); }";
	$style .= "#menu-primary ul ul li a:hover { background-color: #{$menu_bg}; }";

	$style = "\n" . '<style type="text/css" id="sg-custom-colors-css">' . trim( str_replace( array( "\r", "\n", "\t" ), '', $style  ) ) . '</style>' . "\n";

	echo $style;
}

//add_filter( 'theme_mod_background_color', 'stargazer_background_color', 95 );
//add_filter( 'theme_mod_header_textcolor', 'stargazer_header_textcolor', 95 );
add_filter( 'theme_mod_color_palette_primary', 'stargazer_primary_color', 95 );

function stargazer_background_color( $color ) {
	return $color ? $color : '2d2d2d';
}

function stargazer_header_textcolor( $color ) {
	return $color ? $color : '252525';
}

function stargazer_primary_color( $color ) {
	return $color ? $color : 'cc4a00';
}


/*** Child theme colors example ****/

add_action( 'after_setup_theme', 'my_child_theme_setup' );

function my_child_theme_setup() {
	add_theme_support( 'custom-header', array( 'default-text-color' => '000000' ) );

	add_theme_support( 'custom-background', array( 'default-color' => '999999' ) );
}


add_filter( 'theme_mod_color_secondary', 'my_color_secondary' );

function my_color_secondary( $color ) {
	return !empty( $color ) ? $color : 'b54200';
}

add_filter( 'theme_mod_color_menu_background', 'my_color_menu_background' );

function my_color_menu_background( $color ) {
	return !empty( $color ) ? $color : 'b25900';
}



/************************************/








function stargazer_hex_to_rgb( $hex ){

	$color = trim( $hex, '#' );

	$red   = hexdec( $color[0].$color[1] );
	$green = hexdec( $color[2].$color[3] );
	$blue  = hexdec( $color[4].$color[5] );

	return array( 'r' => $red, 'g' => $green, 'b' => $blue );
}










function stargazer_register_colors( $colors ) {

	/* Add custom colors. */
	$colors->add_color(
		array( 'id' => 'primary', 'label' => __( 'Primary Color', 'stargazer' ), 'default' => '' )
	);

	/* Add rule set. */
	$colors->add_rule_set(
		'primary',
		array(
			'color'               => 'a, mark, .comment-respond .required, pre, .form-allowed-tags code, pre code, legend',

			'background-color'    => 'legend, input[type="submit"], input[type="reset"], input[type="button"], button, 
						blockquote, .page-links a, 
						.comment-reply-link, .comment-reply-login, .wp-calendar td.has-posts a,
					         ul.sub-terms li a, pre, .form-allowed-tags code, .widget-title > .wrap, 
					         #comments-number > .wrap, #reply-title > .wrap, .attachment-meta-title > .wrap, 
					         .widget-search > .search-form, .mejs-time-rail .mejs-time-loaded',

			'border-color'        => '#container .avatar',

			'border-top-color'    => 'body',

			'border-bottom-color' => 'body, .entry-content a, .entry-summary a, .widget-title, #comments-number,
					          #reply-title, .attachment-meta-title',

			'outline-color'       => 'blockquote',
		)
	);

}



function stargazer_cp_preview_js_ignore( $selectors, $color_id, $property ) {

	if ( 'color' === $property && 'primary' === $color_id )
		$selectors = '#site-title a, .menu a, .entry-title a, #footer a, .media-info-toggle';
	elseif ( 'background-color' === $property && 'primary' === $color_id )
		$selectors = '.mejs-button button';

	return $selectors;
}

function stargazer_colors_wp_head_callback( $color_palette ) {

	/* Get the cached style. */
	$style = wp_cache_get( 'color_palette' );

	/* If the style is available, output it and return. */
	if ( !empty( $style ) ) {
		echo $style;
		return;
	}

	/* Loop through each of the rules by name. */
	foreach ( $color_palette->rules as $color_id => $properties ) {

		$color = $color_palette->get_color( $color_id );

		/* Get the saved color. */
		$hex = get_theme_mod( 'color_palette_' . sanitize_key( $color_id ), $color['default'] );
		$rgb = join( ', ', stargazer_hex_to_rgb( $hex ) );

		if ( 'primary' === $color_id ) {
			$style .= stargazer_get_color_primary_styles();
		}
		else {
			/* Loop through each of the properties. */
			foreach ( $properties as $property => $selectors ) {
				$style .= join( ', ', $selectors ) . " { {$property}: #{$hex}; } ";
			}
		}
	}

	/* Put the final style output together. */
	$style = "\n" . '<style type="text/css" id="custom-colors-css">' . trim( str_replace( array( "\r", "\n", "\t" ), '', $style  ) ) . '</style>' . "\n";

	/* Cache the style, so we don't have to process this on each page load. */
	wp_cache_set( 'color_palette', $style );

	/* Output the custom style. */
	echo $style;
}

add_filter( 'the_content', 'stargazer_status_content', 9 ); // run before wpautop()

function stargazer_status_content( $content ) {

	if ( !is_singular() && has_post_format( 'status' ) && in_the_loop() && get_option( 'show_avatars' ) && ( have_comments() || comments_open() ) )
		$content .= ' <a class="comments-link" href="' . get_permalink() . '">' . number_format_i18n( get_comments_number() ) . '</a>';

	return $content;
}



add_action( 'wp_ajax_stargazer_editor_styles',         'stargazer_editor_styles_callback' );
add_action( 'wp_ajax_no_priv_stargazer_editor_styles', 'stargazer_editor_styles_callback' );

function stargazer_editor_styles_callback() {

	echo stargazer_get_color_primary_styles();

	die();
}

function stargazer_get_color_primary_styles() {

	$style = '';

		$hex = get_theme_mod( 'color_palette_primary', '2980b9' );
		$rgb = join( ', ', stargazer_hex_to_rgb( $hex ) );


			/* Color. */
			$style .= "a { color: rgba( {$rgb}, 0.75 ); } ";
			$style .= "a:hover, legend, mark, .comment-respond .required, pre, 
					.form-allowed-tags code, pre code, 
					.mejs-button button:hover::after, 
					.mejs-overlay-button:hover::after 
					{ color: #{$hex}; } ";

			/* Background color. */
			$style .= "input[type='submit'], input[type='reset'], input[type='button'], button, .page-links a, 
					.comment-reply-link, .comment-reply-login, .wp-calendar td.has-posts a, ul.sub-terms li a 
					{ background-color: rgba( {$rgb}, 0.8 ); } ";

			$style .= "legend, mark, pre, .form-allowed-tags code { background-color: rgba( {$rgb}, 0.1 ); } ";

			$style .= "input[type='submit']:hover, input[type='submit']:focus, 
			           input[type='reset']:hover, input[type='reset']:focus, 
			           input[type='button']:hover, input[type='button']:focus, 
			           button:focus, button:hover,
			           .page-links a:hover, .wp-calendar td.has-posts a:hover, .widget-title > .wrap,
				   #comments-number > .wrap, #reply-title > .wrap, .attachment-meta-title > .wrap, .widget-search > .search-form, 
				   ul.sub-terms li a:hover, .comment-reply-link:hover, .comment-reply-login:hover, 
					.mejs-time-rail .mejs-time-loaded
					{ background-color: #{$hex}; } ";

			/* Firefox chokes on this rule and drops the rule set, so we're separating it. */
			$style .= "::selection { background-color: #{$hex}; } ";

			/* border-color */
			$style .= "legend { border-color: rgba( {$rgb}, 0.15 ); } ";

			/* border-top-color */
			$style .= "body { border-top-color: #{$hex}; } ";

			/* Border bottom color. */
			$style .= ".entry-content a, .entry-summary a { border-bottom-color: rgba( {$rgb}, 0.15 ); } ";
			$style .= ".entry-content a:hover, .entry-summary a:hover { border-bottom-color: rgba( {$rgb}, 0.75 ); } ";
			$style .= "body, .widget-title, #comments-number, #reply-title,
			           .attachment-meta-title { border-bottom-color: #{$hex}; } ";

			
			/* border-color */
			$style .= "blockquote { background-color: rgba( {$rgb}, 0.85 ); } ";
			$style .= "blockquote blockquote { background-color: rgba( {$rgb}, 0.9 ); } ";

			/* outline-color */
			$style .= "blockquote { outline-color: rgba( {$rgb}, 0.85); } ";

	return $style;
}















?>