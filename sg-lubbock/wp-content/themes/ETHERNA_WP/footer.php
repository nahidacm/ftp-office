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
	<div class="stripe"></div>
	<div id="footer_top"></div>
	<div id="footer">
		<?php if(function_exists(dynamic_sidebar(7))):
		dynamic_sidebar(7);
		endif; ?>
	</div>
	<?php if($ds_eth_adv_user_copy == 'No'){ ?>
	<div id="footer_bottom" class="png_bg"><p>Copyrights &copy; <a href="<?php echo $ds_eth_company_web; ?>"><?php echo $ds_eth_company_name; ?></a> <?php echo $ds_eth_company_year; ?>-<?php echo date('Y'); ?>. All rights reserved.</p></div>
	<?php } else {echo '<div id="footer_bottom" class="png_bg">' . stripslashes($ds_eth_adv_user_copymarkup) . '</div>';} ?>
	<!-- /footer -->
  </div> <!--/#container -->
  <?php wp_footer(); ?>
</body>
</html>