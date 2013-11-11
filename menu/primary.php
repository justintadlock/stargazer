<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>

	<nav <?php hybrid_attr( 'menu', 'primary' ); ?>>

		<div class="assistive-text skip-link">
			<a href="#content"><?php _e( 'Skip to content', 'stargazer' ); ?></a>
		</div><!-- .skip-link -->

		<h3 class="menu-toggle">
			<span class="screen-reader-text"><?php _e( 'Navigation', 'stargazer' ); ?></span>
		</h3><!-- .menu-toggle -->

		<?php wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => '',
				'menu_id'         => 'menu-primary-items',
				'menu_class'      => 'menu-items',
				'fallback_cb'     => '',
				'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">%s</ul>' . get_search_form( false ) . '</div>'
			)
		); ?>

	</nav><!-- #menu-primary -->

<?php endif; // End check for menu. ?>