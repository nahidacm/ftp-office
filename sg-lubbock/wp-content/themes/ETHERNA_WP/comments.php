<?php
global $options;
foreach ($options as $value) {
	if ( isset( $value['id'] ) ) {
		if (get_option( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_option( $value['id'] );
		}
	}
}
$tags = wp_get_post_tags($post->ID);
$i = 0;
if ($tags){$tag_ids = array();
foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
$args=array('tag__in' => $tag_ids,'post__not_in' => array($post->ID),'showposts'=>4,'caller_get_posts'=>1);
$my_query = new wp_query($args);
if($my_query->have_posts()){echo '<ul id="ds_relatedpost"><h3>'. __('Related Posts','designSentry').'</h3>';while ($my_query->have_posts()){
$my_query->the_post();
?>
<li class="ds_related<?php $i++; if(!($i % 2) == 0){echo ' clearleft';}; ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">- <?php the_title(); ?></a></li>
<?php
}echo '</ul>';}} wp_reset_query(); ?>
			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.','designSentry' ); ?></p>
			</div><!-- #comments -->
<?php
		return;
	endif;
?>
<?php if($ds_eth_authors_box == 'Yes'){ ?>
<div id="authors_box">
<div <?php if (!comments_open()){echo 'id="authors_inner_box_no_bcg"';} else {echo 'id="authors_inner_box"';} ?>>
<?php echo get_avatar(get_the_author_meta('user_email'), '60'); ?> <h2><?php _e('This article was written by:','designSentry'); ?> <?php the_author(); ?></h2><p><?php the_author_meta('description'); ?></p><?php if (comments_open()){echo '<div id="authors_inner_box_below"></div>';} ?>
</div></div>
<?php } ?>

<?php if ( have_comments() ) : ?>
			
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments','designSentry' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>','designSentry' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="powercomments"><li><h3 id="comments-title"><?php comments_number(); ?></h3></li><li><ul>
				<?php
					wp_list_comments( array( 'callback' => 'twentyten_comment' ) );
				?>
			</ul></li>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments','designSentry' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>','designSentry' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:
	if ( ! comments_open() ) :
?>
	<p class="nocomments"></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php $comment_args = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
    'author' => '<p class="comment-form-author">' .
                '<label for="author">' . __( 'Your Name','designSentry' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) . 
                '<input id="author" name="author" type="text" value="' .
                esc_attr( $commenter['comment_author'] ) . '" size="40"' . $aria_req . ' />' .
                '</p><!-- #form-section-author .form-section -->',
    'email'  => '<p class="comment-form-email">' .
				'<label for="email">' . __( 'Your Email','designSentry' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="40"' . $aria_req . ' />' .
                '</p><!-- #form-section-email .form-section -->',
    'url'    => '' ) ),
    'comment_field' => '<p class="comment-form-comment">' .
                '<label for="comment">' . __( 'Let us know what you have to say:','designSentry' ) . '</label>' .
                '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
                '</p><!-- #form-section-comment .form-section -->',
    'comment_notes_after' => '',
	'cancel_reply_link' => __( 'Cancel reply' ),
);
comment_form($comment_args); ?>
</div><!-- #comments -->