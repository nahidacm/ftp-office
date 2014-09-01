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
global $query_string;
$query_args = explode("&", $query_string);
$search_query = array();
foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = $query_split[1];
}
$search = new WP_Query($search_query);
?>
	<!-- Main content alpha -->
	<div class="main">
		<div class="inner_main">
		<div class="container_alpha slogan"><h1><?php _e('There are'); ?> <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; echo '<strong>' . $count . '</strong> '; _e('results:'); wp_reset_query(); ?></h1></div>
		<?php if($ds_eth_breadcrumbs_navi == 'Yes'){ ?>
			<div class="container_gamma breadcrumbs">
				<?php ds_breadcrumb_nav(); ?>
			</div>
		<?php } ?>
			<div class="container_omega blogpage">
				<div class="gs_<?php echo(12-$ds_eth_search_sidebar_right); ?> <?php if($ds_eth_search_sidebar_right == 0){echo 'omega';} ?>">
					<?php query_posts($query_string);
					$wp_query->query_vars['posts_per_page'] = $ds_eth_search_ppp;
					$wp_query->get_posts();
					if (have_posts()) : while (have_posts()) : the_post(); ?>
						<div class="post_holder searchresults">
							<h2 class="post_header"><a href="<?php the_permalink() ?>" title="See the rest of <?php the_title_attribute(); ?> article."><?php the_title(); if ($post->post_type == 'page'){ ?> - <strong><?php _e('Page'); ?></strong><?php } ?></a></h2>
							<p class="post_info"><a href="<?php the_permalink() ?>"><?php the_time('j M Y') ?></a><?php if (!($post->post_type == 'page')){ ?> | <a href="<?php the_permalink() ?>"><?php comments_number(); ?></a> | <?php _e('posted by','designSentry'); ?> <?php the_author_link() ?> | <?php _e('in','designSentry'); ?> <?php the_category(', '); ?><?php } ?></p>
							<div class="hr"><div class="inner_hr"></div></div>
							<div class="clearfix"></div>
						</div>
					<?php endwhile; ?>
					<?php else : ?>
						<h2 class="center">Not Found</h2>
						<p class="center">Sorry, but you are looking for something that isn't here.</p>
					<?php endif;
					if (function_exists("pagination")) {
					pagination();
					} ?>
				</div>
				<?php if($ds_eth_search_sidebar_right != 0){ ?>
				<ul class="gs_<?php echo($ds_eth_search_sidebar_right); ?> sidebar omega">
					<?php if(function_exists(dynamic_sidebar(8))):
					dynamic_sidebar(8);
					endif; ?>
				</ul>
				<?php } ?>
			</div>
		</div>
		<!-- /True containers (keep the content inside containers!) -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>