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

function realestatemanagerBuildRoute(&$query)
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
	
	if(isset($query['catid'])) {
		$id = $query['catid'];			
		$segments[] = $id;
		unset($query['catid']);
	};
	
	if(isset($query['ord'])) {				
		$segments[] = $query['ord'];
		unset($query['ord']);
	};
	
	if(isset($query['id'])) {		
		$segments[] = $query['id'];
		unset($query['id']);
	};
	
	if(isset($query['m'])) {
		$segments[] = $query['m'];
		unset($query['m']);
	};
	
   	return $segments;
}

function realestatemanagerParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	$menu =& JSite::getMenu();
	$item =& $menu->getActive(); 	

	if( $count == 3 && $segments[0]!="showCategory"){	
		$vars['task'] = $segments[0];
		$vars['catid'] = $segments[$count-2];
		$vars['id'] = $segments[$count-1];
	}else if( $count == 3 && $segments[0]=="showCategory" && $segments[2]!="1"){	
		$vars['task'] = $segments[0];
		$vars['catid'] = $segments[$count-2];
		$vars['ord'] = $segments[$count-1];
	}else if( $count == 2){
		$vars['task'] = $segments[0];		
		$vars['catid'] = $segments[$count-1];
	}else if( $count == 3 && $segments[2]=="1"){	
		$vars['task'] = $segments[0];
		$vars['catid'] = $segments[$count-2];
		$vars['m'] = $segments[$count-1];
	}else if( $count == 4 && $segments[3]=="1"){	
		$vars['task'] = $segments[0];
		$vars['catid'] = $segments[$count-3];
		$vars['id'] = $segments[$count-2];
		$vars['m'] = $segments[$count-1];
	}
	
  	return $vars;
}

?>