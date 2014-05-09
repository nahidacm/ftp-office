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

wp_enqueue_script('pagents');

if ( post_type_supports($post_type, 'editor') || post_type_supports($post_type, 'thumbnail') ) {
	add_thickbox();
	wp_enqueue_script('media-upload');
}

/**
 * Post ID global
 * @name $post_ID
 * @var int
 */
$post_ID = isset($post_ID) ? (int) $post_ID : 0;
$temp_ID = isset($temp_ID) ? (int) $temp_ID : 0;
$user_ID = isset($user_ID) ? (int) $user_ID : 0;
$agent_id = $_REQUEST['id'];

if ($agent_id){
	$action = "editagent";
}else{
	$action = "addagent";
}

$messages = array();
$messages['post'] = array(
	 0 => '', // Unused. Messages start at index 1.
	 1 => sprintf( __('Post updated. <a href="%s">View Agent</a>'), esc_url( get_permalink($post_ID) ) ),
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

$form_action = $action;

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
foreach ( get_object_taxonomies($post_type) as $tax_name ) {
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
	add_meta_box('pageparentdiv', 'page' == $post_type ? __('Page Attributes') : __('Attributes'), 'page_attributes_meta_box', $post_type, 'side', 'core');

if ( current_theme_supports( 'post-thumbnails', $post_type ) && post_type_supports( $post_type, 'thumbnail' )
	&& ( ! is_multisite() || ( ( $mu_media_buttons = get_site_option( 'mu_media_buttons', array() ) ) && ! empty( $mu_media_buttons['image'] ) ) ) )
		add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', $post_type, 'side', 'low');

if ( post_type_supports($post_type, 'excerpt') )
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
do_action('do_meta_boxes', $post_type, 'side', $post);

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
<h2><?php echo esc_html( "Agent" ); ?><?php if ( isset( $post_new_file ) ) : ?> <a href="<?php echo esc_url( $post_new_file ) ?>" class="add-new-h2"><?php echo esc_html("Add New Agent"); ?></a><?php endif; ?></h2>
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
<script language="javascript" type="text/javascript">
function validFrm(frm){
	if (frm.full_name.value == ''){
		alert("Please Provide Full Name");
		frm.full_name.focus();
		return false;
	}
	if (frm.contents.value == ''){
		alert("Please Provide Contents");
		frm.contents.focus();
		return false;		
	}

	if (frm.email.value == ''){
		alert("Please Provide Email");
		frm.email.focus();
		return false;		
	}else {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = frm.email.value;
		
		if(reg.test(address) == false) {		
		  alert('Invalid Email Address');
		  frm.email.focus();
		  return false;
		}
	}
	if (frm.phone.value == ''){
		alert("Please Provide Phone Number");
		frm.phone.focus();
		return false;		
	}
	if (frm.display_pos.value == ''){
		alert("Please Provide Display Possition");
		frm.display_pos.focus();
		return false;		
	}
	
	return true;
}
</script>
<form name="pagents" action="pagents.php" method="post" id="pagents" <?php do_action('post_edit_form_tag'); ?> enctype="multipart/form-data" onsubmit="return validFrm(this)">
<?php wp_nonce_field($nonce_action); ?>
<input type="hidden" id="user-id" name="user_ID" value="<?php echo (int) $user_ID ?>" />
<input type="hidden" id="hiddenaction" name="action" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="originalaction" name="originalaction" value="<?php echo esc_attr( $form_action ) ?>" />
<input type="hidden" id="post_author" name="post_author" value="<?php echo esc_attr( $post->post_author ); ?>" />
<input type="hidden" id="post_type" name="post_type" value="<?php echo esc_attr( $post_type ) ?>" />
<input type="hidden" id="original_post_status" name="original_post_status" value="<?php echo esc_attr( $post->post_status) ?>" />
<input type="hidden" id="referredby" name="referredby" value="<?php echo esc_url(stripslashes(wp_get_referer())); ?>" />
<input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>" />
<?php
if ( 'draft' != $post->post_status )
	wp_original_referer_field(true, 'previous');

echo $form_extra;

wp_nonce_field( 'autosave', 'autosavenonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
?>

<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
<div id="side-info-column" class="inner-sidebar">

<?php
('page' == $post_type) ? do_action('submitpage_box') : do_action('submitpost_box');
$side_meta_boxes = do_meta_boxes($post_type, 'side', $post);

//***************----------------------------------------------************************************
//*************** Select Property Data From The Property Table ************************************
//***************----------------------------------------------************************************
global $wpdb;

$agentData 	= $wpdb->get_results( "SELECT * FROM e_p_agent WHERE id = ".$agent_id);
$dposData 	= $wpdb->get_results( "SELECT MAX(display_pos) AS display_pos FROM e_p_agent" );
?>
</div>

<div id="post-body">
<div id="post-body-content">
<div id="titlediv">
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Full Name:*  </label>
	<input type="text" name="full_name" size="60" tabindex="1" style="margin-left:200px;" value="<?php echo esc_attr( htmlspecialchars( $agentData[0]->full_name ) ); ?>" id="full_name" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Designations/Certifications :*</label>
	<input type="text" name="contents" style="margin-left:200px;" size="60" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( $agentData[0]->contents ) ); ?>" id="contents" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Email:* </label>
	<input type="text" name="email" style="margin-left:200px;" size="60" tabindex="3" value="<?php echo esc_attr( htmlspecialchars( $agentData[0]->email ) ); ?>" id="email" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Agent Picture:* </label>
	<input type="file" name="agent_photo" class="Input01" tabindex="4" style="width:200px;margin-left:200px;" id="my_file_element"><span style="font-size:12px;">&nbsp;&nbsp;&nbsp;Width: 150px, Height: 135px</span>
    <br />
    <div style="margin-left:200px;">
    <?php
		$file = 'agent_'.$agent_id.'.jpg';
		$file_path = ABSPATH."up_data/agents/".$file;
		if(file_exists($file_path)){
			echo '<img src="'.site_url()."/up_data/agents/".$file.'" width="100" height="106" />';	
			
			if($del_old_file == '1') $sl = 'checked="checked"';
				echo '<input type="checkbox" name="del_old_file" id="del_old_file" value="1" '.$sl.' /> Delete';	
		}
	?></div>
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Phone :*</label>
	<input type="text" name="phone" style="margin-left:200px;" size="60" tabindex="5" value="<?php echo esc_attr( htmlspecialchars( $agentData[0]->phone ) ); ?>" id="phone" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">



	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Personal Statement: </label>
	<textarea style="width:335px;height:250px;margin-left:200px;" class="Input01" rows="3" tabindex="6" cols="40" wrap="physical" name="personel_statement"><?php echo esc_attr( htmlspecialchars( $agentData[0]->personel_statement ) ); ?></textarea>
</div><div style="clear:both;"></div>
<div id="titlewrap">

	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Display Position:* </label>
	<input type="text" name="display_pos" style="margin-left:200px;" size="2" tabindex="7" value="<?php if ($agent_id){ echo esc_attr( htmlspecialchars( $agentData[0]->display_pos ) ); }else{ echo $dp = esc_attr( htmlspecialchars( $dposData[0]->display_pos )) + 1; }?>" id="display_pos" autocomplete="off" />
</div><div style="clear:both;"></div>
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title" style="font-size:15px;">Status: </label>
	<div style="margin-left:200px;">
    <input type="radio" <?php if ($agentData[0]->status == 1){?> checked="checked" <?php }?> value="1" name="status">Yes
    <input type="radio" <?php if ($agentData[0]->status == 0 || $agentData[0]->status == ''){?> checked="checked" <?php }?> value="0" name="status">No
    </div>
</div><div style="clear:both;"></div>

<div class="inside">
<?php
$sample_permalink_html = $post_type_object->public ? get_sample_permalink_html($post->ID) : '';
$shortlink = wp_get_shortlink($post->ID, 'post');
if ( !empty($shortlink) )
    $sample_permalink_html .= '<input id="shortlink" type="hidden" value="' . esc_attr($shortlink) . '" /><a href="#" class="button" onclick="prompt(&#39;URL:&#39;, jQuery(\'#shortlink\').val()); return false;">' . __('Get Shortlink') . '</a>';

if ( $post_type_object->public && ! ( 'pending' == $post->post_status && !current_user_can( $post_type_object->cap->publish_posts ) ) ) { ?>
	<div id="edit-slug-box">
	<?php
		if ( ! empty($post->ID) && ! empty($sample_permalink_html) && 'auto-draft' != $post->post_status )
			echo $sample_permalink_html;
	?>
	</div>
<?php
}
?>
</div>
<?php
wp_nonce_field( 'samplepermalink', 'samplepermalinknonce', false );
?>
</div>

<?php 
do_meta_boxes($post_type, 'normal', $post);

( 'page' == $post_type ) ? do_action('edit_page_form') : do_action('edit_form_advanced');

do_meta_boxes($post_type, 'advanced', $post);

do_action('dbx_post_sidebar'); ?>

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


jQuery('#side-info-column').attr("style", "position: absolute; right: 20px; z-index: 99;");                
jQuery('#side-info-column').show();

document.getElementById('publish').value = "Save";
</script>