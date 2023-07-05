<?php 
    $page = "Grilles"
?>

<?php ob_start(); ?> 

    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-9 main-chart">
                <!--CUSTOM CHART START -->
                    <div class="border-head">
                        <h3>STATISTIQUE ANNUEL</h3>
                    </div>
                    <div class="custom-bar-chart">
                        <ul class="y-axis">
                        <?php
                        foreach ($participants as $value) {
                        ?>
                            
                            <li><span><?= $value ?></span></li>
                        <?php
                        }

                        ?>      
                        </ul>
                        <div class="bar">
                            <div class="title">A</div>
                            <div class="value tooltips" data-original-title="<?= round($apA/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apA*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">B</div>
                            <div class="value tooltips" data-original-title="<?= round($apB/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apB*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">C</div>
                            <div class="value tooltips" data-original-title="<?= round($apC/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apC*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">D</div>
                            <div class="value tooltips" data-original-title="<?= round($apD/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apD*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">E</div>
                            <div class="value tooltips" data-original-title="<?= round($apE/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apE*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">X</div>
                            <div class="value tooltips" data-original-title="<?= round($apX/$effectifOfPromo['participant'],2); ?>" data-toggle="tooltip" data-placement="top"><?= round($apX*100/$effectifOfPromo['participant'],2); ?>%</div>
                        </div>
                    </div>
                </div>
                <!-- /col-lg-9 END SECTION MIDDLE -->
                <!-- **********************************************************************************************************************************************************
                    RIGHT SIDEBAR CONTENT
                    *********************************************************************************************************************************************************** -->
                <div class="col-lg-3 ds">
                <!--COMPLETED ACTIONS DONUTS CHART-->
                <div class="donut-main">
                    <h4><?= $niveauOfPromotion['niveau'] . " / " . $niveauOfPromotion['section']; ?></h4>
                    <button class="btn btn-theme showGrille">Voir la grille</button>
                </div>
                <!-- USERS ONLINE SECTION -->
                <h4 class="centered mt">Palmares</h4>
                <!-- First Member -->
                    <?php 
                    foreach ($dataPalmaress as $key => $value) {
                    ?>
                <div class="desc">
                    <div class="thumb">
                        <img class="img-circle" src="vue/gabarit/assets/img/ui-student.png" width="35px" height="35px" align="">
                    </div>
                    <div class="details">
                        <p>
                            <a href="?grille=<?= $_GET['grille']; ?>&deliberation=<?= $value['id'] ?>"><?= $value['nom']; ?> <?= $value['post_nom']; ?></a><br/>
                            <muted><?= $value['pourcentage']; ?>%</muted>
                        </p>
                    </div>
                </div>
                <!-- Second Member -->
                    <?php
                    }
                    ?>
            </div>
            <!-- /row -->
        </section>
    </section>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main_grille.php"; ?>