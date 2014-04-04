<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

/**
*
* @package  RealEstateManager
* @copyright 2009 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
* Homepage: http://www.ordasoft.com
* @version: 1.0 Basic $
*  @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


require_once($mosConfig_absolute_path."/libraries/joomla/plugin/helper.php");
require_once($mosConfig_absolute_path."/includes/HTML_toolbar.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.php");
require_once($mosConfig_absolute_path."/administrator/components/com_realestatemanager/menubar_ext.php");


$g_item_count = 0;

class HTML_realestatemanager
{
	
	function showVirtualTour( $houses, $category){
  
    global $hide_js, $Itemid,$mosConfig_live_site,$mosConfig_absolute_path;
    global $limit, $total, $limitstart, $task, $paginations, $mainframe, $database;
  
    $mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/mambojavascript.js"></script>');
  	$mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="./includes/js/calendar/calendar-mos.css" title="green" />');
	$mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/calendar/calendar.js">  </script>');
	$mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/calendar/lang/calendar-en-GB.js"> </script>');
    $mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/overlib_mini.js"></script>');
    $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all"  href="./administrator/components/com_realestatemanager/includes/realestatemanager.css" title="green" />');

?>
<style type="text/css">
#goback_div{
	float:right !important;
	padding: 5px 0;
}
#goback_div a, #goback_div a:link {
	color:#FFFFFF !important; 
	text-decoration:none !important;
}

#goback_div a:hover{
	color:#FFAE18 !important;
}
</style>
		<table cellspacing="0" cellpadding="0" border="0" width="982" height="400">
        <tbody>
        <tr><td><div id="goback_div"><a class="go_back" href="javascript:history.go(-1);">Go back to the Property Detail page.</a></div></tr>
        <tr>
            <td>
				<iframe src="<?php echo $houses[0]->virtual_link;?>" width="100%" height="500"></iframe>			
            </td>
        </tr>
	</table>
	<?php
 } 

	function showRentRequest( & $houses, & $currentcat, & $params, & $tabclass, & $catid, & $sub_categories,$is_exist_sub_categories){

		HTML_realestatemanager::displayHouses($houses, $currentcat, $params, $tabclass, $catid, $sub_categories, $is_exist_sub_categories);
		// add the formular for send to :-)
	}

	function displayHouses(&$rows, $order_by_name, $currentcat, &$params, $tabclass, $catid, $categories,$is_exist_sub_categories){

    $session = &JFactory::getSession();
    $arr = $session->get("array","default");
 
    global $hide_js, $Itemid,$mosConfig_live_site,$mosConfig_absolute_path, $isMobile;
    global $limit, $total, $limitstart, $task, $paginations, $mainframe, $database;

    $mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/mambojavascript.js"></script>');
  	$mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="./includes/js/calendar/calendar-mos.css" title="green" />');
	$mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/calendar/calendar.js">  </script>');
	$mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/calendar/lang/calendar-en-GB.js"> </script>');
    $mainframe->addCustomHeadTag('<script type="text/javascript" src= "'.$mosConfig_live_site.'/includes/js/overlib_mini.js"></script>');
    $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all"  href="./administrator/components/com_realestatemanager/includes/realestatemanager.css" title="green" />');

?>
		
  <script type="text/javascript">
		function rent_request_submitbutton() {
			var form = document.userForm;
			if (form.user_name.value == "") {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_RENT_REQ_NAME; ?>" );				
			} else if (form.user_email.value == "" || !isValidEmail(form.user_email.value)) {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_RENT_REQ_EMAIL;?>" );
			} else if (form.user_mailing == "") {       
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_RENT_REQ_MAILING;?>" );
			} else if ((form.rent_until.value == "") || (form.rent_until.value < form.rent_from.value)) {  
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_RENT_REQ_UNTIL;?>" );
			} else {
				form.submit();
			}
		}
		
		function isValidEmail(str) {
			return (str.indexOf("@") > 1);
		}
		</script>        
           
		
        <?php
		if ($_REQUEST['m']!=1){							
				
				for ($catInd=0;$catInd<count($categories);$catInd++){
					
						// getting all houses for this category
						$query = "SELECT * FROM #__rem_houses"
						. "\nWHERE catid = '".$categories[$catInd]->id."' AND published='1' AND approved='1'"
						. "\nORDER BY ".$order_by_name." ASC";
						$database->setQuery( $query );
						$houses = $database->loadObjectList();		
												
						if (count($houses)>0){
							if ($order_by_name=="price"){
							
								for ($i=0; $i<count($houses)-1; $i++){
									for ($j=0; $j<count($houses)-1-$i; $j++){
										$house_i = $houses[$j];
										$house_j = $houses[$j+1];
										
										$price_i = $house_i->price;
										$price_j = $house_j->price;
										
										if ($price_i[0]=="$" && $price_j[0]=="$"){
										
											$price_i = substr($price_i, 1, strlen($price_i));
											$price_i = (int)str_replace(",", "", $price_i);
											
											$price_j = substr($price_j, 1, strlen($price_j));
											$price_j = (int)str_replace(",", "", $price_j);
											
											if ($price_i>$price_j){
												$temp = $houses[$j];
												$houses[$j] = $houses[$j+1];
												$houses[$j+1] = $temp;
											}
										}else{
											if ($price_j[0]=="$"){
												$temp = $houses[$j];
												$houses[$j] = $houses[$j+1];
												$houses[$j+1] = $temp;
											}						
											else if (strcmp($price_j, $price_i)<0){
												$temp = $houses[$j];
												$houses[$j] = $houses[$j+1];
												$houses[$j+1] = $temp;
											}			
										}									
									}																
								}							
							}							
						}	
						
						$query = "SELECT title FROM #__categories"
						. "\nWHERE id = ".$categories[$catInd]->id;
						$database->setQuery( $query );
						$cat_Name = $database->loadObjectList();
						
						$numRows = 0;
						
						$countHouse = count($houses);
						$linerows = (count($houses)%4);
						$numRows = count($houses)/4;
						$j = 0;
					
						if ($countHouse){
						
							$query = "SELECT parent_id FROM #__categories"
							. "\nWHERE id = ".$categories[$catInd]->id;
							$database->setQuery( $query );
							$catParent = $database->loadObjectList();
							$pcatID = $catParent[0]->parent_id;
						?>
							<h1 id="article_title"><?php if ($categories[$catInd]->title!=''){echo $categories[$catInd]->title;}else{echo $cat_Name[0]->title;}?></h1> 
							<br />
						<?php						
						for ($i=0; $i<$numRows; $i++) {
							$row=$houses[$j];					
							$link = JRoute::_( 'index.php?option=com_realestatemanager&amp;task=view&amp;id='. $row->id . '&amp;catid='. $row->catid .'&amp;Itemid='. $Itemid);					
							?>		
							
							<div class="table_promo_box float_left">
								<span>  
									<?php
									$house = $row;
									if($house->link != ''){
										echo '<a href="';
										echo $house->URL;
										echo '"  target="blank"></a>';
									}
									//for local images
									$imageURL = $house->image_link;?>       
										  
									<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
									
									<?php 
										if($imageURL != ''){
										
										$file_pth=pathinfo($imageURL);
										$file_type='.'.$file_pth['extension'];
										
												if(array_key_exists  ( 'filename' , $file_pth  ) ) $file_name=$file_pth['filename'];
												else $file_name =  $file_name = substr($imageURL, 0,strlen($imageURL)-strlen($file_pth['extension'] ) -1 );?>
												
												
												<img width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/photos/".$file_name."_mini".$file_type;?>">
											<?php 
										} else{?>
											<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/images/no-img_eng.gif";?>">										
										<?php }
                                            ?>  
									<span>&nbsp;</span>
									</a>
								</span>  
								<abbr><a href="<?php echo sefRelToAbs( $link ); ?>"><?php echo $row->htitle; ?></a></abbr>
								<blockquote>
									<?php if ($pcatID !='51'){if ($_REQUEST['catid']!='51'){ echo $row->bedrooms;?> Bedrooms<br /><?php }}?>
									<?php echo $row->price; ?>
								</blockquote>
							</div>
							<?php
							$row=$houses[$j+1];
							$link = JRoute::_( 'index.php?option=com_realestatemanager&amp;task=view&amp;id='. $row->id . '&amp;catid='. $row->catid .'&amp;Itemid='. $Itemid);					
							if ($row->id){			
							?>                    
							<div class="table_promo_box float_left">
								<span>  
									<?php							
									$house = $row;
									if($house->link != ''){
										echo '<a href="';
										echo $house->URL;
										echo '"  target="blank"></a>';
									}
									//for local images
									$imageURL = $house->image_link;?>       
										  
									<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
									
									<?php 
										if($imageURL != ''){
										
										$file_pth=pathinfo($imageURL);
										$file_type='.'.$file_pth['extension'];
										
												if(array_key_exists  ( 'filename' , $file_pth  ) ) $file_name=$file_pth['filename'];
												else $file_name =  $file_name = substr($imageURL, 0,strlen($imageURL)-strlen($file_pth['extension'] ) -1 );?>
												
												
												<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/photos/".$file_name."_mini".$file_type;?>">
									<?php 
									} else{?>
										<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/images/no-img_eng.gif";?>">									
									<?php }
									?>  
									<span>&nbsp;</span>
									</a>
								</span>  
								<abbr><a href="<?php echo sefRelToAbs( $link ); ?>"><?php echo $row->htitle; ?></a></abbr>
								<blockquote>
									<?php if ($pcatID !='51'){if ($_REQUEST['catid']!='51'){ echo $row->bedrooms;?> Bedrooms<br /><?php }}?>
									<?php echo $row->price; ?>
								</blockquote>
							</div>
							<?php
							}
							$row=$houses[$j+2];
							$link = JRoute::_( 'index.php?option=com_realestatemanager&amp;task=view&amp;id='. $row->id . '&amp;catid='. $row->catid .'&amp;Itemid='. $Itemid);					
							if ($row->id){			
							?>
							<div class="table_promo_box float_left">
								<span>  
									<?php
									$house = $row;
									if($house->link != ''){
										echo '<a href="';
										echo $house->URL;
										echo '"  target="blank"></a>';
									}
									//for local images
									$imageURL = $house->image_link;?>       
										  
									<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
									
									<?php 
										if($imageURL != ''){
										
										$file_pth=pathinfo($imageURL);
										$file_type='.'.$file_pth['extension'];
										
												if(array_key_exists  ( 'filename' , $file_pth  ) ) $file_name=$file_pth['filename'];
												else $file_name =  $file_name = substr($imageURL, 0,strlen($imageURL)-strlen($file_pth['extension'] ) -1 );?>
												
												
												<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/photos/".$file_name."_mini".$file_type;?>">
									<?php 
									} else{?>
										<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/images/no-img_eng.gif";?>">									
									<?php }
									?>  
									<span>&nbsp;</span>
									</a>
								</span>  
								<abbr><a href="<?php echo sefRelToAbs( $link ); ?>"><?php echo $row->htitle; ?></a></abbr>
								<blockquote>
									<?php if ($pcatID !='51'){if ($_REQUEST['catid']!='51'){ echo $row->bedrooms;?> Bedrooms<br /><?php }}?>
									<?php echo $row->price; ?>
								</blockquote>
							</div>
							<?php
							}
							$row=$houses[$j+3];
							$link = JRoute::_( 'index.php?option=com_realestatemanager&amp;task=view&amp;id='. $row->id . '&amp;catid='. $row->catid .'&amp;Itemid='. $Itemid);					
							if ($row->id){			
							?>
							<div class="table_promo_box float_right nomargin">
								<span>  
									<?php
									
									$house = $row;
									if($house->link != ''){
										echo '<a href="';
										echo $house->URL;
										echo '"  target="blank"></a>';
									}
									//for local images
									$imageURL = $house->image_link;?>       
										  
									<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
									
									<?php 
										if($imageURL != ''){
										
										$file_pth=pathinfo($imageURL);
										$file_type='.'.$file_pth['extension'];
																				
												if(array_key_exists  ( 'filename' , $file_pth  ) ) $file_name=$file_pth['filename'];
												else $file_name =  $file_name = substr($imageURL, 0,strlen($imageURL)-strlen($file_pth['extension'] ) -1 );?>												
												<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/photos/".$file_name."_mini".$file_type;?>">
									<?php 
									} else{?>
										<img  width="220" height="130" border="0" src="<?php echo $mosConfig_live_site."/components/com_realestatemanager/images/no-img_eng.gif";?>">								
									<?php }
									?>  
									<span>&nbsp;</span>
									</a>
								</span>  
								<abbr><a href="<?php echo sefRelToAbs( $link ); ?>"><?php echo $row->htitle; ?></a></abbr>
								<blockquote>
									<?php if ($pcatID !='51'){if ($_REQUEST['catid']!='51'){ echo $row->bedrooms;?> Bedrooms<br /><?php }}?>
									<?php echo $row->price; ?>
								</blockquote>
							</div> <div class="clear"></div>
						   <?php 
						   }
						   $j = $j+4;
						}?>                                   
						<div class="clear"></div>
						<br />
            <?php }}
			
			}else{?>
			
				<!--<div id="main-photo"><img src="<?php echo $mosConfig_live_site."/templates/hualalai_mobile/images/villas.jpg";?>" /></div>-->
                    
					<ul>
				<?php
                //echo $catid;
				//echo count($categories);
				for ($catInd=0;$catInd<count($categories);$catInd++){
					
						// getting all houses for this category
						$query = "SELECT * FROM #__rem_houses"
						. "\nWHERE catid = '".$categories[$catInd]->id."' AND published='1' AND approved='1'"
						. "\nORDER BY ordering ASC";
						$database->setQuery( $query );
						$houses = $database->loadObjectList();
		
						$numRows = 0;		
						$countHouse = count($houses);	
						
						for ($i=0; $i<$countHouse; $i++) {
                                $row=$houses[$i];					
                                $link = JRoute::_( 'index.php?option=com_realestatemanager&amp;task=view&amp;id='.$row->id.'&amp;catid='.$row->catid.'&amp;m=1');					
								$last = $countHouse - $i;
                                ?>	
                                <li <?php if ($last==1){?> style="border-bottom:0!important;"<?php }?>>
                                    <a href="<?php echo sefRelToAbs( $link );?>" title="Villas"><?php echo $row->htitle;?><br />
                                    <span class="propertyinfo"><?php echo $row->bedrooms;?> Bedrooms  |  <?php echo $categories[$catInd]->title;?>  |  <?php echo $row->price; ?></span>
                                    </a>
                                </li>                           
							<?php }
							}?>
                 	</ul>
                    
			<?php }?> 
<?php
 } 
	/**
	 * Displays the house
	 * rent Status 
	 */
	function displayHouse( & $house, & $tabclass, & $params, & $currentcat, & $rating, & $house_photos) 
  {

		global $hide_js,$mainframe, $Itemid, $realestatemanager_configuration, $mosConfig_live_site, $mosConfig_absolute_path, $my;


    $mainframe->addCustomHeadTag('<script src="'.$mosConfig_live_site.'/components/com_realestatemanager/lightbox/js/jquery-1.2.6.js"
type="text/javascript"></script>');
    $mainframe->addCustomHeadTag('<script
src="'.$mosConfig_live_site.'/components/com_realestatemanager/lightbox/js/jquery.lightbox.js"
type="text/javascript"></script>');

    $mainframe->addCustomHeadTag('<link rel="stylesheet" href="'. $mosConfig_live_site.
      '/components/com_realestatemanager/lightbox/css/lightbox.css" type="text/css" media="screen"/>');

/////////////// Roman additions
//////////ROMAN TABS
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="./components/com_realestatemanager/TABS/tabcontent.css" type="text/css" />');

		$mainframe->addCustomHeadTag('<script src="./components/com_realestatemanager/TABS/tabcontent.js" type="text/javascript"></script>');
////////////Adding google map
   /* $mainframe->addCustomHeadTag('<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key='
    . $realestatemanager_configuration['google_map']['key']. '" type="text/javascript">   </script>');*/
?>
<script type="text/javascript" language="Javascript" src="<?php echo $mosConfig_live_site;?>/components/com_realestatemanager/tools/js/lytebox.js"></script>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site;?>/components/com_realestatemanager/tools/css/lytebox.css" type="text/css" media="screen"/>

<script type="text/javascript">  
    var map;

function initialize() {
  if (GBrowserIsCompatible()) {
     map = new GMap2(document.getElementById("map_canvas"));
     map.setCenter(new GLatLng(<?php if($house->hlatitude) echo $house->hlatitude;else echo 0; ?>, 
			       <?php if($house->hlongitude) echo $house->hlongitude;else echo 0; ?>),
			       <?php if($house->map_zoom) echo $house->map_zoom;else echo 1; ?>);
     
     /*set type map: G_HYBRID_MAP, G_NORMAL_MAP, G_SATELLITE_MAP*/
     map.setMapType(G_HYBRID_MAP);  
//Установка маркера с координатами дома	
		  <?php if ($house->hlatitude && $house->hlongitude) 	
			{ ?>  
			   var marker = new GMarker(new GLatLng(<?php echo $house->hlatitude; ?>, <?php echo $house->hlongitude; ?>),false);
			   map.addOverlay( marker );	
		  <?php } ?>   
     
/////////////////////////////////////////////////////
	var mapTypeControl = new GMapTypeControl();
	/*задание координат где выводить кнопку с типами карт*/
        var topRight = new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(5,5));
	map.addControl(mapTypeControl, topRight); /* topRight вывод самих кнопок*/
/*GSmallMapControl() -- Создает контроль с кнопками, +- право/лево в  угол*/
	map.addControl(new GSmallMapControl());
	
  }
}
</script>	



<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

<script type="text/javascript" language="Javascript" src="./includes/js/overlib_mini.js">
</script>

		<script language="javascript" type="text/javascript">

		function review_submitbutton() { 			
			var form = document.review;
			// do field validation
			var rating_checked = false; 
			for (c = 0;  c < form.rating.length; c++){
				if (form.rating[c].checked){
					rating_checked = true;
				} 
			}
			if (form.title.value == "") {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_REVIEW_TITLE; ?>" );
			} else if (form.comment == "") {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_REVIEW_COMMENT;?>" );
			} else if (!rating_checked) {				
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_REVIEW_RATING;?>" );
			} else {
				form.submit();
			}
		}
//*****************   begin add for show/hiden button "Add review" ********************
			function button_hidden( is_hide ) {
				var el = document.getElementById('button_hidden_review');
				var el2 = document.getElementById('hidden_review');
				if(is_hide){
					el.style.display = 'none';
					el2.style.display = 'block';
				} else {
					el.style.display = 'block';
					el2.style.display = 'none';
				}
			}


		function buying_request_submitbutton() {
			var form = document.buying_request;
			if (form.customer_name.value == "") {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BUY_REQ_NAME; ?>" );
			} else if (form.customer_email.value == ""|| !isValidEmail(form.customer_email.value)) {
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BUY_REQ_EMAIL;?>" );
			} else if (form.customer_phone.value == ""||!isValidPhoneNumber(form.customer_phone.value)){ 			  				
				alert( "<?php echo _REALESTATE_MANAGER_INFOTEXT_JS_BUY_REQ_PHONE;?>" );
			} else {
				form.submit();
			}
		}
		function isValidPhoneNumber(str){

		myregexp = new RegExp("^([_0-9() -;,]*)$");
			mymatch = myregexp.exec(str);
			//alert(mymatch);exit							
			

			if(str == "")
				return false;
			if(mymatch != null)
				return true;
			return false;
		}
		function isValidEmail(str) {
			return (str.indexOf("@") > 1);
		}
		
//****************   end add for show/hiden button "Add buying"   *********************
			function buy_house( is_hide ) 
			{
				var el  = document.getElementById('hidden_buying');
				var el2 = document.getElementById('show_buying');
				if( is_hide ) {
					el.style.display = 'none';
					el2.style.display = 'block';
				} else {
					el.style.display = 'block';
					el2.style.display = 'none';
				}
			}
		</script>
        <script language="javascript" type="text/javascript">		
		function loadVtour(hid, cid){				
			window.location = "<?php echo $mosConfig_live_site?>/index.php?option=com_realestatemanager&task=virtualTour&catid="+cid+"&hid="+hid;
		}		
		</script>

<!--<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/lib/jquery.jcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/skins/tango/skin.css" />-->


<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/js/jquery.tn3lite.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/skins/tn3/tn3.css" />


<link href="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/css/slideshow.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/mootools.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/backgroundSlider.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/slideshow.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/texthide.js" ></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/tabcontent.js"></script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site?>/components/com_realestatemanager/gallery/js/swfobject.js" ></script>

<script language="javascript" type="text/javascript">
function addReq(){

var form = jQuery('#reqFrm');

var formajaxurl = jQuery('#reqFrm').serialize();
		jQuery.ajax( {		
			type : "POST",
			url : "<?php echo JURI::root();?>/components/com_realestatemanager/req_form.php",
			data : formajaxurl,
			success : function(msg) {				
				alert("Your request has been submitted successfully!");	
				jQuery('#user_name').val('');
				jQuery('#user_lname').val('');
				jQuery('#user_email').val('');
			}
		});		
}

function addReqMobFrm(){
		
	var form = jQuery('#mreqFrm');
	var formajaxurl = jQuery('#mreqFrm').serialize();
		jQuery.ajax( {		
			type : "POST",
			url : "<?php echo JURI::root();?>/components/com_realestatemanager/req_mobform.php",
			data : formajaxurl,
			success : function(msg){				
				alert("Your request has been submitted successfully!");	
				jQuery('#mobuser_name').val('');
				jQuery('#mobuser_lname').val('');
				jQuery('#mobuser_email').val('');						
			}
		});		
}
function chk_validationsite(){
	var frm = document.getElementById("reqFrm");
	
	
	/*if (frm.chkProperty.checked == false) {
		alert( "Please Check Property Plans & Features" );		
		return false;				
	}
	if (frm.chkMaintence.checked == false) {
		alert( "Please Check Property Maintenance Costs" );		
		return false;				
	}
	if (frm.chkComparable.checked == false) {
		alert( "Please Check Comparable Sales" );		
		return false;				
	}*/
	if (frm.user_name.value == "") {
		alert( "Please Provide First Name" );
		frm.user_name.focus();
		return false;				
	}
	if (frm.user_lname.value == "") {
		alert( "Please Provide Last Name" );
		frm.user_lname.focus();
		return false;				
	} 
	if (frm.user_email.value == ''){
		alert("Please Provide E-mail Address");
		frm.user_email.focus();
		return false;
	}else {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = frm.user_email.value;
		
		if(reg.test(address) == false) {		
		  alert('Invalid Email Address');
		  frm.user_email.focus();
		  return false;
		}
	}
	addReq();		
}
function chk_validation(){
	var frm = document.getElementById("mreqFrm");
	
	/*if (frm.chkMobProperty.checked == false) {
		alert( "Please Check Property Plans & Features" );		
		return false;				
	}
	if (frm.chkMobMaintence.checked == false) {
		alert( "Please Check Property Maintenance Costs" );		
		return false;				
	}
	if (frm.chkMobComparable.checked == false) {
		alert( "Please Check Comparable Sales" );		
		return false;				
	}*/
	if (frm.mobuser_name.value == "") {
		alert( "Please Provide First Name" );
		frm.mobuser_name.focus();
		return false;				
	}
	if (frm.mobuser_lname.value == "") {
		alert( "Please Provide Last Name" );
		frm.mobuser_lname.focus();
		return false;				
	} 
	if (frm.mobuser_email.value == ''){
		alert("Please Provide E-mail Address");
		frm.mobuser_email.focus();
		return false;
	}else {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = frm.mobuser_email.value;
		
		if(reg.test(address) == false) {		
		  alert('Invalid Email Address');
		  frm.mobuser_email.focus();
		  return false;
		}
	}
	addReqMobFrm();		
}
</script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		//Thumbnailer.config.shaderOpacity = 1;
			var tn1 = jQuery('.mygallery').tn3({
			skinDir:"skins",
			imageClick:"fullscreen",
			image:{
			maxZoom:1.5,
			crop:true,
			clickEvent:"dblclick",
			transitions:[{
			type:"fade"
			},{
			type:"fade"
			},{
			type:"fade",
			duration:1060,
			easing:"easeInQuad",
			gridX:1,
			gridY:1,
			// flat, diagonal, circle, random
			sort:"circle",
			sortReverse:false,
			diagonalStart:"bl",
			// fade, scale
			method:"fade",
			partDuration:1060,
			partEasing:"easeInQuad",
			partDirection:"left"
			}]
			}
		});
	});
</script>

<?php 
if ($_REQUEST['m']!=1){
?>
    <div class="banner_image" style="height:590px;">
    	<div class="mygallery">
			<div class="tn3 album">            		   			
                <ol>
				<?php
                    $noOfPhoto = count($house_photos);			
                    for ($i=0; $i<$noOfPhoto; $i++){
                    
                    $photo_pth=pathinfo($house_photos[$i]->main_img);
                    $photo_type='.'.$photo_pth['extension'];
                    $photo_name=basename($house_photos[$i]->main_img,$photo_type);  
                ?>	
                <li>
                	<div class="tn3 description"><?php echo $house_photos[$i]->photo_title;?></div>
                    <a href="./components/com_realestatemanager/photos/<?php echo $photo_name.$photo_type;?>" class="slideshowThumbnail" title="<?php echo $house_photos[$j]->photo_title;?>">
                    <img src="./components/com_realestatemanager/photos/<?php echo $photo_name.$photo_type;?>" width="91" border="0" height="59" alt="<?php echo $house_photos[$i]->photo_title;?>" title="<?php echo $house_photos[$i]->photo_title;?>" style="cursor:pointer;" />
                    </a>
                </li>
                <?php }?>		
                </ol>
            </div>
            </div>    
            <!--<div class="tn3 description">Images with fixed dimensions</div>-->
            <div style="clear:both;"></div>

        </div>
        
<div class="section">        	
            <div class="content_divider"></div>
            
            <div class="content_text">
            	<table cellpadding="0" cellspacing="0" summary="Table Content Text" width="960" class="table_property">
                	<tr>
                    	<td width="322" valign="top" style="line-height:22px;">
                        	<span><?php echo $house->htitle;?></span>
                            <?php echo $house->description;
							
                            //if ($house->edok_link!= ''){?>                            	
                              <!--  <p>
                                <br /><br />
                                <a href="<?php echo $house->edok_link; ?>" target="blank">
                                	<img class="dl_img" src="<?php echo JURI::root();?>/components/com_realestatemanager/images/download.png" height="16" width="16" />
                                </a>
                                <a href="<?php echo $house->edok_link; ?>" target="blank">                                    
									<?php echo _REALESTATE_MANAGER_LABEL_EDOCUMENT_DOWNLOAD;?>
                                </a>
                                </p>  -->                               
                            <?php //}?>
                                                        
                        </td>
                        <td width="45">&nbsp;</td>
                    	<td width="278" valign="top" style="line-height:22px;">
                        <?php if ($house->price!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_PRICE;?></p><abbr><?php echo $house->price; ?></abbr></blockquote>
                        <?php } if ($house->bedrooms!=''){ ?>    
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_BEDROOMS;?></p><abbr><?php echo $house->bedrooms; ?></abbr></blockquote>
                        <?php } if ($house->bathrooms!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_BATHROOMS;?></p><abbr><?php echo $house->bathrooms; ?></abbr></blockquote>
                        <?php } if ($house->additional_room!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_ADDITIONAL_ROOMS;?></p><abbr><?php echo $house->additional_room;?></abbr></blockquote>
                        <?php } if ($house->interior_area!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_INTERIOR_LIVING_AREA;?></p><abbr><?php echo $house->interior_area; ?></abbr></blockquote>
                        <?php } if ($house->lanai!=''){ ?>
                            <blockquote><p><?php if($house->catid=='54'){ echo "Covered Lanai Area"; } else{ echo "Lanai Area"; } ?><?php //echo _REALESTATE_MANAGER_LABEL_LANAI;?></p><abbr><?php echo $house->lanai;?></abbr></blockquote>
                        <?php } 

						if($house->catid=='54'){
						if ($house->garage!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_GARAGE_AREA;?></p><abbr><?php echo $house->garage;?></abbr></blockquote>
                        <?php } if ($house->uroofarea!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_UNDER_ROOF_AREA;?></p><abbr><?php echo $house->uroofarea;?></abbr></blockquote>
                        <?php } 
						}
						else{
						if ($house->uroofarea!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_UNDER_ROOF_AREA;?></p><abbr><?php echo $house->uroofarea;?></abbr></blockquote>
                        <?php } if ($house->garage!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_GARAGE_AREA;?></p><abbr><?php echo $house->garage;?></abbr></blockquote>
                        <?php } 						
						}
						if ($house->lot_size!=''){ ?>
                            <blockquote><p><?php echo _REALESTATE_MANAGER_LABEL_LOT_SIZE;?></p><abbr><?php echo $house->lot_size;?></abbr></blockquote>
                        <?php }
						

							
							//if ($my->id>0){?>

								
                            <blockquote><i style="font-size:11px"><?php echo _REALESTATE_MANAGER_LABEL_NOTE;?></i></blockquote>
                            
                        </td>
                        <td width="45">&nbsp;</td>
                    	<td width="270" valign="top" style="line-height:22px;">
                       	  <div>


<?php
								/*
								$prop_id22 = $house->id;
								$sql22 = "SELECT *FROM user_prop_rel WHERE property_id='$prop_id22'";
								$result22 = mysql_query($sql22);
								$row22 = mysql_fetch_array($result22);
								$user_permitted = $row22[1];
								$arr = explode(",",$user_permitted);
								if (in_array($my->id, $arr) or (62==$my->id)){	
								*/
								?>
                                
                                
                            	
								<?php if ($house->virtual_link!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->virtual_link; ?>" target="blank">Virtual Tour</a>                                
                                        </p>
                                <?php } if ($house->brochure_link!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->brochure_link; ?>" target="blank">Property Brochure</a>                                
                                        </p>
                                <?php } if ($house->lot_link!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->lot_link; ?>" target="blank">Lot Diagram</a>                                
                                        </p>
                                <?php } if ($house->floor_link!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->floor_link; ?>" target="blank">Floor Plan</a>                                
                                        </p>
                                <?php } if ($house->site_plan!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->site_plan; ?>" target="blank">Site Plan</a>                                
                                        </p>
                                <?php } if ($house->blueprints!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->blueprints; ?>" target="blank">Blueprints</a>                                
                                        </p>
                                <?php } if ($house->schematics!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->schematics; ?>" target="blank">Schematics</a>                                
                                        </p>
                                <?php } if ($house->edok_link!=''){ ?>
                                        <p>									
                                            <a href="<?php echo $house->edok_link; ?>" target="blank">Expense Summary</a>                                
                                        </p>
                                <?php }?>
                                
                                
                        <?php //} }?>
                        
                            	<!--Request Property Information<br />
                            	<br />
                                <form action="#" method="post" id="reqFrm" name="reqFrm">
                                	<input type="checkbox" id="chkProperty" name="chkProperty" value="1"/>
                                    <label for="chkProperty">Property Plans &amp; Features</label>
                                    <div class="gap8"></div>
                                    
                                	<input type="checkbox" id="chkMaintence" name="chkMaintence" value="1" />
                                    <label for="chkMaintence">Property Maintenance Costs</label>
                                     <div class="gap8"></div>
                                     
                                	<input type="checkbox" id="chkComparable" name="chkComparable" value="1" />
                                    <label for="chkComparable">Comparable Sales</label>
                                     <div class="gap8"></div>
                                     <div class="gap8"></div>

                                     
                                    <label for="txtName" class="label_name">First Name:</label>
                                    <input type="text" id="user_name" name="user_name" value="" />
                                     <div class="gap8"></div>
                                     
                                    <label for="txtName" class="label_name">Last Name:</label>
                                    <input type="text" id="user_lname" name="user_lname" value="" />
                                     <div class="gap8"></div>
                                     
                                    <label for="txtEmail" class="label_email">Email:</label>
                                    <input type="text" id="user_email" name="user_email" value="" />
                                     <div class="gap8"></div>
                                     <input type="hidden" id="fk_houseid" name="fk_houseid" value="<?php //echo $house->hlocation;?>" />
                                     <input type="button" class="btn_submit float_right add_request" onclick="return chk_validationsite();" />
                                     <div class="clear"></div>
                                </form>
                                <br /> -->
                            <?php 
								$link = JRoute::_( 'index.php?option=com_contact&view=contact&id=1&pid='.$house->id);
							?>    
                            <p style="margin-top:20px;"><a href="<?php echo $link;?>" class="moreinfobutton" style="color:#FFFFFF">Request Additional Information</a></p>
                            </div>
                        </td> 
                    </tr>
                </table>
            </div>
        </div>

		<?php //show the reviews

		if( $params->get('show_reviews')) 
		{
			$reviews = $house->getReviews();	
			?>
         <br />
         <br />
				<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
					<?php echo _REALESTATE_MANAGER_LABEL_REVIEWS; ?> 
				</div>
				<table width="300px" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">
	
			<?php
			if ($reviews != null && count($reviews) > 0)
			{
				for($m = 0, $n = count($reviews); $m < $n; $m ++ )
				{
				$review = $reviews[$m];
			?>
					<tr>
						<td colspan="3">
							<strong>
								<?php echo $review->title; ?>
							</strong>
						</td>
					</tr>
					<tr>	
						<td>
							<?php echo $review->date; ?>
						</td>				
						<td>
							<?php 
								$help = &$review->getReviewFrom();
								echo $help['name']; 
							?>
						</td>					
						<td width="10">
							<img src="./components/com_realestatemanager/images/rating-<?php echo $review->rating; ?>.gif" alt="<?php echo ($review->rating)/2; ?>" border="0" align="right"/>&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<?php echo $review->comment; ?>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<hr />
						</td>
					</tr>
			<?php
				}
			}
				
			?>
				<tr>
					<td colspan="3">&nbsp;
						
					</td>
				</tr>
			</table>     
		
			<?php 
			if($params->get('show_inputreviews')){
			?>
<!--***********   begin add for show/hiden button "Add review"   ***********************-->
<div id ="button_hidden_review" style="<?php if(isset($_REQUEST['err_msg'])) {echo 'display:none';}?>">
<br /> 
<input type="button" name="submit" value="<?php echo _REALESTATE_MANAGER_LABEL_BUTTON_ADD_REVIEW; ?>" class="button" onclick="javascript:button_hidden(true)"/>
				
</div>
<!--***********   end add for show/hiden button "Add review"   ************************-->

			<div id="hidden_review" style="<?php if(isset($_REQUEST['err_msg'] ) ) {echo 'display:block';} else {echo 'display:none';} ?>">
				<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
				<hr />				
				<?php echo _REALESTATE_MANAGER_LABEL_ADDREVIEW; ?>
				</div>


		<form action="<?php echo sefRelToAbs("index.php?option=com_realestatemanager&amp;task=review&amp;Itemid=". $Itemid); ?>" method="post" name="review"> 
		
		<form action="" method="post" name="review"> 
				 

				<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">

					<tr>
						<td colspan="2">
						<?php echo _REALESTATE_MANAGER_LABEL_REVIEW_TITLE; ?>
						</td>				
					</tr>
					<tr>
						<td colspan="2">					
							<input class="inputbox" type="text" name="title" size="80" value="<?php if ( isset($_REQUEST["title"]) ) {echo $_REQUEST["title"];}?>" /> 

						</td>
					</tr>
					<tr>
						<td>
							<?php echo _REALESTATE_MANAGER_LABEL_REVIEW_COMMENT; ?>
						</td>
						<td>
							<?php echo _REALESTATE_MANAGER_LABEL_REVIEW_RATING; ?>
						</td>					
					</tr>
					<tr>
						<td>							
                <?php
		   $comm_val = "";
		   if ( isset($_REQUEST["comment"]) )
                       {
                        $comm_val = $_REQUEST["comment"];

 
                        }
		   editorArea( 'editor1',  $comm_val, 'comment', '410', '200', '60', '10' ) ;     			
                ?>
						</td>
						<td width="">  
							<?php
							$k = 0;
							while($k < 11){
							?>
              <input type="radio" name="rating" value="<?php echo $k;?>" <?php if ( isset($_REQUEST["rating"]) && $_REQUEST["rating"] == $k ) {echo "CHECKED";}?> alt="Rating" />
						<img src="./components/com_realestatemanager/images/rating-<?php echo $k; ?>.gif" alt="<?php echo ($k)/2; ?>" border="0" /><br />
							<?php	
								$k ++;
							} 
							?>
						</td>
					</tr>			
					<tr>
						<td colspan="2">&nbsp;
							
						</td>
					</tr> 

					<tr>
						<td> 
							<!-- save review button-->
							<input class="button" type="button" value="<?php echo _REALESTATE_MANAGER_LABEL_BUTTON_SAVE; ?>" onclick="review_submitbutton()"/>						
						</td>
						<td>  
							<!-- hifde review button-->
							<input class="button" type="button" value="<?php echo _REALESTATE_MANAGER_LABEL_BUTTON_REVIEW_HIDE;?>" onclick="javascript:button_hidden(false);"/>						
						</td>
					<!--	<td>							
							<?php
							// displays back button
							// mosHTML::BackButton ( $params, $hide_js );
							?>	
						</td>
					-->
					</tr> 
					<tr>
						<td colspan="2">&nbsp;	
						</td>
					</tr>

				</table>
		<input type="hidden" name="fk_houseid" value="<?php echo $house->id; ?>" />
		<input type="hidden" name="catid" value="<?php echo $house->catid; ?>" />
		</form>

		</div> <!-- end <div id="hidden_review"> -->
        <br />
        <br />        
			<?php
		   	}   //end if($params->get('show_inputreviews'))

		} // end if( $params->get('show_reviews')) 
?>

<?php
}else{		
?>
	
    <div id="content" style="width:100%">
        <?php 				
			//for local images
			$imageURL = $house->image_link;
			if($imageURL != ''){
				echo '<img id="bannerLargeimage" src="'. $mosConfig_live_site.'/components/com_realestatemanager/photos/'.$imageURL.'"  width="768" height="376" alt="Home Banner, Hualalai Realty, Real Estate, Resort, Villa" >';
			} else{
				echo '<img src="'.$mosConfig_live_site.'/components/com_realestatemanager/images/' . _REALESTATE_MANAGER_NO_PICTURE.'" alt="no-img_eng.gif" border="0" height=376 width=768 />';
			}
		?>
        <p class="caption">A large covered lanai offers a perfect setting to enjoy the homes seemingly endless ocean views.</p>
        
          <h2><?php echo $house->htitle;?></h2>
    
        <p><?php echo $house->description;?></p><br />
        <p>
          
          <?php if ($house->price!=''){?>Price: <?php echo $house->price;?><br /><?php }?>
          <?php if ($house->bedrooms!=''){?>Bedrooms: <?php echo $house->bedrooms;?><br /><?php }?>
          <?php if ($house->bathrooms!=''){?>Bathrooms/Powder: <?php echo $house->bathrooms;?><br /><?php }?>
          <?php if ($house->additional_room!=''){?>Additional Rooms: <?php echo $house->additional_room;?><br /><?php }?>
          <?php if ($house->interior_area!=''){?>Interior Living Area: <?php echo $house->interior_area;?><br /><?php }?>
          <?php if ($house->lanai!=''){ if($house->catid=='54'){ echo "Covered Lanai Area"; } else{ echo "Lanai Area"; }?>: <?php echo $house->lanai;?><br /><?php }?>
		  <?php
		  if($house->catid=='54'){
		  ?>
		  <?php if ($house->garage!=''){?>Garage Area: <?php echo $house->garage;?><br /><?php }?>
          <?php if ($house->uroofarea!=''){?>Under Roof Area: <?php echo $house->uroofarea;?><br /><?php }?>
          
		  <?php
		  } else{
		  ?>
		  <?php if ($house->uroofarea!=''){?>Under Roof Area: <?php echo $house->uroofarea;?><br /><?php }?>	
		  <?php if ($house->garage!=''){?>Garage Area: <?php echo $house->garage;?><br /><?php }?>
          	  
		  <?php
		  }
		  ?>
          <?php if ($house->lot_size!=''){?>Lot size: <?php echo $house->lot_size;?><br /><?php }?>
          Note: Areas are approximate.</p>
          
        <!--<p><strong>Request Property Information</strong></p>
        <form id="mreqFrm" name="mreqFrm" action="#" method="post">
            <p>
              <input type="checkbox" name="chkMobProperty" value="1" /> Property Plans &amp; Features<br />
              <input type="checkbox" name="chkMobMaintence" value="1" /> Property Maintence Costs<br />
              <input type="checkbox" name="chkMobComparable" value="1" /> Comparable Sales</p>
            <p><br />
            First Name<br />
              <input name="mobuser_name" id="mobuser_name" type="text" value="" />
            </p>
             <p>
            Last Name<br />
              <input name="mobuser_lname" id="mobuser_lname" type="text" value="" />
            </p>
            <p>Email<br />
                <input name="mobuser_email" id="mobuser_email" type="text" value="" />
            </p>
            <p>
                <input type="hidden" id="fk_houseid" name="fk_houseid" value="<?php echo $house->hlocation;?>" />
                <input type="button" value="Submit" class="mreqFemSubmit" onclick="return chk_validation();" />
            </p>
        </form> -->
        <div style="width:200px; text-align:center">
		<?php 
			$link = JRoute::_( 'index.php?option=com_contact&view=contact&id=1&pid='.$house->id);
		?>    
		<a href="<?php echo $link;?>" class="moreinfobutton" style="color:#FFFFFF">Request Additional Information</a></div>
        <br />

        <!--<p style="background: #f2f2f2; padding:2px; text-align:center"><a href="contact">Request Additional Information &raquo;</a></p> -->


	  <?php
        $noOfPhoto = count($house_photos);			
        for ($i=0; $i<$noOfPhoto; $i++){
        
        $photo_pth=pathinfo($house_photos[$i]->main_img);
        $photo_type='.'.$photo_pth['extension'];
        $photo_name=basename($house_photos[$i]->main_img,$photo_type);  
        ?>		
        <a href="components/com_realestatemanager/photos/<?php echo $photo_name.$photo_type;?>" rel="lytebox" title="<?php echo $house_photos[$j]->photo_title;?>">
                <img src="components/com_realestatemanager/photos/<?php echo $photo_name.$photo_type;?>" width="768" border="0" height="376" alt="<?php echo $house_photos[$i]->photo_title;?>" title="<?php echo $house_photos[$i]->photo_title;?>" style="cursor:pointer" />
        </a>
        <p class="caption"><?php echo $house_photos[$i]->photo_title;?></p>
      <?php }?>
          </div>     
        </div>
<?php
	}
}  //end function
	
	
/**
* Display links to categories
*/
	function showCategories( &$params, &$categories, &$catid, &$tabclass , &$currentcat)
         {



		global $hide_js, $Itemid, $acl, $mosConfig_live_site, $my,$mainframe;

$mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" media="all" href="./administrator/components/com_realestatemanager/includes/realestatemanager.css" title="green" />');
		?>

		<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $currentcat->header; ?>
		</div>
		
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr>
				<td>
					<?php echo $currentcat->descrip; ?>
				</td>     
	        	        <td width="120" align="center">
	          		 <img src="./components/com_realestatemanager/images/rem_logo.png" align="right" alt="Real Estate Manager logo"/>
	        	        </td>
	      	       </tr>
	        </table>
		<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right"/>
					<tr>
						<td  align="right" >
							<?php
		$link = 'index.php?option=com_realestatemanager&amp;task=show_search&amp;catid='. $catid. '&amp;Itemid='. $Itemid;
							?> 
			
		<a href="<?php echo sefRelToAbs($link); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>" align="right">
			
               <img src="./components/com_realestatemanager/images/search.gif" alt="?" border="0" align="right"/>     
								<?php echo _REALESTATE_MANAGER_LABEL_SEARCH; ?>&nbsp;
							</a>
					
					</tr>
				</table>
			</div><br><br>
		<form action="index.php" method="post" name="adminForm">
		<?php		
			HTML_realestatemanager::listCategories($params, $categories, $catid, $tabclass , $currentcat);
		?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%">&nbsp;
						
					</td>
					<td width="50%">
						<?php		
							mosHTML::BackButton ( $params, $hide_js ); 
						?>
					</td>
				</tr>
			</table>
		<?php		
		if($params->get('show_search')){
		?>
			
		<?php	
		}
//			mosHTML::BackButton ( $params, $hide_js );
                 ?>   
 		</form>

		<?php

}

	
	function listCategories( &$params, $cat_all, $catid, $tabclass , $currentcat) {
		global $Itemid;
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="2" height="20" width="90%" class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo _REALESTATE_MANAGER_LABEL_CATEGORY;?>
			</td>
			<td height="20" width="10%" class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo _REALESTATE_MANAGER_LABEL_HOUSES;?> 
			</td>				
		</tr>
		<tr>
			<td colspan="3">
			<?php
			HTML_realestatemanager::showInsertSubCategory($catid, $cat_all, $params, $tabclass, $Itemid, 0);
			?>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;
				
			</td>
		</tr>
		</table>
<?php	
	}
/*
* add Nikolay - ordaSoft
* function for show subcategory
*/
function showInsertSubCategory($id, $cat_all, $params, $tabclass, $Itemid, $deep) {
	global $g_item_count,$realestatemanager_configuration ;
	$deep++;
	for ($i = 0; $i < count($cat_all); $i++) {
	    if ( ($id == $cat_all[$i]->parent_id) && ($cat_all[$i]->display == 1) ) {
		$g_item_count++;

		$link = 'index.php?option=com_realestatemanager&amp;task=showCategory&amp;catid='. $cat_all[$i]->id .'&amp;Itemid='. $Itemid;
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="<?php echo $tabclass[($g_item_count%2)]; ?>">
				<td width="1%">
					<?php
					if ($deep != 1 ) {
					   $jj = $deep;
					   while ($jj--){echo "&nbsp;&nbsp;&nbsp;&nbsp;";}
					   echo "&nbsp;|_";
					}
					?>
				</td>
				<td width="9%">
				<?php
					if ( ($params->get( 'show_cat_pic')) && ($cat_all[$i]->image != "")) {?>
					   <img src="./images/stories/<?php echo $cat_all[$i]->image;?>" alt="picture for subcategory" height="48" width="48" />&nbsp;
				<?php
					} else  {?>
						<img src="./components/com_realestatemanager/images/folder.png" alt="picture for subcategory" height="48" width="48" />&nbsp;
					  <?php }?>
				</td>
				<td width="80%">	
					<a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
					<?php echo $cat_all[$i]->title;?>
					</a>					
				</td>
				<td  align="left" width="10%">				
					<?php if ($cat_all[$i]->houses == '') echo "0";else echo $cat_all[$i]->houses;?>
				</td>
			</tr>
		</table>
		<?php



if($GLOBALS['subcategory_show']) HTML_realestatemanager::showInsertSubCategory($cat_all[$i]->id, $cat_all, $params, $tabclass, $Itemid, $deep);

	    }//end if ($id == $cat_all[$i]->parent_id)
//	    $z = 1 - $z;
	}//end for(...)	
}//end function showInsertSubCategory($id, $cat_all)





//--------------------------------------------------------------------------------------------------
function showSearchHouses( $params, $currentcat, $clist , $option)
{
		global $hide_js, $Itemid;
	?>
		<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<?php echo $currentcat->header; ?>
		</div>
                      
                  

		<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr>				
				<?php

				if($currentcat->img != null && $currentcat->align == 'left')
                                {
				 ?>
				<td>

		                 <img src="<?php echo $currentcat->img; ?>" align="<?php echo $currentcat->align; ?>" />
		        	</td>
		         <?php
				}
				?>
				<td width="100%">
				  <?php echo $currentcat->descrip; ?>
				</td>
		         <?php
					if($currentcat->img != null && $currentcat->align == 'right')
                                        {
                                         
				?>
				 <td>
		        	  <img src="<?php echo $currentcat->img; ?>" align="<?php echo $currentcat->align; ?>"  alt = "?"/>
		        	 </td>
		         <?php
				}
				?>
		        </tr>
	       </table>



<form action="index.php" method="get" name="adminForm">


 <table border="0" cellpadding="4" cellspacing="0" width="100%">
   <tr>
				 <td align="right">
				   <?php echo _REALESTATE_MANAGER_LABEL_SEARCH_KEYWORD; ?>&nbsp;
				 </td>
		        	 <td align="left">
		          	   <input class="inputbox" type="text" name="searchtext" size="20" maxlength="20"/>
					   <input type='hidden' name="option" value='com_realestatemanager'/>
					   <input type='hidden' name="task" value='search'/>
					   <input type='hidden' name="Itemid" value='<?php echo $Itemid; ?>'/>
					   <input type='hidden' name="search_date_from" value=''/>
					   <input type='hidden' name="search_date_until" value=''/>
		        	


						<input type='hidden'  name= "Address" value = "on"/>
						<input type='hidden'  name= "Title" value = "on"/>
						<input type='hidden'  name= "Broker" value = "on" />
						<input type='hidden'  name= "Feature" value = "on" />
						<input type='hidden'  name= "Description" value = "on" />
						<input type='hidden'  name= "Listing_type" value = "on" />
						<input type='hidden'  name= "Area" value = "on" />
						<input type='hidden'  name= "Property_ownership" value = "on"  />
						<input type='hidden'  name= "Model" value = "on"  />
						<input type='hidden'  name= "Style" value = "on"  />
						<input type='hidden'  name= "Agent" value = "on" />
						<input type='hidden'  name= "Zoning" value = "on" />

					</td>
		               </tr>

				<tr>      
		        	  <td align="right">
				     <?php echo _REALESTATE_MANAGER_LABEL_CATEGORY; ?>&nbsp;
				  </td>
		        	  <td align="left">
		          	     <?php echo $clist; ?>
		        	  </td>
		               </tr>
			       <tr>      
	<td align="center" colspan="2">
            <input type="submit" name="submit" value="<?php echo _REALESTATE_MANAGER_LABEL_SEARCH_BUTTON;?>" class="button" />
        </td>       
     </tr>
		    </table>			
			<br />       
			<?php
				mosHTML::BackButton ( $params, $hide_js );
			?>
		</form>

<?php
}



//--------------------------------------------------------------------------------------------------
	function showRequestThanks( $params, $currentcat){
		global $hide_js, $Itemid,$catid;   
	
	?>
	<div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
	   <?php echo $currentcat->header; ?>
	</div>
	<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr>				
			  <?php
			    if($currentcat->img != null )
                             {
			  ?>
			     <td>

		        	<img src="<?php echo $currentcat->img; ?>" alt="?" />
		             </td>
		        <?php
				}
				?>
			     <td width="100%">
			       <?php echo $currentcat->descrip; ?>
			     </td>
		       
		     </tr>
	    </table>
		<form action="<?php if($catid==0) echo sefRelToAbs("index.php?option=com_realestatemanager&amp;Itemid=".$Itemid);   
                            else if($_REQUEST['where'] == 2) echo sefRelToAbs("index.php?option=com_realestatemanager&amp;task=showCategory&amp;catid=".$catid."&amp;Itemid=".$Itemid);
                            else echo sefRelToAbs("index.php?option=com_realestatemanager&amp;Itemid=".$Itemid);?>" method="post" name="userForm">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
		      	<tr>
			   <td colspan="2" align="right">&nbsp;			
			   </td>
		      	</tr>
		      	<tr>
			  <td>
			    <?php
			      //mosHTML::BackButton ( $params, $hide_js );
			     ?>
			  </td>
			  <td>
			   <input type="submit" name="submit" value="<?php echo _REALESTATE_MANAGER_LABEL_OK; ?>" class="button" />
			  </td>
		      	</tr>

		    </table>			
		</form>
<?php
	}
	
}
?>