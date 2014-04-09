<?php
/*
Template Name: Blog Two
*/
get_header();
?>

						<?php while ( have_posts() ) : the_post(); ?>
							<div class="general_subtitle">
								<?php the_content(); ?>
							</div>
						<?php endwhile; // end of the loop. ?>
                        
                        <div class="line_4" style="margin:0px 0px 0px;"></div>
                        <div class="block_blog_2">

						<?php					
							$count  = get_option($shortname.'_blog_two_posts_count');
							$count = (!$count) ? '-1' : $count;
							$orderby = get_option($shortname.'_blog_order_by');
							$order   = get_option($shortname.'_blog_order');

							$thePostID = $post->ID;
							$get_custom_options = get_option($shortname.'_blog_page_id'); 
							$cat_id_inclusion = trim($get_custom_options['blog_to_cat_'.$thePostID]);
							
							$type = 'post';
							$args=array(
								'post_type' => $type,
								'post_status' => 'publish',
								'posts_per_page' => $count,
								'cat' => $cat_id_inclusion,
								'orderby' => $orderby,
								'order' => $order,
								'paged' => $paged
							);
							
							$clear_second_column_number = 0;
							$wp_query = new WP_Query($args);
							if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();				
								$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'blog_two', false );
								$blog_image_preview = $get_attachment_preview_src[0];

								//get the custom field for post format
								$custom = get_post_custom($post->ID);
								$custom_post_format_url = trim($custom["custom_post_format"][0]);
								
								$clear_second_column_number++;
								$style_second_column = '';
								if ($clear_second_column_number == 3) {
									$style_second_column = 'style="clear:left;"';
								}
								
						?>												
						
                        	<article <?php echo $style_second_column; ?> class="blog_post">
								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<?php if($blog_image_preview) { ?>
										<div class="f_pic"><a href="<?php the_permalink(); ?>" class="general_pic_hover zoom"><img width="100%" src="<?php echo $blog_image_preview; ?>"></a></div>
									<?php } ?>
									<div class="info">
										<div class="category">
											<p><?php _e('Category:','weblionmedia'); ?> <?php the_category(', ') ?></p>
										</div>
										<div class="r_part">
											<?php if (get_option($shortname.'_blog_post_views') == 'true') { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
											<a href="#" class="comments"><?php comments_number(__('0', 'weblionmedia'),__('1', 'weblionmedia'), __('%', 'weblionmedia')); ?></a>
										</div>
									</div>
									<div class="title">
										<div class="tail"></div>
										<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
									</div>
									<div class="author">
										<div class="userpic"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo str_replace("class='avatar","class='rounded-corner-41",get_avatar( get_the_author_meta('email') , $size='36' ));?></a></div>
										
										<div class="text">
											<p class="name"><?php if (!get_the_author_meta('first_name') && !get_the_author_meta('last_name')) { the_author_posts_link(); } else { echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); } ?></p>
											<p class="date"><?php echo get_the_time('d F, Y'); ?></p>
										</div>                                    
										<div class="clearboth"></div>
									</div>
								</div>
                            </article>
							
							<?php
								if ($clear_second_column_number == 3) {
									$clear_second_column_number = 1;
								}								
							?>
							
						<?php endwhile;?>
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
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) :
								endif;							
							}
						?>

                    </div>

<?php get_footer(); ?>