<?php if ( pings_open() && ! comments_open() ) : ?>

	<p class="comments-closed pings-open">
		<?php
			// Translators: 1 and 2 are placeholders for HTML. The order can't be changed.
			printf( __( 'Comments are closed, but %1$strackbacks%2$s and pingbacks are open.', 'stargazer' ), '<a href="' . esc_url( get_trackback_url() ) . '">', '</a>' );
		?>
	</p><!-- .comments-closed .pings-open -->

<?php elseif ( ! comments_open() ) : ?>

	<p class="comments-closed">
		<?php _e( 'Comments are closed.', 'stargazer' ); ?>
	</p><!-- .comments-closed -->

<?php endif; ?>