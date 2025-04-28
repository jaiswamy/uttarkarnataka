<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="page-title" ' . hybrid_get_attr( 'entry-title' ) . '>', '</h1>' ); ?>

		<?php newspaper_posted_on(); ?>
	</header><!-- .entry-header -->

	<?php if ( of_get_option( 'newspaper_featured_image', 'on' ) == 'on' ) { ?>
			<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'newspaper-featured', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?>
	<?php endif; ?>
			<div class="clearfix"></div>
		<?php } ?>

	<div class="entry-content" <?php hybrid_attr( 'entry-content' ); ?>>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'newspaper' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'newspaper' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'newspaper' ) );

			if ( ! newspaper_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
			$meta_text = __( '<strong>Tags:</strong> %2$s', 'newspaper' );
				
			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<span class="entry-cats"><strong>Filed in:</strong> %1$s</span> <span class="entry-tags"><strong>Tags:</strong> %2$s</span>', 'newspaper' );
				} else {
					$meta_text = __( '<span class="entry-cats"><strong>Filed in:</strong> %1$s</span>', 'newspaper' );
				}
			} // end check for categories on this blog
			
			printf(
				$meta_text,
				$category_list,
				$tag_list
			);
		?>

	</footer><!-- .entry-footer -->

	<div class="clearfix"></div>

	<?php newspaper_post_author(); ?>

	<?php newspaper_social_share(); ?>

	<?php newspaper_related_posts() // Related posts. ?>
	
</article><!-- #post-## -->