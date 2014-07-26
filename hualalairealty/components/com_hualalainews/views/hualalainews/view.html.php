<?php
/**
* @version		$Id: view.html.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @subpackage	Users
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Users component
 *
 * @static
 * @package		Joomla
 * @subpackage	Users
 * @since 1.0
 */

class hualalainewsViewhualalainews extends JView
{
	function display( $tpl = null)
	{
		$layout 	= $this->getLayout();
	 	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
		$edit		= JRequest::getVar('edit', true);
		
	    if ($layout=="show") 
				{				
				$this->_show();
				}

		if (($cid[0]!='') && ($edit=='1'))
				{				
				$this->_edit($cid[0]);
				}

		parent::display($tpl);
	}

	function _displayForm($tpl = null)
	{
		parent::display($tpl);
	}

	function _Show($tpl= null)
	{
      global $mainframe;
	  
	  $params		=& $mainframe->getParams();
	  $pathway  	=& $mainframe->getPathway();
	  $document 	=& JFactory::getDocument();		  

      $limit 		= $mainframe->getUserStateFromRequest('com_hualalainews.'.$this->getLayout().'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	  $limitstart	= $mainframe->getUserStateFromRequest('com_hualalainews.'.$this->getLayout().'limitstart', 'limitstart', 0, 'int');
      $limistart 	= ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );	 
      
	  $model		=& $this->getModel('hualalainews');	   
	  $allData		= $model->_loadData($limitstart , $limit);	  
	  $total 		= $model->_total();
	
	  $editor 		=& JFactory::getEditor();
      jimport('joomla.html.pagination');
      
	  $pagination 	= new JPagination($total, $limitstart, $limit);
      $uri 			=& JFactory::getURI();
  	  $cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
	  	  
	  $pathway->addItem( JText::_( "Hualalai Realty - in the News" ));
	  $params->set('page_title',	JText::_( "Hualalai Realty - in the News" ));	  	  
	  $document->setTitle( $params->get( 'page_title' ) );	
	  	
	  $this->assignRef('params',		    $params);
      $this->assignRef('action', 			$uri->tostring());
      $this->assignRef('pagination', 		$pagination);
	  $this->assignRef('allData', 			$allData);		  
	}
	
	function _edit($id)
	{
      global $mainframe;
	  
	  $params		=& $mainframe->getParams();
	  $pathway  	=& $mainframe->getPathway();
	  $document 	=& JFactory::getDocument();		  
      
	  $model		=& $this->getModel('hualalainews');	   
	  $detailData	= $model->_loadDetailData($id);	  

  	  $cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
	  	  
	  $pathway->addItem( JText::_( "Hualalai in the News" ));
	  $params->set('page_title',	JText::_( "Hualalai in the News" ));	  	  
	  $document->setTitle( $params->get( 'page_title' ) );	
	  	
	  $this->assignRef('params',		    $params);
	  $this->assignRef('detailData', 		$detailData);		  
	}
}
?>