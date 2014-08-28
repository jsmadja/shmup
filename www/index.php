<?php 
session_start();
// Includes
include("_connexion.php");
include("_functions.php");
include("_scripts.php");
?>

<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width" />
  <title><?php echo $pageTitle; ?></title>
  <meta name="description" content="<?php echo $pageMeta; ?>">
  <link rel="stylesheet" type="text/css" href="https://lama-dev.splio.com/?s=<?php echo $_SESSION['s']; ?>" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/shmup.css" media="screen" />
  <script type="text/javaScript" src="https://lama.splio.com/resources/js/jquery-1.9.1.min.js"></script>
  <script type="text/javaScript" src="https://lama.splio.com/resources/js/bootstrap-dropdown.js"></script>
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
</head>

<body class="bg-theme">

<div class="set-black overflow-hidden">

  <!-- NAVBAR -->
  <div class="navbar padding-left-20 padding-right-20 <?php echo $bodyWidth; ?>" id="shmup_nav">
     <div class="col-4">
        <span class="title"><a href="index.php">Shmup.com</a></span>
    </div>
    
    <div class="col-8">

        <ul class="nav">
          <li class="<?php echo $nav_blog; ?>"><a href="blog.html">Blog</a></li>
          <li class="<?php echo $nav_jeux; ?>"><a href="index-des-jeux.html">Jeux</a></li>
          <li class="<?php echo $nav_dossiers; ?>"><a href="#">Dossiers</a></li>
          <li class="<?php echo $nav_dico; ?>"><a href="dictionnaire.html">Dico</a></li>
          <li class="<?php echo $nav_team; ?>"><a href="team.html">Team</a></li>
          <li class="<?php echo $nav_liens; ?>"><a href="#">Liens</a></li>
          <li class="" id="nav_settings"><a class="padding-left-5 padding-right-5" href="#"><i class="icon-cogs"></i></a></li>
        </ul>

    </div>
  </div>

</div>

<!-- bandeau -->
<div id="animate-header-1" class="<?php echo $bodyWidth; ?> overflow-hidden position-relative box-shadow-inset-big">
  <img id="logo" src="images/logo/logo.png" />
  <div class="ship"></div>
  <div id="background-1"></div>
  <div id="background-2"></div>
  <div id="background-3"></div>
</div>


<div class="<?php echo $bodyWidth; ?> padding-10 padding-bottom-none set-light border-right-none border-left-none overflow-hidden" id="settings">
  <div class="col-4">
      <div class="col-content text-align-center">
        <h2 class="margin-top-20 color-dark"><i class="icon-cogs"></i>&nbsp;Options</h2>
      </div>
    </div>

    <div class="col-8">
      <div class="col-content">
        <form>
          <fieldset class="">
            <p>
              <label>Thème couleur :</label>
              <select name="colorTheme" id="colorTheme">
                <option>Thèmes</option>
                <option value="?s=">Blue</option>
                <option value="?s=green">Green</option>
                <option value="?s=purple">Purple</option>
                <option value="?s=lilac">Lilac</option>
                <option value="?s=orange">Orange</option>
                <option value="?s=pink">Pink</option>
                <option value="?s=teal">Teal</option>
                <option value="?s=black">Black</option>
              </select>
            </p>
            <p>
              <label>Largeur site :</label>
              <select name="bodyWidth" id="bodyWidth">
                <option>Largeur</option>
                <option value="?w=">80%</option>
                <option value="?w=1">100%</option>
              </select>
            </p>
          </fieldset>
        </form>
      </div>
    </div>

</div>

<div class="<?php echo $bodyWidth; ?> bg-white">

  <section class="col-group" id="section-home">

    <div class="col-4">
      <div class="col-content">
        <?php 
        include('_module_navigation.php');
        include('_module_lastposts.php');
        include('_module_lasttests.php');
        ?>
      </div>
    </div>

    <div class="col-8">
      <div class="col-content">

        <?php if (file_exists("./".$page.".php") AND !strstr($page, "admin/")) 
          { include("./".$page.".php");}
        else
          { include("./page_home.php");}
        ?>

      </div>
    </div>

  </section>

</div>

<!-- JS at the bottom of the page -->
<script type="text/javaScript">

function animateShip(direction) 
{
  if (direction == 'top') {
    $('.ship').stop().removeClass('goingUp goingDown goingLeft goingRight').addClass('goingUp').animate({ 
      top: "-=40px"
    }, 500, function() {
      // Animation complete.
      $('.ship').removeClass('goingUp goingDown goingLeft goingRight');
    });
  }

   if (direction == 'bottom') {
    $('.ship').stop().removeClass('goingUp goingDown goingLeft goingRight').addClass('goingDown').animate({ 
      top: "+=40px"
    }, 500, function() {
      // Animation complete.
      $('.ship').removeClass('goingUp goingDown goingLeft goingRight');
    });
  }

  if (direction == 'left') {
    $('.ship').stop().removeClass('goingUp goingDown goingLeft goingRight').addClass('goingLeft').animate({ 
      left: "-=40px"
    }, 500, function() {
      // Animation complete.
      $('.ship').removeClass('goingUp goingDown goingLeft goingRight');
    });
  }

  if (direction == 'right') {
    $('.ship').stop().removeClass('goingUp goingDown goingLeft goingRight').addClass('goingRight').animate({ 
      left: "+=40px"
    }, 500, function() {
      // Animation complete.
      $('.ship').removeClass('goingUp goingDown goingLeft goingRight');
    });
  }
}

  $(document).keydown(function(e){
      if (e.keyCode == 38) { 
         animateShip('top');
         return false;
      }

      if (e.keyCode == 40) { 
         animateShip('bottom');
         return false;
      }

      if (e.keyCode == 37) { 
         animateShip('left');
         return false;
      }

      if (e.keyCode == 39) { 
         animateShip('right');
         return false;
      }
  });


$(document).ready(function() {

  $('#colorTheme, #bodyWidth').change( function() {
    var that = $(this);
    $('#settings').slideUp('fast', function() {
      window.location.href=that.val();
    });
  });

  $('#nav_settings').click( function() {
    $(this).toggleClass('is-active');
    $('#settings').slideToggle();
  });

  $("#subnav li a").hover(
    function () {
      $(this).toggleClass('bg-light');
    },
    function () {
      $(this).toggleClass('bg-light');
    }
  );

  $(".clickable").addClass('cursor-pointer').on('click', function(e) {
    var clicked = $(this);
      if (e.ctrlKey)      { window.open($(this).attr("data-url")); }
      else if (e.altKey)    { window.open($(this).attr("data-url"), 'GT', 'toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=yes, status=no, directories=no, width=960, height=700'); }
    else          { 
      if (clicked.hasClass('newTab')) {
        window.open($(this).attr("data-url"));
      }
      else {
        window.location = $(this).attr("data-url"); 
      }
    }
      return false;
  });

});
</script>


</body>

</html>
