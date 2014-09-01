<?php
include_once (TEMPLATEPATH . "/functions/theme-options.php");
include_once (TEMPLATEPATH . "/functions/htmLawed.php");
include_once (TEMPLATEPATH . "/functions/shortcodes.php");
include_once (TEMPLATEPATH . "/functions/optionpanel.php");
include_once (TEMPLATEPATH . "/functions/ds_breadcrumb.php");
include_once (TEMPLATEPATH . "/functions/ds_sortables.php");
include_once (TEMPLATEPATH . "/functions/ds_resize.php");
include_once (TEMPLATEPATH . "/functions/ds_pagination.php");
?>
<?php // Includes the jQuery and js
function call_scripts() {
    if( !is_admin()){
		$template_uri = get_template_directory_uri();
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jqplugs', $template_uri . '/js/plugins.js', array('jquery'));
		wp_register_style( 'ds_eth_css Bronze', $template_uri . '/css/img/colors/bronze/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Brown', $template_uri . '/css/img/colors/brown/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Business Green', $template_uri . '/css/img/colors/businessgreen/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Business Purple', $template_uri . '/css/img/colors/businesspurple/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Business Teal', $template_uri . '/css/img/colors/businessteal/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Coral Blue', $template_uri . '/css/img/colors/coralblue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Crimson', $template_uri . '/css/img/colors/crimson/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Dark', $template_uri . '/css/img/colors/dark/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Deep Purple', $template_uri . '/css/img/colors/deeppurple/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Dentist Green', $template_uri . '/css/img/colors/dentistgreen/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Friendly Grey', $template_uri . '/css/img/colors/friendlygrey/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Funky Pink', $template_uri . '/css/img/colors/funkypink/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Funky Purple', $template_uri . '/css/img/colors/funkypurple/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Gold', $template_uri . '/css/img/colors/gold/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Hospital Green', $template_uri . '/css/img/colors/hospitalgreen/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Intense Pink', $template_uri . '/css/img/colors/intensepink/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Navy Blue', $template_uri . '/css/img/colors/navyblue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Neon Blue', $template_uri . '/css/img/colors/neonblue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Ocean Blue', $template_uri . '/css/img/colors/oceanblue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Olive', $template_uri . '/css/img/colors/olive/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Pink Panther', $template_uri . '/css/img/colors/pinkpanther/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Porno Purple', $template_uri . '/css/img/colors/pornopurple/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Red', $template_uri . '/css/img/colors/red/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Sea Blue', $template_uri . '/css/img/colors/seablue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Selen', $template_uri . '/css/img/colors/selen/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Soft Blue', $template_uri . '/css/img/colors/softblue/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Soft Green', $template_uri . '/css/img/colors/softgreen/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Soft Purple', $template_uri . '/css/img/colors/softpurple/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Soft Teal', $template_uri . '/css/img/colors/softteal/rainbow.css', '', '1.0' );
		wp_register_style( 'ds_eth_css Yellow', $template_uri . '/css/img/colors/yellow/rainbow.css', '', '1.0' );
    }
}
add_action('init', 'call_scripts');
?>
<?php load_theme_textdomain('design_sentry'); ?>
<?php // Register Sidebars
if ( function_exists('register_sidebar') )
	register_sidebar(Array("name" => "blog-left"));
	register_sidebar(Array("name" => "blog-right"));
	register_sidebar(Array("name" => "single-left"));
	register_sidebar(Array("name" => "single-right"));
	register_sidebar(Array("name" => "special-single-left"));
	register_sidebar(Array("name" => "special-single-right"));
    register_sidebar(Array("name" => "footer",
						  'before_widget' => '',
						  'after_widget' => '',));
	register_sidebar(Array("name" => "search-results"));
	register_sidebar(Array("name" => "home-blog-left",'id' => 'mpg9'));
	register_sidebar(Array("name" => "home-blog-right",'id' => 'mpg10'));
	register_sidebar(Array("name" => "sidebar-01"));
	register_sidebar(Array("name" => "sidebar-02"));
	register_sidebar(Array("name" => "sidebar-03"));
	register_sidebar(Array("name" => "sidebar-04"));
	register_sidebar(Array("name" => "sidebar-05"));
	register_sidebar(Array("name" => "sidebar-06"));
	register_sidebar(Array("name" => "sidebar-07"));
	register_sidebar(Array("name" => "sidebar-08"));
	register_sidebar(Array("name" => "sidebar-09"));
	register_sidebar(Array("name" => "sidebar-10"));
?>
<?php 
add_filter('dynamic_sidebar_params','widget_alpha_omega');
function widget_alpha_omega($params){
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
    /* Get the ids of this sidebar and widget*/
    $sidebar = $params[0]['id'];
	$sidebarname = $params[0]['name'];
    $widget   = $params[0]['widget_id'];
 
    /* Get number of widgets in this sidebar */
    $num_widgets = $params[1]['number'];
 
    /* Get data for all registered widgets */
    $all_widgets = wp_get_sidebars_widgets();
 
    /* Finish if no widgets set in this sidebar */
    if ( !isset($all_widgets[$sidebar]) || !is_array($all_widgets[$sidebar]) ) { return $params; }
 
    /* Set alpha class for first widget */
	if($sidebarname == 'footer'){
    if ( $all_widgets[$sidebar][0] == $widget ) {
	if($ds_eth_footer_grid1_val2 == 0){
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val1 . ' widget omega">';}
	else{$params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val1 . ' widget">';}
		$params[0]['after_widget'] = '</div>';
    }
	
	if ( $all_widgets[$sidebar][1] == $widget ) {
    if($ds_eth_footer_grid1_val3 == 0){
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val2 . ' widget omega">';}
	else{$params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val2 . ' widget">';}
		$params[0]['after_widget'] = '</div>';
    }
	
	if ( $all_widgets[$sidebar][2] == $widget ) {
    if($ds_eth_footer_grid1_val4 == 0){
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val3 . ' widget omega">';}
	else{$params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val3 . ' widget">';}
		$params[0]['after_widget'] = '</div>';
    }
	
	if ( $all_widgets[$sidebar][3] == $widget ) {
    if($ds_eth_footer_grid1_val5 == 0){
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val4 . ' widget omega">';}
	else{$params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val4 . ' widget">';}
		$params[0]['after_widget'] = '</div>';
    }
	
	if ( $all_widgets[$sidebar][4] == $widget ) {
	if($ds_eth_footer_grid1_val6 == 0){
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val5 . ' widget omega">';}
	else{$params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val5 . ' widget">';}
		$params[0]['after_widget'] = '</div>';
    }
 
    /* Set omega class for last widget */
    if ( $all_widgets[$sidebar][5] == $widget ) {
        $params[0]['before_widget'] = '<div class="gs_' . $ds_eth_footer_grid1_val6 . ' widget omega">';
		$params[0]['after_widget'] = '</div>';
    }
	}
 
    /* Return modified params */   
    return $params;
}
?>
<?php // Post-Thumbnails
add_theme_support('post-thumbnails');
add_theme_support( 'automatic-feed-links' );
?>
<?php // Register Menus
register_nav_menus( array(
                'main_menu' => 'Main menu'
) );
?>
<?php
if ( ! function_exists( 'twentyten_comment' ) ) :
/* Comments */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 80 ); ?>
			<?php printf( __( '%s <span class="says">'.__('says').':</span>' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?><div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><span class="ago">
			<?php
				/* translators: 1: date, 2: time */
				$time_s = round(date('U') - get_comment_time('U'));
				$time_m = round($time_s/60);
				$time_h = round($time_m/60);
				$time_d = round($time_h/24);
				if($time_s <= 120){echo ' '.__('minute','designSentry').' '.__('ago','designSentry').'';}
				elseif($time_m < 60){echo $time_m . ' '.__('minutes','designSentry').' '.__('ago','designSentry').'';}
				elseif($time_h < 24){echo $time_h . ' '.__('hours','designSentry').' '.__('ago','designSentry').'';}
				elseif($time_d < 365){echo $time_d . ' '.__('days','designSentry').' '.__('ago','designSentry').'';}
				else{_e('over year ago','designSentry');}
				?></span><?php edit_comment_link( __('(Edit)','designSentry'), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
function my_image_tag($html){
$html = str_replace('class="','class="wpimgload ',$html);
return $html;
}
add_filter('get_image_tag','my_image_tag');
?>
<?php function get_custom_field_value($szKey, $bPrint = false) {
	global $post;
	$szValue = get_post_meta($post->ID, $szKey, true);
	if ( $bPrint == false ) return $szValue; else echo $szValue;
}
?>
<?php function fix_category_pagination($qs){
	if(isset($qs['category_name']) && isset($qs['paged'])){
		$qs['post_type'] = get_post_types($args = array(
			'public'   => true,
			'_builtin' => false
		));
		array_push($qs['post_type'],'post');
	}
	return $qs;
}
add_filter('request', 'fix_category_pagination');
?>
<?php // Style overriding
add_action( 'wp_head', 'svt_css_hook' );
function svt_css_hook( ) {
include_once (TEMPLATEPATH . "/svt_style_override.php");
}
?>
<?php // js overriding
add_action( 'wp_footer', 'svt_js_hook' );
function svt_js_hook( ) {
include_once (TEMPLATEPATH . "/functions/js_override.php");
}
load_theme_textdomain('designSentry', get_template_directory() . '/languages');
?>