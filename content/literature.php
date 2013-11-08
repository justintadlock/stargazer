<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_singular( get_post_type() ) ) : // If viewing a single post. ?>

		<header class="entry-header">

			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>

			<div class="entry-byline">
				<span <?php hybrid_attr( 'entry-author' ); ?>><?php the_author_posts_link(); ?></span>
				<?php edit_post_link(); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php the_terms( get_the_ID(), 'literary_form', '<span ' . hybrid_get_attr( 'entry-terms', 'literary_form' ) . '>' . __( 'Form:', 'stargazer' ) . ' ', ', ', '</span>' ); ?>
			<?php the_terms( get_the_ID(), 'literary_technique', '<br /><span ' . hybrid_get_attr( 'entry-terms', 'literary_technique' ) . '>' . __( 'Technique:', 'stargazer' ) . ' ', ', ', '</span>' ); ?>
			<?php the_terms( get_the_ID(), 'literary_genre', '<br /><span ' . hybrid_get_attr( 'entry-terms', 'literary_genre' ) . '>' . __( 'Genre:', 'stargazer' ) . ' ', ', ', '</span>' ); ?>
		</footer><!-- .entry-footer -->

	<?php else : // If not viewing a single post. ?>

		<?php get_the_image( array( 'size' => 'stargazer-full' ) ); ?>

		<header class="entry-header">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<div class="entry-byline">
				<span <?php hybrid_attr( 'entry-author' ); ?>><?php the_author_posts_link(); ?></span>
				<?php edit_post_link(); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-summary' ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	<?php endif; // End single post check. ?>

</article><!-- .entry -->