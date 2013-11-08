<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<?php get_the_image( array( 'size' => 'stargazer-full', 'split_content' => true, 'scan_raw' => true, 'scan' => true, 'order' => array( 'scan_raw', 'scan', 'featured', 'attachment' ) ) ); ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<div class="entry-byline">
				<?php hybrid_post_terms( array( 'taxonomy' => 'portfolio', 'text' => __( 'Portfolio: %s', 'stargazer' ) ) ); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
			<?php edit_post_link(); ?>
		</footer><!-- .entry-footer -->

	<?php else : // If not viewing a single post. ?>

		<?php get_the_image( array( 'size' => 'large', 'caption' => true, 'image_scan' => true, 'width' => hybrid_get_content_width() ) ); ?>

		<header class="entry-header">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<div class="entry-byline">
				<?php hybrid_post_terms( array( 'taxonomy' => 'portfolio', 'text' => __( 'Portfolio: %s', 'stargazer' ) ) ); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->