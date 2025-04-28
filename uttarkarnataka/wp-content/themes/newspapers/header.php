<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700,400italic' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php hybrid_attr( 'body' ); ?>>

<div id="page" class="container hfeed site clearfix">

	<header id="masthead" class="site-header" role="banner" <?php hybrid_attr( 'header' ); ?>>

		<div class="top-bar">

			<?php newspaper_breaking_posts(); // Get the breaking posts. ?>
 
			<div class="header-search">
				<form method="get" class="searchform" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search this site...', 'newspaper' ); ?>">
					<button name="search" id="search"><i class="fa fa-search"></i></button>
				</form>
			</div>

		</div>

		<div class="site-branding clearfix">

			<?php if (of_get_option('newspaper_header_style') == 'quotes') { ?>
				<div class="widget-left"><?php dynamic_sidebar( 'header-left' ); ?></div>
				<div class="widget-right"><?php dynamic_sidebar( 'header-right' ); ?></div>
			<?php } ?>

			<?php if (of_get_option('newspaper_header_style') == 'quotes') echo('<div class="logo-center">'); ?>
				<?php newspaper_site_branding(); // Display the site title/logo. ?>
			<?php if (of_get_option('newspaper_header_style') == 'quotes') echo('</div>'); ?>
			
			<?php if (of_get_option('newspaper_header_style') == 'advertisement') { ?>
				<?php newspaper_header_ad(); // Display banner/ad in header. ?>
			<?php } ?>
			
		</div>

		<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>

		<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template. ?>

	</header><!-- #masthead -->

	<div id="site-content" class="site-content">