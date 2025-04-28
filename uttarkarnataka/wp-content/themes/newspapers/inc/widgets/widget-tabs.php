<?php
/**
 * Tabbed widget.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */
class Newspaper_Tabs_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'widget-newspaper-tabs widget_tabs',
			'description' => __( 'Display popular posts, recent posts, recent comments and tags in tabs.', 'newspaper' )
		);

		// Create the widget.
		parent::__construct(
			'newspaper-tabs',                  // $this->id_base
			__( '&raquo; Tabs', 'newspaper' ), // $this->name
			$widget_options                  // $this->widget_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// Output the theme's $before_widget wrapper.
		echo $before_widget;
		?>
		
		<ul class="tabs-nav">
			<li class="active"><a href="#tab1" title="<?php esc_attr_e( 'Popular', 'newspaper' ); ?>"><?php _e( 'Popular', 'newspaper' ); ?></a></li>
			<li><a href="#tab2" title="<?php esc_attr_e( 'Latest', 'newspaper' ); ?>"><?php _e( 'Latest', 'newspaper' ); ?></a></li>
			<li><a href="#tab3" title="<?php esc_attr_e( 'Comments', 'newspaper' ); ?>"><?php _e( 'Comments', 'newspaper' ); ?></a></li>        
			<li><a href="#tab4" title="<?php esc_attr_e( 'Tags', 'newspaper' ); ?>"><?php _e( 'Tags', 'newspaper' ); ?></a></li>
		</ul>

		<div class="tabs-container">
			<div class="tab-content" id="tab1">
				<?php echo newspaper_popular_posts( (int) $instance['popular_num'] ); ?>
			</div>

			<div class="tab-content" id="tab2">
				<?php echo newspaper_latest_posts( (int) $instance['recent_num'] ); ?>
			</div>

			<div class="tab-content" id="tab3">
				<?php $comments = get_comments( array( 'number' => (int) $instance['comments_num'], 'status' => 'approve', 'post_status' => 'publish' ) ); ?>
				<?php if ( $comments ) : ?>
					<ul>
						<?php foreach( $comments as $comment ) : ?>
							<li class="clearfix">
								<a href="<?php echo get_comment_link( $comment->comment_ID ) ?>">
									<span class="entry-thumbnail"><?php echo get_avatar( $comment->comment_author_email, '64' ); ?></span>
									<strong><?php echo $comment->comment_author; ?></strong>
									<span><?php echo wp_html_excerpt( $comment->comment_content, '60' ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="tab-content" id="tab4">
				<?php wp_tag_cloud(); ?>
			</div>
			<div class="clearfix"></div>
		</div>

		<?php
		// Close the theme's widget wrapper.
		echo $after_widget;

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $new_instance;

		$instance['popular_num']  = absint( $new_instance['popular_num'] );
		$instance['recent_num']   = absint( $new_instance['recent_num'] );
		$instance['comments_num'] = absint( $new_instance['comments_num'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 */
	function form( $instance ) {

		// Default value.
		$defaults = array(
			'popular_num'  => 5,
			'recent_num'   => 5,
			'comments_num' => 5
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'popular_num' ); ?>">
				<?php _e( 'Number of Popular Posts', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'popular_num' ); ?>" name="<?php echo $this->get_field_name( 'popular_num' ); ?>" value="<?php echo absint( $instance['popular_num'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'recent_num' ); ?>">
				<?php _e( 'Number of Recent Posts', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'recent_num' ); ?>" name="<?php echo $this->get_field_name( 'recent_num' ); ?>" value="<?php echo absint( $instance['recent_num'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'comments_num' ); ?>">
				<?php _e( 'Number of Recent Comments', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'comments_num' ); ?>" name="<?php echo $this->get_field_name( 'comments_num' ); ?>" value="<?php echo esc_attr( $instance['comments_num'] ); ?>" />
		</p>

	<?php

	}

}

/**
 * Popular Posts by comment
 *
 * @since 1.0.0
 */
function newspaper_popular_posts( $number = 5 ) {

	// Posts query arguments.
	$args = array(
		'posts_per_page' => $number,
		'orderby'        => 'comment_count',
		'post_type'      => 'post'
	);

	// The post query
	$popular = get_posts( $args );

	global $post;

	if ( $popular ) {
		$html = '<ul>';

			foreach ( $popular as $post ) :
				setup_postdata( $post );

				$html .= '<li class="clearfix">';
					$html .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" rel="bookmark">';
						$html .= get_the_post_thumbnail( $post->ID, 'newspaper-widget-thumb', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title( $post->ID ) ) ) );
						$html .= '<h2 class="entry-title">' . esc_attr( get_the_title( $post->ID ) ) . '</h2>';
						$html .= '<div class="entry-meta">' . get_the_date() . '</div>';
					$html .= '</a>';
				$html .= '</li>';

			endforeach;

		$html .= '</ul>';
	}

	// Reset the query.
	wp_reset_postdata();

	if ( isset( $html ) ) {
		return $html;
	}

}

/**
 * Recent Posts
 *
 * @since 1.0.0
 */
function newspaper_latest_posts( $number = 5 ) {

	// Posts query arguments.
	$args = array(
		'posts_per_page' => $number,
		'post_type'      => 'post',
	);

	// The post query
	$recent = get_posts( $args );

	global $post;

	if ( $recent ) {
		$html = '<ul>';

			foreach ( $recent as $post ) :
				setup_postdata( $post );

				$html .= '<li class="clearfix">';
					$html .= '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" rel="bookmark">';
						$html .= get_the_post_thumbnail( $post->ID, 'newspaper-widget-thumb', array( 'class' => 'entry-thumbnail', 'alt' => esc_attr( get_the_title( $post->ID ) ) ) );
						$html .= '<h2 class="entry-title">' . esc_attr( get_the_title( $post->ID ) ) . '</h2>';
						$html .= '<div class="entry-meta">' . get_the_date() . '</div>';
					$html .= '</a>';
				$html .= '</li>';

			endforeach;

		$html .= '</ul>';
	}

	// Reset the query.
	wp_reset_postdata();

	if ( isset( $html ) ) {
		return $html;
	}

}