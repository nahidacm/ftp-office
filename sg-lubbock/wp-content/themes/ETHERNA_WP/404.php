<?php get_header(); ?>
<?php
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
		<?php if($ds_eth_breadcrumbs_navi == 'Yes'){ ?>
			<div class="container_gamma breadcrumbs">
				<?php ds_breadcrumb_nav(); ?>
			</div>
		<?php } ?>
			<div class="container_omega">
				<div class="hr"></div>
				<h1 class="e404 alignleft"><strong>[404]</strong></h1>
				<h1><?php _e('Page can not be found.','designSentry'); ?></h1>
				<h6 class="e404"><?php _e('We are sorry, but the page you are looking for might have been removed, had its name changed or is temporarily unavailable.','designSentry'); ?></h6>
				<p><a href="<?php bloginfo("url"); ?>" class="superbutton"><?php _e('Get me back to homepage!','designSentry'); ?></a></p>
				<div class="clearfix"></div>
				<div class="hr"></div>
			</div>
		</div>
		<!-- /containers -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>