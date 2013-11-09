<?php

class Stargazer_Custom_Header {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	public function __construct() {
		/* Register late so child themes can overwrite. */
		add_action( 'after_setup_theme', array( $this, 'setup' ), 15 );
	}

	public function setup() {

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
				'wp-head-callback'       => array( $this, 'wp_head_callback' ),
				'admin-head-callback'    => array( $this, 'admin_head_callback' ),
				'admin-preview-callback' => array( $this, 'admin_preview_callback' ),
			)
		);

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
	}

	public function wp_head_callback() {

		if ( !display_header_text() )
			return;

		$text_color = get_header_textcolor();

		if ( empty( $text_color ) )
			return;

		$style = "color: #{$text_color};";

		$rgb = hybrid_hex_to_rgb( $text_color );

		$nav_style = "color: rgba( {$rgb['r']}, {$rgb['g']}, {$rgb['b']}, 0.75 );";

		$nav_style  = "#menu-secondary .menu-items > li > a { {$nav_style} }";
		$nav_style .= "#menu-secondary .menu-items > li > a:hover { color: #{$text_color}; }";

		echo "\n" . '<style type="text/css" id="custom-header-css">body.custom-header #site-title a { ' . trim( $style ) . ' }' . $nav_style . '</style>' . "\n";
	}

	public function admin_preview_callback() { ?>


			<header <?php stargazer_attr( 'header' ); ?>>

				<?php if ( display_header_text() ) : // If user chooses to display header text. ?>

					<hgroup id="branding">
						<h1 <?php stargazer_attr( 'site-title' ); ?>><a href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 <?php stargazer_attr( 'site-description' ); ?>><?php bloginfo( 'description' ); ?></h2>
					</hgroup><!-- #branding -->

				<?php endif; // End check for header text. ?>

			</header><!-- #header -->

			<?php if ( get_header_image() && !display_header_text() ) : // If there's a header image but no header text. ?>

				<a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>

			<?php elseif ( get_header_image() ) : // If there's a header image. ?>

				<img class="header-image" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />

			<?php endif; // End check for header image. ?>

	<?php }

	public function admin_head_callback() {

		$text_color = get_header_textcolor();

		$style = "color: #{$text_color};";

		echo "\n" . '<style type="text/css" id="custom-heder-css">'; ?>
			
			@import url(http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic|Merriweather+Sans:700,400,300);

			#header {
				overflow: hidden;
				max-width: 100%;
				padding: 24px 48px 0;
				background: #fff;
			}
			.header-image {
				max-width: 100%;
				height:    auto;
			}

			#site-title {
				vertical-align:  baseline;
				margin: 0 !important;
				font-size: 28px;
				font-family: 'Merriweather Sans', sans-serif;
				line-height: 1.5;
			}
			#site-title a { 
				<?php echo trim( $style ); ?>
				text-decoration: none;
				font-size: 28px;
				line-height: 28px;
			}
			#site-title a:hover {
					text-decoration: none;
					opacity: 0.75;
					border-bottom: 1px solid #d3d3d3;
			}
			#site-description {
				vertical-align:  baseline;
				margin:       0 0 24px;
				font-family:  'Lora', serif;
				font-size:    16px;
				line-height:  16px;
				font-weight:  400;
				font-style:   italic;
				color:        #656565 !important;
				opacity:      0.5;
			}



		<?php echo '</style>' . "\n";
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

Stargazer_Custom_Header::get_instance();
