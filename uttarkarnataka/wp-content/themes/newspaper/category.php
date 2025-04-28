<?php get_header(); ?>

	<main id="main" class="site-main clearfix column" role="main" <?php hybrid_attr( 'content' ); ?>>

		<?php 
			$category = get_category( get_query_var( 'cat' ), false );
			$layout = get_tax_meta( $category->term_id, 'newspaper_cat_layout', false );
			if ( empty( $layout ) ) {
				$layout = 'list';
			}
		?>

		<?php get_template_part( 'content', 'featured' ); ?>

		<?php newspaper_archive_ad(); // Display banner/ad below featured posts. ?>

		<div id="primary" class="content-area column">

			<div id="content" class="content-loop <?php echo esc_attr( newspaper_posts_layout() ); ?> column">

				<?php the_archive_title( '<h3 class="section-title">', '</h3>' ); ?>

				<?php if ( have_posts() ) : ?>
				
					<?php $i = 1; ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php if ( 'grid' === $layout ) : ?>
							<?php get_template_part( 'content', 'grid' ); ?>
						<?php elseif ( 'list' === $layout ) : ?>
							<?php get_template_part( 'content', 'list' ); ?>
						<?php elseif ( 'blog' === $layout ) : ?>
							<?php get_template_part( 'content', 'blog' ); ?>
						<?php endif; ?>
						
						<?php if ( 'grid' === $layout ) : ?>
							<?php if ( ++$i % 2 ) echo '<span class="line clearfix"></span>'; ?>
						<?php endif; ?>

					<?php endwhile; ?>

					<?php get_template_part( 'loop', 'nav' ); // Loads the loop-nav.php template ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

			</div><!-- #content -->

		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</main><!-- #main -->

<?php get_footer(); ?>