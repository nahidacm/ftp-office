<?php // Custom post types and sortables/metaboxes. Result of many docs, guides and my own limited knowledge. Most credit go to SoulSizzle for sharing sortable ajax list script, and Devin Price for sharing knowledge about custom metaboxes, thank you.
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'designsentry_portf',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio' )
			),
		'public' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		'taxonomies' => array('category'),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'register_meta_box_cb' => 'add_url_metaboxes'
		)
	);
	register_post_type( 'designsentry_slider',
		array(
			'labels' => array(
				'name' => __( 'Slider' ),
				'singular_name' => __( 'Slider' )
			),
		'public' => true,
		'has_archive' => true,
		'exclude_from_search' => true,
		'menu_position' => 5,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'register_meta_box_cb' => 'add_url_metaboxes'
		)
	);
}
add_filter( 'manage_edit-designsentry_slider_columns', 'designsentry_slider_custom_columns' );
add_filter( 'manage_edit-designsentry_portf_columns', 'designsentry_portf_custom_columns' );
add_action('admin_init','my_meta_init');
function my_meta_init() {
	add_meta_box('ds_alpha_metabox', 'Markup for slogan area:', 'ds_alpha_metabox', 'page', 'normal', 'high');
}
function add_url_metaboxes() {
    add_meta_box('ds_url_metabox', 'Image will link to: (enter full url)', 'ds_url_metabox', 'designsentry_slider', 'side', 'default');
    add_meta_box('ds_url_metabox', 'Image will link to: (enter full url)', 'ds_url_metabox', 'designsentry_portf', 'side', 'default');
}
function ds_url_metabox() {
    global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="urlmeta_noncename" id="urlmeta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered
    $url = get_post_meta($post->ID, 'ds_url', true);
    // Echo field
    echo '<input type="text" name="ds_url" value="' . $url  . '" class="widefat" />';
}
function ds_alpha_metabox() {
    global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="alphameta_noncename" id="alphameta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered
    $url = get_post_meta($post->ID, 'ds_alpha', true);
    // Echo field
    echo '<input type="text" name="ds_alpha" value="' . htmlspecialchars($url)  . '" class="widefat" />';
}
function ds_save_url_meta($post_id, $post) {
    // verify
    if ( !wp_verify_nonce( $_POST['urlmeta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    // user allowance
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
    // data into array
    $url_meta['ds_url'] = $_POST['ds_url'];
    // delegate
    foreach ($url_meta as $key => $value) { // Cycle through array
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If cf has value
            update_post_meta($post->ID, $key, $value);
        } else { // If not
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
}
add_action('save_post', 'ds_save_url_meta', 1, 2); // save the custom fields
function ds_save_alpha_meta($post_id, $post) {
    // verify
    if ( !wp_verify_nonce( $_POST['alphameta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
    // user allowance
    if ( !current_user_can( 'edit_page', $post->ID ))
        return $post->ID;
    // data into array
    $alpha_meta['ds_alpha'] = $_POST['ds_alpha'];
    // delegate
    foreach ($alpha_meta as $key => $value) { // Cycle through array
		$value = html_entity_decode($value);
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If cf has value
            update_post_meta($post->ID, $key, $value);
        } else { // If not
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
}
add_action('save_post', 'ds_save_alpha_meta', 1, 2); // save the custom fields
function designsentry_slider_custom_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Slide Name' ),
		'hascaption' => __( 'Caption' ),
		'haslink' => __( 'Is linking to' ),
		'thumbnail' => __( 'Slide-preview' ),
		'date' => __( 'Date' )
	);
	return $columns;
}
function designsentry_portf_custom_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Slide Name' ),
		'categories' => __( 'Belongs to categories' ),
		'hascaption' => __( 'Caption' ),
		'haslink' => __( 'Is linking to' ),
		'thumbnail' => __( 'Image-preview' ),
		'date' => __( 'Date' )
	);
	return $columns;
}
add_action( 'manage_designsentry_slider_posts_custom_column', 'designsentry_slider_manage_custom_columns', 10, 2 );
add_action( 'manage_designsentry_portf_posts_custom_column', 'designsentry_portf_manage_custom_columns', 10, 2 );
function designsentry_slider_manage_custom_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case "hascaption":
			if($post->post_content != ""){
				$text_handler = get_the_excerpt();
				echo substr($text_handler, 0, 50).'...';
			} else {echo '----';}
				break;
		case "haslink":
			if(get_post_meta($post->ID, "ds_url", true)){
				echo get_post_meta($post->ID, "ds_url", true);
			} else {echo '----';}
				break;
		case "thumbnail":
				$ds_thumb = get_post_thumbnail_id(); 
				$ds_image = vt_resize( $ds_thumb,'' , 95, 41, true );
				if(get_the_post_thumbnail($post->ID,'thumbnail')){echo '<img src="'.$ds_image['url'].'" alt="" />';}
				break;
		/* Breakout. */
		default :
			break;
	}
}
function designsentry_portf_manage_custom_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case "hascaption":
			if($post->post_content != ""){
				$text_handler = get_the_excerpt();
				echo substr($text_handler, 0, 50).'...';
			} else {echo '----';}
				break;
		case "haslink":
			if(get_post_meta($post->ID, "ds_url", true)){
				echo get_post_meta($post->ID, "ds_url", true);
			} else {echo '----';}
				break;
		case "thumbnail":
				$ds_thumb = get_post_thumbnail_id(); 
				$ds_image = vt_resize( $ds_thumb,'' , 95, 41, true );
				if(get_the_post_thumbnail($post->ID,'thumbnail')){echo '<img src="'.$ds_image['url'].'" alt="" />';}
				break;
		/* Breakout. */
		default :
			break;
	}
}
function designsentry_slider_sort() {
    add_submenu_page('edit.php?post_type=designsentry_slider', 'Sort Slides', 'Sort the slides', 'edit_posts', basename(__FILE__), 'designsentry_slider_sorter');
}
add_action('admin_menu' , 'designsentry_slider_sort');
function designsentry_slider_sorter() {
	$slides = new WP_Query('post_type=designsentry_slider&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
	<div id="wpoldbcg" class="wrap">
	<div class="icon32" id="icon-upload"><br></div>
	<h2>Sort the slides: <img src="<?php bloginfo('url'); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
	<span>The top slides will be displayed first.</span>
	<ul id="slide-list">
	<?php while ( $slides->have_posts() ) : $slides->the_post(); ?>
		<li id="<?php the_id(); ?>"><h5><?php the_title(); ?></h5><?php echo '<span>Drag and drop the slides to change their order.</span>'; $ds_thumb = get_post_thumbnail_id(); $ds_image = vt_resize( $ds_thumb,'' , 95, 41, true ); if(get_the_post_thumbnail($post->ID,'thumbnail')){echo '<img src="'.$ds_image['url'].'" alt="" class="alignright sortable_column" />';} ?></li>			
	<?php endwhile; ?>
	</div><!-- End div#wrap //-->
<?php
}
function designsentry_slide_print_styles() {
	global $pagenow;
	$pages = array('edit.php');
	if (in_array($pagenow, $pages))
		wp_enqueue_style('sortables', get_bloginfo('template_url').'/functions/css/sortables.css');
}
add_action( 'admin_print_styles', 'designsentry_slide_print_styles' );
function designsentry_slide_print_scripts() {
	global $pagenow;
	$pages = array('edit.php');
	if (in_array($pagenow, $pages)) {
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('sortables', get_bloginfo('template_url').'/functions/js/sortables.js');
	}
}
add_action( 'admin_print_scripts', 'designsentry_slide_print_scripts' );
function designsentry_slide_save_order() {
	global $wpdb; // WordPress database class
 
	$order = explode(',', $_POST['order']);
	$counter = 0;
 
	foreach ($order as $sort_id) {
		$wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $sort_id) );
		$counter++;
	}
	die(1);
}
add_action('wp_ajax_slide_sort', 'designsentry_slide_save_order');
?>