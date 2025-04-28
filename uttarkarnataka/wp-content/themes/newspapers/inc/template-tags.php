<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 * 
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

if ( ! function_exists( 'newspaper_site_branding' ) ) {
	/**
	 * Site branding for the site.
	 * 
	 * Display site title by default, but user can change it with their custom logo.
	 * They can upload it on Customizer page.
	 * 
	 * @since  1.0.0
	 */
	function newspaper_site_branding() {

		// Check if logo available, then display it.
		if ( of_get_option( 'newspaper_logo' ) ) :
			echo '<div id="logo" itemscope itemtype="http://schema.org/Brand">' . "\n";
				echo '<a href="' . esc_url( get_home_url() ) . '" itemprop="url" rel="home">' . "\n";
					echo '<img itemprop="logo" src="' . esc_url( of_get_option( 'newspaper_logo' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
				echo '</a>' . "\n";
			echo '</div>' . "\n";

		// If not, then display the Site Title and Site Description.
		else :
			echo '<div id="logo">'. "\n";
				echo '<h1 class="site-title" ' . hybrid_get_attr( 'site-title' ) . '><a href="' . esc_url( get_home_url() ) . '" itemprop="url" rel="home"><span itemprop="headline">' . esc_attr( get_bloginfo( 'name' ) ) . '</span></a></h1>'. "\n";
				if ( of_get_option( 'newspaper_site_desc', 'on' ) == 'on' ) :
					echo '<h2 class="site-description" ' . hybrid_get_attr( 'site-description' ) . '>' . esc_attr( get_bloginfo( 'description' ) ) . '</h2>';
				endif;
			echo '</div>'. "\n";
		endif;

	}
}

if ( ! function_exists( 'newspaper_header_ad' ) ) {
	/**
	 * Header ad.
	 *
	 * @since  1.0.0
	 */
	function newspaper_header_ad() {

		// Get the ad code.
		$ad = of_get_option( 'newspaper_header_ad' );

		// Display the ad.
		if ( ! empty( $ad ) ) {
			echo '<div class="header-ad">' . stripslashes( $ad ) . '</div>';
		}

	}
}

if ( ! function_exists( 'newspaper_archive_ad' ) ) {
	/**
	 * Archive ad.
	 *
	 * @since  1.0.0
	 */
	function newspaper_archive_ad() {

		// Get the ad code.
		$ad = of_get_option( 'newspaper_archive_ad' );

		// Display the ad.
		if ( ! empty( $ad ) ) {
			echo '<div class="archive-ad">' . stripslashes( $ad ) . '</div>';
		}

	}
}

if ( ! function_exists( 'newspaper_header_social' ) ) {
	/**
	 * Social icons in header.
	 *
	 * @since  1.0.0
	 */
	function newspaper_header_social() {

		// Get the social url.
		$enable     = of_get_option( 'newspaper_enable_social_header', 'on' );
		$twitter    = of_get_option( 'newspaper_twitter_url' );
		$facebook   = of_get_option( 'newspaper_fb_url' );
		$gplus      = of_get_option( 'newspaper_gplus_url' );
		$feed       = of_get_option( 'newspaper_feed_url', of_get_default( 'newspaper_feed_url' ) );

		// Check if social links option enabled.
		if ( $enable == 'on' ) {

			echo '<div class="header-social">';

				if ( ! empty( $facebook ) ) {
					echo '<a href="' . esc_url( $facebook ) . '" title="Facebook"><i class="fa fa-facebook"></i><span>facebook</span></a>';
				}
				if ( ! empty( $twitter ) ) {
					echo '<a href="' . esc_url( $twitter ) . '" title="Twitter"><i class="fa fa-twitter"></i><span>twitter</span></a>';
				}
				if ( ! empty( $gplus ) ) {
					echo '<a href="' . esc_url( $gplus ) . '" title="GooglePlus"><i class="fa fa-google-plus"></i><span>google+</span></a>';
				}
				if ( ! empty( $feed ) ) {
					echo '<a href="' . esc_url( $feed ) . '" title="RSS"><i class="fa fa-rss"></i><span>rss</span></a>';
				}

			echo  '</div>';

		}

	}
}

if ( ! function_exists( 'newspaper_breaking_posts' ) ) :
/**
 * Breaking posts.
 * 
 * @since  1.0.0
 */
function newspaper_breaking_posts() {

	$tag    = of_get_option( 'newspaper_breaking_tag' );  // Get the user selected tag for the breaking posts.

	// Posts query arguments.
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 5
	);

	// Limit to tag based on user selected tag.
	if ( ! empty( $tag ) ) {
		$args['tag_id'] = $tag;
	}

	// Allow dev to filter the post arguments.
	$query = apply_filters( 'newspaper_breaking_args', $args );

	// The post query.
	$breaking = new WP_Query( $query );

	// Check if the post(s) exist.
	if ( $breaking->have_posts() ) : ?>

		<div id="news-ticker" class="clearfix">
			<span><span><?php echo date('m'); ?></span><span><?php echo date('d'); ?></span><span class="top-year"><?php echo date('Y'); ?></span><b><?php _e('Headline', 'newspaper'); ?>:</b></span>
			<ul class="news-list">
				<?php while ( $breaking->have_posts() ) : $breaking->the_post(); ?>
					<li class="news-item">
						<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a> <?php printf( __( '%s ago', 'newspaper' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) ); ?>
				<?php endwhile; ?>
			</ul>
			<span class="headline-nav">
				<a class="headline-prev" href="#"><i class="fa fa-angle-left"></i></a>
				<a class="headline-next" href="#"><i class="fa fa-angle-right"></i></a>
			</span><!-- headline-nav -->
		</div>

	<?php endif; // End check.

	// Restore original Post Data.
	wp_reset_postdata();

}
endif;

if ( ! function_exists( 'newspaper_featured_content' ) ) {
	/**
	 * Featured content.
	 *
	 * @since  1.0.0
	 */
	function newspaper_featured_content() {

		$tag    = of_get_option( 'newspaper_featured_tag' );
		$num    = of_get_option( 'newspaper_featured_num', 3 );

		// Don't show featured content on single or paged page.
		if ( is_single() || is_paged() ) {
			return;
		}

		// Posts query arguments.
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => absint( $num )
		);

		// Limit to tag based on user selected tag.
		if ( ! empty( $tag ) ) {
			$args['tag_id'] = $tag;
		}

		// Allow dev to filter the post arguments.
		$query = apply_filters( 'newspaper_featured_args', $args );

		// The post query.
		$featured = new WP_Query( $query );

		// Check if the post(s) exist.
		if ( $featured->have_posts() ) : ?>

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

		<?php endif; // End check.

		// Restore original Post Data.
		wp_reset_postdata();

	}
}

if ( ! function_exists( 'newspaper_featured_content2' ) ) {
	/**
	 * Featured content 2.
	 *
	 * @since  1.0.0
	 */
	function newspaper_featured_content2() {

		// Data from theme options.
		$tag    = of_get_option( 'newspaper_featured_tag' );

		// Don't show featured content on single or paged page.
		if ( is_single() || is_paged() ) {
			return;
		}

		// Posts query arguments.
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => 1
		);

		// Limit to tag based on user selected tag.
		if ( ! empty( $tag ) ) {
			$args['tag_id'] = $tag;
		}

		// Allow dev to filter the post arguments.
		$query = apply_filters( 'newspaper_featured_args', $args );

		// The post query.
		$featured = new WP_Query( $query );

		// Check if the post(s) exist.
		if ( $featured->have_posts() ) : ?>

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

		<?php endif; // End check.

		// Restore original Post Data.
		wp_reset_postdata();

	}
}

if ( ! function_exists( 'newspaper_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 */
	function newspaper_posted_on() {
		?>
		<div class="entry-meta">

				<span class="entry-date">
				<time class="published" datetime="<?php echo esc_html( get_the_date( 'c' ) ); ?>" <?php hybrid_attr( 'entry-published' ) ?>><?php echo esc_html( get_the_date() ); ?></time>
			</span>

			<span class="sep">|</span>

			<?php _e( 'by', 'newspaper' ); ?>
			
				<span class="entry-author author vcard" <?php hybrid_attr( 'entry-author' ) ?>><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url"><span itemprop="name"><?php echo esc_html( get_the_author() ); ?></span></a></span>

			<span class="sep">|</span>

			<?php newspaper_comment_count(); ?>

		</div>

		<?php
	}
}

if ( ! function_exists( 'newspaper_social_share' ) ) {
	/**
	 * Header ad.
	 *
	 * @since  1.0.0
	 */
	function newspaper_social_share() {
		global $post;

		// Disable social share.
		if ( of_get_option( 'newspaper_share_buttons', 'on' ) != 'on' ) {
			return;
		}

		?>
		<div class="entry-share clearfix">
			<h3><?php _e( 'Share this post', 'newspaper' ); ?></h3>
			<ul>
				<li class="twitter"><a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr( get_the_title( $post->ID ) ); ?>&url=<?php echo urlencode( get_permalink( $post->ID ) ); ?>" target="_blank"><i class="fa fa-twitter"></i>Twitter</a></li>
				<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink( $post->ID ) ); ?>" target="_blank"><i class="fa fa-facebook"></i>Facebook</a></li>
				<li class="google-plus"><a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink( $post->ID ) ); ?>" target="_blank"><i class="fa fa-google-plus"></i>Google+</a></li>
				<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( get_permalink( $post->ID ) ); ?>&title=<?php echo esc_attr( get_the_title( $post->ID ) ); ?>" target="_blank"><i class="fa fa-linkedin"></i>LinkedIn</a></li>
				<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink( $post->ID ) ); ?>&media=<?php echo urlencode( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ); ?>" target="_blank"><i class="fa fa-pinterest"></i>Pinterest</a></li>				
				<li class="email"><a href="mailto:"><i class="fa fa-envelope-o"></i>Email</a></li>
			</ul>
		</div><!-- .entry-share -->
		<?php
	}
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @since  1.0.0
 * @return bool
 */
function newspaper_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'newspaper_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'newspaper_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so newspaper_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so newspaper_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in newspaper_categorized_blog.
 *
 * @since 1.0.0
 */
function newspaper_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'newspaper_categories' );
}
add_action( 'edit_category', 'newspaper_category_transient_flusher' );
add_action( 'save_post',     'newspaper_category_transient_flusher' );

if ( ! function_exists( 'newspaper_post_author' ) ) {
	/**
	 * Author post informations.
	 *
	 * @since  1.0.0
	 */
	function newspaper_post_author() {

		// Bail if user don't want to display the author info via theme settings.
		if ( of_get_option( 'newspaper_post_author', 'on' ) != 'on' ) {
			return;
		}

		// Bail if not on the single post.
		if ( ! is_single() ) {
			return;
		}

		// Bail if user hasn't fill the Biographical Info field.
		if ( ! get_the_author_meta( 'description' ) ) {
			return;
		}
	?>

		<div class="author-bio clearfix" <?php hybrid_attr( 'entry-author' ) ?>>
			<?php echo get_avatar( is_email( get_the_author_meta( 'user_email' ) ), apply_filters( 'newspaper_author_bio_avatar_size', 50 ), '', strip_tags( get_the_author() ) ); ?>
			<div class="description">
				<h3 class="author-title name">
					<a class="author-name url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" itemprop="url"><span itemprop="name"><?php echo strip_tags( get_the_author() ); ?></span></a>
				</h3>
				<p class="bio" itemprop="description"><?php echo stripslashes( get_the_author_meta( 'description' ) ); ?></p>
			</div>
		</div><!-- .author-bio -->

	<?php
	}
}

if ( ! function_exists( 'newspaper_related_posts' ) ) {
	/**
	 * Related posts.
	 *
	 * @since  1.0.0
	 */
	function newspaper_related_posts() {
		global $post;

		// Bail if user don't want to display the related posts via theme settings.
		if ( of_get_option( 'newspaper_related_posts', 'on' ) != 'on' ) {
			return;
		}

		// Get the taxonomy terms of the current page for the specified taxonomy.
		$terms = wp_get_post_terms( $post->ID, 'category', array( 'fields' => 'ids' ) );

		// Bail if the term empty.
		if ( empty( $terms ) ) {
			return;
		}
		
		// Posts query arguments.
		$query = array(
			'post__not_in' => array( $post->ID ),
			'tax_query'    => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $terms,
					'operator' => 'IN'
				)
			),
			'posts_per_page' => 4,
			'post_type'      => 'post',
		);

		// Allow dev to filter the query.
		$args = apply_filters( 'newspaper_related_posts_args', $query );

		// The post query
		$related = new WP_Query( $args );

		if ( $related->have_posts() ) : ?>

			<div class="related-posts">
				<h3><?php _e( 'Recommended for You', 'newspaper' ); ?></h3>
				<ul class="clearfix">
					<?php while ( $related->have_posts() ) : $related->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'newspaper-loop', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
								<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		
		<?php endif;

		// Restore original Post Data.
		wp_reset_postdata();

	}
}

if ( ! function_exists( 'newspaper_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since  1.0.0
	 */
	function newspaper_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>" <?php hybrid_attr( 'comment' ); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="comment-container">
				<p <?php hybrid_attr( 'comment-content' ); ?>><?php _e( 'Pingback:', 'newspaper' ); ?> <span <?php hybrid_attr( 'comment-author' ); ?>><span itemprop="name"><?php comment_author_link(); ?></span></span> <?php edit_comment_link( __( '(Edit)', 'newspaper' ), '<span class="edit-link">', '</span>' ); ?></p>
			</article>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" <?php hybrid_attr( 'comment' ); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="comment-container">

				<?php echo get_avatar( $comment, apply_filters( 'newspaper_comment_avatar_size', 52 ) ); ?>

				<div class="comment-head">
					<span class="name" <?php hybrid_attr( 'comment-author' ); ?>><span itemprop="name"><?php echo get_comment_author_link(); ?></span></span>
					<?php
						printf( '<span class="date"><a href="%1$s" ' . hybrid_get_attr( 'comment-permalink' ) . '><time datetime="%2$s" ' . hybrid_get_attr( 'comment-published' ) . '>%3$s</time></a> %4$s</span>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'newspaper' ), get_comment_date(), get_comment_time() ),
							sprintf( __( '%1$s&middot; Edit%2$s', 'newspaper' ), '<a href="' . get_edit_comment_link() . '" title="' . esc_attr__( 'Edit Comment', 'newspaper' ) . '">', '</a>' )
						);
					?>
				</div><!-- comment-head -->
				
				<div class="comment-content comment-entry comment" <?php hybrid_attr( 'comment-content' ); ?>>
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'newspaper' ); ?></p>
					<?php endif; ?>
					<?php comment_text(); ?>
					<span class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'newspaper' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</span><!-- .reply -->
				</div><!-- .comment-content -->

			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
}

if ( ! function_exists( 'newspaper_comment_count' ) ) {
	/**
	 * Comment count
	 *
	 * @since  1.0.0
	 */
	function newspaper_comment_count() {
		?>
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>

			<?php if ( of_get_option( 'newspaper_fb_comment' ) == 'on' ) : ?>
				<span class="entry-comments"><i class="fa fa-comment-o"></i> <span class="fb-comments-count" data-href="<?php the_permalink(); ?>"></span></span>
			<?php elseif ( of_get_option( 'newspaper_disqus_comment' ) == 'on' ) : ?>
				<span class="entry-comments"><a href="<?php the_permalink(); ?>#disqus_thread"><i class="fa fa-comment-o"></i></a></span>
			<?php else : ?>
				<span class="entry-comments"><?php comments_popup_link( __( '0', 'newspaper' ), __( '1', 'newspaper' ), __( '%', 'newspaper' ) ); ?> <i class="fa fa-comment-o"></i></span>
			<?php endif; ?>

		<?php endif; ?>
		<?php
	}
}