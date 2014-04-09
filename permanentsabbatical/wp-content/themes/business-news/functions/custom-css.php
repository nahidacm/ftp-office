<?php
	header("Content-type: text/css");
	$wp_load_include = "../wp-load.php";
	$i = 0;
	while (!file_exists($wp_load_include) && $i++ < 9) {
		$wp_load_include = "../$wp_load_include";
	}
	//required to include wordpress file
	require($wp_load_include);
	
	global $shortname;
	
	$custom_css = get_option($shortname.'_custom_css');
	if ($custom_css) echo $custom_css;
	
	//set the headings section settings: font name
	$site_headings_font = get_option($shortname."_site_headings_font");
	if ($site_headings_font) {
echo 'h1, h2, h3, h4, h5, h6 { font-family: "'.str_replace('+',' ',$site_headings_font).'", Arial, Helvetica, sans-serif !important; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-family: "'.str_replace('+',' ',$site_headings_font).'", Arial, Helvetica, sans-serif !important; } ';
	}

	//set the main menu settings: font name
	$main_site_menu_font = get_option($shortname."_main_site_menu_font");
	if ($main_site_menu_font) {
		echo '
nav.main_menu ul#main-primary-menu li a { font-family: "'.str_replace('+',' ',$main_site_menu_font).'", Arial, Helvetica, sans-serif !important; } ';
	}

	//set the secondary menu settings: font name
	$secondary_site_menu_font = get_option($shortname."_secondary_site_menu_font");
	if ($secondary_site_menu_font) {
		echo '
nav.secondary_menu ul#main-secondary-menu li a { font-family: "'.str_replace('+',' ',$secondary_site_menu_font).'", Arial, Helvetica, sans-serif !important; } ';
	}


	//set the body settings: background color, image, display options
	$theme_bodybgcolor_class = '';
	$theme_background = get_option($shortname."_theme_background");	
	if ($theme_background == 'Boxed') {
	
		$theme_bodybgimage = get_option($shortname."_site_background_image");
		$theme_bodybgcolor = get_option($shortname."_site_background_color");
		
		if ( (!$theme_bodybgimage) && (!$theme_bodybgcolor) ) {
			/*$theme_bodybgcolor_class = '
				body.boxed {background:url('.get_template_directory_uri().'/images/bg_boxed.jpg);}
			';*/
		}
	

		$theme_bodybgimage_class = '';
		if ($theme_bodybgcolor) {
			if ($theme_bodybgimage) {
				$site_background_image_position = get_option($shortname.'_site_background_image_position');
				$site_background_image_repeat = get_option($shortname.'_site_background_image_repeat');
				$site_background_image_attachment = get_option($shortname.'_site_background_image_attachment');
				$theme_bodybgimage_class = " url(".$theme_bodybgimage."); background-position: ".$site_background_image_position." top; background-repeat: ".$site_background_image_repeat."; background-attachment: ".$site_background_image_attachment;
			}
			$theme_bodybgcolor_class = '
body { background:'.$theme_bodybgcolor.$theme_bodybgimage_class.'; }
			';
		} else if ($theme_bodybgimage) {
			$site_background_image_position = get_option($shortname.'_site_background_image_position');
			$site_background_image_repeat = get_option($shortname.'_site_background_image_repeat');
			$site_background_image_attachment = get_option($shortname.'_site_background_image_attachment');
			$theme_bodybgcolor = '#fff';
			$theme_bodybgimage_class = $theme_bodybgcolor." url(".$theme_bodybgimage."); background-position: ".$site_background_image_position." top; background-repeat: ".$site_background_image_repeat."; background-attachment: ".$site_background_image_attachment;

			//repeat center 0
			$theme_bodybgcolor_class = "body { background:".$theme_bodybgimage_class."; }";
		}
		
		echo $theme_bodybgcolor_class;
	}
	
	
	$header_middle_section_background = get_option($shortname."_header_middle_section_background");
	$header_middle_section_background_disable = get_option($shortname."_header_middle_section_background_disable");
	if ( ($header_middle_section_background) && ($header_middle_section_background_disable != "true") ) {
		echo '
			#header .bottom .inner {height:148px; background:url('.$header_middle_section_background.') repeat;}
		';
	}
	if ($header_middle_section_background_disable == "true") {
		echo '
			#header .bottom .inner { background: none; }
		';
	}
?>