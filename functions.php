<?php
/**
 * "The universe is vast and we are so small. There is only one thing we can ever truly control...Whether
 * we are good or evil." ~ Oma Desala (Stargate SG-1)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Stargazer
 * @subpackage Functions
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Get the template directory and make sure it has a trailing slash.
$stargazer_dir = trailingslashit( get_template_directory() );

// Load the Hybrid Core framework and launch it.
require_once( $stargazer_dir . 'library/hybrid.php' );
new Hybrid();

// Load theme-specific files.
require_once( $stargazer_dir . 'inc/custom-background.php' );
require_once( $stargazer_dir . 'inc/custom-header.php'     );
require_once( $stargazer_dir . 'inc/custom-colors.php'     );
require_once( $stargazer_dir . 'inc/welcome.php'           );

// Set up the theme early.
add_action( 'after_setup_theme', 'stargazer_theme_setup', 5 );

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_theme_setup() {

	// Load files.
	require_once( trailingslashit( get_template_directory() ) . 'inc/stargazer.php' );
	require_once( trailingslashit( get_template_directory() ) . 'inc/template.php'  );
	require_once( trailingslashit( get_template_directory() ) . 'inc/customize.php' );

	// Theme layouts.
	add_theme_support( 'theme-layouts', array( 'default' => '2c-l' ) );

	// Enable custom template hierarchy.
	add_theme_support( 'hybrid-core-template-hierarchy' );

	// The best thumbnail/image script ever.
	add_theme_support( 'get-the-image' );

	// Breadcrumbs. Yay!
	add_theme_support( 'breadcrumb-trail' );

	// Nicer [gallery] shortcode implementation.
	add_theme_support( 'cleaner-gallery' );

	// Automatically add feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Support selective refresh of widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Whistles plugin.
	add_theme_support( 'whistles', array( 'styles' => true ) );

	// Post formats.
	add_theme_support(
		'post-formats',
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' )
	);

	// Adds custom logo support
	add_theme_support(
		'custom-logo',
		array(
			'height'     => 78,
			'flex-width' => true
		)
	);

	// Editor styles.
	add_editor_style( stargazer_get_editor_styles() );

	// Handle content width for embeds and images.
	// Note: this is the largest size based on the theme's various layouts.
	hybrid_set_content_width( 1025 );
}
