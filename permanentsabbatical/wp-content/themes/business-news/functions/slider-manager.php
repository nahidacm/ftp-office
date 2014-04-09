<?php
/* Create Sliders Items */
add_action('init', 'create_slider');
function create_slider() {
    	$slider_args = array(
        	'label' => 'Slider Manager',
        	'singular_label' => 'Slider',
        	'public' => true,
        	'show_ui' => true,
			'menu_position' => 100,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => true,
        	'supports' => array('title','thumbnail', 'page-attributes')
        );
    	register_post_type('slider',$slider_args);
	}

	add_action( 'init', 'create_slider_id' );
	function create_slider_id() {
		 $labels = array(
			'name' => __('Slider ID','weblionmedia'),
			'singular_name' => __('Slider ID','weblionmedia'),
			'search_items' =>  __('Search Slider ID','weblionmedia'),
			'all_items' => __('All Slider IDs','weblionmedia'),
			'parent_item' => __('Parent Slider ID','weblionmedia'),
			'parent_item_colon' => __('Parent Slider ID:','weblionmedia'),
			'edit_item' => __('Edit Slider ID','weblionmedia'),
			'update_item' => __('Update Slider ID','weblionmedia'),
			'add_new_item' => __('Add New Slider ID','weblionmedia'),
			'new_item_name' => __('New Slider ID Name','weblionmedia'),
		  );
	
		register_taxonomy('slider_id_name','slider',array(
			'hierarchical' => true,
			'labels' => $labels
		));
	}  

	//global $shortname;
	//$selected_slider = get_option($shortname.'_slider_type');

	add_action('admin_init', 'add_slider');
	add_action('save_post', 'update_slider_website_url');
	
	function add_slider(){
		add_meta_box("slider_details", "Slider Options", "slider_options", "slider", "normal", "low");
	}
	
	function slider_options(){
		global $post, $shortname;
		$selected_slider = get_option($shortname.'_slider_type');
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		$custom = get_post_custom($post->ID);
		$slider_title = $custom["slider_title"][0];
		$slider_description = $custom["slider_description"][0];
		$slider_website_url = $custom["slider_website_url"][0];
		

?>
	<div id="slider-options">
		<table class="form-table">

		
			<tr>
				<td>
					<strong>Title</strong><br />
					<small>Add slide title</small><br />
					<input size="30" style="height:30px; width:97%" type="text" name="slider_title" value="<?php echo $slider_title; ?>" /><br /><br />
				</td>
			</tr>
			<tr>
				<td>
					<strong>Description</strong><br />
					<small>Add slide description </small><br />
					<textarea name="slider_description" cols="75" rows="10" style="width:97%"><?php echo $slider_description; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<strong>URL</strong><br />
					<small>URL the Slide gets linked to</small><br />
					<input size="30" style="height:30px; width:97%" type="text" name="slider_website_url" value="<?php echo $slider_website_url; ?>" /><br /><br />
				</td>
			</tr>
		</table>
	</div><!--end slider-options-->
<?php
	}

	function update_slider_website_url(){
		global $post, $shortname;		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		} else {
			update_post_meta($post->ID, "slider_title", $_POST["slider_title"]);
			update_post_meta($post->ID, "slider_description", $_POST["slider_description"]);
			update_post_meta($post->ID, "slider_website_url", $_POST["slider_website_url"]);			
		}
	}
	

add_filter("manage_edit-slider_columns", "slider_edit_columns");
add_action("manage_posts_custom_column",  "slider_custom_columns");

function slider_edit_columns($columns){

		$newcolumns = array(
			"title" => "Title",
			"slider_image" => "Slider Image",
			"slider_id" => "Slider ID"
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function slider_custom_columns($column){
		global $post;
		switch ($column)
		{
			case "slider_image":
				$image_id = get_post_thumbnail_id($post->ID);
				$image_url = wp_get_attachment_image_src($image_id,'marketplace', true);
				$get_custom_image_url = $image_url[0];
				echo '<img src="'.$get_custom_image_url.'" height="100px" style="padding: 5px 10px 20px 5px; "/>';
				break;
			case "slider_id":
					echo get_the_term_list( get_the_ID(), 'slider_id_name', '', ', ', '' );
				break;
		}
}
?>