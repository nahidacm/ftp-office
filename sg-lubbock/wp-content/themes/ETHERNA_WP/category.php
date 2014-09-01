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
if ((is_category($ds_eth_portf_categories_list1)&&($ds_eth_portf_categories_list1)) || (is_category($ds_eth_portf_categories_list2)&&($ds_eth_portf_categories_list2))){
include(TEMPLATEPATH . '/category-myportfolio.php');
} else {
include(TEMPLATEPATH . '/archive.php');
};
?>