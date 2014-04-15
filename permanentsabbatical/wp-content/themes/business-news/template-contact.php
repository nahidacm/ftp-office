<?php
/*
  Template Name: Contact
 */
get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <div class="general_subtitle">
        <?php the_content(); ?>
    </div>
<?php endwhile; // end of the loop. ?>


<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Contact Form")) : ?>
    <div class="block_contact_form">
        <form id="contact_form" method="post" action="<?php echo get_template_directory_uri(); ?>/functions/contact_form.php">
            <p><?php _e('Name', 'weblionmedia'); ?><span>*</span></p>
            <div class="field"><input type="text" id="username" name="username" class="req"></div>

            <p><?php _e('E-mail', 'weblionmedia'); ?><span>*</span></p>
            <div class="field"><input type="text" id="email" name="email" class="req email"></div>

            <p><?php _e('Comment', 'weblionmedia'); ?><span>*</span></p>
            <div class="textarea"><textarea cols="1" rows="1" id="message" name="message" class="req"></textarea></div>

            <input type="submit" class="general_button" value="<?php _e('Send message', 'weblionmedia'); ?>">
        </form>
        <script type="text/javascript">
            jQuery(function() {
                jQuery('#contact_form').ajaxForm({
                    beforeSubmit: function() {
                        return init_validation('#contact_form');
                    },
                    success: function() {
                        alert('<?php _e('Your message has been sent!', 'weblionmedia'); ?>');
                        jQuery('#contact_form').resetForm();
                    }
                });
            });
        </script>
    </div>
<?php endif; ?>


</div>

<div class="sidebar">

    <?php
    wp_reset_query();
    $custom = get_post_custom($post->ID);
    $current_sidebar = $custom["current_sidebar"][0];

    if ($current_sidebar) {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($current_sidebar)) :
        endif;
    } else {
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Contact Sidebar")) :
        endif;
    }
    ?>

</div>					

<?php get_footer(); ?>