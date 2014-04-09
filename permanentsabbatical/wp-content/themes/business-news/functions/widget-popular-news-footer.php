<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'popular_news_footer_load_widgets' );

/**
 * Register our widget.
 * 'Last_Comments_Widget' is the widget class used below.
 */
function popular_news_footer_load_widgets() {
	register_widget( 'popular_news_footer_widget' );
}

/**
 * popular_news_footer Widget class.
 */
class popular_news_footer_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function popular_news_footer_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Popular news', 'description' => 'The most popular news' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'popular-news-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'popular-news-widget', 'WLM - Popular News (for footer)', $widget_ops, $control_ops );
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

		/* Display the widget title if one was input (before and after defined by themes). */
		$title_output = '';
		if ( $title ) echo $before_title . $title . $after_title;		
		
		$output = '';		
		
		$output .= '
			<div class="block_most_read_news">
		';
		
		global $wpdb;
		global $shortname;
		
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="news" 
			ORDER BY '.$wpdb->posts.'.comment_count DESC
			LIMIT 0,'.$number;

		$news = $wpdb->get_results($sql);

		foreach ($news as $post) {
						
			$post_title = $post->post_title;
			if (strlen($post_title) > 60) {
				$post_title = substr($post_title,0,60).'...';
			}
			
			$post->post_date = date("d F, Y",strtotime($post->post_date));
			$popular_news_footer_thumb = get_the_post_thumbnail($post->ID, 'popular_posts');
			$output .= '
				
                                	<div class="article">
                                    	<div class="pic">
                                        	<a href="'.get_permalink($post->ID).'" class="w_hover">
                                            	'.$popular_news_footer_thumb.'
                                                <span></span>
                                            </a>
                                        </div>
                                        <div class="text">
                                        	<p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
                                            <p class="date">'.$post->post_date.'</p>
                                        </div>
                                    </div>
                                    <div class="line_1"></div>				
			';
		}
		
		$output .= '
			</div>
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
		$defaults = array( 'title' => '', 'number' => '3', 'description' => 'The most popular news' );
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