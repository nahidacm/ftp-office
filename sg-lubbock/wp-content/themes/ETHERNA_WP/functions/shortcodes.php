<?php
add_filter('widget_text', 'do_shortcode');
function span($atts, $content = null) {
	return '
<span>'.$content.'</span>
';
}
add_shortcode('span', 'span')
?>
<?php
function small($atts, $content = null) {
	return '
<small>'.$content.'</small>
';
}
add_shortcode('small', 'small')
?>
<?php
function strong($atts, $content = null) {
	return '
<strong>'.$content.'</strong>
';
}
add_shortcode('strong', 'strong')
?>
<?php
function h1w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h1 class="widgettitle">'.$content.'</h1>
';
}
add_shortcode('h1w', 'h1w')
?>
<?php
function h2w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h2 class="widgettitle">'.$content.'</h2>
';
}
add_shortcode('h2w', 'h2w')
?>
<?php
function h3w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h3 class="widgettitle">'.$content.'</h3>
';
}
add_shortcode('h3w', 'h3w')
?>
<?php
function h4w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h4 class="widgettitle">'.$content.'</h4>
';
}
add_shortcode('h4w', 'h4w')
?>
<?php
function h5w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h5 class="widgettitle">'.$content.'</h5>
';
}
add_shortcode('h5w', 'h5w')
?>
<?php
function h6w($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
	return '
<h6 class="widgettitle">'.$content.'</h6>
';
}
add_shortcode('h6w', 'h6w')
?>
<?php
function bullet_dot($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-dot">', $content, 1);
	return $content;
}
add_shortcode('listdot', 'bullet_dot')
?>
<?php
function bullet_check($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-check">', $content, 1);
	return $content;
}
add_shortcode('listcheck', 'bullet_check')
?>
<?php
function bullet_plus($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-plus">', $content, 1);
	return $content;
}
add_shortcode('listplus', 'bullet_plus')
?>
<?php
function bullet_cross($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-cross">', $content, 1);
	return $content;
}
add_shortcode('listcross', 'bullet_cross')
?>
<?php
function bullet_minus($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-minus">', $content, 1);
	return $content;
}
add_shortcode('listminus', 'bullet_minus')
?>
<?php
function bullet_info($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-info">', $content, 1);
	return $content;
}
add_shortcode('listinfo', 'bullet_info')
?>
<?php
function bullet_arrow($atts, $content = null) {
$content = preg_replace('/<ul>/', '<ul class="bullet-arrow">', $content, 1);
	return $content;
}
add_shortcode('listarrow', 'bullet_arrow')
?>
<?php
function hr() {
return '<div class="hr"><div class="inner_hr"></div></div>'; } add_shortcode('hr', 'hr');
?>
<?php
function br() {
return '<br />'; } add_shortcode('br', 'br');
?>
<?php
function clearfix() {
return '<div class="clearfix"></div>'; } add_shortcode('clear', 'clearfix');
?>
<?php
function gs_1a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_1">'.$content.'</div>
';
}
add_shortcode('gs_1a', 'gs_1a')
?>
<?php
function gs_1($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_1">'.$content.'</div>
';
}
add_shortcode('gs_1', 'gs_1')
?>
<?php
function gs_1z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_1 omega">'.$content.'</div>
';
}
add_shortcode('gs_1z', 'gs_1z')
?>
<?php
function gs_2a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_2">'.$content.'</div>
';
}
add_shortcode('gs_2a', 'gs_2a')
?>
<?php
function gs_2($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_2">'.$content.'</div>
';
}
add_shortcode('gs_2', 'gs_2')
?>
<?php
function gs_2z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_2 omega">'.$content.'</div>
';
}
add_shortcode('gs_2z', 'gs_2z')
?>
<?php
function gs_3a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_3">'.$content.'</div>
';
}
add_shortcode('gs_3a', 'gs_3a')
?>
<?php
function gs_3($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_3">'.$content.'</div>
';
}
add_shortcode('gs_3', 'gs_3')
?>
<?php
function gs_3z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_3 omega">'.$content.'</div>
';
}
add_shortcode('gs_3z', 'gs_3z')
?>
<?php
function gs_4a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_4">'.$content.'</div>
';
}
add_shortcode('gs_4a', 'gs_4a')
?>
<?php
function gs_4($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_4">'.$content.'</div>
';
}
add_shortcode('gs_4', 'gs_4')
?>
<?php
function gs_4z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_4 omega">'.$content.'</div>
';
}
add_shortcode('gs_4z', 'gs_4z')
?>
<?php
function gs_5a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_5">'.$content.'</div>
';
}
add_shortcode('gs_5a', 'gs_5a')
?>
<?php
function gs_5($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_5">'.$content.'</div>
';
}
add_shortcode('gs_5', 'gs_5')
?>
<?php
function gs_5z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_5 omega">'.$content.'</div>
';
}
add_shortcode('gs_5z', 'gs_5z')
?>
<?php
function gs_6a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_6">'.$content.'</div>
';
}
add_shortcode('gs_6a', 'gs_6a')
?>
<?php
function gs_6($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_6">'.$content.'</div>
';
}
add_shortcode('gs_6', 'gs_6')
?>
<?php
function gs_6z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_6 omega">'.$content.'</div>
';
}
add_shortcode('gs_6z', 'gs_6z')
?>
<?php
function gs_7a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_7">'.$content.'</div>
';
}
add_shortcode('gs_7a', 'gs_7a')
?>
<?php
function gs_7($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_7">'.$content.'</div>
';
}
add_shortcode('gs_7', 'gs_7')
?>
<?php
function gs_7z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_7 omega">'.$content.'</div>
';
}
add_shortcode('gs_7z', 'gs_7z')
?>
<?php
function gs_8a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_8">'.$content.'</div>
';
}
add_shortcode('gs_8a', 'gs_8a')
?>
<?php
function gs_8($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_8">'.$content.'</div>
';
}
add_shortcode('gs_8', 'gs_8')
?>
<?php
function gs_8z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_8 omega">'.$content.'</div>
';
}
add_shortcode('gs_8z', 'gs_8z')
?>
<?php
function gs_9a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_9">'.$content.'</div>
';
}
add_shortcode('gs_9a', 'gs_9a')
?>
<?php
function gs_9($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_9">'.$content.'</div>
';
}
add_shortcode('gs_9', 'gs_9')
?>
<?php
function gs_9z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_9 omega">'.$content.'</div>
';
}
add_shortcode('gs_9z', 'gs_9z')
?>
<?php
function gs_10a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_10">'.$content.'</div>
';
}
add_shortcode('gs_10a', 'gs_10a')
?>
<?php
function gs_10($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_10">'.$content.'</div>
';
}
add_shortcode('gs_10', 'gs_10')
?>
<?php
function gs_10z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_10 omega">'.$content.'</div>
';
}
add_shortcode('gs_10z', 'gs_10z')
?>
<?php
function gs_11a($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_11">'.$content.'</div>
';
}
add_shortcode('gs_11a', 'gs_11a')
?>
<?php
function gs_11($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_11">'.$content.'</div>
';
}
add_shortcode('gs_11', 'gs_11')
?>
<?php
function gs_11z($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="gs_11 omega">'.$content.'</div>
';
}
add_shortcode('gs_11z', 'gs_11z')
?>
<?php
function gs_12($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<div class="clearfix"></div><div class="gs_12">'.$content.'</div>
';
}
add_shortcode('gs_12', 'gs_12')
?>
<?php
function code_short($atts, $content = null) {
	return '
<code>'.$content.'</code>
';
}
add_shortcode('code', 'code_short')
?>
<?php
function pre_short($atts, $content = null) {
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return $content;
}
add_shortcode('pre', 'pre_short')
?>
<?php
function superbutton($atts, $content = null) {
	extract(shortcode_atts(array(
		"color" => '',
		"href" => 'http://'
	), $atts));
	return '<p><a class="superbutton '.$color.'" href="'.$href.'">'.$content.'</a></p>';
}
add_shortcode("superbutton", "superbutton");
?>
<?php
function superbuttoninline($atts, $content = null) {
	extract(shortcode_atts(array(
		"color" => '',
		"float" => '',
		"href" => 'http://'
	), $atts));
	return '<a class="superbutton '.$color.' '.$float.'" href="'.$href.'">'.$content.'</a>';
}
add_shortcode("superbuttoninline", "superbuttoninline");
?>
<?php
function toggler($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"title" => '',
		"onload" => ''
	), $atts));
	return '<h3 class="toggle '.$onload.'">'.$title.'</h3><div class="toggler '.$onload.'">'.$content.'</div>';
}
add_shortcode("toggler", "toggler");
?>
<?php
function togglerc($atts, $content = null) {
$content = do_shortcode( shortcode_unautop( $content ) );
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"title" => '',
		"onload" => ''
	), $atts));
	return '<h3 class="toggle '.$onload.'"><strong>'.$title.'</strong></h3><div class="toggler '.$onload.'">'.$content.'</div>';
}
add_shortcode("togglercolor", "togglerc");
?>
<?php
function conf_short($atts, $content = null) {
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<p class="confirmation">'.$content.'</p>
';
}
add_shortcode('confirmation', 'conf_short')
?>
<?php
function warn_short($atts, $content = null) {
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<p class="warning">'.$content.'</p>
';
}
add_shortcode('warning', 'warn_short')
?>
<?php
function info_short($atts, $content = null) {
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<p class="information">'.$content.'</p>
';
}
add_shortcode('info', 'info_short')
?>
<?php
function error_short($atts, $content = null) {
if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
$content = substr( $content, 4, strlen( $content ) - 7 );
	return '
<p class="error">'.$content.'</p>
';
}
add_shortcode('error', 'error_short')
?>
<?php
function blocka_short() {
return '</div></div></div><div class="endmain"></div><div class="startmain"></div><div class="main"><div class="inner_main second_block"><div class="container_alpha_nogradients">'; } add_shortcode('newblock', 'blocka_short');
?>
<?php
function blockap_short() {
return '</div></div></div><div class="endmain"></div><div class="startmain"></div><div class="main"><div class="inner_main second_block"><div class="container_alpha">'; } add_shortcode('newblockplus', 'blockap_short');
?>
<?php
function cgamma_short() {
return '</div><div class="container_gamma">'; } add_shortcode('c-gamma', 'cgamma_short');
?>
<?php
function cgammas_short() {
return '</div><div class="container_gamma slogan">'; } add_shortcode('c-gammaslogan', 'cgammas_short');
?>
<?php
function comega_short() {
return '</div><div class="container_omega">'; } add_shortcode('c-omega', 'comega_short');
?>
<?php
function comegas_short() {
return '</div><div class="container_omega slogan">'; } add_shortcode('c-omegaslogan', 'comegas_short');
?>
<?php
function comegap_short() {
return '</div><div class="container_omega_plus">'; } add_shortcode('c-omegaplus', 'comegap_short');
?>
<?php
function comegaps_short() {
return '</div><div class="container_omega_plus slogan">'; } add_shortcode('c-omegaplusslogan', 'comegaps_short');
?>
<?php
function cap_short($atts, $content = null) {
	extract(shortcode_atts(array(
		"ltr" => ''
	), $atts));
	return '<span class="dropcap">'.$ltr.'</span>';
}
add_shortcode("cap", "cap_short");
?>
<?php
function capc_short($atts, $content = null) {
	extract(shortcode_atts(array(
		"ltr" => ''
	), $atts));
	return '<span class="dropcapcolor">'.$ltr.'</span>';
}
add_shortcode("capc", "capc_short");
?>
<?php
function caps_short($atts, $content = null) {
	extract(shortcode_atts(array(
		"ltr" => ''
	), $atts));
	return '<span class="dropcapspot">'.$ltr.'</span>';
}
add_shortcode("caps", "caps_short");
?>
<?php
function pricing_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return '<div class="pricing">'.$content.'</div>';
}
add_shortcode("pricing", "pricing_short");
?>
<?php
function pricingcol_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"name" => '',
		"price" => '',
		"color" => ''
	), $atts));
	return '<div class="pricing_column"><div class="pricing_blurb '.$color.'"><h3>'.$name.'</h3><h2>'.$price.'</h2></div>'.$content.'</div>';
}
add_shortcode("crest", "pricingcol_short");
?>
<?php
function pricingspec_short($atts, $content = null) {
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return '<div class="specs"><p>'.$content.'</p></div>';
}
add_shortcode("spec", "pricingspec_short");
?>
<?php
function pricingbuy_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"name" => '',
		"href" => '',
		"color" => ''
	), $atts));
	return '<div class="buyme"><p><a class="superbutton '.$color.'" href="'.$href.'">'.$name.'</a></p></div>';
}
add_shortcode("buyme", "pricingbuy_short");
?>
<?php
function tabber_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return '<div class="ds_tabber_wrap">'.$content.'</div>';
}
add_shortcode("tabber", "tabber_short");
?>
<?php
function vtabber_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return '<div class="ds_vtabber_wrap">'.$content.'</div>';
}
add_shortcode("vtabber", "vtabber_short");
?>
<?php
function tabberl_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	return '<ul class="tabber">'.$content.'</ul>';
}
add_shortcode("tabs", "tabberl_short");
?>
<?php
function tabbert_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"id" => ''
	), $atts));
	$idx = str_replace(' ','_',$id);
	return '<li><a href="#ds_tab_'.$idx.'">'.$id.'</a></li>';
}
add_shortcode("tab", "tabbert_short");
?>
<?php
function tabbertab_short($atts, $content = null) {
$content = do_shortcode(shortcode_unautop($content));
$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	extract(shortcode_atts(array(
		"id" => ''
	), $atts));
	$id = str_replace(' ','_',$id);
	return '<div class="ds_tabber" id="ds_tab_'.$id.'">'.$content.'</div>';
}
add_shortcode("tab_content", "tabbertab_short");
?>
<?php
function sidebar($atts, $content = null) {
extract(shortcode_atts(array(
		"size" => '',
		"id" =>  ''
	), $atts));
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
$markup = '<ul class="gs_'.$size.' sidebar omega">';
ob_start();
if ( function_exists ( dynamic_sidebar($id) ) ){dynamic_sidebar($id);}
$markup.= ob_get_clean() . '</ul>';
return $markup;
}
add_shortcode('sidebar', 'sidebar')
?>
<?php
function sidebarm($atts, $content = null) {
extract(shortcode_atts(array(
		"size" => '',
		"id" =>  ''
	), $atts));
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
$markup = '<ul class="gs_'.$size.' sidebar_mirror">';
ob_start();
if ( function_exists ( dynamic_sidebar($id) ) ){dynamic_sidebar($id);}
$markup.= ob_get_clean() . '</ul>';
return $markup;
}
add_shortcode('sidebarmirror', 'sidebarm')
?>