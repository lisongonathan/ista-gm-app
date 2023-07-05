<?php 
    $page = "Deliberation"
?>

<?php ob_start(); ?> 
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="chat-room mt">
          <aside class="mid-side">
            <div class="chat-room-head">
              <h3>Aprréciation: <?= $ap; ?></h3>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Inritulé</th>
                  <th>M-TP</th>
                  <th>M-TD</th>
                  <th>E</th>
                  <th>TOT</th>
                  <th>Credit</th>
                  <th>TOT-P</th>
                </tr>
              </thead>
              <tbody>
            <?php
            foreach ($dataCours as $key => $value) {
                $data = getCoteEtudiant($student, $value['id']);
                if (isset($data['tp'])) {
                    $tp = $data['tp'];
                } else {
                    $tp = "-";
                }
                if (isset($data['td'])) {
                    $td = $data['td'];
                } else {
                    $td = "-";
                }
                if (isset($data['tp']) OR isset($data['td']) AND isset($data['examen'])) {
                    $examen = $data['examen'];
                    $tot = $tp + $td + $examen;
                    $tot_p = $tot*$value['credit'];
                } else {
                    $examen = "";
                    $tot = "-";
                    $tot_p = "-";
                }                
                
            ?>
                <tr class="cours" data-id="<?= $value['id'] ?>">
                    <td><?= $key + 1 ?></td>
                    <td class="intitule"><?= $value['intitule'] ?></td>
                    <td class="tp"><?= $tp ?></td>
                    <td class="td"><?= $td ?></td>
                    <td class="examen"><input type="text" value="<?= $examen ?>" disabled></td>                  
                    <td><?= $tot ?></td>                 
                    <td><?= $value['credit'] ?></td>                 
                    <td><?= $tot_p ?></td>
                </tr>               
            <?php
            }
            ?>
              </tbody>
            </table>
          </aside>
          <aside class="right-side">
            <div class="user-head">
              <a href="#" class="chat-tools btn-theme grillePromo"><i class="fa fa-reply"></i> </a>
              <a href="#" class="chat-tools btn-theme03 modCote"><i class="fa fa-key"></i> </a>
            </div>
            <div class="invite-row">
              <h4 class="pull-left"><?= $totObtByStudent['nom']; ?> <?= $totObtByStudent['post_nom']; ?></h4>
              <a href="#" class="btn btn-theme04 pull-right btn-deliberation">DELIBERER</a>
            </div>
            <ul class="chat-available-user">
            <?php 
            if ($infosBulletin['lblSysteme'] == "LMD") {
            ?>
            <li>
              <a href="chat_room.html">
                Maximum
                <span class="text-muted">: <?= $maxOfPromotion['Maximum'] ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Total Obtenu
                <span class="text-muted">:<?= $totObtByStudent['OBT'] ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Pourcentage
                <span class="text-muted">:<?= $pourcentage ?>%</span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Nombre Credits Validés
                <span class="text-muted">: <?= $dataCredits['ncv'] ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Nombre Crédits non Validé
                <span class="text-muted">: <?= $dataCredits['ncnv'] ?></span>
                </a>
            </li>

            <?php 
            } else {
            ?>  
            <li>
              <a href="chat_room.html">
                Maximum
                <span class="text-muted">: <?= $maxOfPromotion['Maximum'] ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Total Obtenu
                <span class="text-muted">:<?= $totObtByStudent['OBT'] ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Pourcentage
                <span class="text-muted">:<?= round($pourcentageA,2) ?>%</span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Echec(s) leger(s)
                <span class="text-muted">: <?= $counterLegers ?></span>
                </a>
            </li>
            <li>
              <a href="chat_room.html">
                Echec(s) grave(s)
                <span class="text-muted">: <?= $counterGraves ?></span>
                </a>
            </li> 
            <li>
              <a href="chat_room.html">
                Manque des cotes
                <span class="text-muted">: <?= $counterManque ?></span>
                </a>
            </li>
            <?php 
            }
            ?>       
            </ul>
          </aside>
        </div>
        <!-- page end-->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main_deliberation.php"; ?>