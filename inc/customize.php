<?php


add_action( 'delete_attachment', 'stargazer_custom_logo_delete_attachment' );

function stargazer_custom_logo_delete_attachment( $post_id ) {

	$logo = get_theme_mod( 'logo_image_data' );

	if ( $post_id == $logo['attachment_id'] ) {
		remove_theme_mod( 'logo_image'      );
		remove_theme_mod( 'logo_image_data' );
	}
}

add_action( 'customize_register', 'stargazer_customize_register' );

add_theme_support(
	'custom-logo',
	array(
		'max-width'  => 100,
		'max-height' => 65,
		'hard_crop'  => false,
	)
);


function stargazer_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'postMessage';

	/* Load our custom logo image control. */
	require_once( trailingslashit( get_template_directory() ) . 'inc/customize-control-logo-image.php' );
	require_once( trailingslashit( get_template_directory() ) . 'inc/customize-setting-logo-image.php' );


	/* Remove the WordPress background image control. */
	$wp_customize->remove_control( 'background_image' );

	/* Add our custom background image control. */
	$wp_customize->add_control( 
		new Hybrid_Customize_Control_Background_Image( $wp_customize ) 
	);


	/* === Logo Image === */

	if ( current_theme_supports( 'custom-logo' ) ) {

		$logo_image = get_theme_support( 'custom-logo' );

		if ( !is_array( $logo_image[0] ) )
			return;

		$wp_customize->add_section(
			'logo-image',
			array(
				'title'       => esc_html__( 'Logo Image', 'stargazer' ),
				'description' => sprintf( esc_html__( 'The maximum width is %1$spx. The maximum height is %2$spx. Larger images will be resized and cropped.', 'stargazer' ), 100, 65 ),
				'priority'    => 55,
				'capability'  => 'edit_theme_options'
			)
		);

		$wp_customize->add_setting(
			new Stargazer_Customize_Setting_Logo_Image(
				$wp_customize,
				'logo_image',
				array(
					'default'        => '',
					'type'           => 'theme_mod',
					'capability'     => 'edit_theme_options',
					'theme_supports' => 'custom-logo',
				)
			)
		);

		$wp_customize->add_control(
			new Stargazer_Customize_Control_Logo_Image(
				$wp_customize, 
				'logo_image',
				array(
					'label'    => esc_html__( 'Logo Image', 'stargazer' ),
					'section'  => 'logo-image',
					'setting'  => 'logo_image',
					'priority' => 5,
				)
			)
		);


	}
}



function stargazer_get_logo_image() {
	return get_theme_mod( 'logo_image' );
}

function stargazer_get_custom_logo() {

	$data = get_theme_mod( 'logo_image_data' ); // @todo - use theme defaults if these are not set.

	$data = apply_filters( 'stargazer_logo_image_data', $data );

	return (object) $data;
}


add_filter( 'display_media_states', 'stargazer_display_media_states' );

function stargazer_display_media_states( $states ) {
	global $post;

	$is_logo = get_post_meta( $post->ID, '_wp_attachment_is_custom_logo', true );

	if ( $is_logo )
		$states[] = __( 'Logo Image', 'stargazer' );

	return $states;
}











