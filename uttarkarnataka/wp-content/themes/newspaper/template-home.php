<?php
/**
 * Template Name: Home template
 */
get_header(); ?>

	<main id="main" class="site-main clearfix column" role="main" <?php hybrid_attr( 'content' ); ?>>

		<?php if( of_get_option('newspaper_featured_content') == 'slider' ) { 
			
			newspaper_featured_content(); ?>
				
		<?php } elseif(of_get_option('newspaper_featured_content') == 'classic') { 
			
			newspaper_featured_content2(); ?>

		<?php } elseif(of_get_option('newspaper_featured_content') == 'disable') { ?>
				
		<?php } ?>

			<?php newspaper_archive_ad(); // Display banner/ad below featured posts. ?>

		<ul id="home-sidebar">

			<li class="home-col1 column"><?php dynamic_sidebar( 'home-col1' ); ?></li>

			<li class="home-col2 column"><?php dynamic_sidebar( 'home-col2' ); ?></li>

			<li class="home-col3 column"><?php dynamic_sidebar( 'home-col3' ); ?></li>

		</ul>

	</main><!-- #main -->

<?php get_footer(); ?>