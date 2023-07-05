<?php
$page = "Code d'accèss";
?>

<?php ob_start(); ?> 

    <section class="wrapper">
      <div class="showback">        
        <a type="button" href="index.php?subscrib" class="btn btn-default"><i class="fa fa-angle-left"></i> Retour</a><br/>
      </div>
      <h3>CODE D'ACCESS</h3>
      <!-- row -->
      <div class="row mt">
        <div class="col-md-12">
          <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th><i class="fa fa-user"></i> Nom</th>
                  <th class="hidden-phone"><i class="fa fa-user"></i> Post-nom</th>
                  <th><i class="fa fa-bookmark"></i> CODE</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key => $value) {
                ?>
                <tr>
                  <td></td>
                  <td><h5><?= $value['nom']; ?></h5></td>
                  <td><h5><?= $value['post_nom']; ?></h5></td>
                  <td><h5><?= $value['matricule']; ?></h5></td>
                </tr>
                <?php
                }
                 ?>
              </tbody>
            </table>
          </div>
          <!-- /content-panel -->
        </div>
        <!-- /col-md-12 -->
      </div>
      <!-- /row -->
    </section>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main_access.php"; ?>