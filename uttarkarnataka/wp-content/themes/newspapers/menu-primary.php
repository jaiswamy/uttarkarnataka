<?php if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location. ?>
	
	<div id="primary-bar">

			<nav id="primary-nav" class="main-navigation" role="navigation" <?php hybrid_attr( 'menu' ); ?>>

				<?php wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu sf-menu',
						'walker'         => new Newspaper_Custom_Nav_Walker
					)
				); ?>

			</nav><!-- #primary-nav -->

	</div>

<?php endif; // End check for menu. ?>