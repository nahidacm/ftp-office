<?php get_header(); ?>

			<?php
				$s = $_GET['s'];
				
				$args=array(
					'post_type' => array('post','news', 'media'),
					's' => $s,
					'post_status' => 'publish',
					'paged' => $paged
				);
				
				$wp_query = new WP_Query($args);
				
				//if (have_posts()) : while (have_posts()) : the_post();
				
			?>
					<?php if ( have_posts() ) : ?>
							
						<div class="block_author_posts">
							<div class="posts">
							<?php 
								while ( have_posts() ) : the_post();
									$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'blog_two', false );
									$archive_image_preview = $get_attachment_preview_src[0];
							?>
								<article class="block_author_post">
									<div class="f_pic">
										<a href="<?php the_permalink(); ?>" class="general_pic_hover scale"><img width="100%" src="<?php echo $archive_image_preview; ?>"></a>
										<span class="date"><?php echo get_the_time('d F, Y'); ?></span>
									</div>
									
									<div class="info">
										<?php
											$custom_post_type = get_post_type($post->ID);
											
											if ($custom_post_type == 'news') {
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
										?><div class="category"><p><?php _e('Category:','weblionmedia');?> <?php echo $category_name; ?></p></div><?php } ?>
										
										<?php if ($custom_post_type == 'post') { ?><div class="category"><p><?php _e('Category:','weblionmedia'); ?> <?php the_category(', '); ?></p></div><?php } ?>									
										<!--div class="category"><p><?php _e('Category:','weblionmedia'); ?> <?php the_category(', ') ?></p></div-->
										
										<div class="r_part">
											<?php if (get_option($shortname.'_blog_post_views') == 'true') { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
											<a href="#" class="comments"><?php comments_number(__('0', 'weblionmedia'),__('1', 'weblionmedia'), __('%', 'weblionmedia')); ?></a>
										</div>
									</div>
									
									<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
								</article>							
							<?php endwhile; // end of the loop. ?>
							</div>
						</div>
						<?php endif; // end of the loop. ?>
                        
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