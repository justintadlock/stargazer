<?php hybrid_get_header( 'embed' ); ?>

	<?php if ( have_posts() ) : // Checks if any posts were found. ?>

		<?php while ( have_posts() ) : // Begins the loop through found posts. ?>

			<?php the_post(); // Loads the post data. ?>

			<?php stargazer_get_embed_template(); // Loads the embed/*.php template. ?>

		<?php endwhile; // End found posts loop. ?>

	<?php else : // If no posts were found. ?>

		<?php locate_template( array( 'embed/error.php' ), true ); // Loads the embed/error.php template. ?>

	<?php endif; // End check for posts. ?>

<?php hybrid_get_footer( 'embed' ); ?>
