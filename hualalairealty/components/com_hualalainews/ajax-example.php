<?php
require_once('../../configuration.php');
$JConfig 	= new JConfig();
$host 		= $JConfig->host;
$user 		= $JConfig->user;
$password 	= $JConfig->password;
$database	= $JConfig->db;
$prefix 	= $JConfig->dbprefix;
$room_type 	= $_GET['room_type'];
$h_id		= $_GET['h_id'];

	// Connect with the mysql with the "Hostname" and "username"
	$db = mysql_connect($host, $user, $password) or die ("Unable to connect to database");
	// Select the database "simec"
	mysql_select_db($database, $db) or die("Unable to select database");//require("car_connect.php");
	$ht_country_id = mysql_real_escape_string($ht_country_id);
		
		$table = $prefix."hbs_roomlisting";
		$query = "SELECT * FROM ".$table." WHERE h_id = $h_id AND room_type_id = $room_type";
		$qry_result = mysql_query($query) or die(mysql_error());
		$totalData2 = mysql_num_rows($qry_result);
		?>
		<select name="room_name_id" id="room_name_id" style="width: 150px" onChange="room_name_value(this.value);" >  
			<option value="0"><?php echo "-Select Room Name-";?></option>			
			<?php 
			while ($data = mysql_fetch_array($qry_result)){
			?>
				<option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
		    <?php 				
			}
			?>
        </select>&nbsp;<img id="loading_rname" src="components/com_availablescloseout/ajax-loader.gif" height="14" width="14" style="display:none" />		