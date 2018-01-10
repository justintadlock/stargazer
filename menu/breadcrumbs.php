<?php if ( function_exists( 'breadcrumb_trail' ) ) : // Check for breadcrumb support. ?>

	<?php breadcrumb_trail(
		array(
			'container'     => 'nav',
			'show_browse'   => false,
			'show_on_front' => false,
		)
	); ?>

<?php endif; // End check for breadcrumb support. ?>