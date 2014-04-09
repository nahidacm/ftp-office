<?php
/*
Template Name: News One
*/
get_header();
?>

						<?php while ( have_posts() ) : the_post(); ?>
							<div class="general_subtitle"><?php the_content(); ?></div>
						<?php endwhile; // end of the loop. ?>

						<div class="line_4" style="margin:0px 0px 18px;"></div>

						<?php					
						
							if ($paged >= 2) {
								echo '<div class="block_topic_news">';
							}
									
							$thePostID = $post->ID;
							$get_custom_options = get_option($shortname.'_news_page_id');
							$cat_inclusion = trim($get_custom_options['news_to_cat_'.$thePostID]);
					
							$count  = get_option($shortname.'_news_items_count_one');
							$count = ( $count != 'All' ) ? $count : '-1';
							
							$orderby = get_option($shortname.'_news_order_by');
							$order   = get_option($shortname.'_news_order');
							
							$args = array( 'numberposts' => '1', 'post_status' => 'publish', 'post_type' => 'news' );
							$last_posts_id = wp_get_recent_posts( $args );
							foreach ($last_posts_id as $last_added_id) {
								$last_post_id = $last_added_id["ID"];
							}

							//if is the first page then display the first Post differently
							if ($paged < 2) {
							
								$item_categories = get_the_terms( $last_post_id, 'news_entries' );
								if(is_object($item_categories) || is_array($item_categories)) {
									$category_name = '';
									$cats_count = count($item_categories);
									$cat_number = 0;
									foreach ($item_categories as $cat) {
										$cat_number++;
										if ($cats_count == 1) {
											$category_permalink = get_term_link($cat->name, 'news_entries');
											$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
										} else {
											if ($cat_number != $cats_count) {
												$category_permalink = get_term_link($cat->name, 'news_entries');
												$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>, '; 
											} else {
												$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>'; 
											}
										}
									}
								}
															
								$get_attachment_preview_src2 = wp_get_attachment_image_src( get_post_thumbnail_id($last_post_id), 'news_page_one', false );
								$thumb_url2 = $get_attachment_preview_src2[0];
							
?>

							<article class="block_topic_post_feature">
								<?php if($thumb_url2) { ?>
									<div class="f_pic"><a href="<?php echo get_permalink($last_post_id); ?>" class="general_pic_hover scale"><img width="100%" src="<?php echo $thumb_url2; ?>"></a></div>
								<?php } ?>
								<div class="content">
									<p class="title"><a href="<?php echo get_permalink($last_post_id); ?>"><?php echo get_the_title($last_post_id); ?></a></p>
									<div class="info">
										<div class="date"><p><?php echo get_the_time('d M, Y', $last_post_id); ?></p></div>
										<div class="r_part">
											<div class="category"><p><?php echo $category_name; ?></p></div>
											<?php if (get_option($shortname.'_news_post_views') == 'true') { ?><a href="#" class="views"><?php echo getPostViews($last_post_id); ?></a><?php } ?>
										</div>
									</div>
									<?php 
										$content_post = get_post($last_post_id);
										echo '<p class="text">'.$content_post->post_excerpt.'</p>';
									?>
								</div>
								<div class="clearboth"></div>
							</article>
							<div class="line_2" style="margin:21px 0px 21px;"></div>
							
							<div class="block_topic_news">

<?php
							}
							//END if is the first page, then display the first Post differently
							
							
							
							$type = 'news';
							if ($cat_inclusion) {
								$args=array(
								'post_type' => $type,
								'tax_query' => array(
												array(
													'taxonomy' => 'news_entries',
													'field' => 'id',
													'terms' => $cat_inclusion
												 )
												),
								'post_status' => 'publish',
								'posts_per_page' => $count,
								'post__not_in' => array($last_post_id),
								'orderby' => $orderby,
								'order' => $order,
								'paged' => $paged
								);
							} else {
								$args=array(
								'post_type' => $type,
								'post_status' => 'publish',
								'posts_per_page' => $count,
								'post__not_in' => array($last_post_id),
								'orderby' => $orderby,
								'order' => $order,
								'paged' => $paged
								);
							}
							$post_number = 0;
							$clear_second_column_number = 0;
							$wp_query = new WP_Query($args);
							if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();				

								$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'news_page_two', false );
								$thumb_url = $get_attachment_preview_src[0];								
								
								$post_number++;								
								$item_categories = get_the_terms( $post->ID, 'news_entries' );
								if(is_object($item_categories) || is_array($item_categories)) {
									$category_name = '';
									$cats_count = count($item_categories);
									$cat_number = 0;
									foreach ($item_categories as $cat) {
										$cat_number++;
										if ($cats_count == 1) {
											$category_permalink = get_term_link($cat->name, 'news_entries');
											$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>';
										} else {
											if ($cat_number != $cats_count) {
												$category_permalink = get_term_link($cat->name, 'news_entries');
												$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>, '; 
											} else {
												$category_name .= '<a href="'.$category_permalink.'">'.$cat->name.'</a>'; 
											}
										}
									}
								}								
								
								$clear_second_column_number++;
								$style_second_column = '';
								if ($clear_second_column_number == 3) {
									$style_second_column = 'style="clear:left;"';
								}
							?>

								<article <?php echo $style_second_column; ?> class="block_topic_post">
									<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
									<?php if($thumb_url) { ?>
										<div class="f_pic"><a href="<?php the_permalink(); ?>" class="general_pic_hover scale"><img width="100%" src="<?php echo $thumb_url; ?>"></a></div>
									<?php } ?>
									<div class="text"><?php the_excerpt(); ?></div>
									<div class="info">
										<div class="date"><p><?php echo get_the_time('d M, Y'); ?></p></div>
										
										<div class="r_part">
											<div class="category"><p><?php echo $category_name; ?></p></div>
											<?php if (get_option($shortname.'_news_post_views') == 'true') { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
										</div>
									</div>
								</article>
								
								<?php
									if ($clear_second_column_number == 3) {
										$clear_second_column_number = 1;
									}								
								?>
							
						<?php endwhile; ?>
						<?php endif; ?>

						</div>

                        <div class="line_2" style="margin:24px 0px 25px;"></div>

                        <div class="block_pager">

							<?php
								if(function_exists('wp_pagenavi')) { echo wp_pagenavi(); }
								wp_reset_postdata();
							?>

                            <div class="clearboth"></div>
                        </div>
                        
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
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("News Sidebar") ) :
								endif;							
							}
						?>

                    </div>

<?php get_footer(); ?>