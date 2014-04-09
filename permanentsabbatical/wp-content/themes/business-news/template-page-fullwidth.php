<?php
/*
Template Name: Page Full Width
*/
get_header();
?>

						<!--div class="line_4" style="margin:0px 0px 22px;"></div-->

						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; // end of the loop. ?>
						
                    </div>

<?php get_footer(); ?>