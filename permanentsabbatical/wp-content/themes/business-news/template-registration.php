<?php
/*
Template Name: Registration
*/
get_header();		
//Check whether the user is already logged in
if (!$user_ID) {

		if($_POST){
			//We shall SQL escape all inputs
			$user_name_post = $wpdb->escape($_POST['username']);
			if(empty($user_name_post)) { 
				_e("User name should not be empty.","weblionmedia");
				exit();
			}
			$email = $wpdb->escape($_POST['email']);
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) { 
				_e("Please enter a valid email.","weblionmedia");
				exit();
			}		
		
				$random_password = wp_generate_password( 12, false );
				$status = wp_create_user( $user_name_post, $random_password, $email );
				if ( is_wp_error($status) )
					_e("Username already exists. Please try another one.","weblionmedia");
				else {
					$from = get_option('admin_email');
					$headers = __("From:","weblionmedia").' '.$from . "\r\n";
					$subject = __("Registration successful","weblionmedia");
					$msg = __("Registration successful.\nYour login details\nUsername: $user_name_post\nPassword: $random_password","weblionmedia");
					wp_mail( $email, $subject, $msg, $headers );

					_e("Please check your email for login details.","weblionmedia");
				}
			//exit();			
		} else { 	
			?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; // end of the loop. ?>

			<?php 					
				if(get_option('users_can_register')) { //Check whether user registration is enabled by the administrator
			?>
				
				<p class="general_title" id="register"><span><?php _e('Join The Conversation','weblionmedia'); ?></span></p>
				<div class="separator" style="height:39px;"></div>
				
				<div class="block_registration">
					
					<div id="result"></div>
					
					<form action="#" class="w_validation" id="wp_signup_form" method="post">
					
						<div class="col_1">
							<div class="label"><p><?php _e('Login','weblionmedia'); ?><span>*</span>:</p></div>
							<div class="field"><input type="text" name="username" class="req" value="" /></div>
							<div class="clearboth"></div>
							<div class="separator" style="height:14px;"></div>
							
							<div class="label"><p><?php _e('E-mail','weblionmedia'); ?><span>*</span>:</p></div>
							<div class="field"><input type="text" name="email" class="req" value="" /></div>
							<div class="clearboth"></div>
							<div class="separator" style="height:12px;"></div>

							<div class="label"><p><?php _e('Name','weblionmedia'); ?><span>*</span>:</p></div>
							<div class="field"><input type="text" name="first_name" id="first_name" class="req" value="" /></div>
							<div class="clearboth"></div>
							<div class="separator" style="height:12px;"></div>
							
							<div class="label"><p><?php _e('Surname','weblionmedia'); ?><span>*</span>:</p></div>
							<div class="field"><input type="text" name="last_name" id="last_name" class="req" value="" /></div>
							<div class="clearboth"></div>

						</div>
						
						<div class="col_2">

							<div class="label"><p><?php _e('Website','weblionmedia'); ?>:</p></div>
							<div class="field"><input type="text" name="url" id="url" value="" /></div>
							<div class="clearboth"></div>
							<div class="separator" style="height:14px;"></div>
							
							<div class="label"><p><?php _e('Twitter','weblionmedia'); ?>:</p></div>
							<div class="field"><input type="text" name="user_twitter" id="user_twitter" value="" /></div>
							<div class="clearboth"></div>
							<div class="separator" style="height:12px;"></div>
						
							<div class="label"><p><?php _e('Gender','weblionmedia'); ?>:</p></div>
							<div class="checkbox"><input class="sliding_checkbox" name="user_gender" id="user_gender" type="checkbox"></div>
							<script type="text/javascript">
								jQuery(document).ready(function (){
									jQuery('.sliding_checkbox').iButton({
										labelOn : 'Female',
										labelOff : 'Male',
										resizeHandle : false,
										resizeContainer : false
									});
								});
							</script>
							<div class="clearboth"></div>
							<div class="separator" style="height:12px;"></div>
																
							
							<div class="label"><p><?php _e('Profession','weblionmedia'); ?>:</p></div>
							<div class="field"><input type="text" name="user_position" id="user_position" value="" /></div>
							<div class="clearboth"></div>
						</div>
						
						<div class="clearboth"></div>
						<div class="separator" style="height:32px;"></div>
						
						<p class="info_text"><?php _e('By clicking on the button "Register On Site" you agree to be the terms of service (<a href="#">User Agreement</a>)','weblionmedia'); ?></p>
						<p class="info_text"><input type="submit" name="submit" class="general_button" value="Register On Site"></p>
					</form>
				</div>						
				
			</div>
			
			<script type="text/javascript">  						
			jQuery("#submitbtn").click(function() {
				jQuery('#result').html('<img src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" class="loader" />').fadeIn();
				var input_data = jQuery('#wp_signup_form').serialize();
				jQuery.ajax({
					type: "POST",
					url:  "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
					data: input_data,
					success: function(msg){
						jQuery('.loader').remove();
						jQuery('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
					}
				});
				return false;
			});
			</script>
			
			<?php 
				} else {
					echo "<h5>".__("Registration is currently disabled. Please try again later.","weblionmedia")."</h5>";
				}
			} //end of if($_post)
	
} else {
	echo '<p class="general_title"><span>'.__('You are already logged in','weblionmedia').'</span></p>';
	echo '<p><br />'.__('To register, please','weblionmedia').' <a href="'.wp_logout_url(get_permalink()).'" class="lnk_blue"><strong>'.__('Log Out','weblionmedia').'.</strong></a></p>';
}
?>

<?php get_footer(); ?>