<?php
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
		<?php if($ds_eth_portf_slog1 == 'Yes'){echo '<div class="container_alpha slogan">'.stripslashes($ds_eth_portf_alpha1).'</div>';}
		if($ds_eth_breadcrumbs_navi == 'Yes'){ ?>
			<div class="container_gamma breadcrumbs">
				<?php ds_breadcrumb_nav(); ?>
			</div>
		<?php } ?>
			<div class="container_omega portfolio catmyportf">
					<?php
					$omega = 0;
					$paged = get_query_var('paged') ? get_query_var('paged') : 1;
					$args = $query_string.'&post_type=designsentry_portf&posts_per_page='.$ds_eth_portf_ppp1.'&paged='.$paged;
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
					$ds_eth_portf_grid_size1 = 12/$ds_eth_portf_columns1;
					if($ds_eth_portf_grid_size1 == 12){$picsize_x = 649;}
					else{$picsize_x = ((($ds_eth_portf_grid_size1-1)*77)+33);}
					$picsize_y = round($picsize_x/1.8);
					$ds_thumb = get_post_thumbnail_id(); 
					$ds_image = vt_resize( $ds_thumb,'' , $picsize_x, $picsize_y, true );
					$omega++;
					$grid_divider = 12/$ds_eth_portf_grid_size1;
					?>
						<div class="gs_<?php echo($ds_eth_portf_grid_size1); if(($omega % $grid_divider) == 0){echo ' omega';} ?>">
							<?php if(get_post_meta($post->ID, "ds_url", true)){echo '<a href="'.get_post_meta($post->ID, "ds_url", true).'" class="zoomer">';}else{$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' ); echo '<a href="'.$src[0].'" class="zoomer">';} echo '<img src="'.$ds_image['url'].'" alt="" class="border_magic'; if($ds_eth_portf_grid_size1 == 12){echo ' alignleft';} echo '" /></a>'; ?>
							<h3><?php the_title(); ?></h3>
							<?php global $more; $more = FALSE; the_content(__('Read more..','designSentry')); ?>
						</div>
					<?php if(($omega % $grid_divider) == 0){echo '<div class="clearfix"></div>';}
					endwhile; ?>
					<div class="hr"><div class="inner_hr"></div></div>
					<?php
					if (function_exists("pagination")) {
					pagination($loop->max_num_pages);
					} ?>
			</div>
		</div>
		<!-- /containers -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>