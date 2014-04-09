<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'followers_load_widgets' );

function twitter_followers_counter($username) {
	
	$cache_file = '/CACHEDIR_twitter_followers_counter_' . md5 ( $username );
	if (is_file ( $cache_file ) == false) {
		$cache_file_time = strtotime ( '1984-01-11 07:15' );
	} else {
		$cache_file_time = filemtime ( $cache_file );
	}
	$now = strtotime ( date ( 'Y-m-d H:i:s' ) );
	$api_call = $cache_file_time;
	$difference = $now - $api_call;
	$api_time_seconds = 1800;
	if ($difference >= $api_time_seconds) {
		$api_page = 'http://twitter.com/users/show/' . $username;
		$xml = file_get_contents ( $api_page );
		$profile = new SimpleXMLElement ( $xml );
		$count = $profile->followers_count;
		if (is_file ( $cache_file ) == true) {
			unlink ( $cache_file );
		}
		touch ( $cache_file );
		file_put_contents ( $cache_file, strval ( $count ) );
		return strval ( $count );
	} else {
		$count = file_get_contents ( $cache_file );
		return strval ( $count );
	}
}


function fan_count($facebook_name){
    $data = json_decode(file_get_contents("https://graph.facebook.com/".$facebook_name));
    echo $data->likes;
}
//echo fan_count("psdtuts");


/**
 * Register our widget.
 * 'followers_Widget' is the widget class used below.
 */
function followers_load_widgets() {
	register_widget( 'followers_Widget' );
}

/**
 * followers Widget class.
 */
class followers_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function followers_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'followers', 'description' => 'Followers.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'followers-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'followers-widget', 'WLM - Followers Count', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );	
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$feedburner = $instance['feedburner'];
		$feedburner_count = $instance['feedburner_count'];
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		if ($twitter) {
			$data_twitter = twitter_followers_counter($twitter);
			$twitter_output = '
                            <div class="service">
                            	<a href="http://www.twitter.com/'.$twitter.'" class="tw">
                                	<span class="num">'.$data_twitter.'</span>
                                    <span class="people">Followers</span>
                                </a>
                            </div>
			';
		}
		
		
		if ( ($feedburner) && ($feedburner_count)) {
			$feedburner_output = '
                        	<div class="service">
                            	<a href="http://feeds.feedburner.com/'.$feedburner.'" class="rss">
                                	<span class="num">'.$feedburner_count.'</span>
                                    <span class="people">Subscribers</span>
                                </a>
                            </div>
			';
		}
		
		if ($facebook) {
			$facebook_likes = json_decode(file_get_contents('http://graph.facebook.com/'.$facebook))->likes;
			$facebook_output = '
                            <div class="service">
                            	<a href="http://www.facebook.com/'.$facebook.'" class="fb">
                                	<span class="num">'.$facebook_likes.'</span>
                                    <span class="people">Subscribers</span>
                                </a>
                            </div>
			';
		}
		
		echo '
                    	<div class="block_subscribes_sidebar">
							'.$feedburner_output.'
							'.$twitter_output.'
							'.$facebook_output.'
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
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['feedburner'] = strip_tags( $new_instance['feedburner'] );
		$instance['feedburner_count'] = strip_tags( $new_instance['feedburner_count'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'numbers' => '20', 'description' => 'Followers' );
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Facebook Username:</label>
			<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Twitter Username:</label>
			<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" style="width:100%;" />

			<br /><br />
			<label for="<?php echo $this->get_field_id( 'feedburner' ); ?>">Feedburner Username:</label>
			<input id="<?php echo $this->get_field_id( 'feedburner' ); ?>" name="<?php echo $this->get_field_name( 'feedburner' ); ?>" value="<?php echo $instance['feedburner']; ?>" style="width:100%;" />
			
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'feedburner_count' ); ?>">Feedburnet RSS Count: (Because Feedburner API is deprecated, manual entry is required):</label>
			<input id="<?php echo $this->get_field_id( 'feedburner_count' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_count' ); ?>" value="<?php echo $instance['feedburner_count']; ?>" style="width:100%;" />

		</p>

	<?php
	}
}
?>