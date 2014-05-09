<?php
/**
 * Edit post administration panel.
 *
 * Manage Post actions: post, edit, delete, etc.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once('./admin.php');
require_once('includes/property.php');

$parent_file = 'property.php';
$submenu_file = 'property.php';

wp_reset_vars(array('action', 'safe_mode', 'withcomments', 'posts', 'content', 'edited_post_title', 'comment_error', 'profile', 'trackback_url', 'excerpt', 'showcomments', 'commentstart', 'commentend', 'commentorder'));

$post_id = (int) $_REQUEST['id'];

$post_ID = $_REQUEST['id'];
$post = null;
$post_type_object = null;
$post_type = null;
if ( $post_id ) {
	$post = get_post($post_id);
	if ( $post ) {
		$post_type_object = get_post_type_object($post->post_type);
		if ( $post_type_object ) {
			$post_type = $post->post_type;
			$current_screen->post_type = $post->post_type;
			$current_screen->id = $current_screen->post_type;
		}
	}
} elseif ( isset($_POST['post_type']) ) {
	$post_type_object = get_post_type_object($_POST['post_type']);
	if ( $post_type_object ) {
		$post_type = $post_type_object->name;
		$current_screen->post_type = $post_type;
		$current_screen->id = $current_screen->post_type;
	}
}

/**
 * Redirect to previous page.
 *
 * @param int $post_id Optional. Post ID.
 */
function redirect_post($post_id = '') {
	if ( isset($_POST['save']) || isset($_POST['publish']) ) {
		$status = get_post_status( $post_id );

		if ( isset( $_POST['publish'] ) ) {
			switch ( $status ) {
				case 'pending':
					$message = 8;
					break;
				case 'future':
					$message = 9;
					break;
				default:
					$message = 6;
			}
		} else {
				$message = 'draft' == $status ? 10 : 1;
		}

		$location = add_query_arg( 'message', $message, get_edit_post_link( $post_id, 'url' ) );
	} elseif ( isset($_POST['addmeta']) && $_POST['addmeta'] ) {
		$location = add_query_arg( 'message', 2, wp_get_referer() );
		$location = explode('#', $location);
		$location = $location[0] . '#postcustom';
	} elseif ( isset($_POST['deletemeta']) && $_POST['deletemeta'] ) {
		$location = add_query_arg( 'message', 3, wp_get_referer() );
		$location = explode('#', $location);
		$location = $location[0] . '#postcustom';
	} elseif ( 'post-quickpress-save-cont' == $_POST['action'] ) {
		$location = "property.php?action=edit&post=$post_id&message=7";
	} else {
		$location = add_query_arg( 'message', 4, get_edit_post_link( $post_id, 'url' ) );
	}

	wp_redirect( apply_filters( 'redirect_post_location', $location, $post_id ) );
	exit;
}

if ( isset( $_POST['deletepost'] ) )
	$action = 'delete';
elseif ( isset($_POST['wp-preview']) && 'dopreview' == $_POST['wp-preview'] )
	$action = 'preview';


switch($action) {


case 'edit':
		
	$editing = true;

	include('./edit-property-form-advanced.php');

	break;

case 'editproperty':
	//check_admin_referer('update-' . $post_type . '_' . $post_id);
	$post_data = $_POST;
	$post_id = editproperty($post_data);
	
	wp_redirect(site_url().'/wp-admin/admin.php?page=property-agent/property_agent.php'); // Send user on their way while we keep working	
	exit();
	break;
	
case 'addproperty':
	//check_admin_referer('update-' . $post_type . '_' . $post_id);
	$post_data = $_POST;
	$post_id = addproperty($post_data);
	
	wp_redirect(site_url().'/wp-admin/admin.php?page=property-agent/property_agent.php'); // Send user on their way while we keep working	
	exit();
	break;	

case 'delete':
	//check_admin_referer('update-' . $post_type . '_' . $post_id);
	$post_data = $_GET;
	$post_id = deleteproperty($post_data);
	
	wp_redirect(site_url().'/wp-admin/admin.php?page=property-agent/property_agent.php'); // Send user on their way while we keep working	
	exit();
	break;

case 'preview':
	check_admin_referer( 'autosave', 'autosavenonce' );

	$url = post_preview();

	wp_redirect($url);
	exit();
	break;

default:
	wp_redirect( admin_url('property.php') );
	exit();
	break;
} // end switch
include('./admin-footer.php');
?>
