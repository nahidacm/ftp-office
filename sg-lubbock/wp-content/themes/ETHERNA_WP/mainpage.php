<?php
/*
Template Name: Home Page
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
			<div class="container_omega">
				<?php if (have_posts()) :
					while (have_posts()) : the_post();
					the_content('');
					endwhile;
					else : ?>
						<h2 class="center">Not Found</h2>
						<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php endif; ?>
			</div>
		</div>
		<!-- /containers -->
    </div>
    <div class="endmain"></div>
	<!-- /Main content alpha -->
	
    <!-- //Main Content Sector ends// -->
	<?php get_footer(); ?>