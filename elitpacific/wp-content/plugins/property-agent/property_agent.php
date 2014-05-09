<?php
/*
Plugin Name: SuperGeeks Property Agent List Manager 
Plugin URI: http://supergeeks.net/
Description: This Plugin manages list of property agents.
Author: SuperGeeks Team
Version: 1
Author URI: http://supergeeks.net/
*/

/**
 * Get list of property agents, depending on the agent table
 * Returns an stdClass object's array
 */
 
/********** Admin Panel **************************/
add_action('admin_menu', 'property_agent_plugin_menu');

function property_agent_plugin_menu() {
	add_menu_page('Elite Properties','Properties','property_manage',__FILE__,'propertyAgentList_options');	
	//add_options_page('Property List', 'All Properties', 'property_manage', 'propertyAgentList-identifier', 'propertyAgentList_options');
}

function propertyAgentList_options() {
	//if (!current_user_can('manage_options'))  {
	//	wp_die( __('You do not have sufficient permissions to access this page.') );
	//}
	// variables for the field and option names 
    global $wpdb, $wp_locale;	
	
	/**
	* get_results
	*/		
	$myrows = $wpdb->get_results( "SELECT a.*, b.large AS pimage FROM e_p_properties AS a, e_p_pics AS b WHERE a.id = b.property_id AND b.primary_pic = 1 ORDER BY a.id DESC " );
	
    // Now display the settings editing screen
    echo '<div class="wrap">';
?>
<?php //screen_icon(); ?>
<h2>Property List <a href="property.php?action=edit" class="add-new-h2">Add New</a></h2>
<?php	

$wp_list_table = _get_list_table('WP_Property_List_Table');

$pagenum = $wp_list_table->get_pagenum();
$wp_list_table->prepare_items();
$wp_list_table->views();
$wp_list_table->search_box( $post_type_object->labels->search_items, '' );
$wp_list_table->display(); 

if ( $wp_list_table->has_items() )
	$wp_list_table->inline_edit();

    // header

    //echo "<h2>" . __( 'LivingStones Twitter Tools Settings', 'menu-test' ) . "</h2>";

    // settings form   
    ?>
<?php
if ( isset($_REQUEST['s']) && $_REQUEST['s'] )
	printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', get_search_query() ); ?>
</div>

<?php	
}
?>