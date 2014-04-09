<?php
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'description' => __('This is the HomePage sidebr widget.', 'weblionmedia'),
		'name' => 'HomePage Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'description' => __('This is the Blog Sidebar widget.', 'weblionmedia'),
		'name' => 'Blog Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'description' => __('This is the Page Sidebar widget.', 'weblionmedia'),
		'name' => 'Page Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));	
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'news-sidebar',
		'description' => __('This is News Sidebar widget.', 'weblionmedia'),	
		'name' => 'News Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'media-sidebar',
		'description' => __('This is Media Sidebar widget.', 'weblionmedia'),	
		'name' => 'Media Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'contact-sidebar',
		'description' => __('This is Contact Page Sidebar widget.', 'weblionmedia'),	
		'name' => 'Contact Sidebar',
		'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'contact-form',
		'description' => __('This is Contact Form replacement widget.', 'weblionmedia'),	
		'name' => 'Contact Form',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	
	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'footer-column-1',
		'description' => __('This is the Footer Column 1.', 'weblionmedia'),	
		'name' => 'Footer Column 1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));		
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'footer-column-2',
		'description' => __('This is the Footer Column 2.', 'weblionmedia'),	
		'name' => 'Footer Column 2',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));			
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'footer-column-3',
		'description' => __('This is the Footer Column 3.', 'weblionmedia'),		
		'name' => 'Footer Column 3',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));			
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'id' => 'footer-column-4',
		'description' => __('This is the Footer Column 4.', 'weblionmedia'),		
		'name' => 'Footer Column 4',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

$get_custom_options = get_option($shortname.'_sidebars_cp');
$sidebarsCount = $get_custom_options['sidebarsCount'];
if ($sidebarsCount >= 1) {
	for($i = 1; $i <= $sidebarsCount; $i++) {
		if ($get_custom_options[$shortname.'_sidebars_cp_url_'.$i]) {
			$sidebar_name = $get_custom_options[$shortname.'_sidebars_cp_url_'.$i];
			if ( function_exists('register_sidebar') )
				register_sidebar(array(
					'id' => strtolower(str_replace(' ','-',$sidebar_name)),
					'description' => $sidebar_name,		
					'name' => $sidebar_name,
					'before_widget' => '',
		'after_widget' => '<div class="separator" style="height:31px;"></div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
				));
		}
	}
}

/** Register sidebars by running theme_widgets_init() on the widgets_init hook. */
function my_unregister_widgets() {
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Meta' );
} 
add_action( 'widgets_init', 'my_unregister_widgets' );
?>