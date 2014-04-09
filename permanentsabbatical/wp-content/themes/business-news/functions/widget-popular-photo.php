<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'popular_photo_load_widgets' );
/**
 * Register our widget.
 * 'popular_photo_Widget' is the widget class used below.
 */
function popular_photo_load_widgets() {
	register_widget( 'popular_photo_Widget' );
}
/**
 * popular Widget class.
 */
class popular_photo_Widget extends WP_Widget {
	/**
	 * Widget setup.
	 */
	function popular_photo_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'popular', 'description' => 'Popular Photo Post.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'popular-photo-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'popular-photo-widget', 'WLM - Popular Photo Post', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$post_id = $instance['post_id'];
		/* Before widget (defined by themes). */			
		echo $before_widget;
		global $wpdb;
		global $shortname;				$sql = 'SELECT * FROM wp_term_taxonomy				LEFT JOIN wp_term_relationships on wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id				LEFT JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id				LEFT JOIN wp_postmeta on wp_postmeta.meta_key='."'post_views_count'".' AND wp_postmeta.post_id=wp_posts.ID				WHERE wp_term_taxonomy.term_id = ' . $post_id . '				ORDER BY CAST(meta_value as SIGNED) DESC LIMIT 1';				//		echo $sql;			
		$posts = $wpdb->get_results($sql);
		$post_output = '';

		foreach ($posts as $post) {
			$post_title = $post->post_title;
			if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
			if ( strlen($post_description) > 55 ) {
				$post_description = substr($post_description,0,115).'...';
			}						$featured_project_thumb = get_the_post_thumbnail($post->ID, 'popular_photo');			
			$custom = get_post_custom($post->ID);
			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if ( (get_option($shortname.'_blog_post_views') == 'true') && ($custom_post_type == 'post') ) {
				$views_count_output = '<li class="views"><a href="#">'.getPostViews($post->ID).'</a></li>';
			}
			if ( (get_option($shortname.'_news_post_views') == 'true') && ($custom_post_type == 'news') ) {
				$views_count_output = '<li class="views"><a href="#">'.getPostViews($post->ID).'</a></li>';
			}
			if ( (get_option($shortname.'_media_post_views') == 'true') && ($custom_post_type == 'media') ) {
				$views_count_output = '<li class="views"><a href="#">'.getPostViews($post->ID).'</a></li>';
			}
			$post_output = '
				<div class="content">
					<!--a href="#" class="view_all">Show all photos</a-->
					<div class="media"><a href="' . wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) . '" class="general_pic_hover zoom no_fx" data-rel="prettyPhoto" title="'.$post_title.'"><img src="' . wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) . '"></a></div>
                    <p><a href="'.get_permalink($post->ID).'" title="'.$post_title.'">'.$post_title.' <img src="'.get_template_directory_uri().'/images/icon_photo.gif" alt=""></a></p>
					<p class="date">'.get_the_time('d F, Y',$post->ID).'</p>
				</div>
				<div class="info">
					<ul>
						<li class="comments"><a href="#">'.get_comments_number(__('0', 'weblionmedia'),__('1', 'weblionmedia'), __('%', 'weblionmedia')).'</a></li>
						'.$views_count_output.'
					</ul>
				</div>				
			';
		}
		/* Display the widget title if one was input (before and after defined by themes). */
		$the_title_output = '';
		if ($title) $title_output = $before_title.$title.$after_title;
		echo '
			<div class="block_popular_stuff">
				'.$title_output.'
				'.$post_output.'
				<div class="clearboth"></div>
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
		$instance['post_id'] = strip_tags( $new_instance['post_id'] );        
		return $instance;
	}
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Popular Photo.' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php echo 'Category ID:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>" value="<?php echo $instance['post_id']; ?>" style="width:100%;" />
		</p>		
	<?php
	}
}
?>