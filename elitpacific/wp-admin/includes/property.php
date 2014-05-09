<?php
/**
 * WordPress Post Administration API.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * Rename $_POST data from form names to DB post columns.
 *
 * Manipulates $_POST directly.
 *
 * @package WordPress
 * @since 2.6.0
 *
 * @param bool $update Are we updating a pre-existing post?
 * @param array $post_data Array of post data. Defaults to the contents of $_POST.
 * @return object|bool WP_Error on failure, true on success.
 */
/**
 * Update an existing post with values provided in $_POST.
 *
 * @since 1.5.0
 *
 * @param array $post_data Optional.
 * @return int Post ID.
 */
/**
 * Update an existing post with values provided in $_POST.
 *
 * @since 1.5.0
 *
 * @param array $post_data Optional.
 * @return int Post ID.
 */
 
require_once('tn.php'); 
 
function editproperty( $post_data = null ) {
	
	global $wpdb;
	
	$post_ID = (int) $post_data['property_id'];
	$view_len = strlen($post_data['view']);
	
/*	$agent_id = explode(",",$post_data['agent_id']);
		
	if($post_data['tenure']==2){
		$r_date = explode(" ",$post_data['lease_re_date']);
		$re_date = explode("-", $r_date[0]);
		$l_year= $re_date[0];
		$l_m = $re_date[1];
		$l_d = $re_date[2];
		$e_date = explode(" ",$post_data['lease_exp_date']);
		$ex_date = explode("-", $e_date[0]);
		$e_year= $ex_date[0];
		$e_m = $ex_date[1];
		$e_d = $ex_date[2];
	}
	if($post_data['pro_category'] ==3){
		$da_date = explode(" ",$post_data['date_available']);
		$dar_date = explode("-",$da_date[0]);
		$da_year = $dar_date[0];
		$da_m = $dar_date[1];
		$da_d = $dar_date[2];
	}	*/
	
	if($post_data['pro_category'] == '3' || $post_data['pro_category'] == '4')
	{
		$post_data['tenure']='';
	}
	
	if($post_data['tenure']=='2'){
		$lease_re_date = $post_data['l_year'].'-'.$post_data['l_m'].'-'.$post_data['l_d'].' '.'00:00:00';
		$lease_exp_date = $post_data['e_year'].'-'.$post_data['e_m'].'-'.$post_data['e_d'].' '.'00:00:00';
	}
	if($post_data['pro_category'] == 3)
	{
		$rental_date_available = $post_data['da_year'].'-'.$post_data['da_m'].'-'.$post_data['da_d'].' '.'00:00:00';
	}	
		
	$post_len = count($_POST);
	$coma = ", "; 	
	$indx = 0;				
	$file_path = ABSPATH."up_data/properties/";
	
	$propImg = $post_data['propImg'];

	for($i = 0 ; $i<=count($propImg); $i++){						
			$row = $wpdb->get_results("SELECT * FROM e_p_pics WHERE id =".$propImg[$i]);
			$file_path = 'up_data/properties/'.$row[0]->large;
						
			if(file_exists($file_path)){
				unlink($file_path);
			}	
		$wpdb->query("DELETE FROM e_p_pics WHERE id=".$propImg[$i]);			
	}
	if ($post_data['primaryImg']){
		$row = $wpdb->query("UPDATE e_p_pics SET primary_pic = 0 WHERE property_id =".(int) $post_ID);	
		$row = $wpdb->query("UPDATE e_p_pics SET primary_pic = 1 WHERE id =".(int) $post_data['primaryImg']);	
	}	
	$agent = $post_data['agent_id'];
	
	$wpdb->query(" UPDATE e_p_properties SET "				
		." property_name ='".$post_data['property_name']."', "
		." headline_1 = '".$post_data['headline_1']."', "
		." headline_2 = '".$post_data['headline_2']."', "
		." headline_3 = '".$post_data['headline_3']."', "
		." pro_category = '".$post_data['pro_category']."', "
		." agent_id = '".$agent[0]."', "
		." property_type = '".$post_data['property_type']."', "		
		." building_name = '".$post_data['building_name']."', "
		." pro_floor = '".$post_data['pro_floor']."', "
		." amenities = '".$post_data['amenities']."', "		
		." address = '".$post_data['address']."', "
		." city = '".$post_data['city']."', "
		." state_id = '".$post_data['state_id']."', "
		." zip_code = '".$post_data['zip_code']."', "
		." description = '".$post_data['content']."', "
		." neighbourhood = '".$post_data['neighborhood']."', "
		." no_of_bedrooms = '".$post_data['no_of_bedrooms']."', "
		." no_of_full_baths = '".$post_data['no_of_full_baths']."', "
		." no_of_half_baths = '".$post_data['no_of_half_baths']."', "
		." interior_sq_ft = '".$post_data['interior_sq_ft']."', "
		." open_lanai_sq_ft = '".$post_data['open_lanai_sq_ft']."', "
		." covered_lanai_sq_ft = '".$post_data['covered_lanai_sq_ft']."', "
		." parking = '".$post_data['parking']."', "
		." land_sq_ft = '".$post_data['land_sq_ft']."', "
		." tenure = '".$post_data['tenure']."', "	
		." pur_price_fee = '".$post_data['pur_price_fee']."', "
		." lease_rent = '".$post_data['lease_rent']."', "
		." lease_re_date = '".$lease_re_date."', "
		." lease_exp_date = '".$lease_exp_date."', "
		." monthly_rent = '".$post_data['monthly_rent']."', "
		." auction_price = '".$post_data['auction_price']."', "
		." sale_price = '".$post_data['sale_price']."', "				
		." property_frontage = '".$post_data['property_frontage']."', "
		." zoning = '".$post_data['zoning']."', "
		." year_built = '".$post_data['year_built']."', "
		." year_renovated = '".$post_data['year_renovated']."', "
		." property_condition = '".$post_data['property_condition']."', "
		." view = '".$post_data['view']."', "
		." no_of_stories = '".$post_data['no_of_stories']."', "
		." pool = '".$post_data['pool']."', "
		." assessed_value = '".$post_data['assessed_value']."', "
		." monthly_taxes = '".$post_data['monthly_taxes']."', "
		." monthly_maintenance_fee = '".$post_data['monthly_maintenance_fee']."', "
		." maintenance_fee_includes = '".$post_data['maintenance_fee_includes']."', "
		." hoa_fee = '".$post_data['hoa_fee']."', "
		." elementary_school = '".$post_data['elementary_school']."', "
		." middle_school = '".$post_data['middle_school']."', "
		." high_school = '".$post_data['high_school']."', "
		." primary_mls = '".$post_data['primary_mls']."', "
		." mls_no = '".$post_data['mls_no']."', "
		." tax_map_key = '".$post_data['tax_map_key']."', "
		." other = '".$post_data['other']."', "	
		." google_link = '".$post_data['google_link']."', "	
		." map = '".$post_data['map']."', "	
		." link_title1 = '".$post_data['link_title1']."', "
		." link_url1 = '".$post_data['link_url1']."', "
		." link_title2 = '".$post_data['link_title2']."', "
		." link_url2 = '".$post_data['link_url2']."', "
		." link_title3 = '".$post_data['link_title3']."', "
		." link_url3 = '".$post_data['link_url3']."', "
		." link_title4 = '".$post_data['link_title4']."', "
		." link_url4 = '".$post_data['link_url4']."', "
		." link_title5 = '".$post_data['link_title5']."', "
		." link_url5 = '".$post_data['link_url5']."', "
		." link_title6 = '".$post_data['link_title6']."', "
		." link_url6 = '".$post_data['link_url6']."', "
		." link_title7 = '".$post_data['link_title7']."', "
		." link_url7 = '".$post_data['link_url7']."', "
		." link_title8 = '".$post_data['link_title8']."', "
		." link_url8 = '".$post_data['link_url8']."', "
		." feature = '".$post_data['feature']."', "
		." status = '".$post_data['status']."', "
		." security_deposit = '".$post_data['security_deposit']."', "
		." date_available = '".$rental_date_available."', "
		." lease_terms = '".$post_data['lease_terms']."', "
		." appliances = '".$post_data['appliances']."', "
		." finishings = '".$post_data['finishings']."', "
		." flooring = '".$post_data['flooring']."', "
		." security = '".$post_data['security']."', "
		." unit_features = '".$post_data['unit_features']."', "
		." utilities = '".$post_data['utilities']."', "
		." furnished = '".$post_data['furnished']."', "
		." pet_policy = '".$post_data['pet_policy']."', "
		." yard = '".$post_data['yard']."', "
		." sleeps = '".$post_data['sleeps']."', "
		." bed_configuration = '".$post_data['bed_configuration']."', "
		." maximum_guests = '".$post_data['maximum_guests']."', "
		." reservation_restrictions = '".$post_data['reservation_restrictions']."', "
		." reservation_deposit_policy = '".$post_data['reservation_deposit_policy']."', "
		." payment_policy = '".$post_data['payment_policy']."', "
		." cancellation_policy = '".$post_data['cancellation_policy']."', "
		." payment_methods_accepted = '".$post_data['payment_methods_accepted']."', "
		." weekly_rent = '".$post_data['weekly_rent']."', "
		." nightly_rent = '".$post_data['nightly_rent']."', "
		." cleaning_fee = '".$post_data['cleaning_fee']."', "
		." furnishings = '".$post_data['furnishings']."', "
		." ac = '".$post_data['ac']."', "
		." spa = '".$post_data['spa']."', "
		." display_pos = '".$post_data['display_pos']."' "		
		." WHERE id = ".(int) $post_ID
	);

	if($_FILES['map']['name']!=''){
		$xt = strtolower(strrchr($_FILES['map']['name'],'.'));	
		if($xt != '.jpg' && $xt != '.gif')
			$errors .= '- Please upload only .JPG and .GIF Maps.<br />';	
	}
	
	$s_ordr = $wpdb->get_results("SELECT max(sort_order) AS id FROM e_p_pics WHERE property_id = '".$post_ID."'");	
	$s_ordr = $s_ordr[0]->id+1;	
	if($s_ordr==1)
		$pri = 1;
	else
		$pri = 0;
	
	$fileId= $file_count+1;
	session_start();	
	$sess_id = session_id();
	
	$newImageData = $wpdb->get_results("SELECT * FROM e_p_newpics WHERE sessId = '".$sess_id."'");
	
	if (count($newImageData)){
	
		for ($i=0; $i<count($newImageData); $i++){
			
			$wpdb->query("INSERT INTO e_p_pics SET 
						id=NULL,
						property_id = ".$post_ID.",
						large = '".$newImageData[$i]->imageNewName."',
						primary_pic = '".$pri."',			
						sort_order = ".$s_ordr);
						
						$fileId++;
						$s_ordr=$s_ordr+1;
						if($pri==1)
							$pri=0;
		}
		$wpdb->query("DELETE FROM e_p_newpics WHERE sessId='".$sess_id."'");
	}

		/*foreach($_FILES as $key => $val){
				$t 			= time();
				$fname 		= $val['name'];
				$img_name 	= $post_ID."_".$t."_".$fileId;
				$fileExt	= substr($fname, strrpos($fname , "."));
				$fileExt 	= strtolower($fileExt);
				$img_path 	= "$img_name"."$fileExt";
				$img_dir 	= ABSPATH."up_data/properties/$img_name"."$fileExt";		
				
				if ($val['tmp_name']){
					copy($val['tmp_name'], $img_dir);				
				
				$wpdb->query("INSERT INTO e_p_pics SET 
					id=NULL,
					property_id = ".$post_ID.",
					large = '".$img_path."',
					primary_pic = '".$pri."',			
					sort_order = ".$s_ordr);
					
					$fileId++;
					$s_ordr=$s_ordr+1;
					if($pri==1)
						$pri=0;
				}
		}*/
		
		
		
	return $post_ID;
}


function addproperty( $post_data = null ) {
	
	global $wpdb;
	
	$post_ID = (int) $post_data['property_id'];
	
	$view_len = strlen($post_data['view']);
	
	if(is_array($post_data['agent_id']))
	{
		$agent_id = implode(",",$_REQUEST['agent_id']);
	}
	
	/*if($post_data['tenure']==2){
		$r_date = explode(" ",$post_data['lease_re_date']);
		$re_date = explode("-", $r_date[0]);
		$l_year= $re_date[0];
		$l_m = $re_date[1];
		$l_d = $re_date[2];
		$e_date = explode(" ",$post_data['lease_exp_date']);
		$ex_date = explode("-", $e_date[0]);
		$e_year= $ex_date[0];
		$e_m = $ex_date[1];
		$e_d = $ex_date[2];
	}
	if($post_data['pro_category'] ==3){
	
		$da_date = explode(" ",$post_data['date_available']);
		$dar_date = explode("-",$da_date[0]);
		$da_year = $dar_date[0];
		$da_m = $dar_date[1];
		$da_d = $dar_date[2];
	}	*/
	
	if($post_data['tenure']=='2'){
		$lease_re_date = $post_data['l_year'].'-'.$post_data['l_m'].'-'.$post_data['l_d'].' '.'00:00:00';
		$lease_exp_date = $post_data['e_year'].'-'.$post_data['e_m'].'-'.$post_data['e_d'].' '.'00:00:00';
	}
	if($post_data['pro_category'] == 3)
	{
		$rental_date_available = $post_data['da_year'].'-'.$post_data['da_m'].'-'.$post_data['da_d'].' '.'00:00:00';
	}
		
	$post_len = count($_POST);
	$coma = ", "; 	
	$indx = 0;				
	$file_path = ABSPATH."up_data/properties/";
	
	$propImg = $post_data['propImg'];

	for($i = 0 ; $i<=count($propImg); $i++){						
			$row = $wpdb->get_results("SELECT * FROM e_p_pics WHERE id =".$propImg[$i]);
			$file_path = 'up_data/properties/'.$row[0]->large;
						
			if(file_exists($file_path)){
				unlink($file_path);
			}	
		$wpdb->query("DELETE FROM e_p_pics WHERE id=".$propImg[$i]);			
	}
	
	$wpdb->query(" INSERT INTO e_p_properties "
		." ( property_name, headline_1, headline_2, headline_3, pro_category, agent_id, property_type, building_name, pro_floor, amenities, "
		." address, city, state_id, zip_code, description, neighbourhood,
		sleeps, bed_configuration, maximum_guests, no_of_bedrooms, no_of_full_baths, no_of_half_baths, interior_sq_ft,"	
		." open_lanai_sq_ft, covered_lanai_sq_ft, parking, land_sq_ft, tenure, pur_price_fee, lease_rent, lease_re_date, lease_exp_date, lease_terms, 	reservation_restrictions, reservation_deposit_policy, payment_policy, cancellation_policy, payment_methods_accepted, monthly_rent, weekly_rent, nightly_rent, date_available, security_deposit, cleaning_fee, auction_price, sale_price, property_frontage, zoning, year_built, year_renovated, property_condition, "
		." view, no_of_stories, appliances, finishings, flooring, furnishings, ac, security, utilities, furnished, pet_policy, yard, pool, spa,	assessed_value, monthly_taxes, monthly_maintenance_fee, maintenance_fee_includes, hoa_fee, elementary_school, "
		." middle_school, high_school, "
		." primary_mls, mls_no, tax_map_key, other, link_title1, link_url1, link_title2, link_url2, link_title3, link_url3, link_title4, link_url4, link_title5, "
		." link_url5, link_title6, link_url6, link_title7, link_url7, link_title8, link_url8, display_pos, feature, status ) VALUES ( "
		." '".$post_data['property_name']."', '".$post_data['headline_1']."', '".$post_data['headline_2']."', '".$post_data['headline_3']."', "
		." '".$post_data['pro_category']."', '".$post_data['agent_id'][0]."', '".$post_data['property_type']."', '".$post_data['building_name']."', '".$post_data['pro_floor']."', '".$post_data['amenities']."', '".$post_data['address']."', '".$post_data['city']."', '".$post_data['state_id']."', '".$post_data['zip_code']."', '".$post_data['content']."', '".$post_data['neighborhood']."', "		
		." '".$post_data['sleeps']."', "
		." '".$post_data['bed_configuration']."', "
		." '".$post_data['maximum_guests']."', "		
		." '".$post_data['no_of_bedrooms']."', '".$post_data['no_of_full_baths']."', '".$post_data['no_of_half_baths']."', '".$post_data['interior_sq_ft']."', "
		." '".$post_data['open_lanai_sq_ft']."', '".$post_data['covered_lanai_sq_ft']."', '".$post_data['parking']."', '".$post_data['land_sq_ft']."', "
		." '".$post_data['tenure']."', "		
		." '".$post_data['pur_price_fee']."', "
		." '".$post_data['lease_rent']."', "
		." '".$post_data['lease_re_date']."', "
		." '".$post_data['lease_exp_date']."', "
		." '".$post_data['lease_terms']."', "
		." '".$post_data['reservation_restrictions']."', "
		." '".$post_data['reservation_deposit_policy']."', "
		." '".$post_data['payment_policy']."', "
		." '".$post_data['cancellation_policy']."', "
		." '".$post_data['payment_methods_accepted']."', "
		." '".$post_data['monthly_rent']."', "
		." '".$post_data['weekly_rent']."', "		
		." '".$post_data['nightly_rent']."', "
		." '".$post_data['date_available']."', "
		." '".$post_data['security_deposit']."', "
		." '".$post_data['cleaning_fee']."', "
		." '".$post_data['auction_price']."', "
		." '".$post_data['sale_price']."', "		
		." '".$post_data['property_frontage']."', '".$post_data['zoning']."', '".$post_data['year_built']."', "
		." '".$post_data['year_renovated']."', '".$post_data['property_condition']."', '".$post_data['view']."', '".$post_data['no_of_stories']."', "
		." '".$post_data['appliances']."', "
		." '".$post_data['finishings']."', "
		." '".$post_data['flooring']."', "
		." '".$post_data['furnishings']."', "
		." '".$post_data['ac']."', "
		." '".$post_data['security']."', "
		." '".$post_data['utilities']."', "
		." '".$post_data['furnished']."', "
		." '".$post_data['pet_policy']."', "
		." '".$post_data['yard']."', "				
		." '".$post_data['pool']."', '".$post_data['spa']."', '".$post_data['assessed_value']."', '".$post_data['monthly_taxes']."', '".$post_data['monthly_maintenance_fee']."', "
		." '".$post_data['maintenance_fee_includes']."', '".$post_data['hoa_fee']."', '".$post_data['elementary_school']."', '".$post_data['middle_school']."', "
		." '".$post_data['high_school']."', '".$post_data['primary_mls']."', '".$post_data['mls_no']."', '".$post_data['tax_map_key']."', '".$post_data['other']."', "
		." '".$post_data['link_title1']."', '".$post_data['link_url1']."', '".$post_data['link_title2']."', '".$post_data['link_url2']."', "
		." '".$post_data['link_title3']."', '".$post_data['link_url3']."', '".$post_data['link_title4']."', '".$post_data['link_url4']."', "
		." '".$post_data['link_title5']."', '".$post_data['link_url5']."', '".$post_data['link_title6']."', '".$post_data['link_url6']."', "
		." '".$post_data['link_title7']."', '".$post_data['link_url7']."', '".$post_data['link_title8']."', '".$post_data['link_url8']."', "
		." '".$post_data['display_pos']."', '".$post_data['feature']."', '".$post_data['status']."' )"
	);
	
	$post_ID = $wpdb->insert_id;

	if($_FILES['map']['name']!=''){
		echo $xt = strtolower(strrchr($_FILES['map']['name'],'.'));	
		if($xt != '.jpg' && $xt != '.gif')
			$errors .= '- Please upload only .JPG and .GIF Maps.<br />';	
	}
	
	$s_ordr = $wpdb->get_results("SELECT max(sort_order) AS sort_id FROM e_p_pics WHERE property_id = '".$post_ID."'");	
	$s_ordr = $s_ordr['sort_id']+1;	
	
	if($s_ordr==1)
		$pri = 1;
	else
		$pri = 0;
	
	$fileId= $file_count+1;

		foreach($_FILES as $key => $val){
			$t 			= time();
			$fname 		= $val['name'];
			$img_name 	= $post_ID."_".$t."_".$fileId;
			$fileExt	= substr($fname, strrpos($fname , "."));
			$fileExt 	= strtolower($fileExt);
			$img_path 	= "$img_name"."$fileExt";
			$img_dir 	= ABSPATH."up_data/properties/$img_name"."$fileExt";		
			
			if ($val['tmp_name']){
				copy($val['tmp_name'], $img_dir);				
			
			$wpdb->query("INSERT INTO e_p_pics SET 
				id=NULL,
				property_id = ".$post_ID.",
				large = '".$img_path."',
				primary_pic = '".$pri."',			
				sort_order = ".$s_ordr);
				
				$fileId++;
				$s_ordr=$s_ordr+1;
				if($pri==1)
					$pri=0;
			}
		}
		
	return $post_ID;
}


function deleteproperty( $post_data = null ) {
	
	global $wpdb;
	
	$post_ID 	= (int) $post_data['id'];		
	$file_path 	= ABSPATH."up_data/properties/";
	
	$propImg = $wpdb->get_results("SELECT * FROM e_p_pics WHERE property_id = '".(int)$post_ID."'");	

	for($i = 0 ; $i<=count($propImg); $i++){						
			$row = $wpdb->get_results("SELECT * FROM e_p_pics WHERE id =".(int)$propImg[$i]->id);
			$file_path = 'up_data/properties/'.$row[0]->large;
						
			if(file_exists($file_path)){
				unlink($file_path);
			}	
		$wpdb->query("DELETE FROM e_p_pics WHERE id=".(int)$propImg[$i]->id);			
	}
	
	$wpdb->query("DELETE FROM e_p_properties WHERE id=".(int)$post_ID);	
		
	return $post_ID;
}