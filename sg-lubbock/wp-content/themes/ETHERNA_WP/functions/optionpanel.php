<?php function ds_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=optionpanel.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=optionpanel.php&reset=true");
            die;

        }
    }

	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'ds_admin');  
}

function ds_add_init() {
if (is_admin() && ( $_GET['page'] == 'optionpanel.php' ) ){
$file_dir=get_bloginfo('template_directory');
wp_enqueue_script('jquery');
wp_enqueue_style("functions", $file_dir."/functions/css/style.css", false, "1.0", "all");
wp_enqueue_script("jquery-ui", "http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js", false, "1.0");
wp_enqueue_script("plugins", $file_dir."/functions/js/plugins.js", false, "1.0");
wp_enqueue_script("script", $file_dir."/functions/js/script.js", false, "1.0");
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
}
}

function ds_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div id="designsentry">
<h2 class="toplogo"><img src="<?php bloginfo('template_url'); ?>/functions/css/img/logo.png" alt="" /></h2>
<form method="post" enctype="multipart/form-data" >

<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
		case "open":
		?>
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
		?>
		<ul class="ds_tab">
			<li><a href="#designsentry-1"><span class="ico_home designsentry-1"></span>General</a></li>
			<li><a href="#designsentry-2"><span class="ico_color designsentry-2"></span>Colors</a></li>
			<li><a href="#designsentry-3"><span class="ico_logo designsentry-3"></span>Logo</a></li>
			<li><a href="#designsentry-4"><span class="ico_hammer designsentry-4"></span>Slider</a></li>
			<li><a href="#designsentry-5"><span class="ico_social designsentry-5"></span>Blogs</a></li>
			<li><a href="#designsentry-6"><span class="ico_footer designsentry-6"></span>Single Posts</a></li>
			<li><a href="#designsentry-7"><span class="ico_color designsentry-7"></span>Portfolio</a></li>
			<li><a href="#designsentry-8"><span class="ico_add designsentry-8"></span>Search</a></li>
			<li><a href="#designsentry-10"><span class="ico_stats designsentry-10"></span>Statistics</a></li>
			<li><a href="#designsentry-12"><span class="ico_footer designsentry-12"></span>Footer</a></li>
			<li><a href="#designsentry-14"><span class="ico_user designsentry-14"></span>Advanced User</a></li>
			<li><a href="#designsentry-15"><span class="ico_puzzle designsentry-15"></span>Twitter Widget</a></li>
			<li><a href="#designsentry-16"><span class="ico_input designsentry-16"></span>Input</a></li>
		</ul>
        
        
		<?php break;
		
		case "tab":
		?>
        <div id="designsentry-<?php echo $value['tabid']; ?>" class="tab"><p class="submit button_save"><input name="save" type="submit" value="Save changes" /><input type="hidden" name="action" value="save" /></p>
        
		
        <?php break;
		
		case "close":
		?>
        </div>
        
        
		<?php break;
		
		case "title":
		?>
		<h2><?php echo $value['name']; ?>:</h2>
		 
		 
		 <?php break;
		
		case "colorpicker":
		?>
		<div class="setting"><h3><?php echo $value['name']; ?> <span id="cs_<?php echo $value['id']; ?>" class="color_switch"></span></h3>
		<script>
		jQuery(document).ready(function($) {
			<?php if(get_option( $value['id'] ) != ""){ ?>var setcolor = '<?php echo get_option($value['id']); ?>';
			jQuery('#cs_<?php echo $value['id']; ?>').css({'background':setcolor}); <?php } ?>
			jQuery('#<?php echo $value['id']; ?>').ColorPicker({
			onSubmit: function(hsb, hex, rgb) {
				jQuery('#<?php echo $value['id']; ?>').val('#'+hex);
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor(this.value);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#cs_<?php echo $value['id']; ?>').css({'background':'#'+hex});
				jQuery('#<?php echo $value['id']; ?>').attr('value', '#'+hex);
				}
			})
			.bind('keyup', function(){
				jQuery(this).ColorPickerSetColor(this.value);
			});
		});
		</script>
		<p><input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" title="<?php echo $value['std']; ?>" /></p>
		</div>
		
		
        
		<?php break;

		case 'text':
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<p><input type="<?php echo $value['type']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" title="<?php echo $value['std']; ?>" /></p>
		</div>
		
		
        
		<?php break;

		case 'textarea':
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<p><textarea name="<?php echo $value['id']; ?>" rows="<?php echo $value['rows']; ?>" ><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])); } else { echo stripslashes($value['std']); } ?></textarea></p>
		</div>
        
		
		<?php break;

		case 'upload':
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<p><input id="<?php echo $value['id']; ?>" type="text" name="<?php echo $value['id']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" /></p>
		<p class="submit uploadx"><input id="<?php echo $value['id']; ?>_button" type="button" value="Upload Image" class="upload_image_button" /></p>
		</div>
		
		
		<?php 
		break;
		
		case 'eq':
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<div class="columnbox">
			<div class="eq">
				<span><?php if($ds_eth_footer_grid1_val1){echo $ds_eth_footer_grid1_val1;} else{echo '0';} ?></span>
				<span><?php if($ds_eth_footer_grid1_val2){echo $ds_eth_footer_grid1_val2;} else{echo '0';} ?></span>
				<span><?php if($ds_eth_footer_grid1_val3){echo $ds_eth_footer_grid1_val3;} else{echo '0';} ?></span>
				<span><?php if($ds_eth_footer_grid1_val4){echo $ds_eth_footer_grid1_val4;} else{echo '0';} ?></span>
				<span><?php if($ds_eth_footer_grid1_val5){echo $ds_eth_footer_grid1_val5;} else{echo '0';} ?></span>
				<span><?php if($ds_eth_footer_grid1_val6){echo $ds_eth_footer_grid1_val6;} else{echo '0';} ?></span>
			</div>
		</div>
		<div class="columnboxdesc">
			<input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['valx']; ?>" value="<?php if (get_option($value['id']) != "") {echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
			
		<?php 
		break;
		
		case 'eq_mid':
		?>
			<input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['valx']; ?>" value="<?php if (get_option($value['id']) != "") {echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
			
		<?php 
		break;
		
		case 'eq_close':
		?>
			<input type="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['valx']; ?>" value="<?php if (get_option($value['id']) != "") {echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" />
		</div>
		<span id="amount" class="columnboxdescsum"></span>
		<script>jQuery(document).ready(function() {
		function refreshSwatch() {
		var eq1 = jQuery(this).parent().find('span:nth-child(1)').slider( "value" ),
			eq2 = jQuery(this).parent().find('span:nth-child(2)').slider( "value" ),
			eq3 = jQuery(this).parent().find('span:nth-child(3)').slider( "value" ),
			eq4 = jQuery(this).parent().find('span:nth-child(4)').slider( "value" ),
			eq5 = jQuery(this).parent().find('span:nth-child(5)').slider( "value" ),
			eq6 = jQuery(this).parent().find('span:nth-child(6)').slider( "value" ),
			suma = eq1+eq2+eq3+eq4+eq5+eq6;
		jQuery( "#designsentry #amount" ).text( "Overall row size (can't exceed 12): " + suma );
		jQuery( "#designsentry #amount1" ).val( eq1 );
		jQuery( "#designsentry #amount2" ).val( eq2 );
		jQuery( "#designsentry #amount3" ).val( eq3 );
		jQuery( "#designsentry #amount4" ).val( eq4 );
		jQuery( "#designsentry #amount5" ).val( eq5 );
		jQuery( "#designsentry #amount6" ).val( eq6 );
	}
				jQuery("#designsentry .eq").each(function(){
				jQuery(this).find('span').each(function(){
				var value = parseInt(jQuery(this).text());
				jQuery(this).empty().slider({
					orientation: "vertical",
					value: value,
					range: "min",
					max: 12,
					step:2,
					animate: true,
					slide: refreshSwatch,
					change: refreshSwatch
				});
				});
				});
});</script></div>
		
       
		<?php 
		break;
		
		case 'select':
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
        <p><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"';} ?>><?php echo $option; ?></option><?php } ?></select></p>
		</div>
		
		<?php
        break;
            
		case "checkbox":
		?>
		
		<?php
        break;
            
		case "radio":
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<div class="radiox">
			<?php foreach ($value['options'] as $key => $radio_option) { ?><label><input type="<?php echo $value['type']; ?>" name="<?php echo $value['id']; ?>" value="<?php echo $radio_option; ?>" <?php if (get_option($value['id']) == $radio_option) {echo ' checked="checked"'; } elseif (get_option($value['id']) === FALSE && $radio_option == $value['std']) { echo ' checked="checked"'; } ?> /><?php echo $key; ?></label><?php } ?>
		</div></div>
		
		<?php
        break;
            
		case "category_list":
		?>
		<div class="setting"><h3><?php echo $value['name']; ?></h3>
		<div class="checkx">
		<p><?php $categories = get_categories();
		foreach ($categories as $cat){
		$catids = $cat->cat_ID;
		$input_id = $value['id'] . '_' . $cat->cat_ID;
		$checkbox_setting = get_option($value['id']);
		if($checkbox_setting){if (in_array($cat->cat_ID, $checkbox_setting)) $checked = 'checked="checked"'; else $checked = '';}else{$checked = '';}
		?>
		<label><input type="checkbox" name="<?php echo $value['id']; ?>[]" id="<?php echo $input_id; ?>" value="<?php echo $catids; ?>" <?php echo $checked; ?> /> <?php echo($cat->name); ?></label>
		<?php } ?>
		</div></div>
		
        <?php break;
} 
}
?></form>
<form method="post">
<p class="submit button_reset">
<input name="reset" type="submit" value="Reset All Settings" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
</div>
<?php
}
add_action('admin_init', 'ds_add_init');
add_action('admin_menu', 'ds_add_admin'); ?>