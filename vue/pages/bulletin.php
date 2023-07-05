<?php 
    $page = "Bulletin";
?>

<?php ob_start(); ?> 

    <section id="main-content">
      <section class="wrapper">
        <div class="col-lg-12 mt">
          <div class="row content-panel">
            <div class="col-lg-10 col-lg-offset-1">
              <div class="invoice-body donneesReleve">
                <div class="pull-left"><br /><br />
                  <strong>République Démocratique du Congo</strong>
                  <address>
                <strong>Ministère de l'Enseignement Supérieur et Universitaire</strong><br>
                Institu Supérieur de Techniques Appliquées/Gombe - Matadi<br>
                ISTA/GM (à Mbanza - Ngungu)<br>
                Arrêté : N°MINESURS/CABMIN/043/2008
              </address>
                </div>
                <!-- /pull-left -->
                <div class="pull-right">
                    <img src="vue/gabarit/assets/img/ui-sam.jpg" class="img-circle">
                </div>
                <!-- /pull-right -->
                <div class="clearfix"></div>
                <br>
                <br>
                <br>
                <div class="row">
                  <div class="col-md-9">
                    <h4 ><?= $_SESSION['nom'] . " " . $_SESSION['post_nom'] . " " . $_SESSION['prenom']; ?></h4>
                    <address>
                  <strong id="matriculeRel">Sexe : <?= $_SESSION['sexe'] ?></strong><br>
                  Niveau : <?= $infosBulletin['intitule']; ?><br>
                  Section : <?= $infosBulletin['lblSection']; ?><br>
                  Système : <?= $infosBulletin['lblSysteme']; ?>
                </address>
                  </div>
                  <!-- /col-md-9 -->
                  <div class="col-md-3">
                    <br>
                    <div>
                      <div class="pull-left"> N° BULLETIN : </div>
                      <div class="pull-right"> <?= $infoReleve['num_ref']; ?> </div>
                      <div class="clearfix"></div>
                    </div>
                    <div>
                      <!-- /col-md-3 -->
                      <div class="pull-left"> ANNEE : </div>
                      <div class="pull-right"> <?= $infoReleve['debut']; ?> - <?= $infoReleve['fin']; ?> </div>
                      <div class="clearfix"></div>
                    </div>
                    <!-- /row -->
                    <br>
                    
                    <div class="well well-small green">
                      <div class="pull-left">DECISION </div>
                      <div class="pull-right decision-jury">DU JURY : <?= $jury; ?></div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                  <!-- /invoice-body -->
                </div>
                <!-- /col-lg-10 -->
                <table class="table lmd">
                  <thead>
                    <tr>
                      <th style="width:60px" class="text-center">N°</th>
                      <th class="text-left">ELEMENTS CONSTITUTIFS(MATIERES)</th>
                      <th style="width:140px" class="text-right">TP</th>
                      <th style="width:140px" class="text-right">TD</th>
                      <th style="width:140px" class="text-right">EXAMEN</th>
                      <th style="width:90px" class="text-right">CREDIT</th>
                      <th style="width:90px" class="text-right">TOT</th>
                      <th style="width:90px" class="text-right">TOT-P</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $maxSemestre = 0;
                  $obtSemestre = 0;
                  foreach ($dataCotes as $key => $value) {
                  ?>
                  <tr>
                    <td class="text-center"><?= $key + 1; ?></td>
                    <td><?= $value['cours']; ?></td>
                    <td class="text-right"><?= $value['tp']; ?></td>
                    <td class="text-right"><?= $value['td']; ?></td>
                    <td class="text-right"><?= $value['examen']; ?></td>
                    <td class="text-right"><?= $value['credit']; ?></td>
                    <?php
                    if (isset($value['tp']) AND isset($value['td']) AND isset($value['examen'])) {
                        $tot = $value['tp'] + $value['td'] + $value['examen'];
                        $tot_p = $tot*$value['credit'];
                        $maxSemestre = $maxSemestre + 20*$value['credit'];
                        $obtSemestre += $tot_p;
                    ?>
                    <th style="width:90px" class="text-right"><?= $tot ?></th>
                    <th style="width:90px" class="text-right"><?= $tot_p ?></th>
                    <?php
                    } else {
                        $tot = "-";
                        $tot_p = "-";  
                    ?>
                    <th style="width:90px" class="text-right"><?= $tot ?></th>
                    <th style="width:90px" class="text-right"><?= $tot_p ?></th>
                    <?php
                    }
                    ?>
                  </tr>
                  <?php
                  }
                  ?>
                    <tr>
                    <?php 
                      if($infosBulletin['lblSysteme'] == "LMD"){
                    ?>
                    <td colspan="6" rowspan="6"><?php
                  }else{
                    ?>
                    <td colspan="6" rowspan="8">
                    <?php 
                      }
                    ?>
                        <h4>Avertissement</h4>
                        <p>Le recours est acceptable dans le 72h qui suivent la publication officielle des resultats.</p>                      
                        <button class="well well-small green printBtn"><i class="fa fa-print"></i><strong> Imprimer</strong></button>
                      </td>
                    </tr>
                    <?php 
                      if($infosBulletin['lblSysteme'] == "LMD"){
                    ?>
                    <tr>
                      <td class="text-right"><strong>NCV</strong></td>
                      <td class="text-right"><?= $dataCredits['ncv']; ?></td> 
                    </tr>
                    <tr>
                      <td class="text-right no-border"><strong>NCNV</strong></td>
                      <td class="text-right"><?=  $dataCredits['ncnv']; ?></td>
                    </tr>
                    <tr>
                      <td class="text-right no-border"><strong>MAXIMUM </strong></td>
                      <td class="text-right"><?= $maxSemestre; ?></td>
                    </tr>
                    <tr>
                      <td class="text-right no-border">
                        <div class="text-right"><strong>TOTAL</strong></div>
                      </td>
                      <td class="text-right"><strong><?= $obtSemestre; ?></strong></td>
                    </tr>
                    <tr>
                      <td class="text-right no-border">
                        <div class="well well-small green"><strong>Pourcentage</strong></div>
                      </td>
                      <td class="text-right"><strong><?= $pourcentage; ?>%</strong></td>
                    </tr>

                    <?php
                      }else{
                        ?>
                        <tr>
                          <td class="text-right"><strong>Echec(s) leger(s)</strong></td>
                          <td class="text-right"><?= $counterLegers; ?></td> 
                        </tr>
                        <tr>
                          <td class="text-right no-border"><strong>Echec(s) grave(s)</strong></td>
                          <td class="text-right"><?= $counterGraves; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right no-border"><strong>Manque des cotes</strong></td>
                          <td class="text-right"><?= $counterManque; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right no-border"><strong>MAXIMUM </strong></td>
                          <td class="text-right"><?= $maxSemestre; ?></td>
                        </tr>
                        <tr>
                          <td class="text-right no-border">
                            <div class="text-right"><strong>TOTAL</strong></div>
                          </td>
                          <td class="text-right"><strong><?= $obtSemestre; ?></strong></td>
                        </tr>
                        <tr>
                          <td class="text-right no-border">
                            <div class="well well-small green"><strong>Pourcentage</strong></div>
                          </td>
                          <td class="text-right"><strong><?= round($pourcentage,2); ?>%</strong></td>
                        </tr>

                    <?php 
                      }
                    ?>
                    
                  </tbody>
                </table>
                <br>
                <br>
              </div>
              <!--/col-lg-12 mt -->
      </section>
      <!-- /wrapper -->
    </section>


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main.php"; ?>