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
if (in_category($ds_eth_categories_list_sing1)){
include(TEMPLATEPATH . '/single-special.php');
} else {
include(TEMPLATEPATH . '/single-blog.php');
};
?>