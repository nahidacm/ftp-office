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


include_once( dirname(__FILE__).'/compat.joomla1.5.php' );


 //*** Get language files
global $mosConfig_absolute_path, $mosConfig_lang;

$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'];
require_once($mosConfig_absolute_path."/administrator/components/com_realestatemanager/menubar_ext.php");


if (file_exists($mosConfig_absolute_path."/components/com_realestatemanager/language/{$mosConfig_lang}.php" )) {
	include_once($mosConfig_absolute_path."/components/com_realestatemanager/language/{$mosConfig_lang}.php" );
} else {
	include_once($mosConfig_absolute_path."/components/com_realestatemanager/language/english.php" );
       }


class menucat {
	function NEW_CATEGORY() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save();
		mosMenuBar_ext::cancel();
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::endTable();
	}
	function EDIT_CATEGORY() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save();
		mosMenuBar_ext::cancel();
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::endTable();
	}
	function SHOW_CATEGORIES() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::publishList();
		mosMenuBar_ext::unpublishList();
		mosMenuBar_ext::addNew();
		mosMenuBar_ext::editList();
		mosMenuBar_ext::deleteList();
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::endTable();
	}
  	function DEFAULT_CATEGORIES() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::publishList();
		mosMenuBar_ext::unpublishList();
		mosMenuBar_ext::addNew('new', 'Add');
		mosMenuBar_ext::editList();
		mosMenuBar_ext::deleteList();
		mosMenuBar_ext::endTable();
  } 

}


class menurealestatemanager 
{
        

	function MENU_NEW()
  {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save();
		mosMenuBar_ext::cancel();
		//mosMenuBar::help(./components/com_realestatemanager/help/1.html);
		mosMenuBar_ext::spacer();				
		mosMenuBar_ext::endTable();
  }

	function MENU_EDIT() {
		mosMenuBar_ext::startTable(); 
		mosMenuBar_ext::save();

		//*******************  begin add for review edit  **********************
		mosMenuBar_ext::editList('edit_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_EDIT_REVIEW);
		mosMenuBar_ext::deleteList('','delete_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_REVIEW );
		//*******************  end add for review edit  ************************

		mosMenuBar_ext::cancel();
		//mosMenuBar::help();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

	function MENU_DELETE_REVIEW() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save();
		mosMenuBar_ext::spacer();		

		//*******************  begin add for review edit  **********************
		mosMenuBar_ext::editList('edit_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_EDIT_REVIEW);
		mosMenuBar_ext::deleteList('','delete_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_REVIEW );
		//*******************  end add for review edit  ************************

		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::cancel();
		//mosMenuBar::help();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

	function MENU_EDIT_REVIEW() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save('update_review');
		mosMenuBar_ext::cancel('cancel_review_edit');
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();

	}

	function MENU_CANCEL() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::back();  //old valid  mosMenuBar::cancel();
		//mosMenuBar::help();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

	function MENU_CONFIG() {
		mosMenuBar_ext::startTable();
    mosMenuBar_ext::save('config_save');
		mosMenuBar_ext::cancel();
		//mosMenuBar::help();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}


//**************   begin for manage reviews   *********************
	function MENU_MANAGE_REVIEW() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::editList('edit_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_EDIT_REVIEW);
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::deleteList('','delete_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_REVIEW);
		mosMenuBar_ext::endTable();
	}

	function MENU_MANAGE_REVIEW_DELETE() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::editList('edit_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_EDIT_REVIEW);
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::deleteList('','delete_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_REVIEW);
		mosMenuBar_ext::endTable();
	}

	function MENU_MANAGE_REVIEW_EDIT() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::save('update_edit_manage_review');
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::cancel('cancel_edit_manage_review');
		mosMenuBar_ext::endTable();
	}

	function MENU_MANAGE_REVIEW_EDIT_EDIT() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::editList('edit_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_EDIT_REVIEW);
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::deleteList('','delete_manage_review',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_REVIEW);
		mosMenuBar_ext::endTable();
	}
//**************   end for manage reviews   ***********************

//**************   begin for manage suggestion    *****************
	function MENU_MANAGE_SUGGESTION() 
        {
		mosMenuBar_ext::startTable();
    mosMenuBar_ext::NewCustom('view_suggestion','adminForm',
      "../administrator/components/com_realestatemanager/images/dm_view_button.png",
      "../administrator/components/com_realestatemanager/images/dm_view_button_32.png",
      _REALESTATE_MANAGER_TOOLBAR_VIEW_SUGGESTION,_REALESTATE_MANAGER_TOOLBAR_ADMIN_VIEW_SUGGESTION, true, "adminForm");

		mosMenuBar_ext::deleteList('','delete_suggestion',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_SUGGESTION);
		mosMenuBar_ext::endTable();
	}

	function MENU_MANAGE_SUGGESTION_VIEW() {
		mosMenuBar_ext::startTable();
    mosMenuBar_ext::deleteList('','delete_suggestion',_REALESTATE_MANAGER_TOOLBAR_ADMIN_DELETE_SUGGESTION);  
    mosMenuBar_ext::spacer();
    mosMenuBar_ext::back("Back","index2.php?option=com_realestatemanager&task=manage_suggestion");

		mosMenuBar_ext::spacer();
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::endTable();
	}
//**************   end for manage suggestion    *******************


	
	function MENU_DEFAULT() {
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::publishList();
		mosMenuBar_ext::unpublishList();
		 
    mosMenuBar_ext::spacer();  
                
	/*  mosMenuBar_ext::NewCustom('rent','adminForm',
      "../administrator/components/com_realestatemanager/images/dm_lend.png",
      "../administrator/components/com_realestatemanager/images/dm_lend_32.png",
      _REALESTATE_MANAGER_TOOLBAR_RENT_HOUSES,_REALESTATE_MANAGER_TOOLBAR_ADMIN_RENT,true,'adminForm');		*/
		
  /*  mosMenuBar_ext::NewCustom('rent_return','adminForm',
      "../administrator/components/com_realestatemanager/images/dm_lend_return.png",
      "../administrator/components/com_realestatemanager/images/dm_lend_return_32.png",
      _REALESTATE_MANAGER_TOOLBAR_RETURN_HOUSES,_REALESTATE_MANAGER_TOOLBAR_ADMIN_RETURN,
      true,'adminForm');	*/
    mosMenuBar_ext::addNew();
    mosMenuBar_ext::spacer();
		mosMenuBar_ext::deleteList();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

  function MENU_SAVE_BACKEND()
  {
    mosMenuBar_ext::startTable();
    mosMenuBar_ext::spacer();
    mosMenuBar_ext::save();
    mosMenuBar_ext::spacer();
    mosMenuBar_ext::back();	             
    mosMenuBar_ext::spacer(); 
    mosMenuBar_ext::endTable();                    
  }


	function MENU_RENT() {
		mosMenuBar_ext::startTable();
/*
		mosMenuBar_ext::NewCustom('rent','adminForm',"../administrator/components/com_realestatemanager/images/dm_lend.png","../administrator/components/com_realestatemanager/images/dm_lend_32.png",_REALESTATE_MANAGER_TOOLBAR_RENT_HOUSES,_REALESTATE_MANAGER_TOOLBAR_ADMIN_RENT,true,'adminForm');*/

    mosMenuBar_ext::cancel();
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

	function MENU_RENTREQUESTS() 
  {
    global $mosConfig_absolute_path;
		mosMenuBar_ext::startTable();
                
    mosMenuBar_ext::NewCustom('accept_rent_requests','adminForm',
      '../administrator/components/com_realestatemanager/images/dm_accept.png',
      '../administrator/components/com_realestatemanager/images/dm_accept_32.png',
      _REALESTATE_MANAGER_TOOLBAR_ACCEPT_REQUEST,_REALESTATE_MANAGER_TOOLBAR_ADMIN_ACCEPT,
      true, 'adminForm');

    mosMenuBar_ext::NewCustom('decline_rent_requests','adminForm',
      '../administrator/components/com_realestatemanager/images/dm_decline.png',
      '../administrator/components/com_realestatemanager/images/dm_decline_32.png',
      _REALESTATE_MANAGER_TOOLBAR_EXPORT,_REALESTATE_MANAGER_TOOLBAR_ADMIN_DECLINE,
      true, 'adminForm');
                

    mosMenuBar_ext::cancel();
		//mosMenuBar::help(./components/com_realestatemanager/help/1.html);
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}

	function MENU_BUYINGREQUESTS() 
  {
 		global $mosConfig_absolute_path;
		mosMenuBar_ext::startTable();
                
    mosMenuBar_ext::NewCustom('accept_buying_requests','adminForm',
      '../administrator/components/com_realestatemanager/images/dm_accept.png',
      '../administrator/components/com_realestatemanager/images/dm_accept_32.png',
      _REALESTATE_MANAGER_TOOLBAR_ACCEPT_REQUEST,_REALESTATE_MANAGER_TOOLBAR_ADMIN_ACCEPT,true, 'adminForm');

    mosMenuBar_ext::cancel();
		//mosMenuBar::help(./components/com_realestatemanager/help/1.html);
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}
	
	function MENU_RENT_RETURN() {
		mosMenuBar_ext::startTable();
  /*  mosMenuBar_ext::NewCustom('rent_return','adminForm',
      "../administrator/components/com_realestatemanager/images/dm_lend_return.png",
      "../administrator/components/com_realestatemanager/images/dm_lend_return_32.png",
      _REALESTATE_MANAGER_TOOLBAR_RETURN_HOUSES,_REALESTATE_MANAGER_TOOLBAR_ADMIN_RETURN,
      true,'adminForm');	*/
		mosMenuBar_ext::cancel();
		//mosMenuBar::help(./components/com_realestatemanager/help/1.html);
		mosMenuBar_ext::spacer();		
		mosMenuBar_ext::endTable();
	}
	

  function MENU_IMPORT_EXPORT()
  {
    mosMenuBar_ext::startTable();
    mosMenuBar_ext::NewCustom_I('import','adminForm',
      '../administrator/components/com_realestatemanager/images/dm_import.png',
      '../administrator/components/com_realestatemanager/images/dm_import_32.png',
      _REALESTATE_MANAGER_TOOLBAR_IMPORT,_REALESTATE_MANAGER_TOOLBAR_ADMIN_IMPORT,true,'adminForm');
    
    mosMenuBar_ext::NewCustom_E('export','adminForm',
      '../administrator/components/com_realestatemanager/images/dm_export.png',
      '../administrator/components/com_realestatemanager/images/dm_export_32.png',
      _REALESTATE_MANAGER_TOOLBAR_EXPORT,_REALESTATE_MANAGER_TOOLBAR_ADMIN_EXPORT,true,'adminForm');	
                

    mosMenuBar_ext::back();  
		mosMenuBar_ext::spacer();
		mosMenuBar_ext::endTable();	
	}
	function MENU_ABOUT(){
		mosMenuBar_ext::startTable();
		mosMenuBar_ext::back();		
		mosMenuBar_ext::endTable();	
	}
	
}
?>