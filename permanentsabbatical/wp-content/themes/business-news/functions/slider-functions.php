<?php
function selected_slider_output($slider_name, $slider_id, $slides_count, $big_small_slider) {
    global $shortname, $wp_query;
	
	if ($slides_count) {
		$slider_items_count = $slides_count;
	} else {
		$slider_items_count = '-1';
	}
	
	$type = 'slider';					
	$args=array(
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $slider_items_count,
		'orderby' => 'menu_order',
		'order' => 'asc',
		'slider_id_name'=> $slider_id
	);	

	$temp = $wp_query;  // assign original query to temp variable for later use 
	$n = 0; // variable $n, if $n = 1 then get 1st slider image
	$wp_query = null;
	$wp_query = new WP_Query($args);
	if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
		$n++;
		
		if ($big_small_slider == 'big_slider') {
			$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'slider', false );
			$slider_image_preview[$n] = $get_attachment_preview_src[0];
		}
		
		if ($big_small_slider == 'small_slider') {
			$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'news_page_one', false );
			$slider_image_preview[$n] = $get_attachment_preview_src[0];
		}
		
		//$get_attachment_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slider', false );
		//$slider_image_thumb[$n] = $get_attachment_thumb_src[0];
		$custom = get_post_custom();
		$slider_title[$n] = $custom["slider_title"][0];
		$slider_description[$n] = $custom["slider_description"][0];
		$slider_website_url[$n] = $custom["slider_website_url"][0];
	endwhile; endif;
	
	$wp_query = null;
	$wp_query = $temp;    
	
	$slider_output = '';	
	
	if ($big_small_slider == 'big_slider') {
		$slider_output = '
							<div class="block_home_slider">
								<div id="'.$slider_name.'" class="flexslider">
									<ul class="slides">
		';	
	
		for ($i=1;$i<=$slider_items_count;$i++) {
			if ($slider_title[$i] || $slider_description[$i]) {
				$slider_output .= '				
										<li>
											<div class="slide">
												<a href="'.$slider_website_url[$i].'"><img src="'.$slider_image_preview[$i].'" alt="'.$slider_title[$i].'"></a>
												<div class="caption">
													<p class="title">'.$slider_title[$i].'</p>
													<p>'.$slider_description[$i].'</p>
												</div>
											</div>
										</li>
				';
			}
		}
		
	}

	if ($big_small_slider == 'small_slider') {
		$slider_output = '
						<div class="block_home_post_feature">
							<div class="f_pic">
								<div id="'.$slider_name.'" class="home_f_pic_slider flexslider">
									<ul class="slides">
		';
		
		for ($i=1;$i<=$slider_items_count;$i++) {
			if ($slider_title[$i] || $slider_description[$i]) {
				$slider_output .= '				
										<li><a href="'.$slider_website_url[$i].'"><img src="'.$slider_image_preview[$i].'" alt="'.$slider_title[$i].'"></a></li>
				';
			}
		}		
	}

	$slider_output .= "
                                </ul>
                            </div>
                            <script type=\"text/javascript\">
								jQuery(function () {
									jQuery('#".$slider_name."').flexslider({
										animation : '".get_option($shortname.'_slider_animation')."',
										direction : '".get_option($shortname.'_slider_direction')."',
										animationLoop : ".get_option($shortname.'_slider_animationloop').",
										slideshow : ".get_option($shortname.'_slider_slideshow').",
										slideshowSpeed : ".get_option($shortname.'_slider_slideshowspeed').",
										animationSpeed : ".get_option($shortname.'_slider_animationspeed').",
										controlNav : ".get_option($shortname.'_slider_controlnav').",
										directionNav : ".get_option($shortname.'_slider_directionNav').",
										initDelay : ".get_option($shortname.'_slider_initdelay').",
										randomize : ".get_option($shortname.'_slider_randomize').",
										pauseOnAction : ".get_option($shortname.'_slider_pauseonaction').",
										pauseOnHover : ".get_option($shortname.'_slider_pauseonhover').",
										useCSS : false
									});
								});
							</script>
                        </div>
	";
	
	
	
	if ($big_small_slider == 'big_slider') {
		$slider_output .= '
						<div class="line_2" style="margin:34px 0px 28px;"></div>
		';
	}
	
	if ($big_small_slider == 'small_slider') {
		$slider_output .= '	</div> ';
	}
	
	return $slider_output;
	
}
?>