<?php require_once ("includes/header.php"); ?>

<div id="container" data-role="page" >
    <header>

        <div class="upperMenu">
            <?php include("includes/inner-menu.php"); ?>
        </div>

        <div id="header">
            <a href="index.php" class="homeButton" data-direction="reverse"></a>
            <a href="#" class="menuButton"></a>
            <h1>Kealakekua Bay <br/>Afternoon Snorkel</h1>

        </div>
    </header>

    <div id="pagePortfolio" class="page">

        <div class="content">
            <div class="groupBox innerContent">
                <h2><strong>Kealakekua Bay Snorkel</strong></h2>
                <a class="make_reservation" href="#make_reservation" onclick="window.location = '#make_reservation';">
                    Make reservation by clicking here
                </a>
                <p>
                    Join us for a 12:30p.m. departure from Honokohau Harbor to the pristine waters of Kealakekua Bay.  As we travel the Kona Coastline to the bay, your Captain and crew will point out places of interest.  We may even see the Hawaiian Spinner Dolphins along the way.
                </p>
                <p>
                    Kealakekua Bay is a Marine Sanctuary and has been designated as an underwater state park.  The amazing coral reef is home to a variety of Marine life not found anywhere else in Hawaii.  With visibility up to 100ft, the bay offers some of the best snorkeling in all of Hawaii.  Kealakekua Bay is the largest sheltered bay on the Island of Hawaii  with the cliffs (pali) towering to over 100 ft, providing calm water all year.  It is also the location of the Captain Cook monument.
                </p>
                <p>
                    Kealakekua Bay is an ancient, sacred and historical site for the Hawaiian people.  Many ceremonies were performed here.  Kealakekua means “Pathway of the Gods”.
                </p>
                <p>
                    Only permitted vessels are now allowed in Kealakekua Bay and SunLight On Water is honored to hold one of those permits.  As with all our tours, we will share the protocols for swimming respectfully in this sacred place.  
                </p>

            </div>
        </div>

        <div class="content">
            <div class="groupBox innerContent">
                <p class="sunlighttxt"><b><a id="make_reservation">Kealakekua Bay Snorkel</a></b></p>
                <br/>
                <script type="text/javascript" src="https://www.hawaiifun.org/reservation/common/calendar_js.jsp?jsversion=20140126"></script>
                <script type="text/javascript" src="https://www.hawaiifun.org/reservation/external/functions.js?jsversion=20140126"></script>
                
                <form>
                    <h3>
                        Guests
                    </h3>
                    <table>
                        <tr>
                            <td><input class="reservation-input" type='text' id='guests_a7121_t965' value='0' size='4'></td><td><b>$118.00</b> &nbsp;Adults <i><font color="grey"></font></i></td>
                        </tr>
                        <tr>
                            <td><input class="reservation-input" type='text' id='guests_a7121_t1337' value='0' size='4'></td>
                            <td><b>$85.00</b> &nbsp;Child 12 & under<i><font color="grey"></font></i> </td>
                        </tr>
                        <tr>
                            <td> <input class="reservation-input" type='text' id='guests_a7121_t1662' value='0' size='2'></td>
                            <td><b>$65.00</b>&nbsp;Ride Along/with a swimmer<i><font color="grey"></font></i> </td>
                        </tr>
                    </table>

                    <h3 class="header">
                        Choose Date
                    </h3>

                    <input id="date_a7121" onclick="calendar(7121, 'date_a7121', false);" readOnly size="15" />
                    <a onMouseOver="window.status = 'Date Picker';
                        return true;" onMouseOut="window.status = '';
                        return true;" href="javascript:calendar(7121, 'date_a7121', false);"> <img height="22" src="https://www.hawaiifun.org/reservation/company/show-calendar.gif" width="24" border="0"></a>
                    <hr>
                    If your booking this Kealakekua Bay Snorkel 10 days in advance, take $5 off by entering promotional code:<strong><font color="blue"> 10ADV5OFF</strong></font> in the promo field.
                    <p></p>
                    Promotional Code (optional): <input type="text" id="promotionalcode_a7121" size="8" />
                    <p></p>

                    <p></p>
                    Goldcard Number (optional): <input type="text" id="goldcardnumber_a7121" size="8" /><br />
                    If you don't have a Shaka Club Gold Card yet, you can <a target="_blank" href="http://www.shakaclub.hawaiifun.org/goldcardservlet?action=ORDERPAGE&referer=s391">buy it now</a>.
                    <p></p>

                    <hr>
                    <p></p>
                    <input data-role="none" type="checkbox" id="cancellationpolicy_a7121" /><label for="cancellationpolicy_a7121">Check here Acknowledging our Cancellation policy:</label><br><font size="2"><i>
                        <p>
                            <strong>1 - 4 PASSENGERS:</strong>
                            Notification of cancellation must be received by telephone at least 48 HOURS prior to departure time to receive a full refund. Any cancellation given with less than 48 Hours remaining before departure time will not be offered a refund. 
                            <br/>
                        <p/><p>
                            <strong>5 - 10 PASSENGERS:</strong>
                            Notification of cancellation much be received by telephone at least 72 HOURS prior to departure time to receive a full refund. No refund will be offered with less than 72 Hours remaining before departure time. 
                            <br/>
                        <p/><p>
                            <strong>10 + PASSENGERS:</strong>
                            Cancellations must be made 7 DAYS prior to departure date to receive a full refund. No refund will be offered with less than 7 days remaining before departure date.
                            <br/>
                        <p/><p>
                            <strong>PRIVATE CHARTERS:</strong>
                            Cancellations must be made at least 2 WEEKS prior to departure date to receive a full refund. No refund will be offered with less than 14 days remaining before departure date.</i></font>
                    </p>

                    <input type="button" value="Book Now" onclick="if (!checkcancellation(document.getElementById('cancellationpolicy_a7121')))
                            return false;
                        if (document.getElementById('goldcardnumber_a7121').value != '' && document.getElementById('promotionalcode_a7121').value != '') {
                            alert('Please enter either goldcard number or promo code but not both');
                            return false;
                        }
                        reservation2('7121', 7121, document.getElementById('date_a7121').value, '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
                        addGuests(965, document.getElementById('guests_a7121_t965').value);
                        addGuests(1337, document.getElementById('guests_a7121_t1337').value);
                        addGuests(1662, document.getElementById('guests_a7121_t1662').value);
                        setgoldcard(document.getElementById('goldcardnumber_a7121').value);
                        setpromotionalcode(document.getElementById('promotionalcode_a7121').value);
                        availability_popup();
                        return false;" />

                </form>

            </div>
        </div>

        <div class="content">
            <div class="groupBox innerContent">
                <p>
                    <img width="100%" title="Photo " alt="Photo Sun Light On Water" src="img/site_images/kealakekua-bay-snorkel/1.jpg">
                </p>
                <p>
                    <img width="100%" title="Photo " alt="Photo Sun Light On Water" src="img/site_images/kealakekua-bay-snorkel/2.jpg">
                </p>
                <p>
                    <img width="100%" title="Photo " alt="Photo Sun Light On Water" src="img/site_images/kealakekua-bay-snorkel/3.jpg">
                </p>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>




    <?php
    require_once ("includes/footer.php");