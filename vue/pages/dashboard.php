<?php 
    $page = "Dashboard";
?>

<?php ob_start(); ?> 
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-12">
            <div class="row content-panel">
            <?php 
            switch ($_SESSION['module']) {
              case 'Section':
            ?>
                <div class="col-md-4 profile-text mt mb centered">
                    <div class="right-divider hidden-sm hidden-xs">
                        <h4 id="etudiants-section"></h4>
                        <h6>Effectifs Etudiants</h6>
                        <h4 id="enseignants-section"></h4>
                        <h6>Effectifs Enseignants</h6>
                        <h4 id="ec-section"></h4>
                        <h6>Elements Constitutifs</h6>
                    </div>
                </div>
                <!-- /col-md-4 -->
                <div class="col-md-4 profile-text">
                    <h3 id="designation-section"><?php echo $_SESSION['designation']; ?></h3>
                    <h6 id="chef-section">chef de section</h6>
                    <h3 id="description-section">SEC. JURY : <?php echo "(" . $_SESSION['grade'] . ") " . $_SESSION['nom'] . " " . $_SESSION['post_nom'] . " " . $_SESSION['prenom'] ; ?></h3>
                    <br>
                    <p><button class="btn btn-theme" id="promotions-section"></button></p>
                </div>
                <!-- /col-md-4 -->
            <?php
              
              break;
            case 'Comger':
            ?>
                <div class="col-md-4 profile-text mt mb centered">
                    <div class="right-divider hidden-sm hidden-xs">
                        <h4 id="solde_enrol1"></h4>
                        <h6>Solde Enrollement 1er Semestre</h6>
                        <h4 id="solde_enrol2"></h4>
                        <h6>Solde Enrollement 2nd Semestre</h6>
                        <h4 id="solde_frais"></h4>
                        <h6>Solde Frais Académique</h6>
                    </div>
                </div>
                <!-- /col-md-4 -->
                <div class="col-md-4 profile-text">
                    <h3>COMGER</h3>
                    <h6>Comission de Gérance</h6>
                    <h1><?php echo $_SESSION['grade'] . " (" . $_SESSION['matricule'] . ")"; ?></h1>
                    <br>
                    <p><button class="btn btn-theme" id="frais-academique"><i class="fa fa-home"></i> Montant frais académique : <?php echo $_SESSION['frais_academique']; ?> CDF</button></p>
                </div>
                <!-- /col-md-4 -->
            <?php
                break;
              case 'Titulaire':
            ?>
                <div class="col-md-4 profile-text mt mb centered">
                    <div class="right-divider hidden-sm hidden-xs">
                        <h4 id="students-titulaire">1922</h4>
                        <h6>Cotes étudiants</h6>
                        <h4 id="credits-titulaire">290</h4>
                        <h6>Mes credits</h6>
                        <h4 id="promotions-titulaire">$ 13,980</h4>
                        <h6>Mes &Eacute;lements Constitutifs</h6>
                    </div>
                </div>
                <!-- /col-md-4 -->
                <div class="col-md-4 profile-text">
                    <h3 id="identite-titulaire"><?php echo $_SESSION['nom'] . " " .$_SESSION['post_nom'] . ", " . $_SESSION['prenom'];?></h3>
                    <?php $retVal = ($_SESSION['grade'] == "Ass") ? "Assistant" : $_SESSION['grade'] ;?>
                    <h5 id="grade-titulaire"><?php echo $retVal;?></h5>
                    <h1 id="matricule-titulaire">Matricule : <?php echo $_SESSION['matricule'];?></h1>
                    <br>
                    <?php $retVal = ($_SESSION['statut'] == "temps_plein") ? "PERMANANT" : "VISITEUR" ;?>
                    <p><button class="btn btn-theme" id="statut-titulaire"><i class="fa fa-home"></i> <?php echo $retVal;?></button></p>
                </div>
                <!-- /col-md-4 -->

            <?php
                break;
              case 'Etudiant':
            ?>
                <div class="col-md-4 profile-text mt mb centered">
                    <div class="right-divider hidden-sm hidden-xs">
                        <h4 id="ec-etudiant"><?php echo $_SESSION['enrol_1']; ?> CDF</h4>
                        <h6>Enrollement Mi - Session </h6>
                        <h4 id="credits-etudiant"><?php echo $_SESSION['enrol_2']; ?> CDF</h4>
                        <h6>Enrollement Session</h6>
                        <h4 id="frais-etudiant"><?php echo $_SESSION['frais_academique']; ?> CDF</h4>
                        <h6>Montant payé</h6>
                    </div>
                </div>
                <!-- /col-md-4 -->
                <div class="col-md-4 profile-text">
                    <h3 id="identite-etudiant"><?php echo $_SESSION['nom']; ?> <?php echo $_SESSION['post_nom']; ?> <?php echo $_SESSION['prenom']; ?></h3>
                    <?php $retVal = ($_SESSION['sexe'] == "M") ? "Masculin" : "Féminin"; ?>
                    <h6 id="promotion-etudiant"><?php echo $retVal; ?></h6>
                    <h2 id="description-etudiant"><?php echo $_SESSION['matricule']; ?></h2>
                    <br>
                    <?php
                    if ($_SESSION['statut'] == '0') {
                    ?>
                    <p id="statut-etudiant"><button class="btn btn-danger"><i class="fa fa-home"></i> Irrégulier</button></p>
                    <?php
                    } else {
                      ?>
                      <p id="statut-etudiant"><button class="btn btn-theme"><i class="fa fa-home"></i> Régulier</button></p>
                      <?php
                    }                    
                    ?>
              
                </div>
                <!-- /col-md-4 -->
            <?php
              break; 
            default:
            ?>
            <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                    <h4 id="jury-etudiants">1922</h4>
                    <h6>Effectif Etudiant</h6>
                    <h4 id="jury-ecs">290</h4>
                    <h6>&Eacute;lements Constitutifs</h6>
                    <h4 id="jury-promotions">$ 13,980</h4>
                    <h6>Promotions</h6>
                </div>
            </div>
            <!-- /col-md-4 -->
            <div class="col-md-4 profile-text">
                <h3 id="jury-nom"><?php echo $_SESSION['designation']; ?></h3>
                <h6 id="jury-president">Comission de Gérance</h6>
                <h1 id="jury-mdp"><?php echo $_SESSION['mdp']; ?></h1>
                <br>
                <?php $retVal = ($_SESSION['statut'] == "ON") ? "Ouvert" : "Fermé" ; ?>
                <p><button class="btn btn-theme" id="jury-access"><i class="fa fa-home"></i> <?php echo $retVal; ?></button></p>
            </div>
            <!-- /col-md-4 -->
            <?php
              break;
              } 
            ?>
                <div class="col-md-4 centered">
                    <div class="profile-pic">
                        <p><img src="vue/gabarit/assets/img/ui-sam.jpg" class="img-circle"></p>
                        <p>
                        <button class="btn btn-theme" id="effectifM-ista"></button>
                        <button class="btn btn-theme02" id="effectifF-ista"></button>
                        </p>
                    </div>
                </div>
                <!-- /col-md-4 -->
            </div>
            <!-- /row -->
        </div>
            <!-- /col-lg-12 -->
          <div class="col-lg-12 main-chart">
            <!--CUSTOM CHART START -->
            <?php
            switch ($_SESSION['module']) {
                case 'Section':
            ?>
            <div class="border-head">
              <h3>STATISTIQUES</h3>
            </div>
            <div class="row contenu-bd">

            </div>
            <?php
                    break;
                case 'Comger':
            ?>
            <div class="border-head">
              <h3>STATISTIQUES</h3>
            </div>
            <div class="custom-bar-chart">
              <ul class="y-axis">
                <li><span>4.000.000</span></li>
                <li><span>3.200.000</span></li>
                <li><span>2.400.000</span></li>
                <li><span>1.600.000</span></li>
                <li><span>800.000</span></li>
                <li><span>0</span></li>
              </ul>
              <?php  
              if (isset($dataStat)) {
                # code...
                foreach ($dataStat as $key => $value) {
              ?>
              <div class="bar">
                <div class="title"><?= $value['lblSection']; ?></div>
                <div class="value tooltips" data-original-title="<?= $value['Solde']; ?> CDF" data-toggle="tooltip" data-placement="top"><?= (((float) $value['Solde'])/4000000)*100; ?>%</div>
              </div>
              <?php
                }
              }
              ?>
            <?php
                    break;
                case 'Titulaire':
            ?>
            <div class="row">
              <h3>STATISTIQUES</h3>
            </div>
            <div class="row contenu-bd-tit">

            </div>

            <?php
                    break;
                case 'Etudiant':
            ?>
            
              <div class="row">
                <div class="col-lg-9 main-chart moyAnnuel-etudiant">
                  <!--CUSTOM CHART START -->

                </div>
                <!-- /col-lg-9 END SECTION MIDDLE -->
                <!-- **********************************************************************************************************************************************************
                    RIGHT SIDEBAR CONTENT
                    *********************************************************************************************************************************************************** -->
                <div class="col-lg-3 ds">
                  <!--COMPLETED ACTIONS DONUTS CHART-->
                  <div class="donut-main">
                    <h4>UNITES D'ENSEIGNEMENTS</h4>
                  </div>
                  <?php 
                    foreach ($dataStatSudent as $key => $value) {
                  ?>
                  <div class="desc" data-id="<?= $value['id']; ?>">
                    <div class="thumb">
                      <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                      <p>
                        <muted><?= $value['designation']; ?></muted>
                        <br/>
                        <a href="#"><?= $value['code']; ?></a><br/>
                      </p>
                    </div>
                  </div>

                  <?php 
                    }
                  ?>
                </div>
                <!-- /col-lg-3 -->
              </div>
            <?php
                    break;
                
                default:
            ?>
            <div class="border-head">
              <h3>STATISTIQUES</h3>
            </div>
            <div class="row contenu-bd-jury"></div>
            <?php
                    break;
            }
            ?>
          </div>
        </div>
    </section>
    <!-- /wrapper -->
</section>


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main.php"; ?>