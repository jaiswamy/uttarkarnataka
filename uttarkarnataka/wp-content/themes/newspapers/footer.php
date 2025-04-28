	</div><!-- #content -->

	<div class="clearfix"></div>

	<footer id="footer" class="site-footer clearfix" role="contentinfo" <?php hybrid_attr( 'footer' ); ?>>

		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' )) { ?>
			
		<div id="footer-columns" class="clearfix">

			<div class="footer-column footer-column-1">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>

			<div class="footer-column footer-column-2">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>

			<div class="footer-column footer-column-3">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>

			<div class="footer-column footer-column-4">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>

		</div>
		
		<?php } ?>

		<?php get_template_part( 'menu', 'footer' ); // Loads menu-footer.php template. ?>

		<div id="site-bottom" class="clearfix">

			<div class="copyright"><div class="left">&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'description' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>. <?php _e('All rights reserved','newspaper'); ?>.</div><div class="right"><?php echo stripslashes( of_get_option( 'newspaper_footer_text', of_get_default( 'newspaper_footer_text' ) ) ); ?></div></div><!-- .copyright -->

		</div>

	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>