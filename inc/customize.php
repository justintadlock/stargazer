<?php

/* Theme Customizer setup. */
add_action( 'customize_register', 'stargazer_customize_register' );

function stargazer_enqueue_customizer_scripts() {
		wp_enqueue_script(
			'stargazer-customizer',
			trailingslashit( get_template_directory_uri() ) . 'js/customize.js',
			array( 'jquery' ),
			null,
			true
		);
}

function stargazer_customize_register( $wp_customize ) {

	/* Load JavaScript files. */
	add_action( 'customize_preview_init', 'stargazer_enqueue_customizer_scripts' );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'postMessage';

	/* Remove the WordPress background image control. */
	$wp_customize->remove_control( 'background_image' );

	/* Add our custom background image control. */
	$wp_customize->add_control( 
		new Hybrid_Customize_Control_Background_Image( $wp_customize ) 
	);
}
