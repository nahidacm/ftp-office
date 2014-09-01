<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
     Remove this if you use the .htaccess -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!-- Title -->
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<!--  Mobile viewport optimized: j.mp/bplateviewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Stylesheets -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
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
if($ds_eth_css != 'Orange'){
$ds_eth_css = 'ds_eth_css '.$ds_eth_css;
wp_enqueue_style($ds_eth_css);} ?>
<!-- Fav icon -->
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
<!-- Feeds -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- Load Options -->
<?php
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body>
  <div id="container">
	<!-- Header -->
    <div id="header">
		<div id="logo"><a href="<?php bloginfo("url"); ?>"><img src="<?php if($ds_eth_logo_upload){echo $ds_eth_logo_upload;} else { bloginfo('template_url'); echo ('/images/logo.png'); }; ?>" alt="" /></a></div>
		<?php if($ds_eth_adv_user_contact == 'No'){ ?>
		<div id="personal_data">
                    <p>Location:<span> 66th St, Suite 5 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br> Lubbock, TX 79424</span></p>
			<?php if($ds_eth_company_phone != ' '){echo '<p>'.__('Phone','designSentry'); ?>: <span><?php echo $ds_eth_company_phone; ?></span></p><?php } ?>
			<!--
                            <?php if($ds_eth_company_mail != ' '){echo '<p>'.__('E-Mail','designSentry'); ?>: <span><a href="mailto:<?php echo $ds_eth_company_mail; ?>"><?php echo $ds_eth_company_mail; ?></a></span></p><?php } ?>
                       -->
		</div>
		<?php } else {echo '<div id="personal_data">' . stripslashes($ds_eth_adv_user_contactmarkup) . '</div>';} ?>
	</div>
	<div id="menu">
		<a href="#" id="mobile-switch">MENU</a>
		<!-- Menu starts -->
		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_id' => '', 'menu_class' => '', 'before' => '<span class="menu_box_left"></span>', 'after' => '<span class="menu_box_right"></span>', 'theme_location' => 'main_menu' ) ); ?>
		<!-- //Menu ends// -->
		<?php if(!($ds_eth_search == 'No')){get_template_part('searchform');} ?>
	</div>
    <!-- /Header -->