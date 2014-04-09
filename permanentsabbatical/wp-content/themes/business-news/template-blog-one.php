<?php
/*
  Template Name: Blog One
 */
get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <div class="general_subtitle">
        <?php the_content(); ?>
    </div>
<?php endwhile; // end of the loop. ?>

<div class="line_4" style="margin:0px 0px 0px;"></div>
<div class="block_blog_1">

    <?php
    $count = get_option($shortname . '_blog_one_posts_count');
    $count = (!$count) ? '-1' : $count;
    $orderby = get_option($shortname . '_blog_order_by');
    $order = get_option($shortname . '_blog_order');

    $thePostID = $post->ID;
    $get_custom_options = get_option($shortname . '_blog_page_id');
    $cat_id_inclusion = trim($get_custom_options['blog_to_cat_' . $thePostID]);

    $type = 'post';
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => $count,
        'cat' => $cat_id_inclusion,
        'category__not_in' => array(59, 45),
        'orderby' => $orderby,
        'order' => $order,
        'paged' => $paged
    );

    $wp_query = new WP_Query($args);
    if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $get_attachment_preview_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog_one', false);
            $blog_image_preview = $get_attachment_preview_src[0];

            //get the custom field for post format
            $custom = get_post_custom($post->ID);
            $custom_post_format_url = trim($custom["custom_post_format"][0]);
            ?>						
            <article class="blog_post">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="tail"></div>
                    <?php if ($blog_image_preview) { ?>
                        <div class="f_pic"><a href="<?php the_permalink(); ?>" class="general_pic_hover zoom"><img width="100%" src="<?php echo $blog_image_preview; ?>"></a></div>
                    <?php } ?>

                    <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                    <div class="info">
                        <div class="date"><p><a href="#"><?php echo get_the_time('d F, Y'); ?></a></p></div>
                        <div class="author"><p><?php _e('By:', 'weblionmedia'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php if (!get_the_author_meta('first_name') && !get_the_author_meta('last_name')) {
                the_author_posts_link();
            } else {
                echo get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
            } ?></a></p></div>

                        <div class="r_part">
                            <div class="category">
                                <p class="text"><?php _e('Category:', 'weblionmedia'); ?></p>
                                <ul>
                                    <li><?php the_category('&nbsp;') ?></li>
                                </ul>
                            </div>

        <?php if (get_option($shortname . '_blog_post_views') == 'true') { ?><a href="#" class="views"><?php echo getPostViews(get_the_ID()); ?></a><?php } ?>
                            <a href="#" class="comments"><?php comments_number(__('0', 'weblionmedia'), __('1', 'weblionmedia'), __('%', 'weblionmedia')); ?></a>
                        </div>
                    </div>

                    <div class="content"><p>
        <?php
        $text = get_the_excerpt();
        $more = substr($text, -5);
        echo substr($text, 0, strlen($text) - 5) . '<a href="' . get_permalink() . '">' . $more . '</a>';
        ?></p>
                    </div>
                </div>
            </article>
    <?php endwhile; ?>
<?php endif; ?>
</div>

<div class="line_2" style="margin:24px 0px 25px;"></div>

<div class="block_pager">

<?php
if (function_exists('wp_pagenavi')) {
    echo wp_pagenavi();
}
wp_reset_postdata();
?>

    <div class="clearboth"></div>
</div>

</div>

<div class="sidebar">
<?php //echo 'Interesting'; ?>
    <?php
    wp_reset_query();
    $custom = get_post_custom($post->ID);
    $current_sidebar = $custom["current_sidebar"][0];

    if ($current_sidebar) {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($current_sidebar)) :
        endif;
    } else {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar")) :
        endif;
    }
//    echo 'paaa more Interesting';
//    var_dump(dynamic_sidebar("Blog Sidebar"));
    ?>

</div>

<?php get_footer(); ?>