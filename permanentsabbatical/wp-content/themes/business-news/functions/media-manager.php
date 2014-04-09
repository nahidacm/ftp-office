<?php
	add_action('init', 'media_register');
	function media_register() {
		  $labels = array(
		    'name' => 'Media Manager',
		    'singular_name' => 'Media Entry',
		    'add_new' => 'Add Media',
		    'add_new_item' => 'Add New Media Entry',
		    'edit_item' => 'Edit Media Entry',
		    'new_item' => 'New Media Entry',
		    'view_item' => 'View Media Entry',
		    'search_items' => 'Search Media Entries',
		    'not_found' =>  'No Media Entries found',
		    'not_found_in_trash' => 'No Media Entries found in Trash', 
		    'parent_item_colon' => ''
		  );
	
		$slugRule = get_option('category_base');
		//if($slugRule == "") $slugRule = 'category';

		global $paged;
		
    	$args = array(
        	'labels' => $labels,
        	'public' => true,
        	'show_ui' => true,
			'_builtin' => false,
        	'rewrite' => array('slug'=>'media-item','with_front'=>false),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
        	'show_in_nav_menus'=> false,
			'query_var' => true,
			'paged' => $paged,			
        	'menu_position' => 100,
			'taxonomies' => array('post_tag'), // this is IMPORTANT
			'supports' => array('title','thumbnail','excerpt','editor','comments','page-attributes','author')
        );
	
    	register_post_type('media' , $args);
		
		
    	register_taxonomy("media_entries", 
					    	array("media"), 
					    	array(	"hierarchical" => true, 
					    			"label" => "Media Categories", 
					    			"singular_label" => "Media Categories", 
					    			'rewrite' => array('slug' => 'media-category'),
					    			"query_var" => true,
									'paged' => $paged
					    		));  
		flush_rewrite_rules( false );	
	}
	
	add_action('admin_init', 'add_media');
	flush_rewrite_rules(false);
	
	add_action('save_post', 'update_media');
	function add_media(){
		add_meta_box("media_details", "Media Options", "media_options", "media", "normal", "low");
	}
	function media_options(){
		global $post, $shortname;
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		
		$custom = get_post_custom($post->ID);
				
		$custom_page_heading = $custom["custom_page_heading"][0];
		$custom_page_description = $custom["custom_page_description"][0];
		$custom_post_format = $custom["custom_post_format"][0];
		$current_sidebar = $custom["current_sidebar"][0];
		
		if (!$header_background_height) {
			if ($header_background_url) $header_background_height = '350';
		}
?>
		
	<div id="media-options">
		<table class="form-table">
		
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Custom Media Page Heading:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%"  type="text" name="custom_page_heading" value="<?php echo $custom_page_heading; ?>" /><br/>
					<small>Add custom media page heading. If is empty than will be displayed media page item title.</small><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Custom Media Page Description:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%" type="text" name="custom_page_description" value="<?php echo $custom_page_description; ?>" /><br/>
					<small>Add custom media page description. It will be displayed under the Meda page<strong>Title</strong>.</small><br/><br/><br/>
				</td>
			</tr>			
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Media Page Format URL:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<textarea style="width:97%" cols="100" rows="5" name="custom_post_format"><?php echo $custom_post_format; ?></textarea><br/>
					<small><br/>Add in this field the image, video or audio url and select the Post Format in right sidebar.<br/>
					<small>1. Video url (Vimeo, YouTube):<br />
						&nbsp;&nbsp;&nbsp;a. YouTube format: <strong>http://youtube.com/v9VgQehvw7k</strong><br />
						&nbsp;&nbsp;&nbsp;b. Vimeo format: <strong>http://vimeo.com/42011464</strong></small><br/>
					<small>2. Gallery images list:<br />
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image1.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image2.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image3.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image4.jpg</strong></small><br/></small><br/><br/><br/>
				</td>
			</tr>
						
			<?php 
				$get_custom_options = get_option($shortname.'_sidebars_cp');
				
				if ($get_custom_options[$shortname.'_sidebars_cp_url_1']) {
			?>
			<tr>
				<td>
					<label>Select Sidebar: </label><br/><br/>
				</td>
				<td>
					
				</td>
				<td>
					<?php				
						echo '<select name="current_sidebar">';	
						echo '<option value=""></option>';		
						
						
						$get_custom_options = get_option($shortname.'_sidebars_cp');
						$m = 0;
						for($i = 1; $i <= 200; $i++) 
						{
							if ($get_custom_options[$shortname.'_sidebars_cp_url_'.$i])
							{	
								if ( $current_sidebar == $get_custom_options[$shortname.'_sidebars_cp_url_'.$i] ) { 
									?>
										<option selected value='<?php echo $get_custom_options[$shortname.'_sidebars_cp_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebars_cp_url_'.$i]; ?></option>";
									<?php	
								} else {
									?>
										<option value='<?php echo $get_custom_options[$shortname.'_sidebars_cp_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebars_cp_url_'.$i]; ?></option>";
									<?php 
								}
							}
						}
						
						echo '</select>';
					?>
					<br/><label>Select sidebar and add info to it in Appearance -> Widgets.</label><br/>
				</td>
			</tr>			
			<?php } ?>
			
 		
			
		</table>
	</div><!--end media-options-->   
<?php

	}
	function update_media(){
		global $post, $shortname;		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		} else {
			update_post_meta($post->ID, "custom_page_heading", $_POST["custom_page_heading"]);
			update_post_meta($post->ID, "custom_page_description", $_POST["custom_page_description"]);
			update_post_meta($post->ID, "custom_post_format", $_POST["custom_post_format"]);
		}
	}

add_filter("manage_edit-media_columns", "media_edit_columns");
add_action("manage_posts_custom_column",  "media_custom_columns");

function media_edit_columns($columns){

		$newcolumns = array(
			"title" => "Title",
			"media_image" => "Image",
			"media_entries" => "Categories"
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function media_custom_columns($column){
		global $post;
		switch ($column)
		{
		case "media_image":
				$image_id = get_post_thumbnail_id($post->ID);
				$image_url = wp_get_attachment_image_src($image_id,'',true);
				$get_custom_image_url = $image_url[0];
				echo '<img src="'.$get_custom_image_url.'" height="67px" style="padding: 5px 10px 20px 5px; "/>';
				break;
			case "description":
				the_excerpt();
				break;
			case "media_entries":
				echo get_the_term_list($post->ID, 'media_entries', '', ', ','');
				break;
		}
}
?>