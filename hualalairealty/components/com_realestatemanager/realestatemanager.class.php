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


require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.rent.php");
require_once ($mosConfig_absolute_path."/components/com_realestatemanager/realestatemanager.class.review.php");


/**
* House database table class
*/
class mosRealEstateManager extends mosDBTable {

//keys
	/** @var int Primary key */
	var $id=null;
	/** @var int */
	var $houseid=null;
	/** @var int */
	var $catid=null;
	/** @var int */
	var $sid=null;
	/** @var int */
	var $fk_rentid=null;

//Required fields
	/** @var varchar(250) */
	var $description=null;
	/** @var varchar(250) */
	var $link=null;
	/** @var varchar(45) */
	var $listing_type=null;//(for rent or for sale)	
	/** @var varchar(14) */
	var $price=null;
	/** @var varchar(14) */
	var $price_text=null;
	/** @var varchar(200) */
	var $htitle=null;       //beautiful rooms and views
	/** @var varchar(200) */
	var $metaTag=null;       //beautiful rooms and views
	/** @var varchar(200) */
	var $metaDesc=null;       //beautiful rooms and views

//Address fields
	/** @var varchar(100) */
	var $hlocation=null;    //address of house
	/** @var varchar(100) */
	var $streetName=null;    //street name of house
	/** @var varchar(100) */
	var $addNumber=null;    //address number of house
	/** @var varchar(20) */
	var $hlatitude=null;    //latitude of house
	/** @var varchar(20) */
	var $hlongitude=null;    //longitude of house
	/** @var tinyint(4) */
	var $map_zoom=1;    //google map zoom

//Recommended fields
	/** @var int */
	var $bathrooms=null;
	/** @var int */
	var $bedrooms=null;
	/** @var varchar(100) */
	var $additional_room=null;
	/** @var varchar(100) */
	var $car=null;
	/** @var varchar(100) */
	var $broker=null;
	/** @var varchar(200) */
	var $image_link=null;
	/** @var varchar(45) */
	var $listing_status=null;
	/** @var varchar(20) */
//	var $mls=null;
	/** @var varchar(20) */
//	var $mls_name=null;
	/** @var varchar(45) */
	var $price_type=null;    //negotiable or starting
	/** @var varchar(45) */
	var $property_type=null; //apartmemt or land
	/** @var varchar(45) */
	var $provider_class=null; //agent, aggregator, broker, franchisor
	/** @var varchar(4) */
	var $year=null;

//Optional fields
	/** @var varchar(45) */
	var $agent=null;
	/** @var int */
	var $area=null;
	/** @var int */
	var $interior_area=null;	
	/** @var date */
	var $lanai=null;
	/** @var date */
	var $garage=null;
	/** @var date */
	var $uroofarea=null;
	/** @var date */
	var $envelope=null;
	/** @var date */
	var $torsqfield=null;
	/** @var date */
	var $expiration_date=null; //конечный срок действия
	/** @var varchar(100) */
	var $feature=null; //особенность удобства	
	/** @var varchar(100) */
	var $hoa_dues=null; 
	/** @var int */
	var $lot_size=null;
	/** @var varchar(50) */
	var $model=null;
	/** @var FLOAT(2,2) */
	var $property_taxes=null;
	/** @var varchar(45) */
	var $school=null;
	/** @var varchar(45) */
	var $school_district=null;
	/** @var varchar(45) */
	var $style=null;
	/** @var varchar(45) */
	var $zoning=null; //agricultural, commercial, industrial,

	
	/** @var boolean */
	var $checked_out=null;
	/** @var time */
	var $checked_out_time=null;	
	/** @var datetime */
	var $date=null;
	/** @var int */
	var $published=null;
	/** @var int */
	var $hits=null;
	/** @var varchar(200) */
	var $edok_link=null;
	/** @var varchar(200) */
	var $virtual_link=null;
	/** @var varchar(200) */
	var $brochure_link=null;	
	var $property_video_url=null;	
	/** @var varchar(200) */
	var $floor_link=null;
        var $features_list_link=null;
	var $plot_map_link=null;
	var $property_video_image_link=null;
	/** @var varchar(200) */
	var $lot_link=null;
	
	/** @var varchar(200) */
	var $site_plan=null;
	/** @var varchar(200) */
	var $blueprints=null;
	/** @var varchar(200) */
	var $schematics=null;
	

	//** @var int */
	//var $rating=null;
	/*/** @var int */
	var $ordering=null;
	//** @var int */
	//var $archived=null;
	//** @var varchar(200) */
	//var $imageURL=null;
	//** @var varchar(250) */
	//var $URL=null;
	
	//** @var varchar(300) */
	//var $comment=null;
	//** @var int */
	//var $informationFrom=null;









	/**
	* @param database - A database connector object
	*/
	function mosRealEstateManager( &$db ) {
		$this->mosDBTable( '#__rem_houses', 'id', $db );
	}
	
	// overloaded check function
	function check() {

		global $realestatemanager_configuration;
		
		// check for existing houseid
		$this->_db->setQuery( "SELECT id FROM #__rem_houses "
			. "\nWHERE houseid='$this->houseid'");						
		$xid = intval( $this->_db->loadResult() );
		if ($xid && $xid != intval( $this->id )) {
			$this->_error = _REALESTATE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_HOUSEID;
			return false;
		}


		return true;
	}
	
		
	function getReviews(){
		$this->_db->setQuery("SELECT id FROM #__rem_review \n".
							"WHERE fk_houseid='$this->id' ORDER BY id");
		$tmp = $this->_db->loadResultArray();		
		$retVal = array();		
		for($i = 0, $j = count($tmp); $i < $j; $i++ ){
			$help = new mosRealEstateManager_review($this->_db);
			$help->load(intval($tmp[$i]));
			$retVal[$i] = $help;
		}		
		return $retVal;	
	}
	
	function getRent(){
		$rent = null;
		if($this->fk_rentid != null && $this->fk_rentid != 0){
			$rent =  new mosRealEstateManager_rent($this->_db);
			// load the row from the db table
			$rent->load(intval($this->fk_rentid));
		}
		return $rent;
	}
	
	function getAllRents($exclusion=""){
		$this->_db->setQuery("SELECT id FROM #__rem_rent \n".
							"WHERE fk_houseid='$this->id' " . $exclusion . " ORDER BY id");
		$tmp = $this->_db->loadResultArray();		
		$retVal = array();		
		for($i = 0, $j = count($tmp); $i < $j; $i++ ){
			$help = new mosRealEstateManager_rent($this->_db);
			$help->load(intval($tmp[$i]));
			$retVal[$i] = $help;
		}		
		return $retVal;	
	}

	function getAllRentRequests($exclusion=""){
		$this->_db->setQuery("SELECT id FROM #__rem_rent_request \n".
							"WHERE fk_houseid='$this->id'" . $exclusion . " ORDER BY id");
		$tmp = $this->_db->loadResultArray();		
		$retVal = array();		
		for($i = 0, $j = count($tmp); $i < $j; $i++ ){
			$help = new mosRealEstateManager_rent_request($this->_db);
			$help->load(intval($tmp[$i]));
			$retVal[$i] = $help;
		}		
		return $retVal;	
	}

	function getAllBuyingRequests($exclusion=""){
		$this->_db->setQuery("SELECT id FROM #__rem_buying_request \n".
							"WHERE fk_houseid='$this->id'" . $exclusion . " ORDER BY id");
		$tmp = $this->_db->loadResultArray();		
		$retVal = array();		
		for($i = 0, $j = count($tmp); $i < $j; $i++ ){
			$help = new mosRealEstateManager_buying_request($this->_db);
			$help->load(intval($tmp[$i]));
			$retVal[$i] = $help;
		}		
		return $retVal;	
	}

  function getAllImages($exclusion=""){
    $this->_db->setQuery("SELECT thumbnail_img, main_img FROM #__rem_photos \n".
              "WHERE fk_houseid='$this->id'" . $exclusion . " ORDER BY id");
    $retVal = $this->_db->loadObjectList();   
    return $retVal; 
  }

	function toXML(& $xmlDoc, $all){
		
		//create and append name element 
		$retVal = & $xmlDoc->createElement("house");
		
		$houseid = & $xmlDoc->createElement("houseid");
		$houseid->appendChild($xmlDoc->createTextNode($this->houseid));
		$retVal->appendChild( $houseid);
		
    $catid = & $xmlDoc->createElement("catid");
    $catid->appendChild($xmlDoc->createTextNode($this->catid));
    $retVal->appendChild( $catid);

    $sid = & $xmlDoc->createElement("sid");
    $sid->appendChild($xmlDoc->createTextNode($this->sid));
    $retVal->appendChild( $sid);
		
		//
		$description = & $xmlDoc->createElement("description");
		$description->appendChild($xmlDoc->createCDATASection($this->description));
		$retVal->appendChild( $description);

		$link = & $xmlDoc->createElement("link");
		$link->appendChild($xmlDoc->createTextNode($this->link));
		$retVal->appendChild( $link);

		$listing_type = & $xmlDoc->createElement("listing_type");
		$listing_type->appendChild($xmlDoc->createCDATASection($this->listing_type));
		$retVal->appendChild( $listing_type);

		$price = & $xmlDoc->createElement("price");
		$price->appendChild($xmlDoc->createTextNode($this->price));
		$retVal->appendChild( $price);

		$htitle = & $xmlDoc->createElement("htitle");
		$htitle->appendChild($xmlDoc->createCDATASection($this->htitle));
		$retVal->appendChild( $htitle);
		
		$hlocation = & $xmlDoc->createElement("hlocation");
		$hlocation->appendChild($xmlDoc->createCDATASection($this->hlocation));
		$retVal->appendChild( $hlocation);

		$hlatitude = & $xmlDoc->createElement("hlatitude");
		$hlatitude->appendChild($xmlDoc->createTextNode($this->hlatitude));
		$retVal->appendChild( $hlatitude);

		$hlongitude = & $xmlDoc->createElement("hlongitude");
		$hlongitude->appendChild($xmlDoc->createTextNode($this->hlongitude));
		$retVal->appendChild( $hlongitude);

		$map_zoom = & $xmlDoc->createElement("map_zoom");
		$map_zoom->appendChild($xmlDoc->createTextNode($this->map_zoom));
		$retVal->appendChild( $map_zoom);
		
//recommended fields
		$bathrooms = & $xmlDoc->createElement("bathrooms");
		$bathrooms->appendChild($xmlDoc->createTextNode($this->bathrooms));
		$retVal->appendChild( $bathrooms);

		$bedrooms = & $xmlDoc->createElement("bedrooms");
		$bedrooms->appendChild($xmlDoc->createTextNode($this->bedrooms));
		$retVal->appendChild( $bedrooms);
		
		$broker = & $xmlDoc->createElement("broker");
		$broker->appendChild($xmlDoc->createCDATASection($this->broker));
		$broker->appendChild( $broker);

		$image_link = & $xmlDoc->createElement("image_link");
		$image_link->appendChild($xmlDoc->createCDATASection($this->image_link));
		$retVal->appendChild( $image_link);

		$listing_status = & $xmlDoc->createElement("listing_status");
		$listing_status->appendChild($xmlDoc->createTextNode($this->listing_status));
		$retVal->appendChild( $listing_status);

		$price_type = & $xmlDoc->createElement("price_type");
		$price_type->appendChild($xmlDoc->createTextNode($this->price_type));
		$retVal->appendChild( $price_type);

		$property_type = & $xmlDoc->createElement("property_type");
		$property_type->appendChild($xmlDoc->createTextNode($this->property_type));
		$retVal->appendChild( $property_type);

		$provider_class = & $xmlDoc->createElement("provider_class");
		$provider_class->appendChild($xmlDoc->createTextNode($this->provider_class));
		$retVal->appendChild( $provider_class);

		$year = & $xmlDoc->createElement("year");
		$year->appendChild($xmlDoc->createTextNode($this->year));
		$year->appendChild( $year);

//optional fields
		$agent = & $xmlDoc->createElement("agent");
		$agent->appendChild($xmlDoc->createCDATASection($this->agent));
		$retVal->appendChild( $agent);

		$area = & $xmlDoc->createElement("area");
		$area->appendChild($xmlDoc->createCDATASection($this->area));
		$retVal->appendChild( $area);

		$expiration_date = & $xmlDoc->createElement("expiration_date");
		$expiration_date->appendChild($xmlDoc->createTextNode($this->expiration_date));
		$retVal->appendChild( $expiration_date);

		$feature = & $xmlDoc->createElement("feature");
		$feature->appendChild($xmlDoc->createCDATASection($this->feature));
		$retVal->appendChild( $feature);

		$hoa_dues = & $xmlDoc->createElement("hoa_dues");
		$hoa_dues->appendChild($xmlDoc->createCDATASection($this->hoa_dues));
		$retVal->appendChild( $hoa_dues);

		$lot_size = & $xmlDoc->createElement("lot_size");
		$lot_size->appendChild($xmlDoc->createCDATASection($this->lot_size));
		$retVal->appendChild( $lot_size);

		$model = & $xmlDoc->createElement("model");
		$model->appendChild($xmlDoc->createCDATASection($this->model));
		$retVal->appendChild( $model);

		$property_taxes = & $xmlDoc->createElement("property_taxes");
		$property_taxes->appendChild($xmlDoc->createTextNode($this->property_taxes));
		$retVal->appendChild( $property_taxes);

		$school = & $xmlDoc->createElement("school");
		$school->appendChild($xmlDoc->createCDATASection($this->school));
		$retVal->appendChild( $school);

		$school_district = & $xmlDoc->createElement("school_district");
		$school_district->appendChild($xmlDoc->createCDATASection($this->school_district));
		$retVal->appendChild( $school_district);

		$style = & $xmlDoc->createElement("style");
		$style->appendChild($xmlDoc->createCDATASection($this->style));
		$retVal->appendChild( $style);

		$zoning = & $xmlDoc->createElement("zoning");
		$zoning->appendChild($xmlDoc->createCDATASection($this->zoning));
		$zoning->appendChild( $zoning);

		$hits = & $xmlDoc->createElement("hits");
		$hits->appendChild($xmlDoc->createTextNode($this->hits));
		$retVal->appendChild( $hits);

		$date = & $xmlDoc->createElement("date");
		$date->appendChild($xmlDoc->createTextNode($this->date));
		$retVal->appendChild( $date);
	
    $published = & $xmlDoc->createElement("published");
    $published->appendChild($xmlDoc->createTextNode($this->published));
    $retVal->appendChild( $published);
	
		if($all){
			$rents_data = $this->getRent();
			$exclusion = "";
			
			$rents = & $xmlDoc->createElement("rents");
			$rents_data = $this->getAllRents($exclusion);;
			
			foreach($rents_data as $rent_data){
				$rents->appendChild($rent_data->toXML( $xmlDoc));
			}
			$retVal->appendChild( $rents);
		
			$rentrequests = & $xmlDoc->createElement("rentrequests");
			$rentrequests_data = $this->getAllRentRequests($exclusion);
			
      foreach($rentrequests_data as $rentrequest_data){
				$rentrequests->appendChild($rentrequest_data->toXML( $xmlDoc));
			}
			$retVal->appendChild( $rentrequests);

			$buyingrequests = & $xmlDoc->createElement("buyingrequests");
			$buyingrequests_data = $this->getAllBuyingRequests($exclusion);
			foreach($buyingrequests_data as $buyingrequest_data){
				$buyingrequests->appendChild($buyingrequest_data->toXML( $xmlDoc));
			}
			$retVal->appendChild( $buyingrequests);

			$reviews = & $xmlDoc->createElement("reviews");
			$reviews_data = $this->getReviews();
			foreach($reviews_data as $review_data){
				$reviews->appendChild($review_data->toXML( $xmlDoc));
			}
			$retVal->appendChild( $reviews);
			
      $images = & $xmlDoc->createElement("images");
      $images_data = $this->getAllImages();
      foreach($images_data as $image_data){

        $image = & $xmlDoc->createElement("image");

        $image_thumbnail_img = & $xmlDoc->createElement("thumbnail_img");
        $image_thumbnail_img->appendChild($xmlDoc->createTextNode($image_data->thumbnail_img));
        $image->appendChild( $image_thumbnail_img);

        $image_main_img = & $xmlDoc->createElement("main_img");
        $image_main_img->appendChild($xmlDoc->createTextNode($image_data->main_img));
        $image->appendChild($image_main_img);

        $images->appendChild( $image);
      }
      $retVal->appendChild( $images);

		}
		
		return $retVal;
	}

	function toXML2($all){


		$retVal = "<house>\n";

		$retVal .= "<houseid>" . $this->houseid . "</houseid>\n";
    $retVal .= "<catid>" . $this->catid . "</catid>\n";
    $retVal .= "<sid>" . $this->sid . "</sid>\n";
    $retVal .= "<description><![CDATA[" . $this->description . "]]></description>\n";
    $retVal .= "<link><![CDATA[" . $this->link . "]]></link>\n";
    $retVal .= "<listing_type>" . $this->listing_type . "</listing_type>\n";
    $retVal .= "<price>" . $this->price . "</price>\n";
    $retVal .= "<htitle><![CDATA[" . $this->htitle . "]]></htitle>\n";
    $retVal .= "<hlocation><![CDATA[" . $this->hlocation . "]]></hlocation>\n";
    $retVal .= "<hlatitude>" . $this->hlatitude . "</hlatitude>\n";
    $retVal .= "<hlongitude>" . $this->hlongitude . "</hlongitude>\n";
    $retVal .= "<map_zoom>" . $this->map_zoom . "</map_zoom>\n";
    $retVal .= "<bathrooms>" . $this->bathrooms . "</bathrooms>\n";
    $retVal .= "<bedrooms>" . $this->bedrooms . "</bedrooms>\n";
    $retVal .= "<broker>" . $this->broker . "</broker>\n";
    $retVal .= "<image_link><![CDATA[" . $this->image_link . "]]></image_link>\n";
    $retVal .= "<listing_status>" . $this->listing_status . "</listing_status>\n";
    $retVal .= "<price_type>" . $this->price_type . "</price_type>\n";
    $retVal .= "<property_type>" . $this->property_type . "</property_type>\n";
    $retVal .= "<provider_class>" . $this->provider_class . "</provider_class>\n";
    $retVal .= "<year>" . $this->year . "</year>\n";
    $retVal .= "<agent><![CDATA[" . $this->agent . "]]></agent>\n";
    $retVal .= "<area><![CDATA[" . $this->area . "]]></area>\n";
    $retVal .= "<expiration_date>" . $this->expiration_date . "</expiration_date>\n";
    $retVal .= "<feature><![CDATA[" . $this->feature . "]]></feature>\n";
    $retVal .= "<hoa_dues><![CDATA[" . $this->hoa_dues . "]]></hoa_dues>\n";
    $retVal .= "<lot_size>" . $this->lot_size . "</lot_size>\n";
    $retVal .= "<model><![CDATA[" . $this->model . "]]></model>\n";
    $retVal .= "<property_taxes>" . $this->property_taxes . "</property_taxes>\n";
    $retVal .= "<school><![CDATA[" . $this->school . "]]></school>\n";
    $retVal .= "<school_district><![CDATA[" . $this->school_district . "]]></school_district>\n";
    $retVal .= "<style><![CDATA[" . $this->style . "]]></style>\n";
    $retVal .= "<zoning><![CDATA[" . $this->zoning . "]]></zoning>\n";
    $retVal .= "<hits>" . $this->hits . "</hits>\n";
    $retVal .= "<date>" . $this->date . "</date>\n";
    $retVal .= "<published>" . $this->published . "</published>\n";

    if($all){

      $exclusion = "";
      $retVal .= "<rents>\n";
        $rents = $this->getAllRents($exclusion);
        foreach ($rents as $rent){
          $retVal .= $rent->toXML2(); 
        }
      $retVal .= "</rents>\n";

      $retVal .= "<rentrequests>\n";
        $rentrequests = $this->getAllRentRequests($exclusion);
        foreach ($rentrequests as $rentrequest){
          $retVal .= $rentrequest->toXML2(); 
        }
      $retVal .= "</rentrequests>\n";
    
      $retVal .= "<buyingrequests>\n";
        $buyingrequests = $this->getAllBuyingRequests($exclusion);
        foreach ($buyingrequests as $buyingrequest){
          $retVal .= $buyingrequest->toXML2(); 
        }
      $retVal .= "</buyingrequests>\n";

      $retVal .= "<reviews>\n";
        $reviews = $this->getReviews($exclusion);
        foreach ($reviews as $review){
          $retVal .= $review->toXML2(); 
        }
      $retVal .= "</reviews>\n";

      $retVal .= "<images>\n";
      $images_data = $this->getAllImages();
      foreach($images_data as $image_data){
        $retVal .= "<image>\n";
          $retVal .= "<thumbnail_img><![CDATA[" . $image_data->thumbnail_img . "]]></thumbnail_img>\n";
          $retVal .= "<main_img><![CDATA[" . $image_data->main_img . "]]></main_img>\n";
        $retVal .= "</image>\n";
      }
      $retVal .= "</images>\n";

      
    }
    $retVal .= "</house>\n";

    return $retVal;
	
  }

}
?>