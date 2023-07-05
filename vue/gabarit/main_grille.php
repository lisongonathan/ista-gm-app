<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>ISTA-GM/<?php echo $_SESSION['module']; ?></title>

  <!-- Favicons -->
  <link href="vue/gabarit/assets/img/favicon.png" rel="icon">
  <link href="vue/gabarit/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="vue/gabarit/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="vue/gabarit/assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <!-- Custom styles for this template -->
  <link href="vue/gabarit/assets/css/style.css" rel="stylesheet">
  <link href="vue/gabarit/assets/css/style-responsive.css" rel="stylesheet">
  <script src="vue/gabarit/assets/lib/chart-master/Chart.js"></script>

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.php" class="logo"><b>ISTA/<span>GM</span></b></a>
      <!--logo end-->
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="index.php?deconnexion">Se deconnecter</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="javascript:;"><img src="vue/gabarit/assets/img/ui-sam.jpg" class="img-circle" width="80"></a></p>
          <h5 class="centered">ISTA de Gombe - Matadi</h5>
          <li class="mt">
            <a class="dashboard" href="index.php">
              <i class="fa fa-dashboard"></i>
              <span>Tableau de bard</span>
              </a>
          </li>
        
        <?php if ($_SESSION['module'] == "Section") {
        ?>
            <!-- PROMOTIONS -->
            <li class="sub-menu choixPromotion">
                 <a href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Promotions</span>
                </a>
                <ul class="list-promotion">
                </ul>
            </li>
        <?php 
        } ?>
        
        
        <?php if ($_SESSION['module'] == "Jury") {
        ?>
            <!-- PROMOTIONS -->
            <li class="sub-menu choixPromotion">
                 <a class="items_grille" href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Grille(s)</span>
                </a>
                <ul class="list-grille">
                </ul>
            </li>
        <?php 
        } ?>
        
        <?php if ($_SESSION['module'] == "Comger") {
        ?>
          <!-- SECTIONS -->
            <li class="sub-menu">
                 <a class="choixPromotion" href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Sections</span>
                </a>
                <ul class="list-sections">
                </ul>
            </li>
        <?php 
        } ?>
        
        <?php if ($_SESSION['module'] == "Titulaire") {
        ?>

          <!-- COURS -->
          <li class="sub-menu">
            <a class="itemsFiches" href="javascript:;">
              <i class="fa fa-book"></i>
              <span>Fiches de cotation</span>
              </a>
            <ul class="list-fiches">              
            </ul>
          </li>
          <li>
            <a href="#" data-toggle="modal" data-target="#profileUser">
              <i class="fa fa-user"></i>
              <span>Profile </span>
              </a>
          </li>
        <?php 
        } ?>
        <?php if ($_SESSION['module'] == "Etudiant") {
        ?>

          <!-- COURS -->
          <li>
            <a class="itemReleve" href="#">
              <i class="fa fa-book"></i>
              <span>Releve des cotes</span>
              </a>
          </li>
          <li>
            <a href="#" data-toggle="modal" data-target="#profileUser">
              <i class="fa fa-user"></i>
              <span>Profile </span>
              </a>
          </li>
        <?php 
        } ?>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->

        <?php echo $contenu; ?>

    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
          &copy; Copyrights <strong>Dashio</strong>. All Rights Reserved
        </p>
        <div class="credits">
          <!--
            You are NOT allowed to delete the credit link to TemplateMag with free version.
            You can delete the credit link only if you bought the pro version.
            Buy the pro version with working PHP/AJAX contact form: https://templatemag.com/dashio-bootstrap-admin-template/
            Licensing information: https://templatemag.com/license/
          -->
          Created with Dashio template by <a href="https://templatemag.com/">TemplateMag</a>
        </div>
        <a href="index.php#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="vue/gabarit/assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="vue/gabarit/assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.scrollTo.min.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="vue/gabarit/assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="vue/gabarit/assets/lib/common-scripts.js"></script>
  <!--script for this page-->
  <script src="vue/gabarit/assets/lib/sparkline-chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#hidden-table-info').DataTable({
        language: {
            lengthMenu: 'Lignes _MENU_ par page',
            zeroRecords: 'Desolé aucune correspondance n\'a été trouver',
            info: 'Page _PAGE_ sur _PAGES_',
            infoEmpty: 'No records available',
        },
        scrollX: true,
      });

      

      $('.showGrille').click(function (e) {
        e.preventDefault()
        var currentUrl = window.location.href
        console.log(currentUrl)
        window.location.href=currentUrl + '&detail'
      })
    });
  </script>
</body>

</html>
