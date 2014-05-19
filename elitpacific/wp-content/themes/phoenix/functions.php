<?php
// Load theme setup
require_once(TEMPLATEPATH.'/lib/functions/setup.php');
// Load theme options panel
require_once(TEMPLATEPATH.'/lib/admin/includes.php');
//require_once(TEMPLATEPATH.'/admin/controlpanel.php');

// Load meta panels
include(TEMPLATEPATH . '/lib/includes/video_meta.php');
include(TEMPLATEPATH . '/lib/includes/page_meta.php');
include(TEMPLATEPATH . '/lib/includes/post-meta.php');


// Load widgets
require_once(TEMPLATEPATH.'/lib/widgets/phi-latestposts.php');
require_once(TEMPLATEPATH.'/lib/widgets/phi-subpagelist.php');
require_once(TEMPLATEPATH.'/lib/widgets/phi-search.php');
require_once(TEMPLATEPATH.'/lib/widgets/phi-sociables.php');


// Load pager - WP-pagenavi
if ( !function_exists('wp_pagenavi') ) :
require_once(TEMPLATEPATH.'/lib/includes/wp-pagenavi.php');
endif;


// Setup theme

add_action( 'after_setup_theme', 'softshell_setup' );


global $pagenow;
if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	
	
	
	wp_redirect(admin_url("admin.php?page=settings_global.php"));
}
	
//-----------------------------------------------------------
//	PROPERLY REGISTER ALL SCRIPTS AND STYLES
//-----------------------------------------------------------  
//add_action( 'wp_enqueue_scripts', 'scripts_and_css_styles');
function scripts_and_css_styles() {

wp_deregister_script('jquery');
wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2');
wp_enqueue_script('jquery');

wp_register_script('jquery_easing', bloginfo('template_directory').'/lib/scripts/jquery.easing.1.1.3.js', array('jquery'), '1.1.3', false);
wp_enqueue_script( 'jquery_easing' );

wp_register_script('jquery_cycle', bloginfo('template_directory')  .'/lib/scripts/jquery.cycle.all.min.js', array('jquery'), '0.0.0', false);
wp_enqueue_script( 'jquery_cycle' );

wp_register_script('jquery_prettyphoto', bloginfo('template_directory')  .'/lib/scripts/jquery.prettyPhoto.js', array('jquery'), '0.0.0', false);
wp_enqueue_script( 'jquery_prettyphoto' );

wp_register_script('phi_config_js', bloginfo('template_directory')  .'/lib/scripts/config.js', array('jquery'), '1.0.0', false);
wp_enqueue_script( 'phi_config_js' );

wp_register_script('phi_swapstyle_js', bloginfo('template_directory')  .'/lib/scripts/swapstyle.js', array('jquery'), '1.0.0', false);
wp_enqueue_script( 'phi_swapstyle_js' );

wp_register_script('jquery_fancybox', bloginfo('template_directory')  .'/js/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4', false);
wp_enqueue_script( 'jquery_fancybox' );

wp_register_script('jquery_prettyphoto', bloginfo('template_directory')  .'/lib/scripts/jquery.prettyPhoto.js', array('jquery'), '0.0.0', false);
wp_enqueue_script( 'jquery_prettyphoto' );

	if(get_option('phi_dropdown')!=true):
	
wp_register_script('jquery_slidemenu', bloginfo('template_directory')  .'/lib/scripts/jqueryslidemenu.js', array('jquery'), '0.0.0', false);
wp_enqueue_script( 'jquery_slidemenu' );

	endif;


}// scripts and style





// -------------------------------------------------------------------
// REGISTER WIDGETS
// -------------------------------------------------------------------



if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 1',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 2',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 3',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 4',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 5',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 6',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 7',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 8',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 9',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}
if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name'=>'Sidebar 10',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
}

if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name' => 'Blog Widgets',
'before_title' => '<h3>',
'after_title' => '</h3>',
'before_widget' => '<div class="widgetwrap">',
'after_widget' => '</div>',
));
}

if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name' => 'Social Media Widget',
'id' => 'socialmediawidget',
'before_widget' =>'',
'after_widget' => '',
));
}
	

if ( function_exists('register_sidebar') ){
register_sidebar(array(
'name' => 'Footer Widgets',
'before_title' => '<h4>',
'after_title' => '</h4>',
'before_widget' => '<div class="widgetwrap-footer">',
'after_widget' => '</div>',
));
}



add_filter('widget_text', 'do_shortcode'); 



// -----------------------------------------------------------
// SETUP CUSTOM POST TYPES 
// -----------------------------------------------------------

// Portfolio custom post-type
function phi_post_type_portfolio() {
	register_post_type('phiportfolio', 
				array(
				'label' => __('Portfolio'),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false, // It's a custom post type, not built in
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array("slug" => "portfolio"), // Permalinks
				'query_var' => "phiportfolio", // This goes to the WP_Query schema
				'supports' => array('title','author','thumbnail', 'editor' ,'comments'/*,'custom-fields'*/),
				'menu_position' => 5,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				));
	
	
	register_taxonomy("phiportfoliocats", 
				array("phiportfolio"), 
				array("hierarchical" => true, 
						"label" => "Portfolio Categories", 
						"singular_label" => "Category",
						"rewrite" => true,
						"show_ui" => true,
						
						));
}

add_action('init', 'phi_post_type_portfolio');


// Slide custom post-type
function phi_post_type_slide() {
	register_post_type('phislide', 
				array(
				'label' => __('Slideshow'),
				'singular_label' => __('Slide'),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false, // It's a custom post type, not built in
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array("slug" => "slide"), // Permalinks
				'query_var' => "phislide", // This goes to the WP_Query schema
				'supports' => array('title','author','thumbnail', 'editor'/* 'excerpt' ,'custom-fields'*/),
				'menu_position' => 5,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				));

}
add_action('init', 'phi_post_type_slide');

// News custom post-type
function phi_post_type_news() {
	register_post_type('phinews', 
				array(
				'label' => __('News'),
				'singular_label' => __('News'),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false, // It's a custom post type, not built in
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'news',
				'hierarchical' => false,
				'rewrite' => array("slug" => "news"), // Permalinks
				'query_var' => "phinews", // This goes to the WP_Query schema
				'supports' => array('title','author','thumbnail', 'editor'/* 'excerpt' ,'custom-fields'*/),
				'menu_position' => 6,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				));

}
add_action('init', 'phi_post_type_news');



// For inserting articles on home page
function homeArticle($width){
	
	global $post;
	$width = $width;
	
	// Image width
	if($width == 'one-quarter'){$imagewidth = 180;}
	elseif($width == 'one-half'){$imagewidth = 410;}
	
	
	// Image height
	if (get_option('phi_featured_image_height')){$ihFeatured  = get_option('phi_featured_image_height');}
	else{$ihFeatured  = 80;}
	
	
	$customtitle = get_post_meta($post->ID,'phi_customtitle',true);
	$pageurltxt = get_post_meta($post->ID,'phi_customurlname',true);
	$pageurl2 = get_post_meta($post->ID,'phi_customurl2',true);
	$pageurltxt2 = get_post_meta($post->ID,'phi_customurlname2',true);
	$customexcerpt = get_post_meta($post->ID,'phi_customexcerpt',true);
	$customThumbnail = get_post_meta($post->ID,'phi_customimage',true);
	$featuredThumbnail  = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	$thumbnail = $featuredThumbnail[0];
	if($customThumbnail){$thumbnail = $customThumbnail;}
	elseif($featuredThumbnail){$thumbnail = $featuredThumbnail[0];}
	
	
	//else{
	//echo '<h3>'.get_the_title().'</h3>';
	//}
	
	if($thumbnail){
	echo '<div class="imageinset-225"><span><a href="'.get_permalink().'"><img src="'.softshell_image_resize(225,120,$thumbnail).'" alt="" /></a></span></div>';
	}		
	if($customtitle){
	echo '<h2>'.$customtitle.'</h2>';
	}	
		echo '<div style="float:left; margin:16px 16px 0px 0px;">';
		
		$my_query = new WP_Query('category_name=news&showposts=5'); 
			?>
            <h3 style="margin: 0 0 15px;width:200px;text-align:center;">Oahu Quick Search</h3>
            <?php
			//while ($my_query->have_posts()) : $my_query->the_post();?>            
                <!--<table width="100%" border="0">                  
                  <tr>
                    <td rowspan="3"  style="vertical-align:top;">
						<?php the_post_thumbnail(array(100, 100)); ?>&nbsp;                    </td>
                    <td style="text-align:left;" width="100%"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:left; vertical-align:top;"><?php
					$content_post = get_post($my_query->post->ID);
					echo $content = substr($content_post->post_content, 0, 150);?></td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:right;"><a href="<?php the_permalink();?>">More...</a></td>
                  </tr>
                </table>-->
				
			<!-- added by Supergeeks May 22, 2012 -->

<style type="text/css">
#IDX-quickSearchForm { position: relative; height: 400px; width: 200px; } 
#QS-minPriceField { position: absolute; width: 320px; height: 22px; left: 92px; top: 33px; padding-left:4px; } 
#QS-maxPriceField { position: absolute; width: 320px; height: 22px; left: 92px; top: 63px; padding-left:4px; } 
#QS-minSqftField { position: absolute; width: 320px; height: 22px; left: 92px; top: 93px; padding-left:4px; } 
#QS-minRoomsField { position: absolute; width: 320px; height: 22px; left: 92px; top: 123px; padding-left:4px; } 
#QS-minBathsField { position: absolute; width: 320px; height: 22px; left: 92px; top: 153px; padding-left:4px; } 
#QS-labelMaxPrice { text-align: left; position: absolute; width: 70px; height: 22px; left: 12px; top: 66px;  } 
#QS-labelMinPrice { text-align: left; position: absolute; width: 70px; height: 22px; left: 12px; top: 36px;  } 
#QS-labelMinSqft { text-align: left; position: absolute; width: 70px; height: 22px; left: 12px; top: 96px;  } 
#QS-labelMinRooms { text-align: left; position: absolute; width: 70px; height: 22px; left: 12px; top: 126px;  } 
#QS-labelMinBaths { text-align: left; position: absolute; width: 70px; height: 22px; left: 12px; top: 156px;  } 
#QS-labelFormTitle { text-align: left; position: absolute; width: 250px; height: 22px; top: 0px;  } 
#QS-labelCityList { text-align: left; position: absolute; width: 100px; height: 22px; left: 12px; top: 186px;  } 
#QS-buttonSearch { position: absolute; width: 70px; height: 27px; right: 0px; top: 210px; font-weight: bolder; padding: 5px;  } 
#QS-selectCityList { position: absolute; width: 326px; height: 22px; left: 92px; top: 183px; padding-left:3px; } 
#backLink {position:absolute; top:250px;}
</style>
<div id="IDX-quickSearchForm">
<iframe src="http://www.SearchOahuProperties.com/quicksearch/?width=200&utm_source=QUICKSEARCH&utm_campaign=elitepacific.com&utm_medium=referral" frameborder="0" scrolling="no" style="border: none; height: 480px; width:200"></iframe>
</div>

<!-- added by Supergeeks end -->			
                <br />
		<?php 
			//endwhile;

		echo '</div>';
		
		echo '<div style="float:left; margin:16px 0px 0px 0px;width:215px;"><h3 style="margin: 0 0 15px;width:200px;text-align:center;">Maui Quick Search</h3>';
			echo '<div id="IDX-quickSearchForm">'.$customexcerpt.'</div>';
		
			if($pageurltxt){
				//echo '<a href="'.get_permalink().'" class="btn"><span>'.$pageurltxt.'</span></a>';	
                //echo '<a href="http://elitepacific.corefact.com/print/users/login?signup=1" target="_blank" class="btn"><span>Sign Up</span></a>';	 
			}
		echo '</div>';
	if($pageurltxt2){
	echo '<a href="'.$pageurl2.'" class="btn"><span>'.$pageurltxt2.'</span></a>';	
	}
	
	
	}


// For inserting featrured articles on home page
function featuredArticles($pageposts){
	
global $post;

if ($pageposts): 
$counter = 0;
echo '<div class="featured">';
foreach ($pageposts as $post):
	
// Image height
if (get_option('phi_featured_image_height')){$ihFeatured  = get_option('phi_featured_image_height');}
else{$ihFeatured  = 80;}
	
	
$counter ++;
setup_postdata($post);
 
$excerpt = get_post_meta($post->ID,'phi_customexcerpt',true);
$customtitle = get_post_meta($post->ID,'phi_customtitle',true);
$pageurltxt = get_post_meta($post->ID,'phi_customurlname',true);
$pageurl2 = get_post_meta($post->ID,'phi_customurl2',true);
$pageurltxt2 = get_post_meta($post->ID,'phi_customurlname2',true);


// Post images
$customFullsize  = get_post_meta($post->ID,'phi_customimage',true);
$featuredThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), '');


// Conditionals to determine image sources for fullsize images in lightbox and thumbnails
	

// Thumbnail
if($featuredThumbnail){$thumbnailImage = $featuredThumbnail[0];} // If featured image is entered - use this as thumbnail image
elseif($customFullsize){$thumbnailImage = $customFullsize;}
else{$thumbnailImage = false;}

if(($counter % 3) == 0){$position = 'last';}
else{$position = '';}

echo '<div class="one-third-featured '.$position.'">';



if ($thumbnailImage){
echo '<div class="imageinset-300"><span><a href="'.get_permalink().'"><img src="'.softshell_image_resize(300,$ihFeatured,$thumbnailImage).'" alt="" /></a></span></div>';
}

if($customtitle){
echo '<h3><a href="'.get_permalink().'">'.$customtitle.'</a></h3>';
}
else{
echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
}

										
echo '<p>'.$excerpt.'</p>';
if($pageurltxt){
echo '<a href="'.get_permalink().'" class="btn"><span>'.$pageurltxt.'</span></a>';	
} 
									
echo '</div>';
 if(($counter % 3) == 0){echo '<br class="break"/>';}
		
endforeach; 
echo '</div>';
endif;
}





function insertPostImage($placement,$type){
global $post; // Important

$imagePlacement = $placement;
$pagetype = $type;


if($pagetype == 'blog' && $imagePlacement == 'content') {$imageheight = get_option('phi_blog_image_height');}
elseif($pagetype == 'post' && $imagePlacement == 'content') {$imageheight = get_option('phi_post_image_height');}
elseif($pagetype == 'post' && $imagePlacement == 'top') {$imageheight = get_option('phi_post_large_image_height');}



	$customFullsize  = get_post_meta($post->ID,'phi_custom_image',true);
	$featuredFullsize  = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
	$featuredImage = $featuredFullsize[0];


		if($imagePlacement == 'content'){

								
				if($customFullsize){
				
				echo '<div class="imageinset-630"><span><a href="'.$customFullsize.'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize(630,$imageheight,$customFullsize).'" alt=""/></a></span></div>'; 
				
				}
				elseif($featuredFullsize){
				echo '<div class="imageinset-630"><span><a href="'.$featuredImage.'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize(630,$imageheight,$featuredImage).'" alt=""/></a></span></div>'; 
				}
			}
		
		
			if($imagePlacement == 'top'){
		
			
								
				if($customFullsize){
				echo '<div class="imageinset-659"><span><a href="'.$customFullsize.'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize(659,$imageheight,$customFullsize).'"></a></span></div>';
				}
				elseif($featuredFullsize){
				echo '<div class="imageinset-659"><span><a href="'.$featuredImage.'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize(659,$imageheight,$featuredImage).'"></a></span></div>';
				}
			}
		
	
}





function getImage($num) {
global $more;
$more = 1;
$link = get_permalink();
$content = get_the_content();
$count = substr_count($content, '<img');
$start = 0;
for($i=1;$i<=$count;$i++) {
$imgBeg = strpos($content, '<img', $start);
$post = substr($content, $imgBeg);
$imgEnd = strpos($post, '>');
$postOutput = substr($post, 0, $imgEnd+1);
$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);;
$image[$i] = $postOutput;
$start=$imgEnd+1;
}
if(stristr($image[$num],'<img')) { echo '<a href="'.$link.'">'.$image[$num]."</a>"; }
$more = 0;
}

// get all of the images attached to the current post
function phi_get_images($size = 'thumbnail') {
	global $post;

	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

	$results = array();

	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
			$results[] = wp_get_attachment_image($photo->ID, $size);
			
			
			
		}
	}

	return $results;
	
}

// get all of the images attached to the current post
function phi_get_images_url($size = 'large') {
	global $post;

	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

	$results = array();

	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
		
			$results[] = wp_get_attachment_url($photo->ID, $size);
			
			
			
		}
	}
	
	return $results;
	
}

// get all of the images attached to the current post
function phi_get_images_title() {
	global $post;

	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

	$results = array();

	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
				$results[] = apply_filters('the_title', $photo->post_title);
					
		}
	}

	return $results;
	
}


	
	

// Define Folder Constants
define('SOFTSHELL_SCRIPTS_FOLDER', get_bloginfo('template_url') . '/lib/scripts');

function softshell_image_resize($width,$height,$img_url) {
	global $blog_id;
	

	// Get image-quality settings from theme options
	if (get_option('phi_image_quality')){
	$imageQuality 		= get_option('phi_image_quality');
	}
	else{
	$imageQuality = 70;
	}
	
	
	$image['url'] = $img_url;
	$image_path = explode($_SERVER['SERVER_NAME'], $image['url']);
	$image_path = $_SERVER['DOCUMENT_ROOT'] . $image_path[1];
	$image_info = @getimagesize($image_path);

	// If we cannot get the image locally, try for an external URL
	if (!$image_info)
		$image_info = @getimagesize($image['url']);

	$image['width'] = $image_info[0];
	$image['height'] = $image_info[1];
	if($img_url != "" && ($image['width'] != $width || $image['height'] != $height || !isset($image['width']))){
		
		//If WP MU
		if ( (defined('WP_ALLOW_MULTISITE')) && (WP_ALLOW_MULTISITE == true) ) {
			$the_image_src = $img_url;
			if (isset($blog_id) && $blog_id > 0) {
				$image_parts = explode('/files/', $the_image_src);
				if (isset($image_parts[1])) {
					$the_image_src = '/blogs.dir/' . $blog_id . '/files/' . $image_parts[1];
					
				}
			}
		
			$img_url = SOFTSHELL_SCRIPTS_FOLDER."/timthumb.php?src=$the_image_src&amp;w=$width&amp;h=$height&amp;zc=1&amp;q=$imageQuality";
		}else{
			$img_url = SOFTSHELL_SCRIPTS_FOLDER."/timthumb.php?src=$img_url&amp;w=$width&amp;h=$height&amp;zc=1&amp;q=$imageQuality";	
		}
	}
	
	return $img_url;
}



// INSERT PORTFOLIO

function insertPortfolio($columns, $category, $postcount){
global $post;

$clickbehaviour = get_option('phi_thumbnail_click');
$posttype = 'phiportfolio';
$columns = $columns;
$term = $category;
$postcount = $postcount;

if (get_option(phi_disable_portfolioexcerpt)!= true):
$disableexcerpt = 'false';
endif;


// Set default values if not set in admin
if($columns == false){ $columnclass='one-third'; $imagewidth = 300; $imagewrap = 'imageinset-300'; }

elseif($columns == 4){ $columnclass='one-fourth'; $imagewidth = 225; $imagewrap = 'imageinset-225';}

elseif($columns == 3){$columnclass='one-third'; $imagewidth = 300; $imagewrap = 'imageinset-300';}

elseif($columns == 2){ $columnclass='one-half'; $imagewidth = 440; $imagewrap = 'imageinset-440';}


// Thumbnails in 4 column layout
if (get_option('phi_4col_image_height')==false && $columns == 4){$imageheight = 136;}
elseif(get_option('phi_4col_image_height')==true && $columns == 4){$imageheight = get_option('phi_4col_image_height');}

// Thumbnails in 3 column layout
if (get_option('phi_3col_image_height')==false && $columns == 3){$imageheight = 176;}
elseif(get_option('phi_3col_image_height')==true && $columns == 3){$imageheight = get_option('phi_3col_image_height');}

// Thumbnails in 2 column layout
if (get_option('phi_2col_image_height')==false && $columns == 2){$imageheight = 279;}
elseif(get_option('phi_2col_image_height')==true && $columns == 2){$imageheight = get_option('phi_2col_image_height');}


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$counter =  0;

$args = array(
'post_type' => 'phiportfolio',
'taxonomy' => 'phiportfoliocats',
'term' => $term,
'paged'=>$paged,
//'orderby'=>'title',	
'order'=>'ASC',
'showposts'=> $postcount,

);

query_posts($args);


// The loop
if (have_posts()) : while (have_posts()) : the_post(); 	
$counter++;

// Post text
$customtitle = get_post_meta($post->ID,'phi_customtitle',true);
$customexcerpt = get_post_meta($post->ID,'phi_customexcerpt',true);
// Post images
$customThumbnail = get_post_meta($post->ID,'phi_thumbnail_image',true);
$customFullsize  = get_post_meta($post->ID,'phi_lightbox_image',true);
$featuredThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
$featuredFullsize  = wp_get_attachment_image_src(get_post_thumbnail_id(), '');
// Conditionals to determine image sources for fullsize images in lightbox and thumbnails
// Fullsize
if($customFullsize){
$fullsizeImage = $customFullsize;//If custom fullsize image is entered - use this as lightbox image
}
elseif(!$customFullsize){
$fullsizeImage = $featuredFullsize[0];//Else, if featured fullsize image is entered - use this as lightbox image
}
//Thumbnail
if($featuredThumbnail){
$thumbnailImage = $featuredThumbnail[0];//If featured image is entered - use this as thumbnail image
}
elseif($customThumbnail){	
$thumbnailImage = $customThumbnail;//Else, if custom thumbnail image is entered - use this as thumbnail image
}
elseif($customThumbnail == false && $featuredThumbnail == false){
$thumbnailImage = $customFullsize;//Else, if neither custom thumbnail  or featured image is entered - use custom fullsize as thumbnail image
}
// Title
if($customtitle){
	$posttitle = $customtitle;
	}
else{
$posttitle = get_the_title();
	}



	
						$portfoliostring;
						$portfoliostring.= '<!-- Featured Page Box -->';
						$portfoliostring.= '<div class="'.$columnclass;
						if(($counter % $columns) == 0){$portfoliostring.= ' last';}
						$portfoliostring.= '">';
						
						if($clickbehaviour == 'postlink'){
						$portfoliostring.= '<div class="'.$imagewrap.'"><span>';
						$portfoliostring.= '<a href="'.get_permalink().'"><img src="'.softshell_image_resize($imagewidth,$imageheight,$thumbnailImage).'"  alt="'.$posttitle.'" class="zoom"/></a>'; 
						$portfoliostring.= '</span></div>';
						}
						else{
						$portfoliostring.= '<div class="'.$imagewrap.'"><span>';
						$portfoliostring.= '<a href="'.$fullsizeImage.'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize($imagewidth,$imageheight,$thumbnailImage).'"  alt="'.$posttitle.'" class="zoom"/></a>'; 
						$portfoliostring.= '</span></div>';
						}
						
						$portfoliostring.= '<h3><a href="'.get_permalink().'">';
						$portfoliostring.= $posttitle;
						$portfoliostring.= '</a></h3>';
			
						
						if($disableexcerpt == true){
						$portfoliostring.= '<p>'.$customexcerpt.'</p>';
						}
						$portfoliostring.= '<a href="'.get_permalink().'" class="btn-small"><span>'.get_option('phi_readmore_text').'</span></a></div>';
						
						 if(($counter % $columns) == 0){$portfoliostring.= '<br class="break" />';}
						
						$portfoliostring.= '<!-- End Featured Page Box -->';
						
						endwhile; 
						endif;
						
						return $portfoliostring;
						
						 
						
						wp_reset_query();
}

// INSERT GALLERY

function insertGallery($columns,$maximum){
global $post;
$columns = $columns;
$maximum = $maximum -1;
																			
$largephotos = phi_get_images_url();
$title = phi_get_images_title();													

if($maximum){
	$count = $maximum;
}
else{
$count = count($largephotos);
}
if ($columns == 2){$imagewidth = 440; $divclass = 'one-half'; $imagewrap = 'imageinset-440';}
if ($columns == 3){$imagewidth = 300; $divclass = 'one-third'; $imagewrap = 'imageinset-300';}
if ($columns == 4){$imagewidth = 225; $divclass = 'one-fourth'; $imagewrap = 'imageinset-225';}




// Thumbnails in 4 column layout
if (get_option('phi_4col_image_height')==false && $columns == 4){$imageheight = 136;}
elseif(get_option('phi_4col_image_height')==true && $columns == 4){$imageheight = get_option('phi_4col_image_height');}

// Thumbnails in 3 column layout
if (get_option('phi_3col_image_height')==false && $columns == 3){$imageheight = 176;}
elseif(get_option('phi_3col_image_height')==true && $columns == 3){$imageheight = get_option('phi_3col_image_height');}

// Thumbnails in 2 column layout
if (get_option('phi_2col_image_height')==false && $columns == 2){$imageheight = 279;}
elseif(get_option('phi_2col_image_height')==true && $columns == 2){$imageheight = get_option('phi_2col_image_height');}
	
	
	
$i=0;

while ($i <= $count){
$i++;															
$a = $i - 1;
														
if(($i % $columns) == 0){$position = 'last'; }
elseif (($i % $columns) != 0){$position = ''; }
															
$galleryString;
$galleryString .=	 '<div class="'.$divclass.' '.$position.'">';
$galleryString .=	 '<div class="'.$imagewrap.'"><span>';
$galleryString .=	 '<a href="'.$largephotos[$a].'" rel="prettyPhoto[gall]"><img src="'.softshell_image_resize($imagewidth,$imageheight,$largephotos[$a]).'" alt="'.$title[$a].'" class="zoom"/></a>';

$galleryString .=	 '</span></div>';
$galleryString .=	 '<div class="galltitle"><h5>'.$title[$a].'</h5></div>';
$galleryString .=	 '</div>';

// Insert a br for every third item
if(($i % $columns) == 0){ 
$galleryString .=	 '<br class="break"/>';
}
}

return $galleryString;
}


// CONTACT FORM

function makecontact($rec){


$recipient = $rec;
	//If the form is submitted
if(isset($_POST['phi_name'])) {

	
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['phi_name']) === 'Your name' || trim($_POST['phi_name']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['phi_name']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['phi_email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['phi_email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['phi_email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['phi_message']) === '') {
			$commentError = 'Please enter your message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['phi_message']));
			} else {
				$comments = trim($_POST['phi_message']);
			}
		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {
			$phone=trim($_POST['phi_phone']);
			if($recipient){
			$emailTo = $recipient;
			}
			else{
			$emailTo = get_option('phi_form_mail');
			}
			$subject = 'Contact Form Submission from '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nPhone: $phone \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);

			$emailSent = true;

		}
	
}


			$formString = "";
			$formString.='<div id="contact-form" class="innercontent">';
			$formString.='<form action=""  id="validate_form" method="post"><ul>';
			// Name input
			$formString.='<li>';
			$formString.='<input type="text" name="phi_name" class="cleardefault" value="';
			if(isset($_POST['phi_name'])){
			$formString.= $_POST['phi_name'];
			}else{
			$formString.= 'Your name';
			}
			$formString.= '"/>';
			if($nameError != '') {
			$formString.='<span class="red"> * '.$nameError.'</span>';
			}
			$formString.='</li>';
			
			// Mail input
			$formString.='<li>';
			$formString.='<input type="text" name="phi_email" class="cleardefault" value="';
			if(isset($_POST['phi_email'])) {
			$formString.= $_POST['phi_email']; 
			}else{
			$formString.= 'Your email';
			}
			$formString.= '"/>';
			
			if($emailError != '') {
			$formString.='<span class="red"> * '.$emailError.'</span>';
			}
			$formString.='</li>';
			
			// Phone
			$formString.='<li>';
			$formString.='<input type="text" name="phi_phone" class="cleardefault" value="'; 
			if(isset($_POST['phi_phone'])){
			$formString.= $_POST['phi_phone']; 
			}else{ 
			$formString.= 'Your phone number';
			}
			$formString.= '"/>';
			$formString.='</li>';
		
			$formString.='<li>';
			$formString.='Your message:';
			if($commentError != ''){ 
			$formString.= '<span class="red"> * '.$commentError.'</span>';
			}
			$formString.='</li>';
			$formString.='<li>';
			$formString.='<textarea name="phi_message" rows="8" cols="40">';
			if(isset($_POST['phi_message'])) { 
			if(function_exists('stripslashes')) {
			$formString.= stripslashes($_POST['phi_message']);
			} else {
			$formString.= $_POST['phi_message'];
			}
			}
			$formString.= '</textarea>';
			$formString.='</li>';
			$formString.='<li>';
			$formString.= '<input type="submit" id="submitbutton" value="Submit"  />';
			$formString.='</li>';
			$formString.='</ul>';
			$formString.='</form>';
			$formString.='</div>';
			

			
			if(isset($emailSent) && $emailSent == true): 
			
			$formString.= '<script type="text/javascript">$("#validate_form").hide();</script>';
			$formString.= '<div class="mailreceipt shadowbox"><h1>Thanks, '.$name.'</h1><p>Your email was successfully sent. We will be in touch soon.</p></div>';
			endif;
	
		
			return $formString;
	

			
}


// VIDEO FUNCTION

function makeVideo($videourl,$mvh,$shortcode){
global $post;

$videourl=$videourl;
$size=$mvh;	
$shortcode = $shortcode;

$videosource = get_post_meta($post->ID,'phi_videosource',true);
//$videourl= get_post_meta($post->ID,'phi_videourl',true);


if(strstr($videourl,'vimeo.com')) {
	$newvideourl = substr_replace($videourl,'http://vimeo.com/moogaloop.swf?clip_id=', 0,17);	
} 

elseif(strstr($videourl,'youtube.com')) {
	$newvideourl = substr_replace($videourl,'v/', 23,8);	
} 

else{
	$newvideourl = $videosource; //No change
	}

$setVideoHeight = get_post_meta($post->ID,'phi_videoheight',true);
$setVideoWidth = get_post_meta($post->ID,'phi_videowidth',true);

						
if($size == 'large'){
	$defaultVideoWidth  = '659';
	$defaultVideoHeight = '496';
	$divclass = 'imageinset-659';
	};
							
if($size == 'medium'){
	$defaultVideoWidth  = '616';
	$defaultVideoHeight = '314';
	$divclass = 'imageinset-630';
	};
												
if($setVideoHeight == false){
	$newVideoHeight = $defaultVideoHeight;
	
	}
else{
	$newVideoHeight = $setVideoHeight;
}
if($setVideoWidth == false){
	$newVideoWidth = $defaultVideoWidth;
}


$videoString = "";
$videoString .= '<div class="'.$divclass.'"><span style="padding-bottom:20px;"><object type="application/x-shockwave-flash" ';
$videoString .= 'data="';
$videoString .= $newvideourl;
$videoString .= '" width="';
$videoString .= $newVideoWidth;
$videoString .= '" height="';
$videoString .= $newVideoHeight;
$videoString .= '"> <param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="movie" value="';
$videoString .= $newvideourl;
$videoString .= '" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#ffffff" /><img src="banner.gif" width="';
$videoString .= $newVideoWidth;
$videoString .= '" height="';
$videoString .= $newVideoHeight;
$videoString .= '" alt="banner" /></object></span></div><br class="break"/>';

if($shortcode == '1'){
return $videoString;
}
else{
echo $videoString;}
}


// BREADCRUMB SCRIPT

/* Breadcrumb */
function phi_breadcrumbs() {
	
	if(get_option('phi_breadcrumb')==false){
		
	echo '<div id="breadcrumb">';
	
 	if(get_option(phi_breadcrumb)==false){
	$delimiter = ' / ';
	
	$home_name = get_option(phi_trans_home);
	if ($home_name){
	$name = $home_name;	
	}
	else{
	$name = 'Home'; //text for a 'Home' link
	}
	if ( !is_home() || !is_front_page() || is_paged() ) {
		global $post;
		$home = get_bloginfo('url');
		echo 'You are here: <a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo 'Archive by category &#39;';
			single_cat_title();
			echo '&#39;';
 
		} elseif ( is_day() ) {
    	echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
    	echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
    	echo get_the_time('d');
 
		} elseif ( is_month() ) {
    	echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
    	echo get_the_time('F');
 
		} elseif ( is_year() ) {
    	echo get_the_time('Y');
 
		} elseif ( is_single() ) {
			$cat = get_the_category(); $cat = $cat[0];
			if($cat!=''){
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			}
			
			the_title();
 
		} 
			
		
			elseif ( is_page() && !$post->post_parent ) {
			the_title();
 
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			the_title();
 
		} elseif ( is_search() ) {
			echo 'Search results for &#39;' . get_search_query() . '&#39;';
 
		} elseif ( is_tag() ) {
			echo 'Posts tagged &#39;';
			single_tag_title();
			echo '&#39;';
 
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo 'Articles posted by ' . $userdata->display_name;
		}
 
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
 
	}
}
echo '</div>';
}

}


// ---------------------------------------------------------------------------------------------------------------
// SHORTCODES
// ---------------------------------------------------------------------------------------------------------------


// INSERT PORTFOLIO
function portfolio ($atts, $content = null) {
		
		extract(shortcode_atts(array(
				'category' => '',							  
				'columns' => '',
				'postcount' => '',		
				
				), $atts));
				
				
				return insertPortfolio($columns, $category, $postcount);
		
}
add_shortcode("portfolio", "portfolio");


// INSERT GALLERY

function gallery ($atts, $content = null) {
		
		extract(shortcode_atts(array(
											  
				'columns' => '',
				'maximum' => ''
				
				), $atts));
				
				
				return insertGallery($columns, $maximum);
		
}

add_shortcode("gall", "gallery");


// INSERT BUTTON
function button($atts, $content = null) {
		
		extract(shortcode_atts(array(
											  
				'color' => '',
				
				'url' => '',
				'target'=>'',
				'align'	=> '',
				'style' => '',
				), $atts));
				
				if($target =='blank'){$target = 'external';}
		
				if ($float ==''){$clear='<br class="break"/>'; }
		
		return '<a href="'.$url.'" class="btn hoverfade" style="float:'.$align.';" rel="_'.$target.'"><span>'.$content.'</span></a>';
}
add_shortcode("button", "button");




// INSERT VIDEO
function addvideo($atts, $content = null) {
		
		extract(shortcode_atts(array(
				'src' => '',
				'size' =>'medium',
				), $atts));
                
	
		return makeVideo($src,$size,'1');
}
            
add_shortcode("video", "addvideo");


// INSERT CONTACTFORM
function addcontactform($atts, $content = null) {
		
		extract(shortcode_atts(array(
				'recipient' => '',
				
				), $atts));
	
		return makecontact($recipent);
}
            
add_shortcode("contactform", "addcontactform");



// INSERT IMAGE
function addimage($atts, $content = null) {
				extract(shortcode_atts(array(
				'url' => '',
				), $atts));
                return '<img src="'.$url.'"/>';
}
add_shortcode("image", "addimage");



// INSERT PULLQUOTE

function pullquote( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'float' => '$align',
    ), $atts));
   return '<blockquote class="pullquote"><p>'.$content.'</p></blockquote>';
}
add_shortcode('pull', 'pullquote');

// INSERT PUSHQUOTE

function pushquote( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'float' => '$align',
    ), $atts));
   return '<blockquote class="pushquote"><p>'.$content.'</p></blockquote>';
}
add_shortcode('push', 'pushquote');


// INSERT COLUMNS/BOXES
function box($atts, $content = null) {
				extract(shortcode_atts(array(
				'title' => '',
				'size' => '',
				'align' => '',
				'color' => '',
				'position' => '',
								
				), $atts));
                if($position =='last'){$break = '<br class="break"/>'; $stylestring = 'style="margin:0;';}
					 if($color== ''){$color = 'transparent';}
					 if($align== 'right'){$align = 'alignright';}
					 if($align== 'left'){$align = 'alignleft';}
					 
				 
				return '<div class="'.$size.'_'.$color.' box-'.$position.' '.$align.'" style="'.$stylestring.'"><h3>'.$title.'</h3>'.do_shortcode($content).'</div>'.$break;
}
add_shortcode("box", "box");

/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );
 
 function yoast_hide_admin_bar_settings() {
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
}
 
function yoast_disable_admin_bar() {
    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'admin_print_scripts-profile.php', 
         'yoast_hide_admin_bar_settings' );
}
add_action( 'init', 'yoast_disable_admin_bar' , 9 );






add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_help_widget', 'Real Estate Properties', 'custom_dashboard_help');
}

function custom_dashboard_help() {
echo '<p style="float:left;"><img src="'.site_url().'/wp-content/plugins/property-agent/house.jpg" />&nbsp;&nbsp;</p>&nbsp;<h1 style="font-size:16px; margin-top:10px">Welcome to Real Estate Properties Manager!</h1><div style="clear:both;"></div><p>Click <a href="'.site_url().'/wp-admin/admin.php?page=property-agent/property_agent.php">here</a> to begin managing your properties.</p>';
}


add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

function custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_help_widget_agent', 'Real Estate Agents', 'agent_custom_dashboard_help');
}

function agent_custom_dashboard_help() {
echo '<p style="float:left;"><img src="'.site_url().'/wp-content/plugins/agents/agents.jpg" />&nbsp;&nbsp;</p>&nbsp;<h1 style="font-size:16px; margin-top:10px">Welcome to Real Estate Property Agents Manager!</h1><div style="clear:both;"></div><p>Click <a href="'.site_url().'/wp-admin/admin.php?page=agents/agents.php">here</a> to begin managing your agents.</p>';
}

/***** FOR ADD NEW Capability BASED ON ROLE ******
global $wp_roles;
// add "organize_gallery" to this role object
$wp_roles->add_cap( 'administrator', 'property_manage' );
$wp_roles->add_cap( 'author', 'property_manage' );
*/

/*
global $wp_roles;
$wp_roles->add_cap( 'administrator', 'agent_manage' );
$wp_roles->add_cap( 'author', 'agent_manage' );
*/
?>