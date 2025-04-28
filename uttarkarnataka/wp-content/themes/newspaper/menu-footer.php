<?php
// Check if there's a menu assigned to the 'footer' location.
if ( ! has_nav_menu( 'footer' ) ) {
	return;
}
?>

<nav class="footer-nav" role="navigation" <?php hybrid_attr( 'menu' ); ?>>
	<?php wp_nav_menu(
		array(
			'theme_location'  => 'footer',
			'container_class' => 'menu-wrapper',
			'menu_id'         => 'footer-menu',
			'menu_class'      => 'footer-menu',
			'fallback_cb'     => ''
		)
	); ?>
</nav>