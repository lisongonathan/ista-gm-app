<?php 
    $page = "Fiches";
?>

<?php ob_start(); ?> 
    <section id="content">
      <section class="row">
          <div class="col-lg-12">
            <section class="panel" style="position:sticky; top:0px">
              <div class="panel-body minimal">
                <div class="mail-option">          
                  <header class="panel-heading wht-bg ">
                    <h4 class="gen-case fiche-cotation-msg">
                      FICHE DE COTATION : <?= $matiere['intitule']; ?> (<?= $infoPromotion['niveau'] ?> - <?=  $infoPromotion['section']; ?>)
                    </h4>
                  </header>
                  <div class="progress chargementDonnees">
                  </div>
                  <div class="btn-group hidden-phone">
                    <a data-toggle="dropdown" href="#" class="btn mini blue">
                      
                      <i class="fa fa-bookmark "></i> Détails cours
                      <i class="fa fa-angle-down "></i>
                      </a>
                    <ul class="dropdown-menu">
                      <li><a href="#"><i class="fa fa-sitemap"></i> UE : <?= $matiere['designation'] ?></a></li>
                      <li><a href="#"><i class="fa fa-superscript"></i> Credit :  <?= $matiere['credit'] ?></a></li>
                      <li><a href="#"><i class="fa fa-calendar"></i> Semestre : <?= $matiere['semestre'] ?></a></li>
                      <li><a href="#"><i class="fa fa-bar-chart-o"></i> Maximum : <?= $matiere['maximum'] ?></a></li>
                      <li class="divider"></li>
                      <li><a class="retour-dash" href="#"><i class="fa fa-reply"></i> Quitter</a></li>
                    </ul>
                  </div>
                  <div class="btn-group">
                    <a data-original-title="Débloquer" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips unlock-exam">
                      <i class=" fa fa-key"></i>
                      </a>
                  </div>
                  <ul class="unstyled inbox-pagination">
                    <div class="btn-group">
                      <a data-original-title="Enregistre" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips valid-cote">
                        <i class=" fa fa-check"></i> Enregistrer les cotes</a>
                    </div>
                  </ul>
                  <table class="table table-inbox table-hover">
                    <tbody>
                      <tr class="unread">
                        <td class="inbox-small-cells">Matriclue</td>
                        <td class="view-message  dont-show">Nom Post-Nom</td>
                        <td class="inbox-small-cells">M-TP/5</td>
                        <td class="inbox-small-cells">M-TD/5</td>
                        <td class="inbox-small-cells">E/10</td>
                        <td class="view-message  text-right">TOT1/20</td>
                        <td class="view-message  text-right">TOT1P</td>
                        <td class="view-message  text-right">RAT-E/10</td>
                        <td class="view-message  text-right">TOT2/20</td>
                        <td class="view-message  text-right">TOT2P</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
            <section class="panel">
              <div class="panel-body minimal">
                <div class="table-inbox-wrap ">
                  <table class="table table-inbox table-hover">
                    <tbody class="ficheCotationList">
                      <?php
                      foreach ($dataStudents as $key => $value) {
                      ?>
                      <tr class="etudiant-id" data-id="<?= $value['id'] ?>">
                        <td class="inbox-small-cells numMatricule"><?= $value['matricule'] ?></td>
                        <td class="view-message  dont-show"><a href="#" class="description"> <?= $value['nom'] . " - " . $value['post_nom'] ?></a></td>
                        <?php
                          $data = getCoteEtudiant($value['id'], (int) $_GET['matiere']);

                            if(isset($data['tp'])){
                        ?>
                        <td class="inbox-small-cells"><?= $data['tp'] ?>
                        </td>
                        <?php
                            }else{
                        ?>
                        <td class="inbox-small-cells">
                          <input type="text" class="form-control m-tp">
                        </td>
                        <?php
                            }

                            if(isset($data['td'])){
                        ?>
                        <td class="inbox-small-cells"><?= $data['td'] ?>
                        </td>
                        <?php
                            }else{
                        ?>
                        <td class="inbox-small-cells">
                          <input type="text" class="form-control m-td">
                        </td>
                        <?php
                            }

                            if(isset($data['examen'])){
                        ?>
                        <td class="inbox-small-cells"><?= $data['examen'] ?>
                        </td>
                        <?php
                            }else{
                        ?>
                        <td class="inbox-small-cells">
                          <input type="text" class="form-control cote-examen" disabled>
                        </td>
                        <?php
                            }

                            if(isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])){
                        ?>
                        <td class="inbox-small-cells"><?= $data['tp'] + $data['td'] + $data['examen'] ?></td>
                        <td class="inbox-small-cells"><?= ($data['tp'] + $data['td'] + $data['examen'])*$matiere['credit'] ?></td>
                        <?php
                            }else{
                        ?>
                        <td class="inbox-small-cells"> - </td>
                        <td class="inbox-small-cells"> - </td>
                        
                      <?php
                          }

                          if(isset($data['r_examen'])){
                      ?>
                        <td class="inbox-small-cells"><?= $data['r_examen'] ?>
                        </td>
            <?php
                }else{
            ?>
                        <td class="inbox-small-cells">
                          <input type="text" class="form-control rat-e" disabled>
                        </td>
            <?php
                }

                if(isset($data['tp']) AND isset($data['td']) AND isset($data['r_examen'])){
            ?>
                        <td class="inbox-small-cells"><?= $data['tp'] + $data['td'] + $data['r_examen'] ?></td>
                        <td class="inbox-small-cells"><?= ($data['tp'] + $data['td'] + $data['r_examen'])*$matiere['credit'] ?></td>
            <?php
                }else{
            ?>
                        <td class="inbox-small-cells"> - </td>
                        <td class="inbox-small-cells"> - </td>
                        
            <?php
                }

            ?>
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
      </section>
      <!-- /wrapper -->
    </section>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main_access.php"; ?>