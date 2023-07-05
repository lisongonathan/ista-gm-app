<?php 
    $page = "ACADEMIQUE";
    ob_start();
?>

    <form class="form-login" action="">
        <h2 class="form-login-heading">ACADEMIQUE-AUTORISATION</h2>
        <div class="login-wrap">
          <br>
          <select class="form-control action">
            <option value="true">BLOQUER</option>
            <option value="false">DEBLOQUER</option>
          </select>
          <br>
          <select class="form-control departement">
            <option value="TITULAIRE">TITULAIRE</option>
            <option value="JURY">JURY</option>
          </select>
          <br>
          <label class="checkbox">
            <span class="pull-right">
            <a data-toggle="modal" href="index.php?deconnexion"> Se deconnecter</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block validation" type="submit"><i class="fa fa-lock"></i> VALIDER</button>
          <hr>
          <div class="login-social-link centered">
            <p>GESTION AUTHORISATION</p>
            <button class="btn btn-facebook statut-tit" type="submit"><i class="fa fa-book"></i> TITULAIRE</button>
            <button class="btn btn-twitter statut-jury" type="submit"><i class="fa fa-bullhorn"></i> DELIBERATION</button>
          </div>
          <div class="etat-autorisation">
            Don't have an account yet?<br/>
            <a class="" href="#">
              Create an account
              </a>
          </div>
          <div class="btn-group">
              <button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
                  VOIR LES CODES D'ACCESS <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                  <li><a href="index.php?enseignants">Enseignant</a></li>
                  <li class="divider"></li>
              <?php
              foreach ($itemsPromotions as $key => $value) {
              ?>
                  <li><a href="index.php?etudiants=<?= $value['id']; ?>"><?= $value['intitule'] . ' - ' . $value['designation']; ?></a></li>

              <?php
              }
              ?>
              </ul>
          </div>
          <div class="login-social-link centered">
            <p>REINITIALISER LES CODES D'ACCESS</p>
            <a class="btn btn-facebook reset-titulaires" href="index.php?resetEnseignants"><i class="fa fa-user"></i> ENSEIGNANTS</a>
            <a class="btn btn-twitter reset-etudiants" href="index.php?resetEtudiants"><i class="fa fa-user"></i> ETUDIANTS</a> 
          </div>
        </div>
      </form>


<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/auth.php"; ?>