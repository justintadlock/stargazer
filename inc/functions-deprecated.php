<?php
/**
 * Deprecated and removed functions.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Checks if a widget exists.  Pass in the widget class name.  This function is useful for
 * checking if the widget exists before directly calling `the_widget()` within a template.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 * @access     public
 * @param      string  $widget
 * @return     bool
 */
function stargazer_widget_exists( $widget ) {
	return hybrid_widget_exists( $widget );
}

/**
 * Gets the embed template used for embedding posts from the site.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_get_embed_template() {
	hybrid_get_embed_template();
}

/**
 * Adds support for the WordPress 'custom-background' theme feature.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_custom_background_setup() {}

/**
 * Registers custom backgrounds for the theme.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_default_backgrounds() {}

/**
 * Adds support for the WordPress 'custom-header' theme feature and registers custom headers.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_custom_header_setup() {}

/**
 * Registers custom image sizes for the theme.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_image_sizes() {}

/**
 * Registers nav menu locations.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_menus() {}

/**
 * Registers sidebars.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_sidebars() {}

/**
 * Registers custom layouts.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_layouts() {}

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_theme_setup() {}

/**
 * Enqueues scripts.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_enqueue_scripts() {}

/**
 * Loads stylesheets.
 *
 * @since      2.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_enqueue_styles() {}

/**
 * Registers stylesheets for use in the admin.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_admin_register_styles() {}

/**
 * Registers custom scripts.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_scripts() {}

/**
 * Registers custom stylesheets for the front end.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_register_styles() {}

/**
 * Callback function for adding editor styles.  Use along with the add_editor_style() function.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_get_editor_styles() {}

/**
 * Returns the active theme editor stylesheet URI.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_get_editor_stylesheet_uri() {}

/**
 * Returns the parent theme editor stylesheet URI.
 *
 * @since      3.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_get_parent_editor_stylesheet_uri() {}

/**
 * Adds the <body> class to the visual editor.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_tiny_mce_before_init() {}

/**
 * Removes the media player styles from the visual editor since we're loading our own.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_mce_css() {}

/**
 * Enqueues the styles for the "Appearance > Custom Header" screen in the admin.
 *
 * @since      1.0.0
 * @deprecated 4.0.0
 * @access     public
 * @return     void
 */
function stargazer_enqueue_admin_custom_header_styles( $hook_suffix ) {}

/**
 * Callback for the admin preview output on the "Appearance > Custom Header" screen.
 *
 * @since       1.0.0
 * @deprecated  2.0.0
 * @access      public
 * @return      void
 */
function stargazer_custom_header_admin_preview() {}

/**
 * Callback function for outputting the custom header CSS to `admin_head` on "Appearance > Custom Header".  See
 * the `css/admin-custom-header.css` file for all the style rules specific to this screen.
 *
 * @since       1.0.0
 * @deprecated  2.0.0
 * @access      public
 * @return      void
 */
function stargazer_custom_header_admin_head() {}
