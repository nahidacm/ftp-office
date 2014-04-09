<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'contact_load_widgets' );

/**
 * Register our widget.
 * 'contact_Widget' is the widget class used below.
 */
function contact_load_widgets() {
	register_widget( 'contact_Widget' );
}

/**
 * contact Widget class.
 */
class contact_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function contact_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'contact', 'description' => 'Contact Form.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'contact-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'contact-widget', 'WLM - Contact Form', $widget_ops, $control_ops );
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
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;

		echo '
                                <div class="block_contact_footer">
									<form method="post" id="widget_contact_form" action="#feedback">
                                    	<p class="text">'.__('Name:','weblionmedia').'</p>
                                        <div class="field"><input type="text" id="username" name="username"></div>
                                        
                                        <p class="text">'.__('Email:','weblionmedia').'</p>
                                        <div class="field"><input type="text" id="email" name="email"></div>
                                        
                                        <p class="text">'.__('Message:','weblionmedia').'</p>
                                        <div class="textarea"><textarea cols="1" rows="1"  id="message" name="message"></textarea></div>
                                        
                                        <div class="clear_form"><input type="reset" value="'.__('Clear form','weblionmedia').'"></div>
                                        <div class="send"><input type="submit" class="general_button" value="'.__('Submit','weblionmedia').'"></div>
                                        
                                        <div class="clearboth"></div>
                                    </form>
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
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Contact Form.' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>