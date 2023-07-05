<?php 
    $page = "Grilles";
?>

<?php ob_start(); ?> 
  <section id="main-content">
    <section class="wrapper">
      <div class="row mt">
        <div class="col-sm-3">
          <section class="panel">
            <div class="panel-body">
              <a href="#" class="btn btn-compose">
                <i class="fa fa-pencil"></i>  MES PROMOTIONS
              </a>
              <ul class="nav nav-pills nav-stacked mail-nav">
              <?php
              foreach ($dataECS as $key => $value) {
              ?>  
              <li class="itemsCurrentEC" data-id="<?= $value['id']; ?>"><a href="#"> <i class="fa fa-file-text-o"></i> <?= $value['intitule']; ?> </a></li>
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
                    Grille de deliberation
                    <form action="#" class="pull-right mail-src-position">
                      <div class="input-append">
                        <input type="text" class="form-control find-student" placeholder="Trouver un étudiant">
                      </div>
                    </form>
                  </h4>
              </header>
              <div class="panel-body minimal">                 
                <div class="accordion itemsFicheStudents" id="accordion2">
                </div>
              </div>
            </section>
          </div>
      </div>
    </section>
    <!-- /wrapper -->
  </section>


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main.php"; ?>