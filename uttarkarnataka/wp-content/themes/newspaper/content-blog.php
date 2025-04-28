<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<?php the_title( sprintf( '<h2 class="entry-title" ' . hybrid_get_attr( 'entry-title' ) . '><a href="%s" rel="bookmark" itemprop="url">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        
        <div class="clearfix"></div>

	<?php newspaper_posted_on(); ?>

	<?php if ( of_get_option( 'newspaper_featured_image', 'on' ) == 'on' ) { ?>
			<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'newspaper-featured', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?></a>
	<?php endif; ?>
			<div class="clearfix"></div>
		<?php } ?>

	<div class="entry-summary" <?php hybrid_attr( 'entry-summary' ); ?>>
		<?php the_content(); ?>
	</div><!-- .entry-summary -->
	
</article><!-- #post-## -->