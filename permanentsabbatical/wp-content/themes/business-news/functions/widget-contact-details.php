<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'contactdetails_load_widgets' );

/**
 * Register our widget.
 * 'contactdetails_Widget' is the widget class used below.
 */
function contactdetails_load_widgets() {
	register_widget( 'contactdetails_Widget' );
}

/**
 * contactdetails Widget class.
 */
class contactdetails_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function contactdetails_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'contactdetails', 'description' => 'Contact details.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'contactdetails-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'contactdetails-widget', 'WLM - Contact Details', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$address = $instance['address'];
		$phone = $instance['phone'];
		$email = $instance['email'];
		$website = $instance['website'];
							
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) $title_output = $before_title . $title . $after_title;
		
		if ($address) $address_output = '<p class="address">'.$address.'</p>';
		if ($phone) $phone_output = '<p class="phone">'.__('Phone:','weblionmedia').' '.$phone.'</p>';
		if ($email) $email_output = '<p class="email">'.__('Email:','weblionmedia').' <a href="mailto:'.$email.'" target="_blank">'.$email.'</a></p>';
		if ($website) $website_output = '<p class="web">'.__('Web:','weblionmedia').' <a href="'.$website.'">'.$website.'</a></p>';
		        
		echo '
				<div class="block_contacts">
					'.$title_output.'
					'.$address_output.'
					'.$phone_output.'
					'.$email_output.'
					'.$website_output.'
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
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['website'] = strip_tags( $new_instance['website'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'numbers' => '20', 'description' => 'Contact Details' );
?>



		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'address' ); ?>">Address:</label>
			<input id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>">Phone:</label>
			<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" style="width:100%;" />

			<br /><br />
			<label for="<?php echo $this->get_field_id( 'email' ); ?>">E-mail:</label>
			<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'website' ); ?>">Website URL</label>
			<input id="<?php echo $this->get_field_id( 'website' ); ?>" name="<?php echo $this->get_field_name( 'website' ); ?>" value="<?php echo $instance['website']; ?>" style="width:100%;" />

		</p>

	<?php
	}
}
?>