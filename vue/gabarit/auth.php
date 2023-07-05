<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>ISTA-GM/AUTHENTIFICATION</title>

  <!-- Favicons -->
  <link href="vue/gabarit/assets/img/favicon.png" rel="icon">
  <link href="vue/gabarit/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="vue/gabarit/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="vue/gabarit/assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="vue/gabarit/assets/css/style.css" rel="stylesheet">
  <link href="vue/gabarit/assets/css/style-responsive.css" rel="stylesheet">
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
        <?= $contenu; ?>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="vue/gabarit/assets/lib/jquery/jquery.min.js"></script>
  <script src="vue/gabarit/assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="vue/gabarit/assets/lib/jquery.backstretch.min.js"></script>
  <script>
    $.backstretch("vue/gabarit/assets/img/login-bg.jpg", {
      speed: 500
    });
  </script>
  <?php
  if ($page == "ACADEMIQUE") {
?>
<script type="text/javascript" src="controleur/js/academique.js"></script>
<?php
  }
?>
</body>

</html>
