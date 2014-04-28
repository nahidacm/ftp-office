<?php
/*
Plugin Name: EE Archives
Plugin URI: http://supergeeks.net/
Description: EE Archives Plugin as well as widget
Author: SuperGeeks Team
Version: 1
Author URI: http://supergeeks.net/
*/

function widget_eeArchives() {
	global $wpdb, $wp_locale;
	
	$args = '';
	$defaults = array(
		'type' => 'monthly', 'limit' => '',
		'format' => 'html', 'before' => '',
		'after' => '', 'show_post_count' => false,
		'echo' => 0
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( '' == $type )
		$type = 'monthly';

	if ( '' != $limit ) {
		$limit = absint($limit);
		$limit = ' LIMIT '.$limit;
	}
	//filters
	$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
	$join = apply_filters( 'getarchives_join', '', $r );

	
	
	
	//var_dump($archive);
	$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		if ( $arcresults ) {
			$afterafter = $after;
			//var_dump($arcresults);
		?>
		<table width="130" cellspacing="0" cellpadding="0" border="0" class="archive2 fl" summary="">
			<tbody>
				<tr>
					<td colspan="2">
						<img width="129" height="11" alt="img" src="<?php bloginfo('template_directory'); ?>/images/archives.jpg">
					</td>
				</tr>
				<tr>
					<td height="10" colspan="2"></td>
				</tr>
		<?php
	
			foreach ( (array) $arcresults as $arcresult ) {
		?>
				<tr>
					<td width="80">
					<a href="<?php echo get_month_link( $arcresult->year, $arcresult->month ); ?>">
						<?php printf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year); ?>
					</a>
					</td>
					<td width="50" align="right">
						<?php echo $arcresult->posts; ?> posts
					</td>
				</tr>
			<?php
			}
			?>
				<!--<tr>
					<td height="10" colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2">
						<a href="javascript:void(0);"><img width="129" height="6" alt="img" src="<?php //bloginfo('template_directory'); ?>/images/see_more.jpg"></a>
					</td>
				</tr>-->
			</tbody></table>
			<?php
		}
	//var_dump($output);
}
 
function eeArchives_init(){
  register_sidebar_widget(__('EE Archives'), 'widget_eeArchives');
}
add_action("plugins_loaded", "eeArchives_init");
?>