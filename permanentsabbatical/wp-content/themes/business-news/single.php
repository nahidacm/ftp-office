<?php get_header(); ?>
					<?php while ( have_posts() ) : the_post(); 
					
							$this_post_id = $post->ID;
							
							$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single_news', false );
							$main_blog_image_preview = $get_attachment_preview_src[0];
							$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single_news', false );
							$single_image_preview = $get_attachment_preview_src[0];
							
							$custom_post_type = get_post_type($post->ID);
							
							$custom = get_post_custom($post->ID);
							$custom_page_description = $custom["custom_page_description"][0];
							$custom_post_format_url = $custom["custom_post_format"][0];							

							if ($custom_post_type == 'media') {
						?>
						<article class="block_media_item">
						<?php
							}
							
							if ($custom_post_type != 'media') {
						?>
						<article class="block_single_post" id="post-<?php the_ID(); ?>">
						<?php 
							}

							if ( ( function_exists( 'get_post_format' ) && 'video' == get_post_format( $post->ID ) )  ) :
								$video_url = $custom_post_format_url;
								$video_url = str_replace('http://','',$video_url);
								$video_url = str_replace('www.','',$video_url);
								
								$video_pos = strpos($video_url,'youtube.com');
								if ($video_pos === false) {
									$video_url = str_replace('vimeo.com/','',$video_url);
									$video_url = 'http://player.vimeo.com/video/'.$video_url.'?title=0&byline=0&portrait=0&color=7d7d7d';
								} else {
									$video_url = str_replace('youtube.com/','',$video_url);
									$video_url = 'http://youtube.com/embed/'.$video_url;
								}

						?>
                            <div class="block_video">
                                <iframe src="<?php echo $video_url; ?>" width="612" height="343" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            </div>
						<?php endif; // end to check if is video post format ?>						
						
						
						<?php 
							//check if post format is gallery
							if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) )  ) :
						?>  
						
							<?php if ($custom_post_type != 'media') { ?>
                            <div class="f_pic">
                                <div id="post_slider" class="post_slider flexslider">
                                	<ul class="slides">
										<?php
											$images_array = explode("\n", $custom_post_format_url); 
											
											for ($i=0;$i<count($images_array);$i++){
												echo '
													<li><img src="'.trim($images_array[$i]).'" alt="'.get_the_title().'"></li>';
											}
										?>
                            	    </ul>
                                </div>
                                    
                                <script type="text/javascript">
									jQuery(window).load(function() {
										jQuery('#post_slider').flexslider({
											animation : 'fade',
											controlNav : true,
											directionNav : true,
											animationLoop : true,
											slideshow : false
										});
									});
								</script>
                            </div>
							<?php } else {  ?>
                        	<div class="f_item">
                            	<div id="media_item_slider" class="media_item_slider flexslider">
                                	<ul class="slides">
										<?php											
											$images_array = explode("\n", $custom_post_format_url); 
											for ($i=0;$i<count($images_array);$i++){
										?>
											<li>
												<img src="<?php echo get_template_directory_uri(); ?>/functions/timthumb.php?src=<?php echo trim($images_array[$i]); ?>&q=100&w=610&h=292" alt="<?php echo get_the_title(); ?>">
												<div class="caption"><p><b><?php _e('Photo','weblionmedia'); echo ($i+1); ?>.</b> <?php the_title(); ?></p></div>
											</li>
										<?php
											}
										?>									
                                    </ul>
                                </div>
                                
                                <div id="media_item_navigation" class="media_item_navigation flexslider">
                                	<ul class="slides">
										<?php
											$images_array = explode("\n", $custom_post_format_url);
											for ($i=0;$i<count($images_array);$i++){
												echo '
													<li><img src="'.get_template_directory_uri().'/functions/timthumb.php?src='.trim($images_array[$i]).'&q=100&w=89&h=58" alt="'.get_the_title().'"><span class="current"></span></li>';
											}
										?>
                                    </ul>
                                </div>
                                
                                <script type="text/javascript">
									jQuery(function() {
										jQuery('#media_item_navigation').flexslider({
											animation : 'slide',
											controlNav : false,
											directionNav : false,
											animationLoop : false,
											slideshow : false,
											itemWidth : 91,
											itemMargin : 4,
											asNavFor : '#media_item_slider',
											useCSS : false
										});
										jQuery('#media_item_slider').flexslider({
											animation : 'fade',
											controlNav : false,
											animationLoop : false,
											slideshow : false,
											sync : '#media_item_navigation'
										});
									});
								</script>
                            </div>
						<?php
								
							}
							endif; // end to check if is gallery post format
								
							//check if is standard post format, then will be used the featured image
							if ( ( function_exists( 'get_post_format' ) && '' == get_post_format( $post->ID ) )  ) :
								if($single_image_preview) { ?><div class="f_pic"><a href="#"><img width="100%" src="<?php echo $single_image_preview; ?>"></a></div>
								<?php } ?>
						<?php endif; ?>
                        	
                          <p class="title"><a href="#"><?php
								if (get_post_meta($post->ID, 'custom_page_heading',true)) {
									echo get_post_meta($post->ID, 'custom_page_heading',true);
								} else {
									the_title();
								}  ?></a></p>
						  	<?php if ($custom_page_description) { ?>
								<p class="subtitle"><?php echo $custom_page_description; ?></p>
							<?php } ?>
                            
							
                            <div class="info">
                                <div class="date"><p><?php echo get_the_time('d F, Y'); ?></p></div>
								
								<?php if ($custom_post_type != 'media') { ?>
									<div class="author"><p><?php _e('By:','weblionmedia'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php if (!get_the_author_meta('first_name') && !get_the_author_meta('last_name')) { the_author_posts_link(); } else { echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); } ?></a></p></div>
								<?php } ?>
                                    
                            	<div class="r_part">

									<?php
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
									?><div class="category"><p><?php _e('category:','weblionmedia');?> <?php echo $category_name; ?></p></div><?php } ?>
									
                                	<?php if ($custom_post_type == 'post') { ?><div class="category"><p><?php _e('category:','weblionmedia'); ?> <?php the_category(', '); ?></p></div><?php } ?>
                                    
									<?php if ( (get_option($shortname.'_blog_post_views') == 'true') && ($custom_post_type == 'post') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
									<?php if ( (get_option($shortname.'_news_post_views') == 'true') && ($custom_post_type == 'news') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
									<?php if ( (get_option($shortname.'_media_post_views') == 'true') && ($custom_post_type == 'media') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
									
                                    <a href="#" class="comments"><?php comments_number(__('0', 'weblionmedia'),__('1', 'weblionmedia'), __('%', 'weblionmedia')); ?></a>
                                </div>
                            </div>
							
                            
                            <div class="content">

								<?php the_content(); ?>
								<br />
								<?php wp_link_pages('before=<div id="page-links"><span>'.__('Pages:','weblionmedia').'</span>&after=</div>&link_before=<div>&link_after=</div>'); ?>								

                            </div>
                            
							<?php if (($custom_post_type == 'post') && (get_option($shortname."_blog_about_the_author") == 'true')) { ?>
                            <div class="line_3" style="margin:4px 0px 23px;"></div>
                        	
                            <div class="about_author">
								<?php
									$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
									if ($curauth->first_name || $curauth->last_name) $curauth_name = $curauth->first_name.' '.$curauth->last_name;
									if (!$curauth->first_name || !$curauth->last_name) $curauth_name = $curauth->nickname;								
								?>							
                            	<h4><?php _e('About the Author','weblionmedia'); ?></h4>
								<p class="name"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php if (!get_the_author_meta('first_name') && !get_the_author_meta('last_name')) { the_author_posts_link(); } else { echo get_the_author_meta('first_name').' '.get_the_author_meta('last_name'); } ?></a></p>
								
								<?php
									$user_position = get_the_author_meta('user_position', $curauth->ID);
									if ($user_position) {
										echo '<p class="general_subtitle_2">'.$user_position.'</p>';
									}
								?>
								<div class="line_3" style="margin:-6px 0px 17px;"></div>
								<div class="block_author">
									<div class="photo"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $curauth->ID)); ?>"><?php echo str_replace(' photo','',str_replace(' avatar','',get_avatar( get_the_author_meta('email', $curauth->ID) , $size='48' ))); ?></a></div>
									<div class="bio">
									
										<p><?php echo get_the_author_meta('description', $curauth->ID); ?></p>
										<?php 
											$user_url = get_the_author_meta('user_url', $curauth->ID);
											if ($user_url) {
												echo '<p class="www"><a href="'.$user_url.'">'.str_replace('http://','',$user_url).'</a></p>'; 
											}
											$user_email = get_the_author_meta('user_email', $curauth->ID);
											if ($user_email) {
												echo '<p class="email"><a href="mailto:'.$user_email.'" target="_blank">'.$user_email.'</a></p>';
											}
											
											$user_facebook = get_the_author_meta('user_facebook', $curauth->ID);
											$user_twitter = get_the_author_meta('user_twitter', $curauth->ID);
											$user_fr = get_the_author_meta('user_fr', $curauth->ID);
											$user_vimeo = get_the_author_meta('user_vimeo', $curauth->ID);
											$user_rss = get_the_author_meta('user_rss', $curauth->ID);

											$user_facebook_output = '';
											$user_twitter_output = '';
											$user_fr_output = '';
											$user_vimeo_output = '';
											$user_rss_output = '';
											
											if ($user_facebook || $user_twitter || $user_fr || $user_vimeo || $user_rss) {
												if ($user_facebook) { $user_facebook_output = '<li><a href="'.$user_facebook.'" class="fb">Facebook</a></li>'; }
												if ($user_twitter) { $user_twitter_output = '<li><a href="'.$user_twitter.'" class="tw">Twitter</a></li>'; }
												if ($user_fr) { $user_fr_output = '<li><a href="'.$user_fr.'" class="s_fr">Fr</a></li>'; }
												if ($user_vimeo) { $user_vimeo_output = '<li><a href="'.$user_vimeo.'" class="vimeo">Vimeo</a></li>'; }
												if ($user_rss) { $user_rss_output = '<li><a href="'.$user_rss.'" class="rss">RSS</a></li>'; }
												
												echo '
													<div class="line_3" style="margin:10px 0px 17px;"></div>
													<div class="social">
														<ul>
															'.$user_facebook_output.'
															'.$user_twitter_output.'
															'.$user_fr_output.'
															'.$user_vimeo_output.'
															'.$user_rss_output.'
														</ul>
													</div>
												';
											}
										?>
									</div>
								</div>
					

                                <div class="clearboth"></div>
                            </div>
                            
                            <div class="line_3" style="margin:17px 0px 23px;"></div>
							<?php } ?>
                        </article>

						<?php
							if ($custom_post_type != 'media') {
								the_tags('<div class="block_post_tags"><p>'.__('Tags:','weblionmedia').' ',', ','</p></div>');
							}
						?>

						<?php if ( (($custom_post_type == 'post') && (get_option($shortname."_blog_block_post_social") == 'true')) 
									|| (($custom_post_type == 'news') && (get_option($shortname."_news_block_post_social") == 'true'))
									|| (($custom_post_type == 'media') && (get_option($shortname."_media_block_post_social") == 'true')) ) { ?>
                        <div class="block_post_social">
                        	<h4><span><?php _e('B','weblionmedia'); ?></span></h4>
                            
                            <section class="rating">
                            	<p class="title"><span><?php _e('Rating','weblionmedia'); ?></span></p>
                                
                                <ul>
									<?php if ( (get_option($shortname.'_blog_post_views') == 'true') && ($custom_post_type == 'post') ) { ?><li><span><?php echo getPostViews(get_the_ID()); ?></span><?php if (getPostViews(get_the_ID()) > 1) { _e('views','weblionmedia'); } else { _e('view','weblionmedia'); } ?></li><?php } ?>
									<?php if ( (get_option($shortname.'_news_post_views') == 'true') && ($custom_post_type == 'news') ) { ?><li><span><?php echo getPostViews(get_the_ID()); ?></span><?php if (getPostViews(get_the_ID()) > 1) { _e('views','weblionmedia'); } else { _e('view','weblionmedia'); } ?></li><?php } ?>
									<?php if ( (get_option($shortname.'_media_post_views') == 'true') && ($custom_post_type == 'media') ) { ?><li><span><?php echo getPostViews(get_the_ID()); ?></span><?php if (getPostViews(get_the_ID()) > 1) { _e('views','weblionmedia'); } else { _e('view','weblionmedia'); } ?></li><?php } ?>
                                    <li><span><?php comments_number(__('0', 'weblionmedia'),__('1', 'weblionmedia'), __('%', 'weblionmedia')); ?></span><?php comments_number(__('comments', 'weblionmedia'),__('comment', 'weblionmedia'), __('comments', 'weblionmedia')); ?></li>
                                </ul>
                            </section>
                            
                            <section class="subscribe">
                            	<p class="title"><span><?php _e('Subscribe','weblionmedia'); ?></span></p>
                                <?php post_comments_feed_link(__('Subscribe to comments','weblionmedia')); ?>
                            </section>
                            
                            <section class="recommend">
                            	<p class="title"><span><?php _e('recommend to friends','weblionmedia'); ?></span></p>
                                
                                <ul>
                                	<li><a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/button_social_1.png" alt=""></a></li>
                                    <li><a href="https://twitter.com/share?text=<?php echo get_the_title(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/button_social_2.png" alt=""></a></li>
                                    <li><a href="https://plusone.google.com/_/+1/confirm?url=<?php the_permalink(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/button_social_3.png" alt=""></a></li>
                                    <li><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/button_social_4.png" alt=""></a></li>
                                </ul>
                            </section>
                            
                            <div class="clearboth"></div>
                        </div>
                        
                        <div class="line_2" style="margin:22px 0px 29px;"></div>
						<?php } ?>
                        
						<?php if ( (($custom_post_type == 'post') && (get_option($shortname."_blog_recent_posts") == 'true')) || (($custom_post_type == 'news') && (get_option($shortname."_news_recent_posts") == 'true')) ) { ?>
                        <div class="block_related_posts">
                        	<?php if ($custom_post_type == 'post') { ?><h3><?php _e('Recent Posts','weblionmedia'); ?></h3> <?php } ?>
							<?php if ($custom_post_type == 'news') { ?><h3><?php _e('Recent News','weblionmedia'); ?></h3> <?php } ?>
                            
                            <div class="block_main_news">

								<?php									
									if ($custom_post_type == 'post') { query_posts("post_type=post&order=desc&showposts=5"); }
									if ($custom_post_type == 'news') { query_posts("post_type=news&order=desc&showposts=5"); }
									
									$count = 0; 
									if (have_posts()) :  while (have_posts()) : the_post();
										
									  if ($post->ID != $this_post_id) {
										$count++;
										if ($count<=4) {
											$recent_image_preview = '';
											if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
												$get_attachment_preview_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'related_posts', false );
												$recent_image_preview = $get_attachment_preview_src[0];
											}
										
								?> 							
							
                            	<article class="block_news_post">
								
									<?php if ($recent_image_preview) { ?>
										<div class="f_pic"><a href="<?php the_permalink(); ?>" class="general_pic_hover scale_small"><img width="100%" src="<?php echo $recent_image_preview; ?>"></a></div>
									<?php } ?>
									
                                  	<p class="category"><?php the_category(', '); ?></p>
                                    <p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                    <div class="info">
                                        <div class="date"><p><?php echo get_the_time('d F, Y'); ?></p></div>
                                        <?php if ( (get_option($shortname.'_blog_post_views') == 'true') && ($custom_post_type == 'post') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
                                        <?php if ( (get_option($shortname.'_news_post_views') == 'true') && ($custom_post_type == 'news') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
										<?php if ( (get_option($shortname.'_media_post_views') == 'true') && ($custom_post_type == 'media') ) { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
                                        <div class="clearboth"></div>
                                    </div>
								</article>
								
								<?php 	
										}
									}
									endwhile; else :
										echo '<p>'.__('No posts found.','weblionmedia').'</p>';
									endif; 
									wp_reset_query(); //reset query
								?>
                                
                            	<div class="clearboth"></div>
                            </div>
                        </div>
                        
                        <div class="line_2" style="margin:5px 0px 28px;"></div>
						<?php } ?>
                        
						<?php
							if ($custom_post_type == 'post') {
								if (get_option($shortname."_blog_post_comments") == 'true') {
									comments_template('', true);
								}
							}
							if ($custom_post_type == 'news') {
								if (get_option($shortname."_news_post_comments") == 'true') {
									comments_template('', true);
								}
							}
							if ($custom_post_type == 'media') {
								if (get_option($shortname."_media_post_comments") == 'true') {
									comments_template('', true);
								}
							}							
							
						endwhile; // end of the loop. 
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
							} else { ?>
								<?php if ($custom_post_type == 'post') : ?>
									<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) : ?>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ($custom_post_type == 'news') : ?>
									<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("News Sidebar") ) : ?>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ($custom_post_type == 'media') : ?>
									<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Media Sidebar") ) : ?>
									<?php endif; ?>
								<?php endif; ?>
						<?php
							}
						?>

                    </div>

<?php get_footer(); ?>
<?php
	global $wpdb;
	$count = get_post_meta(get_the_ID(), $count_key, true);
	$table = 'wp_postmeta';
	$count = $count['post_views_count'][0];
	//var_dump($count);
	$count++;
	$data = array('meta_value' => $count);
	$where = array('post_id' => get_the_ID(), 'meta_key' => 'post_views_count');		
			
	$posts = $wpdb->update($table, $data, $where);
	wp_query_reset();
?>