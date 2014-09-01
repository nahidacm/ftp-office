<script>
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
<?php if($ds_eth_google_anal){ ?>
	var _gaq=[['_setAccount','<?php echo $ds_eth_google_anal; ?>'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
<?php } ?>
jQuery(document).ready(function() {
	jQuery('.tweeter_widget').each(function(){
		var usernameid = this.id;
		jQuery(this).tweet({
			join_text: "auto",
			username: usernameid,
			avatar_size: <?php echo $ds_eth_twit_ava; ?>,
			count: <?php echo $ds_eth_twit_nr; ?>,
			auto_join_text_default: "",
			auto_join_text_ed: "",
			auto_join_text_ing: "",
			auto_join_text_reply: "",
			auto_join_text_url: "",
			loading_text: "<?php echo $ds_eth_twit_load; ?>"
		});
	});
});
jQuery(window).load(function(){
<?php if((is_page_template('mainpage.php'))||(is_page_template('mainpage-blog.php'))){ ?>
	jQuery('#slider').fadeIn(900);
	jQuery('.inner_main .loader').css({display: "none"});
	jQuery('#slider').nivoSlider({
		directionNav:false,
		effect:'<?php echo $ds_eth_slider_effect; ?>',
		captionOpacity:1,
		slices:<?php echo $ds_eth_slider_slice; ?>,
		animSpeed:<?php echo $ds_eth_slider_anim; ?>,
		controlNav:<?php echo $ds_eth_slider_dots; ?>,
		pauseTime:<?php echo $ds_eth_slider_pause; ?>,
		keyboardNav:true,
		pauseOnHover:true
	});
	jQuery('.inner_main .nivoSlider').append('<div class="slider_cover_tl png_bg"></div><div class="slider_cover_tr png_bg"></div><div class="slider_cover_br png_bg"></div><div class="slider_cover_bl png_bg"></div>');
	var dotsMargin = jQuery('.inner_main .nivo-controlNav').width();
	jQuery('.inner_main .nivo-controlNav').css('margin-left', -dotsMargin/2);
<?php } ?>
<?php if($ds_eth_js_input){
echo stripslashes($ds_eth_js_input);
} ?>
});
</script>