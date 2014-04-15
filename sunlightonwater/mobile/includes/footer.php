
    
    
    <footer>
      <div id="footer">
        Copyright &copy; 2012 by Sunlight On Water
        <a href="http://www.w3.org/html/logo/" target="_blank" class="html5">
            <!--<img src="img/HTML5_1Color_White.png" alt="HTML5 Powered with CSS3 / Styling, and Semantis" title="HTML5 Powered with CSS3 / Styling, and Semantics">-->
        </a>
      </div>
    </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
  <!--<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>-->
  
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.2.min.js"><\/script>')</script>

  
  <!--validation for older browsers (if) -->
  
  
  <script src="js/iscroll.js"></script>
  <script src="js/jquery.flexslider-min.js"></script>
  <script src="js/photoswipe/klass.min.js"></script>
  <script src="js/photoswipe/code.photoswipe.jquery-3.0.5.min.js"></script>
  <script>
    $(document).bind("mobileinit", function(){
      
          $.mobile.defaultPageTransition = 'none';
          //$.mobile.defaultPageTransition = 'slide';
          //$.mobile.defaultPageTransition = 'fade';
          //$.mobile.defaultPageTransition = 'flow';
          //$.mobile.defaultPageTransition = 'flip';
          //$.mobile.defaultPageTransition = 'pop';
          
          $.mobile.ignoreContentEnabled = true;
          
          //enable this if you want your website to run without jQuery Mobile Navigation
          $.mobile.ajaxEnabled = false;
    });
  </script>
  <!--<script src="js/jquery.mobile-1.1.1.min.js"></script>-->
  <script src="js/jquery.mobile-1.2.0.min.js"></script>
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

  <!--
  <script src="js/hammer/hammer.js"></script>
  <script src="js/hammer/jquery.hammer.js"></script>
  -->
  
  <script src="js/helper.js"></script>
  <script src="js/script.js"></script>
  <!-- end scripts-->

  <!-- Debugger - remove for production -->
  <!-- <script src="https://getfirebug.com/firebug-lite.js"></script> -->

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script type="text/javascript">
  var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-19658054-1']);

  _gaq.push(['_trackPageview']);

  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();
</script>

</body>
</html>