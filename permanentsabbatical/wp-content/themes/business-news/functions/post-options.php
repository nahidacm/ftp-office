<?php
global $shortname;
$meta_box_post = array(
	'id' => 'my-meta-box',
	'title' => 'Post Options',
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Custom Post Heading',
			'desc' => 'Add custom post heading. If is empty than will be displayed the post title.',
			'id' => 'custom_page_heading',
			'type' => 'text'
		),
		array(
			'name' => 'Custom Page Description',
			'desc' => '<br />Add custom post description. It will be displayed under the post <strong>Title</strong>.',
			'id' => 'custom_page_description',
			'type' => 'textarea'
		),
		array(
			'name' => 'Select Sidebar',
			'desc' => 'Select sidebar and add info to it in Appearance -> Widgets.',
			'id' => 'current_sidebar',
			'type' => 'custom_sidebars'
		),
		array(
			'name' => 'Post Format URL',
			'desc' => '<br/>Add in this field the image, video or audio url and select the Post Format in right sidebar.<br/>
					<small>1. Video url (Vimeo, YouTube):<br />
						&nbsp;&nbsp;&nbsp;a. YouTube format: <strong>http://youtube.com/v9VgQehvw7k</strong><br />
						&nbsp;&nbsp;&nbsp;b. Vimeo format: <strong>http://vimeo.com/42011464</strong></small><br/>
					<small>2. Gallery images list:<br />
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image1.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image2.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image3.jpg</strong><br/>
						&nbsp;&nbsp;&nbsp;<strong>http://www.sitename.com/image4.jpg</strong></small><br/>
			',
			'id' => 'custom_post_format',
			'type' => 'textarea'
		),		
		/*,
		array(
			'name' => 'Post Type',
			'desc' => 'Select the post type.',
			'id' => 'blog_post_type',
			'type' => 'blog_post_type'
		)*/
		
	)
);
add_action('admin_menu', 'mytheme_add_box_post');

// Add meta box
function mytheme_add_box_post() {
    global $meta_box_post;
    
    add_meta_box($meta_box_post['id'], $meta_box_post['title'], 'mytheme_show_box_post', $meta_box_post['page'], $meta_box_post['context'], $meta_box_post['priority']);
}

// Callback function to show fields in meta box
function mytheme_show_box_post() {
    global $meta_box_post, $post, $shortname;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box_post['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong></label></th>',
                '<td>';
        switch ($field['type']) {
		    case 'info':
                echo '<u>'.$field['desc'].'</u>';
				break;
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="'. $meta. '" size="30" style="width:30%" /><br />', '
', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">'. $meta . '</textarea>', '
', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
				
			 case 'custom_sidebars':
			
				$custom = get_post_custom($post->ID);
				$current_sidebar = $custom["current_sidebar"][0];	

               	echo '<select name="'.$field['id'].'">';	
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
				echo '<br/><span>'.$field['desc'].'</span>';
                break;		
				
			 case 'blog_post_type':
			
				$custom = get_post_custom($post->ID);
				$blog_post_type = $custom["blog_post_type"][0];	

               	echo '<select name="'.$field['id'].'">';
			
				$post_type_1_selected = ($blog_post_type == 'Post Type 1') ? 'selected ' : '';
				$post_type_2_selected = ($blog_post_type == 'Post Type 2') ? 'selected ' : '';
				$post_type_3_selected = ($blog_post_type == 'Post Type 3') ? 'selected ' : '';
				
				if (!$post_type_1_selected && $post_type_2_selected && $post_type_2_selected) {
					$post_type_1_selected = ' selected ';
				}

				echo '
					<option '.$post_type_1_selected.'value="Post Type 1">&nbsp;&nbsp;&nbsp;Post Type 1</option>";
					<option '.$post_type_2_selected.'value="Post Type 2">&nbsp;&nbsp;&nbsp;Post Type 2</option>";
					<option '.$post_type_3_selected.'value="Post Type 3">&nbsp;&nbsp;&nbsp;Post Type 3</option>";
				';

				echo '</select>';
				echo '<br/><span>'.$field['desc'].'</span>';
                break;

        }
        echo     '<td>',
            '</tr>';
    }
    
    echo '</table>';
}

add_action('save_post', 'mytheme_save_data_post');

// Save data from meta box
function mytheme_save_data_post($post_id) {
    global $meta_box_post;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($meta_box_post['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
?>