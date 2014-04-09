<?php get_header(); ?>

						<!--div class="line_4" style="margin:0px 0px 22px;"></div-->

						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; // end of the loop. ?>
						
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
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Page Sidebar") ) :
								endif;							
							}
						?>

                    </div>

<?php get_footer(); ?>