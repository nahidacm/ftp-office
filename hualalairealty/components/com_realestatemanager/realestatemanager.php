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

$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path']	= JPATH_SITE;

if (get_magic_quotes_gpc()) {
  function stripslashes_gpc(&$value)
  {
    $value = stripslashes($value);
  }
  array_walk_recursive($_GET, 'stripslashes_gpc');
  array_walk_recursive($_POST, 'stripslashes_gpc');
  array_walk_recursive($_COOKIE, 'stripslashes_gpc');
  array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}


require_once($mosConfig_absolute_path."/administrator/components/com_realestatemanager/compat.joomla1.5.php");

// load language
if (file_exists($mosConfig_absolute_path."/components/com_realestatemanager/language/{$mosConfig_lang}.php" ))
 {
  include_once($mosConfig_absolute_path."/components/com_realestatemanager/language/{$mosConfig_lang}.php" );
 } 
else 
 {
  include_once($mosConfig_absolute_path."/components/com_realestatemanager/language/english.php" );
 }


/** load the html drawing class */
require_once( $mainframe->getPath( 'front_html' ) );
require_once( $mainframe->getPath( 'class' ) );
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.rent_request.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.buying_request.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.rent.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.review.php");
require_once ($mosConfig_absolute_path."/administrator/components/com_realestatemanager/admin.realestatemanager.class.others.php");
require_once ($mosConfig_absolute_path."/administrator/components/com_realestatemanager/admin.realestatemanager.class.conf.php");


$GLOBALS['rentstatus_show'] = $realestatemanager_configuration['rentstatus']['show'];
$GLOBALS['rentrequest_registrationlevel'] = $realestatemanager_configuration['rentrequest']['registrationlevel'];
$GLOBALS['reviews_show'] = $realestatemanager_configuration['reviews']['show'];
$GLOBALS['reviews_registrationlevel'] = $realestatemanager_configuration['reviews']['registrationlevel'];
$GLOBALS['edocs_show'] = $realestatemanager_configuration['edocs']['show'];
$GLOBALS['edocs_registrationlevel'] = $realestatemanager_configuration['edocs']['registrationlevel'];
$GLOBALS['buy_now_show'] = $realestatemanager_configuration['buy_now']['show'];
$GLOBALS['buy_now_allow_categories'] = $realestatemanager_configuration['buy_now']['allow']['categories'];  
$GLOBALS['price_show'] = $realestatemanager_configuration['price']['show'];

$GLOBALS['cat_pic_show'] = $realestatemanager_configuration['cat_pic']['show'];
$GLOBALS['debug'] = $realestatemanager_configuration['debug'];
$GLOBALS['edocs_location'] = $realestatemanager_configuration['edocs']['location'];
$GLOBALS['subcategory_show'] = $realestatemanager_configuration['subcategory']['show'];
$GLOBALS['foto_high'] = $realestatemanager_configuration['foto']['high'];
$GLOBALS['foto_width'] = $realestatemanager_configuration['foto']['width'];						
$GLOBALS['realestatemanager_configuration'] = $realestatemanager_configuration;


$mainframe->setPageTitle( _REALESTATE_MANAGER_TITLE );

$task = trim( mosGetParam( $_REQUEST, 'task', "" ) );
$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
$catid = intval(mosGetParam( $_REQUEST, 'catid', 0 ) );
$bids = mosGetParam($_REQUEST, 'bid', array(0));

// paginations
$intro    =  $realestatemanager_configuration['page']['items']; // page length

if ($intro) 
 {
  $paginations = 1;
  $limit    = intval( mosGetParam( $_REQUEST, 'limit', $intro ) );
  $GLOBALS['limit'] = $limit;
 
  $limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );
  
  $GLOBALS['limitstart'] = $limitstart;

  $total    = 0;
  $LIMIT = 'LIMIT '.$limitstart.','.$limit;
 }
else 
{
  $paginations = 0;
  $LIMIT    = '';
}

 $session =& JFactory::getSession();
 $session->set("array",$paginations);
            

if($realestatemanager_configuration['debug'] == '1'){
  echo "Task: ".$task . "<br />";
  print_r($_GET); print_r($_POST);
  echo "<hr /><br />";
}


switch ($task)
{

	case 'show_search':
	showSearchHouses( $option, $catid, $option );
	break;
	
	case 'search':
	searchHouses( $option, $catid, $option );
	break;

	case 'view':
	showItemREM( $id, $catid );
	break;
	
	case 'virtualTour':
	showVirtualTour( $id, $catid );
	break;

	case 'review':
	reviewHouse( $option );
	break;
	
	case 'showCategory':
	//if no category is selected show default action
	if ($_REQUEST['catid']==0){
		showCategory( $catid );
	}
	if ( $catid ) 
	{
	  showCategory( $catid );
	} 
        else
	{
	  $task = "xxx";
	 }
	break;

	case 'rent_request':
		showRentRequest( $option, $bids );
	break;
	
	case 'save_rent_request':
		saveRentRequest( $option, $bids );
	break;

	case 'buying_request':
		saveBuyingRequest( $option, $bids );
	break;
	


	default:
	listCategories($catid);
	break;
	

}


function saveRentRequest($option, $bids){
	global $mainframe, $database, $my, $Itemid, $acl,$catid;
	global $realestatemanager_configuration ;
	

	if( !($GLOBALS['rentstatus_show'])  ||
	!checkAccess_REM($GLOBALS['rentrequest_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl))
	{
		           
		echo _REALESTATE_MANAGER_NOT_AUTHORIZED;
		return;
	}
	
	$help = array();	
	foreach($bids as $bid){
		$rent_request = new mosRealEstateManager_rent_request($database); 
		if (!$rent_request->bind($_POST)) {
			echo "<script> alert('".$rent_request->getError()."'); window.history.go(-1); </script>\n";
			exit ();
		}
		$rent_request->rent_request = date("Y-m-d H:i:s");
		$rent_request->fk_houseid = $bid;
		
		if (!$rent_request->check()) {
			echo "<script> alert('".$rent_request->getError()."'); window.history.go(-1); </script>\n";
			exit ();
		}
		if (!$rent_request->store()) {
			echo "<script> alert('".$rent_request->getError()."'); window.history.go(-1); </script>\n";
			exit ();
		}

    		$rent_request->checkin();
		array_push($help, $rent_request);
	}

	
	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	//
	$params->def( 'show_search', '1' );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

	$currentcat->descrip = _REALESTATE_MANAGER_LABEL_RENT_REQUEST_THANKS;
	
	// page image
	$currentcat->img = "./components/com_realestatemanager/images/rem_logo.png";

	$currentcat->header = $params->get( 'header' );
	
	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

    

	HTML_realestatemanager :: showRequestThanks($params, $currentcat);
	
}

function saveBuyingRequest( $option, $bids ){
	global $mainframe, $database, $my, $Itemid, $acl,$catid;
	global $realestatemanager_configuration ;

	$buying_request = new mosRealEstateManager_buying_request($database);
	if (!$buying_request->bind($_POST)) {
			echo $buying_request->getError();
			exit ();
		}
	$buying_request->buying_request = date("Y-m-d H:i:s");
	$buying_request->fk_houseid = $bids[0];
	if (!$buying_request->store()) {
			echo "error:".$buying_request->getError();
// 			exit ();
		}
	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	//
	$params->def( 'show_search', '1' );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

	$currentcat->descrip = _REALESTATE_MANAGER_LABEL_BUYING_REQUEST_THANKS;

	// page image
	$currentcat->img = "./components/com_realestatemanager/images/rem_logo.png";

	$currentcat->header = $params->get( 'header' );
    
	HTML_realestatemanager :: showRequestThanks($params, $currentcat);
}

function showVirtualTour( $hid, $catid ){
	global $mainframe, $database, $my, $Itemid, $acl,$catid;
	global $realestatemanager_configuration ;

	$hid = $_REQUEST['hid'];
	$catid = $_REQUEST['catid'];
	
	$query = "SELECT * FROM #__rem_houses"
		. "\nWHERE id =".$hid."";	
	$database->setQuery( $query );
	$houses = $database->loadObjectList();
	
	$query = "SELECT * " 
		. "FROM #__categories AS cc " 
		. " WHERE section='com_realestatemanager' AND id='$catid'"; 
	$database->setQuery( $query ); 
	$categories = $database->loadObjectList();
	
	$mainframe->setPageTitle( $categories[0]->title." ".$houses[0]->htitle." ** ".$houses[0]->listing_type." **" );	
	$house->cattitle = $category->title;
	$house->catID = $category->id;
	
    
	HTML_realestatemanager :: showVirtualTour( $houses, $categories );
}

function showRentRequest($option,$bid)
{
	global $mainframe, $database, $my, $Itemid, $acl;
	global $realestatemanager_configuration;


	
if( !($GLOBALS['rentstatus_show'])  ||
		!checkAccess_REM($GLOBALS['rentrequest_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl))
                {
                  echo _REALESTATE_MANAGER_NOT_AUTHORIZED;
	  	  return;
        	}
	
		
	$bids = implode(',', $bid);
	
	// getting all houses for this category
	$query = "SELECT * FROM #__rem_houses"
		. "\nWHERE id IN (" .  $bids . ") AND fk_rentid = 0"
		. "\nORDER BY catid, ordering";
	$database->setQuery( $query );
	$houses = $database->loadObjectList();
	
	
	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', _REALESTATE_MANAGER_DESC_TITLE );
	//$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'show_rentstatus', 1 );
	$params->def( 'show_rentrequest', 1 );
	$params->def( 'rent_save', 1); 
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );


	// page description
	$currentcat->descrip = _REALESTATE_MANAGER_DESC_RENT;
	
	// page image
	$currentcat->img = './components/com_realestatemanager/images/rem_logo.png';
	$currentcat->align = 'right';

	$currentcat->header = $params->get( 'header' );
	//$currentcat->header = $currentcat->header . ": " . $category->title;
	
	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

	HTML_realestatemanager :: showRentRequest($houses, $currentcat, $params, $tabclass, $catid, $sub_categories,false);
}


/**
 * comments for registered users
 */
function reviewHouse()
{

	global $mainframe, $database, $my, $Itemid, $acl, $realestatemanager_configuration, $mosConfig_absolute_path, $catid;
	

	if(!($GLOBALS['reviews_show'])  || !checkAccess_REM($GLOBALS['reviews_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) 
        {
		echo _REALESTATE_MANAGER_NOT_AUTHORIZED;
	 	return;
	}	

	
        $review = new mosRealEstateManager_review($database);

	$review->date = date("Y-m-d H:i:s");
	$review->getReviewFrom( $my->id );

	

	if (!$review->bind($_POST)) {
		echo "<script> alert('".$house->getError()."'); window.history.go(-1); </script>\n";
		exit ();
	}
	
	if (!$review->check()) {
		echo "<script> alert('".$house->getError()."'); window.history.go(-1); </script>\n";
		exit ();
	}
	if (!$review->store()) {
		echo "<script> alert('".$house->getError()."'); window.history.go(-1); </script>\n";
		exit ();
	}

	//showing the original entries
	mosRedirect("?option=com_realestatemanager&amp;task=view&amp;catid=".$_POST['catid']."&amp;id=$review->fk_houseid&amp;Itemid=$Itemid");

}



//this function check - is exist houses in this folder and folders under this category 
function is_exist_curr_and_subcategory_houses($catid) {
		global $database, $my; 

		$query = "SELECT *, COUNT(a.id) AS numlinks FROM #__categories AS cc" 
			. "\n LEFT JOIN #__rem_houses AS a ON a.catid = cc.id" 
			. "\n WHERE a.published='1' AND a.approved='1' AND section='com_realestatemanager' AND cc.id='$catid' AND cc.published='1' AND cc.access <= '$my->gid'" 
			. "\n GROUP BY cc.id" 
			. "\n ORDER BY cc.ordering"; 
		$database->setQuery( $query ); 
		$categories = $database->loadObjectList();
		if( count($categories) != 0 ) return true;

		$query = "SELECT id " 
			. "FROM #__categories AS cc " 
			. " WHERE section='com_realestatemanager' AND parent_id='$catid' AND published='1' AND access<='$my->gid'"; 
		$database->setQuery( $query ); 
		$categories = $database->loadObjectList();
 
		if( count($categories) == 0 ) return false;

		foreach($categories as $k) {
			if( is_exist_curr_and_subcategory_houses($k->id) ) return true;
		}
		return false; 
}//end function

//*****************************************************************************

//this function check - is exist folders under this category 
function is_exist_subcategory_houses($catid) {
		global $database, $my; 

		$query = "SELECT *, COUNT(a.id) AS numlinks FROM #__categories AS cc" 
			. "\n LEFT JOIN #__rem_houses AS a ON a.catid = cc.id" 
			. "\n WHERE a.published='1' AND a.approved='1' AND section='com_realestatemanager' AND parent_id='$catid' AND cc.published='1' AND cc.access <= '$my->gid'" 
			. "\n GROUP BY cc.id" 
			. "\n ORDER BY cc.ordering"; 
		$database->setQuery( $query ); 
		$categories = $database->loadObjectList();
		if( count($categories) != 0 ) return true;

		$query = "SELECT id " 
			. "FROM #__categories AS cc " 
			. " WHERE section='com_realestatemanager' AND parent_id='$catid' AND published='1' AND access<='$my->gid'"; 
		$database->setQuery( $query ); 
		$categories = $database->loadObjectList();
 
		if( count($categories) == 0 ) return false;

		foreach($categories as $k) {
			if( is_exist_subcategory_houses($k->id) ) return true;
		}
		return false; 
}//end function


/**
 * This function is used to show a list of all houses
 */
function listCategories( $catid ) 
{
//echo $catid ; exit;

	global $mainframe, $database, $my, $acl;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid, $realestatemanager_configuration;

	/*$query = "select c.id, c.parent_id, c.title, c.image, d.houses, '0' as display from (select id, parent_id, title, image from #__categories where section='com_realestatemanager' ORDER BY ordering ) as c left join ( select a.id as id, count(b.id) as houses  from #__categories as a, #__rem_houses as b  where b.catid=a.id and b.published=1 GROUP BY a.id) as d  on  c.id = d.id;";

	$database->setQuery( $query ); 
	$cat_all = $database->loadObjectList();*/
/////////////////////////////////////////////////////////////

 $query = "select c.id, c.parent_id, c.title, c.image,'0' as houses, '0' as display " .
    " from  #__categories as c where section='com_realestatemanager' ORDER BY parent_id, ordering "; 
    
 $database->setQuery( $query ); 
 $cat_all1 = $database->loadObjectList();

  $query = "select a.id as id, count(b.id) as houses ". 
    " from #__categories as a, #__rem_houses as b ".
    " where b.catid=a.id and b.published=1 GROUP BY a.id";

  $database->setQuery( $query ); 
  $cat_all2 = $database->loadObjectList();

  $cat_all = Array();

  foreach($cat_all1 as $cat_item1){
    foreach( $cat_all2 as $cat_item2 ){
      if($cat_item1->id === $cat_item2->id  ){
        $cat_item1->houses = $cat_item2->houses;
      }
    }
    $cat_all[] = $cat_item1;
  }

////////////////////////////////////////////////////////////

	for ($i = 0; $i < count($cat_all); $i++) {
		if (is_exist_curr_and_subcategory_houses($cat_all[$i]->id)) $cat_all[$i]->display = 1;
	}

	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'show_search', '1' );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

	// page header
	$currentcat->header = $params->get( 'header' );


	//add for show in category picture
	if(($GLOBALS['cat_pic_show'])) $params->def( 'show_cat_pic', 1 );

	// page description
	$currentcat->descrip = _REALESTATE_MANAGER_DESC;

	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

	HTML_realestatemanager::showCategories($params, $cat_all, $catid, $tabclass, $currentcat);
}



function constructPathway($cat){
    global $mainframe, $database, $option, $Itemid,$mosConfig_absolute_path;

    $query = "SELECT * FROM #__categories WHERE section = 'com_realestatemanager' AND published = 1";
    $database->setQuery($query);
    $rows = $database->loadObjectlist('id');
    $pid = $cat->id;
    $pathway = array();
    $pathway_name = array();
    while($pid != 0){

      $cat = @$rows[$pid];

      $pathway[] =  sefRelToAbs('index.php?option=' . $option . '&task=showCategory&catid=' . @$cat->id . '&Itemid=' . $Itemid);
      $pathway_name[] =  @$cat->title  ;
      $pid = @$cat->parent_id;
    }

    $pathway = array_reverse($pathway);
    $pathway_name = array_reverse($pathway_name);

    for($i=0,$n=count($pathway);$i<$n;$i++){
      $mainframe->appendPathWay($pathway_name[$i],$pathway[$i] );
//echo $pathway[$i] ."::";
    }
//exit;
}


/**
 * This function is used to show a list of all houses
 */
function showCategory( $catid )
{

	global $mainframe, $database, $acl, $my;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid, $realestatemanager_configuration;
	
	$session=&JFactory::getSession();
	$order_name = $session->get("orderName"); 	
	$order_by_name = $_REQUEST['ord'];
	
	if ($order_by_name == ''){
		$session->set('orderName', 'streetName,addNumber');
		$order_by_name = $session->get('orderName');
	}else{
		$session->set('orderName', $order_by_name);
		
		$order_by_name = $session->get('orderName');
	}
	// getting all houses for this category
	if ($catid){
		$query = "SELECT * FROM #__rem_houses"
			. "\nWHERE catid = '$catid' AND published='1' AND approved='1'"
			. "\nORDER BY ordering ASC";
		$database->setQuery( $query );
		$houses = $database->loadObjectList();	
		
	
		//getting the current category informations
		$query = "SELECT * FROM #__categories WHERE id='$catid'";
		$database->setQuery( $query );	
		$category = $database->loadObjectList();
		$category = $category[0];
	
		/*$query = "select c.id, c.parent_id, c.title, c.image, d.houses, '0' as display from (select id, parent_id, title, image from #__categories where section='com_realestatemanager' ) as c left join ( select a.id as id, count(b.id) as houses  from #__categories as a, #__rem_houses as b  where b.catid=a.id and b.published=1 GROUP BY a.id) as d  on  c.id = d.id;";
		
		$database->setQuery( $query ); 
		$cat_all = $database->loadObjectList();*/
	/////////////////////////////////////////////////////////////
	
	 $query = "select c.id, c.parent_id, c.title, c.image,'0' as houses, '0' as display " .
		" from  #__categories as c where section='com_realestatemanager' AND c.parent_id = ".$_REQUEST['catid']." ORDER BY parent_id, ordering ASC "; 
		
	 $database->setQuery( $query ); 
	 $cat_all1 = $database->loadObjectList(); 
	
	 // getting all houses for this category
		$query = "SELECT * FROM #__rem_houses"
			. "\nWHERE catid = '$catid' AND published='1' AND approved='1'"
			. "\nORDER BY ordering ASC";
		$database->setQuery( $query );
		$houses = $database->loadObjectList();	
	
		$query = "select a.id as id, count(b.id) as houses ". 
		" from #__categories as a, #__rem_houses as b ".
		" where b.catid=a.id and b.published=1 GROUP BY a.id";
	
	  $database->setQuery( $query ); 
	  $cat_all2 = $database->loadObjectList();
	  
	
	}else{
		$query = "SELECT * FROM #__rem_houses"
		. "\nWHERE published='1' AND approved='1'"
		. "\nORDER BY ordering ASC";
		$database->setQuery( $query );
		$houses = $database->loadObjectList();	
		
		//getting the current category informations
		$query = "SELECT * FROM #__categories WHERE published=1";
		$database->setQuery( $query );	
		$category = $database->loadObjectList();
		$category = $category[0];
	
		/*$query = "select c.id, c.parent_id, c.title, c.image, d.houses, '0' as display from (select id, parent_id, title, image from #__categories where section='com_realestatemanager' ) as c left join ( select a.id as id, count(b.id) as houses  from #__categories as a, #__rem_houses as b  where b.catid=a.id and b.published=1 GROUP BY a.id) as d  on  c.id = d.id;";
		
		$database->setQuery( $query ); 
		$cat_all = $database->loadObjectList();*/
	/////////////////////////////////////////////////////////////
	
	 $query = "select c.id, c.parent_id, c.title, c.image,'0' as houses, '0' as display " .
		" from  #__categories as c where section='com_realestatemanager' AND published='1' ORDER BY parent_id, ordering ASC "; 
		
	 $database->setQuery( $query ); 
	 $cat_all1 = $database->loadObjectList(); 
	
	 // getting all houses for this category
		$query = "SELECT * FROM #__rem_houses"
			. "\nWHERE published='1' AND approved='1'"
			. "\nORDER BY ordering ASC";
		$database->setQuery( $query );
		$houses = $database->loadObjectList();	
	
		$query = "select a.id as id, count(b.id) as houses ". 
		" from #__categories as a, #__rem_houses as b ".
		" where b.catid=a.id and b.published=1 GROUP BY a.id";
	
	  $database->setQuery( $query ); 
	  $cat_all2 = $database->loadObjectList();
	}
	
	

  $cat_all = Array();

  foreach($cat_all1 as $cat_item1){
    foreach( $cat_all2 as $cat_item2 ){
      if($cat_item1->id === $cat_item2->id  ){
        $cat_item1->houses = $cat_item2->houses;
      }
    }
    $cat_all[] = $cat_item1;
  }
	
  if ($_REQUEST['catid']!='' && count($cat_all) == 0){
  	$cat_all[]->id = $_REQUEST['catid'];
  }

////////////////////////////////////////////////////////////

	for ($i = 0; $i < count($cat_all); $i++) {
		if (is_exist_curr_and_subcategory_houses($cat_all[$i]->id)) $cat_all[$i]->display = 1;
	}
	

	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'category_name', $category->title );
	$params->def( 'show_search', '1' );
	
	//add to path category name
	constructPathway($category);
	$mainframe->appendPathWay($category->title);


	if( ($GLOBALS['rentstatus_show']) )
  {
		$params->def('show_rentstatus',1);
      
		if (checkAccess_REM($GLOBALS['rentrequest_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) {
			$params->def( 'show_rentrequest', 1);
		}
	}


	//add for show in category picture
	if( ($GLOBALS['cat_pic_show']) ) $params->def( 'show_cat_pic', 1 );

	$params->def( 'show_rating', 1 );
	
	$params->def( 'hits', 1 );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

	$currentcat->descrip = $category->description;
	
	// page image
	$currentcat->img = null;
	$path = $mosConfig_live_site .'/images/stories/';
	if ( $category->image != null && count($category->image) > 0) {
		$currentcat->img = $path . $category->image;
		$currentcat->align = $category->image_position;
	}

	$currentcat->header = $params->get( 'header' );
	$currentcat->header = "Hualalai Realty ".$category->title;
	$mainframe->setPageTitle( "Hualalai Realty  ".$category->title );
	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );



	HTML_realestatemanager::displayHouses($houses, $order_by_name, $currentcat, $params, $tabclass, $catid, $cat_all, is_exist_subcategory_houses($catid) );
}



function showItemREM ($id, $catid) 
{
	global $mainframe, $database, $my, $acl, $option ;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid, $realestatemanager_configuration,$session;
 	
	//add to path category name
	//getting the current category informations
	$query = "SELECT * FROM #__categories WHERE id='$catid'";
       
	$database->setQuery( $query );	
	$category = $database->loadObjectList();

	$category = $category[0];

    constructPathway($category);
    $pathway =  sefRelToAbs('index.php?option=' . $option . 
	  		'&task=showCategory&catid=' . $category->id . '&Itemid=' . $Itemid);
    $pathway_name =  "house"  ;

	$mainframe->appendPathWay($pathway_name,$pathway);
	$mainframe->appendPathWay(" ");

	//Record the hit
	$sql="UPDATE #__rem_houses SET hits = hits + 1 WHERE id = ". $id ."";
	$database->setQuery( $sql );
	$database->query();

	//load the house
	$house = new mosRealEstateManager( $database );
	$house->load($id);

    //print_r($house);
    //echo '<br /><br />';

    $session=&JFactory::getSession();
    $session->get("obj_house",$house);
	
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );


	if( ($GLOBALS['rentstatus_show']) ){
		$params->def( 'show_rentstatus', 1 );
		if (checkAccess_REM($GLOBALS['rentrequest_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) {
			$params->def( 'show_rentrequest', 1);
		}
	}
	
	if( ($GLOBALS['reviews_show']) ){
		$params->def( 'show_reviews', 1 );
		if (checkAccess_REM($GLOBALS['reviews_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) {
			$params->def( 'show_inputreviews', 1);
		}
	}	
	
	if( ($GLOBALS['edocs_show']) ){
		$params->def( 'show_edocstatus', 1 );
		if (checkAccess_REM($GLOBALS['edocs_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) {
			$params->def( 'show_edocsrequest', 1);//+18.01
				//+18.01
					}
		} 

	if( ($GLOBALS['price_show']) ){
		$params->def( 'show_pricestatus', 1 );
		$params->def( 'show_pricerequest', 1);
	}
//************   begin add button 'buy now'   ***************************

	
   if(($GLOBALS['buy_now_show']) ){
		$params->def( 'show_buy_now', 1 );
		$s = explode(',',$GLOBALS['buy_now_allow_categories']);
    foreach($s as $i )
    {
			if($i == $catid || $i == -2) {
        $params->def( 'show_input_buy_now', 1);
        break;
      }
		}
	}	
	
	$document =& JFactory::getDocument();
	$document->setDescription($house->metaDesc);
	$document->setMetaData( 'keywords', $house->metaTag );
	
	
//************   end add button 'buy now'   ********************************

	
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'item_description', 1 );
	$params->def( 'rent_request', $GLOBALS['rentrequest_registrationlevel']);
	$params->def( 'show_edoc', $GLOBALS['edocs_show']);
	$params->def( 'show_price', $GLOBALS['price_show']);
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
	
	// page header
	$currentcat->header = $params->get( 'header' );
	$currentcat->header = $currentcat->header . ": " . $house->htitle;
	
	$prop_id22 = $house->id;
	$sql22 = "SELECT *FROM user_prop_rel WHERE property_id='$prop_id22'";
	$result22 = mysql_query($sql22);
	$row22 = mysql_fetch_array($result22);
	$user_permitted = $row22[1];
	$arr = explode(",",$user_permitted);
	if (in_array($my->id, $arr) or (62==$my->id)){							
		$query = "select * from #__rem_photos WHERE fk_houseid=$house->id order by image_order ASC";
	}
	else{
		$query = "select * from #__rem_photos WHERE (fk_houseid=$house->id and need_login!='1') order by image_order ASC";
	}
	$database->setQuery( $query );
	$house_photos = $database->loadObjectList();

	$listing_type['foreclosure'] = _REALESTATE_MANAGER_OPTION_FORECLOSURE;
	$listing_type['house for rent'] = _REALESTATE_MANAGER_OPTION_HOUSE_FOR_RENT;
	$listing_type['room for rent'] = _REALESTATE_MANAGER_OPTION_ROOM_FOR_RENT;
	$listing_type['for sale'] =_REALESTATE_MANAGER_OPTION_FOR_SALE;
	$listing_type['new home'] = _REALESTATE_MANAGER_OPTION_NEW_HOME;
	$listing_type['sublet'] = _REALESTATE_MANAGER_OPTION_SUBLET;

	$house->listing_type_title = $house->listing_type;
	$house->listing_type = $listing_type[$house->listing_type];

	//cоздание списка "тип цены"
	
	$test['negotiable'] =_REALESTATE_MANAGER_OPTION_NEGOTIABLE;
	$test['starting'] =_REALESTATE_MANAGER_OPTION_STARTING;
	$house->price_type =	$test[$house->price_type];

	//cоздание списка "статус сделки"
	$listing_status_type['active'] =_REALESTATE_MANAGER_OPTION_ACTIVE;
	$listing_status_type['offer'] =_REALESTATE_MANAGER_OPTION_OFFER;
	$listing_status_type['contract'] =_REALESTATE_MANAGER_OPTION_CONTRACT;
	$listing_status_type['closed'] =_REALESTATE_MANAGER_OPTION_CLOSED;
	$listing_status_type['withdrawn'] =_REALESTATE_MANAGER_OPTION_WITHDRAWN;
	$house->listing_status=$listing_status_type[$house->listing_status];

	$property_type['apartment'] =_REALESTATE_MANAGER_OPTION_APARTMENT;
	$property_type['commercial'] =_REALESTATE_MANAGER_OPTION_COMMERCIAL;
	$property_type['condo'] =_REALESTATE_MANAGER_OPTION_CONDO;
	$property_type['coop'] =_REALESTATE_MANAGER_OPTION_COOP;
	$property_type['farm'] =_REALESTATE_MANAGER_OPTION_FARM;
	$property_type['land'] =_REALESTATE_MANAGER_OPTION_LAND;
	$property_type['manufactured'] =_REALESTATE_MANAGER_OPTION_MANUFACTURED;
	$property_type['multifamily'] =_REALESTATE_MANAGER_OPTION_MULTIFAMILY;
	$property_type['ranch'] =_REALESTATE_MANAGER_OPTION_RANCH;
	$property_type['single family'] =_REALESTATE_MANAGER_OPTION_SINGLE_FAMILY;
	$property_type['tic'] =_REALESTATE_MANAGER_OPTION_TIC;
	$property_type['townhouse'] =_REALESTATE_MANAGER_OPTION_TOWNHOUSE;
	$house->property_type=$property_type[$house->property_type];
	
	//cоздание списка "класс провайдера"
	$provider_class['agent']=_REALESTATE_MANAGER_OPTION_AGENT;
	$provider_class['aggregator']=_REALESTATE_MANAGER_OPTION_AGGREGATOR;
	$provider_class['broker']=_REALESTATE_MANAGER_OPTION_BROKER;
	$provider_class['franchisor']=_REALESTATE_MANAGER_OPTION_FRANCHISOR;
	$provider_class['homebuilder']=_REALESTATE_MANAGER_OPTION_HOMEBUILDER;
	$provider_class['publisher']=_REALESTATE_MANAGER_OPTION_PUBLISHER;
//	$provider_class[] = mosHtml::makeOption('mls',"mls");
	$house->provider_class=$provider_class[$house->provider_class];

	//cоздание списка "районирование"
	$zoning['agricultural']=_REALESTATE_MANAGER_OPTION_AGRICULTURAL;
	$zoning['commercial']=_REALESTATE_MANAGER_OPTION_COMMERCIAL;
	$zoning['industrial']=_REALESTATE_MANAGER_OPTION_INDUSTRIAL;
	$zoning['recreational']=_REALESTATE_MANAGER_OPTION_RECREATIONAL;
	$zoning['residential']=_REALESTATE_MANAGER_OPTION_RESIDENTIAL;
	$zoning['unincorporated']=_REALESTATE_MANAGER_OPTION_UNINCORPORATED;
	$house->zoning=$zoning[$house->zoning];

	//cоздание списка "style"
	$style['Cape Cod']=_REALESTATE_MANAGER_OPTION_CAPE_COD;
	$style['Colonial']=_REALESTATE_MANAGER_OPTION_COLONIAL;
	$style['Craftsman']=_REALESTATE_MANAGER_OPTION_CRAFTSMAN;
	$style['Gothic']=_REALESTATE_MANAGER_OPTION_GOTHIC;
	$style['Prairie']=_REALESTATE_MANAGER_OPTION_PRAIRIE;
	$style['Ranch']=_REALESTATE_MANAGER_OPTION_RANCH2;
	$style['Split Level']=_REALESTATE_MANAGER_OPTION_SPLIT_LEVEL;
	$style['Tudor']=_REALESTATE_MANAGER_OPTION_TUDOR;
	$style['Victorian Queen Anne']=_REALESTATE_MANAGER_OPTION_VICTORIAN_QUEEN_ANNE;
	$house->style=$style[$house->style];
	
	$ptitle = $category->title." ".$house->htitle;
	
	if ($house->listing_type_title == "In Escrow"){
		$ptitle = $ptitle." ** ".$house->listing_type_title." **";
	}
	$mainframe->setPageTitle( $ptitle );	
	$house->cattitle = $category->title;
	$house->catID = $category->id;
	
	// show the house
	HTML_realestatemanager::displayHouse( $house, $tabclass, $params, $currentcat, $ratinglist, $house_photos );
}



function showSearchHouses($options, $catid, $option)
{

	global $mainframe, $database, $my;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid;
	
	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	//
	$params->def( 'show_search', '1' );
	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

	$currentcat->descrip = _REALESTATE_MANAGER_SEARCH_DESC1;
      $currentcat->align = 'right';
	
	// page image
	$currentcat->img = "./components/com_realestatemanager/images/rem_logo.png";


	$currentcat->header = $params->get( 'header' );
	$currentcat->header = $currentcat->header . ": " . _REALESTATE_MANAGER_LABEL_SEARCH;
	
	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

	$categories[] = mosHTML :: makeOption('0', 'Search category');
	$database->setQuery("SELECT id AS value, name AS text FROM #__categories"."\nWHERE section='$option' ORDER BY ordering");
	$categories = array_merge($categories, $database->loadObjectList());

	if (count($categories) < 1) {
	    mosRedirect("index2.php?option=categories&amp;section=$option&amp;err_msg=You must first create category for that section.");
	}

	$clist = mosHTML :: selectList($categories, 'catid', 'class="inputbox" size="1"', 'value', 'text', 0);


	// show the House
	HTML_realestatemanager::showSearchHouses( $params, $currentcat, $clist , $option);

}

function searchHouses($options, $catid, $option){

	global $mainframe, $database, $my, $acl;
	global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
	global $cur_template, $Itemid, $realestatemanager_configuration,$session;
	
        $session = &JFactory::getSession();

	
  if(array_key_exists("searchtext",$_REQUEST))
  {	
    $search = mosGetParam( $_REQUEST, 'searchtext', '' );
    $search = addslashes($search) ; 
    $session->set("poisk",$search);	
  }	
        
    $poisk_search = $session->get("poisk","default");        

	$where = array();
	$Address            = " ";
	$Title              = " ";
	$Broker             = " ";
	$Feature            = " ";
	$Description        = " ";
	$Area		        = " ";
	$Listing_type       = " ";
	$Property_ownership = " ";
	$Model 	            = " ";
	$Style       	    = " ";
	$Agent 	            = " ";
	$Zoning             = " ";
	$Rent               = " ";
	$RentSQL            = " ";
	$RentSQL_JOIN_1	    = " ";
	$RentSQL_JOIN_2     = " ";
	$RentSQL_rent_until = " ";
	$is_add_or = false;
  $add_or_value  = "  ";
		
	if(isset($_GET['Address']) && $_GET['Address']=="on"){
      $Address = " ";
      if($is_add_or) $Address = " or " ;
      $is_add_or = true;
      $Address .=" LOWER(b.hlocation) LIKE '%$poisk_search%' ";       
	}
	if(isset($_GET['Title']) && $_GET['Title']=="on"){
      $Title = " ";
      if($is_add_or) $Title = " or " ;
      $is_add_or = true;
      $Title .=" LOWER(b.htitle) LIKE '%$poisk_search%' ";       
	}
	if(isset($_GET['Broker']) && $_GET['Broker']=="on"){
      $Broker = " ";
      if($is_add_or) $Broker = " or " ;
      $is_add_or = true;
      $Broker .=" LOWER(b.broker) LIKE '%$poisk_search%' ";       
	}

	if(isset($_GET['Feature']) && $_GET['Feature']="on"){
      $Feature = " ";
      if($is_add_or) $Feature = " or " ;
      $is_add_or = true;
      $Feature .=" LOWER(b.feature) LIKE '%$poisk_search%' ";       
	}
	
	if(isset($_GET['Description']) && $_GET['Description']=="on"){	
      $Description = " ";
      if($is_add_or) $Description = " or " ;
      $is_add_or = true;
      $Description .=" LOWER(b.description) LIKE '%$poisk_search%' ";       
	}
	
	if(isset($_GET['Listing_type']) && $_GET['Listing_type']=="on"){	
      $Listing_type = " ";
      if($is_add_or) $Listing_type = " or " ;
      $is_add_or = true;
      $Listing_type .=" LOWER(b.listing_type) LIKE '%$poisk_search%' ";       
	}
	
	if(isset($_GET['Area']) && $_GET['Area']=="on"){	
      $Area = " ";
      if($is_add_or) $Area = " or " ;
      $is_add_or = true;
      $Area .=" LOWER(b.area) LIKE '%$poisk_search%' ";       
	}
	
	if(isset($_GET['Property_ownership']) && $_GET['Property_ownership']=="on"){	
      $Property_ownership = " ";
      if($is_add_or) $Property_ownership = " or " ;
      $is_add_or = true;
      $Property_ownership .=" LOWER(b.property_type) LIKE '%$poisk_search%' ";       
	}
	
	if(isset($_GET['Model']) && $_GET['Model']=="on"){	
      $Model = " ";
      if($is_add_or) $Model = " or " ;
      $is_add_or = true;
      $Model .=" LOWER(b.model) LIKE '%$poisk_search%' ";       
	}

	if(isset($_GET['Style']) && $_GET['Style']=="on"){	
      $Style = " ";
      if($is_add_or) $Style = " or " ;
      $is_add_or = true;
      $Style .=" LOWER(b.style) LIKE '%$poisk_search%' ";       
	}

	if(isset($_GET['Agent']) && $_GET['Agent']=="on"){	
      $Agent = " ";
      if($is_add_or) $Agent = " or " ;
      $is_add_or = true;
      $Agent .=" LOWER(b.agent) LIKE '%$poisk_search%' ";       
	}

	if(isset($_GET['Zoning']) && $_GET['Zoning']=="on"){	
      $Zoning = " ";
      if($is_add_or) $Zoning = " or " ;
      $is_add_or = true;
      $Zoning .=" LOWER(b.zoning) LIKE '%$poisk_search%' ";       
  }


    //  print_r($_REQUEST['search_date_from']);exit;
    $search_date_from = $_REQUEST['search_date_from'];
    //if( ! get_magic_quotes_gpc()  )  
    $search_date_from = addslashes($search_date_from) ;
    $search_date_until = $_REQUEST['search_date_until'];
    //if( ! get_magic_quotes_gpc()  )  
    $search_date_until = addslashes($search_date_until) ;
  
  if(isset($_REQUEST['search_date_from']) && ( trim($_REQUEST['search_date_from'])  ) && trim($_REQUEST['search_date_until']) == "" ){ 
      $RentSQL="  ( ( fk_rentid = 0 OR
       NOT EXISTS (select dd.fk_houseid from #__rem_rent AS dd where dd.rent_until > '".
       $search_date_from."' and dd.rent_from < '".
       $search_date_from."' and dd.fk_houseid=b.id ) ) ".
      " AND (listing_type = \"house for rent\" OR 
      listing_type = \"room for rent\" OR 
      listing_type = \"sublet\" ) ) ";
      if($is_add_or) $RentSQL .= " AND " ;
 
      $RentSQL_JOIN_1="\nLEFT JOIN #__rem_rent AS d "; 
      $RentSQL_JOIN_2="\nON d.fk_houseid=b.id ";
  }
  if(isset($_REQUEST['search_date_until']) && (trim($_REQUEST['search_date_until']) ) && trim($_REQUEST['search_date_from']) == "" ){ 
      $RentSQL="  ( ( fk_rentid = 0  OR
       NOT EXISTS (select dd.fk_houseid from #__rem_rent AS dd where dd.rent_from < '".
       $search_date_until."' and dd.rent_until > '".
       $search_date_until."' and dd.fk_houseid=b.id ) ) ".
      " AND (listing_type = \"house for rent\" OR 
      listing_type = \"room for rent\" OR 
      listing_type = \"sublet\" ) ) ";
      if($is_add_or) $RentSQL .= " AND " ;
 
      $RentSQL_JOIN_1="\nLEFT JOIN #__rem_rent AS d "; 
      $RentSQL_JOIN_2="\nON d.fk_houseid=b.id ";
  }
  if(isset($_REQUEST['search_date_until']) && (trim($_REQUEST['search_date_until']) ) 
    && isset($_REQUEST['search_date_from']) && ( trim($_REQUEST['search_date_from'])  ) ){ 
      $RentSQL="  ( ( fk_rentid = 0 OR
       NOT EXISTS (select dd.fk_houseid from #__rem_rent AS dd where  ( dd.rent_until > '".
       $search_date_from."' and dd.rent_from < '".
       $search_date_from."' )   or ".
      " ( dd.rent_from < '".$search_date_until .
      "' and dd.rent_until > '".$search_date_until."' ) or ".
      " ( dd.rent_from > '".
      $search_date_from."' and dd.rent_until < '".
      $search_date_until."' ) ) ) ".
      " AND (listing_type = \"house for rent\" OR 
      listing_type = \"room for rent\" OR 
      listing_type = \"sublet\" ) ) ";
      if($is_add_or) $RentSQL .= " AND " ;
 
      $RentSQL_JOIN_1="\nLEFT JOIN #__rem_rent AS d "; 
      $RentSQL_JOIN_2="\nON d.fk_houseid=b.id ";
  }
  
  $RentSQL = $RentSQL.(($is_add_or)?( "( ( ".$Address."  " . $Title."  ". $Broker . "  ".
      $Feature." ".$Description."  ". $Listing_type. " ". $Area." ". $Property_ownership."  ". $Model ."  ". $Style . " " .
       $Agent."  ".  $Zoning ."  ))"):(" "));
  if( trim($RentSQL) !="" ) array_push($where, $RentSQL );
  
  array_push($where, " b.published = '1' " );
  array_push($where, " b.approved = '1' " );
  
  if($catid){
		array_push($where, "c.id=$catid");
	}
	
	// getting all houses for this category
	$query = "SELECT b.*, c.title as category_titel, c.ordering as category_ordering FROM #__rem_houses AS b ".
		"\nLEFT JOIN #__categories AS c".
		"\nON b.catid = c.id". 
		((count($where) ? "\nWHERE ".implode(' AND ', $where) : "")).
		"\nORDER BY category_ordering, ordering";	
	//print_r($query);//exit;
	$database->setQuery( $query );
	$houses = $database->loadObjectList();    
	if(!isset($houses[0]->id)){ 
		unset($houses[0]);}
	//var_Dump($houses);
	$currentcat = NULL;
	// Parameters
	$menu = new mosMenu( $database );
	$menu->load( $Itemid );
	$params = new mosParameters( $menu->params );
	$params->def( 'header', $menu->name );
	$params->def( 'pageclass_sfx', '' );
	$params->def( 'category_name', _REALESTATE_MANAGER_LABEL_SEARCH );
	$params->def( 'search_request', '1' );	
	$params->def( 'hits', 1 );
	$params->def( 'show_rating', 1 );
	
	
	if(($GLOBALS['rentstatus_show'])){
		$params->def( 'show_rentstatus', 1 );
		if (checkAccess_REM( $GLOBALS['rentrequest_registrationlevel'],'RECURSE', userGID_REM($my->id), $acl)) {
			$params->def( 'show_rentrequest', 1);
		}
	}


	//add for show in category picture
	if(($GLOBALS['cat_pic_show'])) $params->def('show_cat_pic',1);

	$params->def( 'back_button', $mainframe->getCfg('back_button'));

	$currentcat->descrip = _REALESTATE_MANAGER_SEARCH_DESC2;
	$currentcat->align = 'right';
	// page image
	$currentcat->img = "./components/com_realestatemanager/images/rem_logo.png";

  $currentcat->header = $params->get( 'header' );
	$currentcat->header = $currentcat->header .":". _REALESTATE_MANAGER_LABEL_SEARCH;
	
	// used to show table rows in alternating colours
	$tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

	if(isset($houses[0])){	
		HTML_realestatemanager::displayHouses($houses, $currentcat, $params, $tabclass, $catid, null,false);
	}else{
	print_r("<h1 >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"._REALESTATE_MANAGER_LABEL_SEARCH_NOTHING_FOUND." </h1><br><br> ");
	   }
	
	
	//HTML_realestatemanager::displayHouses($houses, $currentcat, $params, $tabclass, $catid, null,false);
//	HTML_realestatemanager::displayHouses($houses, $currentcat, $params, $tabclass, $catid, $cat_all);
}


function checkAccess_REM( $accessgroupid, $recurse, $usersgroupid, $acl) {
	
	//parse usergroups
	$tempArr = array();
	$tempArr = explode(',',$accessgroupid);
//	print_r($tempArr);echo ':<BR />'; print_r($usersgroupid);
//	echo ':<BR />';
	for($i = 0;$i<count($tempArr);$i++)
	{
	 if($tempArr[$i] == $usersgroupid || $tempArr[$i]==-2){
		return 1;
		}else 
		if($recurse == 'RECURSE'){
			$groupchildren=array();
			$groupchildren=$acl->get_group_children( $tempArr[$i], 'ARO', $recurse );
			if(is_array($groupchildren)&& count($groupchildren) > 0) 
				if ( in_array($usersgroupid, $groupchildren) )
					return 1;
					}
		
	}
        
		//deny access
     		return 0;
	  
}

function userGID_REM($oID){
  	global $database,$ueConfig;
	if($oID > 0) {
		$query = "SELECT gid FROM #__users WHERE id = '".$oID."'";
		$database->setQuery($query);
		$gid = $database->loadResult();
		return $gid;
	}
	else return 0;
}

?>