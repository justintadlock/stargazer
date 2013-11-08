<?php

/* Call late so child themes can override. */
add_action( 'after_setup_theme', 'stargazer_custom_background_setup', 15 );

function stargazer_custom_background_setup() {


	add_theme_support(
		'custom-background',
		array(
			'default-color' => '2d2d2d',
			'default-image' => '',
		)
	);
}
