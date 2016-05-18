<div <?php post_class( 'wp-embed' ); ?>>

	<?php if ( has_excerpt() ) : // If the image has an excerpt/caption. ?>

		<?php $src = wp_get_attachment_image_src( get_the_ID(), 'full' ); ?>

		<?php echo img_caption_shortcode( array( 'align' => 'aligncenter', 'width' => esc_attr( $src[1] ), 'caption' => get_the_excerpt() ), wp_get_attachment_image( get_the_ID(), 'full', false ) ); ?>

	<?php else : // If the image doesn't have a caption. ?>

		<?php echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) ); ?>

	<?php endif; // End check for image caption. ?>

	<p class="wp-embed-heading">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</p><!-- .wp-embed-heading -->

	<div class="wp-embed-content">
		<?php the_content(); ?>
	</div><!-- .wp-embed-content -->

	<?php do_action( 'embed_content' ); ?>

	<div class="wp-embed-footer">

		<?php the_embed_site_title(); ?>

		<div class="wp-embed-meta">
			<?php do_action( 'embed_content_meta' ); ?>
		</div><!-- .wp-embed-meta -->

	</div><!-- .wp-embed-footer -->

</div><!-- .wp-embed -->
