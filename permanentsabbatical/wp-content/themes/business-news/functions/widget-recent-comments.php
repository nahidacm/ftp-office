<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'comments_posts_load_widgets' );

/**
 * Register our widget.
 * 'Last_Comments_Widget' is the widget class used below.
 */
function comments_posts_load_widgets() {
	register_widget( 'comments_Posts_Widget' );
}

/**
 * comments_Posts Widget class.
 */
class comments_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function comments_Posts_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'comments Posts', 'description' => 'The most recent comments' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'comments-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'comments-posts-widget', 'WLM - Recent Comments', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];
		$excerptlength = $instance['excerptlength'];
		$posttype = $instance['posttype'];


		/* Before widget (defined by themes). */			
		echo $before_widget;		
		
		/* Display the widget title if one was input (before and after defined by themes). */
		
		global $wpdb;
		global $shortname;

		$sql = "SELECT $wpdb->comments.* FROM $wpdb->comments JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_status = 'publish' AND post_type like '%".$posttype."%' ORDER BY comment_date_gmt DESC LIMIT ".$number;

			
		$comments = $wpdb->get_results($sql);
		$output = '';

		if ($excerptlength>0) $excerptLen = $excerptlength;
		if (!$excerptLen) $excerptLen = 100;
		
		if ( $comments ) : foreach ( (array) $comments as $comment) :
				$aRecentComment = get_comment($comment->comment_ID);
				
				$aRecentCommentTxt = $aRecentComment->comment_content;
				
				if ($excerptlength>0){ 
					$aRecentCommentTxt = trim( substr( $aRecentComment->comment_content, 0, $excerptLen ));
				
					if(strlen($aRecentComment->comment_content)>$excerptLen){
						$aRecentCommentTxt .= "...";
					}
				}
				

			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($comment->comment_post_ID);
			if ( comments_open() ) {
			if($num_comments == 0) {
			  $comments = 0;
				} elseif($num_comments > 1) {
				  $comments = $num_comments;
				} else {
				   $comments = 1;
				}
				$write_comments = $comments;
			} else { $write_comments = 0; }
			
			$post_title = get_the_title($comment->comment_post_ID);
			$post_date_gmt = get_the_time('d F, Y');
			$views_count_output = '';
			$custom_post_type = get_post_type($comment->comment_post_ID);
			if (get_option($shortname.'_news_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($comment->comment_post_ID).'" class="views">'.getPostViews($comment->comment_post_ID).'</a>';
			}
			
			$output .=  '
			
                                    <div class="block_home_news_post">
                                    	<div class="info">
                                        	<div class="date"><p>'.$post_date_gmt.'</p></div>
                                            <div class="r_part">
                                            	'.$views_count_output.'
                                                <a href="'.get_permalink($comment->comment_post_ID).'" class="comments">'.$write_comments.'</a>
                                            </div>
                                        </div>
                                        <p class="title"><a href="'.get_permalink($comment->comment_post_ID).'">'.$post_title.'</a></p>
										<p>'.$aRecentCommentTxt.'<p>
                                    </div>			
			';
			
			endforeach; 
		endif;
		
		
		if ( $title ) echo $widget_title = $before_title . $title . $after_title;
		echo '<div class="tab_content" style="margin-top:-14px;">'.$output.'</div>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['excerptlength'] = strip_tags( $new_instance['excerptlength'] );
		$instance['posttype'] = $new_instance['posttype'];
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Recent Comments', 'number' => '3', 'excerptlength' => 101, 'description' => 'The most recent comments' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo 'Count:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'excerptlength' ); ?>"><?php echo 'Excerpt length:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'excerptlength' ); ?>" name="<?php echo $this->get_field_name( 'excerptlength' ); ?>" value="<?php echo $instance['excerptlength']; ?>" style="width:100%;" />
		</p>
	

		<p>
			<label for="<?php echo $this->get_field_id( 'posttype' ); ?>"><?php echo 'Custom post type:'; ?></label>
			<select id="<?php echo $this->get_field_id( 'posttype' ); ?>" name="<?php echo $this->get_field_name( 'posttype' ); ?>">
				<option value="" <?php if ( '' == $instance['posttype'] ) echo 'selected="selected"'; ?>>All</option>
				<option value="post" <?php if ( 'post' == $instance['posttype'] ) echo 'selected="selected"'; ?>>Post</option>
				<option value="news" <?php if ( 'news' == $instance['posttype'] ) echo 'selected="selected"'; ?>>News</option>
				<option value="media" <?php if ( 'media' == $instance['posttype'] ) echo 'selected="selected"'; ?>>Media</option>
			</select>
		</p>
		
	<?php
	}
}

?>