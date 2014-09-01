<?php
$themename = "Etherna WP";
$shortname = "ds_eth";

$options = array (

	array(	"name" => "General",
			"type" => "open"),

	/* General */
	array(	"type" => "tab",
			"tabid" => "1"),

	array(	"name" => "General Settings",
			"type" => "title"),

	array(	"name" => "Enter your company name:",
			"desc" => "Company Name",
			"id" => $shortname."_company_name",
			"std" => "Company Name",
			"type" => "text"),

	array(	"name" => "Enter year your company has been established:",
			"desc" => "Year",
			"id" => $shortname."_company_year",
			"std" => '1985',
			"type" => "text"),

	array(	"name" => "Enter your company website link:",
			"desc" => "Website",
			"id" => $shortname."_company_web",
			"std" => 'http://www.designsentry.com',
			"type" => "text"),

	array(	"name" => "Enter your company phone:",
			"desc" => "Phone",
			"id" => $shortname."_company_phone",
			"std" => '+42 555-46-65',
			"type" => "text"),

	array(	"name" => "Enter your company email:",
			"desc" => "Mail",
			"id" => $shortname."_company_mail",
			"std" => 'companymail@domain.com',
			"type" => "text"),

	array(	"name" => "Display breadcrumbs navigation?:",
			"desc" => "",
			"id" => $shortname."_breadcrumbs_navi",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => "Enable slogan area on archive and category pages:",
			"desc" => "",
			"id" => $shortname."_arch_slog1",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"type" => "close"),
	/* End General */

	/* Colors */
	array(	"type" => "tab",
			"tabid" => "2"),

	array(	"name" => "Choose premade color theme",
			"type" => "title"),

	array(	"name" => "Select one of available color themes:",
			"desc" => "",
			"id" => $shortname."_css",
			"type" => "select",	
			"options" => array(
						"1" => "Orange",
						"2" => "Red",
						"3" => "Crimson",
						"4" => "Gold",
						"5" => "Bronze",
						"6" => "Brown",
						"7" => "Dark",
						"8" => "Friendly Grey",
						"9" => "Navy Blue",
						"10" => "Soft Blue",
						"11" => "Ocean Blue",
						"12" => "Sea Blue",
						"13" => "Coral Blue",
						"14" => "Neon Blue",
						"15" => "Soft Teal",
						"16" => "Business Teal",
						"17" => "Business Green",
						"18" => "Soft Green",
						"19" => "Hospital Green",
						"20" => "Dentist Green",
						"21" => "Olive",
						"22" => "Business Purple",
						"23" => "Deep Purple",
						"24" => "Soft Purple",
						"25" => "Funky Purple",
						"26" => "Porno Purple",
						"27" => "Funky Pink",
						"28" => "Intense Pink",
						"29" => "Pink Panther",
						"30" => "Selen",
						"31" => "Yellow"
						),
			"std" => "Orange"),

	array(	"name" => "Use stripe background or full-color? (might need additional tweaks below, for readability):",
			"desc" => "",
			"id" => $shortname."_css_strful",
			"type" => "radio",
			"options" => array("Stripe" => "stripe", "Full" => "full"),
			"std" => "stripe"),

	array(	"name" => "Or build your own, based on theme picked above",
			"type" => "title"),

	array(	"name" => 'Upload your background:',
			"desc" => 'Background',
			"id" => $shortname."_css_bcgupload",
			"std" => '',
			"type" => "upload"),

	array(	"name" => "Set repeating mode for your background:",
			"desc" => "",
			"id" => $shortname."_css_rep",
			"type" => "radio",
			"options" => array("No-repeat" => "no-repeat", "Repeat-x" => "repeat-x", "Repeat-y" => "repeat-y", "Repeat" => "repeat", "Fixed" => "fixed"),
			"std" => "repeat-x"),

	array(	"name" => "Background Color (only applies when custom background is uploaded):",
			"desc" => "",
			"id" => $shortname."_css_bcgcol",
			"std" => '#E8E9EB',
			"type" => "colorpicker"),

	array(	"name" => "Select default buttons color:",
			"desc" => "",
			"id" => $shortname."_css_button",
			"type" => "select",	
			"options" => array(
						"0" => "Same as current theme color",
						"1" => "Orange",
						"2" => "Red",
						"3" => "Black",
						"4" => "White",
						"5" => "Bronze",
						"6" => "Brown",
						"7" => "Green",
						"8" => "Purple",
						"9" => "Teal",
						"10" => "Dentist Green",
						"11" => "Grey",
						"12" => "Hospital Green",
						"13" => "Navy",
						"14" => "Neon Blue",
						"15" => "Ocean Blue",
						"16" => "Olive",
						"17" => "Pink",
						"18" => "Selen",
						"19" => "Soft Green",
						"20" => "Soft Teal",
						"21" => "Yellow"
						),
			"std" => "Same as current theme color"),

	array(	"name" => "Links &amp; Strong Headings Color:",
			"desc" => "",
			"id" => $shortname."_css_headcol",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Color settings for text outside white content block",
			"type" => "title"),

	array(	"name" => "Top Phone &amp; eMail text color (default is black):",
			"desc" => "",
			"id" => $shortname."_css_toppecol",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Top Phone number &amp; eMail text color:",
			"desc" => "",
			"id" => $shortname."_css_toppecolx",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Bottom Copyrights text color:",
			"desc" => "",
			"id" => $shortname."_css_copycol",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Bottom Copyrights link color:",
			"desc" => "",
			"id" => $shortname."_css_copylcol",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Bottom Copyrights text embed-shadow color (default is white):",
			"desc" => "",
			"id" => $shortname."_css_copyscol",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Color settings for line separating main content and footer",
			"type" => "title"),

	array(	"name" => "Upper line color (should be darker than background):",
			"desc" => "",
			"id" => $shortname."_css_uppline",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Lower line color (should be brighter than background):",
			"desc" => "",
			"id" => $shortname."_css_dowline",
			"std" => '',
			"type" => "colorpicker"),

	array(	"name" => "Or hide this line altogether?:",
			"desc" => "",
			"id" => $shortname."_css_linerad",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "No"),

	array(	"type" => "close"),
	/* End Colors */

	/* Logo */
	array(	"type" => "tab",
			"tabid" => "3"),

	array(	"name" => "Logo Settings",
			"type" => "title"),

	array(	"name" => 'Upload your logo:',
			"desc" => 'logo',
			"id" => $shortname."_logo_upload",
			"std" => '',
			"type" => "upload"),

	array(	"name" => 'Logo X-Position (also accepts "-" values):',
			"desc" => 'x-position in px',
			"id" => $shortname."_logo_xpos",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Logo Y-Position (also accepts "-" values):',
			"desc" => 'y-position in px',
			"id" => $shortname."_logo_ypos",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Extend headroom (if you have big logo):',
			"desc" => 'headroom in px',
			"id" => $shortname."_logo_headroom",
			"std" => '0',
			"type" => "text"),

	array(	"type" => "close"),
	/* End Logo */

	/* Slider */
	array(	"type" => "tab",
			"tabid" => "4"),

	array(	"name" => "Slider settings",
			"type" => "title"),

	array(	"name" => "Select animations effect:",
			"desc" => "",
			"id" => $shortname."_slider_effect",
			"type" => "select",	
			"options" => array(
						"0" => "random",
						"1" => "sliceDown",
						"2" => "sliceDownLeft",
						"3" => "sliceUp",
						"4" => "sliceUpLeft",
						"5" => "sliceUpDown",
						"6" => "sliceUpDownLeft",
						"7" => "fold",
						"8" => "fade",
						"9" => "slideInRight",
						"10" => "slideInLeft",
						"11" => "boxRandom",
						"12" => "boxRain",
						"13" => "boxRainReverse",
						"14" => "boxRainGrow",
						"15" => "boxRainGrowReverse"
						),
			"std" => "random"),

	array(	"name" => 'Enter pause time between slides (in ms):',
			"desc" => '',
			"id" => $shortname."_slider_pause",
			"std" => '6000',
			"type" => "text"),

	array(	"name" => 'Enter how many slices there will be for every animation:',
			"desc" => '',
			"id" => $shortname."_slider_slice",
			"std" => '10',
			"type" => "text"),

	array(	"name" => 'Enter animation time (in ms):',
			"desc" => '',
			"id" => $shortname."_slider_anim",
			"std" => '500',
			"type" => "text"),

	array(	"name" => "Show the navigation dots?:",
			"desc" => "",
			"id" => $shortname."_slider_dots",
			"type" => "radio",	
			"options" => array("Yes" => "true", "No" => "false"),
			"std" => "true"),

	array(	"type" => "close"),
	/* End Slider */

	/* Blogs Settings */
	array(	"type" => "tab",
			"tabid" => "5"),

	array(	"name" => "Blog-1 settings",
			"type" => "title"),

	array(	"name" => "Blog-1 Categories:",
			"desc" => "Cats",
			"id" => $shortname."_categories_list1",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_blog_slog1",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_blog_alpha1",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Blog-1 left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_left",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Blog-1 right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_right",
			"std" => '4',
			"type" => "text"),

	array(	"name" => 'Amount of items per page for blog-1:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_blog_ppp1",
			"std" => '3',
			"type" => "text"),
			
	array(	"name" => "Blog-2 settings",
			"type" => "title"),
	
	array(	"name" => "Blog-2 Categories:",
			"desc" => "Cats",
			"id" => $shortname."_categories_list2",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_blog_slog2",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),
			
	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_blog_alpha2",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Blog-2 left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_left2",
			"std" => '4',
			"type" => "text"),		

	array(	"name" => 'Blog-2 right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_right2",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Amount of items per page for blog-2:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_blog_ppp2",
			"std" => '3',
			"type" => "text"),
			
	array(	"name" => "Blog-3 settings",
			"type" => "title"),

	array(	"name" => "Blog-3 Categories:",
			"desc" => "Cats",
			"id" => $shortname."_categories_list3",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_blog_slog3",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_blog_alpha3",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Blog-3 left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_left3",
			"std" => '3',
			"type" => "text"),

	array(	"name" => 'Blog-3 right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_right3",
			"std" => '3',
			"type" => "text"),

	array(	"name" => 'Amount of items per page for blog-3:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_blog_ppp3",
			"std" => '3',
			"type" => "text"),
			
	array(	"name" => "Homepage Blog Settings",
			"type" => "title"),

	array(	"name" => "Homepage Blog Categories:",
			"desc" => "Cats",
			"id" => $shortname."_categories_list4",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => 'Homepage Blog left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_left4",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Homepage Blog right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for blog page.',
			"id" => $shortname."_blog_sidebar_right4",
			"std" => '4',
			"type" => "text"),

	array(	"name" => 'Amount of items per page for Homepage Blog:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_blog_ppp4",
			"std" => '3',
			"type" => "text"),

	array(	"type" => "close"),
	/* END Blogs Settings */

	/* Single post Settings */
	array(	"type" => "tab",
			"tabid" => "6"),

	array(	"name" => "Single Posts settings",
			"type" => "title"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_single_slog1",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_single_alpha1",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Single Posts left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for single page.',
			"id" => $shortname."_single_sidebar_left",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Single Posts right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for single page.',
			"id" => $shortname."_single_sidebar_right",
			"std" => '4',
			"type" => "text"),

	array(	"name" => "Show authors box?",
			"desc" => "",
			"id" => $shortname."_authors_box",
			"type" => "radio",
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => "Special Single Posts settings (i.e. can be used for portfolio items)",
			"type" => "title"),

	array(	"name" => "Special Single Page Categories:",
			"desc" => "Cats",
			"id" => $shortname."_categories_list_sing1",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_single_slog2",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_single_alpha2",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Special Single Posts left-sidebar grid size:',
			"desc" => 'Enter the size of left sidebar for single page.',
			"id" => $shortname."_single_sidebar_left2",
			"std" => '0',
			"type" => "text"),

	array(	"name" => 'Special Single Posts right-sidebar grid size:',
			"desc" => 'Enter the size of right sidebar for single page.',
			"id" => $shortname."_single_sidebar_right2",
			"std" => '3',
			"type" => "text"),

	array(	"type" => "close"),
	/*  END Single post Settings */

	/* Portfolios Settings */
	array(	"type" => "tab",
			"tabid" => "7"),

	array(	"name" => "Standard, paged portfolio settings",
			"type" => "title"),

	array(	"name" => "Standard-Portfolio Categories:",
			"desc" => "Cats",
			"id" => $shortname."_portf_categories_list1",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_portf_slog1",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_portf_alpha1",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Amount of columns per row (available sizes: 1, 2, 3, 4, 6):',
			"desc" => 'Enter the amount of columns for portfolio-1 page.',
			"id" => $shortname."_portf_columns1",
			"std" => '3',
			"type" => "text"),

	array(	"name" => 'Amount of items per page:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_portf_ppp1",
			"std" => '9',
			"type" => "text"),

	array(	"name" => "Allow for lightbox gallery mode?:",
			"desc" => "",
			"id" => $shortname."_allowg1",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "No"),

	array(	"name" => "Sortable, animated portfolio settings",
			"type" => "title"),

	array(	"name" => "Sortable-Portfolio Categories:",
			"desc" => "Cats",
			"id" => $shortname."_portf_categories_list2",
			"std" => '',
			"options" => array(),
			"type" => "category_list"),

	array(	"name" => "Enable slogan area:",
			"desc" => "",
			"id" => $shortname."_portf_slog2",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => 'Markup for Slogan Area:',
			"desc" => "Standard HTML rules apply.",
			"id" => $shortname."_portf_alpha2",
			"std" => '<img src="wp-content/themes/ETHERNA_WP/images/buttons/info_button.png" class="alignleft" alt=""/><h1>The <strong>block</strong> construction of <strong>Etherna</strong> allows for very easy content creation. Some things just cannot be made easier.</h1>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => 'Welcome message:',
			"desc" => 'Portfolio welcome message.',
			"id" => $shortname."_portf_wm2",
			"std" => '<h1>Welcome to our <strong>portfolio!</strong></h1>',
			"rows" => '1',
			"type" => "textarea"),

	array(	"name" => 'Amount of columns per row (available sizes: 1, 2, 3, 4, 6):',
			"desc" => 'Enter the amount of columns for portfolio-2 page.',
			"id" => $shortname."_portf_columns2",
			"std" => '3',
			"type" => "text"),

	array(	"name" => 'Amount of items displayed:',
			"desc" => 'Enter how many posts will be displayed per page.',
			"id" => $shortname."_portf_ppp2",
			"std" => '-1',
			"type" => "text"),

	array(	"name" => "Allow for lightbox gallery mode?:",
			"desc" => "",
			"id" => $shortname."_allowg2",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"type" => "close"),
	/* END Portfolios Settings */

	/* Search */
	array(	"type" => "tab",
			"tabid" => "8"),

	array(	"name" => "Search settings",
			"type" => "title"),

	array(	"name" => "Display search field?:",
			"desc" => "",
			"id" => $shortname."_search",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "Yes"),

	array(	"name" => "Amount of headlines displayed per page on search results page:",
			"desc" => "",
			"id" => $shortname."_search_ppp",
			"std" => '15',
			"type" => "text"),

	array(	"name" => "Grid size of sidebar on search results page:",
			"desc" => "",
			"id" => $shortname."_search_sidebar_right",
			"std" => '4',
			"type" => "text"),

	array(	"type" => "close"),
	/* End Search */

	/* Stats */
	array(	"type" => "tab",
			"tabid" => "10"),

	array(	"name" => "Statistics",
			"type" => "title"),

	array(	"name" => 'Enter your google ID for google analytics (usually looks like this: UA-XXXXX-X):',
			"desc" => 'Example is UA-XXXXX-X',
			"id" => $shortname."_google_anal",
			"std" => '',
			"type" => "text"),

	array(	"type" => "close"),
	/* End Stats */

	/* Footer */
	array(	"type" => "tab",
			"tabid" => "12"),

	array(	"name" => "Footer grid settings",
			"type" => "title"),
	
	array(	"name" => 'Footer widgets grid size:',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val1",
			"std" => '2',
			"valx" => 'amount1',
			"type" => "eq"),

	array(	"name" => 'val2',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val2",
			"std" => '4',
			"valx" => 'amount2',
			"type" => "eq_mid"),

	array(	"name" => 'val3',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val3",
			"std" => '4',
			"valx" => 'amount3',
			"type" => "eq_mid"),

	array(	"name" => 'val4',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val4",
			"std" => '2',
			"valx" => 'amount4',
			"type" => "eq_mid"),	

	array(	"name" => 'val5',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val5",
			"std" => '0',
			"valx" => 'amount5',
			"type" => "eq_mid"),

	array(	"name" => 'val6_close',
			"desc" => 'footer grid',
			"id" => $shortname."_footer_grid1_val6",
			"std" => '0',
			"valx" => 'amount6',
			"type" => "eq_close"),

	array(	"type" => "close"),
	/* End Footer */

	/* Advanced User */
	array(	"type" => "tab",
			"tabid" => "14"),

	array(	"name" => "Advanced user settings",
			"type" => "title"),

	array(	"name" => "Use extended phone/email contact info in the top right side of site?",
			"desc" => "",
			"id" => $shortname."_adv_user_contact",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "No"),

	array(	"name" => 'Enter your markup (select "Yes" above to activate markup in this field):',
			"desc" => "",
			"id" => $shortname."_adv_user_contactmarkup",
			"std" => '<p>Phone <span>+42 555-65-67</span></p><p>email: <span><a href="mailto:companymail@companydomain.com">companymail@companydomain.com</a></span></p>',
			"rows" => '3',
			"type" => "textarea"),

	array(	"name" => "Use extended copyright info in the footer?",
			"desc" => "",
			"id" => $shortname."_adv_user_copy",
			"type" => "radio",	
			"options" => array("Yes" => "Yes", "No" => "No"),
			"std" => "No"),

	array(	"name" => 'Enter your markup (select "Yes" above to activate markup in this field):',
			"desc" => "",
			"id" => $shortname."_adv_user_copymarkup",
			"std" => '<p>Copyrights &copy; <a href="#">Company Name</a> 1984-2011. All rights reserved.</p>',
			"rows" => '2',
			"type" => "textarea"),

	array(	"type" => "close"),
	/* End Advanced User */

	/* Twitter Widget */
	array(	"type" => "tab",
			"tabid" => "15"),

	array(	"name" => "Twitter Widget Settings",
			"type" => "title"),

	array(	"name" => 'Number of tweets displayed:',
			"desc" => '',
			"id" => $shortname."_twit_nr",
			"std" => '4',
			"type" => "text"),

	array(	"name" => 'Avatar size:',
			"desc" => '',
			"id" => $shortname."_twit_ava",
			"std" => '37',
			"type" => "text"),

	array(	"name" => 'Text displayed during loading:',
			"desc" => '',
			"id" => $shortname."_twit_load",
			"std" => 'loading tweets...',
			"type" => "text"),

	array(	"type" => "close"),
	/* End Twitter Widget */

	/* Input */
	array(	"type" => "tab",
			"tabid" => "16"),

	array(	"name" => "JS Quick Input",
			"type" => "title"),

	array(	"name" => 'Input your own javascrips:',
			"desc" => '',
			"id" => $shortname."_js_input",
			"std" => '',
			"rows" => '20',
			"type" => "textarea"),

	array(	"name" => "CSS Quick Input",
			"type" => "title"),

	array(	"name" => 'Input your own css:',
			"desc" => '',
			"id" => $shortname."_css_input",
			"std" => '',
			"rows" => '20',
			"type" => "textarea"),

	array(	"type" => "close")
	/* End Input */
);
?>