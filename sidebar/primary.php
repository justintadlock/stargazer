<?php if ( ! in_array( hybrid_get_theme_layout(), array( '1c', '1c-narrow' ) ) ) : // If not a one-column layout. ?>

	<aside <?php hybrid_attr( 'sidebar', 'primary' ); ?>>

		<h3 id="sidebar-primary-title" class="screen-reader-text"><?php
			// Translators: %s is the sidebar name. This is the sidebar title shown to screen readers.
			printf( _x( '%s Sidebar', 'sidebar title', 'stargazer' ), hybrid_get_sidebar_name( 'primary' ) );
		?></h3>

		<?php if ( is_active_sidebar( 'primary' ) ) : // If the sidebar has widgets. ?>

			<?php dynamic_sidebar( 'primary' ); // Displays the primary sidebar. ?>

		<?php else : // If the sidebar has no widgets. ?>

			<?php if ( stargazer_widget_exists( 'WP_Widget_Categories' ) ) : ?>

				<?php the_widget(
					'WP_Widget_Categories',
					array( 'dropdown' => true, 'hierarchical' => true ),
					array(
						'before_widget' => '<section class="widget widget_categories">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>'
					)
				); ?>

			<?php endif; ?>

			<?php if ( stargazer_widget_exists( 'WP_Widget_Tag_Cloud' ) ) : ?>

				<?php the_widget(
					'WP_Widget_Tag_Cloud',
					array(),
					array(
						'before_widget' => '<section class="widget widget_tag_cloud">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>'
					)
				); ?>

			<?php endif; ?>

			<?php if ( stargazer_widget_exists( 'WP_Widget_Meta' ) ) : ?>

				<?php the_widget(
					'WP_Widget_Meta',
					array(),
					array(
						'before_widget' => '<section class="widget widget_meta">',
						'after_widget'  => '</section>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>'
					)
				); ?>

			<?php endif; ?>

		<?php endif; // End widgets check. ?>

	</aside><!-- #sidebar-primary -->

<?php endif; // End layout check. ?>