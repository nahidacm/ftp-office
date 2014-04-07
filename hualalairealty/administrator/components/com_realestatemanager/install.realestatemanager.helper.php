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

if(!defined( '_JLEGACY' ))
{
 $GLOBALS['path'] = $mosConfig_live_site."/components/com_realestatemanager/images/";
}
else 
{
$GLOBALS['path'] = $mosConfig_live_site."/administrator/components/com_realestatemanager/images/";
}
$path = $GLOBALS['path'];
class DMInstallHelper
{ 
function getComponentId()
    {
        static $id;

        if(!$id)
        {
            global $database;
            $database->setQuery("SELECT id FROM #__components WHERE name= 'RealEstate Manager'");
            $id =$database->loadResult();
        }
        return $id;
    }

   
    function setAdminMenuImages(){
      global $database,$path;

        $id = DMInstallHelper::getComponentId();



        // Main mennu
        $database->setQuery("UPDATE #__components SET admin_menu_img = '".$path."dm_component_16.png' WHERE id=$id");
        $database->query();

        // Submenus
        $submenus = array();
        $submenus[] = array( 'image' => $path.'dm_edit_16.png', 'name'=>'Houses' );
        $submenus[] = array( 'image' => $path.'dm_component_16.png', 'name'=>'Categories' );
        $submenus[] = array( 'image' => $path.'dm_component_16.png', 'name'=>'Rent Requests' );
        $submenus[] = array( 'image' => $path.'dm_component_16.png', 'name'=>'Sale Manager' );
        $submenus[] = array( 'image' => $path.'dm_component_16.png', 'name'=>'Settings' );
        $submenus[] = array( 'image' => $path.'dm_credits_16.png', 'name'=>'About' );
       



        foreach( $submenus as $submenu )
          {

           $database->setQuery("UPDATE #__components SET admin_menu_img = '".$submenu['image']."'"
                                . "\n WHERE parent=$id AND name = '".$submenu['name']."';");
           $database->query();
          }



    }
}

?>