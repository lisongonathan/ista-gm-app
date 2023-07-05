<?php 
    $page = "Fiches";
?>

<?php ob_start(); ?> 
    <section id="content">
      <section class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading wht-bg">
                <h4 class="gen-case">
                    GRILLE DE DELIBERATION : <?= $niveauOfPromotion['niveau'] ?> - <?=  $niveauOfPromotion['section']; ?>
                  </h4>
              </header>
              <div class="panel-body minimal">
                <div class="table-inbox-wrap ">
                  <table class="table table-inbox table-hover">
                    <tbody>
                      <tr class="unread">
                        <td class="inbox-small-cells" style="border: 1px solid black;">ETUDIANT</td>
                        <?php 
                        foreach ($dataCours as $key => $value) {
                        ?>
                            <td class="view-message  dont-show"  style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;"><?= $value['intitule'] . '<br />Cr : ' . $value['credit']; ?></td>
                        <?php
                        }
                        ?>
                        <td class="inbox-small-cells text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">Maximum</td>
                        <td class="inbox-small-cells text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">Total</td>
                        <td class="inbox-small-cells text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">Pourcentage</td>
                        <td class="view-message  text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">NCV</td>
                        <td class="view-message  text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">NCNV</td>
                        <td class="view-message  text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">Appréciation</td>
                        <td class="view-message  text-right" style="border: 1px solid black;writing-mode: vertical-rl; text-orientation:sideways-right;">Capitatisation</td>
                      </tr>
            <?php
            foreach ($dataStudents as $key => $value) {
                $ncv = 0;
                $ncnv = 0;
                $tp = 0;
                $td = 0;
                $examen = 0;
            ?>
                      <tr class="etudiant-id" data-id="<?= $value['id'] ?>">
                        <td class="view-message  dont-show" style="border: 1px solid black;"><a href="#" class="description"> <?= $value['nom'] . " - " . $value['post_nom'] ?></a></td>
            <?php
            foreach ($dataCours as $k => $v) {
              $data = getCoteEtudiant($value['id'], $v['id']);

                if(isset($data['tp'])){
                    $tp = (int) $data['tp']*$v['credit'];
                }else{
                    $tp = $tp + 0;
                }

                if(isset($data['td'])){
                    $td = (int) $data['td']*$v['credit'];
                }else{
                    $td = $td + 0;
                }

                if(isset($data['examen'])){
                    $examen =(int) $data['examen']*$v['credit'];
                }else{
                    $examen = $examen + 0;
                }

                if(isset($data['tp']) AND isset($data['td']) AND isset($data['examen'])){
                    if($data['tp'] + $data['td'] + $data['examen'] >= 10.0){                    
                        $ncv = $ncv + $v['credit'];
                    }else {
                        $ncnv = $ncnv + $v['credit'];
                    }
            ?>
                        <td class="inbox-small-cells" style="border: 1px solid black;"><?= $tp + $td + $examen; ?></td>
            <?php
                }else{
                    $ncnv = $ncnv + $v['credit'];
            ?>
                        <td class="inbox-small-cells" style="border: 1px solid black;"> - </td>
                        
            <?php
                }
                
                $max[] = 20*$v['credit'];
                $moyTot[] = ($tp+$td+$examen);

            }
            $den = array_sum($max);
            $num = getByObtEtudiant($value['id']);
            $pourcentage = ($num['OBT']/$den)*100;
            if ($pourcentage >=50.0) {
                if ($pourcentage >= 60.0) {
                    if ($pourcentage >= 70.0) {
                        if ($pourcentage >= 80.0) {
                            if ($pourcentage >= 90.0) {
                                $ap = "A";
                            } else {
                                $ap = "B";
                            }
                            
                        } else {
                            $ap = "C";
                        }
                        
                    } else {
                        $ap = "D";
                    }
                    
                } else {
                    $ap = "E";
                }
                
            } else {
                $ap = "X";
            }
            if ($ncnv) {
                $cap = "DETTES";
            } else {
                $cap = "CAP";
            }
            ?>
                        <td class="inbox-small-cells"><?= $den; ?></td>
                        <td class="inbox-small-cells"><?= $num['OBT']; ?></td>
                        <td class="inbox-small-cells"><?= round($pourcentage, 2) . "%"; ?></td>
                        <td class="inbox-small-cells"><?= $ncv; ?></td>
                        <td class="inbox-small-cells"><?= $ncnv; ?></td>
                        <td class="inbox-small-cells"><?= $ap; ?></td>
                        <td class="inbox-small-cells"><?= $cap; ?></td>
                      </tr>
            <?php 
            $max = array();
            $moyTot = array();
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