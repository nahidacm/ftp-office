<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */



get_header(); ?>



	<div class="services-container">

            <div class="service mobile">
                <h2><a href="tel:(808) 942-0773">Call us</a></h2>
            </div>
            <div class="service mobile">
                <h2><a href="mailto:help@supergeeks.net">Email us</a></h2>
            </div>
            <div class="service mobile">
                <h2><a href="/location">Locations</a></h2>
            </div>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>



			<?php endwhile; // end of the loop. ?>



	</div><!-- services-container -->

    

    <div class="customer-service-container align-center">

		<?php if ( is_active_sidebar( 'customer-service' ) ) : ?>

            <?php dynamic_sidebar( 'customer-service' ); ?>

        <?php endif; ?>

    </div>

    

    <div class="clients-container align-center">

		<?php if ( is_active_sidebar( 'some-of-our-clients' ) ) : ?>

            <h2><?php dynamic_sidebar( 'some-of-our-clients' ); ?></h2>

        <?php endif; ?>

    </div>



<?php get_footer(); ?>