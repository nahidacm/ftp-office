<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
        
        	<div class="blogsidebar">
            	<?php get_sidebar(); ?>
            </div>
            
            <div class="blogcontent">
				<?php if ( have_posts() ) : ?>
        
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php /*?><?php get_template_part( 'content', get_post_format() ); ?><?php */?>
                            <h1 class="entry-title">
        						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php the_title(); ?>
                                </a>
    						</h1>
                            
                            <div class="postedby">
                            	Posted by: <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
                                <span> | </span>
                                Posted on: <?php the_date('F j, Y'); ?>
                                <span> | </span>
                                <?php comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post'); ?>
                            </div>
                        	<?php the_excerpt(); ?><span class="read_more"><a href="<?php the_permalink(); ?>"> Read More... </a></span>
                    </article>
                    <?php endwhile; ?>
        
                    <?php twentytwelve_content_nav( 'nav-below' ); ?>
        
                <?php else : ?>
        
                    <article id="post-0" class="post no-results not-found">
        
                    <?php if ( current_user_can( 'edit_posts' ) ) :
                        // Show a different message to a logged-in user who can add posts.
                    ?>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
                        </header>
        
                        <div class="entry-content">
                            <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
                        </div><!-- .entry-content -->
        
                    <?php else :
                        // Show the default message to everyone else.
                    ?>
                        <header class="entry-header">
                            <h1 class="entry-title" style="font-size:1.5em; margin:0 0 10px 0;"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
                        </header>
        
                        <div class="entry-content">
                            <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
                            <?php get_search_form(); ?>
                        </div><!-- .entry-content -->
                    <?php endif; // end current_user_can() check ?>
        
                    </article><!-- #post-0 -->
        
                <?php endif; // end have_posts() check ?>
			</div>
            <div class="clear"></div>
		</div><!-- #content -->
	</div><!-- #primary -->
    
    <div style="height:50px;"></div>
    <div class="customer-service-container align-center">
		<?php if ( is_active_sidebar( 'customer-service' ) ) : ?>
            <?php dynamic_sidebar( 'customer-service' ); ?>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>