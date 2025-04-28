<?php if ( is_singular( 'post' ) ) : // If viewing a single post page. ?>

	<div class="loop-nav">
		<?php previous_post_link( '<div class="prev">' . __( 'Previous Post: %link', 'newspaper' ) . '</div>', '%title' ); ?>
		<?php next_post_link(     '<div class="next">' . __( 'Next Post: %link',     'newspaper' ) . '</div>', '%title' ); ?>
	</div><!-- .loop-nav -->

<?php elseif ( is_home() || is_archive() || is_search() ) : // If viewing the blog, an archive, or search results. ?>
	
	<?php 
		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return;
		}
	?>

	<?php loop_pagination(
		array( 
			'prev_text' => _x( '&larr; Previous', 'posts navigation', 'newspaper' ), 
			'next_text' => _x( 'Next &rarr;',     'posts navigation', 'newspaper' )
		) 
	); ?>

<?php endif; // End check for type of page being viewed. ?>