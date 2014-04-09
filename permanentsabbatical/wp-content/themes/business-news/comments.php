<?php
/**
 * The template for displaying Comments.
 */
?>

<div class="block_comments">
<?php if (get_comments_number($post->ID) > 0) { ?><h3><?php } ?>
<?php comments_number(__('', 'weblionmedia'),__('1 Comment', 'weblionmedia'), __('% Comments', 'weblionmedia')); ?>
<?php if (get_comments_number($post->ID) > 0) { ?></h3><?php } ?>

<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'weblionmedia' ); ?></p>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( "<span class='meta-nav'>&larr;</span> Older Comments", 'weblionmedia' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( "Newer Comments <span class='meta-nav'>&rarr;</span>", 'weblionmedia' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

	<ul>
		<?php
			wp_list_comments( array( 'style' => 'div', 'callback' => 'weblionmedia_comment' ) );
		?>
	</ul>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( "<span class='meta-nav'>&larr;</span> Older Comments", 'weblionmedia' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( "Newer Comments <span class='meta-nav'>&rarr;</span>", 'weblionmedia' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	 $needed_comment_form = 0;
	 if ($needed_comment_form == 1) comment_form(); 
	 
	if ( !comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'weblionmedia' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

</div>

<?php comment_form_theme(); ?>