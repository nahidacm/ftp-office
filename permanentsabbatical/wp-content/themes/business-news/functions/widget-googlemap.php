<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'googlemap_load_widgets' );

/**
 * Register our widget.
 * 'googlemap_Widget' is the widget class used below.
 */
function googlemap_load_widgets() {
	register_widget( 'googlemap_Widget' );
}

/**
 * googlemap Widget class.
 */
class googlemap_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function googlemap_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'googlemap', 'description' => 'Google Map' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'googlemap-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'googlemap-widget', 'WLM - Google Map', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$googlemap = $instance['googlemap'];
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		//here will be displayed widget content for Footer 1st column 
?>					

		<!-- google map -->
		<div class="block_location">
<?php
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
?>		
			<div class="map"><iframe width="290" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $googlemap; ?>&amp;output=embed"></iframe></div>
			<div class="line_2" style="margin:22px 0px 0px;"></div>
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
		$instance['googlemap'] = $new_instance['googlemap'];
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'googlemap Subscribe' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
<p>
			<label for="<?php echo $this->get_field_id( 'googlemap' ); ?>"><?php echo 'Google Map Full URL:'; ?></label>
			<textarea id="<?php echo $this->get_field_id( 'googlemap' ); ?>" name="<?php echo $this->get_field_name( 'googlemap' ); ?>" style="width:100%;"><?php echo $instance['googlemap']; ?></textarea>
		</p>

	<?php
	}
}
?>