<?php require_once ("includes/header.php"); ?>

<div id="container" data-role="page" >

    <header>

        <div class="upperMenu">
            <?php include("includes/inner-menu.php"); ?>
        </div>

        <div id="header">
            <a href="index.php" class="homeButton" data-direction="reverse"></a>
            <a href="#" class="menuButton"></a>

            <h1> Swim <br/>with Manta Rays</h1>

            <!--<a href="portfolio.php" class="nextButton">&raquo;</a>-->

            <!--
            <a href="index.php">
              <div class="iButtonBody">
                <div>
                  <span></span>
                </div>
                <p>Back</p>
              </div>
            </a>
            -->
        </div>
    </header>
    <!--
    <div id="main" role="main">
    </div>
    -->

    <div id="pageServices" class="page">
        <div class="content">
            <div class="groupBox innerContent">
                <a class="make_reservation" href="#make_reservation" onclick="window.location = '#make_reservation';">
                    Make reservation by clicking here
                </a>
                <p>Sometimes referred to as the “Butterflies of the Sea”, these graceful animals are a sight that must been seen in person. Manta rays are beautiful sea creatures that live in warm tropical waters. Their side fins have evolved into wide triangular wings with which they use to “fly” through the water. These wings range from 4-20 ft, making them amongst the largest sea creatures anywhere. The Manta ray is one of Hawaii’s most fascinating and stunningly beautiful sights.</p>
                <p>Believed to have a lifespan of up to 25 years, this greatest of the ray family have been documented swimming at depths of 100 feet, but no one really knows how deep they can swim.</p>
                <p>Unlike most of their relatives, Manta Rays have NO teeth, stinger or barbs and are completely safe to be around. We invite you to have yet another experience of a lifetime…a night snorkel with these angels of the Ocean.</p>
                <p>The forward-pointing, paddle-like organs at each corner of a Manta’s mouth are termed “cephalic lobes”. They are basically forward extensions of the pectoral wings, complete with supporting radial cartilages. Mantas have been observed using their cephalic lobes like scoops to help push plankton-bearing water into their mouths. When Mantas are not actively feeding, the cephalic lobes are often furled like a flag ready for storage or held with their tips touching. Either of these cephalic lobe positions may reduce drag during long-distance swimming.</p>
                <p>Mantas are known to leap completely out of the water and do so for a variety of possible reasons. They may do it to escape a potential predator or to rid themselves of skin parasites. Or they may leap to communicate to others of their own species — the great, crashing splash of their re-entries can often be heard from miles (kilometers) away. It’s anyone’s guess what they may be trying to communicate. Leaping male Mantas may be demonstrating their fitness as part of a courtship display. Since these leaps are highly energetic and often repeated several times in succession, they may also represent a form of play.</p>
                <p>You may be wondering why we go snorkeling with the Mantas at night? Although Mantas are most commonly seen during daylight hours, it’s only because that is when most observers are in the water. Scientifically, we do not know exactly what Mantas do at night or how active they are, but they may feed most actively at night, when many planktonic creatures naturally rise to the surface, providing a rich bounty on which Mantas may feed. Using state-of-the-art lights, we are able to attract concentrations of these plankton and therefore attract the Mantas.&nbsp; It is exhilarating to be in the Ocean at night with the Mantas.</p>
                <p>We approach each tour with your safety and enjoyment as our highest priority and have adapted our tours to reflect this. We utilize custom designed light boards that were created specifically for us that double as rescue boards. Whenever possible we tie off directly to the back of the boat so swimming is minimized and you can easily enjoy the incredible show the mantas put on. If the mantas do not come to the boat, we may need to swim to them.</p>
                <p>Over 200 Manta Rays have been identified and named along the Kona Coast. I am happy to introduce you to Melainah Ray shown in the photo below!</p>
                <p>The crew will take photos of you on the boat and in the water. 12-20 photos will be provided to you at no extra cost. We are happy to provide you with this complimentary keepsake of your tour.</p>
                <p>All equipment is provided: short wetsuits, snorkel gear, flotation if needed, as well as water/sodas and dry snacks. All you need to bring is a towel and light jacket or windbreaker.  Rx masks are available in a limited range and by request.</p>
                <p>Personal items such as cameras, cell phones, or any other valuables brought on board are at your own risk. </p>

            </div>
        </div>
        <div class="content" id="make_reservation">

            <script type="text/javascript" src="https://www.hawaiifun.org/reservation/common/calendar_js.jsp?jsversion=20140126"></script>
            <script type="text/javascript" src="https://www.hawaiifun.org/reservation/external/functions.js?jsversion=20140126"></script>
            <script type="text/javascript" src="https://www.hawaiifun.org/reservation/external/functions2.js?jsversion=20140126"></script>

            <div class="groupBox innerContent">

                <script type="text/javascript">
                    // Activity group settings
                    var group1 = {
                        supplierid: 391,
                        activityids: [2051, 7028, 7029, 7030],
                        guesttypeids: [965, 1337, 1662],
                        activityprices: {
                            2051: {965: 92.00, 1337: 75.00, 1662: 40.00},
                            7028: {965: 92.00, 1337: 75.00, 1662: 40.00},
                            7029: {965: 92.00, 1337: 75.00, 1662: 40.00},
                            7030: {965: 92.00, 1337: 75.00, 1662: 40.00}
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
                        var minavailability = {guests: {}};
                        var failure = false;
                        $.each(group.guesttypeids, function(key, value) {
                            if (failure)
                                return;
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
                        var minavailability = {guests: {}};
                        var failure = false;
                        $.each(group.guesttypeids, function(key, value) {
                            if (failure)
                                return;
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
                                $.each(group.activityids, function(key, value) {
                                    // Enable or disable activities based on availability (only if activity date is selected and all guest types are correct)
                                    var activityid = value;
                                    if (data[activityid]) {
                                        group.activityid = activityid;
                                    }
                                });
                                if (group.activityid == null) {
                                    $('#availability').html('Not enough availability');
                                    $('#' + group.pricecontrolid).html('');
                                } else {
                                    $('#availability').html(group.activitydescriptions[group.activityid] + ' - seats available');
                                    var price = 0.0;
                                    $.each(group.guesttypeids, function(key, value) {
                                        var guesttypeid = value;
                                        var guestscount = getGuestsCount(group, guesttypeid, false);
                                        var guesttypeprice = group.activityprices[group.activityid][guesttypeid];
                                        price += guestscount * guesttypeprice;
                                    });
                                    $('#' + group.pricecontrolid).html('$' + formatMoney(price));
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
                        var guestscountstr = $('#' + group.guesttypecontrolids[guestTypeId]).val();
                        if (guestscountstr == '')
                            return 0;
                        if (!/^\d+$/.test(guestscountstr)) {
                            if (showWarningIfWrongFormat) {
                                alert('Please select guest count');
                            }
                            return null;
                        }
                        return parseInt(guestscountstr);
                    }

                    function getActivityDate(group, showWarningIfWrongFormat) {
                        var activitydatestr = $('#' + group.datecontrolid).val();
                        if (!/^\d\d?\/\d\d?\/\d\d\d\d$/.test(activitydatestr)) {
                            if (showWarningIfWrongFormat) {
                                alert('Please select activity date');
                            }
                            return null;
                        }
                        return activitydatestr;
                    }

                    function selectActivity(group, selectedcheckbox) {
                        if (!selectedcheckbox.checked)
                            return;
                        $.each(group.activityids, function(key, value) {
                            if (selectedcheckbox.id == group.activitycheckboxcontrolids[value])
                                return;
                            $('#' + group.activitycheckboxcontrolids[value]).attr('checked', false);
                        });
                    }

                    function booknow(group) {
                        if (!$('#' + group.cancellationpolicycontrolid).is(':checked')) {
                            alert('Please check cancellation policy');
                            return false;
                        }

                        if ($('#' + group.goldcardnumbercontrolid).val() != '' && $('#' + group.promotionalcodecontrolid).val() != '') {
                            alert('Please enter either goldcard number or promo code but not both');
                            return false;
                        }

                        var activitydate = getActivityDate(group, true);
                        if (activitydate == null)
                            return false;

                        var activityid = getSelectedActivityId(group, true);
                        if (activityid == null)
                            return false;

                        reservation(group.supplierid, activityid, activitydate, '', 0.0);
                        $.each(group.guesttypeids, function(key, value) {
                            var guesttypeid = value;
                            var guestscount = $('#' + group.guesttypecontrolids[guesttypeid]).val();
                            addGuests(guesttypeid, guestscount);
                        });
                        setgoldcard($('#' + group.goldcardnumbercontrolid).val());
                        setpromotionalcode($('#' + group.promotionalcodecontrolid).val());

                        availability_popup();

                        return true;
                    }
                </script>

                <h1>Night Manta Snorkeling</h1>

                <h3>
                    Guests
                </h3>

                <table>
                    <tr>
                        <td><input class="reservation-input" id="guests_g1_t965" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
                        <td><b>$92.00</b> Adults <i><font color="grey">(Normal retail $102 - Save $10 by booking now)</font></i></td>
                    </tr>
                    <tr>
                        <td><input class="reservation-input" id="guests_g1_t1337" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
                        <td><b>$75.00</b> Child 12 & under<i><font color="grey">(Normal retail $85 - Save $10 by booking now)</font></i> </td>
                    </tr>

                    <tr>
                        <td><input class="reservation-input" id="guests_g1_t1662" type="text" value="0" size="5" onchange="showPriceAndAvailability(group1);"></td>
                        <td><b>$40.00</b> Ride Along<i><font color="grey">(No discount offered on this guest type)</font></i> </td>
                    </tr>

                </table>

                <h3 class="header">
                    Choose Date
                </h3>

                <table>
                    <tr>
                        <td>
                            <input id="date_g1" onclick="showCalendar(group1);" onchange="showPriceAndAvailability(group1);" readOnly size="15">
                            <a onMouseOver="window.status = 'Date Picker';
                        return true;" onMouseOut="window.status = '';
                        return true;" href="javascript:showCalendar(group1);" style="vertical-align: middle;"> <img src="https://www.hawaiifun.org/reservation/common/images/calendar-small.gif" style="width: 16px; height: 16px; border: none;"></a>
                        </td>
                    </tr>
                </table>

                <h3 class="header">
                    <div id="availability"></div>
                </h3>

                <hr />

                Total Price with all Taxes & Fees</a>: <span id="price_g1"></span>

                <hr />
                If booking your trip 10 days in advance take an additional $5 off by entering promotional code:<strong><font color="blue"> 10ADV5OFF</strong></font> in the promo field.
                <script type="text/javascript">showPriceAndAvailability(group1);</script>
                <p> Promotional Code (optional): <input type="text" id="promotionalcode" size="8" />
                </p>

                <p></p>
                Goldcard Number (optional): <input type="text" id="goldcardnumber" size="8" /><br />
                If you don't have a Goldcard yet, you can <a target="_blank" href="http://www.shakaclub.hawaiifun.org/goldcardservlet?action=ORDERPAGE&referer=s391">buy it now</a>.
                <p></p>

                <input data-role="none" type="checkbox" id="cancellationpolicy"><label for="cancellationpolicy">Check here Acknowledging our Cancellation policy:</label><br><font size="2"><i>
                    <p>
                    <strong>1 - 4 PASSENGERS:</strong>
                    Notification of cancellation must be received by telephone at least 48 HOURS prior to departure time to receive a full refund. Any cancellation given with less than 48 Hours remaining before departure time will not be offered a refund. 
                    <br/>
                    </p><p>
                    <strong>5 - 10 PASSENGERS:</strong>
                    Notification of cancellation much be received by telephone at least 72 HOURS prior to departure time to receive a full refund. No refund will be offered with less than 72 Hours remaining before departure time. 
                    <br/>
                    </p><p>
                    <strong>10 + PASSENGERS:</strong>
                    Cancellations must be made 7 DAYS prior to departure date to receive a full refund. No refund will be offered with less than 7 days remaining before departure date.
                    <br/>
                    </p><p>
                    <strong>PRIVATE CHARTERS:</strong>
                    Cancellations must be made at least 2 WEEKS prior to departure date to receive a full refund. No refund will be offered with less than 14 days remaining before departure date.</i></font>
                    </p>
                <input type="button" value="Book Now" onclick="booknow(group1);
                        return false;" />


            </div>
        </div>

        <div class="content">
            <div class="groupBox innerContent">
                <p><img width="100%" alt="Swim with Manta Rays Image" src="img/site_images/Melainah-Ray-11-300x168.jpg" title="Melainah Ray-1" class="alignleft size-medium wp-image-210"></p>
                <p><img width="100%" alt="Swim with Manta Rays Image" src="img/site_images/manta/December-14-2012-Manta-049-300x225.jpg" title="Melainah Ray-1" class="alignleft size-medium wp-image-210"></p>
                <p><img width="100%" alt="Swim with Manta Rays Image" src="img/site_images/manta/December-14-2012-Manta-073-300x225.jpg" title="Melainah Ray-1" class="alignleft size-medium wp-image-210"></p>
                <p><img width="100%" alt="Swim with Manta Rays Image" src="img/site_images/manta/December-29-2012-Manta-047-001-1-300x225.jpg" title="Melainah Ray-1" class="alignleft size-medium wp-image-210"></p>
                <p><img width="100%" alt="Swim with Manta Rays Image" src="img/site_images/manta/February-12-2013-Manta-079-003-300x225.jpg" title="Melainah Ray-1" class="alignleft size-medium wp-image-210"></p>

            </div>
        </div>
        <!-- end  content -->

    </div>
    <div class="clearfix"></div>




<?php
require_once ("includes/footer.php");