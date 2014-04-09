<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'subpages_links_load_widgets' );

/**
 * Register our widget.
 * 'subpages_links_Widget' is the widget class used below.
 */
function subpages_links_load_widgets() {
	register_widget( 'subpages_links_Widget' );
}

/**
 * subpages_links Widget class.
 */
class subpages_links_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function subpages_links_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'subpages_links', 'description' => 'subpages list.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'subpages_links-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'subpages_links-widget', 'WLM - Parrent SubPages', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;
		wp_reset_query();
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		echo '
			<div class="block_sidebar_menu">
		';
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;		
		
		echo '
				<ul>
		';
		
		if(wp_list_pages("child_of=".$post->ID."&echo=0")) {
			wp_list_pages("title_li=&depth=1&child_of=".$post->ID."&sort_column=menu_order&show_date=modified&date_format=");
		} else {
			wp_list_pages("title_li=&depth=1&child_of=".$post->post_parent."&sort_column=menu_order&show_date=modified&date_format="); 
		}
		
		echo '
				</ul>
				<div class="line_2"></div>
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
		//$instance['usearrow'] = strip_tags( $new_instance['usearrow'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'subpages' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			
			<!--br /><br />
			<label for="<?php echo $this->get_field_id( 'usearrow' ); ?>">Use arrows for subpages list</label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'usearrow' ); ?>" <?php if($instance['usearrow']) { echo 'checked="yes"'; } ?> /-->
		</p>

	<?php
	}
}
?>