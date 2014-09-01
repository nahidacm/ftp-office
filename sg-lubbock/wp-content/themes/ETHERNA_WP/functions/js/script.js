jQuery(function(){
	var tabContainers = jQuery('#designsentry form > div');
	if(jQuery.cookie("ds_theme_options")){var cookiezz = jQuery.cookie("ds_theme_options").replace("#", ".");}else{jQuery.cookie("ds_theme_options", "#designsentry-1"); var cookiezz = jQuery.cookie("ds_theme_options").replace("#", ".");}
	jQuery(cookiezz).parent().parent().addClass('selected');
    tabContainers.not(jQuery.cookie("ds_theme_options")).hide();
    jQuery('#designsentry ul.ds_tab a').click(function () {
        tabContainers.hide().filter(this.hash).fadeIn(500);
		jQuery.cookie("ds_theme_options", this.hash);
        jQuery('#designsentry ul.ds_tab li').removeClass('selected');
        jQuery(this).parent().addClass('selected');
        return false;
    });
	
	if (jQuery("#message").length > 0){
		jQuery('#message').hide().slideDown(400).delay(2000).slideUp(400);
	}
	
	/* Clear input on focus in fields */
	jQuery('#designsentry input').focus(function()
	{if(jQuery(this).val()==jQuery(this).attr('title'))
	{jQuery(this).val('');}
	});
	/* If field is empty afterward, add description text again */
	jQuery('#designsentry input').blur(function()
	{if(jQuery(this).val()==''){
	jQuery(this).val(jQuery(this).attr('title'));
	}});
	
	jQuery("#designsentry select, #designsentry input:checkbox, #designsentry input:radio, #designsentry input:file").uniform();
	
	var txtBox_id = '';
	jQuery('.upload_image_button').click(function() {
		txtBox_id = '#'+jQuery(this).attr('id').replace('_button', '');
		formfield = jQuery(txtBox_id);
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery(txtBox_id).val(imgurl);
		tb_remove();
	}
	jQuery('.button_reset input').click(function(){
		var answer = confirm('Reset all settings?');
		return answer;
	});  
});