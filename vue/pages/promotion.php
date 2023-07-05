<?php 
    $page = "Promotion";
?>

<?php ob_start(); ?> 
<section id="main-content">
    <section class="wrapper">
        <!-- /row - SECOND ROW OF PANELS -->
        <div class="row mt">
          <!-- /col-lg-12 -->
          <div class="col-lg-12 mt">
            <div class="row content-panel">
              <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">
                  <li class="active">
                    <a data-toggle="tab" href="#overview">Unités Enseignements</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#contact" class="contact-map">Enseignants</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#edit">Cours</a>
                  </li>
                </ul>
              </div>
              <!-- /panel-heading -->
              <div class="panel-body">
                <div class="tab-content">
                  <div id="overview" class="tab-pane active">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked mail-nav list-ues">
                                    <li class="active"><a href="#"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-info pull-right inbox-notification">Modifier</span></a></a>
                                    </li>
                                </ul>
                            </div>
                            <button class="btn btn-compose addUnite-Ens">Ajouter une Unité d'enseignement</button>
                        </div>
                      <!-- /col-md-6 -->
                        <div class="col-md-6 detailed">
                            <div class="row centered mt mb ue-item">
                                <div class="col-lg-12 ">
                                    <div class="activity-panel">
                                        <h4 class="nom-ue">Nom UE</h4>
                                        <div class="col-sm-4">
                                            <h1><i class="fa fa-barcode"></i></h1>
                                            <h3 class="code-ue">XXXX</h3>
                                            <h6>CODE UE</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <h1><i class="fa fa-trophy"></i></h1>
                                            <h3 class="credits-ue">37</h3>
                                            <h6>CREDITS</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <h1><i class="fa fa-group"></i></h1>
                                            <h3 class="ec-ue">1980</h3>
                                            <h6>ELEMENTS CONSTITUTIFS</h6>
                                        </div>
                                        <h5></h5>
                                        <p class="list-ue">...ISTA/GM...</p>
                                    </div>
                                </div>
                            </div>
                        <!-- /row -->
                            <br />
                            <form role="form" class="form-horizontal" id='addUE-form'>
                                <h4>Ajouter une unité d'enseignement</h4>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Designation</label>
                                    <div class="col-lg-10">
                                    <input type="text" placeholder=" " id="ue-designation" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Code</label>
                                    <div class="col-lg-10">
                                    <input type="text" placeholder=" " id="ue-code" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="submit" value="Ajouter" class="btn btn-compose">
                                    </div>
                                </div>
                            </form>
                      </div>
                      <!-- /col-md-6 -->
                    </div>
                    <!-- /OVERVIEW -->
                  </div>
                  <!-- /tab-pane -->
                  <div id="contact" class="tab-pane">
                    <div class="row">                 
                        <div class="col-md-12 detailed">      
                            <table class="table table-striped table-advance table-hover data-enseignants">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-bolt"></i> Matricule</th>
                                        <th><i class="fa fa-user"></i> Prenom</th>
                                        <th><i class="fa fa-user"></i> Nom</th>
                                        <th><i class="fa fa-user"></i> Post-nom</th>
                                        <th class="hidden-phone"><i class="fa fa-info"></i> Grade</th>
                                        <th><i class=" fa fa-edit"></i> Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="list-enseignant">
                                </tbody>
                            </table>
                            <!-- /content-panel -->
                            <form role="form" class="form-horizontal control-enseignant">
                                <h4 class="mb">Affectation Charge Horaire</h4> 
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Titulaire</label>
                                    <div class="col-lg-6">
                                    <select class="form-control id_titulaire">
                                        <?php foreach ($dataEnseignant as $key => $value) {
                                            if (!$value['matricule']) {
                                                $matricule = "A compléter";
                                            }else{
                                                $matricule = $value['matricule'];
                                            }

                                        ?>
                                        
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['grade'] . ' - ' . $value['nom'] . " " . $value['post_nom'] . " (". $matricule .")"; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Matières</label>
                                    <div class="col-lg-6">
                                    <select class="form-control id_unite">
                                        <?php foreach ($dataEC as $key => $value) {?>
                                        
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['intitule'] . ' - ' . $value['code']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="submit" value="Ajouter" class="btn btn-compose">
                                    </div>
                                </div>
                            </form>
                            <br />
                        </div>
                        <!-- /col-md-12 -->
                    </div>
                    <!-- /row -->
                    <a href="#" class="btn btn-compose bouton-ajout-enseignant">
                        <i class="fa fa-plus"></i> <strong>Enseignant</strong>
                    </a>
                  </div>
                  <!-- /tab-pane -->
                  <div id="edit" class="tab-pane">
                    <div class="row">                 
                        <div class="col-md-12 detailed">     
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-bullhorn"></i> Intitule</th>
                                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Credit</th>
                                    <th class="hidden-phone"><i class="fa fa-question-circle"></i> Code</th>
                                    <th><i class="fa fa-bookmark"></i> Unité</th>
                                    <th><i class=" fa fa-edit"></i> Semestre</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($dataEC as $key => $value) {
                                ?>
                                    <tr>
                                        <td>
                                        <a href="#"><?= $value['intitule'] ?></a>
                                        </td>
                                        <td class="hidden-phone"><?= $value['credit'] ?></td>
                                        <td><?= $value['code'] ?> </td>
                                        <td><span class="label label-info label-mini"><?= $value['designation'] ?></span></td>
                                        <td><span class="label label-info label-mini"><?= $value['semestre'] ?></span></td>
                                        <td>
                                        <button class="btn btn-danger btn-xs delete-matiere" data-id="<?= $value['id']; ?>"><i class="fa fa-trash-o "></i></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <!-- /content-panel -->
                            <form role="form" class="form-horizontal form-add-ec" action="" method="POST">
                                <h4><?= $msg; ?></h4>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Intitulé</label>
                                    <div class="col-lg-6">
                                    <input type="text" placeholder="Intitule du cours" name="cours-intitule" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Code</label>
                                    <div class="col-lg-6">
                                    <input type="text" placeholder="Code du cours" name="cours-code" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Credit</label>
                                    <div class="col-lg-6">
                                    <input type="text" placeholder="Pondération(Ancien système)" name="cours-credit" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Semestre</label>
                                    <div class="col-lg-6">
                                    <select class="form-control" name="cours-semestre">
                                        <option value="1">Premier</option>
                                        <option value="2">Second</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Unité d'Enseignements</label>
                                    <div class="col-lg-6">
                                    <select class="form-control" name="cours-unite">
                                        <?php 
                                        foreach ($dataUE as $key => $value) {
                                        ?>
                                        <option value="<?= $value['id']; ?>"><?= $value['designation']; ?>(<?= $value['code']; ?>)</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Verifier les Informations</label>
                                    <div class="col-lg-6">
                                    <input type="submit" value="Valider" name="addCours" class="form-control btn btn-danger">
                                    </div>
                                </div>
                            </form>
                            <br />
                        </div>
                        <!-- /col-md-12 -->
                    </div>
                    <!-- /row -->
                    <a href="#" class="btn btn-compose addEC">
                        <i class="fa fa-pencil"></i>  Ajouter un nouveau cours
                    </a>
                  </div>
                  <!-- /tab-pane -->
                </div>
                <!-- /tab-content -->
              </div>
              <!-- /panel-body -->
            </div>
            <!-- /col-lg-12 -->
          </div>
          <!-- /row -->
        </div>
    </section>
    <!-- /wrapper -->
</section>
?>
<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/main.php"; ?>