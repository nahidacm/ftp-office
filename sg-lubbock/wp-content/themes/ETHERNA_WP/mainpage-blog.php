<?php
/*
Template Name: Home Page With Blog
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
			<div class="container_alpha slider">
				<div id="slider" class="nivoSlider">
				<?php
				$args = array( 'post_type' => 'designsentry_slider', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC');
				$loop = new WP_Query( $args );
				$c = 0;
				while ( $loop->have_posts() ) : $loop->the_post();
						$c++;
						$htmlcaption = '';
						if($post->post_content != ""){$htmlcaption = '#htmlcaption' . $c;}
						$ds_thumb = get_post_thumbnail_id(); 
						$ds_image = vt_resize( $ds_thumb,'' , 918, 350, true );
						if(get_the_post_thumbnail($post->ID,'thumbnail')){if(get_post_meta($post->ID, "ds_url", true)){echo '<a href="'.get_post_meta($post->ID, "ds_url", true).'">';} echo '<img src="'.$ds_image['url'].'" alt="" title="'.$htmlcaption.'" />'; if(get_post_meta($post->ID, "ds_url", true)){echo '</a>';}}
				endwhile;
				echo '</div>';
				$c = 0;
				while ( $loop->have_posts() ) : $loop->the_post();
					$c++;
					if($post->post_content != ""){
					echo '<div id="htmlcaption'.$c.'" class="nivo-html-caption">';
						the_content();
					echo '</div>';}
				endwhile;
				wp_reset_query();
				?>
				<div class="loader"></div>
			</div>
			<?php $ds_alpha = stripslashes(get_post_meta($post->ID, "ds_alpha", true)); if (!empty($ds_alpha)) {echo '<div class="container_alpha slogan">'.$ds_alpha.'</div>';} ?>
				<?php if (have_posts()) :
					while (have_posts()) : the_post();
					if($content = $post->post_content){
					echo '<div class="container_gamma">';
					the_content('');
					echo '</div>';
					}
					endwhile;
					endif; ?>
				<div class="container_omega blogpage">
				<?php if($ds_eth_blog_sidebar_left4 != 0){ ?>
				<ul class="gs_<?php echo($ds_eth_blog_sidebar_left4); ?> sidebar_mirror">
					<?php if(function_exists(dynamic_sidebar('home-blog-left'))):
					dynamic_sidebar('home-blog-left');
					endif; ?>
				</ul>
				<?php } ?>
				<div class="gs_<?php echo(12-$ds_eth_blog_sidebar_right4-$ds_eth_blog_sidebar_left4); ?> <?php if($ds_eth_blog_sidebar_right4 == 0){echo 'omega';} ?>">
					<?php 
					$paged = 1;
					if ( get_query_var('paged') ) $paged = get_query_var('paged');
					if ( get_query_var('page') ) $paged = get_query_var('page');
					query_posts(array( 'category__in' => $ds_eth_categories_list4, 'paged' => $paged, 'posts_per_page' => $ds_eth_blog_ppp4));
					if (have_posts()) : ?>
					<?php while (have_posts()) : the_post();
					$picsize_x = ((((12-$ds_eth_blog_sidebar_right4-$ds_eth_blog_sidebar_left4)-1)*77)+33);
					$picsize_y = $picsize_x*2;
					$ds_thumb = get_post_thumbnail_id(); 
					$ds_image = vt_resize( $ds_thumb,'' , $picsize_x, $picsize_y, false );
					?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
							<h2 class="post_header"><a href="<?php the_permalink() ?>" title="See the rest of <?php the_title_attribute(); ?> article."><?php the_title(); ?></a></h2>
							<p class="post_info"><a href="<?php the_permalink() ?>"><?php the_time('j M Y') ?></a> | <a href="<?php the_permalink() ?>"><?php comments_number(); ?></a> | <?php _e('posted by','designSentry'); ?> <?php the_author_link() ?> | <?php _e('in','designSentry'); ?> <?php the_category(', '); ?></p>
							<div class="hr"><div class="inner_hr"></div></div>
							<?php if(get_the_post_thumbnail($post->ID,'thumbnail')){ ?><a href="<?php the_permalink() ?>" class="post_info move_pos"><img src="<?php echo $ds_image['url']; ?>" class="border_magic alignleft" /></a><?php } ?>
							<div class="clearfix"></div>
							<?php global $more; $more = FALSE; ?>
							<?php the_content(__('Read more..','designSentry')); ?>
						</div>
					<?php endwhile; ?>
					<?php endif;
					if (function_exists("pagination")){
					pagination();
					} ?>
				</div>
				<?php if($ds_eth_blog_sidebar_right4 != 0){ ?>
				<ul class="gs_<?php echo($ds_eth_blog_sidebar_right4); ?> sidebar omega">
					<?php if(function_exists(dynamic_sidebar('home-blog-right'))):
					dynamic_sidebar('home-blog-right');
					endif; ?>
				</ul>
				<?php } wp_reset_query(); ?>
			</div>
		</div>
		<!-- /containers -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>