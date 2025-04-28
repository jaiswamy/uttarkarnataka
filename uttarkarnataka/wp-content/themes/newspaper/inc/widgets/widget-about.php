<?php
/**
 * Feedburner widget.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */
class Newspaper_About_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'widget-newspaper-about widget_about',
			'description' => __( 'Display profile info.', 'newspaper' )
		);

		// Create the widget.
		parent::__construct(
			'newspaper-about',                  // $this->id_base
			__( '&raquo; About', 'newspaper' ), // $this->name
			$widget_options                         // $this->widget_options
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

		// If the title not empty, display it.
		if ( $instance['title'] ) {
			echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;
		}
		
			if ( $instance['img'] ) {
				echo '<img src="'. esc_url( $instance['img'] ). '" alt="' . strip_tags( $instance['name'] ) . '">';
			}
			
			echo '<div class="about-content">';
			
			if ( $instance['name'] ) {
				echo '<div class="about-name">' . strip_tags( $instance['name'] ) . '</div>';
			}
			
			if ( $instance['desc'] ) {
				echo '<div class="about-desc">' . stripslashes( $instance['desc'] ) . '</div>';
			}
			
			echo '</div>';

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

		$instance['title']   = strip_tags( $new_instance['title'] );
		$instance['img']  = esc_url_raw( $new_instance['img'] );
		$instance['name']   = stripslashes( $new_instance['name'] );
		$instance['desc'] = stripslashes( $new_instance['desc'] );

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
			'title'   => '',
			'img'  => '',
			'name' => '',
			'desc' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>">
				<?php _e( 'Name:', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo esc_attr( $instance['name'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>">
				<?php _e( 'Description:', 'newspaper' ); ?>
			</label>
			<textarea class="widefat" name="<?php echo $this->get_field_name( 'desc' ); ?>" id="<?php echo $this->get_field_id( 'desc' ); ?>" cols="30" rows="6"><?php echo stripslashes( $instance['desc'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'img' ); ?>">
				<?php _e( 'Image:', 'newspaper' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo esc_attr( $instance['img'] ); ?>" placeholder="<?php echo esc_attr( 'http://...' ); ?>" />
		</p>

	<?php

	}

}