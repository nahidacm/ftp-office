<?php require_once ("includes/header.php"); ?>

  <div id="container" data-role="page" >
    
    <header>
    
      <div class="upperMenu">
        <?php include("includes/inner-menu.php"); ?>
      </div>
      
      <div id="header">
        <a href="blog.php" class="homeButton" data-direction="reverse"></a>
        <a href="#" class="menuButton"></a>
        <h1> Blog</h1>
        <h2> Company Name, Service Sector</h2>
        <!--<a href="contact.php" class="nextButton">&raquo;</a>-->
      </div>
    </header>

    <!--
    <div id="main" role="main">
    </div>
    -->
    
    <div id="pageBlog" class="page">
      
  
    <!-- if you want a header -->
    <!--
      <div class="content">
          <div class="groupBox innerContent">
            
            <div id="banner" class="flexslider">
              <ul class="slides">
                <li>
                  <img src="img/blog.jpg" />
                </li>
              </ul>
            </div>
              
          </div>
      </div>
      -->
  
          <div class="clearfix"></div>
          <div class="blogDetail">
          <ul>
            <li>
            <div class="groupBox innerContent">
              <div class="postDetails">
                <div class="title">
                  We have rolled out
                </div>
                <a class="thumb" href="blog-detail.php">
                  <img src="img/slides/6.jpg" alt="Post 1">
                </a>
              </div>
              
              <div class="description">
                <div class="about">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
              </div>
              <div class="clearfix"></div>
              
              
              <div class="tags left">
                <a class="category" href="#"> News </a>
                <a class="date" href="#"> 1 Aug 2012</a>
                <a class="writer" href="#"> Josh Jonah</a>
                <div class="clearfix"></div>
              </div>
              
              <div class="clearfix"></div>
            </div>
            
          </li>
            </ul>
          </div>
    </div>
    <div class="clearfix"></div>

    


<?php require_once ("includes/footer.php");