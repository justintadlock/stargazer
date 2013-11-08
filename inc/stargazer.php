<?php



class Stargazer_Theme_Setup {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	public $prefix = 'stargazer';

	public $directory = '';

	public $directory_uri = '';

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ), 5 );
	}

	public function theme_setup() {

		//add_theme_support( 'hybrid-core-theme-settings' );
		//add_theme_support( 'hybrid-core-shortcodes' );
		//add_theme_support( 'hybrid-core-deprecated' );

		/* Load widgets. */
		add_theme_support( 'hybrid-core-widgets' );

		/* Load scripts. */
		add_theme_support( 'hybrid-core-scripts', array( 'comment-reply', 'mobile-toggle' ) );

		/* Theme layouts. */
		add_theme_support( 
			'theme-layouts', 
			array(
				'1c'        => __( 'One Column Wide',                'stargazer' ),
				'1c-narrow' => __( 'One Column Narrow',              'stargazer' ),
				'2c-l'      => __( 'Two Columns: Content - Sidebar', 'stargazer' ),
				'2c-r'      => __( 'Two Columns: Content - Sidebar', 'stargazer' )
			),
			array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
		);

		/* Custom colors */
		add_theme_support( 'color-palette',
			array(
				'callback'         => 'stargazer_register_colors',
				'wp-head-callback' => 'stargazer_colors_wp_head_callback'
			)
		);

		/* Ignore some selectors for the Color Palette extension in the theme customizer. */
		add_filter( 'color_palette_preview_js_ignore', 'stargazer_cp_preview_js_ignore', 10, 3 );

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

		/* Add support for custom theme fonts. */
		//add_theme_support( 'theme-fonts', array( 'callback' => 'socially_awkward_register_fonts' ) );

		/* Automatically add feed links to <head>. */
		add_theme_support( 'automatic-feed-links' );

		/* Whistles plugin. */
		add_theme_support( 'whistles', array( 'styles' => true ) );

		/* Post formats. */
		add_theme_support( 
			'post-formats', 
			array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
		);

		/* Add custom scripts. */
		add_action( 'wp_enqueue_scripts', 'stargazer_enqueue_scripts' );


		/* Editor styles. */

		$editor_styles   = array();
		$editor_styles[] = trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css';

		if ( is_child_theme() )
			$editor_styles[] = trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css';

		$editor_styles[] = get_locale_stylesheet_uri();
		$editor_styles[] = add_query_arg( 'action', 'stargazer_editor_styles', admin_url( 'admin-ajax.php' ) );

		add_editor_style( $editor_styles );

		/* Handle content width for embeds and images. */
		// Note: this is the largest size based on the theme's responsive breakpoints.
		hybrid_set_content_width( 1025 );

		add_action( 'init',                   'stargazer_register_image_sizes' );
		add_action( 'init',                   'stargazer_register_menus', 11 );
		add_action( 'widgets_init',           'stargazer_register_sidebars' );
		add_filter( 'body_class',             'stargazer_body_class' );
		add_filter( 'excerpt_length',         'stargazer_excerpt_length' );
		add_filter( 'theme_mod_theme_layout', 'stargazer_mod_theme_layout', 15 );
		add_filter( 'hybrid_attr_sidebar',    'stargazer_sidebar_subsidiary_class', 10, 2 );
		add_filter( 'hybrid_default_backgrounds', 'stargazer_default_backgrounds' );
	}


	/**
	 * Returns the instance.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Stargazer_Theme_Setup::get_instance();

function stargazer_register_image_sizes() {

	set_post_thumbnail_size( 175, 131, true );

	add_image_size( 'stargazer-full', 1025, 9999, false );
}

function stargazer_register_menus() {
	register_nav_menu( 'primary',   _x( 'Primary',   'nav menu location', 'stargazer' ) );
	register_nav_menu( 'secondary', _x( 'Secondary', 'nav menu location', 'stargazer' ) );
	register_nav_menu( 'social',    _x( 'Social',    'nav menu location', 'stargazer' ) );
}

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

function stargazer_mod_theme_layout( $layout ) {

	if ( is_attachment() ) {
		$post_layout = get_post_layout( get_queried_object_id() );

		if ( 'default' === $post_layout && '1c-narrow' !== $layout )
			$layout = '1c';
	}

	return $layout;
}


function stargazer_default_backgrounds( $backgrounds ) {

	$_backgrounds= array(
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


function stargazer_enqueue_scripts() {

	wp_register_script(
		'stargazer',
		hybrid_locate_theme_file( array( 'js/stargazer.js' ) ),
		array( 'jquery' ),
		null,
		true
	);


	/*
	wp_localize_script(
		'stargazer',
		'stargazer',
		array(
			'font_primary'   => 'Open Sans',
			'font_secondary' => 'Droid Serif',
			'font_headlines' => 'Open Sans',
		)
	);*/

	wp_enqueue_script( 'stargazer' );

}

function stargazer_body_class( $classes ) {

	if ( is_home() || is_archive() || is_search() )
		$classes[] = 'plural';

	if ( display_header_text() )
		$classes[] = 'display-header-text';

	if ( stargazer_get_logo_image() )
		$classes[] = 'custom-logo';

	return $classes;
}

function stargazer_excerpt_length( $length ) {
	return 30;
}



function stargazer_sidebar_subsidiary_class( $attr, $context ) {

	if ( 'subsidiary' === $context ) {

		/*
		 * Note that we're using the global $sidebars_widgets variable here. This is because 
		 * core has marked wp_get_sidebars_widgets() as a private function. Therefore, this 
		 * leaves us with $sidebars_widgets for figuring out the widget count.
		 * @link http://codex.wordpress.org/Function_Reference/wp_get_sidebars_widgets
		 */
		global $sidebars_widgets;

		if ( is_array( $sidebars_widgets ) && !empty( $sidebars_widgets[ $context ] ) ) {
			$count = count( $sidebars_widgets[ $context ] );

			if ( !( $count % 3 ) || $count % 2 )
				$attr['class'] .= ' sidebar-col-3';

			elseif ( !( $count % 2 ) )
				$attr['class'] .= ' sidebar-col-2';

			else
				$attr['class'] .= ' sidebar-col-1';

		}

	}

	return $attr;
}