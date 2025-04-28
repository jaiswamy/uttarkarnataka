<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'newspaper-loop', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?></a>
	<?php endif; ?>

	<?php the_title( sprintf( '<h2 class="entry-title" ' . hybrid_get_attr( 'entry-title' ) . '><a href="%s" rel="bookmark" itemprop="url">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php newspaper_posted_on(); ?>

	<div class="entry-summary" <?php hybrid_attr( 'entry-summary' ); ?>>
		<?php echo wp_trim_words( get_the_excerpt(), apply_filters( 'freshlife_loop_grid_excerpt', 20 ) ); ?>
	</div><!-- .entry-summary -->
	
</article><!-- #post-## -->