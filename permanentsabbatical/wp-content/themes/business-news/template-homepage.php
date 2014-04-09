<?php
/*
  Template Name: Home Page
 */
get_header();
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
<?php endif; ?>

</div>

<div class="sidebar">

    <?php
    //wp_reset_query();
    $custom = get_post_custom($post->ID);
    $current_sidebar = $custom["current_sidebar"][0];
    try {
        if ($current_sidebar) {
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($current_sidebar)) :
            endif;
        } else {
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("HomePage Sidebar")) :
            endif;
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
    ?>

</div>

<?php get_footer(); ?>