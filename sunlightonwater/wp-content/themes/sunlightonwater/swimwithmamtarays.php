<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
/*
/*
Template Name:Swim With Manta Rays Page
*/

get_header();
?>
<div class="innercontainer">
<script type="text/javascript">
//<![CDATA[
var fv = '&file=./MantaRayWebmovieSOW-11.flv&' + 'image=_library/media/manta-preview.jpg';
var so = new SWFObject('_library/media/flvplayer.swf','mpl','330','243','9');
so.addParam('allowscriptaccess','always');
so.addParam('allowfullscreen','true');
so.addParam('flashvars',fv);
so.write("player1");
//]]>
</script>
<!--<div class="caption">Don't forget to watch our Manta Ray video</div>-->

<script type="text/javascript">
    // Activity group settings
    var group1 = {
      supplierid: 391,
      activityids: [ 2051, 7028, 7029, 7030],
      guesttypeids: [ 965, 1337,1662 ],
      activityprices: {
        2051: { 965: 92.00, 1337: 75.00, 1662:40.00 },
        7028: { 965: 92.00, 1337: 75.00, 1662:40.00 },
        7029: { 965: 92.00, 1337: 75.00,1662:40.00 },
        7030: { 965: 92.00, 1337: 75.00, 1662:40.00 }
      },
      activitydescriptions: {
        2051: 'Check-in 5:00 pm',
        7028: 'Check-in 5:15 pm',
        7029: 'Check-in 5:30 pm',
        7030: 'Check-in 5:45 pm'
      },
      datecontrolid: 'date_g1',
      pricecontrolid: 'price_g1',
      guesttypecontrolids: {
        965: 'guests_g1_t965',
        1337: 'guests_g1_t1337',
 1662: 'guests_g1_t1662'
      },
      cancellationpolicycontrolid: 'cancellationpolicy',
      goldcardnumbercontrolid: 'goldcardnumber',
      promotionalcodecontrolid: 'promotionalcode',
	  activityid: null
    };

    function showCalendar(group) {
      var minavailability = { guests: {} };
      var failure = false;
      jQuery.each(group.guesttypeids, function(key, value) {
        if (failure) return;
        var guesttypeid = value;
        var guestscount = getGuestsCount(group, guesttypeid, true);
        if (guestscount == null) {
          failure = true;
        } else {
          minavailability.guests[guesttypeid] = guestscount;
        }
      });
      if (!failure) {
        // Show calendar (only if all guest type counts are correct)
        calendar(group.activityids, group.datecontrolid, false, minavailability);
      }
    }
	
    function formatMoney(n) {
      var c = 2, d = ".", t = ",", s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
	
    function showPriceAndAvailability(group) {
      var activityid = getSelectedActivityId(group, false);
      var activitydate = getActivityDate(group, false);
      var minavailability = { guests: {} };
      var failure = false;
      jQuery.each(group.guesttypeids, function(key, value) {
        if (failure) return;
        var guesttypeid = value;
        var guestscount = getGuestsCount(group, guesttypeid, false);
        if (guestscount == null) {
          failure = true;
        } else {
          minavailability.guests[guesttypeid] = guestscount;
        }
      });

      if (activitydate != null && !failure) {
        checkAvailability(function(data) {
		  group.activityid = null;
          jQuery.each(group.activityids, function(key, value) {
            // Enable or disable activities based on availability (only if activity date is selected and all guest types are correct)
            var activityid = value;
			if (data[activityid]) {
			  group.activityid = activityid;
			}
          });
		  if (group.activityid == null) {
		    jQuery('#availability').html('Not enough availability');
		    jQuery('#' + group.pricecontrolid).html('');
		  } else {
		    jQuery('#availability').html(group.activitydescriptions[group.activityid] + ' - seats available');
            var price = 0.0;
		    jQuery.each(group.guesttypeids, function(key, value) {
		      var guesttypeid = value;
		      var guestscount = getGuestsCount(group, guesttypeid, false);
		      var guesttypeprice = group.activityprices[group.activityid][guesttypeid];
		      price += guestscount * guesttypeprice;
			});
		    jQuery('#' + group.pricecontrolid).html('$' + formatMoney(price));
		  }
        }, group.activityids, activitydate, minavailability);
      }
    }

    function getSelectedActivityId(group, showWarningIfNoActivitySelected) {
      var activityid = group.activityid;
      if (activityid == null && showWarningIfNoActivitySelected) {
        alert('Please select activity');
      }
      return activityid;
    }
	
    function getGuestsCount(group, guestTypeId, showWarningIfWrongFormat) {
      var guestscountstr = jQuery('#' + group.guesttypecontrolids[guestTypeId]).val();
      if (guestscountstr == '') return 0;
      if (!/^\d+$/.test(guestscountstr)) {
        if (showWarningIfWrongFormat) {
          alert('Please select guest count');
        }
        return null;
      }
      return parseInt(guestscountstr);
    }

    function getActivityDate(group, showWarningIfWrongFormat) {
      var activitydatestr = jQuery('#' + group.datecontrolid).val();
      if (!/^\d\d?\/\d\d?\/\d\d\d\d$/.test(activitydatestr)) {
        if (showWarningIfWrongFormat) {
          alert('Please select activity date');
        }
        return null;
      }
      return activitydatestr;
    }

    function selectActivity(group, selectedcheckbox) {
      if (!selectedcheckbox.checked) return;
      jQuery.each(group.activityids, function(key, value) {
        if (selectedcheckbox.id == group.activitycheckboxcontrolids[value]) return;
        jQuery('#' + group.activitycheckboxcontrolids[value]).attr('checked', false);
      });
    }

    function booknow(group) {
      if (!jQuery('#' + group.cancellationpolicycontrolid).is(':checked')) {
        alert('Please check cancellation policy');
        return false;
      }

	  if (jQuery('#' + group.goldcardnumbercontrolid).val() != '' && jQuery('#' + group.promotionalcodecontrolid).val() != '') { 
	    alert('Please enter either goldcard number or promo code but not both'); 
		return false; 
	  }

      var activitydate = getActivityDate(group, true);
      if (activitydate == null) return false;

      var activityid = getSelectedActivityId(group, true);
      if (activityid == null) return false;

      reservation(group.supplierid, activityid, activitydate, '', 0.0);
      jQuery.each(group.guesttypeids, function(key, value) {
        var guesttypeid = value;
        var guestscount = jQuery('#' + group.guesttypecontrolids[guesttypeid]).val();
        addGuests(guesttypeid, guestscount);
      });
	  setgoldcard(jQuery('#' + group.goldcardnumbercontrolid).val());
      setpromotionalcode(jQuery('#' + group.promotionalcodecontrolid).val());
	  
      availability_popup();
	  
      return true;
    }
  </script>
  
<div class="swimleft">
	<div class="swimmanta">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        <?php endwhile; endif; ?>
    </div>       
</div>
<div class="swimright">

<?php echo do_shortcode("[metaslider id=361]"); ?>

    <div class="player">
<!--<object>



<iframe src="http://player.vimeo.com/video/43172942?title=0&amp;byline=0&amp;portrait=0" width="330" height="243" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>



</object>//-->



</div>
    <p class="sunlighttxt"><b>NIGHTLY MANTA SNORKELS</b></p>
<br/>

<p><b>5:00 p.m.--8:30 p.m.</b> (time changes during year with sunset)</p>
<p class="sunlighttxt"><b>Check-in 15 minutes prior to departure. Please verify current check-in times in your confirmation email. Be sure to allow extra time in your drive for afternoon traffic.</b></p>
<br/>
<p class="sunlighttxt"><b>Provided:</b> wetsuits, all snorkel gear, flotation as needed, lights, swim guide(s) in Ocean with you, water/sodas/juice, variety of dry snacks.  Once out of the water enjoy our warm shower, hot chocolate/coffee or tea. <b style="color: red;">Also included are 12-20 photos of your trip.</b></p>

<br/>
    <p class="sunlighttxt"><b>Bring:</b> towel, dry clothes, jacket/sweatshirt for the boat ride home.</p>
<br/>

<!--<p>Here is a  <a target="_blank" href="http://www.google.com/maps?q=Sunlight+On+Water,+425+Kealakehe+Parkway,+Kailua-Kona,+Hawaii&hl=en&ll=19.668898,-156.023948&spn=0.018892,0.024076&sll=19.668103,-156.026543&sspn=0.019094,0.012424&z=16&iwloc=A">Google Map</a> to our departure site at Honokohau Harbor.</p>-->
<p>Click Here for <a href="directions">Directions</a> &amp; <a href="directions">Map</a> to our departure site at Honokohau Harbor </p>
       

<br/>

<form>

<input type="hidden" name="action" value="EXTERNALRESERVATIONPAGE" />
<input type="hidden" name="activityid" value="2051" />

&nbsp;
<p class="sunlighttxt"><span style="font-size:14px;"><b>BOOK NOW!</b></span>
<br/>
  <h3>
Guests
  </h3>
<table>
    <tr>
      <td><input style="margin-right: 5px;" id="guests_g1_t965" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
      <td><b>$92.00 Adults <i><font color="grey">(Normal retail $102 - Save $10 by booking now)</font></i></b></td>
    </tr>
    <tr>
      <td><input id="guests_g1_t1337" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
      <td><b>$75.00 Child 12 & under<i><font color="grey">(Normal retail $85 - Save $10 by booking now)</font></i> </b></td>
    </tr>
    <tr>
      <td><input id="guests_g1_t1662" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
      <td><b>$40.00</b> Ride Along<i><font color="grey">(No discount offered on this guest type)</font></i> </td>
    </tr>
  </table>

  <table>
    <tr>
		<td>
			<h3 class="header">Choose Date: </h3>
		</td>
		<td>
			<input id="date_g1" onclick="showCalendar(group1);" onchange="showPriceAndAvailability(group1);" readOnly size="15">
			<a onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;" href="javascript:showCalendar(group1);" style="vertical-align: middle;"> <img src="https://www.hawaiifun.org/reservation/common/images/calendar-small.gif" style="width: 16px; height: 16px; border: none;"></a>
		</td>
    </tr>
  </table>

  <p><b style="color: red;"> Discount applied at checkout.</b></p>
	<br/>
  <h3 class="header">
    <div id="availability"></div>
  </h3>
  <br/>
  <hr />
  <div>Total Price with all Taxes & Fees: <span id="price_g1"></span></div>
  <hr />
  <br/>
If booking your trip 10 days in advance take an additional $5 off by entering promotional code:<strong><font color="blue"> 10ADV5OFF</strong></font> in the promo field.
  <script type="text/javascript">showPriceAndAvailability(group1);</script>
 <p> Promotional Code (optional): <input type="text" id="promotionalcode_a1399" size="8" /></p>
 <p>
  Goldcard Number (optional): <input type="text" id="goldcardnumber" size="8" /><br />
  If you don't have a Goldcard yet, you can <a target="_blank" href="http://www.shakaclub.hawaiifun.org/goldcardservlet?action=ORDERPAGE&referer=s391">buy it now</a>.
 </p>
 <br/>
  <strong>
	Book a Combo Package with any two or more activities and save! 
	For Combo, Group or Private Charter Rates please <a href="/contact-us">CLICK HERE</a>.<br/>
	Please call <a href="tel:808/896-2480">808/896-2480</a> for Reservations by telephone 8a.m.—8p.m. Hawaii Standard Time.
</strong>
<br/><br/>
  <input type="checkbox" id="cancellationpolicy">&nbsp;&nbsp;Check here Acknowledging our Cancellation policy:<br><font size="2">
  <br/>
 
<p>
<strong>1 - 4 PASSENGERS:</strong>
Notification of cancellation must be received by telephone at least 48 HOURS prior to departure time to receive a full refund. Any cancellation given with less than 48 Hours remaining before departure time will not be offered a refund. 
</p>

<p>
<strong>5 - 10 PASSENGERS:</strong>
Notification of cancellation much be received by telephone at least 72 HOURS prior to departure time to receive a full refund. No refund will be offered with less than 72 Hours remaining before departure time. 
</p>

<p>
<strong>10 + PASSENGERS:</strong>
Cancellations must be made 7 DAYS prior to departure date to receive a full refund. No refund will be offered with less than 7 days remaining before departure date.
</p>

<p>
<strong>PRIVATE CHARTERS:</strong>
Cancellations must be made at least 2 WEEKS prior to departure date to receive a full refund. No refund will be offered with less than 14 days remaining before departure date.</i></font>
</p>

<input type="button" onclick="booknow(group1);" value="Book Now">

</form>

<div class="sunlightphoto">

    <object width="355" height="266" type="application/x-shockwave-flash" data="http://www.sunlightonwater.com/_library/media/mantaflash.swf">

        <param value="http://www.sunlightonwater.com/_library/media/mantaflash.swf" name="movie" />

    </object>

 <!-- <object height="300" width="400" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0 class="><param value="10583" name="_cx"><param value="7938" name="_cy"><param value="" name="FlashVars"><param value="http://www.sunlightonwater.com/_library/media/mantaflash.swf" name="Movie"><param value="http://www.sunlightonwater.com//_library/media/mantaflash.swf" name="Src"><param value="Opaque" name="WMode"><param value="-1" name="Play"><param value="-1" name="Loop"><param value="High" name="Quality"><param value="" name="SAlign"><param value="-1" name="Menu"><param value="" name="Base"><param value="" name="AllowScriptAccess"><param value="ShowAll" name="Scale"><param value="0" name="DeviceFont"><param value="0" name="EmbedMovie"><param value="FFFFFF" name="BGColor"><param value="" name="SWRemote"><param value="" name="MovieData"><param value="1" name="SeamlessTabbing"><param value="0" name="Profile"><param value="" name="ProfileAddress"><param value="0" name="ProfilePort"><param value="all" name="AllowNetworking"><param value="false" name="AllowFullScreen">                              
</object> -->


</div>

</div>    
<br class="clear" />

<div style="height:20px;"></div>

<h2><em>What our Guests are saying :</em></h2>
<p>Melainah, </p>

<p>We went last night and what a terrific trip! The Captain and Crew were marvelous, the boat perfect, weather superb and the mantas cooperative. My daughter and I thoroughly enjoyed ourselves. I am very glad that we went with Sunlight On Water. The small group and self contained nature was superior to the crowds on board with the big operators. Being off on our own with our own private manta showing is the only way to go!</p>

<p>
A well done tour all around, with excellent value.~Lee N. 
</p>
</div>
<?php get_footer(); ?>