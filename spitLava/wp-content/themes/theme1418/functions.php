<?php

$functions_path = TEMPLATEPATH . '/functions/';

$includes_path = TEMPLATEPATH . '/includes/';



//Loading jQuery and Scripts

require_once $includes_path . 'theme-scripts.php';



//Widget and Sidebar

require_once $includes_path . 'sidebar-init.php';

require_once $includes_path . 'register-widgets.php';



//Theme initialization

require_once $includes_path . 'theme-init.php';



//Additional function

require_once $includes_path . 'theme-function.php';



//Shortcodes

require_once $includes_path . 'theme_shortcodes/shortcodes.php';

include_once(TEMPLATEPATH . '/includes/theme_shortcodes/alert.php');

include_once(TEMPLATEPATH . '/includes/theme_shortcodes/tabs.php');

include_once(TEMPLATEPATH . '/includes/theme_shortcodes/toggle.php');

include_once(TEMPLATEPATH . '/includes/theme_shortcodes/html.php');



//tinyMCE includes

include_once(TEMPLATEPATH . '/includes/theme_shortcodes/tinymce/tinymce_shortcodes.php');





















// removes detailed login error information for security
//add_filter('login_errors',create_function('$a', "return null;"));



if (!function_exists('optionsframework_init')) {





    /* ----------------------------------------------------------------------------------- */

    /* Options Framework Theme

      /*----------------------------------------------------------------------------------- */



    /* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */



    if (STYLESHEETPATH == TEMPLATEPATH) {

        define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');

        define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
    } else {

        define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');

        define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/admin/');
    }



    require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}



// Removes Trackbacks from the comment cout

add_filter('get_comments_number', 'comment_count', 0);

function comment_count($count) {

    if (!is_admin()) {

        global $id;

        $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));

        return count($comments_by_type['comment']);
    } else {

        return $count;
    }
}

// enable shortcodes in sidebar

add_filter('widget_text', 'do_shortcode');

// custom excerpt ellipses for 2.9+

function custom_excerpt_more($more) {

    return 'Read More &raquo;';
}

add_filter('excerpt_more', 'custom_excerpt_more');

// no more jumping for read more link

function no_more_jumping($post) {

    return '&nbsp;<a href="' . get_permalink($post->ID) . '" class="read-more">' . 'Continue Reading' . '</a>';
}

add_filter('excerpt_more', 'no_more_jumping');

// category id in body and post class

function category_id_class($classes) {

    global $post;

    foreach ((get_the_category($post->ID)) as $category)
        $classes [] = 'cat-' . $category->cat_ID . '-id';

    return $classes;
}

add_filter('post_class', 'category_id_class');

add_filter('body_class', 'category_id_class');


register_sidebar(array(
    'name' => 'Header Social Link',
    'id' => 'header-social-link',
    'description' => 'Widgets in this area will be shown on the Header.',
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));


register_sidebar(array(
    'name' => 'Home Row 1',
    'id' => 'home-row-1',
    'description' => 'Widgets in this area will be shown on the Header.',
));
register_sidebar(array(
    'name' => 'Home Row 2',
    'id' => 'home-row-2',
    'description' => 'Widgets in this area will be shown on the Header.',
));
register_sidebar(array(
    'name' => 'Home Row 3',
    'id' => 'home-row-3',
    'description' => 'Widgets in this area will be shown on the Header.',
));

// custom
// A glitch in WP means that  edit_posts is required before custom posts can work. However, adding   edit_posts  throws up some unwanted menu items.
// Menus are either top level   menu  or  lower level  submenu. The code below shows how to remove menu items. I couldn't manage to remove submenus.
// Removing menus or submenus doesn't prevent users pasting urls into the browser and accessing things.  The code  below also prevents that happenning.
//Thanks to:  http://www.shinephp.com/how-to-block-wordpress-admin-menu-item/
// Thanks to Grimbog http://wordpress.org/support/topic/how-to-get-the-current-logged-in-users-role?replies=10

function get_user_role() {
    global $current_user;
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}

if (( is_user_logged_in()) && (get_user_role() == 'subscriber')) { // If the user has the role   Reviewer  then remove these menu items

    function removeMenu() {
        global $menu; //    ****************** Find the numbers corresponding to the menu items to remove in   wp-admin/menu.php **********
        unset($menu[2]); // remove dashboard menu
        unset($menu[5]); // remove post menu
        unset($menu[25]); // remove comments menu
        unset($menu[75]); // remove tools menu
        unset($menu[100]);
    }

    add_action('admin_head', 'removeMenu');

    function menu_redirect() { // Redirect links. Thanks to   Vladimir Garagulya at  http://www.shinephp.com/how-to-block-wordpress-admin-menu-item/
// Although menu items have been removed a user could still paste in the url for that menu item and go to that page. This redirects such urls back to the dashboard.
// Before removing the menu items click on each one and copy the relevant urls. Take the last bit of each url and paste into either   $linksToAllow = array
// or $linksToBlock = array    (below)
// Again, before removing the menu items, check that the above code works when you click on each menu item.
// edit.php    is not redirected for some reason.
// If the user pastes    edit.php     onto the end of /wp-admin/ they can see a list of all the posts that have been published.
// However, they can't do anything with that list of posts. And trying to add a new post redirects them back to the dashboard.
// It's not ideal. Redirecting edit.php back to the dashboard would be better.
        $result = false;
        $linksToAllow = array('edit.php?post_type=portfolio', 'post-new.php?post_type=portfolio');    // Links to allow
        foreach ($linksToAllow as $key => $value) {
            $result = stripos($_SERVER['REQUEST_URI'], $value);
            if ($result !== false) {
                $result = 'blah';
                break;
            }
        }

        if ($result !== blah) {
            $linksToBlock = array('edit.php', 'post-new.php', 'tools.php', 'edit-comments.php');   // Links to block (i.e. to redirect back to wp-admin/index.php)
            foreach ($linksToBlock as $key => $value) {
                $result = stripos($_SERVER['REQUEST_URI'], $value);
                if ($result !== false) {
                    $result = 'something';
                    break;
                }
            }
        }

        if ($result == something) {
            wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
        }
    }

    add_action('admin_menu', 'menu_redirect');
}

if (( is_user_logged_in()) && (get_user_role() == 'subscriber')) {
    add_action('admin_init', 'my_remove_menu_pages2');

    function my_remove_menu_pages2() {
        remove_menu_page('upload.php');
    }

    add_filter('show_admin_bar', '__return_false');
}



if (!current_user_can('manage_options') && (get_user_role() != 'editor')) {

    function auto_media() {
        echo '<style type="text/css">
        #media-items .savesend input.button, #gallery-settings * {display:none;}
		#wp-content-media-buttons { display: none; }
		ul.subsubsub li{ display:none; }
		ul.subsubsub li.mine{ display:block; }
		
    </style>';
    }

    add_action('admin_head', 'auto_media');
}

function removeMenu3() {
    remove_submenu_page('index.php', 'update-core.php');
}

add_action('admin_head', 'removeMenu3');

if (!current_user_can('manage_options') && (get_user_role() != 'editor')) {
    add_filter('user_can_richedit', create_function('$a', 'return false;'), 50);
}

add_filter('logout_url', 'projectivemotion_logout_home', 10, 2);

function projectivemotion_logout_home($logouturl, $redir) {
    $redir = get_option('siteurl');
    return $logouturl . '&amp;redirect_to=' . urlencode($redir);
}

function sl_rating_custom_box_readonly() {
    add_meta_box(
            'ffpc_video_sectionid2', 'Admin Rating:', 'sl_rating_inner_custom_box_readonly', 'portfolio', 'normal', 'high'
    );
}

if (!current_user_can('manage_options') && (get_user_role() != 'editor')) {


    function sl_rating_inner_custom_box_readonly($post) {

        echo 'Admin Rating:<br/>';
        $rating = get_post_meta($post->ID, 'sl_rating', true) / 5;


        echo "<div style='padding:20px;'>";
        echo "Admin has rated this video to $$rating mic(s).";
        echo "</div>";
    }

    add_action('add_meta_boxes', 'sl_rating_custom_box_readonly');
}

if (!current_user_can('manage_options') && (get_user_role() != 'editor')) {

    function remove_screen_options() {
        return false;
    }

    add_filter('screen_options_show_screen', 'remove_screen_options');
}

// featured image meta box
add_action('do_meta_boxes', 'customposttype_image_box');

function customposttype_image_box() {

    remove_meta_box('postimagediv', 'portfolio', 'side');

    add_meta_box('postimagediv', __('If your video\'s first frame is blank, upload a thumbnail here:'), 'post_thumbnail_meta_box', 'portfolio', 'normal', 'high');
}

// move featured image meta box end
//text change
function spitlava_featured_image_alttext($translation, $text, $domain) {
    global $post;
    if ($post->post_type == 'portfolio') {
        $translations = &get_translations_for_domain($domain);
        if ($text == 'Featured Image') {
            return $translations->translate('Thumbnail Image');
        }
        if ($text == 'Set featured image') {
            return $translations->translate('Upload thumbnail image');
        }
        if ($text == 'Remove featured image') {
            return $translations->translate('Remove thumbnail image');
        }
    }
    return $translation;
}

add_filter('gettext', 'spitlava_featured_image_alttext', 10, 4);

// custom admin login logo
function custom_login_logo() {
    echo '<style type="text/css">
	h1 a { background-image: url(' . get_bloginfo('template_directory') . '/images/logo_spit_lava.png) !important; }
	</style>';
}

add_action('login_head', 'custom_login_logo');

// text change
// Added on 04/02/2013
if (!current_user_can('manage_options') && (get_user_role() != 'editor')) {

    function comment_hide() {
        echo '<style type="text/css">
		#commentsdiv { display: none; }
		#wordpress-https { display: none; }
		#commentstatusdiv { display: none; }
		</style>';
    }

    add_action('admin_head', 'comment_hide');
}

function getLatestVideo() {
    $args = array(
        'numberposts' => 1,
        'offset' => 0,
        'orderby' => 'post_date',
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'suppress_filters' => true);

    $recent_posts = wp_get_recent_posts($args);

    return $recent_posts[0];
}

function getTop3video() {
    $args = array(
    'numberposts' => 3,
    'offset' => 0,
    'orderby' => 'post_date',
    'post_type' => 'portfolio',
    'meta_key' => 'TopThree',
    'meta_value' => 'yes',
    'post_status' => 'publish',
    'suppress_filters' => true );

    $top_videos = wp_get_recent_posts($args);

    return $top_videos;
}

?>