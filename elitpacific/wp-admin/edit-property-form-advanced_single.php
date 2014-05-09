<?php
/**
 * Post advanced form for inclusion in the administration panels.
 *
 * @package WordPress
 * @subpackage Administration
 */
// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

wp_enqueue_script('property');

if ( post_type_supports($post_type, 'editor') || post_type_supports($post_type, 'thumbnail') ) {
	add_thickbox();
	wp_enqueue_script('media-upload');
}

function check($dateTime)
{
	if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches))
	{ 
		if (checkdate($matches[2], $matches[3], $matches[1]))
		{ 
			return true; 
		} 
	} 
	return false;
}  

/**
 * Post ID global
 * @name $post_ID
 * @var int
 */
$post_ID = isset($post_ID) ? (int) $post_ID : 0;
$temp_ID = isset($temp_ID) ? (int) $temp_ID : 0;
$user_ID = isset($user_ID) ? (int) $user_ID : 0;
$property_id = $_REQUEST['id'];
$action = isset($action) ? $action : '';

$messages = array();
$messages['post'] = array(
	 0 => '', // Unused. Messages start at index 1.
	 1 => sprintf( __('Post updated. <a href="%s">View Property</a>'), esc_url( get_permalink($post_ID) ) ),
	 2 => __('Custom field updated.'),
	 3 => __('Custom field deleted.'),
	 4 => __('Post updated.'),
	/* translators: %s: date and time of the revision */
	 5 => isset($_GET['revision']) ? sprintf( __('Post restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	 6 => sprintf( __('Post published. <a href="%s">View post</a>'), esc_url( get_permalink($post_ID) ) ),
	 7 => __('Post saved.'),
	 8 => sprintf( __('Post submitted. <a target="_blank" href="%s">Preview post</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 9 => sprintf( __('Post scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview post</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('Post draft updated. <a target="_blank" href="%s">Preview post</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);
$messages['page'] = array(
	 0 => '', // Unused. Messages start at index 1.
	 1 => sprintf( __('Page updated. <a href="%s">View page</a>'), esc_url( get_permalink($post_ID) ) ),
	 2 => __('Custom field updated.'),
	 3 => __('Custom field deleted.'),
	 4 => __('Page updated.'),
	 5 => isset($_GET['revision']) ? sprintf( __('Page restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	 6 => sprintf( __('Page published. <a href="%s">View page</a>'), esc_url( get_permalink($post_ID) ) ),
	 7 => __('Page saved.'),
	 8 => sprintf( __('Page submitted. <a target="_blank" href="%s">Preview page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	 9 => sprintf( __('Page scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview page</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	10 => sprintf( __('Page draft updated. <a target="_blank" href="%s">Preview page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

$messages = apply_filters( 'post_updated_messages', $messages );

$message = false;
if ( isset($_GET['message']) ) {
	$_GET['message'] = absint( $_GET['message'] );
	if ( isset($messages[$post_type][$_GET['message']]) )
		$message = $messages[$post_type][$_GET['message']];
	elseif ( !isset($messages[$post_type]) && isset($messages['post'][$_GET['message']]) )
		$message = $messages['post'][$_GET['message']];
}

$notice = false;
$form_extra = '';
if ( 'auto-draft' == $post->post_status ) {
	if ( 'edit' == $action )
		$post->post_title = '';
	$autosave = false;
	$form_extra .= "<input type='hidden' id='auto_draft' name='auto_draft' value='1' />";
} else {
	$autosave = wp_get_post_autosave( $post_ID );
}

if ($property_id)
	$form_action = 'editproperty';
else
	$form_action = 'addproperty';
	
$nonce_action = 'update-' . $post_type . '_' . $post_ID;
$form_extra .= "<input type='hidden' id='post_ID' name='post_ID' value='" . esc_attr($post_ID) . "' />";

// Detect if there exists an autosave newer than the post and if that autosave is different than the post
if ( $autosave && mysql2date( 'U', $autosave->post_modified_gmt, false ) > mysql2date( 'U', $post->post_modified_gmt, false ) ) {
	foreach ( _wp_post_revision_fields() as $autosave_field => $_autosave_field ) {
		if ( normalize_whitespace( $autosave->$autosave_field ) != normalize_whitespace( $post->$autosave_field ) ) {
			$notice = sprintf( __( 'There is an autosave of this post that is more recent than the version below.  <a href="%s">View the autosave</a>' ), get_edit_post_link( $autosave->ID ) );
			break;
		}
	}
	unset($autosave_field, $_autosave_field);
}

$post_type_object = get_post_type_object($post_type);

// All meta boxes should be defined and added before the first do_meta_boxes() call (or potentially during the do_meta_boxes action).
require_once('./includes/meta-boxes.php');

add_meta_box('submitdiv', __('Options'), 'post_submit_meta_box', $post_type, 'side', 'core');

if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post_type, 'post-formats' ) )
	add_meta_box( 'formatdiv', _x( 'Format', 'post format' ), 'post_format_meta_box', $post_type, 'side', 'core' );

// all taxonomies
/*foreach ( get_object_taxonomies($post_type) as $tax_name ) {
	$taxonomy = get_taxonomy($tax_name);
	if ( ! $taxonomy->show_ui )
		continue;

	$label = $taxonomy->labels->name;

	if ( !is_taxonomy_hierarchical($tax_name) )
		add_meta_box('tagsdiv-' . $tax_name, $label, 'post_tags_meta_box', $post_type, 'side', 'core', array( 'taxonomy' => $tax_name ));
	else
		add_meta_box($tax_name . 'div', $label, 'post_categories_meta_box', $post_type, 'side', 'core', array( 'taxonomy' => $tax_name ));
}

if ( post_type_supports($post_type, 'page-attributes') )
	add_meta_box('pageparentdiv', 'page' == $post_type ? __('Page Attributes') : __('Attributes'), 'page_attributes_meta_box', $post_type, 'side', 'core');*/

/*if ( current_theme_supports( 'post-thumbnails', $post_type ) && post_type_supports( $post_type, 'thumbnail' )
	&& ( ! is_multisite() || ( ( $mu_media_buttons = get_site_option( 'mu_media_buttons', array() ) ) && ! empty( $mu_media_buttons['image'] ) ) ) )
		add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', $post_type, 'side', 'low');*/

/*if ( post_type_supports($post_type, 'excerpt') )
	add_meta_box('postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', $post_type, 'normal', 'core');

if ( post_type_supports($post_type, 'trackbacks') )
	add_meta_box('trackbacksdiv', __('Send Trackbacks'), 'post_trackback_meta_box', $post_type, 'normal', 'core');

if ( post_type_supports($post_type, 'custom-fields') )
	add_meta_box('postcustom', __('Custom Fields'), 'post_custom_meta_box', $post_type, 'normal', 'core');

do_action('dbx_post_advanced');
if ( post_type_supports($post_type, 'comments') )
	add_meta_box('commentstatusdiv', __('Discussion'), 'post_comment_status_meta_box', $post_type, 'normal', 'core');

if ( ('publish' == $post->post_status || 'private' == $post->post_status) && post_type_supports($post_type, 'comments') )
	add_meta_box('commentsdiv', __('Comments'), 'post_comment_meta_box', $post_type, 'normal', 'core');

if ( !( 'pending' == $post->post_status && !current_user_can( $post_type_object->cap->publish_posts ) ) )
	add_meta_box('slugdiv', __('Slug'), 'post_slug_meta_box', $post_type, 'normal', 'core');

if ( post_type_supports($post_type, 'author') ) {
	if ( is_super_admin() || current_user_can( $post_type_object->cap->edit_others_posts ) )
		add_meta_box('authordiv', __('Author'), 'post_author_meta_box', $post_type, 'normal', 'core');
}

if ( post_type_supports($post_type, 'revisions') && 0 < $post_ID && wp_get_post_revisions( $post_ID ) )
	add_meta_box('revisionsdiv', __('Revisions'), 'post_revisions_meta_box', $post_type, 'normal', 'core');

do_action('add_meta_boxes', $post_type, $post);
do_action('add_meta_boxes_' . $post_type, $post);

do_action('do_meta_boxes', $post_type, 'normal', $post);
do_action('do_meta_boxes', $post_type, 'advanced', $post);
do_action('do_meta_boxes', $post_type, 'side', $post);*/

add_screen_option('layout_columns', array('max' => 2) );

if ( 'post' == $post_type ) {
	add_contextual_help($current_screen,
	'<p>' . __('The title field and the big Post Editing Area are fixed in place, but you can reposition all the other boxes using drag and drop, and can minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to unhide more boxes (Excerpt, Send Trackbacks, Custom Fields, Discussion, Slug, Author) or to choose a 1- or 2-column layout for this screen.') . '</p>' .
	'<p>' . __('<strong>Title</strong> - Enter a title for your post. After you enter a title, you&#8217;ll see the permalink below, which you can edit.') . '</p>' .
	'<p>' . __('<strong>Post editor</strong> - Enter the text for your post. There are two modes of editing: Visual and HTML. Choose the mode by clicking on the appropriate tab. Visual mode gives you a WYSIWYG editor. Click the last icon in the row to get a second row of controls. The HTML mode allows you to enter raw HTML along with your post text. You can insert media files by clicking the icons above the post editor and following the directions. You can go the distraction-free writing screen, new in 3.2, via the Fullscreen icon in Visual mode (second to last in the top row) or the Fullscreen button in HTML mode (last in the row). Once there, you can make buttons visible by hovering over the top area. Exit Fullscreen back to the regular post editor.') . '</p>' .
	'<p>' . __('<strong>Publish</strong> - You can set the terms of publishing your post in the Publish box. For Status, Visibility, and Publish (immediately), click on the Edit link to reveal more options. Visibility includes options for password-protecting a post or making it stay at the top of your blog indefinitely (sticky). Publish (immediately) allows you to set a future or past date and time, so you can schedule a post to be published in the future or backdate a post.') . '</p>' .
	( ( current_theme_supports( 'post-formats' ) && post_type_supports( 'post', 'post-formats' ) ) ? '<p>' . __( '<strong>Post Format</strong> - This designates how your theme will display a specific post. For example, you could have a <em>standard</em> blog post with a title and paragraphs, or a short <em>aside</em> that omits the title and contains a short text blurb. Please refer to the Codex for <a href="http://codex.wordpress.org/Post_Formats#Supported_Formats">descriptions of each post format</a>. Your theme could enable all or some of 10 possible formats.' ) . '</p>' : '' ) .
	'<p>' . __('<strong>Featured Image</strong> - This allows you to associate an image with your post without inserting it. This is usually useful only if your theme makes use of the featured image as a post thumbnail on the home page, a custom header, etc.') . '</p>' .
	'<p>' . __('<strong>Send Trackbacks</strong> - Trackbacks are a way to notify legacy blog systems that you&#8217;ve linked to them. Enter the URL(s) you want to send trackbacks. If you link to other WordPress sites they&#8217;ll be notified automatically using pingbacks, and this field is unnecessary.') . '</p>' .
	'<p>' . __('<strong>Discussion</strong> - You can turn comments and pings on or off, and if there are comments on the post, you can see them here and moderate them.') . '</p>' .
	'<p>' . sprintf(__('You can also create posts with the <a href="%s">Press This bookmarklet</a>.'), 'options-writing.php') . '</p>' .
	'<p><strong>' . __('For more information:') . '</strong></p>' .
	'<p>' . __('<a href="http://codex.wordpress.org/Posts_Add_New_Screen" target="_blank">Documentation on Writing and Editing Posts</a>') . '</p>' .
	'<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>'
	);
} elseif ( 'page' == $post_type ) {
	add_contextual_help($current_screen, '<p>' . __('Pages are similar to Posts in that they have a title, body text, and associated metadata, but they are different in that they are not part of the chronological blog stream, kind of like permanent posts. Pages are not categorized or tagged, but can have a hierarchy. You can nest Pages under other Pages by making one the &#8220;Parent&#8221; of the other, creating a group of Pages.') . '</p>' .
	'<p>' . __('Creating a Page is very similar to creating a Post, and the screens can be customized in the same way using drag and drop, the Screen Options tab, and expanding/collapsing boxes as you choose. This screen also has the new in 3.2 distraction-free writing space, available in both the Visual and HTML modes via the Fullscreen buttons. The Page editor mostly works the same as the Post editor, but there are some Page-specific features in the Page Attributes box:') . '</p>' .
	'<p>' . __('<strong>Parent</strong> - You can arrange your pages in hierarchies. For example, you could have an &#8220;About&#8221; page that has &#8220;Life Story&#8221; and &#8220;My Dog&#8221; pages under it. There are no limits to how many levels you can nest pages.') . '</p>' .
	'<p>' . __('<strong>Template</strong> - Some themes have custom templates you can use for certain pages that might have additional features or custom layouts. If so, you&#8217;ll see them in this dropdown menu.') . '</p>' .
	'<p>' . __('<strong>Order</strong> - Pages are usually ordered alphabetically, but you can choose your own order by entering a number (1 for first, etc.) in this field.') . '</p>' .
	'<p><strong>' . __('For more information:') . '</strong></p>' .
	'<p>' . __('<a href="http://codex.wordpress.org/Pages_Add_New_Screen" target="_blank">Documentation on Adding New Pages</a>') . '</p>' .
	'<p>' . __('<a href="http://codex.wordpress.org/Pages_Screen#Editing_Individual_Pages" target="_blank">Documentation on Editing Pages</a>') . '</p>' .
	'<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>'
	);
}

require_once('./admin-header.php');
?>
<div class="wrap">
<?php //screen_icon(); ?>
<h2><?php echo esc_html( "Property" ); ?><?php if ( isset( $post_new_file ) ) : ?> <a href="<?php echo esc_url( $post_new_file ) ?>" class="add-new-h2"><?php echo esc_html("Add New Property"); ?></a><?php endif; ?></h2>
<?php if ( $notice ) : ?>
<div id="notice" class="error"><p><?php echo $notice ?></p></div>
<?php endif; ?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<script language="javascript" type="text/javascript">
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}
</script>
<script type="text/javascript">
	function updateCategory(e){
		//common			
		if(e.value == '1'){			
			jQuery('#sale').show();
		}else{
			jQuery('#sale').hide();
		}				
		if(e.value == '3' || e.value == '4'){			
			jQuery('#rent').show();
			jQuery('#security_deposit').show();
			jQuery('#flooring').show();
			jQuery('#security').show();
			jQuery('#_features').show();
			jQuery('#pet_policy').show();
			jQuery('#yard').show();
			jQuery('#tenure').hide();
			jQuery('#zoning').hide();
			jQuery('#assessed_value').hide();
			jQuery('#monthly_taxes').hide();
			jQuery('#monthly_maintenance_fee').hide();
			jQuery('#monthly_fee_includes').hide();
			jQuery('#hoa_fee').hide();
			jQuery('#mls_numberprimary_mls').hide();
			jQuery('#mls_number').hide();
			jQuery('#tmk_number').hide();
		}else{
			jQuery('#rent').hide();
			jQuery('#security_deposit').hide();
			jQuery('#flooring').hide();
			jQuery('#security').hide();
			jQuery('#_features').hide();
			jQuery('#pet_policy').hide();
			jQuery('#yard').hide();
			jQuery('#tenure').show();
			jQuery('#zoning').show();
			jQuery('#assessed_value').show();
			jQuery('#monthly_taxes').show();
			jQuery('#monthly_maintenance_fee').show();
			jQuery('#monthly_fee_includes').show();
			jQuery('#hoa_fee').show();
			jQuery('#primary_mls').show();
			jQuery('#mls_number').show();
			jQuery('#tmk_number').show();
		}
		if(e.value == '4'){
			jQuery('#sleeps').show();
			jQuery('#bed_configuration').show();
			jQuery('#maximum_guests').show();
			jQuery('#reservation_restrictions').show();
			jQuery('#reservation_deposit_policy').show();
			jQuery('#payment_policy').show();
			jQuery('#cancellation_policy').show();
			jQuery('#payment_methods_accepted').show();
			jQuery('#weekly_rent').show();
			jQuery('#nightly_rent').show();
			jQuery('#cleaning_fee').show();
			jQuery('#furnishings').show();
			jQuery('#ac').show();
			jQuery('#spa').show();
			jQuery('#elementary_school').hide();
			jQuery('#middle_school').hide();
			jQuery('#high_school').hide();
		}else{
			jQuery('#sleeps').hide();
			jQuery('#bed_configuration').hide();
			jQuery('#maximum_guests').hide();
			jQuery('#reservation_restrictions').hide();
			jQuery('#reservation_deposit_policy').hide();
			jQuery('#payment_policy').hide();
			jQuery('#cancellation_policy').hide();
			jQuery('#payment_methods_accepted').hide();
			jQuery('#weekly_rent').hide();
			jQuery('#nightly_rent').hide();
			jQuery('#cleaning_fee').hide();
			jQuery('#furnishings').hide();
			jQuery('#ac').hide();
			jQuery('#spa').hide();
			jQuery('#elementary_school').show();
			jQuery('#middle_school').show();
			jQuery('#high_school').show();
		}
		if(e.value == '3'){
			jQuery('#date_available').show();
			jQuery('#lease_terms').show();
			jQuery('#appliances').show();
			jQuery('#finishings').show();
			jQuery('#utilities').show();
			jQuery('#furnished').show();
			jQuery('#monthly_rental_rate_star').show();
		}else{
			jQuery('#date_available').hide('');
			jQuery('#lease_terms').hide('');
			jQuery('#appliances').hide('');
			jQuery('#finishings').hide('');
			jQuery('#utilities').hide('');
			jQuery('#furnished').hide('');
			jQuery('#monthly_rental_rate_star').hide('');
		}
		if(e.value == '2'){
			jQuery('#auc').show(); 
		}else{
			jQuery('#auc').hide();
		}		
	}
</script>
<script type="text/javascript">
	function chkValid(frm){
		//common			
		if (frm.property_name.value == ''){
			alert("Please Provide Property Address");
			frm.property_name.focus();
			return false;
		}
		if (frm.headline_1.value == ''){
			alert("Please Provide Headline 1");
			frm.headline_1.focus();
			return false;
		}
		if (frm.pcat.selectedIndex == 0){
			alert("Please Select Category");
			frm.pcat.focus();
			return false;
		}
		if (frm.pcat.selectedIndex == 2){
			if (frm.auction_price.value == ''){
				alert("Please Provide Auction Price");
				frm.auction_price.focus();
				return false;
			}
		}if (frm.pcat.selectedIndex == 3){
			if (frm.monthly_rent.value == ''){
				alert("Please Provide Monthly Rent");
				frm.monthly_rent.focus();
				return false;
			}
		}		
		if (frm.conditions.selectedIndex == -1){
			alert("Please Select Agent");
			frm.conditions.focus();
			return false;
		}
		if (frm.property_type.selectedIndex == 0){
			alert("Please Select Property Type");
			frm.pcat.focus();
			return false;
		}
		if (frm.property_type.selectedIndex == 3){
			if (frm.building_name.value == ''){
				alert("Please Provide Building Name");
				frm.building_name.focus();
				return false;
			}
		}
		if (frm.property_type.selectedIndex == 3){
			if (frm.pro_floor.value == ''){
				alert("Please Provide Floor");
				frm.pro_floor.focus();
				return false;
			}
		}
		if (frm.property_type.selectedIndex == 3){
			if (frm.amenities.value == ''){
				alert("Please Provide Amenities");
				frm.amenities.focus();
				return false;
			}
		}
		if (frm.address.value == ''){
			alert("Please Provide Address");
			frm.address.focus();
			return false;
		}
		if (frm.city.value == ''){
			alert("Please Provide City");
			frm.city.focus();
			return false;
		}
		if (frm.state_id.selectedIndex == 0){			
			alert("Please Select a State");
			frm.state_id.focus();
			return false;
		}
		if (frm.neighborhood.value == ''){
			alert("Please Provide Neighborhood");
			frm.neighborhood.focus();
			return false;
		}
		if (frm.display_pos.value == ''){
			alert("Please Provide Display Position");
			frm.display_pos.focus();
			return false;
		}	
		/*if (frm.tenure_val.selectedIndex == 0){			
			alert("Please Select a Tenure");
			frm.tenure_val.focus();
			return false;
		}*/
		
		
		return true;
	}
</script>
<form name="property" action="property.php" method="post" id="property"<?php do_action('post_edit_form_tag'); ?> enctype="multipart/form-data" onsubmit="return chkValid(this);">
<?php wp_nonce_field($nonce_action); ?>
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(stripslashes(wp_get_referer())); ?>" />
<input type="hidden" id="property_id" name="property_id" value="<?php echo $property_id; ?>" />
<?php
if ( 'draft' != $post->post_status )
	wp_original_referer_field(true, 'previous');

echo $form_extra;

wp_nonce_field( 'autosave', 'autosavenonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
?>

<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>" >
<div id="side-info-column" class="inner-sidebar">

<?php
('page' == $post_type) ? do_action('submitpage_box') : do_action('submitpost_box');
$side_meta_boxes = do_meta_boxes($post_type, 'side', $post);

//***************----------------------------------------------************************************
//*************** Select Property Data From The Property Table ************************************
//***************----------------------------------------------************************************
global $wpdb;

//$propertyData = $wpdb->get_results( "SELECT a.*, b.large AS pimage FROM e_p_properties AS a, e_p_pics AS b WHERE a.id = b.property_id AND b.primary_pic = 1 AND a.id = ".$property_id);
$propertyData = $wpdb->get_results( "SELECT a.*, b.large AS pimage FROM e_p_properties AS a LEFT JOIN e_p_pics AS b ON ( a.id = b.property_id ) WHERE a.id = ".$property_id);
$propertyAgent = $wpdb->get_results( "SELECT * FROM e_p_agent WHERE status = 1");
$propertyState = $wpdb->get_results( "SELECT * FROM e_p_states");
$propertyImages = $wpdb->get_results( "SELECT * FROM e_p_pics WHERE property_id = ".$property_id);
?>
</div>

<div id="post-body">
<div id="post-body-content">
<?php //if ( post_type_supports($post_type, 'title') ) { ?>
<div id="titlediv">
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Property Address:* </label>
	<input type="text" name="property_name" size="60" tabindex="1" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->property_name ) ); ?>" id="property_name" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Headline 1:*</label>
	<input type="text" name="headline_1" style="margin-left:200px;" size="60" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->headline_1 ) ); ?>" id="headline_1" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Headline 2: </label>
	<input type="text" name="headline_2" style="margin-left:200px;" size="60" tabindex="3" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->headline_2 ) ); ?>" id="headline_2" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Headline 3: </label>
	<input type="text" name="headline_3" size="60" tabindex="4" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->headline_3 ) ); ?>" id="headline_3" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Category:*</label>
	<select onchange="updateCategory(this)" id="pcat" style="width:185px;margin-left:200px;" tabindex="5" class="Input01" name="pro_category">
          	<option value="_" selected="selected">Please Select</option>
          	<option <?php if ($propertyData[0]->pro_category == '1'){?> selected="selected" <?php }?> value="1">Sale</option>
            <option <?php if ($propertyData[0]->pro_category == '2'){?> selected="selected" <?php }?> value="2">Auction</option>
            <option <?php if ($propertyData[0]->pro_category == '3'){?> selected="selected" <?php }?> value="3">Long Term Rentals</option>
            <option <?php if ($propertyData[0]->pro_category == '4'){?> selected="selected" <?php }?> value="4">Vacation Rentals</option>    
    </select>
</div><div style="clear:both;"></div>

<div id="auc" <?php if($propertyData[0]->pro_category == 2) echo ''; else echo 'style="display:none"';  ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Auction Starting Bid:* </label>    
    <input type="text" name="auction_price" id="auction_price" size="60" tabindex="6" style="margin-left:200px;" value="<?php echo $propertyData[0]->auction_price;?>" autocomplete="off" /> &nbsp; e.g. $1,234,567 
</div><div style="clear:both;"></div>

<div id="rent" <?php if($propertyData[0]->pro_category==3 || $propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"';?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Monthly Rental Rate: <span id="monthly_rental_rate_star" <? if($propertyData[0]->pro_category==3 || $propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"'; ?>>*</span> </label>     
    <input type="text" name="monthly_rent" id="monthly_rent" size="60" tabindex="7" style="margin-left:200px;" value="<?php echo $propertyData[0]->monthly_rent;?>" autocomplete="off" /> &nbsp; e.g. $1,234,567  
    
</div><div style="clear:both;"></div>

<div id="weekly_rent" <?php if ($propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Weekly Rental Rate: </label>
    <input type="text" name="weekly_rent" size="60" tabindex="8" style="margin-left:200px;" value="<?php echo $propertyData[0]->weekly_rent;?>" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="nightly_rent" <?php if($propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Nightly Rental Rate: </label>
    <input type="text" name="nightly_rent" size="60" tabindex="9" style="margin-left:200px;" value="<?php echo $propertyData[0]->nightly_rent;?>" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="security_deposit" <?php if($propertyData[0]->pro_category==3 || $propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Security Deposit: </label>
    <input type="text" name="security_deposit" size="60" tabindex="10" style="margin-left:200px;" value="<?php echo $propertyData[0]->security_deposit;?>" id="security_deposit" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="cleaning_fee" <?php if($propertyData[0]->pro_category==4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Cleaning Fee: </label>
    <input type="text" name="cleaning_fee" size="60" tabindex="11" style="margin-left:200px;" value="<?php echo $propertyData[0]->cleaning_fee;?>" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="date_available" <?php if($propertyData[0]->pro_category==3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Date Available: </label>    
    <select tabindex="12" style="width:185px;margin-left:200px;" class="Input01" name="da_m" id="da_m">
        <option value="_" >Month</option>
        <option value="01" <?php if($propertyData[0]->da_m=='01') echo 'selected = "selected"';?>>Jan</option>
        <option value="02" <?php if($propertyData[0]->da_m=='02') echo 'selected = "selected"';?>>Feb</option>
        <option value="03" <?php if($propertyData[0]->da_m=='03') echo 'selected = "selected"';?>>Mar</option>
        <option value="04" <?php if($propertyData[0]->da_m=='04') echo 'selected = "selected"';?>>Apr</option>
        <option value="05" <?php if($propertyData[0]->da_m=='05') echo 'selected = "selected"';?>>May</option>
        <option value="06" <?php if($propertyData[0]->da_m=='06') echo 'selected = "selected"';?>>Jun</option>
        <option value="07" <?php if($propertyData[0]->da_m=='07') echo 'selected = "selected"';?>>Jul</option>
        <option value="08" <?php if($propertyData[0]->da_m=='08') echo 'selected = "selected"';?>>Aug</option>
        <option value="09" <?php if($propertyData[0]->da_m=='09') echo 'selected = "selected"';?>>Sep</option>
        <option value="10" <?php if($propertyData[0]->da_m=='10') echo 'selected = "selected"';?>>Oct</option>
        <option value="11" <?php if($propertyData[0]->da_m=='11') echo 'selected = "selected"';?>>Nov</option>
        <option value="12" <?php if($propertyData[0]->da_m=='12') echo 'selected = "selected"';?>>Dec</option>
    </select>&nbsp;
    <select name="da_d" class="Input01" id="da_d" style="width:60px">
   		<option value="_">Day</option>
			<?php for ($i=1; $i<=31; $i++){?>
                <option <?php if ($propertyData[0]->da_d == $i){?> selected="selected" <?php }?> value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
    </select>&nbsp;
    <input type="text" name="da_year" maxlength="4" class="Input1" value="<?php echo $propertyData[0]->da_year?>" style="width:40px" />
</div><div style="clear:both;"></div>

<div id="lease_terms" <?php if($propertyData[0]->pro_category==3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Lease Terms: </label>
    <input type="text" name="lease_terms" size="60" tabindex="13" style="margin-left:200px;" value="<?php echo $propertyData[0]->lease_terms;?>" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="reservation_restrictions" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Reservation Restrictions: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="14" class="Input01" rows="6" cols="50" wrap="physical" name="reservation_restrictions"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->reservation_restrictions ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="reservation_deposit_policy" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Reservation Deposit Policy: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="15" class="Input01" rows="6" cols="50" wrap="physical" name="reservation_deposit_policy"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->reservation_deposit_policy ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="payment_policy" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Payment Policy: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="16" class="Input01" rows="6" cols="50" wrap="physical" name="payment_policy"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->payment_policy ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="cancellation_policy" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Cancellation Policy: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="17" class="Input01" rows="6" cols="50" wrap="physical" name="cancellation_policy"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->cancellation_policy ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="payment_methods_accepted" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Payment Methods Accepted: </label>
    <input type="text" name="payment_methods_accepted" size="60" tabindex="18" style="margin-left:200px;" value="<?php echo $propertyData[0]->payment_methods_accepted;?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="sale" <?php if($propertyData[0]->pro_category == 1) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Price: </label>
    <input type="text" name="sale_price" size="60" tabindex="19" style="margin-left:200px;" value="<?php echo $propertyData[0]->sale_price;?>" id="sale_price" autocomplete="off" />  &nbsp; e.g. 1,234,567  
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Select Agent:*</label>
    <select name="agent_id[]" id="conditions" size="60" style="width:185px; height:150px; margin-left:200px;" tabindex="20" multiple >
    <?php		
		for ($i=0;$i<count($propertyAgent); $i++){?>	
        	<option <?php if ($propertyData[0]->agent_id == $propertyAgent[$i]->id){?> selected="selected" <?php }?> value="<?php echo $propertyAgent[$i]->id;?>"><?php echo $propertyAgent[$i]->full_name;?></option>
    <?php }?>
    </select>    
</div><div style="clear:both;"></div>
<div style="clear:both;"></div>
<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Select Property Type:*</label>
    <select onchange="if(this.value == '3'){ Element.show('pro1');Element.show('pro2');Element.show('pro3');} else {Element.hide('pro1');Element.hide('pro2');Element.hide('pro3');};" tabindex="21" style="width:185px;margin-left:200px;" class="Input01" name="property_type" id="property_type">
        <option value="_">Select Property Type</option>
        <option <?php if ($propertyData[0]->property_type == '1'){?> selected="selected" <?php }?> value="1">Land</option>
        <option <?php if ($propertyData[0]->property_type == '2'){?> selected="selected" <?php }?> value="2">House</option>
        <option <?php if ($propertyData[0]->property_type == '3'){?> selected="selected" <?php }?> value="3">Condo</option>
        <option <?php if ($propertyData[0]->property_type == '4'){?> selected="selected" <?php }?> value="4">Commercial</option>
    </select>          
</div><div style="clear:both;"></div>


<div id="pro1" <?php if($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Building Name:* </label>
    <input type="text" name="building_name" id="building_name" size="60" tabindex="22" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->building_name ) ); ?>" autocomplete="off" />  
</div><div style="clear:both;"></div>

<div id="pro2" <?php if($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Floor:* </label>
    <input type="text" name="pro_floor" size="60" tabindex="23" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->pro_floor ) ); ?>" id="pro_floor" autocomplete="off" id="pro_floor" />  
</div><div style="clear:both;"></div>

<div id="pro3" <?php if($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Amenities:* </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="24" class="Input01" rows="6" cols="50" wrap="physical" name="amenities" id="amenities"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->amenities ) ); ?></textarea>    
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Address:*</label>
    <input type="text" name="address" size="60" tabindex="25" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->address ) ); ?>" id="address" autocomplete="off" />  
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">City:* </label>
    <input type="text" name="city" size="60" tabindex="26" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->city ) ); ?>" id="city" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">State:* </label>
    <select id="state_id" tabindex="27" style="width:185px;margin-left:200px;" class="Input01" name="state_id">
    	<option value="_">Please Select</option>
    	<?php		
		for ($i=0;$i<count($propertyState); $i++){?>        	
        	<option <?php if ($propertyData[0]->state_id == $propertyState[$i]->state_id){?> selected="selected" <?php }?> value="<?php echo $propertyState[$i]->state_id;?>"><?php echo $propertyState[$i]->state_name;?></option>
    <?php }?>
    </select>    
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Zip Code:*</label>
    <input type="text" name="zip_code" size="60" tabindex="28" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->zip_code ) ); ?>" id="zip_code" autocomplete="off" />   
</div><div style="clear:both;"></div>
<div class="inside">
<?php
//$sample_permalink_html = $post_type_object->public ? get_sample_permalink_html($post->ID) : '';
//$shortlink = wp_get_shortlink($post->ID, 'post');
//if ( !empty($shortlink) )
//    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';

//if ( $post_type_object->public && ! ( 'pending' == $post->post_status && !current_user_can( $post_type_object->cap->publish_posts ) ) ) { ?>
	<div id="edit-slug-box">
	<?php
//		if ( ! empty($post->ID) && ! empty($sample_permalink_html) && 'auto-draft' != $post->post_status )
//			echo $sample_permalink_html;
	?>
	</div>
<?php
//}
?>
</div>
<?php
wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
?>
</div>
<?php //} ?>

<?php //if ( post_type_supports($post_type, 'editor') ) { ?>
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Description:*</label> <br />
<?php 
$post->post_content = $propertyData[0]->description;
the_editor($post->post_content); ?>
<table id="post-status-info" cellspacing="0"><tbody><tr>
	<td id="wp-word-count"><?php printf( __( 'Word count: %s' ), '<span class="word-count">0</span>' ); ?></td>
	<td class="autosave-info">
	<span class="autosave-message">&nbsp;</span>
<?php
	if ( 'auto-draft' != $post->post_status ) {
		echo '<span id="last-edit">';
		if ( $last_id = get_post_meta($post_ID, '_edit_last', true) ) {
			$last_user = get_userdata($last_id);
			printf(__('Last edited by %1$s on %2$s at %3$s'), esc_html( $last_user->display_name ), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		} else {
			printf(__('Last edited on %1$s at %2$s'), mysql2date(get_option('date_format'), $post->post_modified), mysql2date(get_option('time_format'), $post->post_modified));
		}
		echo '</span>';
	} ?>
	</td>
</tr></tbody></table>
<br />
<div id="titlediv">
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Neighborhood:*  </label>
	<input type="text" name="neighborhood" size="60" tabindex="29" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->neighbourhood ) ); ?>" id="neighborhood" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="sleeps" <?php if ($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none;"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Sleeps:  </label>
	<input type="text" name="sleeps" size="60" tabindex="30" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->sleeps ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="bed_configuration" <?php if ($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none;"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Bed Configuration: </label>
	<input type="text" name="bed_configuration" size="60" tabindex="31" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->bed_configuration ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="maximum_guests" <?php if ($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none;"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Maximum Guests: </label>
	<input type="text" name="maximum_guests" size="60" tabindex="32" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->maximum_guests ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Number of Bedrooms: </label>
	<input type="text" name="no_of_bedrooms" size="60" tabindex="33" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->no_of_bedrooms ) ); ?>" id="no_of_bedrooms" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Number of Full Baths: </label>
	<input type="text" name="no_of_full_baths" size="60" tabindex="34" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->no_of_full_baths ) ); ?>" id="no_of_full_baths" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Number of Half Baths: </label>
	<input type="text" name="no_of_half_baths" size="60" tabindex="35" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->no_of_half_baths ) ); ?>" id="no_of_half_baths" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Interior Sq Ft: </label>
	<input type="text" name="interior_sq_ft" size="60" tabindex="36" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->interior_sq_ft ) ); ?>" id="interior_sq_ft" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Open Lanai Sq Ft: </label>
	<input type="text" name="open_lanai_sq_ft" size="60" tabindex="37" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->open_lanai_sq_ft ) ); ?>" id="open_lanai_sq_ft" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Covered Lanai Sq Ft: </label>
	<input type="text" name="covered_lanai_sq_ft" size="60" tabindex="38" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->covered_lanai_sq_ft ) ); ?>" id="covered_lanai_sq_ft" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Parking: </label>
	<input type="text" name="parking" size="60" tabindex="39" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->parking ) ); ?>" id="parking" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Land Sq Ft: </label>
	<input type="text" name="land_sq_ft" size="60" tabindex="40" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->land_sq_ft ) ); ?>" id="land_sq_ft" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="furnished" <?php if ($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Furnished: </label>
	<input type="text" name="furnished" size="60" tabindex="41" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->furnished ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="finishings" <?php if ($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Finishings: </label>
	<input type="text" name="finishings" size="60" tabindex="42" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->finishings ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="flooring" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Flooring: </label>
	<input type="text" name="flooring" size="60" tabindex="43" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->flooring ) ); ?>" id="flooring" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="furnishings" <?php if($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Furnishings: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="44" class="Input01" rows="6" cols="50" wrap="physical" name="furnishings"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->furnishings ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="ac" <?php if ($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">A/C: </label>
    <input type="text" name="ac" size="60" tabindex="45" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->ac ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="security" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Security: </label>
	<input type="text" name="security" size="60" tabindex="46" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->security ) ); ?>" id="security" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="utilities" <?php if ($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Utilities: </label>
	<input type="text" name="utilities" size="60" tabindex="47" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->utilities ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="appliances" <?php if($propertyData[0]->pro_category == 3) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Appliances: </label>
    <textarea style="width:280px;margin-left:200px;" tabindex="48" class="Input01" rows="6" cols="50" wrap="physical" name="appliances"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->appliances ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="_features" <?php if($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"'; ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title"> Unit Features: </label>
    <textarea style="width:336px;margin-left:200px;" tabindex="49" class="Input01" rows="6" cols="50" wrap="physical" name="_features"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->_features ) ); ?></textarea>  
</div><div style="clear:both;"></div>

<div id="pet_policy" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;"> Pet Policy: </label>
	<input type="text" name="pet_policy" size="60" tabindex="50" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->pet_policy ) ); ?>" id="pet_policy" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="yard" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Yard: </label>
	<input type="text" name="yard" size="60" tabindex="51" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->yard ) ); ?>"  autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="tenure" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo 'style=""';  ?>>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Select Tenure:* </label>
    <select onchange="if(this.value == '2'){ Element.show('pur_price_fee');Element.show('lease_rent');Element.show('lease_renegotiate_date');Element.show('lease_expiration_date'); } else { Element.hide('pur_price_fee');Element.hide('lease_rent');Element.hide('lease_renegotiate_date');Element.hide('lease_expiration_date'); }" id="tenure_val" tabindex="52" style="width:185px;margin-left:200px;" class="Input01" name="tenure">
	  <option value="_"> Select Tenure </option>
      <option <?php if ($propertyData[0]->tenure == '1'){?> selected="selected" <?php }?>  value="1">Fee Simple</option>
      <option <?php if ($propertyData[0]->tenure == '2'){?> selected="selected" <?php }?>  value="2">Leasehold</option>
    </select>    
</div><div style="clear:both;"></div>

<div id="pur_price_fee" <?php if($propertyData[0]->tenure==2) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Purchase Price Fee: </label>
	<input type="text" name="pur_price_fee" size="60" tabindex="53" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->pur_price_fee ) ); ?>"  autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="lease_rent" <?php if($propertyData[0]->tenure==2) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Lease Rent:* </label>
	<input type="text" name="lease_rent" size="60" tabindex="54" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->lease_rent ) ); ?>"  autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="lease_renegotiate_date" <?php if($propertyData[0]->tenure==2) echo ''; else echo 'style="display:none"';  ?>>
	<?php
	if (check($propertyData[0]->lease_re_date)){
		$l_year = date('Y', strtotime($propertyData[0]->lease_re_date));
		$l_m = date('m', strtotime($propertyData[0]->lease_re_date));
		$l_d = date('d', strtotime($propertyData[0]->lease_re_date));	
	}
	?>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Lease Renegotiate Date: </label>    
    <select tabindex="55" style="width:185px;margin-left:200px;" class="Input01" name="l_m" id="l_m">
        <option value="_" selected="selected" >Month</option>
        <option value="01" <?php if($l_m=='01') echo 'selected = "selected"';?>>Jan</option>
        <option value="02" <?php if($l_m=='02') echo 'selected = "selected"';?>>Feb</option>
        <option value="03" <?php if($l_m=='03') echo 'selected = "selected"';?>>Mar</option>
        <option value="04" <?php if($l_m=='04') echo 'selected = "selected"';?>>Apr</option>
        <option value="05" <?php if($l_m=='05') echo 'selected = "selected"';?>>May</option>
        <option value="06" <?php if($l_m=='06') echo 'selected = "selected"';?>>Jun</option>
        <option value="07" <?php if($l_m=='07') echo 'selected = "selected"';?>>Jul</option>
        <option value="08" <?php if($l_m=='08') echo 'selected = "selected"';?>>Aug</option>
        <option value="09" <?php if($l_m=='09') echo 'selected = "selected"';?>>Sep</option>
        <option value="10" <?php if($l_m=='10') echo 'selected = "selected"';?>>Oct</option>
        <option value="11" <?php if($l_m=='11') echo 'selected = "selected"';?>>Nov</option>
        <option value="12" <?php if($l_m=='12') echo 'selected = "selected"';?>>Dec</option>
    </select>&nbsp;
    <select name="l_d" class="Input01" id="l_d" style="width:60px">
   		<option value="_" selected="selected">Day</option>
			<?php for ($i=1; $i<=31; $i++){?>
                <option <?php if ($l_d == $i){?> selected="selected" <?php }?> value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
    </select>&nbsp;
    <input type="text" name="l_year" maxlength="4" class="Input1" value="<?php echo $l_year?>" style="width:40px" />
</div><div style="clear:both;"></div>

<div id="lease_expiration_date" <?php if($propertyData[0]->tenure==2) echo ''; else echo 'style="display:none"';  ?>>
	<?php	
	if (check($propertyData[0]->lease_exp_date)){
		$e_year = date('Y', strtotime($propertyData[0]->lease_exp_date));
		$e_m = date('m', strtotime($propertyData[0]->lease_exp_date));
		$e_d = date('d', strtotime($propertyData[0]->lease_exp_date));	
	}
	?>
	<label class="hide-if-no-js" style="font-size:16px; float:left;" id="title-prompt-text" for="title">Lease Expiration Date: </label>    
    <select tabindex="56" style="width:185px;margin-left:200px;" class="Input01" name="e_m" id="e_m">
        <option value="_" selected="selected" >Month</option>
        <option value="01" <?php if($e_m=='01') echo 'selected = "selected"';?>>Jan</option>
        <option value="02" <?php if($e_m=='02') echo 'selected = "selected"';?>>Feb</option>
        <option value="03" <?php if($e_m=='03') echo 'selected = "selected"';?>>Mar</option>
        <option value="04" <?php if($e_m=='04') echo 'selected = "selected"';?>>Apr</option>
        <option value="05" <?php if($e_m=='05') echo 'selected = "selected"';?>>May</option>
        <option value="06" <?php if($e_m=='06') echo 'selected = "selected"';?>>Jun</option>
        <option value="07" <?php if($e_m=='07') echo 'selected = "selected"';?>>Jul</option>
        <option value="08" <?php if($e_m=='08') echo 'selected = "selected"';?>>Aug</option>
        <option value="09" <?php if($e_m=='09') echo 'selected = "selected"';?>>Sep</option>
        <option value="10" <?php if($e_m=='10') echo 'selected = "selected"';?>>Oct</option>
        <option value="11" <?php if($e_m=='11') echo 'selected = "selected"';?>>Nov</option>
        <option value="12" <?php if($e_m=='12') echo 'selected = "selected"';?>>Dec</option>
    </select>&nbsp;
    <select name="e_d" class="Input01" id="e_d" style="width:60px">
   		<option value="_" selected="selected">Day</option>
			<?php for ($i=1; $i<=31; $i++){?>
                <option <?php if ($e_d == $i){?> selected="selected" <?php }?> value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
    </select>&nbsp;
    <input type="text" name="e_year" maxlength="4" class="Input1" value="<?php echo $e_year?>" style="width:40px" />
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Property Frontage: </label>
	<input type="text" name="property_frontage" size="60" tabindex="57" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->property_frontage ) ); ?>" id="property_frontage" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="zoning" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Zoning: </label>
	<input type="text" name="zoning" size="60" tabindex="58" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->zoning ) ); ?>"  autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Year Built: </label>
	<input type="text" name="year_built" size="60" tabindex="59" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->year_built ) ); ?>" id="year_built" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Year Renovated: </label>
	<input type="text" name="year_renovated" size="60" tabindex="60" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->year_renovated ) ); ?>" id="year_renovated" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Property Condition: </label>
	<input type="text" name="property_condition" size="60" tabindex="61" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->property_condition ) ); ?>" id="property_condition" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">View: </label>
	<textarea style="width:335px;margin-left:200px;" tabindex="62" class="Input01" onkeyup="textCounter(this.form.view,this.form.remLen,100);" onkeydown="textCounter(this.form.view,this.form.remLen,100);" rows="3" cols="40" wrap="physical" name="view"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->view ) ); ?></textarea><br /><input type="text" style="width:30px;margin-left:200px;" value="66" maxlength="3" size="3" name="remLen" class="Input01" readonly="readonly"> characters left
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Number of Stories: </label>
	<input type="text" name="no_of_stories" size="60" tabindex="63" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->no_of_stories ) ); ?>" id="no_of_stories" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Pool: </label>
	<input type="text" name="pool" size="60" tabindex="64" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->pool ) ); ?>" id="pool" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="spa" <?php if ($propertyData[0]->pro_category == 4) echo ''; else echo 'style="display:none"';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Spa: </label>
	<input type="text" name="spa" size="60" tabindex="65" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->spa ) ); ?>"  autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="assessed_value" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Assessed Value: </label>
	<input type="text" name="assessed_value" size="60" tabindex="66" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->assessed_value ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="monthly_taxes" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Monthly Taxes: </label>
	<input type="text" name="monthly_taxes" size="60" tabindex="67" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->monthly_taxes ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="monthly_maintenance_fee" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Monthly Maintenance Fee: </label>
	<input type="text" name="monthly_maintenance_fee" size="60" tabindex="68" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->monthly_maintenance_fee ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="monthly_fee_includes" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Maintenance Fee Includes: </label>
	<input type="text" name="monthly_fee_includes" size="60" tabindex="69" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->monthly_fee_includes ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="hoa_fee" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">HOA Fee: </label>
	<input type="text" name="hoa_fee" size="60" tabindex="70" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->hoa_fee ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="elementary_school" <?php if ($propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Elementary School: </label>
	<input type="text" name="elementary_school" size="60" tabindex="71" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->elementary_school ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="middle_school" <?php if ($propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Middle School: </label>
	<input type="text" name="middle_school" size="60" tabindex="72" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->middle_school ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="high_school" <?php if ($propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">High School: </label>
	<input type="text" name="high_school" size="60" tabindex="73" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->high_school ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="primary_mls" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Primary MLS: </label>
	<input type="text" name="primary_mls" size="60" tabindex="74" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->primary_mls ) ); ?>" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="mls_number" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">MLS Number: </label>
	<input type="text" name="mls_no" size="60" tabindex="75" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->mls_no ) ); ?>" id="mls_no" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="tmk_number" <?php if ($propertyData[0]->pro_category == 3 || $propertyData[0]->pro_category == 4) echo 'style="display:none"'; else echo '';  ?>>
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Tax Map Key Number: </label>
	<input type="text" name="tax_map_key" size="60" tabindex="76" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->tax_map_key ) ); ?>" id="tax_map_key" autocomplete="off" />
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Other: </label>
	<textarea style="width:335px;margin-left:200px;" class="Input01" rows="3" tabindex="77" cols="40" wrap="physical" name="other"><?php echo esc_attr( htmlspecialchars( $propertyData[0]->other ) ); ?></textarea>
</div><div style="clear:both;"></div>

<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Upload Images: <span style="font-size:12px;"><br />[Supported Images: ".JPEG,<br /> .JPEG, .GIF, .PNG" ]</span></label>
    <?php $numPic = count($propertyImages)+1;?>
	<input type="hidden" value="<?php echo $numPic;?>" name="file_count">
	<input type="file" name="file_<?php echo $numPic;?>" class="Input01" tabindex="78" style="width:200px;margin-left:200px;" id="my_file_element"><span style="font-size:12px;">&nbsp;&nbsp;&nbsp;Width: 600px, Height: 500 px</span><br /><br />
    <div style="margin-left:200px; width:460px;">
    <?php for ($i=0; $i<count($propertyImages);$i++){
		       $j = $i+1;	
	?>		<div style="float:left; width:100px; padding-right:12px;">
    	    <img width="75" border="0" height="55px;" src="<?php echo site_url();?>/up_data/properties/<?php echo $propertyImages[$i]->large;?>"><br /><br />
            <input type="checkbox" value="<?php echo $propertyImages[$i]->id;?>" name="propImg[]">Delete<br />
            <input type="radio" name="primaryImg" <?php if ($propertyImages[$i]->primary_pic == '1'){?> checked="checked" <?php }?> value="<?php echo $propertyImages[$i]->id;?>">As Primary         
			<?php if ($j%4==0){ echo "<br><br>";}?>
           	</div>
        <?php }?>
    </div>
</div><div style="clear:both;"></div><br /><br />
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 1: </label>
	<input type="text" name="link_title1" size="60" tabindex="79" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title1 ) ); ?>" id="link_title1" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 1: </label>
	<input type="text" name="link_url1" size="60" tabindex="80" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url1 ) ); ?>" id="link_url1" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 2: </label>
	<input type="text" name="link_title2" size="60" tabindex="81" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title2 ) ); ?>" id="link_title2" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 2: </label>
	<input type="text" name="link_url2" size="60" tabindex="82" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url2 ) ); ?>" id="link_url2" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 3: </label>
	<input type="text" name="link_title3" size="60" tabindex="83" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title3 ) ); ?>" id="link_title3" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 3: </label>
	<input type="text" name="link_url3" size="60" tabindex="84" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url3 ) ); ?>" id="link_url3" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 4: </label>
	<input type="text" name="link_title4" size="60" tabindex="85" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title4 ) ); ?>" id="link_title4" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 4: </label>
	<input type="text" name="link_url4" size="60" tabindex="86" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url4 ) ); ?>" id="link_url4" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 5: </label>
	<input type="text" name="link_title5" size="60" tabindex="87" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title5 ) ); ?>" id="link_title5" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 5: </label>
	<input type="text" name="link_url5" size="60" tabindex="88" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url5 ) ); ?>" id="link_url5" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 6: </label>
	<input type="text" name="link_title6" size="60" tabindex="89" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title6 ) ); ?>" id="link_title6" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 6: </label>
	<input type="text" name="link_url6" size="60" tabindex="90" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url6 ) ); ?>" id="link_url6" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 7: </label>
	<input type="text" name="link_title7" size="60" tabindex="91" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title7 ) ); ?>" id="link_title7" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 7: </label>
	<input type="text" name="link_url7" size="60" tabindex="92" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url7 ) ); ?>" id="link_url7" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Title 8: </label>
	<input type="text" name="link_title8" size="60" tabindex="93" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_title8 ) ); ?>" id="link_title8" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Link Url 8: </label>
	<input type="text" name="link_url8" size="60" tabindex="94" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->link_url8 ) ); ?>" id="link_url8" autocomplete="off" /><span style="font-size:12px;">[ Enter complete URL including http://]</span>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Display Position:*  </label>
	<input type="text" name="display_pos" size="2" tabindex="95" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $propertyData[0]->display_pos ) ); ?>" id="display_pos" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Agent Page Only: </label>
	<div style="margin-left:200px;">
    	<input type="radio" <?php if ($propertyData[0]->feature == 1){?> checked="checked" <?php }?> value="1" tabindex="96" name="feature">Yes
        <input type="radio" <?php if ($propertyData[0]->feature == 0 || $propertyData[0]->feature == ''){?> checked="checked" <?php }?> value="0" name="feature">No 
    </div>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:16px;">Status: </label>
	<div style="margin-left:200px;">
    	<input type="radio"  <?php if ($propertyData[0]->status == 1 || $propertyData[0]->status == ''){?> checked="checked" <?php }?>  tabindex="97" value="1" name="status"><span style="font-size:12px;">Active </span>
        <input type="radio" <?php if ($propertyData[0]->status == 0){?> checked="checked" <?php }?> value="0" name="status"><span style="font-size:12px;">In-active [Only Active properties will display on UserEnd]</span>
    </div>
</div><div style="clear:both;"></div>
</div>
<br class="clear" />
<?php
//}

//do_meta_boxes($post_type, 'normal', $post);

//( 'page' == $post_type ) ? do_action('edit_page_form') : do_action('edit_form_advanced');

//do_meta_boxes($post_type, 'advanced', $post);

//do_action('dbx_post_sidebar'); ?>

</div>
</div>
<br class="clear" />
</div><!-- /poststuff -->
</form>
</div>

<?php wp_comment_reply(); ?>

<?php if ((isset($post->post_title) && '' == $post->post_title) || (isset($_GET['message']) && 2 > $_GET['message'])) : ?>
<script type="text/javascript">
try{document.post.title.focus();}catch(e){}
</script>
<?php endif; ?>
<script language="javascript" type="text/javascript">
document.getElementById('minor-publishing-actions').style.display = 'none';
document.getElementById('misc-publishing-actions').style.display = 'none';
document.getElementById('delete-action').style.display = 'none';
document.getElementById('publish').value = "Save";

</script>