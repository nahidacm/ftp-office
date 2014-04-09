<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'calendar_load_widgets' );

/**
 * Register our widget.
 * 'calendar_Widget' is the widget class used below.
 */
function calendar_load_widgets() {
	register_widget( 'calendar_Widget' );
}

/**
 * calendar Widget class.
 */
class calendar_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function calendar_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'calendar', 'description' => 'Calendar.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'calendar-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'calendar-widget', 'WLM - Calendar', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		//here will be displayed widget content for Footer 1st column 
?>					

		<!-- newsletter -->
		<div class="block_calendar">
<?php
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
?>
			<div class="calendar" id="calendar_sidebar"></div>

			<script type="text/javascript">
				var today = new Date();
				var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
				jQuery('#calendar_sidebar').DatePicker({
					flat : true,
					date : date,
					calendars : 1,
					starts : 1,
					locale : {
						days : ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
						daysShort : ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
						daysMin : ['S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
						months : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
						monthsShort : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						weekMin : 'wk'
					}
				});
			</script>
			
			<div class="line_2"></div>
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
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Calendar' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>