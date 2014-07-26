<?php
/**
* @version		$Id: router.php 10752 2008-08-23 01:53:31Z eddieajau $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

function hualalainewsBuildRoute(&$query)
{

	static $items;

	$segments	= array();
	$itemid		= null;

	if(isset($query['view']))
	{		
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if(isset($query['task'])) {
		$segments[] = $query['task'];
		unset($query['task']);			
	};
	
	if(isset($query['Itemid'])) {
		$segments[] = $query['Itemid'];
		unset($query['Itemid']);
	};	
	
	if(isset($query['cid'])) {
		$id = $query['cid'][0];			
		$segments[] = $id;
		unset($query['cid']);
	};
	
   	return $segments;
}

function hualalainewsParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	$menu =& JSite::getMenu();
	$item =& $menu->getActive(); 	

	if( $count == 3 && $segments[0] != "edit"){	
		$vars['view'] = $segments[0];
		$vars['task'] = $segments[$count-2];
		$vars['Itemid'] = $segments[$count-1];
	}else if( $segments[0] == "edit"){
		$vars['task'] = $segments[0];
		$vars['Itemid'] = $segments[$count-2];
		$vars['cid'] = $segments[$count-1];		
	}
	
  	return $vars;
}

?>