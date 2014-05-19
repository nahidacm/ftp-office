<?php 
/*
Template Name: Fullwidth
*/

get_header(); ?>


<div id="article-content">
			
			<?php phi_breadcrumbs();?>
			
			<?php 
			 
			if (have_posts()) : while (have_posts()) : the_post();
			$theexcerpt = get_post_meta($post->ID,'phi_customexcerpt',true);
			if($theexcerpt){
			echo '<h3>'.$theexcerpt.'</h3>';
			}
			
			endwhile; 
			
endif;
the_content();
			wp_pagenavi();
?>
			
</div>
<?php get_footer();?>
