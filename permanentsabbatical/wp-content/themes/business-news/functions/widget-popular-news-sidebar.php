<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'popular_news_sidebar_load_widgets' );

/**
 * Register our widget.
 * 'Last_Comments_Widget' is the widget class used below.
 */
function popular_news_sidebar_load_widgets() {
	register_widget( 'popular_news_sidebar_widget' );
}

/**
 * Popular_news_sidebar Widget class.
 */
class popular_news_sidebar_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function popular_news_sidebar_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Popular news_sidebar', 'description' => 'The most popular blog posts' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'popular-news_sidebar-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'popular-news_sidebar-widget', 'WLM - Popular News (for sidebar)', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];

		/* Before widget (defined by themes). */			
		echo $before_widget;		

		
		$output = '';		
		$output .= '
			<div class="block_popular_posts">
		';
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) $output .= $before_title . $title . $after_title;		
		
		global $wpdb;
		global $shortname;
		
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="news" 
			ORDER BY '.$wpdb->posts.'.comment_count DESC
			LIMIT 0,'.$number;

		$news_sidebar = $wpdb->get_results($sql);

		$post_number = 0;
		foreach ($news_sidebar as $post) {
			$post_title = $post->post_title;
			if (strlen($post_title) > 60) {
				$post_title = substr($post_title,0,60).'...';
			}
			
			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_news_post_views') == 'true') {
				$views_count_output = '<li><a href="'.get_permalink($post->ID).'" class="views">'.getPostViews($post->ID).'</a></li>';
			}
			
			$post->post_date = date("d F, Y",strtotime($post->post_date));
			$popular_news_sidebar_thumb = get_the_post_thumbnail($post->ID, 'popular_posts');
			$output .= '
                        	<div class="article">
								<div class="pic">
									<a href="'.get_permalink($post->ID).'" class="w_hover">
                                      	'.$popular_news_sidebar_thumb.'
										<span></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
                                    <div class="date"><p>'.$post->post_date.'</p></div>
                                    <div class="icons">
                                    	<ul>
                                        	'.$views_count_output.'
                                            <li><a href="'.get_permalink($post->ID).'" class="comments">'.get_comments_number($post->ID).'</a></li>
                                        </ul>
                                    </div>
								</div>
							</div>
			';
			$post_number++;
			if ($post_number == 3) { $output .= '<div class="line_2"></div>'; } else {  $output .= '<div class="line_3"></div>'; }
			
		}

		$output .= '
			</div>
			<div class="separator" style="height:31px;"></div>
		';

		echo $output;
		/* After widget (defined by themes). */
		//echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'number' => '3', 'description' => 'The most popular blog posts' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo 'Count:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>