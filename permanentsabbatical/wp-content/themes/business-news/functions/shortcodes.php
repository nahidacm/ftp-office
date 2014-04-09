<?php
/**
 * Theme Shortcodes Functions
*/


//[recent_posts_slider count="9" catid="7"]
function theme_recent_posts_slider($atts, $content=null){
    extract(shortcode_atts(array(
		"count" => "9",
		"display_count" => "3",
		"catid" => ""
    ), $atts));

	global $wp_query, $post;
	
	if (!$count) $count = 9;
	if (!$display_count) $display_count = 3;
	
	$display_count = round($count / 3);
	
	$type = 'post';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'cat' => $catid,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$posts_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
					$cat_slug = $cat_url_html;
				} else {
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
					$cat_slug .= ', '.$cat_url_html;
				}
			}
		}
		
		// get full image from featured image if was not see full image url in Posts
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$posts_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $posts_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $posts_content_excerpt_length).'...';
		}

		if ($i == 0) $posts_items_output .= ' <li> ';
			
		$full_title = get_the_title();
		if (strlen($full_title) < 38) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_blog_post_views') == 'true') {
			$views_count_output = '                                    
					<div class="icons">
							<ul>
								<li><a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a></li>
							</ul>
						</div>
			';
		}
		
		$posts_items_output .= '
                        	<div class="block_home_post">
								<div class="pic">
									<a href="'.get_permalink().'" class="w_hover">
										'.$image_thumb.'
										<span></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
									<div class="date"><p>'.get_the_time('d F, Y').'</p></div>
									'.$views_count_output.'
								</div>
							</div>
		';
		
		$i++;
		if ($i == $display_count) {
			$posts_items_output .= ' <div class="line_3" style="margin:13px 0 0;"></div></li> ';
			$i = 0;
		} else {
			$posts_items_output .= ' <div class="line_3" style="margin:13px 0 17px;"></div> ';
		}

	endwhile;
	endif;
	
	if ($i > $display_count) {
			$posts_items_output .= ' </li> ';
	}
	
	$wp_query = null;
	$wp_query = $temp;	

	global $wpdb;
	$posts_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value  like 'template-blog%.php'");
	$posts_page_link = get_permalink($posts_page_id);
	if ($posts_page_id) {
		$all_posts_page_output = '
			<a href="'.$posts_page_link.'" class="lnk_all_news fl">'.__('All Posts','weblionmedia').'</a>
			<div class="clearboth"></div>
			<div class="line_3" style="margin:13px 0px 35px;"></div>
		';
	} else {
		$all_posts_page_output = '
			<div class="clearboth"></div>
			<div style="margin:13px 0px 35px;"></div>
		';
	}
	
	return '
		<div id="home_posts_slider" class="home_news_slider flexslider">
			<ul class="slides">	
				'.$posts_items_output.'
			</ul>
		</div>
		<script type="text/javascript">
			jQuery(function() {
				jQuery(\'#home_posts_slider\').flexslider({
					animation : \'slide\',
					controlNav : true,
					directionNav : true,
					animationLoop : false,
					slideshow : false,
					useCSS : false
				});
			});
		</script>
		<div class="separator" style="height:13px;"></div>
		'.$all_news_page_output.'
		<!-- end Recent News -->
	';
}
add_shortcode('recent_posts_slider', 'theme_recent_posts_slider');



//[best_posts_slider_bycomments title="Top Stories" count="6" sliderid="best_posts_slider4"]
function theme_best_posts_slider_bycomments($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "10",
		"sliderid" => "" //unique slider id
    ), $atts));

	global $wp_query, $post;


	if (!$count) $count = 10;
	
	$type = 'post';
	$args = array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'orderby' => 'comment_count',
		'order' => 'desc'
	);

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();									
		// get full image from featured image if was not see full image url in posts
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$custom = get_post_custom($post->ID);
		$posts_video_url = $custom["posts_video_url"][0];						
		$video_class = '';
		if ($posts_video_url) {
			$posts_video_url = str_replace('youtube.com/embed/','youtube.com/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtube.com/embed/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtu.be/',$posts_video_url);
			$posts_video_url = str_replace('youtu.be/embed/','youtu.be/',$posts_video_url);
			$image_preview_url = $posts_video_url;
			
			$video_class = '-media';
		}
		
		$posts_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $posts_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $posts_content_excerpt_length).'...';
		}

		$post_categories = wp_get_post_categories( $post->ID );
		$cats = array();
		$cat_url_html = '';
		foreach($post_categories as $c){
			$cat = get_category( $c );
			$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			if (!$cat_url_html) {
				$cat_url_html = '<a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			} else {
				$cat_url_html = ', <a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>							
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_posts_slider_bycomments', 'theme_best_posts_slider_bycomments');


//[best_posts_slider_byid title="Top Stories" id_array="153,140,131,129,74,88,121" sliderid="best_posts_slider3"]
function theme_best_posts_slider_byid($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"id_array" => "",
		"sliderid" => "" //unique slider id
    ), $atts));

	global $wp_query, $post;
	
	$ids_chunks = explode(",", $id_array);
	for ($i=0;$i<count($ids_chunks);$i++) {
		$id_array_final[] = trim($ids_chunks[$i]);
	}
	
	$count = count($ids_chunks);
	
	$type = 'post';
	$args = array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'post__in' => $id_array_final
	);

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							
		// get full image from featured image if was not see full image url in posts
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$custom = get_post_custom($post->ID);
		$posts_video_url = $custom["posts_video_url"][0];						
		$video_class = '';
		if ($posts_video_url) {
			$posts_video_url = str_replace('youtube.com/embed/','youtube.com/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtube.com/embed/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtu.be/',$posts_video_url);
			$posts_video_url = str_replace('youtu.be/embed/','youtu.be/',$posts_video_url);
			$image_preview_url = $posts_video_url;
			
			$video_class = '-media';
		}
		
		$posts_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $posts_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $posts_content_excerpt_length).'...';
		}

		$post_categories = wp_get_post_categories( $post->ID );
		$cats = array();
		$cat_url_html = '';
		foreach($post_categories as $c){
			$cat = get_category( $c );
			$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			if (!$cat_url_html) {
				$cat_url_html = '<a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			} else {
				$cat_url_html = ', <a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>							
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_posts_slider_byid', 'theme_best_posts_slider_byid');


//[best_posts_slider_bycat title="Top Stories" count="" catid="" sliderid="best_posts_slider1"]
//[best_posts_slider_bycat title="Top Stories" count="6" catid="7" sliderid="best_posts_slider2"]
function theme_best_posts_slider_bycat($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "10",
		"catid" => "",
		"sliderid" => "" //unique slider id
		
    ), $atts));

	global $wp_query, $post;
	
	if (!$count) $count = 10;
	
	$type = 'post';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'cat' => $catid,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'menu_order',
			'order' => 'asc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'menu_order',
			'order' => 'asc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();									
		// get full image from featured image if was not see full image url in posts
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$custom = get_post_custom($post->ID);
		$posts_video_url = $custom["posts_video_url"][0];						
		$video_class = '';
		if ($posts_video_url) {
			$posts_video_url = str_replace('youtube.com/embed/','youtube.com/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtube.com/embed/',$posts_video_url);
			$posts_video_url = str_replace('youtube.com/','youtu.be/',$posts_video_url);
			$posts_video_url = str_replace('youtu.be/embed/','youtu.be/',$posts_video_url);
			$image_preview_url = $posts_video_url;
			
			$video_class = '-media';
		}
		
		$posts_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $posts_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $posts_content_excerpt_length).'...';
		}
		
		$post_categories = wp_get_post_categories( $post->ID );
		$cats = array();
		$cat_url_html = '';
		foreach($post_categories as $c){
			$cat = get_category( $c );
			$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			if (!$cat_url_html) {
				$cat_url_html = '<a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			} else {
				$cat_url_html = ', <a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_posts_slider_bycat', 'theme_best_posts_slider_bycat');


//[recent_posts2 title="Recent Posts" count="8" catid=""]
function theme_recent_posts2($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "4",
		"catid" => "",
		"content_length" => "114"
    ), $atts));

	global $wp_query, $post, $paged, $shortname;
	
	if (!$count) $count = 4;
	
	$type = 'post';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'cat' => $catid,
			'category__not_in' => array(59, 45),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc',
			'paged' => $paged
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',			
			'category__not_in' => array(59, 45),
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc',
			'paged' => $paged
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$posts_items_output = '';
	$post_number = 0;
	$clear_second_column_number = 0;
	$news_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							
		
		$post_number++;

		/*$item_categories = get_the_terms( $post->ID, 'posts_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) {
					$category_permalink = get_term_link($cat->name, 'posts_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';				
					$cat_slug = $cat_url_html; 
				} else {
					$category_permalink = get_term_link($cat->name, 'posts_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';				
					$cat_slug .= ', '.$cat_url_html;
				}
			}
		}*/
		
		$post_categories = wp_get_post_categories( $post->ID );
		$cats = array();
		$cat_slug = '';
		foreach($post_categories as $c){
			$cat = get_category( $c );
			$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			if (!$cat_slug) {
				$cat_slug = '<a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			} else {
				$cat_slug = ', <a href="'.get_permalink($cat->term_id).'">'.$cat->name.'</a>';
			}
		}
		
		// get full image from featured image if was not see full image url in posts
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news2_homepage', array('alt' => the_title_attribute('echo=0')));
		
		if (!$content_length) $content_length = 120;
		$news_content_excerpt_length = $content_length;
		
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr(strip_tags($post_description), 0, $news_content_excerpt_length).'...';
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 32) $full_title .= ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		$clear_second_column_number++;
		$style_second_column = '';
		if ($clear_second_column_number % 2 == 1) {
			$style_second_column = 'style="clear:left;"';
		}

		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_news_post_views') == 'true') {
			$views_count_output = '<a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a>';
		}
			
		$news_items_output .= '<article '.$style_second_column.' class="block_topic_post">
                            	<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                <div class="f_pic"><a href="'.get_permalink().'" class="general_pic_hover scale">'.$image_thumb.'</a></div>
                                <p class="text">'.$post_description.'</p>
                                <div class="info">
                                	<div class="date"><p>'.get_the_time('d M, Y').'</p></div>
                                    <div class="r_part">
                                    	<div class="category"><p>'.$cat_slug.'</p></div>
                                        '.$views_count_output.'
                                    </div>
                                </div>
                            </article>';
		$i++;
	endwhile;
	endif;
		
	$recent_news2_pagination = '
					<div class="line_3" style="margin:20px 0px 24px;"></div>
					<div class="block_pager">
					<div class="clearboth"></div>
					</div>
	';



						
	
	$wp_query = null;
	$wp_query = $temp;	

	
	$item_categories = get_the_terms( $post->ID, 'news_entries' );
	if(is_object($item_categories) || is_array($item_categories)) {
		$cat_slug = '';
		$sortable_cats = '';
		$cats_count = count($item_categories);
		$cat_number = 0;
		foreach ($item_categories as $cat) {
			if ($cat->term_id == $catid)
			$category_permalink = get_term_link($cat->name, 'news_entries');
		}
	}

	return '<!-- Recent News 2 --> 
			<h3 style="font-size:16px;"><a href="'.get_permalink( 37 ).'">'.$title.'</a></h3>
            <div class="line_4" style="margin:-4px 0px 18px;"></div>
			<div class="block_topic_news">
				'.$news_items_output.'
			</div>
			'.$recent_news2_pagination.'
			<!-- end Recent News 2 -->';
	
	if ($clear_second_column_number == 3) {
		$clear_second_column_number = 1;
	}						
}
add_shortcode('recent_posts2', 'theme_recent_posts2');


//[recent_posts count="8" catid=""]
function theme_recent_posts($atts, $content=null){
    extract(shortcode_atts(array(
		"count" => "6",
		"catid" => "",
		"onecolumn" => "no" //no, yes - use on homepage for example
    ), $atts));

	global $wp_query, $post, $shortname;
	
	if (!$count) $count = 6;
	
	$type = 'post';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'cat' => $catid,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$news_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
		
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		/*if ($i == 0) $news_items_output .= '
				<!-- Recent News -->
				<div class="block_home_col_1">
		';*/
		
		if ($onecolumn != "yes") 
		if ($i == $ceil_column) $news_items_output .= '
				</div>
				<div class="block_home_col_2">
		';
		
		if ($onecolumn != "yes") {
			if (($i > 0) and ($i != $ceil_column) and ($i != $count))
				$news_items_output .= '<div class="line_3" style="margin:14px 0px 17px;"></div>';
		} else { $news_items_output .= '<div class="line_3" style="margin:14px 0px 17px;"></div>'; }
			
		$full_title = get_the_title();
		if (strlen($full_title) < 38) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		
		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_news_post_views') == 'true') {
			$views_count_output = '
				<div class="icons">
					<ul>
						<li><a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a></li>
					</ul>
				</div>			
			';
		}
		
		$news_items_output .= '
                        	<div class="block_home_post">
								<div class="pic">
									<a href="'.get_permalink().'" class="w_hover">
										'.$image_thumb.'
										<span></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
									<div class="date"><p>'.get_the_time('d F, Y').'</p></div>
									'.$views_count_output.'
								</div>
							</div>
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	global $wpdb;
	$news_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value='template-news-all.php'");
	$news_page_link = get_permalink($news_page_id);
	if ($news_page_id) {
		$all_news_page_output = '
			<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
			<div class="clearboth"></div>
			<div class="line_3" style="margin:13px 0px 35px;"></div>
		';
	} else {
		$all_news_page_output = '
			<div class="clearboth"></div>
			<div style="margin:13px 0px 35px;"></div>
		';
	}
	
	return '
		<!-- Recent News -->
		<div class="block_home_col_1">
			'.$news_items_output.'
		</div>
		<div class="clearboth"></div>
		<div class="line_3" style="margin:14px 0px 13px;"></div>
		'.$all_news_page_output.'
		<!-- end Recent News -->
	';
}
add_shortcode('recent_posts', 'theme_recent_posts');



//[slider_posts_byid slider_name="home_slider1" id_array="" count="3"]
function theme_slider_posts_byid($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"id_array" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'big_slider';
	return selected_slider_posts_output($slider_name, $count, $big_slider, $id_array);
}
add_shortcode("slider_posts_byid", "theme_slider_posts_byid");


//[slider_news_byid slider_name="home_slider1" id_array="" count="3"]
function theme_slider_news_byid($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"id_array" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'big_slider';
	return selected_slider_news_output($slider_name, $count, $big_slider, $id_array);
}
add_shortcode("slider_news_byid", "theme_slider_news_byid");

//[small_slider_posts_byid slider_name="home_slider1" id_array="" count="3"]
function theme_small_slider_posts_byid($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"id_array" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'small_slider';
	return selected_slider_posts_output($slider_name, $count, $big_slider, $id_array);
}
add_shortcode("small_slider_posts_byid", "theme_small_slider_posts_byid");


//[small_slider_news_byid slider_name="home_slider1" id_array="" count="3"]
function theme_small_slider_news_byid($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"id_array" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'small_slider';
	return selected_slider_news_output($slider_name, $count, $big_slider, $id_array);
}
add_shortcode("small_slider_news_byid", "theme_small_slider_news_byid");


//[slider_posts slider_name="home_slider1" count="3"]
function theme_slider_posts($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'big_slider';
	return selected_slider_posts_output($slider_name, $count, $big_slider, '');
}
add_shortcode("slider_posts", "theme_slider_posts");

//[small_slider_posts slider_name="home_slider1" count="3"]
function theme_small_slider_posts($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"count" => "3"
    ), $atts));
	$small_slider = 'small_slider';
	return selected_slider_posts_output($slider_name, $count, $small_slider, '');
}
add_shortcode("small_slider_posts", "theme_small_slider_posts");

//[slider_news slider_name="home_slider1" count="3"]
function theme_slider_news($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'big_slider';
	return selected_slider_news_output($slider_name, $count, $big_slider, '');
}
add_shortcode("slider_news", "theme_slider_news");

//[small_slider_news slider_name="home_slider1" count="3"]
function theme_small_slider_news($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"count" => "3"
    ), $atts));
	$small_slider = 'small_slider';
	return selected_slider_news_output($slider_name, $count, $small_slider, '');
}
add_shortcode("small_slider_news", "theme_small_slider_news");



//[button_standard title="Submit" url="http://www.themeforest.net" type="2"]
function theme_button_standard($atts, $content=null){
	extract(shortcode_atts( array(
		"title" => "",
		"url" => "",
		"type" => "1" //1, 2, 3, 4, 5, 6, 7, 8
	), $atts));
	
	return '
		<a href="'.$url.'" class="general_button standart type_'.$type.'">'.$title.'</a>
	';
}
add_shortcode('button_standard', 'theme_button_standard');

//[button_icons title="Submit" url="http://www.themeforest.net" type="search"]
function theme_button_icons($atts, $content=null){
	extract(shortcode_atts( array(
		"title" => "",
		"url" => "",
		"type" => "approve" //search, approve, remove, calendar, mail, comment, like, edit, favourite, registration, tag, settings, apply, info, play, open
	), $atts));
	
	return '
		<a href="'.$url.'" class="general_button w_icon '.$type.'"><span>'.$title.'</span></a>
	';
}
add_shortcode('button_icons', 'theme_button_icons');



//[recent_news_slider count="9" catid="7"]
function theme_recent_news_slider($atts, $content=null){
    extract(shortcode_atts(array(
		"count" => "9",
		"display_count" => "3",
		"catid" => ""
    ), $atts));

	global $wp_query, $post;
	
	if (!$count) $count = 9;
	if (!$display_count) $display_count = 3;
	
	$display_count = round($count / 3);
	
	$type = 'news';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'tax_query' => array(
				array(
					'taxonomy' => 'news_entries',
					'field' => 'id',
					'terms' => $catid
				 )
			),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$news_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
					$cat_slug = $cat_url_html;
				} else {
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
					$cat_slug .= ', '.$cat_url_html;
				}
			}
		}
		
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news_homepage', array('alt' => the_title_attribute('echo=0')));

		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		if ($i == 0) $news_items_output .= ' <li> ';
			
		$full_title = get_the_title();
		if (strlen($full_title) < 38) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_news_post_views') == 'true') {
			$views_count_output = '                                    
					<div class="icons">
							<ul>
								<li><a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a></li>
							</ul>
						</div>
			';
		}
		
		$news_items_output .= '
                        	<div class="block_home_post">
								<div class="pic">
									<a href="'.get_permalink().'" class="w_hover">
										'.$image_thumb.'
										<span></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
									<div class="date"><p>'.get_the_time('d F, Y').'</p></div>
									'.$views_count_output.'
								</div>
							</div>
		';
		
		$i++;
		if ($i == $display_count) {
			$news_items_output .= ' <div class="line_3" style="margin:13px 0 0;"></div></li> ';
			$i = 0;
		} else {
			$news_items_output .= ' <div class="line_3" style="margin:13px 0 17px;"></div> ';
		}

	endwhile;
	endif;
	
	if ($i > $display_count) {
			$news_items_output .= ' </li> ';
	}
	
	$wp_query = null;
	$wp_query = $temp;	

	global $wpdb;
	$news_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value='template-news-all.php'");
	$news_page_link = get_permalink($news_page_id);
	if ($news_page_id) {
		$all_news_page_output = '
			<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
			<div class="clearboth"></div>
			<div class="line_3" style="margin:13px 0px 35px;"></div>
		';
	} else {
		$all_news_page_output = '
			<div class="clearboth"></div>
			<div style="margin:13px 0px 35px;"></div>
		';
	}
	
	return '
		<div id="home_news_slider" class="home_news_slider flexslider">
			<ul class="slides">	
				'.$news_items_output.'
			</ul>
		</div>
		<script type="text/javascript">
			jQuery(function() {
				jQuery(\'#home_news_slider\').flexslider({
					animation : \'slide\',
					controlNav : true,
					directionNav : true,
					animationLoop : false,
					slideshow : false,
					useCSS : false
				});
			});
		</script>
		<div class="separator" style="height:13px;"></div>
		'.$all_news_page_output.'
		<!-- end Recent News -->
	';
}
add_shortcode('recent_news_slider', 'theme_recent_news_slider');



/*
[pricelist pricing_items="Storage|RAM|SSH|MySQL|Traffic|POP3&SMPT|Speed|Emails Acounts"]

[price_item title="Basic" price="$20" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up" pricing_items="20GB Storage|256MB Ram|uncheckicon|checkicon|500 Gb|checkicon|100Mb/sec|100|"]

[price_item title="Standard" price="$40" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up" column_type="medium" pricing_items="40GB Storage|512MB Ram|uncheckicon|checkicon|1000 Gb|checkicon|100Mb/sec|unlimited|"]

[price_item premium="premium" title="Premium" price="$52" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up"  column_type="special" pricing_items="60GB Storage|1024MB Ram|checkicon|checkicon|1500 Gb|checkicon|100Mb/sec|unlimited|"]

[/pricelist]
*/
function theme_pricelist($atts, $content=null){
    extract(shortcode_atts(array(
		"pricing_items" => ""
    ), $atts));

	$items_chunks = explode("|", $pricing_items);
	$items_output = '';
	for ($i=0;$i<count($items_chunks);$i++) {
		$items_output .= '
				<div class="cell">
					<p>'.$items_chunks[$i].'</p>
				</div>
		';
	}
	
	return '
		<div class="block_pricing_table_1">
			<div class="column category">
				'.$items_output.'
			</div>
			'.do_shortcode($content).'
		</div>
	';
}
add_shortcode('pricelist', 'theme_pricelist');
function theme_price_item($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"price" => "",
		"price_info" => "",
		"pricing_items" => "",
		"button_url" => "#",
		"button_text" => "Sign up",
		"column_type" => "default" //medium, special
    ), $atts));

	$items_chunks = explode("|", $pricing_items);
	$items_output = '';
	for ($i=0;$i<count($items_chunks)-1;$i++) {
		if ($items_chunks[$i] == "checkicon") $items_chunks[$i] = '<span class="icon check">&nbsp;</span>';
		if ($items_chunks[$i] == "uncheckicon") $items_chunks[$i] = '<span class="icon uncheck">&nbsp;</span>';
		$cell_item = ($i % 2);
		$cell_item_outout = ($cell_item == 0) ? '' : ' alt';
		
		$items_output .= '
				<div class="cell'.$cell_item_outout.'">
					<p>'.$items_chunks[$i].'</p>
				</div>
		';
	}
	
	return '
			<div class="column '.$column_type.'">
				<div class="title">
					<p>'.$title.'</p>
				</div>
				<div class="price">
					<p class="num">'.$price.'</p>
					<p class="period">'.$price_info.'</p>
				</div>
				'.$items_output.'
				<div class="cell bottom">
					<p><a href="'.$button_url.'">'.$button_text.'</a></p>
				</div>
			</div>
	';	
}
add_shortcode('price_item', 'theme_price_item');
			   




/*
[pricelist2 pricing_items="Words which look even:|Slightly believable passage:|Needure there anything:|Embarrassing the middle:|Fact that a reader distracted:|Content page when looking:|The point of using is that:|Many var opassages available:"]

[price_item title="Basic Plan" price="$20" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up" pricing_items="20GB Storage|256MB Ram|&mdash;|greenicon|500 Gb|greenicon|100Mb/sec|&mdash;|"]

[price_item title="Standard Plan" price="$40" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up" column_type="medium" pricing_items="40GB Storage|512MB Ram|&mdash;|greenicon|500 Gb|greenicon|100Mb/sec|unlimited|"]

[price_item premium="premium" title="Premium Plan" price="$52" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up"  column_type="special" pricing_items="60GB Storage|1024MB Ram|greenicon|greenicon|500 Gb|greenicon|100Mb/sec|unlimited|"]

[price_item title="Business Plan" price="$80" price_info="per month" button_url="http://www.themeforest.com" button_text="Sign Up" pricing_items="1000 0GB Storage|2048MB Ram|greenicon|greenicon|2000 Gb|greenicon|100Mb/sec|unlimited|"]
[/pricelist2]
*/
function theme_pricelist2($atts, $content=null){
	return '
		<div class="block_pricing_table_2">
				'.do_shortcode($content).'
		</div>
	';
}
add_shortcode('pricelist2', 'theme_pricelist2');




//[image align="left" border="yes" src="/wp-content/themes/weblionmedia/images/services.jpg"]
//[image align="right" border="no" src="/wp-content/themes/weblionmedia/images/services.jpg" title="image description" width="300" height="200"]
function theme_image($atts, $content=null){
	extract(shortcode_atts( array(
		"src" => "",
		"border" => "", //yes|no
		"title" => "",
		"align" => "", //left|right
		"height" => "",
		"width" => ""
	), $atts));
	
	$border_output = '';
	if ($border == "yes") $border_output = 'w_frame';
	
	$width_output = '';
	if ($width) $width_output = ' width="'.$width.'px" ';

	$height_output = '';
	if ($height) $height_output = ' height="'.$height.'px" ';	
	
	return '<a href="#" class="pic '.$border_output.' align'.$align.'"><img src="'.$src.'" '.$height_output.' '.$width_output.' alt="'.$title.'"></a>';
}
add_shortcode('image', 'theme_image');

						
//[audio url="http://weblionmedia.webglogic.com/audio/AirReview-Landmarks-02-ChasingCorporate.mp3"]
function theme_audio($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '#'
	), $atts));
	
	return '
		<div class="block_audio">
			<audio id="player2" src="'.$url.'" type="audio/mp3" controls></audio>
		</div>		
	';
}
add_shortcode("audio", "theme_audio");
						

//[vimeo url="http://player.vimeo.com/video/20245032?title=0&amp;byline=0&amp;portrait=0" width="" height=""]
function theme_vimeo($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '#',
		"width" => '612',
		"height" => '344'
	), $atts));
	
	return '
		<div class="block_video">
			<iframe src="'.$url.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
	';
}
add_shortcode("vimeo", "theme_vimeo");


//[youtube url="http://player.vimeo.com/video/20245032?title=0&amp;byline=0&amp;portrait=0" width="" height=""]
function theme_youtube($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '#',
		"width" => '612',
		"height" => '344'
	), $atts));
	
	return '
		<div class="block_video">
			<iframe src="'.$url.'" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></iframe>
		</div>		
	';
}
add_shortcode("youtube", "theme_youtube");




/*[list type="1"]
<ul>
	<li><a href="#">Words which look even</a></li>
	<li><a href="#">Slight believe passage</a></li>
	<li><a href="#">Needure there anything</a></li>
	<li><a href="#">Embarrassing / the middle</a></li>
	<li><a href="#">Fact that a read distracted</a></li>
</ul>
[/list]*/
function theme_list($atts, $content=null){
    extract(shortcode_atts(array(
		"type" => "1" //1, 2, 3, 4, 5, 6
    ), $atts));

	$content_output = str_replace('<ul>', '<ul class="list_'.($type).'">', $content);
	return do_shortcode($content_output);
}
add_shortcode('list', 'theme_list');




/*[tabs titles="Planning|Development|Support" type="1"]
[tab]Randomised words which don't look even slightly believable. If you are going to use a passage. You need to be sure there isn't anything embarrassing hidden in the middle of text established fact that a reader will be istracted by the readable content of a page when looking at its layout.[/tab]
[tab]Fact reader will be distracted by the <a href="#" class="main_link">readable content</a> of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have evolved over. There are many variations of passages of Lorem Ipsum available, but the majority.[/tab]
[tab]Distracted by the  readable content  of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have  evolved over.  There are many variations of passages of Lorem Ipsum available.[/tab]
[/tabs]
*/
function theme_tabs($atts, $content = null) {
    extract(shortcode_atts(array(
		"titles" => "",
		"type" => "1", //1, 2
		"tabs_name" => ""
    ), $atts));
	
	$title_chunks = explode("|", $titles);
	
	$tabs_output = '
		<div class="block_tabs_type_'.$type.'">
			<div class="tabs">
				<ul>';

	$titles_output = '';
	for ($i=0;$i<count($title_chunks);$i++) {

		if ($i == 0) {
			$class_current =' class="current"';
		} else { $class_current = ''; }

		$titles_output .= '
					<li><a href="#'.($i+1).'"'.$class_current.'>'.$title_chunks[$i].'</a></li><!-- tab link -->';
	}

	$tabs_output .= $titles_output.'
				</ul>
			</div>
			'.do_shortcode($content).'
			<script type="text/javascript">
				jQuery(\'.block_tabs_type_'.$type.' .tabs\').tabs(\'.block_tabs_type_'.$type.' .tab_content\', {
					initialIndex : 0
				});
			</script>
		</div>
		<!-- /tab block -->
	';
	return $tabs_output;
}
add_shortcode("tabs", "theme_tabs");
//TAB info shortcode
function theme_tab($atts, $content = null) {
    extract(shortcode_atts(array(
		"first" => "", //first
		"id" => ""
    ), $atts));
	
	$class_active = ($first == 'first') ? '  display-block' : '';
	
	return '
			<div class="tab_content">
				<!-- tab content goes here -->
				<p>'.do_shortcode($content).'</p>
			</div>
	';
}
add_shortcode("tab", "theme_tab");



/*[infobox type="info" title="Note:"]Insert any text here. Lorem ipsum dolores...[/infobox]
[infobox type="error" title="Note:"]Insert any text here. Lorem ipsum dolores...[/infobox]
[infobox type="warning" title="Note:"]Insert any text here. Lorem ipsum dolores...[/infobox]
[infobox type="success" title="Note:"]Insert any text here. Lorem ipsum dolores...[/infobox]*/
function theme_infobox($atts, $content=null){
    extract(shortcode_atts(array(
		"type" => "info", //error, info, warning, success
		"title" => "Note:"
    ), $atts));
	
	$title_output = ($title) ? '<b>'.$title.'</b>' : '';
	return '
        <div class="general_info_box '.$type.'">
			<a href="#" class="close">Close</a>
			<p>'.$title_output.' '.do_shortcode($content).'</p>
		</div>
		<div class="separator" style="height:10px;"></div>
	';
}
add_shortcode('infobox', 'theme_infobox');



/*
[testimonial name="Steeve Holms" position="Web Developer"]Table content of a page when lookin at its layout. The point of using is that it has a more-or-less normal. Distrib of letters, as opposed. To using 'Content here, content here', making it look like.[/testimonial]
[testimonial name="John D." position="Manager"]There are many variations passages of available, but the majority have suffered alteration in some form, injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of you need to be sure there isn't anything.[/testimonial]
[testimonial name="John Doe" position="Business Man"]Table content of a page when lookin at its layout. The point of using is that it has a more-or-less normal. Distrib of letters, as opposed. To using 'Content here, content here', making it look like.[/testimonial]
*/
function theme_testimonial($atts, $content = null) {
    extract(shortcode_atts(array(
		"siteurl" => "#",
		"name" => "",
		"position" => "",
		"type" => "1" //1, 2, 3
    ), $atts));
	
	$name_output = '';
	if ($name) $name_output = '<div class="author"><p><a href="'.$siteurl.'">'.$name.'</a>. <a href="'.$siteurl.'" class="position">'.$position.'</a></p></div>';
	
	return '
			<div class="block_testimonial_type_1">
				<div class="text">
					<div class="tail"></div>
					<p>'.do_shortcode($content).'</p>
				</div>
				'.$name_output.'
			</div>			
	';
}
add_shortcode("testimonial", "theme_testimonial");





//[dropcap type="1"]text[/dropcap]
//[dropcap type="2"]text[/dropcap]
//[dropcap type="3"]text[/dropcap]
//[dropcap type="4"]text[/dropcap]
//[dropcap type="5"]text[/dropcap]
function theme_dropcap($atts, $content=null){
    extract(shortcode_atts(array(
		"type" => "1" //1, 2, 3, 4, 5
    ), $atts));
	return '<div class="dropcaps_'.$type.'">'.do_shortcode($content).'</div>';
}
add_shortcode('dropcap', 'theme_dropcap');



// Columns Shortcode
//One half 1
/*[one_half]<h3>One half</h3> Randomised words which don\'t look even slightly believable. If you are going to use a passage you need to be sure there isn\'t anything embarrassing hidden in the middle. Established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that.[/one_half]
[one_half last="last"]<h3>[colored]2.[/colored] One half</h3> Randomised words which don\'t look even slightly believable. If you are going to use a passage you need to be sure there isn\'t anything embarrassing hidden in the middle. Established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that.[/one_half]*/
//One half 2
/*[one_half_last]Randomised words which don\'t look even slightly believable. If you are going to use a passage you need to be sure there isn\'t anything embarrassing hidden in the middle. Established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that.[/one_half_last]*/
function theme_column($atts, $content = null, $shortcodename = '') {	
	
	$clear_code = '';
	if ($shortcodename == "one_half_last")  {
		$shortcodename = "one_half last";
		$clear_code = '<div class="clearboth"></div>';
	}
	if ($shortcodename == "one_third_last") {
		$shortcodename = "one_third last";
		$clear_code = '<div class="clearboth"></div>';
	}
	if ($shortcodename == "two_third_last") {
		$shortcodename = "two_third last";
		$clear_code = '<div class="clearboth"></div>';
	}
	if ($shortcodename == "one_fourth_last") {
		$shortcodename = "one_fourth last";
		$clear_code = '<div class="clearboth"></div>';
	}
	if ($shortcodename == "one_fifth_last") {
		$shortcodename = "one_fifth last";
		$clear_code = '<div class="clearboth"></div>';
	}
	if ($shortcodename == "one_sixth_last") {
		$shortcodename = "one_sixth last";
		$clear_code = '<div class="clearboth"></div>';
	}
	
	if ( ((is_page_template('template-homepage.php')) || (is_home()) || (is_front_page())) && ($shortcodename == "one_half") ) {
		$shortcodename = 'block_home_col_1';
	}
	if ( ((is_page_template('template-homepage.php')) || (is_home()) || (is_front_page())) && ($shortcodename == "one_half last") ) {
		$shortcodename = 'block_home_col_2';
	}
	
	return '
		<div class="'.$shortcodename.'">
			'.do_shortcode($content).'
		</div>
		'.$clear_code;
}
add_shortcode('one_half', 'theme_column');
add_shortcode('one_half_last', 'theme_column');
add_shortcode('one_third', 'theme_column');
add_shortcode('one_third_last', 'theme_column');
add_shortcode('two_third', 'theme_column');
add_shortcode('two_third_last', 'theme_column');
add_shortcode('full_width', 'theme_column');
add_shortcode('one_fourth', 'theme_column');
add_shortcode('one_fourth_last', 'theme_column');
add_shortcode('one_fifth', 'theme_column');
add_shortcode('one_fifth_last', 'theme_column');
add_shortcode('one_sixth', 'theme_column');
add_shortcode('one_sixth_last', 'theme_column');
add_shortcode('two_fourth', 'theme_column');
add_shortcode('three_fourth', 'theme_column');



//[table][/table]
function theme_table($atts, $content=null){
    extract(shortcode_atts(array(
		"type" => "1" //1, 2
    ), $atts));
	return do_shortcode(str_replace('<table>','<table cellpadding="0" cellspacing="0" class="table_'.$type.'">',$content));
}
add_shortcode('table', 'theme_table');


//If you are going [cite_text type="1"]to use a passage[/cite_text] you need to be sure.
//If you are going [cite_text type="2"]to use a passage[/cite_text] you need to be sure.
//If you are going [cite_text type="3"]to use a passage[/cite_text] you need to be sure.
function theme_cite_text($atts, $content=null){
    extract(shortcode_atts(array(
		"type" => "1" //1, 2, 3
    ), $atts));
	return '<ins class="the_ins_'.$type.'" cite="cite_text" datetime="datetime_text">'.do_shortcode($content).'</ins>';
}
add_shortcode('cite_text', 'theme_cite_text');
add_shortcode('highlight', 'theme_cite_text');



//[blockquote align="left"]Slightly believable. If you are going to use a passage you need to be sure. There anything embarrassing hidden middle established fact that a reader.[/blockquote]
//[blockquote align="right"]Slightly believable. If you are going to use a passage you need to be sure. There anything embarrassing hidden middle established fact that a reader.[/blockquote]
//[blockquote align="full"]Slightly believable. If you are going to use a passage you need to be sure. There anything embarrassing hidden middle established fact that a reader.[/blockquote]
function theme_blockquote($atts, $content=null){
    extract(shortcode_atts(array(
		"align" => "left" //full, left, right
    ), $atts));
	return '<blockquote class="'.$align.'">'.do_shortcode($content).'</blockquote>';
}
add_shortcode('blockquote', 'theme_blockquote');


/*[accordion]
	[accordion_item first="first" title="Et adipiscing integer, scelerisque pid"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/accordion_item]
	[accordion_item title="A pulvinar ut, parturient enim porta ut sed"]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/accordion_item]
	[accordion_item title="Duis sociis, elit odio dapibus nec"]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/accordion_item]
	[accordion_item title="Nec purus, cras tincidunt rhoncus"]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/accordion_item]
[/accordion]*/
function theme_accordion($atts, $content=null){	
	return '
		<!-- Accordation Style 1 -->
		<div class="block_accordeon_type_1">
			'.do_shortcode($content).'
		</div>
		<script type="text/javascript">
			jQuery(\'.block_accordeon_type_1\').tabs(\'.block_accordeon_type_1 div.accordeon_content\', {
				tabs : \'.button_outer\',
				effect : \'slide\',
				currentClose: false,
				initialIndex : 0
			});
		</script>		
		<!-- / Accordation Style 1 -->
	';
}
add_shortcode('accordion', 'theme_accordion');
function theme_accordion_item($atts, $content=null){
	extract(shortcode_atts( array(
		"title" => "",
		"first" => "" //first
		
	), $atts));
	
	return '
		<div class="button_outer '.$first.'"><div class="button_inner">'.$title.'</div></div><!-- accordeon trigger -->
		<div class="accordeon_content">
			<!-- accordeon content goes here -->
			<p>'.do_shortcode($content).'</p>
		</div>
	';
}
add_shortcode('accordion_item', 'theme_accordion_item');


/*[accordion2]
	[accordion_item2 first="first" title="Et adipiscing integer, scelerisque pid"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta, odio arcu vut natoque dolor ut, enim etiam vut augue. Ac augue amet quis integer ut dictumst? Elit, augue vut egestas! Tristique phasellus cursus egestas a nec a! Sociis et? Augue velit natoque, amet, augue. Vel eu diam, facilisis arcu.[/accordion_item2]
	[accordion_item2 title="A pulvinar ut, parturient enim porta ut sed"]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in. Magna eros hac montes, et velit. Odio aliquam phasellus enim platea amet. Turpis dictumst ultrices, rhoncus aenean pulvinar? Mus sed rhoncus et cras egestas, non etiam a? Montes? Ac aliquam in nec nisi amet eros! Facilisis! Scelerisque in.[/accordion_item2]
	[accordion_item2 title="Duis sociis, elit odio dapibus nec"]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim. Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna.[/accordion_item2]
	[accordion_item2 title="Nec purus, cras tincidunt rhoncus"]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus, vut enim habitasse cum magna. Duis sociis, elit odio dapibus nec, dignissim purus est magna integer eu porta sagittis ut, pid rhoncus facilisis porttitor porta, et, urna parturient mid augue a, in sit arcu augue, sit lectus, natoque montes odio, enim.[/accordion_item2]
[/accordion2]*/
function theme_accordion2($atts, $content=null){	
	return '
		<!-- Accordation Style 2 -->
		<div class="block_accordeon_type_2">
			'.do_shortcode($content).'
		</div>
		<script type="text/javascript">
			jQuery(\'.block_accordeon_type_2\').tabs(\'.block_accordeon_type_2 div.accordeon_content\', {
				tabs : \'.button_outer\',
				effect : \'slide\',
				currentClose: false,
				initialIndex : 0
			});
		</script>		
		<!-- / Accordation Style 2 -->
	';
}
add_shortcode('accordion2', 'theme_accordion2');
function theme_accordion_item2($atts, $content=null){
	extract(shortcode_atts( array(
		"title" => "",
		"first" => "" //first
		
	), $atts));
	
	return '
		<div class="button_outer '.$first.'"><div class="button_inner">'.$title.'</div><div class="arrow"></div></div><!-- accordeon trigger -->
		<div class="accordeon_content">
			<!-- accordeon content goes here -->
			<p>'.do_shortcode($content).'</p>
		</div>
	';
}
add_shortcode('accordion_item2', 'theme_accordion_item2');


//[block_staff title="Staff of the journal" url_1="http://www.themeforest.net" avatar_url_1="/wp-content/themes/business-news/images/ava_default_1.jpg" position_1="Staf Member 1" name_1="Roman Polyarush" url_2="http://www.themeforest.net" avatar_url_2="/wp-content/themes/business-news/images/ava_default_2.jpg" position_2="Staf Member 2" name_2="Roman Polyarush" url_3="http://www.themeforest.net" avatar_url_3="/wp-content/themes/business-news/images/ava_default_3.jpg" position_3="Staf Member 3" name_3="Roman Polyarush" url_4="http://www.themeforest.net" avatar_url_4="/wp-content/themes/business-news/images/ava_default_4.jpg" position_4="Staf Member 4" name_4="Roman Polyarush" url_5="http://www.themeforest.net" avatar_url_5="/wp-content/themes/business-news/images/ava_default_5.jpg" position_5="Staf Member 5" name_5="Roman Polyarush" url_6="http://www.themeforest.net" avatar_url_6="/wp-content/themes/business-news/images/ava_default_6.jpg" position_6="Staf Member 6" name_6="Roman Polyarush"]
function theme_block_staff($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => "",
		"url_1" => "",
		"avatar_url_1" => "",
		"position_1" => "",
		"name_1" => "",
		
		"url_2" => "",
		"avatar_url_2" => "",
		"position_2" => "",
		"name_2" => "",
		
		"url_3" => "",
		"avatar_url_3" => "",
		"position_3" => "",
		"name_3" => "",
		
		"url_4" => "",
		"avatar_url_4" => "",
		"position_4" => "",
		"name_4" => "",
		
		"url_5" => "",
		"avatar_url_5" => "",
		"position_5" => "",
		"name_5" => "",
		
		"url_6" => "",
		"avatar_url_6" => "",
		"position_6" => "",
		"name_6" => "",		
	), $atts));

	return '
		<div class="block_staff">
			<div class="title">
				<p><span class="left">&nbsp;</span>'.$title.'<span class="right">&nbsp;</span></p>
			</div>
			
			<div class="one_third">
				<div class="person">
					<div class="photo"><a href="'.$url_1.'"><img src="'.$avatar_url_1.'" alt="'.$name_1.'"></a></div>
					<div class="text">
						<p class="position">'.$position_1.':</p>
						<p class="name"><a href="'.$url_1.'">'.$name_1.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
				
				<div class="person">
					<div class="photo"><a href="'.$url_4.'"><img src="'.$avatar_url_4.'" alt="'.$name_4.'"></a></div>
					<div class="text">
						<p class="position">'.$position_4.':</p>
						<p class="name"><a href="'.$url_4.'">'.$name_4.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
			</div>
			
			<div class="one_third">
				<div class="person">
					<div class="photo"><a href="'.$url_2.'"><img src="'.$avatar_url_2.'" alt="'.$name_2.'"></a></div>
					<div class="text">
						<p class="position">'.$position_2.':</p>
						<p class="name"><a href="'.$url_2.'">'.$name_2.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
				
				<div class="person">
					<div class="photo"><a href="'.$url_5.'"><img src="'.$avatar_url_5.'" alt="'.$name_5.'"></a></div>
					<div class="text">
						<p class="position">'.$position_5.':</p>
						<p class="name"><a href="'.$url_5.'">'.$name_5.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
			</div>
			
			<div class="one_third last">
				<div class="person">
					<div class="photo"><a href="'.$url_3.'"><img src="'.$avatar_url_3.'" alt="'.$name_3.'"></a></div>
					<div class="text">
						<p class="position">'.$position_3.':</p>
						<p class="name"><a href="'.$url_3.'">'.$name_3.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
				
				<div class="person">
					<div class="photo"><a href="'.$url_6.'"><img src="'.$avatar_url_6.'" alt="'.$name_6.'"></a></div>
					<div class="text">
						<p class="position">'.$position_6.':</p>
						<p class="name"><a href="'.$url_6.'">'.$name_6.'</a></p>
					</div>
					
					<div class="clearboth"></div>
				</div>
			</div>
			
			<div class="clearboth"></div>
		</div>
	';
}
add_shortcode("block_staff", "theme_block_staff");




//[title_center title="General title"]
function theme_title_center($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => ""
	), $atts));

	return '
		<div class="block_staff">
			<div class="title">
				<p><span class="left">&nbsp;</span>'.$title.'<span class="right">&nbsp;</span></p>
			</div>
		</div>
	';
}
add_shortcode("title_center", "theme_title_center");




//[line]
function theme_line($atts, $content = null) {
	extract(shortcode_atts(array(
		"margin_top" => "0",
		"margin_right" => "0",
		"margin_bottom" => "18",
		"margin_left" => "0"
	), $atts));
	return '<div class="line_4" style="margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px"></div>';
}
add_shortcode("line", "theme_line");


//[line2]
function theme_line2($atts, $content = null) {
	extract(shortcode_atts(array(
		"margin_top" => "22",
		"margin_right" => "0",
		"margin_bottom" => "20",
		"margin_left" => "0"
	), $atts));
	return '<div class="line_2" style="margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px"></div>';
}
add_shortcode("line2", "theme_line2");


//[line3]
function theme_line3($atts, $content = null) {
	extract(shortcode_atts(array(
		"margin_top" => "24",
		"margin_right" => "0",
		"margin_bottom" => "19",
		"margin_left" => "0"
	), $atts));
	return '<div class="line_3" style="margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px"></div>';
}
add_shortcode("line3", "theme_line3");





//[general_subtitle]Eestablished fact that a reader will be distracted by the readable content of a page when looking at its layout are many variations of passages have suffered alteration.[/general_subtitle]
function theme_general_subtitle($atts, $content = null) {
	return '<p class="general_subtitle">'.do_shortcode($content).'</p>';
}
add_shortcode("general_subtitle", "theme_general_subtitle");




//[googlemap src="http://maps.google.com/?ie=UTF8&ll=46.774671,-71.220932&spn=0.172821,0.445976&t=h&z=12&output=embed" width="520" height="310"]
//[googlemap src="http://maps.google.com/?ie=UTF8&ll=46.774671,-71.220932&spn=0.172821,0.445976&t=h&z=12" width="100%" height="400"]
function theme_google_map($atts, $content = null) {
	extract(shortcode_atts(array(
		"width" => "100%",
		"height" => "170",
		"src" => ""
	), $atts));

	if (!$width) $width='100%';
	
	return '
		<div class="block_location">
			<div class="map">
				<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&output=embed"></iframe>
			</div>
			<div class="line_2" style="margin:22px 0px 0px;"></div>
		</div>
	';
}
add_shortcode("googlemap", "theme_google_map");


//[organictabs_news userecent="yes" usepopular="yes" usecomment="yes" usetags="yes" countposts="5" countcomments="5"]
function theme_organictabs_news($atts, $content = null) {
	extract(shortcode_atts(array(
		"userecent" => "yes", //yes|no
		"usepopular" => "yes", //yes|no
		"usecomment" => "yes", //yes|no
		"countposts" => "5",
		"countcomments" => "5"
    ), $atts));
	
	if ($userecent == 'yes') $userecent_output = '<li><a href="#4" class="current">'.__('Recent','weblionmedia').'</a></li><!-- tab link -->';
	if ($usepopular == 'yes') $usepopular_output = ' <li><a href="#5">'.__('Popular','weblionmedia').'</a></li><!-- tab link -->';
	if ($usecomment == 'yes') $usecomment_output = '<li><a href="#6">'.__('Comments','weblionmedia').'</a></li><!-- tab link -->';
	
	global $wpdb;
	global $shortname;

	$news_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value='template-news-all.php'");
	$news_page_link = get_permalink($news_page_id);
	
	/*
	if ($usetags == 'yes') {
		$poststags_output = '';	
		$poststags_output .= '<div class="tab_content">';
		$tags = get_tags();
		$tags_count = count($tags);
		for ($i = 0;$i < $tags_count;$i++):
			$poststags_output .= '
								<!-- tab content goes here -->
								<div class="block_home_news_post">
									<p class="title"><a href="'. get_tag_link($tags[$i]->term_id) . '">' . $tags[$i]->name .'</a></p>
								</div>
			';
		endfor;
		$poststags_output .= '
								<div class="separator" style="height:7px;"></div>								
								<a href="#" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
								<div class="clearboth"></div>
							</div>
		';
	}
	*/
	
	if ($usepopular == 'yes') {
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="news"
			GROUP BY ID 
			ORDER BY '.$wpdb->posts.'.comment_count DESC
			LIMIT 0,'.$countposts;
			
		$posts = $wpdb->get_results($sql);

		$postspopular_output = '';
		$postspopular_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';		

		$post_number = 0;
		foreach ($posts as $post) {
		
			$post_number++;
			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($post->ID);
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
			
			$post_title = $post->post_title;
			$post_date_gmt = date("d F, Y",strtotime($post->post_date_gmt));
			
			
			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_news_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($post->ID).'" class="views">'.getPostViews($post->ID).'</a>';
			}
		
			$postspopular_output .= '
                                    <div class="block_home_news_post">
                                    	<div class="info">
                                        	<div class="date"><p>'.$post_date_gmt.'</p></div>
                                            <div class="r_part">
                                            	'.$views_count_output.'
                                                <a href="'.get_permalink($post->ID).'" class="comments">'.$write_comments.'</a>
                                            </div>
                                        </div>
                                        <p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
                                    </div>
                                    
			';
			
		}
		
		if ($news_page_id) {
			$postspopular_output .= '
									<div class="separator" style="height:7px;"></div>								
									<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
									<div class="clearboth"></div>
					</div>	
			';
		}
	}
	

	if ($userecent == 'yes') {	
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="news"
			GROUP BY ID 
			ORDER BY '.$wpdb->posts.'.post_date DESC
			LIMIT 0,'.$countposts;
			
		$posts = $wpdb->get_results($sql);

		$newsposts_output = '';
		$newsposts_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';		

		$post_number = 0;
		foreach ($posts as $post) {
		
			$post_number++;
			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($post->ID);
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
			
			$post_title = $post->post_title;
			$post_date_gmt = date("d F, Y",strtotime($post->post_date_gmt));

			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_news_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($post->ID).'" class="views">'.getPostViews($post->ID).'</a>';
			}
			
			$newsposts_output .= '
								<div class="block_home_news_post">
									<div class="info">
										<div class="date"><p>'.$post_date_gmt.'</p></div>
										<div class="r_part">
											'.$views_count_output.'
											<a href="'.get_permalink($post->ID).'" class="comments">'.$write_comments.'</a>
										</div>
									</div>
									<p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
								</div>
			';
			
		}
		
		if ($news_page_id) {
			$newsposts_output .= '
									<div class="separator" style="height:7px;"></div>								
									<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
									<div class="clearboth"></div>
					</div>	
			';
		}
	}


	if ($usecomment == 'yes') {	

		$sql = "SELECT ".$wpdb->comments.".* FROM ".$wpdb->comments." JOIN ".$wpdb->posts." ON ".$wpdb->posts.".ID = ".$wpdb->comments.".comment_post_ID WHERE comment_approved = '1' AND ".$wpdb->posts.".post_type='news' AND post_status = 'publish' ORDER BY comment_date_gmt DESC LIMIT ".$countcomments;
			
		$comments = $wpdb->get_results($sql);
		$newscomments_output = '';
		$newscomments_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';
		


		$excerptLen = 23;
		
		if ( $comments ) : foreach ( (array) $comments as $comment) :

			$aRecentComment = get_comment($comment->comment_ID);
			$aRecentCommentTxt = $aRecentComment->comment_content;
			if ($excerptLen>0){ 
				$aRecentCommentTxt = trim( substr( $aRecentComment->comment_content, 0, $excerptLen ));
				if(strlen($aRecentComment->comment_content)>$excerptLen){
					$aRecentCommentTxt .= "...";
				}
			}

			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_news_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($comment->comment_post_ID).'" class="views">'.getPostViews($comment->comment_post_ID).'</a>';
			}
			
			$post_date_gmt = get_the_time('d F, Y');
			$post_title = get_the_title($comment->comment_post_ID);
			
			$newscomments_output .= '
						<div class="block_home_news_post">
							<div class="info">
								<div class="date"><p>'.$post_date_gmt.'</p></div>
								<div class="r_part">
									'.$views_count_output.'
									<a href="'.get_permalink($comment->comment_post_ID).'" class="comments">'.$write_comments.'</a>
								</div>
							</div>
							<p class="title"><a href="'.get_permalink($comment->comment_post_ID).'">'.$post_title.'</a></p>
						</div>
			';
			
			endforeach; 
		endif;


		if ($news_page_id) {
			$newscomments_output .= '
									<div class="separator" style="height:7px;"></div>								
									<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
									<div class="clearboth"></div>
					</div>	
			';
		}
	}
	
	return '
		<div class="block_tabs_type_4">
			<div class="tabs">
				<ul>
					'.$userecent_output.'
					'.$usepopular_output.'
					'.$usecomment_output.'
				</ul>
			</div>
			 '.$newsposts_output.'
			 '.$postspopular_output.'
			 '.$newscomments_output.'
			<script type="text/javascript">
				jQuery(\'.block_tabs_type_4 .tabs\').tabs(\'.block_tabs_type_4 .tab_content\', {
					initialIndex : 0
				});
			</script>
		</div>
	';
	
}
add_shortcode('organictabs_news','theme_organictabs_news');



//[organictabs_blog userecent="yes" usepopular="yes" usecomment="yes" countposts="5" countcomments="5"]
function theme_organictabs_blog($atts, $content = null) {
	extract(shortcode_atts(array(
		"userecent" => "yes", //yes|no
		"usepopular" => "yes", //yes|no
		"usecomment" => "yes", //yes|no
		"countposts" => "5",
		"countcomments" => "5"
    ), $atts));
	
	if ($userecent == 'yes') $userecent_output = '<li><a href="#1" class="current">'.__('Recent','weblionmedia').'</a></li><!-- tab link -->';
	if ($usepopular == 'yes') $usepopular_output = ' <li><a href="#2">'.__('Popular','weblionmedia').'</a></li><!-- tab link -->';
	if ($usecomment == 'yes') $usecomment_output = '<li><a href="#3">'.__('Comments','weblionmedia').'</a></li><!-- tab link -->';
	
	global $wpdb;
	global $shortname;
	
	$blog_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value='template-blog-one.php'");
	$blog_page_link = get_permalink($blog_page_id);
	
	/*
	if ($usetags == 'yes') {
		$poststags_output = '';	
		$poststags_output .= '<div class="tab_content">';
		$tags = get_tags();
		$tags_count = count($tags);
		for ($i = 0;$i < $tags_count;$i++):
			$poststags_output .= '
								<!-- tab content goes here -->
								<div class="block_home_news_post">
									<p class="title"><a href="'. get_tag_link($tags[$i]->term_id) . '">' . $tags[$i]->name .'</a></p>
								</div>
			';
		endfor;
		$poststags_output .= '
								<div class="separator" style="height:7px;"></div>								
								<a href="#" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
								<div class="clearboth"></div>
							</div>
		';
	}
	*/
	
	if ($usepopular == 'yes') {
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="post"
			GROUP BY ID 
			ORDER BY '.$wpdb->posts.'.comment_count DESC
			LIMIT 0,'.$countposts;
			
		$posts = $wpdb->get_results($sql);

		$postspopular_output = '';
		$postspopular_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';		

		$post_number = 0;
		foreach ($posts as $post) {
		
			$post_number++;
			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($post->ID);
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
			
			$post_title = $post->post_title;
			$image_url = get_the_post_thumbnail($post->ID, 'recent_blogs_flickr');			
			$post_date_gmt = date("d F, Y",strtotime($post->post_date_gmt));

			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_blog_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($post->ID).'" class="views">'.getPostViews($post->ID).'</a>';
			}
			
			$postspopular_output .= '
                                    <div class="block_home_news_post">
                                    	<div class="info">
                                        	<div class="date"><p>'.$post_date_gmt.'</p></div>
                                            <div class="r_part">
                                            	'.$views_count_output.'
                                                <a href="'.get_permalink($post->ID).'" class="comments">'.$write_comments.'</a>
                                            </div>
                                        </div>
                                        <p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
                                    </div>
                                    
			';
			
		}
		
		if ($blog_page_id) {
			$postspopular_output .= '
								<div class="separator" style="height:7px;"></div>								
								<a href="'.$blog_page_link.'" class="lnk_all_news fl">'.__('All Posts','weblionmedia').'</a>
								<div class="clearboth"></div>
				</div>	
			';
		}
	}
	

	if ($userecent == 'yes') {	
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="post"
			GROUP BY ID 
			ORDER BY '.$wpdb->posts.'.post_date DESC
			LIMIT 0,'.$countposts;
			
		$posts = $wpdb->get_results($sql);

		$blogposts_output = '';
		$blogposts_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';		

		$post_number = 0;
		foreach ($posts as $post) {
		
			$post_number++;
			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($post->ID);
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
			
			$post_title = $post->post_title;
			$image_url = get_the_post_thumbnail($post->ID, 'recent_blogs_flickr');			
			$post_date_gmt = date("d F, Y",strtotime($post->post_date_gmt));

			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_blog_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($post->ID).'" class="views">'.getPostViews($post->ID).'</a>';
			}
			
			$blogposts_output .= '
								<div class="block_home_news_post">
									<div class="info">
										<div class="date"><p>'.$post_date_gmt.'</p></div>
										<div class="r_part">
											'.$views_count_output.'
											<a href="'.get_permalink($post->ID).'" class="comments">'.$write_comments.'</a>
										</div>
									</div>
									<p class="title"><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></p>
								</div>
			';
			
		}

		if ($blog_page_id) {
			$blogposts_output .= '
								<div class="separator" style="height:7px;"></div>								
								<a href="'.$blog_page_link.'" class="lnk_all_news fl">'.__('All Posts','weblionmedia').'</a>
								<div class="clearboth"></div>
				</div>	
			';
		}
	}

	if ($usecomment == 'yes') {	

		$sql_comment = "SELECT ".$wpdb->comments.".* FROM ".$wpdb->comments." JOIN ".$wpdb->posts." ON ".$wpdb->posts.".ID = ".$wpdb->comments.".comment_post_ID WHERE comment_approved = '1' AND ".$wpdb->posts.".post_type='post'  AND post_status = 'publish' ORDER BY comment_date_gmt DESC LIMIT ".$countcomments;
			
		$comments = $wpdb->get_results($sql_comment);
		$blogcomments_output = '';
		$blogcomments_output .= '
			<div class="tab_content">
				<!-- tab content goes here -->
		';

		$excerptLen = 23;
		
		if ( $comments ) : foreach ( (array) $comments as $comment) :

			$aRecentComment = get_comment($comment->comment_ID);
			$aRecentCommentTxt = $aRecentComment->comment_content;
			if ($excerptLen>0){ 
				$aRecentCommentTxt = trim( substr( $aRecentComment->comment_content, 0, $excerptLen ));
				if(strlen($aRecentComment->comment_content)>$excerptLen){
					$aRecentCommentTxt .= "...";
				}
			}
				
			//$image_url = get_the_post_thumbnail($comment_post_ID->ID, 'recent_blogs_flickr');
			$post_date_gmt = get_the_time('d F, Y');
			$post_title = get_the_title($comment->comment_post_ID);

			$views_count_output = '';
			$custom_post_type = get_post_type($post->ID);
			if (get_option($shortname.'_blog_post_views') == 'true') {
				$views_count_output = '<a href="'.get_permalink($comment->comment_post_ID).'" class="views">'.getPostViews($comment->comment_post_ID).'</a>';
			}
			
			$blogcomments_output .= '
						<div class="block_home_news_post">
							<div class="info">
								<div class="date"><p>'.$post_date_gmt.'</p></div>
								<div class="r_part">
									'.$views_count_output.'
									<a href="'.get_permalink($comment->comment_post_ID).'" class="comments">'.$write_comments.'</a>
								</div>
							</div>
							<p class="title"><a href="'.get_permalink($comment->comment_post_ID).'">'.$post_title.'</a></p>
						</div>
			';
			
			endforeach; 
		endif;

		if ($blog_page_id) {
			$blogcomments_output .= '
								<div class="separator" style="height:7px;"></div>								
								<a href="'.$blog_page_link.'" class="lnk_all_news fl">'.__('All Posts','weblionmedia').'</a>
								<div class="clearboth"></div>
				</div>	
			';
		}
	}
	
	return '
		<div class="block_tabs_type_4">
			<div class="tabs">
				<ul>
					'.$userecent_output.'
					'.$usepopular_output.'
					'.$usecomment_output.'
				</ul>
			</div>
			 '.$blogposts_output.'
			 '.$postspopular_output.'
			 '.$blogcomments_output.'
			<script type="text/javascript">
				jQuery(\'.block_tabs_type_4 .tabs\').tabs(\'.block_tabs_type_4 .tab_content\', {
					initialIndex : 0
				});
			</script>
		</div>
	';
	
}
add_shortcode('organictabs_blog','theme_organictabs_blog');



//[best_news_slider_bycomments title="Top Stories (comments)" count="5" sliderid="best_news_slider4"]
function theme_best_news_slider_bycomments($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "10",
		"sliderid" => "" //unique slider id
    ), $atts));

	global $wp_query, $post;


	if (!$count) $count = 10;
	
	$type = 'news';
	$args = array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'orderby' => 'comment_count',
		'order' => 'desc'
	);

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();									
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$cat_slug = $cat->name; 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
				} else {
					$cat_slug = $cat->name;
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html .= ', <a href="'.$category_permalink.'">'.$cat->name.'</a>';
				}
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>							
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_news_slider_bycomments', 'theme_best_news_slider_bycomments');


//[best_news_slider_byid title="Top Stories" id_array="153,140,131,129,74,88,121" sliderid="best_news_slider3"]
function theme_best_news_slider_byid($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"id_array" => "",
		"sliderid" => "" //unique slider id
    ), $atts));

	global $wp_query, $post;
	
	$ids_chunks = explode(",", $id_array);
	for ($i=0;$i<count($ids_chunks);$i++) {
		$id_array_final[] = trim($ids_chunks[$i]);
	}
	
	$count = count($ids_chunks);
	
	$type = 'news';
	$args = array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $count,
		'post__in' => $id_array_final
	);

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$cat_slug = $cat->name; 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
				} else {
					$cat_slug = $cat->name;
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html .= ', <a href="'.$category_permalink.'">'.$cat->name.'</a>';
				}
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>							
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_news_slider_byid', 'theme_best_news_slider_byid');


//[best_news_slider_bycat title="Top Stories" count="" catid="" sliderid="best_news_slider1"]
//[best_news_slider_bycat title="Top Stories" count="6" catid="7" sliderid="best_news_slider2"]
function theme_best_news_slider_bycat($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "10",
		"catid" => "",
		"sliderid" => "" //unique slider id
		
    ), $atts));

	global $wp_query, $post;
	
	if (!$count) $count = 10;
	
	$type = 'news';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'tax_query' => array(
				array(
					'taxonomy' => 'news_entries',
					'field' => 'id',
					'terms' => $catid
				 )
			),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'menu_order',
			'order' => 'asc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'menu_order',
			'order' => 'asc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$slider_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();									
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'best_materials_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$cat_slug = $cat->name; 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
				} else {
					$cat_slug = $cat->name;
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html .= ', <a href="'.$category_permalink.'">'.$cat->name.'</a>';
				}
			}
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 35) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$slider_items_output .= '
                                        <li>
                                            <div class="block_best_material_post">
                                                <div class="f_pic"><a href="'.get_permalink().'" class="w_hover">'.$image_thumb.'<span></span></a></div>
                                                <p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                                <div class="info">
                                                    <div class="date"><p>'.get_the_time('d F, Y').'</p></div>
                                                    <div class="category"><p>'.$cat_url_html.'</p></div>
                                                </div>
                                            </div>
                                        </li>
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	return '
						<!-- Best Materials Slider -->
                        <h3 style="font-size:16px;">'.$title.'</h3>
                        <div class="line_4" style="margin:-4px 0px 18px;"></div>
                        <div class="block_best_materials">
                        	<div class="slider">
                                <div id="'.$sliderid.'" class="flexslider">
                                    <ul class="slides">
										'.$slider_items_output.'
                                    </ul>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
								jQuery(function() {
									jQuery(\'#'.$sliderid.'\').flexslider({
										animation : \'slide\',
										controlNav : false,
										directionNav : true,
										animationLoop : false,
										slideshow : false,
										itemWidth: 213,
										itemMargin: 0,
										minItems: 1,
										maxItems: 3,
										move: 1,
										useCSS : false
									});
								});
							</script>
                        </div>
                        
                        <div class="line_2" style="margin:20px 0px 0px;"></div>
						<!-- end Best Materials Slider -->
	';
}
add_shortcode('best_news_slider_bycat', 'theme_best_news_slider_bycat');

//[recent_news2 title="Business News" count="8" catid="7"]
//[recent_news2 count="6" catid=""]
function theme_recent_news2($atts, $content=null){
    extract(shortcode_atts(array(
		"title" => "",
		"count" => "4",
		"catid" => "",
		"content_length" => "114"
    ), $atts));

	global $wp_query, $post, $paged, $shortname;
	
	if (!$count) $count = 4;
	
	$type = 'news';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'tax_query' => array(
				array(
					'taxonomy' => 'news_entries',
					'field' => 'id',
					'terms' => $catid
				 )
			),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc',
			'paged' => $paged
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc',
			'paged' => $paged
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$news_items_output = '';
	$post_number = 0;
	$clear_second_column_number = 0;
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							
		
		$post_number++;

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) {
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';				
					$cat_slug = $cat_url_html; 
				} else {
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';				
					$cat_slug .= ', '.$cat_url_html;
				}
			}
		}
		
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news2_homepage', array('alt' => the_title_attribute('echo=0')));
				
		if (!$content_length) $content_length = 120;
		$news_content_excerpt_length = $content_length;
		
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		$full_title = get_the_title();
		if (strlen($full_title) < 32) $full_title .= ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

		$clear_second_column_number++;
		$style_second_column = '';
		if ($clear_second_column_number == 3) {
			$style_second_column = 'style="clear:left;"';
		}

		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_news_post_views') == 'true') {
			$views_count_output = '<a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a>';
		}
			
		$news_items_output .= '
							
                            <article '.$style_second_column.' class="block_topic_post">
                            	<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
                                <div class="f_pic"><a href="'.get_permalink().'" class="general_pic_hover scale">'.$image_thumb.'</a></div>
                                <p class="text">'.$post_description.'</p>
                                <div class="info">
                                	<div class="date"><p>'.get_the_time('d M, Y').'</p></div>
                                    <div class="r_part">
                                    	<div class="category"><p>'.$cat_slug.'</p></div>
                                        '.$views_count_output.'
                                    </div>
                                </div>
                            </article>							
		';
		

		
		$i++;

	endwhile;
	endif;
		
	$recent_news2_pagination = '
					<div class="line_3" style="margin:20px 0px 24px;"></div>
					<div class="block_pager">
						'.wp_pagenavi_recent_news().'
					<div class="clearboth"></div>
					</div>
	';



						
	
	$wp_query = null;
	$wp_query = $temp;	

	
	$item_categories = get_the_terms( $post->ID, 'news_entries' );
	if(is_object($item_categories) || is_array($item_categories)) {
		$cat_slug = '';
		$sortable_cats = '';
		$cats_count = count($item_categories);
		$cat_number = 0;
		foreach ($item_categories as $cat) {
			if ($cat->term_id == $catid)
			$category_permalink = get_term_link($cat->name, 'news_entries');
		}
	}

	return '
			<!-- Recent News 2 --> 
			<h3 style="font-size:16px;"><a href="'.$category_permalink.'">'.$title.'</a></h3>
            <div class="line_4" style="margin:-4px 0px 18px;"></div>
			<div class="block_topic_news">
				'.$news_items_output.'
			</div>
			'.$recent_news2_pagination.'
			<div class="line_2" style="margin:24px 0px 35px;"></div>
			<!-- end Recent News 2 --> 
		
	';
	
	if ($clear_second_column_number == 3) {
		$clear_second_column_number = 1;
	}						
}
add_shortcode('recent_news2', 'theme_recent_news2');


//[recent_news count="8" catid="7"]
//[recent_news count="6" catid=""]
function theme_recent_news($atts, $content=null){
    extract(shortcode_atts(array(
		"count" => "6",
		"catid" => "",
		"onecolumn" => "no" //no, yes - use on homepage for example
    ), $atts));

	global $wp_query, $post, $shortname;
	
	if (!$count) $count = 6;
	
	$type = 'news';
	if ($catid) {
		$args = array(
			'post_type' => $type,
			'tax_query' => array(
				array(
					'taxonomy' => 'news_entries',
					'field' => 'id',
					'terms' => $catid
				 )
			),
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	} else {
		$args = array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => $count,
			'sort_column' => 'ID',
			'order' => 'desc'
		);
	}

	$temp = $wp_query;  // assign original query to temp variable for later use   
	$wp_query = null;
	$wp_query = new WP_Query($args); 
	
	$i = 0;
	$ceil_column = ceil($count/2);
	$news_items_output = '';
	if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							

		$item_categories = get_the_terms( $post->ID, 'news_entries' );
		$cat_slug = '';
		if(is_object($item_categories) || is_array($item_categories)) {
			foreach ($item_categories as $cat) {
				if (!$cat_slug) { 
					$category_permalink = get_term_link($cat->name, 'news_entries');
					$cat_url_html = '<a href="'.$category_permalink.'">'.$cat->name.'</a>';				
					$cat_slug = $cat_url_html;
				} else {
					$cat_slug .= ', '.$cat_url_html;
				}
			}
		}
		
		// get full image from featured image if was not see full image url in News
		$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
		$image_preview_url = $get_custom_options[0];
		$image_thumb = get_the_post_thumbnail($post->ID, 'recent_news_homepage', array('alt' => the_title_attribute('echo=0')));
		
		$news_content_excerpt_length = 100;
		if ($post->post_excerpt) { $post_description = $post->post_excerpt; } else { $post_description = $post->post_content; }
		if ( strlen($post_description) > $news_content_excerpt_length ) {
			$post_description = substr($post_description, 0, $news_content_excerpt_length).'...';
		}

		/*if ($i == 0) $news_items_output .= '
				<!-- Recent News -->
				<div class="block_home_col_1">
		';*/
		
		if ($onecolumn != "yes") 
		if ($i == $ceil_column) $news_items_output .= '
				</div>
				<div class="block_home_col_2">
		';
		
		if ($onecolumn != "yes") {
			if (($i > 0) and ($i != $ceil_column) and ($i != $count))
				$news_items_output .= '<div class="line_3" style="margin:14px 0px 17px;"></div>';
		} else { $news_items_output .= '<div class="line_3" style="margin:14px 0px 17px;"></div>'; }
			
		$full_title = get_the_title();
		if (strlen($full_title) < 38) $full_title .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		
		
		$views_count_output = '';
		$custom_post_type = get_post_type($post->ID);
		if (get_option($shortname.'_news_post_views') == 'true') {
			$views_count_output = '
				<div class="icons">
					<ul>
						<li><a href="'.get_permalink().'" class="views">'.getPostViews(get_the_ID()).'</a></li>
					</ul>
				</div>			
			';
		}
		
		$news_items_output .= '
                        	<div class="block_home_post">
								<div class="pic">
									<a href="'.get_permalink().'" class="w_hover">
										'.$image_thumb.'
										<span></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="'.get_permalink().'">'.$full_title.'</a></p>
									<div class="date"><p>'.get_the_time('d F, Y').'</p></div>
									'.$views_count_output.'
								</div>
							</div>
		';
		
		$i++;
		
	endwhile;
	endif;	
	
	$wp_query = null;
	$wp_query = $temp;	

	global $wpdb;
	$news_page_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value='template-news-all.php'");
	$news_page_link = get_permalink($news_page_id);
	if ($news_page_id) {
		$all_news_page_output = '
			<a href="'.$news_page_link.'" class="lnk_all_news fl">'.__('All News','weblionmedia').'</a>
			<div class="clearboth"></div>
			<div class="line_3" style="margin:13px 0px 35px;"></div>
		';
	} else {
		$all_news_page_output = '
			<div class="clearboth"></div>
			<div style="margin:13px 0px 35px;"></div>
		';
	}
	
	return '
		<!-- Recent News -->
		<div class="block_home_col_1">
			'.$news_items_output.'
		</div>
		<div class="clearboth"></div>
		<div class="line_3" style="margin:14px 0px 13px;"></div>
		'.$all_news_page_output.'
		<!-- end Recent News -->
	';
}
add_shortcode('recent_news', 'theme_recent_news');

//[special_topic name="Special topics" url="/contact/" title="Dapibus arcu aliquam odio hac, lacus, natoque in a urna aenean nisi." margin_bottom=""]
function theme_special_topic($atts, $content = null) {
	extract(shortcode_atts(array(
		"name" => "",
		"url" => "",
		"title" => "",
		"margin_bottom" => "17"
	), $atts));
	
	if (!$margin_bottom) $margin_bottom = '17';
	
	return '
		<div class="block_special_topic">
			<div class="type"><p>'.$name.'</p></div>
			<div class="title"><p><a href="'.$url.'">'.$title.'</a></p></div>
		</div>
		<div class="separator" style="height:'.$margin_bottom.'px;"></div>
	';
}
add_shortcode("special_topic", "theme_special_topic");


//[slider slider_name="home_slider1" slider_id="slider2" count="3"]
//[slider slider_name="home_slider2" slider_id="" count="4"]
function theme_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"slider_id" => "",
		"count" => "3"
    ), $atts));
	$big_slider = 'big_slider';
	return selected_slider_output($slider_name, $slider_id, $count, $big_slider);
}
add_shortcode("slider", "theme_slider");


//[small_slider slider_name="home_slider1" slider_id="slider2" count="3"]
//[small_slider slider_name="home_slider2" slider_id="" count="4"]
function theme_small_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		"slider_name" => "",
		"slider_id" => "",
		"count" => "3"
    ), $atts));
	$small_slider = 'small_slider';
	return selected_slider_output($slider_name, $slider_id, $count, $small_slider);
}
add_shortcode("small_slider", "theme_small_slider");


//[gallery postid="" width="" height=""]
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'theme_gallery');
function theme_gallery($atts, $content = null) {
	extract(shortcode_atts(array(
		"postid" => "",
		"width" => "80",
		"height" => "80"
    ), $atts));

	$attachment_args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,       
		'post_status' => null,
		'post_parent' => $postid,
		'orderby' => 'menu_order',
		'order' => 'DESC'
	);

	if ($postid) {
		
		$output_pagination = '
			<style>
				#gallery-1 {
					margin: auto;
				}
				#gallery-1 .gallery-item {
					float: left;
					margin-top: 10px;
					margin-right: 20px;
					text-align: center;
					width: auto;
				}
				#gallery-1 img {
					border: 2px solid #cfcfcf;
				}
				#gallery-1 .gallery-caption {
					margin-left: 0;
				}
			</style>
		';
	
		$output_pagination .= '
			<div id="gallery-1" class="gallery galleryid-500 gallery-columns-3 gallery-size-thumbnail">
		';
		
		$site_url_images = get_site_url();
		$attachments = get_posts($attachment_args);
		if ($attachments) {
			foreach($attachments as $gallery ) {
				$i++;
				$image_attachment_url = wp_get_attachment_url( $gallery->ID);
				$gallery_thumbnail = get_the_post_thumbnail($gallery->ID, 'gallery');
				
				$output_pagination .= '
					<dl class="gallery-item">
					  <dt class="gallery-icon"> <a href="'.$image_attachment_url.'" rel="prettyPhoto[gallery_'.$postid.']" title="'.get_the_title($gallery->ID).'"><img src="'.get_bloginfo('template_url').'/functions/timthumb.php?src='.$image_attachment_url.'&amp;w='.$width.'&amp;h='.$height.'&amp;zc=1" /></a></dt>
					</dl>
				';
			}
		}

		$output_pagination .= '
				<br style="clear: both" />
				<br style="clear: both;" />
			</div>
		';

		return $output_pagination;
	} else return '...You forgot to enter postid in the gallery shortcode...';
}
add_shortcode('gallery','theme_gallery');
?>