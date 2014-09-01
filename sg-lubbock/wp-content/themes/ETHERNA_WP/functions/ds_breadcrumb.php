<?php
    if (!function_exists('ds_breadcrumb_nav')) {
		function ds_breadcrumb_nav() {
		global $options;
		global $post;
foreach ($options as $value) {
	if ( isset( $value['id'] ) ) {
		if (get_option( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_option( $value['id'] );
		}
	}
}
			if ( !is_home() || !is_front_page() ) {
				_e('<p><span>&raquo;</span><a href="') . _e( home_url() ) . _e('">') . _e('Home') . _e('</a><span>&raquo;</span>');
				if ( is_category() ) {
					single_cat_title();
					//the_category(', ');
				} elseif ( is_single() ) {
					the_category(', ') . _e('<span>&raquo;</span>') . the_title();
				} elseif (is_page() && $post->post_parent ) {
					_e( '<a href="' . get_permalink($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>');
					_e('<span>&raquo;</span>');
					_e( the_title() . '</p>' );
				} elseif ( is_page() ) {
					_e( the_title() . '</p>');
				} elseif ( is_404() ) {
					_e( '404</p>');
				} elseif ( is_search() ) {
					_e('Search for: ') . the_search_query() . _e('</p>');
				}
			}
		}
    }
?>