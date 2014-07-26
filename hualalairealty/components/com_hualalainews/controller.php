<?php
/**
 * @version		$Id: controller.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Weblinks Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class hualalainewsController extends JController{

	/**
	 * Method to show a weblinks view
	 *
	 * @access	public
	 * @since	1.5
	 */
	 function __construct($config = array()){
		parent::__construct($config);
        $this->registerTask( 'add'  , 	'display'  );
		$this->registerTask( 'edit'  , 	'display'  );
        $this->registerTask( 'save'  , 	'save'  );
        $this->registerTask( 'show'  , 	'show'  );
		$this->registerTask( 'remove', 	'remove'  );
		// Register Extra tasks
	}

	function display(){

        switch($this->getTask())
		{
			case 'add'     :
			{	JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'form'  );
				JRequest::setVar( 'view', 'hualalainews' );
				JRequest::setVar( 'edit', false );
			} break;

			case 'edit'     :
			{	JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'details'  );
				JRequest::setVar( 'view', 'hualalainews' );
				JRequest::setVar( 'edit', true );
			} break;

			case 'show'    :
			{	JRequest::setVar( 'hidemainmenu', 1 );
				JRequest::setVar( 'layout', 'show'  );
				JRequest::setVar( 'view', 'hualalainews' );
				JRequest::setVar( 'edit', false );
			} break;			

		}
        parent::display();
	}

	function save(){

		 $user 	=& JFactory::getUser();
		 $model =& $this->getModel('hualalainews');
		 $post 	= JRequest::get('post');
		 $model->store( $post );
		 $h_role_id = $model->_getgId( $user->id );
		 
		 $msg 	= "Data saved successfully";
		 
		 if ($h_role_id->h_role_id == '3'){
		 	$link 	= 'index.php?option=com_hualalainews&task=show&h_id='.$post['h_id'];
		 }else{
		 	$link 	= 'index.php?option=com_hualalainews&task=show';
		 }

		 $this->setRedirect($link, $msg);
	}

	function remove(){				

		$cid = $_REQUEST[cid];
		$user 	=& JFactory::getUser();		

		if (is_array($cid)){
			$cid = $cid[0];
		}else{
			$cid = $cid;	
		}
		
		$model = $this->getModel('hualalainews');
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$h_role_id = $model->_getgId( $user->id );

		if ($h_role_id->h_role_id == '3'){
		 	$this->setRedirect( 'index.php?option=com_hualalainews&task=show&h_id='.$_REQUEST['h_id']);
		}else{
			$this->setRedirect( 'index.php?option=com_hualalainews&task=show' );
		}		
	}
	
	function checkAccess(){

		global $mainframe;

		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$result	= null;
				
		$query = 'SELECT h_role_id '
		. ' FROM #__hbs_user_role_hotel '
		. ' WHERE h_user_id = '.$user->id;
		$db->setQuery($query);
		$row = $db->loadObjectList();
		$h_role_id = $row[0]->h_role_id;
		
		if (($h_role_id == '1') || ($h_role_id == '3')){
			return true;					
		}
		elseif ($h_role_id == '2'){		
			$query = "SELECT name AS menuname, link AS menulink FROM #__menu WHERE menutype = 'Hotels menu' AND id IN "
			. " ( SELECT menu_id FROM #__hbs_user_menu WHERE h_user_id = ".$user->id.") ORDER BY id ASC";
			$db->setQuery($query);
			$result = $db->loadObjectList();
			
			if ($db->getErrorNum()) {
				JError::raiseWarning( 500, $db->stderr() );
			}		
			if (count($result)){
				return true;
			}else{
				return false;
			}					
		} 		
		else {		
			return false;
		}
	}
}
?>