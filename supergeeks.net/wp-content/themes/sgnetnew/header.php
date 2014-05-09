<?php

/**

 * The Header for our theme.
            <div class="tel-container">
                <h2 class="mobile"><?php dynamic_sidebar( 'footer-contact' ); ?></h2>
            </div>

 *

 * Displays all of the <head> section and everything up till <div id="main">

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */

?><!DOCTYPE html>

<!--[if IE 7]>

<html class="ie ie7" <?php language_attributes(); ?>>

<![endif]-->

<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); ?>>

<![endif]-->

<!--[if !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); ?>>

<!--<![endif]-->

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name="viewport" content="width=device-width" />

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />



<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>

<!--[if lt IE 9]>

<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>

<![endif]-->

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->

<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->

<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->

<!--[if gt IE 8]><!-->

<!--<![endif]-->

<?php wp_head(); ?>

</head>



<body <?php body_class(); ?>>

<div class="wrapper">

    <header>

        <div class="center">

            <div class="logo"><?php lm_display_logo(); ?></div>

            <a href="javascript:void(0);" class="toggleHeaderMenu"></a>

            <h2 class="how-can-we-help pc"><?php bloginfo( 'description' ); ?></h2>

            <div class="clear"></div>

            <nav>

                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'header-menu' ) ); ?>

            </nav>

            <div class="fixed-social-icons-container mobile">

                <h2 class="how-can-we-help"><?php bloginfo( 'description' ); ?></h2>

                <div class="fixed-social-icons">

                    <a href="<?php echo stripslashes(get_option('ab_chat_live_url')) ?>" title="Chat Live! Link" target="_blank" class="chat hidden"></a>

                    <a href="<?php echo stripslashes(get_option('ab_facebook_url')) ?>" title="Facebook Link" target="_blank" class="facebook"></a>

                    <a href="<?php echo stripslashes(get_option('ab_twitter_url')) ?>" title="Twitter Link" target="_blank" class="twitter"></a>

                </div>

                <div class="clear"></div>

            </div>

            <div class="fixed-social-icons pc">

                <a href="<?php echo stripslashes(get_option('ab_chat_live_url')) ?>" title="Chat Live! Link" target="_blank" class="chat hidden"></a>

                <a href="<?php echo stripslashes(get_option('ab_facebook_url')) ?>" title="Facebook Link" target="_blank" class="facebook"></a>

                <a href="<?php echo stripslashes(get_option('ab_twitter_url')) ?>" title="Twitter Link" target="_blank" class="twitter"></a>

                <a href="http://supergeeks.net/locations/" title="Map Link" class="map"></a>

            </div>

            <script>

                var fixedSocialIconsTop = jQuery(".fixed-social-icons:visible").position().top;

                jQuery(window).scroll(function () {

                    var scrollPos = jQuery(window).scrollTop();

                    jQuery(".fixed-social-icons").css("top", (scrollPos + fixedSocialIconsTop).toString() + "px");

                });

            </script>

        </div>

    </header>



	<div role="main" class="content_wrapper center">