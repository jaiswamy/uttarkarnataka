<?php
/**
 * Custom functions for the theme options.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

/**
 * Theme options header.
 *
 * @since  1.0.0
 */
function newspaper_of_header() {
	$theme = wp_get_theme();
	$name  = $theme->get( 'TextDomain' );
?>
	<div class="header-options">
		<ul class="theme-info">
			<li><span class="dashicons dashicons-info"></span><a href="http://docs.theme-junkie.com/<?php echo esc_attr( $name ); ?>" target="_blank"><?php _e( 'Documentation', 'newspaper' ); ?></a></li>
			<li><span class="dashicons dashicons-lightbulb"></span><a href="http://www.theme-junkie.com/forum/" target="_blank"><?php _e( 'Support Forum', 'newspaper' ); ?></a></li>
			<li><span class="dashicons dashicons-twitter"></span><a href="https://twitter.com/theme_junkie" target="_blank">Follow Us</a></li>
			<li><span class="dashicons dashicons-facebook"></span><a href="https://www.facebook.com/themejunkies" target="_blank">Like Us</a></li>
		</ul>
	</div>
<?php
}
add_action( 'optionsframework_header_options', 'newspaper_of_header' );

/**
 * Favicon output.
 *
 * @since 1.0.0
 */
function newspaper_favicon_output() {
	$favicon = of_get_option( 'newspaper_favicon' );

	if ( !empty( $favicon ) ) {
		echo '<link href="' . esc_url( $favicon ) . '" rel="icon">' . "\n";
	}

}
add_action( 'wp_head', 'newspaper_favicon_output', 5 );

/**
 * Mobile Icon output.
 *
 * @since 1.0.0
 */
function newspaper_mobile_icon_output() {
	$icon = of_get_option( 'newspaper_mobile_icon' );

	if ( !empty( $icon ) ) {
		echo '<link rel="apple-touch-icon-precomposed" href="' . esc_url( $icon ) . '">' . "\n";
	}

}
add_action( 'wp_head', 'newspaper_mobile_icon_output', 6 );

/**
 * Custom RSS feed url.
 *
 * @since  1.0.0
 * @return string
 */
function newspaper_feed_url( $output, $feed ) {

	// Get the custom rss feed url.
	$url = of_get_option( 'newspaper_feedburner_url' );

	// Do not redirect comments feed
	if ( strpos( $output, 'comments' ) ) {
		return $output;
	}

	// Check the settings.
	if ( !empty( $url ) ) {
		$output = esc_url( $url );
	}

	return $output;
}
add_filter( 'feed_link', 'newspaper_feed_url', 10, 2 );

/**
 * Accent Colors
 *
 * @since  1.0.0
 */
function newspaper_accent_colors() {

	$option  = of_get_option( 'newspaper_colors', 'blue' );
	$pallete = of_get_option( 'newspaper_color_pallete', '#369' );
	$color   = '#369';

	if ( $option == 'green' ) {
		$color  = '#3B8914';
	}

	if ( $option == 'red' ) {
		$color  = '#FA3725';
	}

	if ( $pallete != '#369' && $pallete != '' ) {
		$color   = $pallete;
	}
	?>
	<style>

		#primary-bar,
                .pagination .page-numbers.current { 
			background-color: <?php echo $color ?>;
		}

		a:link,
		a:visited,		
		.widget_tabs .tab-content .entry-title a:hover,
		#site-bottom a:hover,
		.category-box ul li strong a:hover,
		#featured-content-2 .entry-title a:hover,
		.entry-title a:hover,
		.section-title a:hover,
 		.widget ul li a:hover,
		.widget .tagcloud a:hover,
		.widget_latest_comments a:hover .name,
		.related-posts ul li a:hover .entry-title,
		.widget_tabs .tab-content ul li .entry-title:hover,
		.widget_tabs #tab3 li a span:hover,
		.posts .cat-posts .view-more a,
		.posts .cat-posts a:hover .entry-title,
		.posts .sub-cats li:hover > a:after,
		.single .entry-meta .entry-author a:hover,
                .pagination .page-numbers,
		.site-branding .widget .about-name {
			color: <?php echo $color ?>;
		}

	</style>
	<?php
}
add_action( 'wp_head', 'newspaper_accent_colors', 20 );

/**
 * Single post advertisement.
 * Before content.
 *
 * @since  1.0.0
 */
function newspaper_single_ad_before( $content ) {
	$ad = of_get_option( 'newspaper_ad_single_before' );

	if ( is_single() ) {
		$content = stripslashes( $ad ) . $content;
	} else {
		$content;
	}

	return $content;

}
add_filter( 'the_content', 'newspaper_single_ad_before', 20 );

/**
 * Single post advertisement.
 * After content.
 *
 * @since  1.0.0
 */
function newspaper_single_ad_after( $content ) {
	$ad = of_get_option( 'newspaper_ad_single_after' );

	if ( is_single() ) {
		$content = $content . stripslashes( $ad );
	} else {
		$content;
	}

	return $content;

}
add_filter( 'the_content', 'newspaper_single_ad_after', 20 );

/**
 * Tracking Code
 *
 * @since  1.0.0
 */
function newspaper_tracking_code() {
	$tracking_code = of_get_option( 'newspaper_tracking_code' );

	if ( !empty( $tracking_code ) ) {
		echo stripslashes( $tracking_code ) . "\n";
	}

}
add_action( 'wp_footer', 'newspaper_tracking_code', 15 );

/**
 * Header Code
 *
 * @since  1.0.0
 */
function newspaper_header_code() {
	$header_code = of_get_option( 'newspaper_script_head' );

	if ( !empty( $header_code ) ) {
		echo stripslashes( $header_code ) . "\n";
	}

}
add_action( 'wp_head', 'newspaper_header_code', 20 );

/**
 * Footer Code
 *
 * @since  1.0.0
 */
function newspaper_footer_code() {
	$footer_code = of_get_option( 'newspaper_script_footer' );

	if ( !empty( $footer_code ) ) {
		echo stripslashes( $footer_code ) . "\n";
	}

}
add_action( 'wp_footer', 'newspaper_footer_code', 20 );