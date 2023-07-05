<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ISTA-GM/<?php echo $_SESSION['module']; ?></title>

  <!-- Favicons -->
  <link href="vue/gabarit/assets/img/favicon.png" rel="icon">
  <link href="vue/gabarit/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="vue/gabarit/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="vue/gabarit/assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <link href="vue/gabarit/asets/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
  <link href="vue/gabarit/asets/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
  <link rel="stylesheet" href="vue/gabarit/asets/lib/advanced-datatable/css/DT_bootstrap.css" />
  <!-- Custom styles for this template -->
  <link rel="stylesheet" type="text/css" href="vue/gabarit/assets/css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="vue/gabarit/assets/lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="vue/gabarit/assets/css/style.css" rel="stylesheet">
  <link href="vue/gabarit/assets/css/style-responsive.css" rel="stylesheet">
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
          <li class="sub-menu">
            <a class="itemReleve" href="#">
              <i class="fa fa-book"></i>
              <span>Bulletin</span>
            </a>
            <ul class=""> 
              <li><a href="index.php?releve=1">1er Semestre</a></li> 
              <li><a href="index.php?releve=2">2nd Semestre</a></li>            
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
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->

    <?php echo $contenu; ?>

    <!--main content end-->

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
    <!-- Modal -->
    <div class="modal fade" id="profileUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" id="fermerProfile" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Vérifier et modifier vos informations</h4>
          </div>
          <div class="modal-body">
              <section class="panel">
                <div class="panel-body">
                  <ul class="nav nav-pills nav-stacked mail-nav">
                    <li>
                      <a href="#"> <i class="fa fa-user"></i> <?= $_SESSION['nom']; ?>  
                        <form action="#" class="pull-right mail-src-position">
                          <div class="input-append">
                            <input type="text" class="form-control" id="nomUser" placeholder="Modifier votre Nom">
                          </div>
                        </form>
                      </a>
                    </li>
                    <li>
                      <a href="#"> <i class="fa fa-user"></i> <?= $_SESSION['post_nom']; ?>
                        <form action="#" class="pull-right mail-src-position">
                          <div class="input-append">
                            <input type="text" class="form-control" id="postNomUser" placeholder="Modifier votre Post - nom">
                          </div>
                        </form>
                      </a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-user"></i> <?= $_SESSION['prenom']; ?>
                        <form action="#" class="pull-right mail-src-position">
                          <div class="input-append">
                            <input type="text" class="form-control" id="preNomUser" placeholder="Modifier votre Prenom">
                          </div>
                        </form>
                      </a>
                    </li>
                    <li>
                      <?php $sexeUser = ($_SESSION['sexe'] == "M") ? "Masculin" : "Féminin"; ?>
                      <a href="#"> <i class="fa fa-info"></i> <?= $sexeUser; ?> 
                        <form action="#" class="pull-right mail-src-position">
                          <div class="input-append">
                            <select class="form-control" id="sexeUser">
                                <option class="form-control" value="M"></i> Masculin</option>
                                <option class="form-control" value="F"></i> Feminin</option>
                            </select>
                          </div>                                      
                        </form>
                      </a>
                    </li>
                  </ul>
                  <button type="button" class="btn btn-compose" id="validProfile"><i class="fa fa-pencil"></i>  METTRE &Agrave; JOUR</button>
                </div>
              </section>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="vue/gabarit/assets/lib/jquery/jquery.min.js"></script>

  <script src="vue/gabarit/assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script class="include" type="text/javascript" src="vue/gabarit/assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.scrollTo.min.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="vue/gabarit/assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="vue/gabarit/assets/lib/common-scripts.js"></script>
  <script type="text/javascript" src="vue/gabarit/assets/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="vue/gabarit/assets/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="vue/gabarit/assets/lib/sparkline-chart.js"></script>
  <script src="vue/gabarit/assets/lib/zabuto_calendar.js"></script>
  <script type="text/javascript" language="javascript" src="vue/gabarit/assets/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="vue/gabarit/assets/lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
  <script>
    $(document).ready(function(){ 

    $('.itemReleve').click(function(e){     
      $.post(
          "./controleur/php/API.php",
          { 
              statutEtudiant: "All"
          },
          function(response){
              let respJSON = JSON.parse(response)
              if(respJSON.data.frais_academique==500000 && respJSON.data.enrol_1==25000 && respJSON.data.enrol_2==25000){
                  alert("Bonne chance et courrage...")
              }else{
                  alert("Vous n'êtes pas en ordre...")
                  window.location.replace("index.php")
              }
              
          }
      )
    })

    function getAllSections(){
      $.post(
        "./controleur/php/API.php",
        {
          sectionsAB: "all"
        },
        function(data){
              let dataJSON = JSON.parse(data)
              //console.log(dataJSON.data)
              //alert($('.list-promotion').html())
              $('.list-sections').html(" ")
              let contenu = " "
              $.each(dataJSON.data, function(key, value){
                contenu += '<li ><a href="index.php?section='+value.id+'&col=1">'+value.designation+'</a></li>'
                //alert($('.list-promotion').html())
              })
              $('.list-sections').append(contenu)

        }
      )        
    }
    getAllSections()
    setInterval(getAllSections,10000)

    function getAllPromotions(){
      $.post(
        "./controleur/php/API.php",
        {
          promoOfSection: "all"
        },
        function(data){
              let dataJSON = JSON.parse(data)
              $('.list-promotion').html(" ")
              let contenu = " "
              $.each(dataJSON.data, function(key, value){
                contenu += '<li ><a href="index.php?promotion='+value.promo+'&col=1">'+value.class+'</a></li>'
              })
              $('.list-promotion').append(contenu)

        }
      )        
    }
    getAllPromotions()
    setInterval(getAllPromotions,10000)

    function getAllGrille(){
      $.post(
        "./controleur/php/API.php",
        {
          grille: "all"
        },
        function(data){
              let dataJSON = JSON.parse(data)
              //console.log(dataJSON.data)
              //alert($('.list-promotion').html())
              $('.list-grille').html(" ")
              let contenu = " "
              $.each(dataJSON.data, function(key, value){
                contenu += '<li ><a href="index.php?grille='+value.promo+'">'+value.class+'</a></li>'
                //alert($('.list-promotion').html())
              })
              $('.list-grille').append(contenu)

        }
      )        
    }
    getAllGrille()
    setInterval(getAllGrille,10000)
      
    function getAllFiches(){
      $.post(
        "./controleur/php/API.php",
        {
          fichesCotes: "all"
        },
        function(data){
              let dataJSON = JSON.parse(data)
              console.log(dataJSON.data)
              //alert($('.list-promotion').html())
              $('.list-fiches').html(" ")
              let contenu = " "
              $.each(dataJSON.data, function(key, value){
                contenu += '<li ><a class ="itemFiche" href="index.php?fiche='+value.id+'&matiere='+value.id_matiere+'">'+value.intitule+' (' + value.class + ')</a></li>'
                //alert($('.list-promotion').html())
              })
              $('.list-fiches').append(contenu)

              $('.itemFiche').click(function(){
                $(this).addClass('active')
              })

        }
      )        
    }
    getAllFiches()
    setInterval(getAllFiches,10000)

    $('#fermerProfile').click(function(e){
      e.preventDefault()
      location.replace("index.php")
    })

    $('#validProfile').click(function(e){
      e.preventDefault()

      let dataForm = {
        nom: $('#nomUser').val(),
        post_nom: $('#postNomUser').val(),
        prenom: $('#preNomUser').val(),
        sexe: $('#sexeUser').val()
      }
      $.post(
        "./controleur/php/API.php",
        {
          updateUser: dataForm
        },
        function(data){
          let dataJSON = JSON.parse(data)
          
          if(dataJSON.code == 200){                  
            location.replace("index.php")
          }else{
            alert("Un problème est survenu lors de la modification...!")                             
            location.replace("index.php")
          }
        }
      )
    })
  })
  </script>
  <?php 
  switch ($page) {
    case 'Dashboard':
  ?>
  <script src="vue/gabarit/assets/lib/chart-master/Chart.js"></script>
  <script src="controleur/js/dashboard.js"></script>
  <?php 
      break;
    
    case 'Promotion':  
?>
 <script src="controleur/js/promotion.js"></script>
<?php 
      break;
    
    case 'Fiches':  
?>
 <script src="controleur/js/fiche.js"></script>
<?php 
      break;
    
    case 'Grilles':  
?>
 <script src="controleur/js/grille.js"></script>
<?php
      break;

    case 'Bulletin':  
?>
 <script src="controleur/js/releve.js"></script>
<?php
    
    break;
    default:
?>
     <script src="controleur/js/comger.js"></script>
<?php 
      break;
  }
?>
</body>

</html>
