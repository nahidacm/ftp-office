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

if( stristr( $_SERVER['PHP_SELF'], 'administrator')) {
	@define( '_VM_IS_BACKEND', '1' );
}
defined('_VM_TOOLBAR_LOADED' ) or define('_VM_TOOLBAR_LOADED', 1 );

include_once( dirname(__FILE__).'/compat.joomla1.5.php' );


// ensure this file is being included by a parent file


require_once( $mainframe->getPath( 'toolbar_html' ) );
require_once( $mainframe->getPath( 'toolbar_default' ) );

$section = mosGetParam( $_REQUEST, 'section', 'courses' );


if (isset($section) && $section=='categories') { 

switch ($task) {
         
	case "new":
		menucat::NEW_CATEGORY();
		break;
	case "edit":
		menucat::EDIT_CATEGORY();
		break;
	default:
		menucat::SHOW_CATEGORIES();
		break;
  }
} else {


switch ($task) {
       
	case "new":
		menurealestatemanager::MENU_SAVE_BACKEND();
		break;

	case "edit":
		menurealestatemanager::MENU_EDIT();
		break;
		
	case "show_import_export":
		menurealestatemanager::MENU_IMPORT_EXPORT();
		break;
		
	case "rent":
		menurealestatemanager::MENU_RENT();
		break;

	case "rent_return":
		menurealestatemanager::MENU_RENT_RETURN();
		break;

	case "rent_requests":
		menurealestatemanager::MENU_RENTREQUESTS();
		break;

	case "buying_requests":
		menurealestatemanager::MENU_BUYINGREQUESTS();
		break;

	case "import":
		menurealestatemanager::MENU_CANCEL();
		break;

	case "export":
		menurealestatemanager::MENU_CANCEL();
		break;
	
	case "config":
		menurealestatemanager::MENU_CONFIG();
		break;


	case "config_save":
		menurealestatemanager::MENU_CONFIG();
		break; 

	case "about":
		menurealestatemanager::MENU_ABOUT();
		break;

	case "delete_review":
		menurealestatemanager::MENU_DELETE_REVIEW();
		break;

	case "edit_review":
		menurealestatemanager::MENU_EDIT_REVIEW();
		break;

	case "update_review":
		menurealestatemanager::MENU_EDIT();
		break;

	case "cancel_review_edit":
		menurealestatemanager::MENU_EDIT();
		break;

//**************   begin for manage reviews   *********************
	case "manage_review":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "delete_manage_review":
		menurealestatemanager::MENU_MANAGE_REVIEW_DELETE();
		break;

	case "edit_manage_review":
		menurealestatemanager::MENU_MANAGE_REVIEW_EDIT();
		break;

	case "update_edit_manage_review":
		menurealestatemanager::MENU_MANAGE_REVIEW_EDIT_EDIT();
		break;

	case "cancel_edit_manage_review":
		menurealestatemanager::MENU_MANAGE_REVIEW_EDIT_EDIT();
		break;

	case "sorting_manage_review_numer":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_mls":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_title_house":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_title_category":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_title_review":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_user_name":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_date":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;

	case "sorting_manage_review_rating":
		menurealestatemanager::MENU_MANAGE_REVIEW();
		break;
//**************   end for manage reviews   ***********************

//**************   begin for manage suggestion    *****************
	case "manage_suggestion":
		menurealestatemanager::MENU_MANAGE_SUGGESTION();
		break;

	case "delete_suggestion":
		menurealestatemanager::MENU_MANAGE_SUGGESTION();
		break;

	case "view_suggestion":
		menurealestatemanager::MENU_MANAGE_SUGGESTION_VIEW();
		break;
//**************   end for manage suggestion    *******************

	default:
		menurealestatemanager::MENU_DEFAULT();
		break;
}

} //else
?>