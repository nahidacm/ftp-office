<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'meta_links_load_widgets' );

/**
 * Register our widget.
 * 'meta_links_Widget' is the widget class used below.
 */
function meta_links_load_widgets() {
	register_widget( 'meta_links_Widget' );
}

/**
 * meta_links Widget class.
 */
class meta_links_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function meta_links_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'meta_links', 'description' => 'Meta.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'meta_links-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'meta_links-widget', 'Meta', $widget_ops, $control_ops );
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
		
		echo '
			<div class="block_sidebar_menu">
		';
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;		
?>		
	
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="http://wordpress.org/" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.')); ?>">WordPress.org</a></li>
					<?php wp_meta(); ?>
				</ul>
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
		$defaults = array( 'title' => '', 'description' => 'meta' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			
			<!--br /><br />
			<label for="<?php echo $this->get_field_id( 'usearrow' ); ?>">Use arrows for meta list</label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'usearrow' ); ?>" <?php if($instance['usearrow']) { echo 'checked="yes"'; } ?> /-->
		</p>

	<?php
	}
}
?>