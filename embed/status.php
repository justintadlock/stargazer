<div <?php post_class( 'wp-embed' ); ?>>

	<?php get_the_image( array( 'size' => 'stargazer-full', 'order' => array( 'featured', 'attachment' ) ) ); ?>

		<?php if ( get_option( 'show_avatars' ) ) : // If avatars are enabled. ?>

	<p class="wp-embed-heading">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_avatar( get_the_author_meta( 'email' ) ); ?></a>
	</p><!-- .wp-embed-heading -->

		<?php endif; // End avatars check. ?>

	<div class="wp-embed-content">
		<?php the_content(); ?>
	</div><!-- .wp-embed-content -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title() ?>

		<div class="wp-embed-meta">
			<?php stargazer_post_format_permalink(); ?>
			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->