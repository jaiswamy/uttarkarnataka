<?php
/**
 * Widget home posts 1 column widget.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */
class Newspaper_Posts_2_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'widget-newspaper-posts-2 posts-category-2-widget',
			'description' => __( 'Display posts based on user selected category.', 'newspaper' )
		);

		// Create the widget.
		parent::__construct(
			'newspaper-posts-2',                      // $this->id_base
			__( '&raquo; Category Posts 2', 'newspaper' ), // $this->name
			$widget_options                                  // $this->widget_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// If user have not selected any category then display none.
		if ( empty( $instance['cat'] ) ) {
			return;
		}

		// Output the theme's $before_widget wrapper.
		echo $before_widget;

			// Pull the selected category.
			$cat_id = $instance['cat'];

			// Get the category.
			$category = get_category( $cat_id );

			// Get the category archive link.
			$cat_link = get_category_link( $cat_id );

			// Posts query arguments.
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => $instance['limit']
			);

			// Limit to category based on user selected tag.
			if ( ! empty( $instance['cat'] ) ) {
				$args['cat'] = $instance['cat'];
			}

			// Allow dev to filter the post arguments.
			$query = apply_filters( 'newspaper_widget_posts_2_args', $args );

			// The post query.
			$posts = new WP_Query( $query );

			if ( $posts->have_posts() ) : ?>

				<h3 class="widget-title">
					<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo $category->name; ?></a>
				</h3>

				<ul>

					<?php $count = 1; ?>

					<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

							<li>
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'newspaper-loop', array( 'class' => 'entry-thumb', 'alt' => esc_attr( get_the_title() ) ) ); ?></a>
								<?php endif; ?>
								<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								
							<?php if ( $instance['show_meta'] ) : ?>
								<div class="entry-meta">

									<span class="entry-date">
										<time class="published" datetime="<?php echo esc_html( get_the_date( 'c' ) ); ?>" <?php hybrid_attr( 'entry-published' ) ?>><?php echo esc_html( get_the_date() ); ?></time>
									</span>

									<span class="sep">|</span>

										<?php newspaper_comment_count(); ?>

								</div>
							<?php endif; ?>
								
							<?php if ( $instance['show_excerpt'] ) : ?>
								<div class="entry-summary">
									<?php echo apply_filters( 'newspaper_posts_2', wp_trim_words( get_the_excerpt(), 20 ) ); ?>
								</div><!-- .entry-summary -->
							<?php endif; ?>
							</li>

					<?php if ($count == 1) : ?>
						<?php if ( $instance['show_ad'] ) : ?>
							<li class="widget-ad clearfix"><?php echo stripslashes( $instance['widget_ad'] ) ?></li>
						<?php endif; ?>
					<?php endif; $count++; ?>

					<?php endwhile; ?>
					
				</ul>

			<?php endif;

			// Restore original Post Data.
			wp_reset_postdata();

		// Close the theme's widget wrapper.
		echo $after_widget;

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance        = $new_instance;
		$instance['cat'] = $new_instance['cat'];
		$instance['limit']     = (int) $new_instance['limit'];
		$instance['show_excerpt'] = isset( $new_instance['show_excerpt'] ) ? (bool) $new_instance['show_excerpt'] : false;
		$instance['show_meta'] = isset( $new_instance['show_meta'] ) ? (bool) $new_instance['show_meta'] : false;
		$instance['show_ad'] = isset( $new_instance['show_ad'] ) ? (bool) $new_instance['show_ad'] : false;
		$instance['widget_ad'] = stripslashes( $new_instance['widget_ad'] );

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
			'cat' => '',
			'limit'     => 5,
			'show_excerpt' => false,
			'show_meta' => false,
			'show_ad' => false,
			'widget_ad' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Choose Category:', 'newspaper' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" style="width:100%;">
			<?php $categories = get_terms( 'category' ); ?>
			<?php foreach( $categories as $category ) { ?>
				<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $instance['cat'], $category->term_id ); ?>><?php echo esc_html( $category->name ); ?></option>
			<?php } ?>
		</select>
	</p>
	
	<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
				<?php _e( 'Number of posts to show', 'newspaper' ); ?>
			</label>
			<input class="small-text" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" step="1" min="0" value="<?php echo (int)( $instance['limit'] ); ?>" />
		</p>
		
	<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_excerpt'] ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>">
				<?php _e( 'Display excerpt?', 'newspaper' ); ?>
			</label>
	</p>
	
	<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_meta'] ); ?> id="<?php echo $this->get_field_id( 'show_meta' ); ?>" name="<?php echo $this->get_field_name( 'show_meta' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_meta' ); ?>">
				<?php _e( 'Display meta?', 'newspaper' ); ?>
			</label>
	</p>
		
	<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_ad'] ); ?> id="<?php echo $this->get_field_id( 'show_ad' ); ?>" name="<?php echo $this->get_field_name( 'show_ad' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_ad' ); ?>">
				<?php _e( 'Display ad between 1 and 2 post?', 'newspaper' ); ?>
			</label>
	</p>
	
	<p>
			<label for="<?php echo $this->get_field_id( 'widget_ad' ); ?>">
				<?php _e( 'Ad Code:', 'newspaper' ); ?>
			</label>
			<textarea class="widefat" name="<?php echo $this->get_field_name( 'widget_ad' ); ?>" id="<?php echo $this->get_field_id( 'widget_ad' ); ?>" cols="30" rows="6"><?php echo stripslashes( $instance['widget_ad'] ); ?></textarea>
	</p>

	<?php

	}

}