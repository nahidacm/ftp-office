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

function print_vars($obj) {
    $arr = get_object_vars($obj);
    while (list($prop, $val) = each($arr))
		 if(class_exists($val)) print_vars($val);
		  else echo "\t $prop = $val\n<br />";
}

function print_methods($obj) {
    $arr = get_class_methods(get_class($obj));
    foreach ($arr as $method)   echo "\tfunction $method()\n <br />";
}

if (PHP_VERSION >= 5) {
    // Emulate the old xslt library functions
    function xslt_create() {
        return new XsltProcessor();
    }

    function xslt_process($xsltproc,
                          $xml_arg,
                          $xsl_arg,
                          $xslcontainer = null,
                          $args = null,
                          $params = null) {

        // Create instances of the DomDocument class
        $xml = new DomDocument;
        $xsl = new DomDocument;

        // Load the xml document and the xsl template
        $xml->load($xml_arg);
        $xsl->load($xsl_arg);

        // Load the xsl template
        $xsltproc->importStyleSheet($xsl);

        // Set parameters when defined
        if ($params) {
            foreach ($params as $param => $value) {
                $xsltproc->setParameter("", $param, $value);
            }
        }

        // Start the transformation
        $processed = $xsltproc->transformToXML($xml);

        // Put the result in a file when specified
        if ($xslcontainer) {
            return @file_put_contents($xslcontainer, $processed);
        } else {
            return $processed;
        }

    }

    function xslt_free($xsltproc) {
        unset($xsltproc);
    }
}

class mosRealEstateManagerImportExport{
	

	/**
	 * Imports the lines given to this method into the database and writes a
	 * table containing the information of the imported houses.
	 * The imported houses will be set to [not published] 
	 * Format: #;id;isbn;title;author;language
	 * @param array lines - an array of lines read from the file
	 * @param int catid - the id of the category the houses should be added to 
	 */
	function importHousesCSV($lines, $catid){
		global $database;
		$retVal= array();
		$i = 0;
	    	foreach ($lines as $line) {
	    		$tmp = array();

			if(trim($line) == "" ) continue;
	    		$line = explode('|', $line);//edit nik  old -->, -1);
				$house = new mosRealEstateManager($database);
				$house->houseid = trim($line[0]);
				$house->description = $line[1];
				$house->link = $line[2];
				$house->listing_type = $line[3];
				$house->price = $line[4];
				$house->price_type = $line[5];
				$house->htitle = $line[6];
	
				$house->hlocation = $line[7];
				$house->hlatitude = $line[8];
				$house->hlongitude = $line[9];

				$house->bathrooms = $line[10];
				$house->bedrooms = $line[11];
				$house->car = $line[12];
				$house->broker = $line[13];
				$house->image_link = $line[14];
				$house->listing_status = $line[15];

				$house->property_type = $line[16];
				$house->provider_class = $line[17];
				$house->year = $line[18];

				$house->agent = $line[19];
				$house->area = $line[20];
				$house->expiration_date = $line[21];
				$house->feature = $line[22];
				$house->hoa_dues = $line[23];
				$house->lot_size = $line[24];
				$house->model = $line[25];
				$house->property_taxes = $line[26];
				$house->school = $line[27];
				$house->school_district = $line[28];
				$house->style = $line[29];
				$house->zoning = $line[30];
				$house->date = $line[31];
				$house->hits = $line[32];

				$house->catid = $catid;
				
	        
				    // optimize!!!
			            $tmp[0] = $i;
			            $tmp[1] = trim($line[0]);
//			            $tmp[2] = $line[12];
			            $tmp[2] = $line[7];
			            $tmp[3] = $line[6];
			            $tmp[4] = $line[3];
				
				if (!$house->check() || !$house->store()) {
					$tmp[5] =  $house->getError(); 
				} else {
					$tmp[5] =  "OK";
				}
				$house->checkin();
				$house->updateOrder( "catid='$house->catid'" );
				$retVal[$i] = $tmp;
				$i ++;
			}
			return $retVal;
	}

	function getXMLItemValue($item,$item_name) {
	    $house_items = $item->getElementsByTagname( $item_name );
	    $house_item = $house_items->item(0);
	    if(NULL != $house_item) return $house_item->nodeValue ;
		else return "";	
	}

  function findCategory(& $categories, $new_category ) 
  {
    global $database;
  
    foreach( $categories as $category ){
      if($category->old_id == $new_category->old_id ) return  $category;
    }
    $new_parent_id = null;
    if($new_category->old_parent_id != 0 ){
      foreach( $categories as $category ){
        if($category->old_id == $new_category->old_parent_id ){
          $new_parent_id = $category->id;
          break;
        }
      }
    }
    else $new_parent_id = 0;

    //sanity test
    if( $new_parent_id === null) {
      echo "error in import !"; exit;
    }

    $row = new mosCategory($database);
    $row->section='com_realestatemanager';
    $row->parent_id=$new_parent_id ;
    $row->name=$new_category->name ;
    $row->title=$new_category->title ;
    $row->published=$new_category->published ;

    if (!$row->check()) {
      echo "error in import2 !"; exit;
      exit();
    }
    if (!$row->store()) {
      echo "error in import3 !"; exit;
      exit();
    }

    $row->updateOrder("section='com_realestatemanager' AND parent_id='$row->parent_id'");

    $new_category->id = $row->id;
    $categories[] = $new_category;

    return  $new_category;
    
  }

//******************   begin add for import XML format   ****************************
	function importHousesXML($files_name_pars, $catid) 
	{
	
  	global $database;
		$retVal= array();
		$k = 0;
    $new_categories = array();
    $new_relate_ids = array();

		$dom = new domDocument('1.0','windows-1251');
		$dom->load($files_name_pars);

    if($catid === null){
      $cat_list = $dom->getElementsByTagname('category');
      for ($i = 0; $i < $cat_list->length; $i++){
        $category = $cat_list->item($i);
        $new_category = null;
        $new_category->old_id = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_id');
        $new_category->old_parent_id = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_parent_id');
        $new_category->name = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_name');
        $new_category->title = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_title');
        $new_category->published = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_published');
        $new_category->params = mosRealEstateManagerImportExport::getXMLItemValue($category,'category_type');
        $new_category = mosRealEstateManagerImportExport::findCategory($new_categories, $new_category ) ;
      }
    }


		$house_list = $dom->getElementsByTagname('house');
// 		$st = $houseid = "";
// 		$begin = $end = $kol = 0;

		for ($i = 0; $i < $house_list->length; $i++) {
		    $house_class = new mosRealEstateManager($database);

		    $house = $house_list->item($i);
 
//		    echo $house_item->hasChildNodes() . "<br />";

		    //get HouseID
		    $house_id = $house_class->houseid = mosRealEstateManagerImportExport::getXMLItemValue($house,'houseid');
//getting requirement fields
		    //get description
		    $house_description = $house_class->description = mosRealEstateManagerImportExport::getXMLItemValue($house,'description');
		    //get link
		    $house_class->link = mosRealEstateManagerImportExport::getXMLItemValue($house,'link');
		    //get listing_type
		    $house_listing_type = $house_class->listing_type = mosRealEstateManagerImportExport::getXMLItemValue($house,'listing_type');
		    //get Title(house)
		    $house_htitle = $house_class->htitle = mosRealEstateManagerImportExport::getXMLItemValue($house,'htitle');
		    //get price
		    $house_class->price = mosRealEstateManagerImportExport::getXMLItemValue($house,'price');
			 //get price Text
		    $house_class->price_text = mosRealEstateManagerImportExport::getXMLItemValue($house,'price_text');
//getting recommended fields
		    //get location
		    $house_hlocation = $house_class->hlocation = mosRealEstateManagerImportExport::getXMLItemValue($house,'hlocation');
		    //get latitude
		    $house_hlatitude = $house_class->hlatitude = mosRealEstateManagerImportExport::getXMLItemValue($house,'hlatitude');
		    //get longitude
		    $house_hlongitude = $house_class->hlongitude = mosRealEstateManagerImportExport::getXMLItemValue($house,'hlongitude');
		    //get map_zoom
//		    $house_map_zoom = $house_class->map_zoom = mosRealEstateManagerImportExport::getXMLItemValue($house,'map_zoom');
		    //get bathrooms
		    $house_class->bathrooms = mosRealEstateManagerImportExport::getXMLItemValue($house,'bathrooms');
		    //get bedrooms
		    $house_class->bedrooms = mosRealEstateManagerImportExport::getXMLItemValue($house,'bedrooms');
			//get cars
		    $house_class->car = mosRealEstateManagerImportExport::getXMLItemValue($house,'car');			
		    //get broker
		    $house_class->broker = mosRealEstateManagerImportExport::getXMLItemValue($house,'broker');
		    //get image_link
		    $house_class->image_link = mosRealEstateManagerImportExport::getXMLItemValue($house,'image_link');
		    //get listing_status
		    $house_class->listing_status = mosRealEstateManagerImportExport::getXMLItemValue($house,'listing_status');


		    //get price_type
		    $house_class->price_type = mosRealEstateManagerImportExport::getXMLItemValue($house,'price_type');
		    //get property_type
		    $house_class->property_type = mosRealEstateManagerImportExport::getXMLItemValue($house,'property_type');
		    //get provider_class
		    $house_class->provider_class = mosRealEstateManagerImportExport::getXMLItemValue($house,'provider_class');
		    //get year
		    $house_class->year = mosRealEstateManagerImportExport::getXMLItemValue($house,'year');
//getting optional fields
		    //get agent
		    $house_class->agent = mosRealEstateManagerImportExport::getXMLItemValue($house,'agent');
		    //get area
		    $house_class->area = mosRealEstateManagerImportExport::getXMLItemValue($house,'area');
		    //get expiration_date
		    $house_class->expiration_date = mosRealEstateManagerImportExport::getXMLItemValue($house,'expiration_date');
		    //get feature
		    $house_class->feature = mosRealEstateManagerImportExport::getXMLItemValue($house,'feature');
		    //get hoa_dues
		    $house_class->hoa_dues = mosRealEstateManagerImportExport::getXMLItemValue($house,'hoa_dues');
		    //get lot_size
		    $house_class->lot_size = mosRealEstateManagerImportExport::getXMLItemValue($house,'lot_size');
		    //get model
		    $house_class->model = mosRealEstateManagerImportExport::getXMLItemValue($house,'model');
		    //get property_taxes
		    $house_class->property_taxes = mosRealEstateManagerImportExport::getXMLItemValue($house,'property_taxes');
		    //get school
		    $house_class->school = mosRealEstateManagerImportExport::getXMLItemValue($house,'school');
		    //get school_district
		    $house_class->school_district = mosRealEstateManagerImportExport::getXMLItemValue($house,'school_district');
		    //get style
		    $house_class->style = mosRealEstateManagerImportExport::getXMLItemValue($house,'style');
		    //get zoning
		    $house_class->zoning = mosRealEstateManagerImportExport::getXMLItemValue($house,'zoning');

		    //get hits
		    $house_class->hits = mosRealEstateManagerImportExport::getXMLItemValue($house,'hits');
		    //get date
		    $house_class->date = mosRealEstateManagerImportExport::getXMLItemValue($house,'date');
          //get published
        $house_class->published = mosRealEstateManagerImportExport::getXMLItemValue($house,'published');


        //get category
        if($catid === null){
          $new_category = null;
          $new_category->old_id = mosRealEstateManagerImportExport::getXMLItemValue($house,'catid');
  
          $new_category = mosRealEstateManagerImportExport::findCategory($new_categories, $new_category ) ;
  
          //set category
          $house_class->catid = $new_category->id;
        } else {
          $new_category = new mosCategory($database);
          $new_category->Load($catid);
  
          $house_class->catid = $catid;
        }

	            //for output rezult in table
	            $tmp[0] = $i;
	            $tmp[1] = $house_id;
	            $tmp[2] = $house_hlocation;
	            $tmp[3] = $house_htitle;
	            $tmp[4] = $house_class->broker;


//ПРоверяется наличие дома с указанным id и 
		    if (!$house_class->check() || !$house_class->store()) {
		       $tmp[5] =  $house_class->getError();
		    } else { $tmp[5] =  "OK"; }

		    $house_class->checkin();
		    $house_class->updateOrder( "catid='$house_class->catid'" );
		    $retVal[$i] = $tmp;


        //get Reviews
        if( $tmp[5] =  "OK" && mosRealEstateManagerImportExport::getXMLItemValue($house,'reviews') != "" ){
          $review_list = $house->getElementsByTagname('review'); 
          for ($j = 0; $j < $review_list->length; $j++) {

              $review = $review_list->item($j);
    
              //get for review - user_name
              $review_user_name = mosRealEstateManagerImportExport::getXMLItemValue($review,'user_name');
              //get for review - user_email
              $review_user_email = mosRealEstateManagerImportExport::getXMLItemValue($review,'user_email');
              //get for review - date
              $review_date = mosRealEstateManagerImportExport::getXMLItemValue($review,'date');
              //get for review - rating
              $review_rating = mosRealEstateManagerImportExport::getXMLItemValue($review,'rating');
              //get for review - title
              $review_title = mosRealEstateManagerImportExport::getXMLItemValue($review,'title');
              //get for review - comment
              $review_comment = mosRealEstateManagerImportExport::getXMLItemValue($review,'comment');
    
              //insert data in table #__rem_review
              $database->setQuery("INSERT INTO #__rem_review".
                "\n (fk_houseid, user_name,user_email, date, rating, title, comment)".
                "\n VALUES ".
                "\n (".$house_class->id.", '".$review_user_name."', '".$review_user_email.
                "', '".$review_date."',".$review_rating.",'".$review_title."', '".$review_comment."');");
              $database->query();
    
          } //end for(...) - REVIEW
        } //end if(...) - REVIEW


        //get rents
        if( $tmp[5] =  "OK" && mosRealEstateManagerImportExport::getXMLItemValue($house,'rents') != "" ){
          $rent_list = $house->getElementsByTagname('rent'); 
          for ($j = 0; $j < $rent_list->length; $j++) {

              $rent = $rent_list->item($j);

              $help = new mosRealEstateManager_rent($database);

              //get for rent - rent_from
              $help->rent_from = mosRealEstateManagerImportExport::getXMLItemValue($rent,'rent_from');
              //get for rent - rent_until
              $help->rent_until = mosRealEstateManagerImportExport::getXMLItemValue($rent,'rent_until');
              //get for rent - rent_return
              $help->rent_return = mosRealEstateManagerImportExport::getXMLItemValue($rent,'rent_return');
              //get for rent - user_name
              $help->user_name = mosRealEstateManagerImportExport::getXMLItemValue($rent,'user_name');
              //get for rent - user_email
              $help->user_email = mosRealEstateManagerImportExport::getXMLItemValue($rent,'user_email');
              //get for rent - user_mailing
              $help->user_mailing = mosRealEstateManagerImportExport::getXMLItemValue($rent,'user_mailing');
    
              //insert data in table #__rem_rent
              if (!$help->check() || !$help->store()) {    
                $tmp[5] =  $help->getError();
              } else {
      
                $house_class->fk_rentid = $help->id;
                if (!$house_class->check() || !$house_class->store()) {    
                  $tmp[5] =  $house_class->getError();
                } else { $tmp[5] =  "OK"; }
              }
    
          } //end for(...) - rent
        } //end if(...) - rent

        //get rentrequests
        if( $tmp[5] =  "OK" && mosRealEstateManagerImportExport::getXMLItemValue($house,'rentrequests') != "" ){
          $rentrequests_list = $house->getElementsByTagname('rentrequest'); 
          for ($j = 0; $j < $rentrequests_list->length; $j++) {

              $rentrequest = $rentrequests_list->item($j);
    
              //get for rentrequest - rent_from
              $rr_rent_from = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'rent_from');
              //get for rentrequest - rent_until
              $rr_rent_until = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'rent_until');
              //get for rentrequest - rent_return
              $rr_rent_request = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'rent_request');
              //get for rentrequest - user_name
              $rr_user_name = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'user_name');
              //get for rentrequest - user_email
              $rr_user_email = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'user_email');
              //get for rentrequest - user_mailing
              $rr_user_mailing = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'user_mailing');
              //get for rentrequest - status
              $rr_status = mosRealEstateManagerImportExport::getXMLItemValue($rentrequest,'status');
    
              //insert data in table #__rem_rent_request
              $database->setQuery("INSERT INTO #__rem_rent_request ".
                "\n (fk_houseid, rent_from,rent_until, rent_request, user_name, user_email, user_mailing,status)".
                "\n VALUES ".
                "\n (".$house_class->id.", '".$rr_rent_from."', '".$rr_rent_until.
                "', '".$rr_rent_request."','".$rr_user_name."','".$rr_user_email."', '".$rr_user_mailing.
                "', '".$rr_status."');");
              $database->query();
    
          } //end for(...) - rentrequest
        } //end if(...) - rentrequest

        //get buyingrequests
        if( $tmp[5] =  "OK" && mosRealEstateManagerImportExport::getXMLItemValue($house,'buyingrequests') != "" ){
          $buyingrequests_list = $house->getElementsByTagname('buyingrequest'); 
          for ($j = 0; $j < $buyingrequests_list->length; $j++) {

              $buyingrequest = $buyingrequests_list->item($j);
    
                  //get for $buyingrequest - buying_request
              $br_buying_request = mosRealEstateManagerImportExport::getXMLItemValue($buyingrequest,'buying_request');
              //get for $buyingrequest - customer_name
              $br_customer_name = mosRealEstateManagerImportExport::getXMLItemValue($buyingrequest,'customer_name');
              //get for $buyingrequest - customer_email
              $br_customer_email = mosRealEstateManagerImportExport::getXMLItemValue($buyingrequest,'customer_email');
              //get for $buyingrequest - customer_phone
              $br_customer_phone = mosRealEstateManagerImportExport::getXMLItemValue($buyingrequest,'customer_phone');
              //get for $buyingrequest - status
              $br_status = mosRealEstateManagerImportExport::getXMLItemValue($buyingrequest,'status');
    
              //insert data in table #__rem_buying_request
              $database->setQuery("INSERT INTO #__rem_buying_request ".
                "\n (fk_houseid, buying_request, customer_name, customer_email, customer_phone,status)".
                "\n VALUES ".
                "\n (".$house_class->id.
                ", '".$br_buying_request."','".$br_customer_name."','".$br_customer_email."', '".$br_customer_phone.
                "', '".$br_status."');");
              $database->query();
    
          } //end for(...) - $buyingrequest
        } //end if(...) - $buyingrequest


        //get images
        if( $tmp[5] =  "OK" && mosRealEstateManagerImportExport::getXMLItemValue($house,'images') != "" ){
          $images_list = $house->getElementsByTagname('image'); 
          for ($j = 0; $j < $images_list->length; $j++) {

              $image = $images_list->item($j);
    
              //get for $image - thumbnail_img
              $image_thumbnail_img = mosRealEstateManagerImportExport::getXMLItemValue($image,'thumbnail_img');
              //get for $image - main_img
              $image_main_img = mosRealEstateManagerImportExport::getXMLItemValue($image,'main_img');
    
              //insert data in table #__rem_photos
              $database->setQuery("INSERT INTO #__rem_photos " .
                "\n (fk_houseid, thumbnail_img, main_img, as_featured_image, need_login)".
                "\n VALUES ".
                "\n (".$house_class->id.
                ", '".$image_thumbnail_img."','".$image_main_img."', 0, 0);");
              $database->query();
    
          } //end for(...) - images
        } //end if(...) - images


		}//end for(...) - house

		return $retVal;
	}
//***************************************************************************************************
//***********************   end add for import XML format   *****************************************
//***************************************************************************************************

	function exportHousesXML($houses, $all){
		global $mosConfig_live_site, $mosConfig_absolute_path, $realestatemanager_configuration, $database;

// 		$xmlDoc =& new DOMIT_Document();	
// 		$xmlDoc->appendChild($xmlDoc->createProcessingInstruction('xml', "version=\"1.0\" encoding=\"iso-8859-2\"")); 
// 
// 		//create and append list element 
// 		$xmlDoc->appendChild($xmlDoc->createElement("houses")); 
// 	    
// 		foreach ($houses as $house) {
// 			$xmlDoc->documentElement->appendChild($house->toXML( $xmlDoc, $all));
// 		}	
// 		
// 		return $xmlDoc->toNormalizedString ();		

    $xmlDoc = new DOMIT_Document(); 
    $strXmlDoc = "";
    //$xmlDoc->appendChild($xmlDoc->createProcessingInstruction('xml', "version=\"1.0\" encoding=\"iso-8859-2\"")); 
    $strXmlDoc .= "<?xml version='1.0' encoding='iso-8859-2'?>\n";
 
    //$istaller_data_dom =  $xmlDoc->createElement("istaller_data");
    $strXmlDoc .= "<houses_data>\n";
    if($all){

      //create and append list element
      $categories_dom =   $xmlDoc->createElement("categories");
      $strXmlDoc .= "<categories>\n";

      //$xmlDoc->appendChild($categories_dom);

      $database->setQuery("SELECT name, title,section, id, parent_id, published FROM #__categories ".
                "WHERE section='com_realestatemanager' order by parent_id ; " );
      $categories = $database->loadObjectList();   

      foreach($categories as $category){
      //add category
        $category_dom =  $xmlDoc->createElement("category");
    
        $category_id =  $xmlDoc->createElement("category_id");
        $category_id->appendChild($xmlDoc->createTextNode($category->id));
        $category_dom->appendChild( $category_id );

        $category_parent_id =  $xmlDoc->createElement("category_parent_id");
        $category_parent_id->appendChild($xmlDoc->createTextNode($category->parent_id));
        $category_dom->appendChild( $category_parent_id );
    
        $category_name =  $xmlDoc->createElement("category_name");
        $category_name->appendChild($xmlDoc->createCDATASection($category->name));
        $category_dom->appendChild( $category_name );
    
        $category_title =  $xmlDoc->createElement("category_title");
        $category_title->appendChild($xmlDoc->createCDATASection($category->title));
        $category_dom->appendChild( $category_title );
    
        $category_section =  $xmlDoc->createElement("category_section");
        $category_section->appendChild($xmlDoc->createTextNode($category->section));
        $category_dom->appendChild( $category_section );
    
        $category_published =  $xmlDoc->createElement("category_published");
        $category_published->appendChild($xmlDoc->createTextNode($category->published));
        $category_dom->appendChild( $category_published );
  
        //$categories_dom->appendChild( $category_dom);
        $strXmlDoc .= $category_dom->toNormalizedString();
      }
      //create and append list element
      //$istaller_data_dom->appendChild($categories_dom);
      $strXmlDoc .= "</categories>\n";
     
     }

    //create and append list element
    $strXmlDoc .= "<houses_list>\n";
    foreach ($houses as $house) {
      $strXmlDoc .= $house->toXML2($all);
    }
    $strXmlDoc .= "</houses_list>\n";

    $strXmlDoc .= "</houses_data>";

    return $strXmlDoc;    

	}
	
	function storeExportFile($data, $type){
      global $mosConfig_live_site, $mosConfig_absolute_path, $realestatemanager_configuration;
      $fileName = "realestatemanager_" . date("Ymd_His");
      $fileBase = "/administrator/components/com_realestatemanager/exports/";
      
      //write the xml file
      $fp = fopen($mosConfig_absolute_path . $fileBase . $fileName . ".xml" , "w", 0); #open for writing
  		
      fwrite($fp, $data); #write all of $data to our opened file
  		fclose($fp); #close the file
  		
  		
  		$InformationArray = array();
  		$InformationArray['xml_file'] = $fileName . '.xml';
  		$InformationArray['log_file'] = $fileName . '.log';
  		$InformationArray['fileBase'] = "file://" . getcwd (). "/components/com_realestatemanager/exports/";
  		$InformationArray['urlBase'] = $mosConfig_live_site . $fileBase;
  		$InformationArray['out_file'] = $InformationArray['xml_file'];
  		$InformationArray['error'] = null;
  		
  		switch($type){
  			case 'csv':
	  			$InformationArray['xslt_file'] = 'csv.xsl';
	  			$InformationArray['out_file'] = $fileName . '.csv';
	  			mosRealEstateManagerImportExport :: transformPHP4($InformationArray);
  			break;
  			
  			default:
  			break;
  		}

		return $InformationArray;
	}

	
	function transformPHP4(&$InformationArray){
			// create the XSLT processor^M
			$xh = xslt_create() or die("Could not create XSLT processor");
			
            
			// Process the document
			$result = xslt_process($xh, $InformationArray['fileBase'].$InformationArray['xml_file'],
         $InformationArray['fileBase'].$InformationArray['xslt_file'], 
         $InformationArray['fileBase'].$InformationArray['out_file']);
			
			if (!$result)
      {                         
			  // Something croaked. Show the error
        $InformationArray['error'] = "Cannot process XSLT document: " . /*xslt_errno($xh) .*/ " " /*. xslt_error($xh)*/;
			} 
			
			// Destroy the XSLT processor
			xslt_free($xh);

	}
//////////  MY  ///////////////////////////////////////////////

function remove_info()
{
  global $database;
  $database->setQuery('truncate #__rem_houses');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery("delete from #__categories where section='com_realestatemanager'");
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery('truncate #__rem_review');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery('truncate #__rem_photos');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery('truncate #__rem_rent');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery('truncate #__rem_rent_request');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  $database->setQuery('truncate #__rem_buying_request');
  $database->query(); 
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return $database->stderr();
  }
  return "";

}

}
?>