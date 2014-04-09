<?php get_header(); ?>

						<?php							
							//echo do_shortcode('[special_topic name="Special topics" url="/contact/" title="Dapibus arcu aliquam odio hac, lacus, natoque in a urna aenean nisi." margin_bottom=""]');
							echo do_shortcode('[slider slider_name="home_slider" slider_id="" count="4"]');
							echo do_shortcode('[recent_news count="6" catid="" onecolumn="two"]');
							echo do_shortcode('[recent_news2 title="Main News" count="4" catid="" content_length=""]');
							//echo do_shortcode('[best_news_slider_byid title="Best Materials" id_array="153,140,131,129,74,88,121" sliderid="best_news_slider1"]');
						?>

                    </div>
                    
                    <div class="sidebar">

						<?php 
							wp_reset_query();
							$custom = get_post_custom($post->ID);
							$current_sidebar = $custom["current_sidebar"][0];	
							
							if ($current_sidebar) {
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($current_sidebar) ) :
								endif;
							} else {
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("HomePage Sidebar") ) :
								endif;							
							}
						?>

                    </div>

<?php get_footer(); ?>