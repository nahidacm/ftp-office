<?php
	add_action('init', 'portfolio_register');
	function portfolio_register() {
		  $labels = array(
		    'name' => 'Portfolio',
		    'singular_name' => 'Portfolio Entry',
		    'add_new' => 'Add New',
		    'add_new_item' => 'Add New Portfolio Entry',
		    'edit_item' => 'Edit Portfolio Entry',
		    'new_item' => 'New Portfolio Entry',
		    'view_item' => 'View Portfolio Entry',
		    'search_items' => 'Search Portfolio Entries',
		    'not_found' =>  'No Portfolio Entries found',
		    'not_found_in_trash' => 'No Portfolio Entries found in Trash', 
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
        	'rewrite' => array('slug'=>'portfolio-item','with_front'=>false),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
        	'show_in_nav_menus'=> false,
			'query_var' => true,
			'paged' => $paged,			
        	'menu_position' => 100,
        	'supports' => array('title','thumbnail','excerpt','editor','comments')
        );
	
    	register_post_type('portfolio' , $args);
		
		
    	register_taxonomy("portfolio_entries", 
					    	array("portfolio"), 
					    	array(	"hierarchical" => true, 
					    			"label" => "Portfolio Categories", 
					    			"singular_label" => "Portfolio Categories", 
					    			'rewrite' => array('slug' => 'portfolio-category'),
					    			"query_var" => true,
									'paged' => $paged
					    		));  
		flush_rewrite_rules( false );	
	}
	
	add_action('admin_init', 'add_portfolio');
	flush_rewrite_rules(false);
	
	add_action('save_post', 'update_portfolio');
	function add_portfolio(){
		add_meta_box("portfolio_details", "Portfolio Options", "portfolio_options", "portfolio", "normal", "low");
	}
	function portfolio_options(){
		global $post, $shortname;
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		
		$custom = get_post_custom($post->ID);
				
		$custom_page_heading = $custom["custom_page_heading"][0];
		$custom_page_description = $custom["custom_page_description"][0];
		$portfolio_client_name = $custom["portfolio_client_name"][0];
		$portfolio_client_site_url = $custom["portfolio_client_site_url"][0];
		$portfolio_video_url = $custom["portfolio_video_url"][0];		
		$current_sidebar = $custom["current_sidebar"][0];
		
		if (!$header_background_height) {
			if ($header_background_url) $header_background_height = '350';
		}

?>
		
	<div id="portfolio-options">
		<table class="form-table">
		
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Custom Portfolio Page Heading:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%"  type="text" name="custom_page_heading" value="<?php echo $custom_page_heading; ?>" /><br/>
					<small>Add custom portfolio page heading. If is empty than will be displayed portfolio page item title.</small><br/><br/><br/>
				</td>
			</tr>
			<!--tr>
				<td valign="top" style="width:100px;">
					<label><strong>Custom Portfolio Page Description:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%" type="text" name="custom_page_description" value="<?php echo $custom_page_description; ?>" /><br/>
					<small>Add custom portfolio page description. It will be displayed under the <strong>Custom Portfolio Page Heading</strong>.</small><br/><br/><br/>
				</td>
			</tr-->			
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Author Name:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%" type="text" name="portfolio_client_name" value="<?php echo $portfolio_client_name; ?>" /><br/>
					<small>Add author name of this work.</small><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Author Site URL:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%" type="text" name="portfolio_client_site_url" value="<?php echo $portfolio_client_site_url; ?>" /><br/>
					<small>Add author site URL.</small><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td valign="top" style="width:100px;">
					<label><strong>Video URL:</strong></label>
				</td>
				<td>
					
				</td>
				<td>
					<input size="30" style="height:30px; width:97%" type="text" name="portfolio_video_url" value="<?php echo $portfolio_video_url; ?>" /><br/>
					<small>Add video url (Vimeo, YouTube).<br />
						1. YouTube format: <strong>http://youtube.com/v9VgQehvw7k</strong><br />
						2. Vimeo format: <strong>http://vimeo.com/42011464</strong></small><br/><br/><br/>
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
	</div><!--end portfolio-options-->   
<?php

	}
	function update_portfolio(){
		global $post, $shortname;		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		} else {
			update_post_meta($post->ID, "custom_page_heading", $_POST["custom_page_heading"]);
			update_post_meta($post->ID, "custom_page_description", $_POST["custom_page_description"]);
			update_post_meta($post->ID, "portfolio_client_name", $_POST["portfolio_client_name"]);
			update_post_meta($post->ID, "portfolio_client_site_url", $_POST["portfolio_client_site_url"]);
			update_post_meta($post->ID, "portfolio_video_url", $_POST["portfolio_video_url"]);
			update_post_meta($post->ID, "current_sidebar", $_POST["current_sidebar"]);
		}
	}

add_filter("manage_edit-portfolio_columns", "prod_edit_columns");
add_action("manage_posts_custom_column",  "prod_custom_columns");

function prod_edit_columns($columns){

		$newcolumns = array(
			"title" => "Title"/*,
			"portfolio_image" => "Image",
			"portfolio_entries" => "Categories"*/
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function prod_custom_columns($column){
		global $post;
		switch ($column)
		{
		case "portfolio_image":
				$image_id = get_post_thumbnail_id($post->ID);
				$image_url = wp_get_attachment_image_src($image_id,'marketplace', true);
				$get_custom_image_url = $image_url[0];
				echo '<img src="'.$get_custom_image_url.'" height="67px" style="padding: 5px 10px 20px 5px; "/>';
				break;
			case "description":
				the_excerpt();
				break;
			case "portfolio_entries":
				echo get_the_term_list($post->ID, 'portfolio_entries', '', ', ','');
				break;
		}
}

?>