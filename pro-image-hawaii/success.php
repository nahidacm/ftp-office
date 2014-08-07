<?php
	// Work-around for setting up a session because Flash Player doesn't send the cookies
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}
	session_start();
?>
<?php

if(isset($_GET['from_email']))
{
	$email = strip_tags(stripslashes($_GET['from_email']));
	$store = $_GET['to_email'];
	$name = strip_tags(stripslashes($_GET['from_name']));
	$company = strip_tags(stripslashes($_GET['from_company']));
	$phone = strip_tags(stripslashes($_GET['from_phone1']));
	$location = $_GET['to_email'].'@proimagehawaii.com';
	
	if(!isset($_GET['instruction'])):
		$instruction = "none";
	else:
		$instruction = strip_tags(stripslashes($_GET['instruction']));
	endif;
	
	$mail_body = "Name: ".$name."<br />";
	$mail_body .= "Email: ".$email."<br />";
	$mail_body .= "Company: ".$company."<br />";
	$mail_body .= "Phone: ".$phone."<br />";
	$mail_body .= $_SESSION['mb_file_names'];
	$mail_body .= "Special Instructions: ".$instruction."<br /><br />";
	$subject = 'File Upload For '.$name.', '.$company;
		
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: ProImage <upload@proimagehawaii.com>' . "\r\n";		
		
		
	//echo  $location ."<br />".$subject ."<br />".$mail_body ."<br />".$headers;
		
	if(mail($location,$subject,$mail_body,$headers))
	{
		$mail_body .='Thank you.  We have successfully received your file(s).  A customer service representative will be contacting you via phone or email during our regular business hours.  If this is a rush order, please give us a call so we can get started on your order as soon as possible.  For store hours and contact information, visit <a href="http://www.proimagehawaii.com/locations">www.proimagehawaii.com/locations.</a><br />';
		mail($email,$subject,$mail_body,$headers);
		
		echo "<p><span style='color:#339900'><strong>Your file has been uploaded successfully.  A customer service representative will be contacting you soon.</strong></span></p>";
	}	
	else
		echo "<p><span style='color:#FF0000'><strong>Error</strong></span></p>";	
		
		echo '<script type="text/javascript">
				if (parent != self)
					top.scrollTo(0,0);
				else 
					self.scrollTo(0,0);
			  </script>';	

}

$_SESSION['mb_file_names'] = "";
exit(0);
?>