<?php
/*
Template Name: Portfolio-Sortable
*/
get_header();
global $options;
foreach ($options as $value) {
	if ( isset( $value['id'] ) ) {
		if (get_option( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_option( $value['id'] );
		}
	}
}
?>
	<!-- Main content alpha -->
	<div class="main">
		<div class="inner_main">
		<?php if($ds_eth_portf_slog2 == 'Yes'){echo '<div class="container_alpha slogan">'.stripslashes($ds_eth_portf_alpha2).'</div>';}
		if($ds_eth_breadcrumbs_navi == 'Yes'){ ?>
			<div class="container_gamma breadcrumbs">
				<?php ds_breadcrumb_nav(); ?>
			</div>
		<?php } ?>
			<div class="container_omega portfolio">
					<?php if (have_posts()) :
					while (have_posts()) : the_post();
					the_content('');
					endwhile;
					endif;
					$omega = 0;
					$args = array( 'post_type' => 'designsentry_portf', 'category__in' => $ds_eth_portf_categories_list2, 'paged' => get_query_var('paged'), 'posts_per_page' => $ds_eth_portf_ppp2);
					$loop = new WP_Query( $args );
					echo '<div id="welcomemsg">'; if($ds_eth_portf_wm2){echo stripslashes($ds_eth_portf_wm2);} echo '<div id="portf2sorter"><a class="superbutton selected" href="#All">'.__('All').'</a>'; if($ds_eth_portf_categories_list2){foreach($ds_eth_portf_categories_list2 as $cat_id){echo '<a class="superbutton" href="#'.get_cat_name($cat_id).'">'.get_cat_name($cat_id).'</a>';}} echo '</div></div><div class="hr"><div class="inner_hr"></div></div><div id="portfolio_wrap">';
					while ( $loop->have_posts() ) : $loop->the_post();
					$ds_eth_portf_grid_size2 = 12/$ds_eth_portf_columns2;
					if($ds_eth_portf_grid_size2 == 12){$picsize_x = 649;}
					else{$picsize_x = ((($ds_eth_portf_grid_size2-1)*77)+33);}
					$picsize_y = round($picsize_x/1.8);
					$ds_thumb = get_post_thumbnail_id(); 
					$ds_image = vt_resize( $ds_thumb,'' , $picsize_x, $picsize_y, true );
					$omega++;
					$grid_divider = 12/$ds_eth_portf_grid_size2;
					$category = get_the_category();
					if($ds_eth_allowg2 == 'Yes'){$allow_gallery = 'rel="prettyPhoto[gallery]" ';}
					?>
						<div class="box gs_<?php echo($ds_eth_portf_grid_size2).' '; foreach($category as $cat){$strcat = str_replace(' ','_',$cat->cat_name); echo ' '.$strcat;} ?>">
							<?php if(get_post_meta($post->ID, "ds_url", true)){echo '<a '.$allow_gallery.'href="'.get_post_meta($post->ID, "ds_url", true).'" class="zoomer">';}else{$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' ); echo '<a '.$allow_gallery.'href="'.$src[0].'" class="zoomer">';} echo '<img src="'.$ds_image['url'].'" alt="" class="border_magic'; if($ds_eth_portf_grid_size2 == 12){echo ' alignleft';} echo '" /></a>'; ?>
							<h3><?php the_title(); ?></h3>
							<?php global $more; $more = FALSE; the_content(__('Read more..','designSentry')); ?>
						</div>
					<?php endwhile; ?>
					</div>
					<div class="hr"><div class="inner_hr"></div></div>
			</div>
		</div>
		<!-- /containers -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>