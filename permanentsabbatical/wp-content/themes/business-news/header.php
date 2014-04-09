<?php
/**
 * The Header for the theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php
	//Print the <title> tag based on what is being viewed.
	global $page, $paged;	
	// Add the blog name.
	bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'business-news' ), max( $paged, $page ) );
?></title>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no" />

<?php
	global $shortname;
	$favicon = get_option($shortname.'_favicon');
	if ($favicon) {
?>
<!-- ~~~~~~ FAVICONS ~~~~~~ -->
<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
<?php 
	}
?>

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/layout/plugins/html5.js"></script>
<![endif]-->

<?php wp_head();?>
</head>

<body <?php body_class('custom-background'); ?>>
	<div class="wrapper sticky_footer">
    	<!-- HEADER BEGIN -->
        <header>
            <div id="header">
				<?php if (get_option($shortname."_header_top_section") != "true" ) { ?>
            	<section class="top">
                	<div class="inner">
                    	<div class="fl">
                        	<div class="block_top_menu">
								<?php
									wp_nav_menu(array(
										'menu'              => '',
										'container'         => '',
										'container_class'   => '',
										'container_id'      => '',
										'menu_class'        => '',
										'menu_id'           => 'top-left-menu',
										'echo'              => true,
										'fallback_cb'       => '',
										'before'            => '',
										'after'             => '',
										'link_before'       => '',
										'link_after'        => '',
										'depth'             => 1,
										'theme_location'    => 'header_top_left_menu'
									));
								?>
                            </div>
                        </div>
                        
                        <div class="fr">
                        	<div class="block_top_menu">
								<?php
									wp_nav_menu(array(
										'menu'              => '',
										'container'         => '',
										'container_class'   => '',
										'container_id'      => '',
										'menu_class'        => '',
										'menu_id'           => 'top-right-menu',
										'echo'              => true,
										'fallback_cb'       => '',
										'before'            => '',
										'after'             => '',
										'link_before'       => '',
										'link_after'        => '',
										'depth'             => 1,
										'theme_location'    => 'header_top_right_menu'
									));
								?>
                            </div>
							
							<?php if (get_option($shortname."_social_media_header") == "true" ) { ?>
                            <div class="block_social_top">
                            	<ul>
                                	<?php if (get_option($shortname."_social_links_twitter")) { ?><li><a href="<?php echo get_option($shortname."_social_links_twitter"); ?>" class="fb"><?php _e('Facebook','weblionmedia'); ?></a></li><?php } ?>
                                    <?php if (get_option($shortname."_social_links_facebook")) { ?><li><a href="<?php echo get_option($shortname."_social_links_facebook"); ?>" class="tw"><?php _e('Twitter','weblionmedia'); ?></a></li><?php } ?>
									<?php if (get_option($shortname."_social_links_gplus")) { ?><li><a href="<?php echo get_option($shortname."_social_links_gplus"); ?>" class="gplus"><?php _e('Google+','weblionmedia'); ?></a></li><?php } ?>
                                    <?php if (get_option($shortname."_social_links_rss")) { ?><li><a href="<?php echo get_option($shortname."_social_links_rss"); ?>" class="rss"><?php _e('RSS','weblionmedia'); ?></a></li><?php } ?>
                                </ul>
                            </div>
							<?php } ?>
                        </div>
                        
                    	<div class="clearboth"></div>
                    </div>
                </section>
				<?php } ?>
                
				<?php if (get_option($shortname."_header_middle_section") != "true" ) { ?>
            	<section class="bottom">
                	<div class="inner">
						<?php
							if (get_option($shortname."_logo")) {
								$logo_margin_top = trim(get_option($shortname."_logo_margin_top"));
								$logo_margin_top = str_replace('px','',$logo_margin_top);
								$logo_margin_top = str_replace('em','',$logo_margin_top);
								$logo_margin_left = trim(get_option($shortname."_logo_margin_left"));
								$logo_margin_left = str_replace('px','',$logo_margin_left);
								$logo_margin_left = str_replace('em','',$logo_margin_left);
						?>
							<div id="logo_top" style="<?php echo 'margin-top: '.$logo_margin_top.'px; margin-left: '.$logo_margin_left.'px; '; ?>"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_option($shortname."_logo"); ?>" alt="<?php echo get_bloginfo('name'); ?>" title="<?php echo get_bloginfo('name'); ?>"></a></div>
						<?php } ?>
                        
						<?php if (get_option($shortname."_block_today_date") == 'true') { ?>
						<div class="block_today_date">
                        	<div class="num"><p id="num_top_day"><?php $today = getdate(); if ($today['mday']<10) echo '0'; echo $today['mday']; ?></p></div>
                            <div class="other">
                            	<p class="month_year"><span id="month_top_display"><?php $today["month"] = date("M");  echo $today['month']; ?></span>, <span id="year_top_display"><?php echo $today['year']; ?></span></p>
                                <p id="day_top_display" class="day"><?php echo $today['weekday']; ?></p>
                            </div>
                        </div>
						<?php } ?>
                        
                        <div class="fr">
						<?php
							if ( (get_option($shortname."_banner")) && (!get_option($shortname."_banner_custom_code")) ) {
								$banner_margin_top = trim(get_option($shortname."_banner_margin_top"));
								$banner_margin_top = str_replace('px','',$banner_margin_top);
								$banner_margin_top = str_replace('em','',$banner_margin_top);
								$banner_margin_right = trim(get_option($shortname."_banner_margin_right"));
								$banner_margin_right = str_replace('px','',$banner_margin_right);
								$banner_margin_right = str_replace('em','',$banner_margin_right);
						?>
							<div id="banner_top" style="<?php echo 'margin-top: '.$banner_margin_top.'px; margin-right: '.$banner_margin_right.'px;'; ?>"><a href="<?php echo get_option($shortname.'_header_banner_url'); ?>"><img src="<?php echo get_option($shortname."_banner"); ?>" alt="" title=""></a></div>
						<?php 
							} else if (get_option($shortname."_banner_custom_code")) {
								$banner_margin_top = trim(get_option($shortname."_banner_margin_top"));
								$banner_margin_top = str_replace('px','',$banner_margin_top);
								$banner_margin_top = str_replace('em','',$banner_margin_top);
								$banner_margin_right = trim(get_option($shortname."_banner_margin_right"));
								$banner_margin_right = str_replace('px','',$banner_margin_right);
								$banner_margin_right = str_replace('em','',$banner_margin_right);							
						?>
							<div id="banner_top" style="<?php echo 'margin-top: '.$banner_margin_top.'px; margin-right: '.$banner_margin_right.'px;'; ?>">						
						<?php
								echo get_option($shortname."_banner_custom_code"); 
								echo '</div>';	
							}
						?>
                        </div>
                        
                        <div class="clearboth"></div>
                    </div>
                </section>
				<?php } ?>
                
                <section class="section_main_menu">
                	<div class="inner">
                    	<nav class="main_menu">
							<?php
								wp_nav_menu(array(
									'menu'              => '',
									'container'         => '',
									'container_class'   => '',
									'container_id'      => '',
									'menu_class'        => '',
									'menu_id'           => 'main-primary-menu',
									'echo'              => true,
									'fallback_cb'       => '',
									'before'            => '',
									'after'             => '',
									'link_before'       => '',
									'link_after'        => '',
									'depth'             => 0,
									'theme_location'    => 'main_menu'
								));
							?>
						</nav>
                    </div>
                </section>

				<?php if (get_option($shortname."_main_secondary_menu") != 'true') { ?>
                <section class="section_secondary_menu">
                	<div class="inner">
                    	<nav class="secondary_menu">
							<?php
								//the main menu for desktop version
								wp_nav_menu(array(
									'menu'              => '',
									'container'         => '',
									'container_class'   => '',
									'container_id'      => '',
									'menu_class'        => '',
									'menu_id'           => 'main-secondary-menu',
									'echo'              => true,
									'fallback_cb'       => '',
									'before'            => '',
									'after'             => '',
									'link_before'       => '',
									'link_after'        => '',
									'depth'             => 0,
									'theme_location'    => 'main_secondary_menu'
								));
							?>
                        </nav>
                        
                        <div class="block_clock">
                        	<p><?php _e('Time:','weblionmedia'); ?> <span id="time_display"><?php if ($today['hours'] < 10) echo '0'; echo $today['hours']; ?>:<?php if ($today['minutes'] < 10) echo '0'; echo $today['minutes']; ?></span></p>
                        </div>
                    </div>
                </section>
				<?php } ?>
				
            </div>
        </header>
    	<!-- HEADER END -->
        
        <!-- CONTENT BEGIN -->
        <div id="content" <?php if ( (!is_page_template('template-page-fullwidth.php')) && (!is_page_template('template-registration.php')) ) { echo ' class="right_sidebar"'; } ?>>
        	<div class="inner">
            	<div class="general_content">
                	<div class="main_content">
					
					<?php if ( !is_home() && (!is_front_page()) && (!is_page_template('template-homepage.php')) ) { ?>
						<?php if (get_option($shortname."_breadcrumbs") == 'Yes') { ?>
							<div class="block_breadcrumbs">
								<div class="text"><p><?php _e('You are here:','weblionmedia'); ?></p></div>
								
								<ul>
									<li><?php echo '<a href="'.home_url().'">'.__('Home','weblionmedia').'</a>'; ?></li>
									<?php if (function_exists('theme_breadcrumbs')) theme_breadcrumbs(); ?>
								</ul>
							</div>
							<div class="separator" style="height:30px;"></div>
						<?php } ?>
						
						<?php 
							//get page section title
							if ( is_archive() ) {
							if ( is_day() ) : 
						?>
						
						<h2>
						<?php printf( __( 'Daily Archives: %s', 'weblionmedia' ), '<span>' . get_the_date() . '</span>' ); ?>
						</h2>
						<?php elseif ( is_month() ) : ?>
						<h2>
							<?php printf( __( 'Monthly Archives: %s', 'weblionmedia' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
						</h2>
						<?php elseif ( is_year() ) : ?>
						<h2>
							<?php printf( __( 'Yearly Archives: %s', 'weblionmedia' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
						</h2>
						<?php elseif ( is_category() ) : ?>
						<h2>
							<?php printf( __( 'Category Archives: %s', 'weblionmedia' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
						</h2>
						<?php
							elseif ( is_author() ) : 
								$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));

								if ($curauth->first_name || $curauth->last_name) $curauth_name = $curauth->first_name.' '.$curauth->last_name;
								if (!$curauth->first_name || !$curauth->last_name) $curauth_name = $curauth->nickname;
						?>
                        <h2><?php _e('About','weblionmedia'); ?> <?php echo $curauth_name; ?></h2>
                        
						<?php
							$user_position = get_the_author_meta('user_position', $curauth->ID);
							if ($user_position) {
								echo '<p class="general_subtitle_2">'.$user_position.'</p>';
							}
						?>
                        <div class="line_3" style="margin:-6px 0px 17px;"></div>
                        <div class="block_author">
							<div class="photo"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $curauth->ID)); ?>"><?php echo str_replace(' photo','',str_replace(' avatar','',get_avatar( get_the_author_meta('email', $curauth->ID) , $size='97' ))); ?></a></div>
                            <div class="bio">
							
								<p><?php echo get_the_author_meta('description', $curauth->ID); ?></p>
								<?php 
									$user_url = get_the_author_meta('user_url', $curauth->ID);
									if ($user_url) {
										echo '<p class="www"><a href="'.$user_url.'">'.str_replace('http://','',$user_url).'</a></p>'; 
									}
									$user_email = get_the_author_meta('user_email', $curauth->ID);
									if ($user_email) {
										echo '<p class="email"><a href="mailto:'.$user_email.'" target="_blank">'.$user_email.'</a></p>';
									}
									
									$user_facebook = get_the_author_meta('user_facebook', $curauth->ID);
									$user_twitter = get_the_author_meta('user_twitter', $curauth->ID);
									$user_fr = get_the_author_meta('user_fr', $curauth->ID);
									$user_vimeo = get_the_author_meta('user_vimeo', $curauth->ID);
									$user_gplus = get_the_author_meta('user_gplus', $curauth->ID);
									$user_rss = get_the_author_meta('user_rss', $curauth->ID);

									$user_facebook_output = '';
									$user_twitter_output = '';
									$user_fr_output = '';
									$user_vimeo_output = '';
									$user_gplus_output = '';
									$user_rss_output = '';
									
									if ($user_facebook || $user_twitter || $user_fr || $user_vimeo || $user_rss) {
										if ($user_facebook) { $user_facebook_output = '<li><a href="'.$user_facebook.'" class="fb">Facebook</a></li>'; }
										if ($user_twitter) { $user_twitter_output = '<li><a href="'.$user_twitter.'" class="tw">Twitter</a></li>'; }
										if ($user_fr) { $user_fr_output = '<li><a href="'.$user_fr.'" class="s_fr">Fr</a></li>'; }
										if ($user_vimeo) { $user_vimeo_output = '<li><a href="'.$user_vimeo.'" class="vimeo">Vimeo</a></li>'; }
										//if ($user_gplus) { $user_gplus_output = '<li><a href="'.$user_gplus.'" class="gplus">Google+</a></li>'; }
										if ($user_rss) { $user_rss_output = '<li><a href="'.$user_rss.'" class="rss">RSS</a></li>'; }
										
										echo '
											<div class="line_3" style="margin:10px 0px 17px;"></div>
											<div class="social">
												<ul>
													'.$user_facebook_output.'
													'.$user_twitter_output.'
													'.$user_fr_output.'
													'.$user_vimeo_output.'
													'.$user_gplus_output.'
													'.$user_rss_output.'
												</ul>
											</div>
										';
									}
								?>
                            </div>
                            <div class="clearboth"></div>
                        </div>
                        
                        <div class="line_2" style="margin:17px 0px 27px;"></div>
												
						
						<div class="block_author_posts">
                        	<h2><?php _e('Author Posts','weblionmedia'); ?></h2>
						</div>

						<?php else : ?>
						<h2>
							<?php
								$custom_post_type = get_post_type($post->ID);
								if ($custom_post_type == 'news') { 
									//_e( 'News Archives', 'weblionmedia' );
									$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
									echo __( 'Category Archives:', 'weblionmedia' ).' '.$term->name;
								}
								if ($custom_post_type == 'post') { _e( 'Blog Archives', 'weblionmedia' ); }
							?>
							<?php
								
							?>
							
						</h2>
						<?php 
							endif;
						?>
						<?php
							} else if ( is_search() ) {
								echo '<h2>';
								printf( __( 'Search Results for: %s', 'weblionmedia' ), '<strong>' . get_search_query() . '</strong>' );
								echo '</h2>';
							} else {
								if ( !is_single() ) {
								
									if (!is_page_template('template-registration.php')) {
										echo '<h2>';
										//get page section title
										if (get_post_meta($post->ID, 'custom_page_heading',true)) {
											echo get_post_meta($post->ID, 'custom_page_heading',true);
										} else {
											the_title();
										}
										echo '</h2>';
										
										if (is_404()) {
											echo '<center><h2>'.__('ERROR PAGE 404','weblionmedia').'</h2>';
											echo '<h3>'.__('The page was not found','weblionmedia').'</h3></center>';
											echo '<p style="margin-bottom:5px;">&nbsp;</p>';
										}
									}
								}
							}
						?>
						
					<?php } //end to check if home page or frontpage ?>