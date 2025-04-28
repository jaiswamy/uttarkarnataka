<?php 
global $cat;

// Get the category ID.
$category = get_category( get_query_var( 'cat' ), false );
$style = get_tax_meta( $category->term_id, 'newspaper_featured_layout', false );

// Set the default value for the style.
if ( empty( $style ) ) {
	$style = 'list';
}

// Get the tag ID.
$tag = get_tax_meta( $category->term_id, 'newspaper_featured_tag', false );

if ( $tag !== '' ) : ?>

<?php if ( 'classic' === $style ) : ?>

	<?php
		// Posts query arguments.
		$query = array(
			'post_type'      => 'post',
			'posts_per_page' => 1,
			'tag_id'         => $tag,
			'cat'            => $cat
		);

		// Allow dev to filter the query.
		$args = apply_filters( 'newspaper_featured_posts_args', $query );

		// The post query
		$featured = new WP_Query( $args );
	?>

	<?php if ( $featured->have_posts() ) : ?>

			<div id="featured-content-2" class="clearfix">
					<ul>
						
						<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
							
							<li class="hentry post">
								<article <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<?php the_title( sprintf( '<h2 class="entry-title" ' . hybrid_get_attr( 'entry-title' ) . '><a href="%s" itemprop="url" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'newspaper-featured', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?></a>
	<?php endif; ?>

	<div class="entry-summary">
		<?php echo wp_trim_words( get_the_excerpt(), apply_filters( 'newspaper_featured_excerpt', 35 ) ); ?>
	</div>

	<?php newspaper_posted_on(); ?>

</article><!-- #post-## -->
							</li>

						<?php endwhile; ?>

					</ul>
			</div>

		<?php endif; ?>

		<?php elseif ( 'slider' === $style ) : ?>

			<?php
		// Posts query arguments.
		$query = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'tag_id'         => $tag,
			'cat'            => $cat
		);

		// Allow dev to filter the query.
		$args = apply_filters( 'newspaper_featured_posts_args', $query );

		// The post query
		$featured = new WP_Query( $args );
	?>

	<?php if ( $featured->have_posts() ) : ?>

			<div id="featured-content" class="slider clearfix">
				<div class="flexslider">
					<ul class="slides">
						
						<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
							
							<li class="hentry post">
								<article <?php post_class(); ?> <?php hybrid_attr( 'post' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'newspaper-featured', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title() ) ) ); ?></a>
	<?php endif; ?>

	<?php the_title( sprintf( '<h2 class="entry-title" ' . hybrid_get_attr( 'entry-title' ) . '><a href="%s" itemprop="url" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

</article><!-- #post-## -->
							</li>

						<?php endwhile; ?>

					</ul>
				</div>
			</div>

		<?php endif; ?>

	<?php endif; wp_reset_postdata(); ?>

<?php endif; ?>