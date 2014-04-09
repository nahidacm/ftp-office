<?php global $shortname; ?>

                	<div class="clearboth"></div>
                </div>
            </div>
        </div>
    	<!-- CONTENT END -->
        
        <!-- FOOTER BEGIN -->
        <footer>
            <div id="footer">
            	<section class="top">
                	<div class="inner">
						<?php
							if (get_option($shortname."_logo_footer")) {
						?>
							<div id="logo_bottom"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_option($shortname."_logo_footer"); ?>" alt="<?php echo get_bloginfo('name'); ?>" title="<?php echo get_bloginfo('name'); ?>"></a></div>
						<?php } ?>
                        
                        <div class="block_to_top">
                        	<a href="#"><?php _e('BACK TO TOP','weblionmedia'); ?></a>
                        </div>
                    </div>
                </section>
                
            	<section class="middle">
                	<div class="inner">
                    	<div class="line_1"></div>
                        
                        <div class="block_footer_widgets">
                        	<div class="column">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 1") ) : ?>
								<?php endif; ?>
                            </div>
                            
                            <div class="column">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 2") ) : ?>
								<?php endif; ?>
                            </div>
                            
                            <div class="column">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 3") ) : ?>
								<?php endif; ?>
                            </div>
                            
                            <div class="column">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 4") ) : ?>
								<?php endif; ?>
                            </div>
                            
                            <div class="clearboth"></div>
                        </div>
                    </div>
                </section>
                
            	<section class="bottom">
                	<div class="inner">
                    	<div class="line_1"></div>
                        
                        <div class="fr">
                        	<div class="block_menu_footer">
								<?php
									//the main menu for desktop version
									wp_nav_menu(array(
										'menu'              => '',
										'container'         => '',
										'container_class'   => '',
										'container_id'      => '',
										'menu_class'        => '',
										'menu_id'           => 'footer-menu',
										'echo'              => true,
										'fallback_cb'       => '',
										'before'            => '',
										'after'             => '',
										'link_before'       => '',
										'link_after'        => '',
										'depth'             => 0,
										'theme_location'    => 'footer_menu'
									));
								?>
                            </div>
                            
							<?php if (get_option($shortname."_social_media_footer") == 'true') { ?>
                            <div class="block_social_footer">
                            	<ul>
								
                                	<?php if (get_option($shortname."_social_links_twitter")) { ?><li><a href="<?php echo get_option($shortname."_social_links_twitter"); ?>" class="fb"><?php _e('Facebook','weblionmedia'); ?></a></li><?php } ?>
									
                                    <?php if (get_option($shortname."_social_links_facebook")) { ?><li><a href="<?php echo get_option($shortname."_social_links_facebook"); ?>" class="tw"><?php _e('Twitter','weblionmedia'); ?></a></li><?php } ?>
									
									<?php if (get_option($shortname."_social_links_gplus")) { ?><li><a href="<?php echo get_option($shortname."_social_links_gplus"); ?>" class="gplus"><?php _e('Google+','weblionmedia'); ?></a></li><?php } ?>
									
                                    <?php if (get_option($shortname."_social_links_rss")) { ?><li><a href="<?php echo get_option($shortname."_social_links_rss"); ?>" class="rss"><?php _e('RSS','weblionmedia'); ?></a></li><?php } ?>
									
                                </ul>
                            </div>
							<?php } ?>							
                        </div>
                        
                        <div class="block_copyrights"><p><?php echo stripslashes(get_option($shortname.'_footer_copyright'));  ?></p></div>	
                    </div>
                </section>
            </div>
        </footer>
        <!-- FOOTER END -->
    </div>
	
    <!-- POPUP BEGIN -->
    <div id="overlay"></div>
    <div id="login" class="block_popup">
    	<div class="popup">
        	<a href="#" class="close"><?php _e('Close','weblionmedia'); ?></a>
            
            <div class="content">
            	<div class="title"><p><?php _e('Enter the site','weblionmedia'); ?></p></div>
                
                <div class="form">
                	<form action="<?php echo wp_login_url( get_permalink() ); ?>" method="post" name="login_form">
                    	<div class="column">
                        	<p class="label"><?php _e('Login','weblionmedia'); ?></p>
                            <div class="field"><input type="text" name="log" id="log"></div>
                        </div>						
						
                        <div class="column">
                        	<p class="label"><?php _e('Password','weblionmedia'); ?></p>
                            <div class="field"><input type="password" name="pwd" id="pwd"></div>
                        </div>
						
						<div class="column_2">
                            <div class="remember">
                            	<div class="checkbox"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever"></div>
                                <div class="remember_label"><p><?php _e('Remember me','weblionmedia'); ?></p></div>
                            </div>
                        </div>
                        
                        <div class="column_2">
                            <p class="forgot_pass"><a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>"><?php _e('Forgot password?','weblionmedia'); ?></a></p>
                        </div>
                        
                        <div class="column button">
							<input type="hidden" name="redirect_to" value="<?php echo get_admin_url(); ?>"/>
							<a href="#" class="enter" id="submit" onclick="document.forms['login_form'].submit(); return false;"><span><?php _e('Login','weblionmedia'); ?></span></a>
                        </div>
                        
                        <div class="clearboth"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- POPUP END -->

<?php
	//Display the javascript tracking code
	echo stripslashes(get_option($shortname.'_tracking_code')); 
	 
	//Addd the wp_footer action hook
	wp_footer();
?>

</body>
</html>