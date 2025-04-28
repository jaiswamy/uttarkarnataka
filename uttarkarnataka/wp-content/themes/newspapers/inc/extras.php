<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since  1.0.0
 * @param  array $args Configuration arguments.
 * @return array
 */
function newspaper_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'newspaper_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since  1.0.0
 * @param  array $classes Classes for the body element.
 * @return array
 */
function newspaper_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( ! is_home() && ! is_front_page() && ! is_archive() && ! is_search() ) {
		if ( in_array( get_theme_mod( 'theme_layout' ), array( 'content-sidebar' ) ) ) {
			$classes[] = 'content-sidebar';
		}
	}

	if ( in_array( get_theme_mod( 'theme_layout' ), array( 'sidebar-content' ) ) ) {
		$classes[] = 'sidebar-content';
	}

	return $classes;
}
add_filter( 'body_class', 'newspaper_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @since  1.0.0
 * @param  array $classes Classes for the post element.
 * @return array
 */
function newspaper_post_classes( $classes ) {

	// Adds a class if a post hasn't a thumbnail.
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'newspaper_post_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function newspaper_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'newspaper' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'newspaper_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function newspaper_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'newspaper_render_title' );
endif;

/**
 * Change the excerpt more string.
 *
 * @since  1.0.0
 * @param  string  $more
 * @return string
 */
function newspaper_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'newspaper_excerpt_more' );

function newspaper_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'newspaper_excerpt_length');

/**
 * Remove theme-layouts meta box on attachment and bbPress post type.
 * 
 * @since 1.0.0
 */
function newspaper_remove_theme_layout_metabox() {
	remove_post_type_support( 'attachment', 'theme-layouts' );
	remove_post_type_support( 'forum', 'theme-layouts' );
	remove_post_type_support( 'topic', 'theme-layouts' );
	remove_post_type_support( 'reply', 'theme-layouts' );
}
add_action( 'init', 'newspaper_remove_theme_layout_metabox', 11 );

/**
 * Add post type 'post' support for the Simple Page Sidebars plugin.
 * 
 * @since  1.0.0
 */
function newspaper_page_sidebar_plugin() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'simple-page-sidebars/simple-page-sidebars.php' ) ) {
		add_post_type_support( 'post', 'simple-page-sidebars' );
	}
}
add_action( 'init', 'newspaper_page_sidebar_plugin' );

/**
 * Custom comment form fields.
 *
 * @since  1.0.0
 * @param  array $fields
 * @return array
 */
function newspaper_comment_form_fields( $fields, $args = array() ) {

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) )
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html5     = 'html5' === $args['format'];

	$fields['author'] = '<p class="comment-form-author">' . '<label for="author"> ' . __( 'Name', 'newspaper' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input class="txt" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';

	$fields['email'] = '<p class="comment-form-email"><label for="email"> ' . __( 'Email', 'newspaper' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input class="txt" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';

	$fields['url'] = '<p class="comment-form-url"><label for="url"> ' . __( 'Website', 'newspaper' ) . '</label> ' . '<input class="txt" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	return $fields;

}
add_filter( 'comment_form_default_fields', 'newspaper_comment_form_fields' );

/**
 * Custom comment form submit field.
 * 
 * @since  1.0.0
 */
function newspaper_comment_button() {
	echo '<input class="btn" name="submit" type="submit" id="submit" value="' . esc_attr__( 'Post Comment', 'newspaper' ) . '" />';
}
add_action( 'comment_form', 'newspaper_comment_button' );