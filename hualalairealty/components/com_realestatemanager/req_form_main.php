<?php
include('../../configuration.php');


$JConfig 		= new JConfig();
$host 			= $JConfig->host;
$user 			= $JConfig->user;
$password 		= $JConfig->password;
$database		= $JConfig->db;
$prefix 		= $JConfig->dbprefix;
$SmtpServer		= $JConfig->smtphost;
$SmtpPort		= $JConfig->smtpport;
$SmtpUser		= $JConfig->smtpuser;
$SmtpPass		= $JConfig->smtppass;
$fromName 		= $JConfig->sitename;
$fromEmail 		= $JConfig->mailfrom;


function authgMail($from, $namefrom, $to, $nameto, $subject, $message) {


$smtpServer = "mail.hualalairealty.com";   	//ip address of the mail server.  This can also be the local dmain name
$port = "8889";					 // should be 25 by default, but needs to be whichever port the mail server will be using for smtp 
$timeout = "45";				 // typical timeout. try 45 for slow servers
$username = "HualalaiRealty@hualalairealty.com"; // the login for your smtp
$password = "4sSoesman!";			// the password for your smtp
$localhost = "127.0.0.1";	   		// Defined for the web server.  Since this is where we are gathering the details for the email
$newLine = "\r\n";			 	// aka, carrage return line feed. var just for newlines in MS
$secure = 0;				  	// change to 1 if your server is running under SSL

//connect to the host and port
$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
$smtpResponse = fgets($smtpConnect, 4096);
if(empty($smtpConnect)) {
   $output = "Failed to connect: $smtpResponse";
   echo $output;
   return $output;
}
else {
   $logArray['connection'] = "<p>Connected to: $smtpResponse";
   echo "<p />connection accepted<br>".$smtpResponse."<p />Continuing<p />";
}

//you have to say HELO again after TLS is started
   fputs($smtpConnect, "HELO $localhost". $newLine);
   $smtpResponse = fgets($smtpConnect, 4096);
   $logArray['heloresponse2'] = "$smtpResponse";
//request for auth login
fputs($smtpConnect,"AUTH LOGIN" . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['authrequest'] = "$smtpResponse";

//send the username
fputs($smtpConnect, base64_encode($username) . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['authusername'] = "$smtpResponse";

//send the password
fputs($smtpConnect, base64_encode($password) . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['authpassword'] = "$smtpResponse";

//email from
fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['mailfromresponse'] = "$smtpResponse";

//email to
fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['mailtoresponse'] = "$smtpResponse";

//the email
fputs($smtpConnect, "DATA" . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['data1response'] = "$smtpResponse";

//construct headers
$headers = "MIME-Version: 1.0" . $newLine;
$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
$headers .= "To: $nameto <$to>" . $newLine;
$headers .= "From: $namefrom <$from>" . $newLine;

//observe the . after the newline, it signals the end of message
fputs($smtpConnect, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['data2response'] = "$smtpResponse";

// say goodbye
fputs($smtpConnect,"QUIT" . $newLine);
$smtpResponse = fgets($smtpConnect, 4096);
$logArray['quitresponse'] = "$smtpResponse";
$logArray['quitcode'] = substr($smtpResponse,0,3);
fclose($smtpConnect);
//a return value of 221 in $retVal["quitcode"] is a success
return($logArray);
}



if ($_REQUEST['chkProperty']){
	$chkProperty = "Yes";
}else{
	$chkProperty = "No";
}
if ($_REQUEST['chkMaintence']){
	$chkMaintence = "Yes";
}else{
	$chkMaintence = "No";
}
if ($_REQUEST['chkComparable']){
	$chkComparable = "Yes";
}else{
	$chkComparable = "No";
}

$to = 't.monzur@asthait.com';
$to = array("ssoesman@hualalairesort.com", "vtobias@hualalairesort.com", "acarty@hualalairesort.com", "t.monzur@asthait.com");

$subject = 'Request additional information: Property ID -> '.$_REQUEST['fk_houseid'];

$body = 'A customer has placed a request for.... <br /><br />';
$body .= "Property ID: ".$_REQUEST['fk_houseid']."<br />";
$body .= "Property Plans & Features: ".$chkProperty."<br />";
$body .= "Property Maintenance Costs: ".$chkMaintence."<br />";
$body .= "Comparable Sales: ".$chkComparable."<br />";
$body .= "Name: ".$_REQUEST['user_name']."<br />";
$body .= "Email Address: ".$_REQUEST['user_email']."<br />";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Hualalai Realty'. "\r\n";		
$mailReport = "Request additional information";

for ($i=0; $i<count($to); $i++){
	authgMail($fromEmail, $fromName, $to[$i], "", $subject, $body);	
}

mysql_connect($host, $user, $password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());

$sql = "INSERT INTO ".$prefix."rem_rent_request VALUES ('', '".$_REQUEST['fk_houseid']."', '0000-00-00', '', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '".$_REQUEST['user_name']."', '".$_REQUEST['user_email']."', '".$_REQUEST['chkProperty']."', '".$_REQUEST['chkMaintence']."', '".$_REQUEST['chkComparable']."', '', '0')";
mysql_query( $sql);				
?>