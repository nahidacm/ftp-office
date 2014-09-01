<?php get_header();
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
	<div class="main png_bg">
		<div class="inner_main">
		<?php $ds_alpha = stripslashes(get_post_meta($post->ID, "ds_alpha", true)); if (!empty($ds_alpha)) {echo '<div class="container_alpha slogan">'.$ds_alpha.'</div>';} ?>
		<?php if($ds_eth_breadcrumbs_navi == 'Yes'){ ?>
			<div class="container_gamma breadcrumbs">
				<?php ds_breadcrumb_nav(); ?>
			</div>
		<?php } ?>
			<div class="container_omega">
		
		<!-- Content starts -->
		<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>				
					<?php the_content(''); ?>
					<?php endwhile;
					endif; ?>
		<!-- //Content ends// -->
		
			</div>
		</div>
		<!-- /True containers (keep the content inside containers!) -->
    </div>
    <div class="endmain png_bg"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>