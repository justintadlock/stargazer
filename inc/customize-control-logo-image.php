<?php




class Stargazer_Customize_Control_Logo_Image extends WP_Customize_Image_Control {

	public function __construct( $manager, $id, $args ) {
		parent::__construct( $manager, $id, $args );

		$this->get_url = 'stargazer_get_logo_image';
	}

	public function tab_uploaded() {
		$logos = get_posts( 
			array(
				'post_type'  => 'attachment',
				'meta_key'   => '_wp_attachment_is_custom_logo',
				'meta_value' => $this->manager->get_stylesheet(),
				'orderby'    => 'none',
				'nopaging'   => true,
			) 
		);

		?><div class="uploaded-target"></div><?php

		if ( empty( $logos ) )
			return;

		foreach ( (array) $logos as $logo ) {
			$src = wp_get_attachment_image_src( $logo->ID, array( 100, 65 ) );
			$this->print_tab_image( $src[0] );
		}
	}
}

?>