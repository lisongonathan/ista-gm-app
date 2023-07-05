<?php 
    $page = "Comger";
    $id = (int) $_GET['section'];
?>

<?php ob_start(); ?> 

    <section id="main-content">
      <section class="wrapper site-min-height">
        <div class="row mt mb">
          <div class="col-lg-12">
            <h3><?= $currentSection['designation']; ?></h3>
            <br>
            <div class="col-lg-4 col-md-4 col-sm-12 active">
              <div class="dmbox">
                <div class="service-icon">
                  <a class="" href="?section=<?= $id; ?>&col=1"><i class="dm-icon fa fa-money fa-3x"></i></a>
                </div>
                <h4>1. Frais académique</h4>
                <h1>500 000 CDF</h1>
              </div>
            </div>
            <!-- end dmbox -->
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="dmbox active">
                <div class="service-icon">
                  <a class="" href="?section=<?= $id; ?>&col=2"><i class="dm-icon fa fa-angle-double-right fa-3x"></i></a>
                </div>
                <h4>2. Enrolement Mi - Session</h4>
                <h1>25 000 CDF</h1>
              </div>
            </div>
            <!-- end dmbox -->
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="dmbox">
                <div class="service-icon">
                  <a class="" href="?section=<?= $id; ?>&col=3"><i class="dm-icon fa fa-folder-open-o fa-3x"></i></a>
                </div>
                <h4>3. Enrolement Session</h4>
                <h1>25 000 CDF</h1>
              </div>
            </div>
            <!-- end dmbox -->
          </div>
          <!--  /col-lg-12 -->
        </div>
        <!-- /row -->
            <div class="col-lg-12 mt">
              <div class="row content-panel">
                <div class="panel-heading">
                  <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                      <a data-toggle="tab" href="#overview">ETUDIANT IRREGULIER</a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#contact" class="contact-map">ETUDIANT REGULIER</a>
                    </li>
                  </ul>
                </div>
                <!-- /panel-heading -->
                <div class="panel-body">
                  <div class="tab-content">
                    <div id="overview" class="tab-pane active">
                      <div class="row">
                        <div class="col-sm-3">
                          <section class="panel">
                            <div class="panel-body">
                              <ul class="nav nav-pills nav-stacked mail-nav">
                              <?php 
                              foreach ($dataSection as $key => $value) {
                                ?>
                                <li data-id="<?= $value['promo']; ?>"><a href="#"> <i class="fa fa-home"></i> <?= $value['class']; ?></a></li>
                                <?php
                              }
                              ?>
                              </ul>
                            </div>
                          </section>
                        </div>
                        <div class="col-sm-9">
                            <header class="panel-heading wht-bg">
                              <h4 class="gen-case">
                                  <?php 
                                  switch ($_GET['col']) {
                                    case '1':
                                  ?>
                                  <span> FRAIS ACADEMIQUE</span>
                                  <?php
                                      break;
                                    case '2':
                                  ?>
                                  <span> ENROLLEMENT MI - SESION</span>
                                  <?php
                                      break;
                                    case '3':
                                  ?>
                                  <span> ENROLLEMENT SESION</span>
                                  <?php
                                      break;
                                    
                                    default:
                                      header('Location:index.php?erreur="Cette page n\'est pas disponible"');
                                      break;
                                  }
                                  ?>
                                  
                                  <form action="#" class="pull-right mail-src-position">
                                    <div class="input-append">
                                      <input type="text" class="form-control find-student" placeholder="Rechercher...">
                                    </div>
                                  </form>
                                </h4>
                            </header>
                            <div class="panel-body minimal">
                              <div class="table-inbox-wrap ">
                                <table class="table table-inbox table-hover">
                                  <tbody class="list-items-irregulier">         
                              <?php 
                              foreach ($listStudentICurrentSection as $key => $value) {
                                ?>
                                <tr class="unread">
                                  <td class="inbox-small-cells">
                                    <input type="checkbox" data-id="<?= $value['matricule']; ?>" class="mail-checkbox irregulier">
                                  </td>
                                  <td class="view-message  nom"><a href="#"><?= $value['nom']; ?></a></td>
                                  <td class="view-message  post_nom"><a href="#"><?= $value['post_nom']; ?></a></td>
                                  <td class="view-message  prenom"><a href="#"><?= $value['prenom']; ?></a></td>
                                  <td class="view-message  matricule"><a href="#"><?= $value['matricule']; ?></a></td>
                                  <td class="view-message  text-right"><?= $value['solde']; ?></td>
                                </tr>
                                <?php
                              }
                              ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                      </div>
                      <!-- /OVERVIEW -->
                    </div>
                    <!-- /tab-pane -->
                    <div id="contact" class="tab-pane">
                      <div class="row">
                        <div class="col-sm-3">
                          <section class="panel">
                            <div class="panel-body">
                              <ul class="nav nav-pills nav-stacked mail-nav">
                              <?php
                              foreach ($dataSection as $key => $value) {
                                ?>
                                <li data-id="<?= $value['promo']; ?>"><a href="#"> <i class="fa fa-home"></i> <?= $value['class']; ?></a></li>
                                <?php
                              }
                              ?>
                              </ul>
                            </div>
                          </section>
                        </div>
                        <div class="col-sm-9">
                          <section class="panel">
                            <header class="panel-heading wht-bg">
                              <h4 class="gen-case">
                                  <?php 
                                  switch ($_GET['col']) {
                                    case '1':
                                  ?>
                                  <span> FRAIS ACADEMIQUE</span>
                                  <?php
                                      break;
                                    case '2':
                                  ?>
                                  <span> ENROLLEMENT MI - SESION</span>
                                  <?php
                                      break;
                                    case '3':
                                  ?>
                                  <span> ENROLLEMENT SESION</span>
                                  <?php
                                      break;
                                    
                                    default:
                                    header('Location:index.php?erreur="Cette page n\'est pas disponible"');
                                      break;
                                  }
                                  ?>
                                  <form action="#" class="pull-right mail-src-position">
                                    <div class="input-append">
                                      <input type="text" class="form-control find-student" placeholder="Rechercher...">
                                    </div>
                                  </form>
                                </h4>
                            </header>
                            <div class="panel-body minimal">
                              <div class="table-inbox-wrap ">
                                <table class="table table-inbox table-hover">
                                  <tbody>         
                              <?php 
                              foreach ($listStudentRCurrentSection as $key => $value) {
                                ?>
                                    <tr class="">
                                  <td class="inbox-small-cells">
                                    <input type="checkbox" class="mail-checkbox regulier" checked>
                                  </td>
                                  <td class="view-message  dont-show"><a href="#"><?= $value['nom']; ?></a></td>
                                  <td class="view-message  dont-show"><a href="#"><?= $value['post_nom']; ?></a></td>
                                  <td class="view-message  dont-show"><a href="#"><?= $value['prenom']; ?></a></td>
                                  <td class="view-message  dont-show"><a href="#"><?= $value['matricule']; ?></a></td>
                                  <td class="view-message  text-right"><?= $value['solde']; ?></td>
                                    </tr>
                                <?php
                              }
                              ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </section>
                        </div>
                      </div>
                      <!-- /row -->
                    </div>
                    <!-- /tab-pane -->
                  </div>
                  <!-- /tab-content -->
                </div>
                <!-- /panel-body -->
              </div>
              <!-- /col-lg-12 -->
            </div>
        <!--  /row -->
      </section>
      <!-- /wrapper -->
    </section>


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main.php"; ?>