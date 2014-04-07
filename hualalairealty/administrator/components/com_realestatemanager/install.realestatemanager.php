<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) {
	die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
}

/**
*
* @package  RealEstateManager
* @copyright 2009 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
* Homepage: http://www.ordasoft.com
* @version: 1.0 Basic $
*  @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/



$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path']	= JPATH_SITE;

require_once($mosConfig_absolute_path."/administrator/components/com_realestatemanager/compat.joomla1.5.php");
require_once($mosConfig_absolute_path."/administrator/components/com_realestatemanager/install.realestatemanager.helper.php");
require_once ($mosConfig_absolute_path."/administrator/components/com_realestatemanager/admin.realestatemanager.class.impexp.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.php");


function com_install()
{

global $database,$mosConfig_absolute_path,$mosConfig_live_site;
//**********************   begin check version PHP   ***********************
$is_warning = false;

if ( (phpversion()) < 5 ) { 
	?>
<center>
<table width="100%" border="0">
  <tr>
    <td>
      <code>Installation status: <font color="red">fault</font></code>
    </td>
  </tr>
  <tr>
    <td>
      <code><font color="red">This component works correctly under PHP version 5.0 and higher.</font></code>
    </td>
  </tr>
</table>
</center>

<?php
return '<h2><font color="red">Component installation fault</font></h2>';
}

//******************   end check version PHP   ******************************


//********************   begin check CURL extension   ******************
if ( !(function_exists('curl_init')) ) {
$is_warning = true;
?>
<center>
<table width="100%" border="0">
  <tr>
    <td>
      <code><font color="red">CURL extension not found! In order for Photo download to work, you need to compile PHP5 with support for the CURL extension!</font></code>
    </td>
  </tr>
</table>
</center>
<?php
}
//****************   end check CURL extension   ***********************
//*************   begin check GD extension   *************************
if ( !(function_exists('imagefontwidth')) ) {
$is_warning = true;
?>
<center>
<table width="100%" border="0">
  <tr>
    <td>
      <code><font color="red">GD extension not found! In order for CAPTCHA picture works correctly, you need to compile PHP5 with support for the GD extension!</font></code>
    </td>
  </tr>
</table>
</center>
<?php
}
//************************   end check GD extension   ******************
DMInstallHelper::setAdminMenuImages();

//add simple data
$ret = mosRealEstateManagerImportExport  :: importHousesXML( $mosConfig_absolute_path."/administrator/components/com_realestatemanager/exports/sample_data.xml",NULL );
foreach ($ret as $entry){
    if( $entry[5] != "OK"){
      echo "<h2 style='color:red;'>Error Import simple data - ".$entry[5]."</h2>";
      $is_warning = true;
      break;
    } 
}
if( !$is_warning ) echo "<h2 style='color:#0f0;'>Import simple data - OK</h2>";


# Show installation result to user
?>
<center>
<table width="100%" border="0">
  <tr>
    <td>
      <strong>RealEstateManager</strong><br/>
      <br/>
      This component is published under the <a href="<?php echo $mosConfig_live_site."/components/com_realestatemanager/doc/LICENSE.txt"; ?>"
       target="new">License</a>.
    </td>
  </tr>
  <tr>
    <td>
      <code>Installation: <font color="green">succesful</font></code>
    </td>
  </tr>
    <tr>
      <td>
    If after download and evaluation you like RealEstateManger,, please vote for RealEstateManger, at the <a href="http://extensions.joomla.org/extensions/vertical-markets/real-estate/8529">Joomla Extension Site!</a>  
    </td>
  </tr>
</table>
</center>

<?php
if($is_warning) return '<h2><font color="red">The RealEstateManager Component installed with a warning about a missing PHP extension! Please read carefully and uninstall RealEstateManager. Next fix your PHP installation and then install RealEstateManager again.</font></h2>';
}
?>