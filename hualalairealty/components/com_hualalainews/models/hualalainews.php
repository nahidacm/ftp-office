<?php
/**
 * @version		$Id: user.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	User
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');
/**
 * User Component User Model
 *
 * @author Johan Janssens <johan.janssens@joomla.org>
 * @package		Joomla
 * @subpackage	User
 * @since 1.5
*/

class hualalainewsModelhualalainews extends JModel
{
	/**
	 * User id
	 *
	 * @var int
	 */

	var $_id = null;
	/**
	 * User data
	 *
	 * @var array
	 */

	var $_data = null;
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */

	function __construct()
	{
		parent::__construct();
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId($id);
	}

	/**
	 * Method to set the weblink identifier
	 *
	 * @access	public
	 * @param	int Weblink identifier
	 */

	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a user
	 *
	 * @since 1.5
	 */

	function &getData()
	{
		// Load the weblink data
		if ($this->_loadData()) {
			//do nothing
		}
		return $this->_data;
	}

	/**
	 * Method to load user data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */

	 function _total(  ){
	 	 return $this->_getListCount($this->_buildQuery());
	 }
	 
	 function _buildQuery(){
	 
	 	$db = &JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$uid = $user->id; 
	 	 	
		return 'SELECT * FROM #__news_content WHERE published = 1 ORDER BY ordering ASC';
	 }	
	
	function _loadData($limitstart , $limit){

		$db = &JFactory::getDBO();								
		$db->setQuery($this->_buildQuery() , $limitstart , $limit);

		// Check the results
		if (!($list = $db->loadObjectList())){
			$this->setError(JText::_('COULD_NOT_FIND_USER'));
			return false;
		}
        return $list;
	}
	
	 function _buildDetailQuery($id){
	 
	 	$db = &JFactory::getDBO();
	 	 	
		return 'SELECT * FROM #__news_content WHERE id = '.$id;
	 }	
	
	function _loadDetailData($id){

		$db = &JFactory::getDBO();								
		$db->setQuery($this->_buildDetailQuery($id));

		// Check the results
		if (!($details = $db->loadObjectList())){
			$this->setError(JText::_('COULD_NOT_FIND_DATA'));
			return false;
		}
        return $details;
	}
	
	
}
?>