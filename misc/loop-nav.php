<?php if ( is_singular( 'post' ) ) : // If viewing a single post page. ?>

	<div class="loop-nav">
		<?php previous_post_link( '<div class="prev">' . __( 'Previous Post: %link', 'stargazer' ) . '</div>', '%title' ); ?>
		<?php next_post_link(     '<div class="next">' . __( 'Next Post: %link',     'stargazer' ) . '</div>', '%title' ); ?>
	</div><!-- .loop-nav -->

<?php elseif ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>

	<?php loop_pagination(
		array( 
			'prev_text' => sprintf( __( '%s Previous', 'posts navigation', 'stargazer' ), is_rtl() ? '<span class="meta-nav">&rarr;</span>' : '<span class="meta-nav">&larr;</span>' ), 
			'next_text' => sprintf( __( 'Next %s',     'posts navigation', 'stargazer' ), is_rtl() ? '<span class="meta-nav">&larr;</span>' : '<span class="meta-nav">&rarr;</span>' )
		) 
	); ?>

<?php endif; ?>