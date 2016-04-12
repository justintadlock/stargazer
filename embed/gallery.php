<div <?php post_class( 'wp-embed' ); ?>>

	<?php get_the_image( array( 'size' => 'stargazer-full' ) ); ?>

	<p class="wp-embed-heading">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</p><!-- .wp-embed-heading -->

	<div class="wp-embed-excerpt">
		<?php the_excerpt_embed(); ?>
		<?php $count = hybrid_get_gallery_item_count(); ?>
		<p class="gallery-count"><?php printf( _n( 'This gallery contains %s item.', 'This gallery contains %s items.', $count, 'stargazer' ), $count ); ?></p>
	</div><!-- .wp-embed-excerpt -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title() ?>

		<div class="wp-embed-meta">
			<?php stargazer_post_format_permalink(); ?>
			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->