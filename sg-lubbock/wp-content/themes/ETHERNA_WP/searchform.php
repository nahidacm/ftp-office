<div class="search">
	<form id="search_form" action="<?php bloginfo('url'); ?>" method="get">
		<input id="search_input" type="text" value="<?php if(trim(wp_specialchars($s,1))!='') echo trim(wp_specialchars($s,1));else echo ' ';?>" name="s">
		<input id="search_submit" type="submit" value="<?php _e('search'); ?>" name="SearchSubmit">
	</form>
</div>