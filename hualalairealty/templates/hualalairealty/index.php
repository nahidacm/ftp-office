<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link href="<?php echo $this->baseurl ?>/templates/hualalairealty/css/styles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/css/lytebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/js/lytebox.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/js/scripts.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/js/menu.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/js/swfobject-v2point2.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/tools/galleria/galleria-1.2.7.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/hualalairealty/js/jquery.staff.js"></script>-->

<script type="text/javascript" src="http://use.typekit.com/dal7jbg.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<style type="text/css">
		.clearboth {
			clear: both;
		}
		
		#map-view-container {
			position: relative;
		}

		#map-container {
			float: left;
		}

		#map-view-container img.map {
			position: relative;
			z-index: 100;
		}
		
		#map-view-container img.region {
			display: none;
			left: 0px;
			position: absolute;
			top: 0px;
			z-index: 20;
		}		
		
		#map-view-container img.regionBg {
			left: 0px;
			position: absolute;
			top: 0px;
			z-index: 19;
		}

		#practice-container {
			float: left;
		}
		
		#practice-container ul {
			display: none;
		}
		
		#practice-container ul.selected {
			display: inline;
		}
		
		#practice-container ul li {
			list-style-type: none;
		}

		#practice-container .selected-list ul li {
			list-style-type: none;
		}
	</style>

</head>
<body>
<?php 
global $mainframe;

$linkNews = JRoute::_( 'index.php?option=com_hualalainews&view=hualalainews&task=show&Itemid=48');
$linkPhoto = JRoute::_( 'index.php?option=com_easygallery&view=easygallery');
$villas = JRoute::_( 'index.php?option=com_realestatemanager&task=showCategory&catid=44');
$homes = JRoute::_( 'index.php?option=com_realestatemanager&task=showCategory&catid=54');
$homesites = JRoute::_( 'index.php?option=com_realestatemanager&task=showCategory&catid=51');
$allProperty = JRoute::_( 'index.php?option=com_realestatemanager&task=showCategory&catid=0');

?>
<?php	
$user =& JFactory::getUser();
if($user->id){
?>
<script type="text/javascript">
jQuery(function(){
	jQuery('#hualog').text('LOGOUT');
});
</script>
<?php
}
?>
	<div class="article">
        <div class="header">
        	<div class="lang_link float_right">
            	<ul>
                <?php if ($_REQUEST['id']==68){?>
                	<li><a href="index.php"><img src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/nav_lang_english.gif" width="77" height="18" alt="Language Japanees" /></a></li>
                <?php }else{?>
                	<li><a href="index.php?option=com_content&view=article&id=68&&Itemid=111"><img src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/nav_lang_japanese.gif" width="77" height="18" alt="Language Japanese" /></a></li>
                <?php }?>
                </ul>
            </div>
            <div class="clear"></div>
            
            <div class="navigation">
            	<div class="page_logo float_left">
                	<a href="index.php"><img src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/HualalaiRealtyLogo.png" width="251" height="50" alt="Hualalai Realty, Hualalai Resort" border="0" /></a>
                </div>
                
                <div class="primary_menu float_right">
                    <ul>
                        <li><a href="index.php" class="<?php if ($_REQUEST['Itemid']==84){?> nav_home_active <?php }else{?> nav_home<?php }?>">HOME</a></li>
                        <li id="mainMenu">
                        	<a href="<?php echo $allProperty;?>" class="nav_realestate">REAL ESTATE</a>
                            <ul id="subMenu">
                                <li class="noborder"><a href="<?php echo $allProperty;?>" class="<?php if ($_REQUEST['catid']!=''){?> nav_sub_realestate_active <?php }else{?> nav_sub_realestate<?php }?>">REAL ESTATE</a></li>
                                <li><a href="<?php echo $villas;?>" class="<?php if ($_REQUEST['catid']==44 && $_REQUEST['option']=="com_realestatemanager"){?> nav_sub_villas_active <?php }else{?> nav_sub_villas<?php }?>">VILLAS FOR SALE</a></li>
                                <li><a href="<?php echo $homes;?>" class="<?php if ($_REQUEST['catid']==54 && $_REQUEST['option']=="com_realestatemanager"){?> nav_sub_homes_active <?php }else{?> nav_sub_homes<?php }?>">HOMES FOR SALE</a></li>
                                <li><a href="<?php echo $homesites;?>" class="<?php if ($_REQUEST['catid']==51 && $_REQUEST['option']=="com_realestatemanager"){?> nav_sub_homesites_active <?php }else{?> nav_sub_homesites<?php }?>">HOMESITES FOR SALE</a></li>
                                <li><a href="<?php echo $allProperty;?>" class="<?php if ($_REQUEST['catid']==0 && $_REQUEST['option']=="com_realestatemanager"){?> nav_sub_properties_active <?php }else{?> nav_sub_properties<?php }?>">ALL PROPERTIES FOR SALE</a></li>
		                        <li class="noborder"><a href="index.php?option=com_content&view=article&id=159&Itemid=115" class="<?php if ($_REQUEST['Itemid']==115){?> nav_salesupdate_active <?php }else{?> nav_salesupdate<?php }?>">SALES UPDATE</a></li>
                            </ul>
                        </li>
                        <li><a href="index.php?option=com_content&view=article&id=66&&Itemid=2" class="<?php if ($_REQUEST['Itemid']==2){?> nav_membership_active <?php }else{?> nav_membership<?php }?>">MEMBERSHIP</a></li>
                        <li><a href="<?php echo $linkPhoto;?>" class="<?php if ($_REQUEST['view']=="easygallery"){?> nav_photogallery_active <?php }else{?> nav_photogallery<?php }?>">PHOTO GALLERY</a></li>
                        <li><a href="index.php?option=com_content&view=article&id=46&Itemid=41" class="<?php if ($_REQUEST['Itemid']==41){?> nav_aboutus_active <?php }else{?> nav_aboutus<?php }?>">ABOUT US</a></li>
                        <li><a href="<?php echo $linkNews;?>" class="<?php if ($_REQUEST['Itemid']==48){?> nav_press_active <?php }else{?> nav_press<?php }?>">PRESS</a></li>
                        <li><a href="<?php echo $this->baseurl ?>/index.php?option=com_hualalaiblog&view=list" class="<?php if ($_REQUEST['option']=='com_hualalaiblog'){?> nav_blog_active <?php }else{?> nav_blog<?php }?>">BLOG</a></li>
                    
						<li><a href="http://www.facebook.com/HualalaiRealEstate" target="_blank" class="nav_facebook">Facebook</a></li>
                    </ul>                   
                </div>
                <div class="clear"></div>
            </div>
            
            <?php if ($_REQUEST['option']=="com_realestatemanager" && $_REQUEST['task']=="showCategory"){?>
                <div class="secondary_menu">
                    <a href="<?php echo $allProperty;?>" class="<?php if ($_REQUEST['catid']==0 && $_REQUEST['option']=="com_realestatemanager"){?> nav_propertiessale_active <?php }else{?> nav_propertiessale<?php }?>">All Properties for Sale</a>
                    <a href="<?php echo $villas;?>" class="<?php if ($_REQUEST['catid']==44 && $_REQUEST['option']=="com_realestatemanager"){?> nav_villasale_active <?php }else{?> nav_villasale<?php }?>">Villas for sale</a>
                    <a href="<?php echo $homes;?>" class="<?php if ($_REQUEST['catid']==54 && $_REQUEST['option']=="com_realestatemanager"){?> nav_homesale_active <?php }else{?> nav_homesale<?php }?>">Homes for sale</a>
                    <a href="<?php echo $homesites;?>" class="<?php if ($_REQUEST['catid']==51 && $_REQUEST['option']=="com_realestatemanager"){?> nav_homesitesale_active <?php }else{?> nav_homesitesale<?php }?>">Homesites for sale</a>
                </div>            
                <div class="submenu">
                    <span>
                        <img src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/title_sortproperties.gif" width="118" height="13"
                        alt="Title Sort Properties by, Hualalai Realty, Real Estate, Resort, Villa" />
                    </span>
                <?php 
				global $mainframe;
				$session=&JFactory::getSession();
				$order_name = $session->get("orderName"); 
				$linktitle = JRoute::_( "index.php?option=com_realestatemanager&task=showCategory&catid=".$_REQUEST['catid']."&ord=streetName,addNumber");
				$linkbed = JRoute::_( "index.php?option=com_realestatemanager&task=showCategory&catid=".$_REQUEST['catid']."&ord=bedrooms");
				$linkprice = JRoute::_( "index.php?option=com_realestatemanager&task=showCategory&catid=".$_REQUEST['catid']."&ord=price");
				?>    
                    <a href="<?php echo $linktitle;?>" class="<?php if ($order_name=="streetName,addNumber"){?>nav_name_active<?php }else{?> nav_name<?php }?>">Name</a>
                    <?php if ($_REQUEST['catid']!='51'){?>
                    <a href="<?php echo $linkbed;?>" class="<?php if ($order_name=="bedrooms"){?>nav_bedroom_active<?php }else{?> nav_bedroom<?php }?>">Bedrooms</a>
                    <?php }?>
                    <a href="<?php echo $linkprice;?>" class="<?php if ($order_name=="price"){?>nav_price_active<?php }else{?> nav_price<?php }?>">Price</a>
                </div>
            <?php } if ($_REQUEST['option']=="com_realestatemanager" && $_REQUEST['task']=="view"){?>
            	<div class="secondary_menu_property">
                    <div class="prev_next float_left">
					<?php 
						global $mainframe, $database;
						
						$session=&JFactory::getSession();
						$order_name = $session->get("orderName"); 
						
						$query = "SELECT streetName, addNumber, price, bedrooms FROM #__rem_houses"
						. "\nWHERE id = ".$_REQUEST['id']." ";
						$database->setQuery( $query );
						$house = $database->loadObjectList();
						
						if ($order_name == "streetName,addNumber"){
							$prev_next_street = $house[0]->streetName;
							$prev_next_addno  = $house[0]->addNumber;
						}if ($order_name == "price"){
							$prev_next = $house[0]->price;
						}if ($order_name == "bedrooms"){
							$prev_next = $house[0]->bedrooms;
						}
						
						$queryCatP = "SELECT parent_id FROM #__categories WHERE id = ".intval($_REQUEST['catid']);
						$database->setQuery( $queryCatP );
						$catParent = $database->loadObjectList();
						
						if ($catParent[0]->parent_id>0){
							$selCat = $catParent[0]->parent_id;
						}else{
							$selCat = $_REQUEST['catid'];	
						}		
						
						if ($order_name=="price"){
						
							$query = "SELECT * FROM #__rem_houses"
							. "\nWHERE published='1' AND catid = ".$_REQUEST['catid']." AND approved='1'";
							$database->setQuery( $query );
							$navhouses = $database->loadObjectList();
								
								for ($i=0; $i<count($navhouses)-1; $i++){
									for ($j=0; $j<count($navhouses)-1-$i; $j++){
										$house_i = $navhouses[$j];
										$house_j = $navhouses[$j+1];
										
										$price_i = $house_i->price;
										$price_j = $house_j->price;
										
										if ($price_i[0]=="$" && $price_j[0]=="$"){
										
											$price_i = substr($price_i, 1, strlen($price_i));
											$price_i = (int)str_replace(",", "", $price_i);
											
											$price_j = substr($price_j, 1, strlen($price_j));
											$price_j = (int)str_replace(",", "", $price_j);
											
											if ($price_i>$price_j){
												$temp = $navhouses[$j];
												$navhouses[$j] = $navhouses[$j+1];
												$navhouses[$j+1] = $temp;
											}
										}else{
											if ($price_j[0]=="$"){
												$temp = $navhouses[$j];
												$navhouses[$j] = $navhouses[$j+1];
												$navhouses[$j+1] = $temp;
											}						
											else if (strcmp($price_j, $price_i)<0){
												$temp = $navhouses[$j];
												$navhouses[$j] = $navhouses[$j+1];
												$navhouses[$j+1] = $temp;
											}			
										}									
									}																
								}	
								
								for ($nav=0; $nav<count($navhouses); $nav++){
									if ($navhouses[$nav]->id == $_REQUEST['id']){
										break;
									}														
								}
								
								$previous_obj = NULL;
								$next_obj = NULL;
								
								if($nav>0)
									$previous_obj = $navhouses[$nav-1];
								if($nav+1<count($navhouses))
									$next_obj = $navhouses[$nav+1];
								
								if ($previous_obj!=NULL){
									$prev_link = "index.php?option=com_realestatemanager&task=view&id=".$previous_obj->id."&catid=".$_REQUEST['catid']."&Itemid=0";
								}else{
									$prev_link = "#";
								}
								if ($next_obj!=NULL){
									$next_link = "index.php?option=com_realestatemanager&task=view&id=".$next_obj->id."&catid=".$_REQUEST['catid']."&Itemid=0";
								}else{
									$next_link = "#";
								}
													
						}elseif ($order_name=="bedrooms"){						
														
							$query = "SELECT * FROM #__rem_houses"
							. "\nWHERE published='1' AND catid = ".$_REQUEST['catid']." AND approved='1' ORDER BY bedrooms ASC";
							$database->setQuery( $query );
							$bedhouses = $database->loadObjectList();

							for ($bed=0; $bed<count($bedhouses); $bed++){								
								if ($bedhouses[$bed]->id == $_REQUEST['id']){									
									break;
								}														
							}
							
							$previous_obj = NULL;
							$next_obj = NULL;
							
							if($bed>0)
								$previous_obj = $bedhouses[$bed-1];
							if($bed+1<count($bedhouses))
								$next_obj = $bedhouses[$bed+1];
							
							if ($previous_obj!=NULL){
								$prev_link = "index.php?option=com_realestatemanager&task=view&id=".$previous_obj->id."&catid=".$_REQUEST['catid']."&Itemid=0";
							}else{
								$prev_link = "#";
							}
							if ($next_obj!=NULL){
								$next_link = "index.php?option=com_realestatemanager&task=view&id=".$next_obj->id."&catid=".$_REQUEST['catid']."&Itemid=0";
							}else{
								$next_link = "#";
							}
							
						}else{							
							
							/*$query_prev = "SELECT * FROM #__rem_houses"
							. "\nWHERE published='1' AND catid = ".$_REQUEST['catid']." AND approved='1' AND streetName < \"".$prev_next_street."\" AND "
							. "\naddNumber < \"".$prev_next_addno."\" "
							. "\nORDER BY streetName,addNumber DESC Limit 0,1";
							$database->setQuery( $query_prev );
							$houses_prev = $database->loadObjectList();
							
							$query_next = "SELECT * FROM #__rem_houses"
							. "\nWHERE published='1' AND catid = ".$_REQUEST['catid']." AND approved='1' AND streetName > \"".$prev_next_street."\" AND "
							. "\naddNumber > \"".$prev_next_addno."\" "
							. "\nORDER BY streetName,addNumber ASC Limit 0,1";
							$database->setQuery( $query_next );
							$houses_next = $database->loadObjectList();*/
							
							$query_prev_next = "SELECT * FROM #__rem_houses"
							. "\nWHERE published='1' AND catid = ".$_REQUEST['catid']." AND approved='1' "
							. "\nORDER BY streetName,addNumber ASC";
							$database->setQuery( $query_prev_next );
							$houses_prev_next = $database->loadObjectList();
							
							for ($i=0; $i<count($houses_prev_next); $i++){
								
								if ($_REQUEST['id' ]== $houses_prev_next[$i]->id){
									if ($i==0){
										$houses_prev_id = "#";
									}else{
										$houses_prev_id = $houses_prev_next[$i-1]->id;
									}
									
									if ($i==count($houses_prev_next)-1){
										$houses_next_id = "#";
									}else{
										$houses_next_id = $houses_prev_next[$i+1]->id;
									}
								}															
							}

							if ($houses_prev_id != "#"){
								$prev_link = "index.php?option=com_realestatemanager&task=view&id=".$houses_prev_id."&catid=".$_REQUEST['catid']."&Itemid=0";
							}else{
								$prev_link = "#";
							}
							if ($houses_next_id != "#"){
								$next_link = "index.php?option=com_realestatemanager&task=view&id=".$houses_next_id."&catid=".$_REQUEST['catid']."&Itemid=0";
							}else{
								$next_link = "#";
							}
						}
                    ?> 
                        <a href="<?php echo $prev_link;?>" class="btn_prev">Prvious Villa</a>
                        <a href="<?php echo $next_link;?>" class="btn_next">Next Villa</a>
                        <div class="clear"></div>
                    </div>
                    <a href="<?php echo $this->baseurl ?>/index.php?option=com_realestatemanager&task=showCategory&catid=51" class="<?php if ($selCat=='51'){?>nav_homesitesale_active<?php }else{?>nav_homesitesale<?php }?>">Homesites for sale</a>
                    <a href="<?php echo $this->baseurl ?>/index.php?option=com_realestatemanager&task=showCategory&catid=54" class="<?php if ($selCat=='54'){?>nav_homesale_active<?php }else{?>nav_homesale<?php }?>">Homes for sale</a>
                    <a href="<?php echo $this->baseurl ?>/index.php?option=com_realestatemanager&task=showCategory&catid=44" class="<?php if ($selCat=='44'){?>nav_villasale_active<?php }else{?>nav_villasale<?php }?>">Villas for sale</a> 
                    <a href="<?php echo $this->baseurl ?>/index.php?option=com_realestatemanager&task=showCategory&catid=0" class="<?php if ($selCat=='0'){?>nav_propertiessale_active<?php }else{?>nav_propertiessale<?php }?>">All Properties for Sale</a>
                    <div class="clear"></div>
	            </div>
           <?php }?>
        </div>
    
    	<?php 			
		if ($_REQUEST['view']=="frontpage" || $_REQUEST['view']=="article" || $_REQUEST['option']=="com_user"  || $_REQUEST['view']=="category"){?>	    
            <div class="banner">
                <div class="banner_image">
                    <div class="banner_image_in">
                    <?php
					$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
					$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
					$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");					
					
					if( ($iPod || $iPhone || $iPad) && $_REQUEST['id']=='45' && $_REQUEST['Itemid']=='84' ){
					?>
                    	<jdoc:include type="modules" name="ihome_banner"/>
                    <?php }else{?>    
                        <jdoc:include type="modules" name="user3"/>
                    <?php }?>
                    </div>
                </div>
                
                <br />
                
            </div>
        <?php }?>
        
        <div class="section">        	
        	<?php if (($_REQUEST['view']=="frontpage") || ($_REQUEST['view']=="article" && $_REQUEST['id']==45)){?>
                <div class="home_promo">
                    
                    <div class="table_promo_box float_left">
                        <jdoc:include type="modules" name="left"/>
                    </div>                    
                   <!-- <div class="four_panel float_left"> -->
                        <jdoc:include type="modules" name="middle"/>                	 
                   <!-- </div>   -->     
                  
                    <div class="table_promo_box float_right nomargin">
                    	<jdoc:include type="modules" name="right"/>
                        <!--<span>
                            <a href="<?php echo $this->baseurl ?>/index.php?option=com_hualalainews&view=hualalainews&task=show&Itemid=48">
                                <img height="304" width="220" alt="Latest Press about Hualalai Resort" src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/image_latest_press.jpg">                              
	                              <span class="featured_thumbnil">
                                  <img height="304" width="220" alt="Featured Property" src="<?php echo $this->baseurl ?>/templates/hualalairealty/images/bg_rounded_featured.png">
                                </span>
                            </a>
                        </span>
                        <a href="<?php echo $linkNews;?>"><label>LATEST PRESS</label></a>-->
                    </div>                    
                </div> 
                <div class="content_divider"></div>             
             <?php }?>             
                        
            <div class="content_text">		
				<span style="color:red;"><jdoc:include type="message" /></span>
				<div style="clear: both"></div><br/>
            	<jdoc:include type="component" />                
                <div style="clear: both"></div>
            </div><br />
        
        	<div style="clear: both"></div>    
        </div>
        
    
        <div class="footer">
            <div class="content_divider"></div>
        	<div class="footer_top">             
                <jdoc:include type="modules" name="user2"/>
            </div>
            
        	<div class="footer_middle">              
                <jdoc:include type="modules" name="user1"/>
            </div>
            
            <div class="footer_bottom">
                <jdoc:include type="modules" name="user4"/>
            </div>
        </div>
    </div>
	
    <script>
	//jQuery.noConflict();

    jQuery(document).ready(function() {
			if (jQuery("#galleria").length > 0){
				Galleria.loadTheme('<?php echo $this->baseurl ?>/templates/hualalairealty/tools/galleria/galleria.classic.min.js');
				Galleria.run('#galleria');
			}
		});
    </script>
<?php
if ($_REQUEST['id']=='46'){
?>    
<script language="javascript">
	jQuery.noConflict();

    jQuery(document).ready(function() {
        
        jQuery("#map-container AREA").mouseover(function(){
            var regionMap = '.'+jQuery(this).attr('id')+'-map';
            var regionList = '.'+jQuery(this).attr('id')+'-list';
            jQuery(regionMap).css('display', 'inline');

            // Check if a click event has occured and only change the Region hover state accodringly
            if (! jQuery('#practice-container ul').hasClass('selected')) {
                jQuery(regionList).css('display', 'inline');
            }
        }).mouseout(function(){
            var regionMap = '.'+jQuery(this).attr('id')+'-map';
            var regionList = '.'+jQuery(this).attr('id')+'-list';

            // Check if a click event has occured and only change the Region hover state accodringly
            if (! jQuery(regionMap).hasClass('selected')) {
                jQuery(regionMap).css('display', 'none');
            }

            // Check if a click event has occured and only change the Region hover state accodringly
            if (! jQuery('#practice-container ul').hasClass('selected')) {
                jQuery(regionList).css('display', 'none');
            }
        });

        jQuery("#map-container AREA").click(function(){
            jQuery('#map-container img.region').removeClass('selected').css('display', 'none');
            jQuery('#practice-container ul').removeClass('selected').css('display', 'none');
            
            var regionMap = '.'+jQuery(this).attr('id')+'-map';
            var regionList = '.'+jQuery(this).attr('id')+'-list';
            jQuery(regionMap).addClass('selected').css('display', 'inline');
            jQuery(regionList).addClass('selected').css('display', 'inline');
        });

    });
    
</script>
<?php
}?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-354568-21");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>