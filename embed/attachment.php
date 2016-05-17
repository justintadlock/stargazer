<div <?php post_class( 'wp-embed' ); ?>>

	<?php hybrid_attachment(); // Function for handling non-image attachments. ?>

	<p class="wp-embed-heading">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</p><!-- .wp-embed-heading -->

	<div class="wp-embed-excerpt">
		<?php the_excerpt_embed(); ?>
	</div><!-- .wp-embed-excerpt -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title() ?>

		<div class="wp-embed-meta">
			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->