<style type='text/css'>
<?php
global $options;
foreach ($options as $value) {
	if ( isset( $value['id'] ) ) {
		if (get_option( $value['id'] ) === FALSE) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_option( $value['id'] );
		}
	}
}
if(($ds_eth_logo_xpos)||($ds_eth_logo_ypos)){ ?>
#logo{
left:<?php echo ($ds_eth_logo_xpos+4); ?>px;
bottom:<?php echo $ds_eth_logo_ypos; ?>px;
}
<?php }
if($ds_eth_logo_headroom){ ?>
#header{
height:<?php echo ($ds_eth_logo_headroom+108); ?>px;
}
<?php } 
if($ds_eth_css_strful == 'full'){ ?>
body{
background:url("<?php bloginfo('template_url') ?>/css/img/colors/<?php $css_name = str_replace(' ','',strtolower($ds_eth_css)); echo $css_name; ?>/img/backgroundfull.png") repeat fixed center top;
}
<?php }
if($ds_eth_css_bcgupload){ ?>
body{
background:url("<?php echo $ds_eth_css_bcgupload.'") '; if($ds_eth_css_rep != 'fixed'){echo $ds_eth_css_rep.' scroll';} elseif($ds_eth_css_rep == 'fixed'){echo ' fixed';} echo ' center top '.$ds_eth_css_bcgcol; ?>;
}
<?php }
if($ds_eth_css_button != 'Same as current theme color'){ ?>
a.superbutton,.inner_main input.superbutton,button.superbutton,.inner_main input.wpcf7-submit,#comments input#submit,.pagination .current{
<?php if($ds_eth_css_button == 'Orange'){ ?>color:#ffffff;background-position:center -1px;border:1px solid #d65f34;box-shadow:inset 0px 1px 1px #faaa82;text-shadow:1px 1px #c8542d;<?php } ?>
<?php if($ds_eth_css_button == 'Red'){ ?>color:#ffffff;background-position:center -1141px;border:1px solid #9e2b2b;box-shadow:inset 0px 1px 1px #ec6161;text-shadow:1px 1px #9e2b2b;<?php } ?>
<?php if($ds_eth_css_button == 'Black'){ ?>color:#dfdfdf;background-position:center -61px;border:1px solid #000000;box-shadow:inset 0px 1px 1px #474747;text-shadow:1px 1px #000000;<?php } ?>
<?php if($ds_eth_css_button == 'White'){ ?>color:#7a7a7a;background-position:center -181px;border:1px solid #cecece;box-shadow:inset 0px 1px 1px #ffffff;text-shadow:1px 1px #ffffff;<?php } ?>
<?php if($ds_eth_css_button == 'Bronze'){ ?>color:#ffffff;background-position:center -301px;border:1px solid #43363b;box-shadow:inset 0px 1px 1px #8c8085;text-shadow:1px 1px #3d3638;<?php } ?>
<?php if($ds_eth_css_button == 'Brown'){ ?>color:#ffffff;background-position:center -361px;border:1px solid #4a413e;box-shadow:inset 0px 1px 1px #8c8085;text-shadow:1px 1px #3d3638;<?php } ?>
<?php if($ds_eth_css_button == 'Green'){ ?>color:#ffffff;background-position:center -421px;border:1px solid #40533f;box-shadow:inset 0px 1px 1px #7c907c;text-shadow:1px 1px #374936;<?php } ?>
<?php if($ds_eth_css_button == 'Purple'){ ?>color:#ffffff;background-position:center -481px;border:1px solid #352d42;box-shadow:inset 0px 1px 1px #776890;text-shadow:1px 1px #352d42;<?php } ?>
<?php if($ds_eth_css_button == 'Teal'){ ?>color:#ffffff;background-position:center -541px;border:1px solid #40665e;box-shadow:inset 0px 1px 1px #9ccbc1;text-shadow:1px 1px #40665e;<?php } ?>
<?php if($ds_eth_css_button == 'Coral'){ ?>color:#ffffff;background-position:center -601px;border:1px solid #44a6ac;box-shadow:inset 0px 1px 1px #91e4e6;text-shadow:1px 1px #44a6ac;<?php } ?>
<?php if($ds_eth_css_button == 'Dentist Green'){ ?>color:#ffffff;background-position:center -660px;border:1px solid #8ca48b;box-shadow:inset 0px 1px 1px #dee6de;text-shadow:1px 1px #8ca48b;<?php } ?>
<?php if($ds_eth_css_button == 'Grey'){ ?>color:#ffffff;background-position:center -721px;border:1px solid #819792;box-shadow:inset 0px 1px 1px #d6dedc;text-shadow:1px 1px #819792;<?php } ?>
<?php if($ds_eth_css_button == 'Hospital Green'){ ?>color:#ffffff;background-position:center -781px;border:1px solid #649873;box-shadow:inset 0px 1px 1px #acd2bb;text-shadow:1px 1px #649873;<?php } ?>
<?php if($ds_eth_css_button == 'Navy'){ ?>color:#ffffff;background-position:center -841px;border:1px solid #36434a;box-shadow:inset 0px 1px 1px #7d96a4;text-shadow:1px 1px #36434a;<?php } ?>
<?php if($ds_eth_css_button == 'Neon Blue'){ ?>color:#ffffff;background-position:center -901px;border:1px solid #128ece;box-shadow:inset 0px 1px 1px #38d4f6;text-shadow:1px 1px #128ece;<?php } ?>
<?php if($ds_eth_css_button == 'Ocean Blue'){ ?>color:#ffffff;background-position:center -961px;border:1px solid #284250;box-shadow:inset 0px 1px 1px #598196;text-shadow:1px 1px #284250;<?php } ?>
<?php if($ds_eth_css_button == 'Olive'){ ?>color:#ffffff;background-position:center -1021px;border:1px solid #6c6e4b;box-shadow:inset 0px 1px 1px #babc8e;text-shadow:1px 1px #6c6e4b;<?php } ?>
<?php if($ds_eth_css_button == 'Pink'){ ?>color:#ffffff;background-position:center -1081px;border:1px solid #a35eaf;box-shadow:inset 0px 1px 1px #e8acee;text-shadow:1px 1px #a35eaf;<?php } ?>
<?php if($ds_eth_css_button == 'Selen'){ ?>color:#ffffff;background-position:center -1201px;border:1px solid #bfc517;box-shadow:inset 0px 1px 1px #fdff6a;text-shadow:1px 1px #a8aa21;<?php } ?>
<?php if($ds_eth_css_button == 'Soft Green'){ ?>color:#ffffff;background-position:center -1261px;border:1px solid #90a850;box-shadow:inset 0px 1px 1px #e4edad;text-shadow:1px 1px #90a850;<?php } ?>
<?php if($ds_eth_css_button == 'Soft Teal'){ ?>color:#ffffff;background-position:center -1321px;border:1px solid #92c9bd;box-shadow:inset 0px 1px 1px #e2f6f1;text-shadow:1px 1px #6b9f93;<?php } ?>
<?php if($ds_eth_css_button == 'Yellow'){ ?>color:#ffffff;background-position:center -1381px;border:1px solid #edc72e;box-shadow:inset 0px 1px 1px #fff49c;text-shadow:1px 1px #d4ae00;<?php } ?>
}
a.superbutton:hover,.inner_main input.superbutton:hover,a.superbutton.selected,button.superbutton:hover,.inner_main input.wpcf7-submit:hover,#comments input#submit:hover{
<?php if($ds_eth_css_button == 'Orange'){ ?>background-position:center -31px;<?php } ?>
<?php if($ds_eth_css_button == 'Red'){ ?>background-position:center -1170px;<?php } ?>
<?php if($ds_eth_css_button == 'Black'){ ?>background-position:center -91px;<?php } ?>
<?php if($ds_eth_css_button == 'White'){ ?>background-position:center -211px;<?php } ?>
<?php if($ds_eth_css_button == 'Bronze'){ ?>background-position:center -330px;<?php } ?>
<?php if($ds_eth_css_button == 'Brown'){ ?>background-position:center -390px;<?php } ?>
<?php if($ds_eth_css_button == 'Green'){ ?>background-position:center -450px;<?php } ?>
<?php if($ds_eth_css_button == 'Purple'){ ?>background-position:center -510px;<?php } ?>
<?php if($ds_eth_css_button == 'Teal'){ ?>background-position:center -570px;<?php } ?>
<?php if($ds_eth_css_button == 'Coral'){ ?>background-position:center -630px;<?php } ?>
<?php if($ds_eth_css_button == 'Dentist Green'){ ?>background-position:center -690px;<?php } ?>
<?php if($ds_eth_css_button == 'Grey'){ ?>background-position:center -750px;<?php } ?>
<?php if($ds_eth_css_button == 'Hospital Green'){ ?>background-position:center -810px;<?php } ?>
<?php if($ds_eth_css_button == 'Navy'){ ?>background-position:center -870px;<?php } ?>
<?php if($ds_eth_css_button == 'Neon Blue'){ ?>background-position:center -930px;<?php } ?>
<?php if($ds_eth_css_button == 'Ocean Blue'){ ?>background-position:center -990px;<?php } ?>
<?php if($ds_eth_css_button == 'Olive'){ ?>background-position:center -1050px;<?php } ?>
<?php if($ds_eth_css_button == 'Pink'){ ?>background-position:center -1110px;<?php } ?>
<?php if($ds_eth_css_button == 'Selen'){ ?>background-position:center -1230px;<?php } ?>
<?php if($ds_eth_css_button == 'Soft Green'){ ?>background-position:center -1290px;<?php } ?>
<?php if($ds_eth_css_button == 'Soft Teal'){ ?>background-position:center -1350px;<?php } ?>
<?php if($ds_eth_css_button == 'Yellow'){ ?>background-position:center -1410px;<?php } ?>
}
a.superbutton,.inner_main input.superbutton,button.superbutton,.inner_main input.wpcf7-submit,#comments input#submit,.pagination .current{
<?php if($ds_eth_css_button != 'White'){ ?>color:#ffffff !important;<?php }
else{ ?>color:#7a7a7a !important;<?php } ?>
}
<?php }
if($ds_eth_css_headcol){ ?>
a,a:active,a:visited,#main_link_color,#personal_data p span,#personal_data p span a,h1 strong,h2 strong,h3 strong,h4 strong,h5 strong,h6 strong,.dropcapcolor,.inner_main .widget ul.testimonials li p span,.post_header a:hover,.breadcrumbs p span,h1 span, h2 span, h3 span, h4 span, h5 span, h6 span,.hotstuff ul li a,#ds_relatedpost .ds_related a:hover,.inner_main ul li.popular-posts ul li a:hover{color:<?php echo $ds_eth_css_headcol; ?>;}
a:hover{color:#1e1e1e;}#footer a:hover{ color:#ffffff;}.post_header a{color:#1e1e1e;}.dropcapspot{background-color:<?php echo $ds_eth_css_headcol; ?>;}
::-moz-selection{background:<?php echo $ds_eth_css_headcol; ?>;color:#fff;text-shadow: none;}
::selection{background:<?php echo $ds_eth_css_headcol; ?>;color:#fff;text-shadow: none;}
a:link{-webkit-tap-highlight-color:<?php echo $ds_eth_css_headcol; ?>;}
<?php }
if($ds_eth_css_toppecol){ ?>
#personal_data p{color:<?php echo $ds_eth_css_toppecol; ?>;}
<?php }
if($ds_eth_css_toppecolx){ ?>
#personal_data p span, #personal_data p span a{color:<?php echo $ds_eth_css_toppecolx; ?>;}
<?php }
if($ds_eth_css_copycol){ ?>
#footer_bottom p{color:<?php echo $ds_eth_css_copycol; ?>;}
<?php }
if($ds_eth_css_copylcol){ ?>
#footer_bottom p a{color:<?php echo $ds_eth_css_copylcol; ?>;}
<?php }
if($ds_eth_css_copyscol){ ?>
#footer_bottom p{text-shadow:1px 1px <?php echo $ds_eth_css_copyscol; ?>;}
<?php }
if($ds_eth_css_dowline){ ?>
.stripe{background-color:<?php echo $ds_eth_css_dowline; ?>;}
<?php }
if($ds_eth_css_uppline){ ?>
.stripe{border-top:1px solid <?php echo $ds_eth_css_uppline; ?>;}
<?php }
if($ds_eth_css_linerad == 'Yes'){ ?>
.stripe{display:none;}
<?php }
if($ds_eth_css_input){
echo stripslashes($ds_eth_css_input);
} ?>
</style>