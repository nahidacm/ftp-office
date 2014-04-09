<?php
/**
 * @package WordPress
 * @subpackage WebLionMedia
 * */
error_reporting(0);
//error_reporting(E_ALL);

$themename = "Business News";
$shortname = "pm";

if (!isset($content_width))
    $content_width = '100%';

//Add automatic feed links
add_theme_support('automatic-feed-links');

//Add post-formats to blog posts
add_theme_support('post-formats', array('gallery', 'video'));
add_post_type_support('news', 'post-formats');
add_post_type_support('media', 'post-formats');

//Make theme available for translation. Translations can be filed in the /languages/ directory
load_theme_textdomain('weblionmedia', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/" . $locale . ".php";
if (is_readable($locale_file))
    require_once( $locale_file );

add_theme_support('nav-menus');
if (function_exists('register_nav_menus')) {
    register_nav_menus(
            array(
                'header_top_left_menu' => 'Header Top Left Menu',
                'header_top_right_menu' => 'Header Top Right Menu',
                'main_menu' => 'Main Primary Menu',
                'main_secondary_menu' => 'Main Secondary Menu',
                'footer_menu' => 'Footer Menu'
            )
    );
}

//Set theme custom background 
add_theme_support('custom-background');

//Set theme post thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size(300, 250, true);
add_image_size('slider', 610, 292, true); // basic slider preview, featured image from the media page template
add_image_size('recent_news_homepage', 65, 43, true); // recent news - homepage
add_image_size('recent_news2_homepage', 379, 179, true); // recent news 2 - homepage
add_image_size('best_materials_homepage', 184, 105, true); // best materials - homepage
add_image_size('single_news', 610, 259, true); // single news details page, single blog post page
add_image_size('related_posts', 130, 130, true); // related posts in news details page and in single post page - below the content, also in the news second page template
add_image_size('popular_posts', 46, 46, true); // popular posts in news details page and in single post page - right sidebar
add_image_size('popular_photo', 236, 135, true); // popular photo&video in news details page and in single post page - right sidebar
add_image_size('menu_featured', 107, 107, true); // sub menu featured photo
add_image_size('blog_one', 610, 244, true); // blog one thumb
add_image_size('blog_two', 288, 170, true); // blog two thumb, archives, author page
add_image_size('news_page_one', 290, 170, true); // news one thumb, in news first page template
add_image_size('news_page_two', 256, 122, true); // news two thumb, in news first page template
add_image_size('media_featured', 182, 116, true); // media page, featured small image
add_image_size('media_recent', 132, 86, true); // media page, recent&popular thumbs
add_image_size('media_slider_big', 610, 293, true); // media slider big details page
add_image_size('media_slider_small', 89, 58, true); // media slider small details page

define('JSLIBS', get_template_directory_uri('template_url') . '/functions/js');

//Load theme styles
function my_init_styles() {

    global $shortname;

    //Enqueue custom web fonts 
    wp_enqueue_style('style_default', get_template_directory_uri() . '/style.css', false, '1.0', 'screen');
    wp_enqueue_style('style_custom_webfont1', 'http://fonts.googleapis.com/css?family=PT+Sans:400,700', false, '1.0', 'screen');
    wp_enqueue_style('style_custom_webfont2', 'http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700', false, '1.0', 'screen');
    wp_enqueue_style('style_custom_webfont3', 'http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic', false, '1.0', 'screen');

    //Enqueue custom styles
    wp_enqueue_style('style_prettyphoto', get_template_directory_uri() . '/layout/plugins/prettyphoto/css/prettyPhoto.css', false, '3.1.3', 'screen');
    wp_enqueue_style('style_calendar', get_template_directory_uri() . '/layout/plugins/calendar/calendar.css', false, '1.0.0', 'screen');
    wp_enqueue_style('style_mediaelementplayer', get_template_directory_uri() . '/layout/plugins/video-audio/mediaelementplayer.css', false, '2.9.1', 'screen');

//	if ( is_home() || is_front_page() || is_page_template('template-homepage.php') || (is_single()) ) {
    wp_enqueue_style('style_fliexslider', get_template_directory_uri() . '/layout/plugins/flexslider/flexslider.css', false, '2.1', 'screen');
//	}	

    if (is_page_template('template-registration.php')) {
        wp_enqueue_style('style_ibutton', get_template_directory_uri() . '/layout/plugins/ibuttons/css/jquery.ibutton.css', false, '1.0.03', 'screen');
    }

    wp_enqueue_style('style_wlm_custom', get_template_directory_uri() . '/functions/custom-css-main.php', false, '1.0.0', 'screen');


    //check if the selected font is a common web font not a google web font
    $common_web_fonts_array = array("Arial", "Comic Sans MS", "Courier New", "Georgia", "Lucida Console", "Palatino Linotype", "Tahoma", "Times New Roman", "Verdana");

    $site_headings_font = get_option($shortname . "_site_headings_font");
    if (in_array($site_headings_font, $common_web_fonts_array)) {
        $common_web_fonts_headings = 1;
    } else {
        $common_web_fonts_headings = 0;
    }

    $main_site_menu_font = get_option($shortname . "_main_site_menu_font");
    if (in_array($main_site_menu_font, $common_web_fonts_array)) {
        $common_web_fonts_menu = 1;
    } else {
        $common_web_fonts_menu = 0;
    }

    $secondary_site_menu_font = get_option($shortname . "_secondary_site_menu_font");
    if (in_array($secondary_site_menu_font, $common_web_fonts_array)) {
        $common_web_fonts_menu = 1;
    } else {
        $common_web_fonts_menu = 0;
    }

    // enqueue the site headings font
    if (($site_headings_font != "PT+Sans") && ($site_headings_font != "PT+Sans+Narrow") && ($site_headings_font != "Droid+Serif") &&
            ($site_headings_font) && ($common_web_fonts_headings == 0)) {
        wp_enqueue_style('style_site_headings_font', 'http://fonts.googleapis.com/css?family=' . $site_headings_font, false, '1.0', 'screen');
    }
    if (($main_site_menu_font != "PT+Sans") && ($main_site_menu_font != "PT+Sans+Narrow") && ($main_site_menu_font != "Droid+Serif") &&
            ($main_site_menu_font) && ($common_web_fonts_menu == 0)) {
        wp_enqueue_style('style_main_site_menu_font', 'http://fonts.googleapis.com/css?family=' . $main_site_menu_font, false, '1.0', 'screen');
    }
    if (($secondary_site_menu_font != "PT+Sans") && ($secondary_site_menu_font != "PT+Sans+Narrow") && ($secondary_site_menu_font != "Droid+Serif") &&
            ($secondary_site_menu_font) && ($common_web_fonts_menu == 0)) {
        wp_enqueue_style('style_secondary_site_menu_font', 'http://fonts.googleapis.com/css?family=' . $secondary_site_menu_font, false, '1.0', 'screen');
    }
}

add_action('wp_print_styles', 'my_init_styles');

function my_init_scripts() {
    if (!is_admin()) {

        // jQuery Script
        wp_enqueue_script('jquery');

        // Comment Script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        // Theme scripts
        wp_enqueue_script('jquery_prettyphoto', get_template_directory_uri() . '/layout/plugins/prettyphoto/jquery.prettyPhoto.js', false, '3.1.3', false);
        wp_enqueue_script('jquery_tools_min', get_template_directory_uri() . '/layout/plugins/tools/jquery.tools.min.js', false, '1.2.6', false);
        wp_enqueue_script('jquery_calendar', get_template_directory_uri() . '/layout/plugins/calendar/calendar.js', false, '1.0.0', false);
        wp_enqueue_script('jquery_scrolltomin', get_template_directory_uri() . '/layout/plugins/scrollto/jquery.scroll.to.min.js', false, '1.4.2', false);
        wp_enqueue_script('jquery_mediaelement', get_template_directory_uri() . '/layout/plugins/video-audio/mediaelement-and-player.js', false, '2.9.1', false);

//		if ( is_home() || is_front_page() || is_page_template('template-homepage.php') || (is_single()) ) {
        wp_enqueue_script('jquery_flexslider', get_template_directory_uri() . '/layout/plugins/flexslider/jquery.flexslider-min.js', false, '2.1', false);
//		}

        if (is_page_template('template-registration.php')) {
            wp_enqueue_script('jquery_ibutton', get_template_directory_uri() . '/layout/plugins/ibuttons/lib/jquery.ibutton.min.js', false, '1.0.03', false);
        }

        wp_enqueue_script('jquery_form', get_template_directory_uri() . '/layout/plugins/ajaxform/jquery.form.js', false, '1.3.2', false);
        wp_enqueue_script('jquery_main', get_template_directory_uri() . '/layout/js/main.js', false, '1.0.0', false);
    }
}

add_action('wp_print_scripts', 'my_init_scripts');

function admin_scripts() {
    wp_enqueue_script('slider-add-remove-rows', JSLIBS . '/sidebars_add_remove.js', array('jquery'), '1.0.0');
}

add_action('admin_enqueue_scripts', 'admin_scripts');

//Include custom theme functions
require_once( get_template_directory() . '/functions/dropdown-menus.php' );
require_once( get_template_directory() . '/functions/post-options.php' );
require_once( get_template_directory() . '/functions/page-options.php' );
require_once( get_template_directory() . '/functions/slider-manager.php' );
require_once( get_template_directory() . '/functions/news-manager.php' );
require_once( get_template_directory() . '/functions/media-manager.php' );
require_once( get_template_directory() . '/functions/wp-pagenavi.php' );
require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/slider-functions.php' );
require_once( get_template_directory() . '/functions/slider-functions-posts.php' );
require_once( get_template_directory() . '/functions/slider-functions-news.php' );

//Include custom theme widgets
require_once( get_template_directory() . '/functions/widgets.php' );
require_once( get_template_directory() . '/functions/widget-flickr.php' );
require_once( get_template_directory() . '/functions/widget-tags.php' );
require_once( get_template_directory() . '/functions/widget-popular-news-footer.php' );
require_once( get_template_directory() . '/functions/widget-contact.php' );
require_once( get_template_directory() . '/functions/widget-followers.php' );
require_once( get_template_directory() . '/functions/widget-popular-blog-posts.php' );
require_once( get_template_directory() . '/functions/widget-twitter.php' );
require_once( get_template_directory() . '/functions/widget-newsletter.php' );
require_once( get_template_directory() . '/functions/widget-popular-news-sidebar.php' );
require_once( get_template_directory() . '/functions/widget-googlemap.php' );
require_once( get_template_directory() . '/functions/widget-contact-details.php' );
require_once( get_template_directory() . '/functions/widget-calendar.php' );
require_once( get_template_directory() . '/functions/widget-subpages.php' );
require_once( get_template_directory() . '/functions/widget-popular-video.php' );
require_once( get_template_directory() . '/functions/widget-popular-photo.php' );
require_once( get_template_directory() . '/functions/widget-archives.php' );
require_once( get_template_directory() . '/functions/widget-categories.php' );
require_once( get_template_directory() . '/functions/widget-meta.php' );
require_once( get_template_directory() . '/functions/widget-recent-comments.php' );
require_once( get_template_directory() . '/functions/widget-search.php' );


//Include WordPress admin panel functions
require_once( get_template_directory() . '/admin/admin-functions.php' );
require_once( get_template_directory() . '/admin/admin-interface.php' );
require_once( get_template_directory() . '/admin/theme-settings.php' );

if (!function_exists('weblionmedia_comment')) :

    function weblionmedia_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>

        <!-- the comment -->
        <div class="comment" id="comment-<?php comment_ID(); ?>">
            <div>
                <div class="userpic"><?php echo get_avatar(get_the_author_meta('email'), $size = '36'); ?></div>
                <div class="content">
                    <p class="name"><?php echo get_comment_author_link(); ?></p>
                    <p class="info"><span class="date"><?php echo get_comment_date('M j, Y, g:i a'); ?></span><?php comment_reply_link(array_merge($args, array('class' => 'reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></p>
        <?php comment_text(); ?>
            <?php if ($comment->comment_approved == '0') : ?>
                        <br /><br /><em style="font-weight:bold;color:#F24024; margin-top:20px;"><?php _e('Your comment is awaiting moderation.', 'weblionmedia'); ?></em>
                        <br />
            <?php endif; ?>
                </div>
                <div class="clearboth"></div>
                <div class="line_3"></div>
            </div>		

            <?php
        }

    endif;

    function comment_form_theme($args = array(), $post_id = null) {
        global $user_identity, $id;

        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();

        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields = array(
            'author' => '<p>' . __('Name', 'weblionmedia') . '<span>' . ( $req ? '*' : '' ) . '</span></p>
                          <div class="field"><input type="text" class="req" id="author" name="author" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . '></div>',
            'email' => '<p>' . __('E-mail', 'weblionmedia') . '<span>' . ( $req ? '*' : '' ) . '</span></p>
                        <div class="field"><input type="text" class="req" id="email" name="email" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . '></div>',
            'url' => '<p>' . __('Website', 'weblionmedia') . '</p>
						<div class="field"><input type="text" id="url" name="url" value="' . esc_attr($commenter['comment_author_url']) . '"></div>'
        );

        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', $fields),
            'comment_field' => '<p>' . __('Comment', 'weblionmedia') . '</p>
										<div class="textarea"><textarea id="comment" name="comment" cols="100" rows="5" required></textarea></div>',
            'must_log_in' => '<p style="margin-left:0px;">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'weblionmedia'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
            'logged_in_as' => '<p style="margin-left:0px;">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a><br /><br />', 'weblionmedia'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
            'id_form' => 'cont_form',
            'id_submit' => 'submit',
            'title_reply' => __('Leave a Reply', 'weblionmedia'),
            'title_reply_to' => __('Leave a Reply to %s', 'weblionmedia'),
            'cancel_reply_link' => __('Cancel reply', 'weblionmedia'),
            'label_submit' => __('Submit Comment', 'weblionmedia'),
        );

        $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));
        ?>
    <?php if (comments_open()) : ?>
                <?php do_action('comment_form_before'); ?>
            <!-- end comments -->

            <!-- comment form -->
            <section id="respond" class="reply">
                    <?php if (get_comments_number() > 0) { ?><div class="separator" style="height:30px;"></div><?php } ?>
                <div class="block_leave_reply">
                    <h3><?php _e('Leave a Reply', 'weblionmedia'); ?></h3>
                    <p class="text"><?php _e('Your email address will not be published. Required fields are marked.', 'weblionmedia'); ?> <span>*</span></p>
                        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                            <?php echo $args['must_log_in']; ?>
                            <?php do_action('comment_form_must_log_in_after'); ?>
                        <?php else : ?>
                        <form class="w_validation" action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post">
                            <?php do_action('comment_form_top'); ?>
                            <?php if (is_user_logged_in()) : ?>
                                <?php echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity); ?>
                                <?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
                            <?php else : ?>
                                <?php echo $args['comment_notes_before']; ?>
                                <?php
                                do_action('comment_form_before_fields');
                                foreach ((array) $args['fields'] as $name => $field) {
                                    echo apply_filters("comment_form_field_{$name}", $field) . "\n";
                                }
                                do_action('comment_form_after_fields');
                                ?>
                            <?php endif; ?>
                            <?php echo apply_filters('comment_form_field_comment', $args['comment_field']); ?>

                            <input type="submit" class="general_button" value="<?php _e('Post Comment', 'weblionmedia'); ?>">

                            <?php echo str_replace('<a', '<a class="cancel"', get_cancel_comment_reply_link($args['cancel_reply_link'])); ?>
                            <br /><br />

            <?php comment_id_fields(); ?>
                <?php do_action('comment_form', $post_id); ?>
                        </form>
            <?php endif; ?>
                </div>
            </section><!---/ comment form -->
            <?php do_action('comment_form_after'); ?>
        <?php else : ?>
            <?php do_action('comment_form_comments_closed'); ?>
        <?php endif; ?>
        <?php
    }

// Breadcrumbs function code
    function theme_breadcrumbs() {
        $delimiter = '';
        if (!is_home() && !is_front_page() || is_paged()) {
            global $post;
            global $shortname;
            $home = home_url();

            if (is_category()) {
                global $wp_query;
                global $shortname;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0)
                    echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
                echo '<li>' . __('Archive by category', 'weblionmedia');
                echo ' <strong>';
                single_cat_title();
                echo '</strong>';
                echo '</li>';
            } elseif (is_day()) {
                echo '<li>';
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>';
                echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>';
                echo get_the_time('d');
                echo '</li>';
            } elseif (is_month()) {
                echo '<li>';
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>';
                echo get_the_time('F');
                echo '</li>';
            } elseif (is_year()) {
                echo '<li>';
                echo get_the_time('Y');
                echo '</li>';
            } elseif (is_single() && !is_attachment()) {
                $cat = get_the_category();
                if (!$cat) {
                    if (get_post_type() == 'portfolio') {
                        
                    }
                } else {
                    echo '<li>';
                    echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                    echo '</li>';
                }
                echo '<li>';
                echo get_the_title();
                echo '</li>';
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                echo '<li>';
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
                echo '</li>';
                echo '<li>';
                echo get_the_title();
                echo '</li>';
            } elseif (is_page() && !$post->post_parent) {
                echo '<li>';
                echo get_the_title();
                echo '</li>';
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    echo '<li>';
                echo $crumb . ' ' . $delimiter . ' ';
                echo '</li>';
                echo '<li>';
                echo get_the_title();
                echo '</li>';
            } elseif (is_search()) {
                echo '<li>';
                echo __('Search Results for', 'weblionmedia') . ' &#39;' . get_search_query() . '&#39;';
                echo '</li>';
            } elseif (is_tag()) {
                echo '<li>';
                echo __('Posts tagged', 'weblionmedia') . ' &#39;';
                single_tag_title();
                echo '</li>';
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo '<li>';
                echo __('Articles posted by', 'weblionmedia') . $userdata->display_name;
                echo '</li>';
            } elseif (is_404()) {
                echo '<li>';
                _e('ERROR 404', 'weblionmedia');
                echo '</li>';
            }

            /* if ( get_query_var('paged') ) {
              if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
              if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
              } */
        }
    }

    function add_last_item_class($strHTML) {
        $temp_strHTML = $strHTML;
        $temp_strHTML = str_replace('menu-item-type-post_type ', '', $temp_strHTML);
        $temp_strHTML = str_replace('menu-item-object-page ', '', $temp_strHTML);
        $temp_strHTML = str_replace('menu-item-object-page ', '', $temp_strHTML);
        $temp_strHTML = str_replace('menu-item-type-custom ', '', $temp_strHTML);
        $temp_strHTML = str_replace('menu-item-object-custom ', '', $temp_strHTML);

        $temp_strHTML = str_replace(' current-page-parent', '', $temp_strHTML);
        $temp_strHTML = str_replace(' current_page_parent', '', $temp_strHTML);
        $temp_strHTML = str_replace(' current_page_ancestor', '', $temp_strHTML);

        $temp_strHTML = str_replace('current-menu-item', 'active', $temp_strHTML);
        $temp_strHTML = str_replace('current_page_item"><a', '"><a class="active" ', $temp_strHTML);
        $temp_strHTML = str_replace('current-menu-parent"><a', '"><a class="active"', $temp_strHTML);
        $temp_strHTML = str_replace('menu-item-home ', '', $temp_strHTML);
        $temp_strHTML = str_replace('href="#login"', 'href="#login" class="open_popup"', $temp_strHTML);
        echo $temp_strHTML;
    }

    add_filter('wp_nav_menu', 'add_last_item_class');

    function fallback_default_menu() {
        $all_pages = wp_list_pages("sort_column=menu_order&sort_order=ASC&exclude=" . $exclude . "&title_li=&echo=0");
        $all_pages = str_replace('page_item ', 'menu-item menu-item-type-post_type menu-item-object-page ', $all_pages);
        $all_pages = str_replace('page_item', 'menu-item', $all_pages);

        echo '<ul>' .
        '<li><a href="' . home_url() . '">Home</a></li>
			' . $all_pages . '
		</ul>';
    }

    class topmenu_walker extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth, $args) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
            $class_names = $value = '';
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
            $class_names = ' class="' . esc_attr($class_names) . '"';
            $output .= $indent . '<li id="item-' . $item->ID . '"' . $value . $class_names . '>';
            $indent = '';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            $attributes .=!empty($item->class) ? ' class="' . esc_attr($item->class) . '"' : ' class="left_wrapper"';

            $prepend = '';
            $append = '';
            $description = !empty($item->description) ? '<span>' . esc_attr($item->description) . '</span>' : '';

            if ($depth != 0) {
                $description = $append = $prepend = "";
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $prepend . apply_filters('the_title', $item->title, $item->ID) . $append;
            $item_output .= $description . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

    add_filter('next_post_link', 'add_css_class_to_next_post_link');

    function add_css_class_to_next_post_link($link) {
        $link = str_replace("<a ", "<a class='next-project'  ", $link);
        return $link;
    }

    add_filter('previous_post_link', 'add_css_class_to_previous_post_link');

    function add_css_class_to_previous_post_link($link) {
        $link = str_replace("<a ", "<a class='previous-project'  ", $link);
        return $link;
    }

//enable/disable admin bar for site
    if (get_option($shortname . '_admin_bar') == 'Yes') {
        add_filter('show_admin_bar', '__return_true');
    } else {
        add_filter('show_admin_bar', '__return_false');
    }

//add classes for next and previous post links
    add_filter('next_posts_link_attributes', 'posts_link_attributes_next');
    add_filter('prev_posts_link_attributes', 'posts_link_attributes_prev');

    function posts_link_attributes_prev() {
        return 'class="pager-previous"';
    }

    function posts_link_attributes_next() {
        return 'class="pager-next"';
    }

    add_action('wp_print_styles', 'deregister_cf7_styles', 100);

    function deregister_cf7_styles() {
        if (!is_page(100)) {
            wp_deregister_style('contact-form-7');
        }
    }

// Add specific CSS class by filter
    add_filter('body_class', 'my_body_class_class_names');

    function my_body_class_class_names($classes) {
        global $shortname;
        // add 'class-name' to the $classes array
        unset($classes);
        if (get_option($shortname . "_theme_background") == 'Boxed') {
            $classes[] = 'custom-background boxed"';
        } else {
            $classes[] = 'custom-background';
        }
        // return the $classes array
        return $classes;
    }

    function shortcode_empty_paragraph_fix($content) {
        $array = array(
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }

    add_filter('the_content', 'shortcode_empty_paragraph_fix');

//Show Post Views Count on Posts Without Any Plugin in WordPress
    function getPostViews($postID) {
        $count_key = "post_views_count";
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 ";
        }
        return $count;
    }

    function setPostViews($postID) {
        $count_key = "post_views_count";
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);    //$sql = "UPDATE wp_postmeta		//		SET meta_value = '$count'		//		WHERE post_id = $postID AND meta_key = 'post_views_count'";		//				//$table = 'wp_postmeta';				//$data = array('meta_value' => $count);		//$where = array('post_id' => $postID, 'meta_key' => 'post_views_count');				//				//echo $sql;		//			//$posts = $wpdb->update($table, $data, $where);				//return $posts;
        }
    }

    /* add extra inputs for user profile */
    add_action('show_user_profile', 'my_show_extra_profile_fields');
    add_action('edit_user_profile', 'my_show_extra_profile_fields');

    function my_show_extra_profile_fields($user) {
        ?>

        <h3>Extra profile information</h3>

        <table class="form-table">

            <tr>
                <th><label for="twitter">Gender</label></th>
                <td>
                    <select name="user_gender" id="user_gender">
                        <option>&nbsp;</option>
                        <option<?php if (esc_attr(get_the_author_meta('user_gender', $user->ID)) == 'Female') echo ' selected="selected"'; ?>>Female</option>
                        <option<?php if (esc_attr(get_the_author_meta('user_gender', $user->ID)) == 'Male') echo ' selected="selected"'; ?>>Male</option>
                    </select><br />
                    <span class="description">Please select your Gender.</span>
                </td>
            </tr>	
            <tr>
                <th><label for="twitter">User Profession</label></th>
                <td>
                    <input type="text" name="user_position" id="user_position" value="<?php echo esc_attr(get_the_author_meta('user_position', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Profession (ex: <strong>Web Designer</strong>).</span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter">Facebook</label></th>
                <td>
                    <input type="text" name="user_facebook" id="user_facebook" value="<?php echo esc_attr(get_the_author_meta('user_facebook', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Facebook URL.</span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter">Twitter</label></th>
                <td>
                    <input type="text" name="user_twitter" id="user_twitter" value="<?php echo esc_attr(get_the_author_meta('user_twitter', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Twitter URL.</span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter">Fr</label></th>
                <td>
                    <input type="text" name="user_fr" id="user_fr" value="<?php echo esc_attr(get_the_author_meta('user_fr', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Fr URL.</span>
                </td>
            </tr>
            <tr>
                <th><label for="twitter">Vimeo</label></th>
                <td>
                    <input type="text" name="user_vimeo" id="user_vimeo" value="<?php echo esc_attr(get_the_author_meta('user_vimeo', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your Vimeo URL.</span>
                </td>
            </tr>
            <!--tr>
                    <th><label for="twitter">Google+</label></th>
                    <td>
                            <input type="text" name="user_gplus" id="user_gplus" value="<?php echo esc_attr(get_the_author_meta('user_gplus', $user->ID)); ?>" class="regular-text" /><br />
                            <span class="description">Please enter your Google+ URL.</span>
                    </td>
            </tr-->
            <tr>
                <th><label for="twitter">RSS</label></th>
                <td>
                    <input type="text" name="user_rss" id="user_rss" value="<?php echo esc_attr(get_the_author_meta('user_rss', $user->ID)); ?>" class="regular-text" /><br />
                    <span class="description">Please enter your RSS URL.</span>
                </td>
            </tr>
        </table>
    <?php
    }

    add_action('personal_options_update', 'my_save_extra_profile_fields');
    add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

    function my_save_extra_profile_fields($user_id) {
        if (!current_user_can('edit_user', $user_id))
            return false;
        update_user_meta($user_id, 'user_gender', $_POST['user_gender']);
        update_user_meta($user_id, 'user_position', $_POST['user_position']);
        update_user_meta($user_id, 'user_facebook', $_POST['user_facebook']);
        update_user_meta($user_id, 'user_twitter', $_POST['user_twitter']);
        update_user_meta($user_id, 'user_fr', $_POST['user_fr']);
        //update_user_meta( $user_id, 'user_vimeo', $_POST['user_vimeo'] );
        update_user_meta($user_id, 'user_gplus', $_POST['user_gplus']);
        update_user_meta($user_id, 'user_rss', $_POST['user_rss']);
    }

    add_action('media_buttons', 'add_sc_select', 11);

    function add_sc_select() {
        global $shortcode_tags;
        /* ------------------------------------- */
        /* enter names of shortcode to exclude bellow */
        /* ------------------------------------- */
        $exclude = array("wp_caption", "embed");
        echo '&nbsp;<select id="sc_select"><option value="">&nbsp;*Select Shortcode*&nbsp;</option>';
        $shortcodes_list .= '<option value="' . "[special_topic name='' url='' title='' margin_bottom='']" . '">Special Topic</option>';
        $shortcodes_list .= '<option value="' . "[slider slider_name='' slider_id='' count='']" . '">Slider</option>';
        $shortcodes_list .= '<option value="' . "[small_slider slider_name='' slider_id='' count='']" . '">Slider Small</option>';

        $shortcodes_list .= '<option value="' . "[slider_news slider_name='' count='']" . '">Slider News</option>';
        $shortcodes_list .= '<option value="' . "[slider_news_byid slider_name='' count='' id_array='190,200,203']" . '">Slider News By IDs</option>';
        $shortcodes_list .= '<option value="' . "[small_slider_news slider_name='' count='']" . '">Slider Small News</option>';
        $shortcodes_list .= '<option value="' . "[recent_news_slider count='9' catid='']" . '">Recent News Slider</option>';
        $shortcodes_list .= '<option value="' . "[recent_news count='' catid='']" . '">Recent News 1st</option>';
        $shortcodes_list .= '<option value="' . "[recent_news2 title='' count='' catid='' content_length='']" . '">Recent News 2nd</option>';
        $shortcodes_list .= '<option value="' . "[best_news_slider_byid title='' sliderid='some_unique_id' id_array='1,2,3,4,5,6,7']" . '">Best News Slider By IDs</option>';
        $shortcodes_list .= '<option value="' . "[best_news_slider_bycat title='' count='' catid='' sliderid='some_unique_id']" . '">Best News Slider By Category</option>';
        $shortcodes_list .= '<option value="' . "[best_news_slider_bycomments title='' sliderid='some_unique_id' count='']" . '">Best News Slider By Comments</option>';

        $shortcodes_list .= '<option value="' . "[slider_posts slider_name='' count='']" . '">Slider Posts</option>';
        $shortcodes_list .= '<option value="' . "[slider_posts_byid slider_name='' count='' id_array='17,45,114']" . '">Slider Posts By IDs</option>';
        $shortcodes_list .= '<option value="' . "[small_slider_posts slider_name='' count='']" . '">Slider Small Posts</option>';
        $shortcodes_list .= '<option value="' . "[recent_posts_slider count='9' catid='']" . '">Recent Posts Slider</option>';
        $shortcodes_list .= '<option value="' . "[recent_posts count='6' catid='41' onecolumn='two']" . '">Recent Posts 1st</option>';
        $shortcodes_list .= '<option value="' . "[recent_posts2 title='Recent Posts' count='4' catid='41' content_length='']" . '">Recent Posts 2nd</option>';
        $shortcodes_list .= '<option value="' . "[best_posts_slider_byid title='' id_array='1,190,193' sliderid='some_unique_id']" . '">Best Posts Slider By IDs</option>';
        $shortcodes_list .= '<option value="' . "[best_posts_slider_bycat title='' catid='' count='6' sliderid='some_unique_id']" . '">Best Posts Slider By Category</option>';
        $shortcodes_list .= '<option value="' . "[best_posts_slider_bycomments title='' count='6' sliderid='some_unique_id']" . '">Best Posts Slider By Comments</option>';

        $shortcodes_list .= '<option value="' . "[organictabs_news userecent='yes|no' usepopular='yes|no' usecomment='yes|no' countposts='5' countcomments='5']" . '">Organic News Tabs</option>';
        $shortcodes_list .= '<option value="' . "[organictabs_blog userecent='yes|no' usepopular='yes|no' usecomment='yes|no' countposts='5' countcomments='5']" . '">Organic Blog Tabs</option>';
        $shortcodes_list .= '<option value="' . "[gallery postid='' width='' height='']" . '">Gallery</option>';
        $shortcodes_list .= '<option value="' . "[line margin_top='' margin_bottom='' margin_left='' margin_right='']" . '">Line 1st</option>';
        $shortcodes_list .= '<option value="' . "[line2 margin_top='' margin_bottom='' margin_left='' margin_right='']" . '">Line 2nd</option>';
        $shortcodes_list .= '<option value="' . "[line3 margin_top='' margin_bottom='' margin_left='' margin_right='']" . '">Line 3rd</option>';
        $shortcodes_list .= '<option value="' . "[googlemap src='' width='' height='']" . '">Google Map</option>';
        $shortcodes_list .= '<option value="' . "[button_standard title='Submit' url='' type='1|2|3|4|5|6|7|8']" . '">Button Standard</option>';
        $shortcodes_list .= '<option value="' . "[button_icons title='Submit' url='' type='search|approve|remove|calendar|mail|comment|like|edit|favourite|registration|tag|settings|apply|info|play|open']" . '">Button With Icons </option>';
        $shortcodes_list .= '<option value="' . "[pricelist pricing_items='Storage|RAM|SSH|MySQL|Traffic|POP3&SMPT|Speed|Emails Acounts']
[price_item title='Basic' price='$20' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up' pricing_items='20GB Storage|256MB Ram|uncheckicon|checkicon|500 Gb|checkicon|100Mb/sec|100|']
[price_item title='Standard' price='$40' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up' column_type='medium' pricing_items='40GB Storage|512MB Ram|uncheckicon|checkicon|1000 Gb|checkicon|100Mb/sec|unlimited|']
[price_item premium='premium' title='Premium' price='$52' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up'  column_type='special' pricing_items='60GB Storage|1024MB Ram|checkicon|checkicon|1500 Gb|checkicon|100Mb/sec|unlimited|']
[/pricelist]" . '">Price List 1st</option>';
        $shortcodes_list .= '<option value="' . "[pricelist2]
[price_item title='Basic' price='$20' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up' pricing_items='20GB Storage|256MB Ram|uncheckicon|checkicon|500 Gb|checkicon|100Mb/sec|100|']
[price_item title='Standard' price='$40' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up' column_type='medium' pricing_items='40GB Storage|512MB Ram|uncheckicon|checkicon|1000 Gb|checkicon|100Mb/sec|unlimited|']
[price_item premium='premium' title='Premium' price='$52' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up'  column_type='special' pricing_items='60GB Storage|1024MB Ram|checkicon|checkicon|1500 Gb|checkicon|100Mb/sec|unlimited|']
[price_item premium='premium' title='Business' price='$80' price_info='per month' button_url='http://www.themeforest.com' button_text='Sign Up'  column_type='medium' pricing_items='150GB Storage|2048MB Ram|checkicon|checkicon|20000 Gb|checkicon|100Mb/sec|unlimited|']
[/pricelist2]" . '">Price List 2nd</option>';
        $shortcodes_list .= '<option value="' . "[image align='left|right' border='yes|no' src='' title='' width='' height='']" . '">Image</option>';
        $shortcodes_list .= '<option value="' . "[audio url='']" . '">Audio</option>';
        $shortcodes_list .= '<option value="' . "[vimeo url='' width='' height='']" . '">Vimeo Video</option>';
        $shortcodes_list .= '<option value="' . "[youtube url='' width='' height='']" . '">YouTube Video	</option>';
        $shortcodes_list .= '<option value="' . "[list type='1|2|3|4|5|6']
	<ul>
		<li><a href='#'>Established fact that a reader.</a></li>
		<li><a href='#'>Distracted by the readable.</a></li>
		<li><a href='#'>When looking at its layout.</a></li>
		<li><a href='#'>Has a more-or-less normal.</a></li>
		<li>Distribution of letters.</li>
	</ul>
[/list]" . '">List</option>';
        $shortcodes_list .= '<option value="' . "[tabs titles='Planning|Development|Support' type='1']
[tab]Randomised words which don't look even slightly believable. If you are going to use a passage. You need to be sure there isn't anything embarrassing hidden in the middle of text established fact that a reader will be istracted by the readable content of a page when looking at its layout.[/tab]
[tab]Fact reader will be distracted by the <a href='#' class='main_link'>readable content of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have evolved over. There are many variations of passages of Lorem Ipsum available, but the majority.[/tab]
[tab]Distracted by the  readable content  of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have  evolved over.  There are many variations of passages of Lorem Ipsum available.[/tab]
[/tabs]" . '">Tabs 1st</option>';
        $shortcodes_list .= '<option value="' . "[tabs titles='Planning|Development|Support' type='2']
[tab]Randomised words which don't look even slightly believable. If you are going to use a passage. You need to be sure there isn't anything embarrassing hidden in the middle of text established fact that a reader will be istracted by the readable content of a page when looking at its layout.[/tab]
[tab]Fact reader will be distracted by the <a href='#' class='main_link'>readable content of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have evolved over. There are many variations of passages of Lorem Ipsum available, but the majority.[/tab]
[tab]Distracted by the  readable content  of a page when. Looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content here, content here, making it look like readable English will uncover many web sites still in their infancy. Various versions have  evolved over.  There are many variations of passages of Lorem Ipsum available.[/tab]
[/tabs]" . '">Tabs 2nd</option>';
        $shortcodes_list .= '<option value="' . "[infobox type='error|info|warning|success' title='Note:']Insert any text here.[/infobox]" . '">Infobox</option>';
        $shortcodes_list .= '<option value="' . "[testimonial name='' position='']Testimonial content.[/testimonial]" . '">Testimonial</option>';
        $shortcodes_list .= '<option value="' . "[dropcap type='1|2|3|4|5']A[/dropcap]" . '">Dropcaps</option>';
        $shortcodes_list .= '<option value="' . "[one_half]<p>Content...</p>[/one_half]
[one_half_last]<p>Content...</p>[/one_half_last]" . '">Column 1/2+1/2</option>';
        $shortcodes_list .= '<option value="' . "[one_third]<p>Content...</p>[/one_third]
[one_third]<p>Content...</p>[/one_third]
[one_third_last]<p>Content...</p>[/one_third_last]" . '">Column 1/3+1/3+1/3</option>';
        $shortcodes_list .= '<option value="' . "[one_fourth]<p>Content...</p>[/one_fourth]
[one_fourth]<p>Content...</p>[/one_fourth]
[one_fourth]<p>Content...</p>[/one_fourth]
[one_fourth_last]<p>Content...</p>[/one_fourth_last]" . '">Column 1/4+1/4+1/4+1/4</option>';
        $shortcodes_list .= '<option value="' . "[one_third]<p>Content...</p>[/one_third]
[two_third_last]<p>Content...</p>[/two_third_last]" . '">Column 1/3+2/3</option>';
        $shortcodes_list .= '<option value="' . "[one_fifth]<p>Content...</p>[/one_fifth]
[one_fifth]<p>Content...</p>[/one_fifth]
[one_fifth]<p>Content...</p>[/one_fifth]
[one_fifth]<p>Content...</p>[/one_fifth]
[one_fifth_last]<p>Content...</p>[/one_fifth_last]" . '">Column 1/5+1/5+1/5+1/5+1/5</option>';
        $shortcodes_list .= '<option value="' . "[one_sixth]<p>Content...</p>[/one_sixth]
[one_sixth]<p>Content...</p>[/one_sixth]
[one_sixth]<p>Content...</p>[/one_sixth]
[one_sixth]<p>Content...</p>[/one_sixth]
[one_sixth]<p>Content...</p>[/one_sixth]
[one_sixth_last]<p>Content...</p>[/one_sixth_last]" . '">Column 1/6+1/6+1/6+1/6+1/6+1/6</option>';
        $shortcodes_list .= '<option value="' . "[full_width]Content...[/full_width]" . '">Coumn Full Width</option>';
        $shortcodes_list .= '<option value="' . "[table type='1']
<table>
	<thead>
		<tr>
			<th class='first-th'>Header 1</th>
			<th>Header 2</th>
			<th>Header 3</th>
			<th class='last-th'>Header 4</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class='first-td'>Item #1</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>100 Gb</td>
			<td class='last-td'>100 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #2</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>200 Gb</td>
			<td class='last-td'>200 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #3</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>300 Gb</td>
			<td class='last-td'>300 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #4</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>400 Gb</td>
			<td class='last-td'>400 Gb</td>
		</tr>
		<tr class='last-row'>
			<td class='first-td'>Item #5</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>500 Gb</td>
			<td class='last-td'>500 Gb</td>
		</tr>
	</tbody>
</table>
[/table]
" . '">Table 1st</option>';
        $shortcodes_list .= '<option value="' . "[table type='2']
<table>
	<thead>
		<tr>
			<th class='first-th'>Header 1</th>
			<th>Header 2</th>
			<th>Header 3</th>
			<th class='last-th'>Header 4</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class='first-td'>Item #1</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>100 Gb</td>
			<td class='last-td'>100 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #2</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>200 Gb</td>
			<td class='last-td'>200 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #3</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>300 Gb</td>
			<td class='last-td'>300 Gb</td>
		</tr>
		<tr>
			<td class='first-td'>Item #4</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>400 Gb</td>
			<td class='last-td'>400 Gb</td>
		</tr>
		<tr class='last-row'>
			<td class='first-td'>Item #5</td>
			<td><span class='desc-container' title='Established fact that a reader will be distracted by the readable  when. Looking at its layout.'>Description</span></td>
			<td>500 Gb</td>
			<td class='last-td'>500 Gb</td>
		</tr>
	</tbody>
</table>
[/table]
" . '">Table 2nd</option>';
        $shortcodes_list .= '<option value="' . "[highlight type='1|2|3']text here...[/highlight]" . '">Highlight / Cite Text </option>';
        $shortcodes_list .= '<option value="' . "[blockquote align='left|right|full']Content...[/blockquote]" . '">Blockquote</option>';
        $shortcodes_list .= '<option value="' . "[accordion]
	[accordion_item first='first' title='']Content...[/accordion_item]
	[accordion_item title='']Content...[/accordion_item]
	[accordion_item title='']Content...[/accordion_item]
[/accordion]" . '">Accordion 1st</option>';
        $shortcodes_list .= '<option value="' . "[accordion2]
	[accordion_item2 first='first' title='']Content...[/accordion_item2]
	[accordion_item2 title='']Content...[/accordion_item2]
	[accordion_item2 title='']Content...[/accordion_item2]
[/accordion2]" . '">Accordion 2nd</option>';
        $shortcodes_list .= '<option value="' . "[block_staff title='Staff of the journal' 
url_1='http://www.themeforest.net' avatar_url_1='/images/ava_default_1.jpg' position_1='Staf Member 1' name_1='Roman Polyarush' 
url_2='http://www.themeforest.net' avatar_url_2='/images/ava_default_2.jpg' position_2='Staf Member 2' name_2='Roman Polyarush' 
url_3='http://www.themeforest.net' avatar_url_3='/images/ava_default_3.jpg' position_3='Staf Member 3' name_3='Roman Polyarush' 
url_4='http://www.themeforest.net' avatar_url_4='/images/ava_default_4.jpg' position_4='Staf Member 4' name_4='Roman Polyarush' 
url_5='http://www.themeforest.net' avatar_url_5='/images/ava_default_5.jpg' position_5='Staf Member 5' name_5='Roman Polyarush' 
url_6='http://www.themeforest.net' avatar_url_6='/images/ava_default_6.jpg' position_6='Staf Member 6' name_6='Roman Polyarush']" . '">Staff Block</option>';
        $shortcodes_list .= '<option value="' . "[title_center title='']" . '">Title Center </option>';
        $shortcodes_list .= '<option value="' . "[general_subtitle]Content...[/general_subtitle]" . '">General SubTitle</option>';

        echo $shortcodes_list;
        echo '</select>';
    }

    add_action('admin_head', 'button_js');

    function button_js() {
        echo '<script type="text/javascript">
	jQuery(document).ready(function(){
	   jQuery("#sc_select").change(function() {
			  send_to_editor(jQuery("#sc_select :selected").val());
        		  return false;
		});
	});
	</script>';
    }

    function date_french($format, $timestamp = null) {
        $param_D = array('', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
        $param_l = array('', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        $param_F = array('', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
        $param_M = array('', 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec');

        $return = '';
        if (is_null($timestamp)) {
            $timestamp = mktime();
        }
        for ($i = 0, $len = strlen($format); $i < $len; $i++) {
            switch ($format[$i]) {
                case '\\' : // fix.slashes
                    $i++;
                    $return .= isset($format[$i]) ? $format[$i] : '';
                    break;
                case 'D' :
                    $return .= $param_D[date('N', $timestamp)];
                    break;
                case 'l' :
                    $return .= $param_l[date('N', $timestamp)];
                    break;
                case 'F' :
                    $return .= $param_F[date('n', $timestamp)];
                    break;
                case 'M' :
                    $return .= $param_M[date('n', $timestamp)];
                    break;
                default :
                    $return .= date($format[$i], $timestamp);
                    break;
            }
        }
        return $return;
    }

// Adding Shortcodes to the_excerpt() function
    add_filter('the_excerpt', 'do_shortcode');
// Enable shortcodes in widgets
    add_filter('widget_text', 'do_shortcode');
    ?>