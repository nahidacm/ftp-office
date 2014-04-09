<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'tags_links_load_widgets' );

/**
 * Register our widget.
 * 'tags_links_Widget' is the widget class used below.
 */
function tags_links_load_widgets() {
	register_widget( 'tags_links_Widget' );
}

/**
 * tags_links Widget class.
 */
class tags_links_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function tags_links_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tags_links', 'description' => 'Tags Links.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'tags_links-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tags_links-widget', 'WLM - Tags', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$usecount = apply_filters('widget_usecount', $instance['usecount'] );
		$numbers = apply_filters('widget_usecount', $instance['numbers'] );
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		global $wpdb;
		$poststags_output = '';
		$posttags = get_tags();
		$numbers_count = 0;
		if ($posttags) {
		  foreach($posttags as $tag) {
			  if ($numbers_count < $numbers) {
				  $usecount_output = '';
				  if ($usecount == 'on') $usecount_output = ' <span class="num">('.$tag->count.')</span>';
				  $poststags_output .= '
						<li><a href="'. get_tag_link($tag->term_id) . '" class="tag-link">' . $tag->name . $usecount_output . '</a></li>
					';
				  $numbers_count++;
			  }
		  }
		}		
		
		echo '<div class="block_tags">
				<ul>'
					.$poststags_output.
			 '	</ul>
			</div>
		';

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
		$instance['usecount'] = strip_tags( $new_instance['usecount'] );
		$instance['numbers'] = strip_tags( $new_instance['numbers'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'numbers' => '20', 'description' => 'Tags Links' );
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'usecount' ); ?>">Use count for tags list:  </label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'usecount' ); ?>" <?php if($instance['usecount']) { echo 'checked="yes"'; } ?> />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'usecount' ); ?>">How many tags to list:  </label>
			<input id="<?php echo $this->get_field_id( 'numbers' ); ?>" name="<?php echo $this->get_field_name( 'numbers' ); ?>" value="<?php echo $instance['numbers']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>