<?php
/**
 * Template Name: Portfolio 3 columns
 */

get_header(); ?>

<div class="clearfix">
  <div class="grid_24">
  	<div class="holder clearfix">
    	<div class="fleft">
      	<div id="categorybox">
          <ul class="menu">
            <li><a href="#">categories</a>
                <?php
                    //list terms in a given taxonomy (useful as a widget for twentyten)
                    $taxonomy = 'portfolio_category';
                    $tax_terms = get_terms($taxonomy);
                    ?>
                    <ul class="submenu" id="sm_1">
                    <?php
                    foreach ($tax_terms as $tax_term) {
                    echo '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a></li>';
                    }
                ?>
                    </ul>
            </li>
          </ul>            
        </div>
      </div>
			<div class="fright">
				<?php if ( ! dynamic_sidebar( 'Before Content Area' ) ) : ?>
			    <!--Widgetized 'Before Content Area' for the home page-->
			  <?php endif ?>
       </div>
    </div>
  </div>
</div>

<div id="content" class="grid_18">   

<div id="gallery">
  <ul class="portfolio">
  	<?php
			$i=1;
      if ( get_query_var('paged') ) {
              $paged = get_query_var('paged');
      } elseif ( get_query_var('page') ) {
              $paged = get_query_var('page');
      } else {
              $paged = 1;
      }
	  
      query_posts( array( 'post_type' => 'portfolio', 'posts_per_page' => 12, 'paged' => $paged ) );
      if ( have_posts() ) : $count = 0; while ( have_posts() ) : the_post(); $count++;
			if(($i%3) == 0){ $addclass = "nomargin";	}	
      ?>
    <?php 
      
      
    ?>
    
      <li class="<?php echo $addclass; ?>">
      	<header class="f-item-head">
            <div class="fleft"><?php if(function_exists('sl_get_ratings')) { echo sl_get_ratings(get_the_ID()); } ?></div>
            <div class="fright"><?php comments_popup_link('0', '1', '%', 'comments-link', '-'); ?></div>
        </header>
        <div class="folio-desc">
          <div class="fleft">
		  <?php
			$title = the_title('','',FALSE);
			
		  ?>
            <h4><a href="<?php the_permalink(); ?>"><?php if($title!=''){?><?php $title = the_title('','',FALSE); echo substr($title, 0, 16); if(strlen($title)>16){ echo "..."; } ?><?php } else{ ?>Untitled<?php } ?></a></h4>

                <time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time('m.d.Y'); ?></time>
          </div>
			
            <div class="fright">
                <?php if(function_exists('sl_get_fire_trash_tip_icon')) { sl_get_fire_trash_tip_icon(get_the_ID()); } ?>
            </div>
            <div class="clear"></div>
        </div>
		<?php
		if(has_post_thumbnail()){
		?>
	<span class="image-border"><a class="image-wrap" href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'theme1418');?> <?php the_title_attribute(); ?>" ><?php the_post_thumbnail( 'portfolio-post-thumbnail' ); ?></a></span>
	<?php
	}
	else{
	?>
<?php	
$values1 = get_post_custom_values("sl_video_id");
$video_id = $values1[0];
if(isset($video_id)){
?>
					
	<span class="image-border"><a class="image-wrap" href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'theme1418');?> <?php the_title_attribute(); ?>" ><img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=http://view.vzaar.com/<?php echo $video_id; ?>/image&w=196&h=139&q=100"></a></span>	
<?php
}
}
?>	
      
      </li>
    
  
    <?php $i++; $addclass = ""; endwhile; else: ?>
    <div class="no-results">
      <p><strong>There has been an error.</strong></p>
      <p>We apologize for any inconvenience, please <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>">return to the home page</a> or use the search form below.</p>
      <?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
    </div><!--noResults-->
  <?php endif; ?>
  </ul>
  <div class="clear"></div>
</div>





<?php if(function_exists('wp_pagenavi')) : ?>
	<div class="wrapper"><?php wp_pagenavi('','',array(),'home',3); ?></div>
<?php else : ?>
  <?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <nav class="oldernewer">
      <div class="older">
        <?php next_posts_link('&laquo; Older Entries') ?>
      </div><!--.older-->
      <div class="newer">
        <?php previous_posts_link('Newer Entries &raquo;') ?>
      </div><!--.newer-->
    </nav><!--.oldernewer-->
  <?php endif; ?>
<?php endif; ?>
<!-- Page navigation -->


</div><!-- #content -->
<aside class="grid_6">
	<?php if ( ! dynamic_sidebar( 'Home Sidebar' ) ) : ?>
    <!--Widgetized 'Home Sidebar' for the home page-->
  <?php endif ?>
</aside>


<?php get_footer(); ?>