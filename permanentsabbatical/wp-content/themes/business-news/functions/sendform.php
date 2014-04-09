<?php
	header('Content-Type: text/html; charset=utf-8');

	$wp_load_include = "../wp-load.php";
	$i = 0;
	while (!file_exists($wp_load_include) && $i++ < 9) {
		$wp_load_include = "../$wp_load_include";
	}
	//required to include wordpress file
	require($wp_load_include);

	global $shortname;
	$contact_form_email = get_option($shortname.'_contact_form_email');	


	$name = htmlspecialchars((isset($_POST['name']) ? $_POST['name'] : null));
	$subject = htmlspecialchars((isset($_POST['subject']) ? $_POST['subject'] : null));
	if (!$subject) $subject = "Contact Form Message!";

	$email_usr  = htmlspecialchars((isset($_POST['email']) ? $_POST['email'] : null));
	$message = htmlspecialchars((isset($_POST['message']) ? $_POST['message'] : null));
	$message = wordwrap($message,70);
	$email = $contact_form_email;
	$message_send = "Name: $name\r\n
	E-mail: $email_usr\r\n
	Message: $message\r\n\r\n
	### ".get_bloginfo('site_name') . " (" . home_url().") ###";
	$head = "Content-Type: text/plain; charset=\"utf-8\"\r\n";
	$head .= "X-Mailer: PHP/".phpversion()."\r\n";
	$head .= "Reply-To: $email_usr\r\n";
	$head .= "To: $email\r\n";
	$head .= "From: $email_usr\r\n";
	$head .= "Subject: $	\r\n";
	mail($email, $subject, $message_send, $head);
	unset($name, $subject, $email_usr, $message, $email, $subject, $message_send, $head);
?>