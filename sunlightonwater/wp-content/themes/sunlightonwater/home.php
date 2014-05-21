<?php







/**







 * @package WordPress







 * @subpackage Default_Theme







 */







/*







Template Name: Home Page







*/







?><?php
?>















<?php get_header(); ?>















    	<img align="middle" src="<?php bloginfo('stylesheet_directory'); ?>/images/hawaiian-dolphin-swims.jpg" width="740" height="58" alt="Dolphin Swim Sunlight on Water" title="Dolphin Swim" />







        <div class="dlphin">







        	<p>Aloha! and welcome to the website for SunLight On Water,</p>







        	<p>the premier <a href="dolphin-swim">Dolphin Swim</a> eco-tour charter company on the Big Island of Hawaii.</p>















        </div>







        <!-- Contentleft Div Starts Here -->







        <div class="contentleft">



		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>



            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>



        <?php endwhile; endif; ?>



        </div>







    	<!-- Contentleft Div Ends Here -->







        







        <!-- Contentright Div Starts Here -->







        <div class="contentright">







            <!-- <img src="http://majesticserver/sunlightonwater/wp-content/themes/sunlightonwater_new/images/imageslide.jpg" width="409" height="253" alt="Sunlight on Water Image" title="Sunlight on Water" />-->















            <div class="musictext">



				<div style="margin:0 0 0 22px;"><?php echo do_shortcode("[metaslider id=472]"); ?></div>



            	<!--<object width="422" height="265" type="application/x-shockwave-flash" data="http://www.sunlightonwater.com/_library/templates/skin_sunlight/homeflash.swf">







                    <param value="http://www.sunlightonwater.com/_library/templates/skin_sunlight/homeflash.swf" name="movie" />







                </object>//-->







                







            	<!--<object height="265" width="422" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">







                <param value="http://www.sunlightonwater.com/_library/templates/skin_sunlight/homeflash.swf" name="movie" />







                <param value="best" name="quality" />







                <param value="true" name="play" />







                <embed height="265" width="422" play="true" quality="best" type="application/x-shockwave-flash" src="http://www.sunlightonwater.com/_library/templates/skin_sunlight/homeflash.swf" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>-->







            </div>







			<div class="music" style="margin: 5px 0 0 21px;"><iframe scrolling="no" height="30" frameborder="0" width="50" src="http://www.sunlightonwater.com/_library/media/flashmp3.html"></iframe></div><div class="musiccontent" style="width:314px; margin:1px 0 0 0;">The controls at left will stop the music if you like. It is an excerpt of "Taua Mai E" from "The Calling" by Kutira &nbsp; Raphae</div>















            <br class="clear" />







        </div>







        <br class="clear" />







        <!-- Contentright Div Starts Here -->







        <!-- Photo Div Starts  Here -->







        <ul class="photo">







            <li>







               <a href="?page_id=14"><img height="101" border="0" width="160" src="http://www.sunlightonwater.com/_library/templates/skin_sunlight/home-small1.jpg" alt="Michael &amp; Melainah Yee" />&nbsp;</a>







                 <p class="sunlighttxt">Michael and Melainah Yee SunLight On Water's owners, Michael and Melainah Yee have extensive experience leading Dolphin Swims on the Big Island of Hawaii. Even more important, is their deep love for these beautiful...</p>







                <a href="?page_id=14">READ MORE --></a>















            </li>







            







            <li>







                <a href="http://sunlightonwater.com/about-us/our-boat"><img height="101" border="0" width="160" src="http://www.sunlightonwater.com/_library/templates/skin_sunlight/home-small2.jpg" alt="Dolphin swim boat" />&nbsp;</a>







                 <p class="sunlighttxt">Our boat, the "Uhane Nui O Nai'a" is pretty special. The name means "Great Spirit of the Dolphin" and she was built specifically for snorkeling with a long list of features that includes an onboard...</p>







				<a href="?page_id=16">READ FULL FEATURE LIST --></a>







            </li>







            







            <li>







                <a href="?page_id=26"><img height="101" border="0" width="160" src="http://www.sunlightonwater.com/_library/templates/skin_sunlight/home-small3.jpg" alt="Dolphin Photos" />&nbsp;</a>















                <p class="sunlighttxt">If you love pictures of Dolphins, then you are going to really love the page that Melainah has put together of <a href="http://sunlightonwater.com/about-dolphins/dolphin-pictures">Dolphin Photos</a>. But that's not all, she has also prepared 13 gorgeous Dolphin pictures as Desktop Wallpaper Backgrounds! <a href="http://sunlightonwater.com/about-dolphins/dolphin-wallpapers">GO --></a></p>







               







            </li>







            







            <li>







                <a href="?page_id=24"><img height="101" border="0" width="160" src="http://www.sunlightonwater.com/_library/templates/skin_sunlight/home-small4.jpg" alt="dolphin picture" />&nbsp;</a>







               <p class="sunlighttxt">Because we love Dolphins so much, we want to help you learn about them too. We have several of our favorite things about Dolphins for you to discover and then we also have some more...</p>















                 <a href="about-dolphins">READ MORE --></a>







            </li>







        </ul>







        <br class="clear" />







        <div class="accredited">







            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/hvcb_member.jpg" width="152" height="75" alt="Member Image Sunlight on Water" title="Member Image" />





            <!--<img src="<?php bloginfo('stylesheet_directory'); ?>/images/bbbseal3.gif" width="94" height="152" alt="Member Image1 Sunlight on Water" title="Member Image1" />-->
<a title="Click for the Business Review of Sunlight on Water, a Boat - Charter in Kailua Kona HI" href="http://www.bbb.org/hawaii/business-reviews/boat-charter/sunlight-on-water-in-kailua-kona-hi-53033592#sealclick" target='_blank'><img alt="Click for the BBB Business Review of this Boat - Charter in Kailua Kona HI" style="border: 0;" src="http://seal-hawaii.bbb.org/seals/blue-seal-69-145-sunlightonwater-53033592.png" /></a>			


            <!--<a href="http://sunlightonwater.com/agent-shortcut"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/shortcut.gif" width="200" height="54" alt="Agent Shortcut" title="Agent Shortcut" /></a>-->




        </div>







        







<?php get_footer(); ?>