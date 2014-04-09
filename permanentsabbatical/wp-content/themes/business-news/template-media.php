<?php
/*
Template Name: Media
*/
get_header();
?>

						<?php while ( have_posts() ) : the_post(); ?>
							<div class="general_subtitle"><?php the_content(); ?></div>
						<?php endwhile; // end of the loop. ?>

						<div class="line_4" style="margin:0px 0px 22px;"></div>
						
						<?php
						
						// Get the featured media items
						$id_array = get_option($shortname.'_media_featured_list');
							
						if ($id_array) {
							
							$ids_chunks = explode(",", $id_array);
							for ($i=0;$i<count($ids_chunks);$i++) {
								$ids[] = trim($ids_chunks[$i]);
							}
							
							$type = 'media';
							$args=array(
								'post_type' => $type,
								'post_status' => 'publish',
								'post__in' => $ids,
								'orderby' => 'post__in'
							);

							$media_post_number = 0;
							$wp_query = new WP_Query($args);
							if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
							
								$media_post_number++;
								if ($media_post_number == 1) {
									$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slider', false );
									$media_image_preview = $get_attachment_preview_src[0];
									
									$custom = get_post_custom($post->ID);
									$custom_post_format_url = $custom["custom_post_format"][0];
									$images_array = explode("\n", $custom_post_format_url);	
									
									if ( ( function_exists( 'get_post_format' ) && 'video' == get_post_format( $post->ID ) )  ) {
										$count_images = __('Video','weblionmedia');
									} else {
										$count_images = (count($images_array) == 1) ?  count($images_array).' '.__('photo','weblionmedia') : count($images_array).' '.__('photos','weblionmedia');
									}
						?>
						<div class="block_media_f_pic">
							<?php if ($media_image_preview) { echo '<img width="100%" src="'.$media_image_preview.'">'; } ?>
							<div class="caption">
								<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
								<div class="l_part"><p class="date"><?php echo get_the_time('d F, Y'); ?></p></div>
								<div class="r_part"><p class="type"><a href="<?php the_permalink(); ?>"><?php echo $count_images; ?></a></p></div>								
								<div class="clearboth"></div>
							</div>
						</div>
						
						<div class="separator" style="height:19px;"></div>
						
						<div class="block_media_posts">
						<?php
								} else {
									$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'media_featured', false );
									$media_image_preview = $get_attachment_preview_src[0];

									$custom = get_post_custom($post->ID);
									$custom_post_format_url = $custom["custom_post_format"][0];
									$images_array = explode("\n", $custom_post_format_url);
									
									if ( ( function_exists( 'get_post_format' ) && 'video' == get_post_format( $post->ID ) )  ) {
										$count_images = __('Video','weblionmedia');
									} else {
										$count_images = (count($images_array) == 1) ?  count($images_array).' '.__('photo','weblionmedia') : count($images_array).' '.__('photos','weblionmedia');
									}
						?>
                            <article class="block_media_post">
								<?php if($media_image_preview) { ?>
                                <div class="f_pic">
                                    <a href="<?php the_permalink(); ?>"><?php echo '<img width="100%" src="'.$media_image_preview.'">'; ?><span class="hover"></span></a>
                                    <span class="type"><?php echo $count_images; ?></span>
                                </div>
                                <?php } ?>    
                              	<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                <p class="date"><?php echo get_the_time('d F, Y'); ?></p>
                            </article>						
						<?php
								}
								endwhile; endif;
								wp_reset_postdata();
								// End Get the featured media items
								
								echo '<div class="separator" style="height:31px;"></div>';
							}
						?>
                        </div>
                        
                        <div class="block_tabs_type_3">
                            <div class="tabs">
                                <ul>
                                    <li><a href="#1" class="current"><?php _e('Latest','weblionmedia'); ?></a></li><!-- tab link -->
                                    <li><a href="#2"><?php _e('Popular','weblionmedia'); ?></a></li><!-- tab link -->
                                </ul>
                            </div>
                                        
                            <div class="tab_content">
                                <!-- tab content goes here -->
                                <div class="block_media_posts_all">
							
						<?php
							$get_custom_options = get_option($shortname.'_media_page_id');
							$cat_inclusion = trim($get_custom_options['media_to_cat_'.$post->ID]);
					
							$count  = get_option($shortname.'_media_items_count');
							$count = ( $count != 'All' ) ? $count : '-1';
							$orderby = get_option($shortname.'_media_order_by');
							$order   = get_option($shortname.'_media_order');
							
							$type = 'media';
							if ($cat_inclusion) {
								$args=array(
								'post_type' => $type,
								'tax_query' => array(
												array(
													'taxonomy' => 'media_entries',
													'field' => 'id',
													'terms' => $cat_inclusion
												 )
												),
								'post_status' => 'publish',
								'posts_per_page' => $count,
								'orderby' => $orderby,
								'order' => $order,
								'paged' => $paged
								);
							} else {
								$args=array(
								'post_type' => $type,
								'post_status' => 'publish',
								'posts_per_page' => $count,
								'orderby' => $orderby,
								'order' => $order,
								'paged' => $paged
								);
							}

							$clear_second_column_number = 0;
							$wp_query = new WP_Query($args);
							if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();							
								$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'media_recent', false );
								$media_image_preview = $get_attachment_preview_src[0];								
								
									$clear_second_column_number++;
									$style_second_column = '';
									if ($clear_second_column_number == 5) {
										$style_second_column = 'style="clear:left;"';
									}
						?>

                                	<article <?php echo $style_second_column; ?> class="block_media_post_all">
                                    	<div class="f_pic">
                                           <a href="<?php the_permalink(); ?>"><?php echo '<img width="100%" src="'.$media_image_preview.'">'; ?><span class="hover"></span></a>
                                        </div>
                                      	<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                        <p class="date"><?php echo get_the_time('d F, Y'); ?></p>
                                    </article>
								
								<?php
									if ($clear_second_column_number == 5) {
										$clear_second_column_number = 1;
									}								
								?>
							
						<?php endwhile;?>
						<?php endif; ?>

                                </div>
                                
                                <div class="separator" style="height:12px;"></div>
								<a href="#" class="lnk_archive2 fr">&nbsp;</a>						
                                <div class="clearboth"></div>
                                
                                <div class="block_tabs_pager">
                                	<ul>
										<?php
											if(function_exists('wp_pagenavi')) { echo wp_pagenavi(); }
											wp_reset_postdata();
										?>
                                    </ul>
                                </div>
                            </div>
                                        
                            <div class="tab_content">
                                <!-- tab content goes here -->
                                <div class="block_media_posts_all">
									<?php										
										$type = 'media';
										$args=array(
											'post_type' => $type,
											'post_status' => 'publish',
											'posts_per_page' => 8,
											'orderby' => 'comment_count',
											'order' => 'desc'
										);

										$clear_second_column_number = 0;
										$wp_query = new WP_Query($args);
										if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
											$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'media_recent', false );
											$media_image_preview = $get_attachment_preview_src[0];
											
											$clear_second_column_number++;
											$style_second_column = '';
											if ($clear_second_column_number == 5) {
												$style_second_column = 'style="clear:left;"';
											}											
									?>

										<article <?php echo $style_second_column; ?> class="block_media_post_all">
											<div class="f_pic">
											   <a href="<?php the_permalink(); ?>"><?php echo '<img width="100%" src="'.$media_image_preview.'">'; ?><span class="hover"></span></a>
											</div>
											<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
											<p class="date"><?php echo get_the_time('d F, Y'); ?></p>
										</article>								
									
										<?php
											if ($clear_second_column_number == 5) {
												$clear_second_column_number = 1;
											}								
										?>							
									
									<?php endwhile;?>
									<?php endif; ?>								
                                    
                                </div>
								
                                <div class="separator" style="height:12px;"></div>
								<a href="#" class="lnk_archive2 fr">&nbsp;</a>
                                <div class="clearboth"></div>
								
                            </div>
                                        
                            <script type="text/javascript">
                                jQuery('.block_tabs_type_3 .tabs').tabs('.block_tabs_type_3 .tab_content', {
                                    initialIndex : 0
                                });
                            </script>
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
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Media Sidebar") ) :
								endif;							
							}
						?>

                    </div>

<?php get_footer(); ?>