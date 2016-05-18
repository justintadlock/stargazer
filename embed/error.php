<div class="wp-embed">

	<p class="wp-embed-heading">
		<?php _e( 'Nothing found', 'stargazer' ); ?>
	</p>

	<div class="wp-embed-content">
		<?php echo wpautop( __( 'Apologies, but no entries were found.', 'stargazer' ) ); ?>
	</div><!-- .wp-embed-content -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">
		<?php the_embed_site_title() ?>
	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->