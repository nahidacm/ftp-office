<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'feedburner_subscribe_load_widgets' );

/**
 * Register our widget.
 * 'feedburner_subscribe_Widget' is the widget class used below.
 */
function feedburner_subscribe_load_widgets() {
	register_widget( 'feedburner_subscribe_Widget' );
}

/**
 * feedburner_subscribe Widget class.
 */
class feedburner_subscribe_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function feedburner_subscribe_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'feedburner_subscribe', 'description' => 'Feedburner Subscribe.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'feedburner_subscribe-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'feedburner_subscribe-widget', 'WLM - Feedburner Subscribe', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$feedburner_subscribe_username = $instance['feedburner_subscribe_username'];
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		//here will be displayed widget content for Footer 1st column 
?>					

		<!-- newsletter -->
		<div class="block_newsletter">
<?php
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
?>		
			<form action="http://feedburner.google.com/fb/a/mailverify?" method="post" target="_blank">
				<div class="field"><input type="text" name="email" title="<?php _e('Enter Your Email Address','weblionmedia'); ?>" class="w_def_text" /></div>
				<input type="hidden" name="uri" value="<?php echo $feedburner_subscribe_username; ?>" />
				<input type="submit" class="button" value="<?php _e('Subscribe','weblionmedia'); ?>">
				<div class="clearboth"></div>
			</form>
		</div>
		
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feedburner_subscribe_username'] = strip_tags( $new_instance['feedburner_subscribe_username'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Feedburner Subscribe' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_subscribe_username' ); ?>"><?php echo 'Feedburner Username:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'feedburner_subscribe_username' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_subscribe_username' ); ?>" value="<?php echo $instance['feedburner_subscribe_username']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>