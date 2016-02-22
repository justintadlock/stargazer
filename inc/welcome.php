<?php
/**
 * Handles the theme welcome/info screen in the admin.
 *
 * @package    Stargazer
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013 - 2016, Justin Tadlock
 * @link       http://themehybrid.com/themes/stargazer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Hook into the admin menu.
add_action( 'admin_menu', 'stargazer_admin_menu' );

/**
 * Adds a custom themes sub-page.
 *
 * @since  2.1.0
 * @access public
 * @return void
 */
function stargazer_admin_menu() {
	$theme = wp_get_theme( get_template() );

	$page = add_theme_page( $theme->display( 'Name' ), $theme->display( 'Name' ), 'edit_theme_options', 'stargazer', 'stargazer_welcome_page' );

	if ( $page )
		add_action( "admin_head-{$page}", 'stargazer_welcome_page_css' );
}

/**
 * Outputs some custom CSS to the welcome screen.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function stargazer_welcome_page_css() { ?>

	<style type="text/css" media="screen">
		.appearance_page_stargazer .three-col { clear: both; }
		.appearance_page_stargazer .col .dashicons { margin-top: 3px; margin-right: 4px; }
	</style>
<?php }

/**
 * Outputs the custom admin screen.
 *
 * @since  2.1.0
 * @access public
 * @return void
 */
function stargazer_welcome_page() {

	$theme = wp_get_theme( get_template() ); ?>

	<div class="wrap about-wrap">

		<h1><?php echo $theme->display( 'Name' ); ?></h1>

		<div class="two-col">

			<div class="col about-text">
				<?php echo $theme->display( 'Description' ); ?>
			</div><!-- .col -->

			<div class="col">
				<img src="<?php echo trailingslashit( get_template_directory_uri() ); ?>screenshot.png" alt="" />
			</div><!-- .col -->

		</div><!-- .two-col -->

		<div class="three-col">

			<div class="col">

				<h3><i class="dashicons dashicons-sos"></i><?php esc_html_e( 'Help &amp; Support', 'stargazer' ); ?></h3>

				<p>
					<?php esc_html_e( 'Instead of giving you crippleware ("lite" themes) and selling the real theme, I believe it is better to offer you a useful service, which is the Theme Hybrid club. By joining, you will get full theme support directly from the theme author via the forums or live chat.', 'stargazer' ); ?>
				</p>

				<p>
					<a class="button button-primary" href="http://themehybrid.com/club" target="_blank"><?php esc_html_e( 'Join The Club', 'stargazer' ); ?></a>
				</p>

			</div><!-- .col -->

			<div class="col">

				<h3><i class="dashicons dashicons-admin-appearance"></i><?php esc_html_e( 'Child Themes', 'stargazer' ); ?></h3>

				<p>
					<?php esc_html_e( 'Are you getting tired of your current design or do you want to try something different than the default? No problem. There are many child themes available for download (with more on the way). Browse them and choose one that fits your site.', 'stargazer' ); ?>
				</p>

				<p>
					<a class="button button-primary" href="http://themehybrid.com/themes/stargazer#row-child-themes" target="_blank"><?php esc_html_e( 'View Child Themes', 'stargazer' ); ?></a>
				</p>

			</div><!-- .col -->

			<div class="col">

			<?php $plugins = stargazer_get_recommended_plugins(); ?>

			<?php if ( $plugins ) : ?>


				<h3><i class="dashicons dashicons-admin-plugins"></i><?php esc_html_e( 'Supported Plugins', 'stargazer' ); ?></h3>

				<p>
					<?php esc_html_e( 'Do you need extra functionality? Stargazer has built-in support for the following plugins.', 'stargazer' ); ?>
				</p>

				<ul>
					<?php foreach ( $plugins as $plugin ) : ?>
						<li><a href="<?php echo esc_url( "https://wordpress.org/plugins/{$plugin->slug}" ); ?>" target="_blank"><?php echo esc_html( $plugin->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>

			<?php endif; ?>

			</div><!-- .col -->

		</div><!-- .three-col -->

	</div><!-- .wrap -->

<?php }

/**
 * Returns an array of recommended plugins.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function stargazer_get_recommended_plugins() {

	$api = get_transient( 'stargazer_recommended_plugins' );

	if ( ! $api ) {

		// If `plugins_api()` isn't available, load the file that holds the function
		if ( ! function_exists( 'plugins_api' ) && file_exists( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' ) )
			require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin-install.php' );

		// Make sure the function exists.
		if ( function_exists( 'plugins_api' ) ) {

			$fields = array(
				'downloadlink'      => false,
				'short_description' => false,
				'description'       => false,
				'sections'          => false,
				'tested'            => false,
				'requires'          => false,
				'rating'            => false,
				'ratings'           => false,
				'downloaded'        => false,
				'last_updated'      => false,
				'added'             => false,
				'tags'              => false,
				'compatibility'     => false,
				'homepage'          => false,
				'versions'          => false,
				'reviews'           => false,
				'banners'           => false,
				'icons'             => false,
				'active_installs'   => false,
				'group'             => false,
				'contributors'      => false
			);

			$api = plugins_api(
				'query_plugins',
				array( 'author' => 'greenshady', 'per_page' => -1, 'fields'   => $fields )
			);

			// If no error, let's roll.
			if ( ! is_wp_error( $api ) ) {

				// If this is an array, let's make it an object.
				if ( is_array( $api ) )
					$api = (object) $api;

				// Only proceed if we have an object.
				if ( is_object( $api ) ) {

					// Set the transient with the new data.
					set_transient( 'stargazer_recommended_plugins', $api, 14 * DAY_IN_SECONDS );
				}
			}
		}
	}

	// Get recommended plugin slugs.
	$rec = array(
		'clean-my-archives',
		'custom-background-extended',
		'custom-header-extended',
		'whistles',
		'widgets-reloaded'
	);

	$plugins = array();

	if ( is_object( $api ) && isset( $api->plugins ) && is_array( $api->plugins ) ) {

		foreach ( $api->plugins as $plugin ) {

			if ( in_array( $plugin->slug, $rec ) )
				$plugins[ $plugin->slug ] = $plugin;
		}

		ksort( $plugins );
	}

	return $plugins;
}
