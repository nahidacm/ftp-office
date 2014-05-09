<?php
/**
 * New Post Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Administration Bootstrap */
require_once('./admin.php');

$parent_file = 'edit-property-form-advanced.php';
$submenu_file = 'property-new.php';

$post_type = "page";
$title = "Add New Property";

$editing = true;

wp_enqueue_script('autosave');

// Show post form.
//$post = get_default_post_to_edit( $post_type, true );
//$post_ID = $post->ID;
include('edit-property-form-advanced.php');
include('./admin-footer.php');
?>
